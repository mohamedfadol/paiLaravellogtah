<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Minutes;
use Illuminate\Http\Request;
use App\Models\Meeting;
use App\Models\AgendaDetails;
use App\Models\Agenda;
use App\Models\Board; 
use App\Models\MinuteSignature;
use Carbon\Carbon;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator; 
use Illuminate\Support\Facades\DB;
use App\Enums\MinutesStatusEnum;
use Illuminate\Validation\Rules\Enum;
use App\Models\ActionTracker;
use Illuminate\Support\Str;
use App\Enums;

class MinutesController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getListOfMinutes(Request $request)
    {
        // \Log::info("coming requist minutes");
        $currentYear = Carbon::now()->format('Y'); 
        $year = $request->dateYearRequest ?? $currentYear;
        // \Log::info($year);
        $minutes = Minutes::where('business_id',$request->business_id)->with(['business','user','attendance_boards',
            'meeting'=> function($q){ return $q->with(['agendas'=>function($q){ return $q->with(['agenda_details'=> function($q){return $q->with('agenda');}]);},
                                    'committee'=> function($q){ 
                                    return $q->with([
                                    'board' => function($q){ return $q->with('business');},
                                    'members' => function($e){return $e->with('position');}
                                ]);},
                                'board'=> function($q){ return $q->with('business');}]);},
            'committee'=> function($q){ 
                return $q->with([
                                    'board' => function($q){ return $q->with('business');},
                                    'members' => function($e){return $e->with('position');}
                                ]);},
            'board' => function($q){ return $q->with(['business','members' => function($e){return $e->with(['position',
            'minute_signature'=> function($e){return $e->with(['member' => function($e){return $e->with(['position','minute_signature'=> function($e){return $e->with(['member' => function($q){return $q->with('position');}]);}]);}]);},
            'signature_member'=> function($e){return $e->with(['member' => function($e){return $e->with(['position','minute_signature']);}]);},]);}]);}
            ])->where(function($q) use($year){
                $q->where(DB::raw('YEAR(created_at)'), $year)->orWhere(DB::raw('YEAR(created_at)'), Carbon::now()->format('Y'));
            })->get();

        if (!$minutes) {
            return $this->error('', 'there\'s not minutes found', 401);
        }

        return $this->success([
            'minutes' => $minutes,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function inserNewMinute(Request $request)
    {
        //  \Log::info($request->all());
        try{
                $validator = Validator::make($request->all(), [
                    // 'minute_name' => 'required|string',
                    // 'minute_date' => 'required|string',
                    'meeting_id' => 'required',
                    // 'minute_decision' => 'required',
                    'business_id' => 'required',
                    'add_by' => 'required',
                    // 'board_id' => 'required',
                ]); 
        
                if ($validator->fails()) {
                    return  $this->error('', $validator->errors(), 401);
                }
                
                $meeting = Meeting::findOrFail($request->meeting_id)->load('board');
                // $board = Board::findOrFail($request->board_id);
                $currentYear = Carbon::now()->format('Y');
                $genarate_numbers = $meeting->id.'-'.$currentYear;
                
                // use meeting  date if meeting request exist instead of request date
                $date = Carbon::parse($request->minute_date);
                
                if(!empty($request->meeting_id)){
                    $date = $meeting->meeting_start;
                }
                $minute_name = $meeting->meeting_title;
                $meeting_description = $meeting->meeting_description;
                $minute_name = $meeting->meeting_title;
                
                $minute = Minutes::create([
                        "minute_name" => $minute_name,
                        'minute_numbers' => $genarate_numbers,
                        'minute_date' => $date,
                        "committee_id" => $request->committee_id ?? null,
                        "minute_decision" => $request->minute_decision ?? $meeting_description,
                        "board_id" => $meeting->board->id ?? null,
                        "meeting_id" => $request->meeting_id ?? null,
                        "minute_status" => $request->minute_status ?? "NOTSIGNED",
                        "add_by" => $request->add_by,
                        "business_id" => $request->business_id,
                    ]);
                    
                if($request->listOfAgendaDetails && is_array($request->listOfAgendaDetails) && count($request->listOfAgendaDetails) > 0){
                    
                    for($i = 0; $i < count($request->listOfAgendaDetails); $i++){
                        $details = AgendaDetails::updateOrCreate(
                                       ['agenda_id' => $request->listOfAgendaDetails[$i]['agenda_id'] ],
                                        [
                                        "missions" => $request->listOfAgendaDetails[$i]['missions'] ,
                                        "tasks" => $request->listOfAgendaDetails[$i]['tasks'] ,
                                        "reservations" => $request->listOfAgendaDetails[$i]['reservations'] 
                                        ]
                                    );
                        $actions = ActionTracker::create([
                                        'tasks' => $request->listOfAgendaDetails[$i]['tasks'],
                                        'date_assigned' => now(),
                                        'meeting_id' => $request->meeting_id ?? null,
                                        'agenda_detail_id' => $details->id,
                                        ]);           
                                    
                    }
                    
                }
                
                if($request->attendance && is_array($request->attendance) && count($request->attendance) > 0){
                    for($i = 0; $i < count($request->attendance); $i++){
                        $minute->attendance_boards()->create([
                                                         'attended_name' => $request->attendance[$i]['attended_name'],
                                                         'position' => $request->attendance[$i]['position'],
                                                     ]);
                                                     
                    }
                }
                 
                // \Log::info("minute inserted done");
            return $this->success([
                'minute' => $minute->load('meeting','user','attendance_boards'),
            ]);
           }catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            return $this->error('', 'some thing occurs on create meeting !!!', 500);
        }
    }

    /**
     * Show the form for creating a new sign  resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function memberMakeSignMinute(Request $request)
    {
        try{
        $signature = MinuteSignature::where('member_id',$request->member_id)->where('minute_id',$request->minute_id)->where('has_signed',true)->get();
        if(count($signature)> 0){
            \Log::info("you have signed already");
         return   $this->error('', 'you have signed already !!!', 400);
        }else{
            $signature = MinuteSignature::create([
                    'member_id' => $request->member_id,
                    'minute_id' => $request->minute_id,
                    'has_signed' => true,
                ]);
            $minute = Minutes::findOrFail($request->minute_id);
            return $this->success([
                'minute' => $minute,
            ]);
        }
        
        }catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            return $this->error('', 'some thing occurs on create signed !!!', 500);
        }
        
    }
    
    /**
     * update a existing created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateMinute(Request $request)
    {
        //  \Log::info($request->all());
        try{
                $validator = Validator::make($request->all(), [
                    // 'minute_name' => 'required|string',
                    // 'minute_date' => 'required|string',
                    'minute_id' => 'required',
                    // 'minute_decision' => 'required',
                    // 'business_id' => 'required',
                    // 'add_by' => 'required',
                    // 'board_id' => 'required',
                ]);
        
                if ($validator->fails()) {return  $this->error('', $validator->errors(), 401);}
                
                $minute = Minutes::findOrFail($request->minute_id);
                if(empty($minute)){ return $this->error('', 'some thing occurs on update minute !!!', 401); }
                    
                if($request->listOfAgendaDetails && is_array($request->listOfAgendaDetails) && count($request->listOfAgendaDetails) > 0){
                    for($i = 0; $i < count($request->listOfAgendaDetails); $i++){
                        $details =  AgendaDetails::updateOrCreate(
                                       ['agenda_id' => $request->listOfAgendaDetails[$i]['agenda_id'] ],
                                        [
                                        "missions" => $request->listOfAgendaDetails[$i]['missions'] ,
                                        "tasks" => $request->listOfAgendaDetails[$i]['tasks'] ,
                                        "reservations" => $request->listOfAgendaDetails[$i]['reservations'] 
                                        ]
                                    );
                        $actions = ActionTracker::create([
                                        'tasks' => $request->listOfAgendaDetails[$i]['tasks'],
                                        'date_assigned' => now(),
                                        'meeting_id' => $request->meeting_id ?? null,
                                        'agenda_detail_id' => $details->id,
                                        ]); 
                    }
                    
                }
                
                if($request->attendance && is_array($request->attendance) && count($request->attendance) > 0){
                    for($i = 0; $i < count($request->attendance); $i++){
                        $minute->attendance_boards()->create([
                                                         'attended_name' => $request->attendance[$i]['attended_name'],
                                                         'position' => $request->attendance[$i]['position'],
                                                     ]);
                    }
                }
                 
                // \Log::info("minute updated done");
                return $this->success([
                    'minute' => $minute,
                ]);
           }catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            return $this->error('', 'some thing occurs on update minute !!!', 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Minutes  $minutes
     * @return \Illuminate\Http\Response
     */
    public function deleteMinute(Request $request)
    {
        //  \Log::info($request->all());
        try{
                $validator = Validator::make($request->all(), ['minute_id' => 'required']);
        
                if ($validator->fails()) {return  $this->error('', $validator->errors(), 401);}
                
                $minute = Minutes::findOrFail($request->minute_id);
                if(empty($minute)){ return $this->error('', 'some thing occurs on delete minute !!!', 401); }
                $agendasIds = $minute->meeting->agendas()->get()->pluck('id')->toArray();
                AgendaDetails::whereIn('agenda_id' ,$agendasIds)->delete();
                $minute->delete();
                 
                // \Log::info("minute delete done");
                return $this->success([
                    'minute' => null,
                ]);
           }catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            return $this->error('', 'some thing occurs on delete minute !!!', 500);
        }
    }
}
