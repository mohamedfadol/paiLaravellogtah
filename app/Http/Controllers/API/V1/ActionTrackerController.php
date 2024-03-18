<?php

namespace App\Http\Controllers\API\V1;

use DB;
use Carbon\Carbon;
use App\Models\Note;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\ActionTracker;
use App\Traits\HttpResponses;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Services\FirebaseNotificationService;

class ActionTrackerController extends Controller
{
    use HttpResponses;
    
    //  FirebaseNotificationService $firebaseNotificationService;
 
    public function __construct(private FirebaseNotificationService $firebaseNotificationService)
    {
        $this->firebaseNotificationService = $firebaseNotificationService;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getListOfActionTrackers(Request $request)
    {
        try{
            \Log::info("coming requist actions trackers");
            $currentYear = Carbon::now()->format('Y');
            $year = $request->dateYearRequest ?? $currentYear;
            \Log::info($year);
            $actionstrackers = ActionTracker::with([
                                                    'business',
                                                    'meeting' => function($q){ 
                                                        $q->with('agendas');
                                                    },
                                                    'details' => function($q){ 
                                                        return $q->with('agenda');
                                                    },
                                                    'member'=> function($e){
                                                        return $e->with('position');
                                                    }
                                                    ]
                                )
                                ->whereYear('created_at', $year)->get();

            if (!$actionstrackers) {
                return $this->error('', 'there\'s not actions trackers found ', 401);
            }

            return $this->success([
                'actions' => $actionstrackers,
            ]);
        
        }catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            return $this->error('', 'some thing occurs on get list of actions trackers !!!', 500);
        }
    }

        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getListOfActionTrackersWhereLike(Request $request)
    {
        try{
        $actionstrackers = ActionTracker::where('business_id', $request->business_id)
                            ->with([
                                'member' => function ($e) use ($request) {
                                    $e->with([
                                        'position' => function ($query) use ($request) {
                                            $query->where('position_name', 'LIKE', '%' . $request->position_name . '%');
                                        }
                                    ]);
                                },
                                'business',
                                'meeting'=> function($q){ 
                                     $q->with('agendas');
                                },
                                'details' => function ($q) {
                                    $q->with('agenda');
                                }
                            ])
                            ->when(
                                $request->action_status, function ($query) use ($request){
                                    $query->where('action_status', 'LIKE', '%' . $request->action_status . '%');
                                }
                                )
                            ->when(
                                $request->position_name, function ($query) use ($request){
                                    $query-> whereHas('member.position', function ($query) use ($request) {
                                        $query->where('position_name', 'LIKE', '%' . $request->position_name . '%');
                                    });
                                }
                            )
                            ->get();

        if (!$actionstrackers) {
            return $this->error('', 'there\'s not actions trackers found ', 401);
        }

        return $this->success([
            'actions' => $actionstrackers,
        ]);
        
        }catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            return $this->error('', 'some thing occurs on get list of actions trackers !!!', 500);
        }
    }




    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function editActionsTracker(Request $request)
    {
        try{
                $validator = Validator::make($request->all(), [
                    'date_due'    => 'required|string',
                    'member_id'   => 'required|integer',
                    'action_id'   => 'required|integer',
                    'business_id' => 'required|integer',
                ]);
        
                if ($validator->fails()) {
                    return  $this->error('', $validator->errors(), 401);
                }
                $data = array(); 
                $action = ActionTracker::findOrFail($request->action_id);
                $action->update([
                    'date_due' => $request->date_due,
                    'note' => $request->note,
                    'member_id' => $request->member_id,
                    'meeting_id' => $action->meeting_id,
                    'action_status' => $request->action_status,
                    'business_id' => $request->business_id,
                ]);

                if(!empty($request->note)){
                    $note = Note::create([
                        'note' => $request->note,
                        'member_id' => $request->member_id,
                        'action_id' => $action->id,
                    ]);
                }
                 
                $data['token'] = 'eMj3RP7WQhuX6earr9vSiB:APA91bEMLhwPlwOADPmwX8HZcJSDomPV0Wc5QSFw3Ivx2-ralhZvKVSOvMiZ7nK4_I_V2YQ98-gtTSElJ4K2ukeyYpl_6qiA_z3SbXRLlhefPeYQ-hDJ-WO5cRHG69sApa-EpKHZhEqV';
                $data['body'] = $action->date_due;
                $data['title'] = $action->tasks;
                $this->firebaseNotificationService->sendFirebaseNotification($data);
                Notification::create([
                    'notification_title' => $action->tasks,
                    'notification_body' => $action->date_due,
                    'notification_token' => $data['token'],
                    'member_id' => $request->member_id,
                    'user_id' => 1,
                    'action_id' => $action->id,
                    'business_id' => $request->business_id
                ]);
                // \Log::info("action inserted done");
                $action = $action->load(['business','meeting','details' => function($q){ return $q->with('agenda');},'member'=> function($e){return $e->with('position');}]);
                return $this->success(['action' => $action]);
        }catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            return $this->error('', 'some thing occurs on edit actions trackers !!!', 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ActionTracker  $actionTracker
     * @return \Illuminate\Http\Response
     */
    public function show(ActionTracker $actionTracker)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ActionTracker  $actionTracker
     * @return \Illuminate\Http\Response
     */
    public function edit(ActionTracker $actionTracker)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ActionTracker  $actionTracker
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ActionTracker $actionTracker)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ActionTracker  $actionTracker
     * @return \Illuminate\Http\Response
     */
    public function destroy(ActionTracker $actionTracker)
    {
        //
    }
}
