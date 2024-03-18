<?php

namespace App\Http\Controllers\API\V1;

use Carbon\Carbon;
use App\Models\Note;
use App\Models\Board;
use App\Models\Meeting;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class NotificationController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getListOfNotification(Request $request)
    {
        try{
            \Log::info("comeing request notes");
            $currentYear = Carbon::now()->format('Y');
            $year = $request->dateYearRequest ?? $currentYear;
            \Log::info($year);
            $notifications =  Notification::get();
            if (!$notifications) { return $this->error('', 'there\'s not notes for notifications found ', 401); }
            return $this->success([
                'notifications' => $notifications,
            ]);
        
        }catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            return $this->error('', 'some thing occurs on get list of notes for notifications !!!', 500);
        }
    }


        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getListOfCommitteeNotes(Request $request)
    {
        try{
            \Log::info("comeing request notes");
            $currentYear = Carbon::now()->format('Y');
            $year = $request->dateYearRequest ?? $currentYear;
            \Log::info($year);
            $committees =  Committee::with([
                                    'meetings' => function ($q) {
                                            $q->with('agendas')
                                            ->whereHas('agendas');
                                    },
                                    'business',
                                    'members' => function($e){
                                        return $e->with('position');
                                    }
                                    ]
                                    
                                    ) ->whereHas('meetings.agendas')
                            ->whereYear('created_at', $year)
                        ->get();
            if (!$committees) { return $this->error('', 'there\'s not notes for committees found ', 401); }
            return $this->success([
                'committees' => $committees,
            ]);
        
        }catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            return $this->error('', 'some thing occurs on get list of notes for committees !!!', 500);
        }
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function insertNewNote(Request $request)
    {
        \Log::info($request->all());
        try{
                $validator = Validator::make($request->all(),
                                        [
                                        // '*.ListDataOfNotes.*.criteria_category' => 'required',
                                            // "member_id" => 'required',
                                            "businessId" => 'required',
                                        ]);
        
                if ($validator->fails()) {
                    return  $this->error('', $validator->errors(), 401);
                }
                
                // $signatureName = 'member_signature_'.time().'_.png';
                // $signatureSelf = base64_decode($request->uploadSignature);
                // Storage::disk('signatures_uploads')->put($signatureName, $signatureSelf);
                
                // $file = $request->member_profile_image;
                // $imageName = time() . '.' . $file;
                // $imageSelf = base64_decode($request->imageSelf);
                // Storage::disk('public_uploads')->put($request->business_id . '/' . $imageName, $imageSelf);
                
                if($request->ListDataOfNotes && is_array($request->ListDataOfNotes) && count($request->ListDataOfNotes) > 0){
                    for($i = 0; $i < count($request->ListDataOfNotes); $i++){
                        $note = new Note;
                        $note->note = $request->ListDataOfNotes[$i]['text'];
                        $note->annotation_id = $request->ListDataOfNotes[$i]['id'];
                        $note->positionDx = $request->ListDataOfNotes[$i]['positionDx'];
                        $note->positionDy = $request->ListDataOfNotes[$i]['positionDy'];
                        $note->page_index = $request->ListDataOfNotes[$i]['pageIndex'];
                        // $note->member_id = $request->ListDataOfNotes[$i]['memberId'];
                        $note->business_id = $request->businessId;
                        $note->file_edited = $request->fileEdited;
                        $note->save();
                    }
                }
                // $note = Note::create([
                //                 "note" =>  $request->text,
                //                 "annotation_id" => $request->id,
                //                 'position' => $request->position,
                //                 "page_index" =>  $request->pageIndex,
                //                 "file_edited" =>  $request->fileEdited,
                //                 "member_id" =>  $request->memberId,
                //                 "business_id" =>  $request->businessId,
                //             ]);
               
      
                
                \Log::info($note->load('member'));
                return $this->success([
                    'note' => $note->load('member'),
                ]);
        }catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            return $this->error('', 'some thing occurs on create note !!!', 500);
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
