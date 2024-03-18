<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Meeting;
use App\Models\Agenda;
use Carbon\Carbon;
use App\Models\Board;
use App\Models\Committee;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Enums\MeetingStatusEnum;
use Illuminate\Validation\Rules\Enum;
use App\Enums;
class MeetingController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the Meetings resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getListOfMeetings(Request $request)
    {
        \Log::info("coming Request Meetings");
        // $meetings = Meeting::where('meeting_status',MeetingStatusEnum::QOURMREACHED)->get();
        // $meetings = Meeting::where('meeting_status',MeetingStatusEnum::SIGNED)->get();
        // $meetings = Meeting::where('meeting_status',MeetingStatusEnum::NOTSIGNED)->get();
        // $meetings = Meeting::where('meeting_status',MeetingStatusEnum::PARTIAL)->get();
        $meetings = Meeting::where('business_id',$request->business_id)->get();

        if (!$meetings) {
            return $this->error('', 'there\'s not meetings found ', 401);
        }

        return $this->success([
            'meetings' => $meetings,
        ]);
    }



    public function getListOfAgendaByMeetingId(Request $request)
    {
        \Log::info($request->meeting_id); 
        $agendas = Meeting::findOrFail($request->meeting_id)->agendas()->get();

        if (!$agendas) {
            return $this->error('', 'there\'s not agendas found ', 401);
        }

        \Log::info($agendas);
        return $this->success([
            'agendas' => $agendas,
        ]);
    }
    
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function inserNewMeeting(Request $request)
    {       
        // \Log::info($request->all());
        try{
                $validator = Validator::make($request->all(), [
                    'meeting_title' => 'required|string',
                //     'meeting_description' => 'required|string',
                    'meeting_start' => 'required|string',
                    'meeting_end' => 'required|string',
                    'meeting_by' => 'required|string',
                //     'meeting_media_name' => 'required|string',
                //     'meeting_status' => [ 'required', new Enum(MeetingStatusEnum::class) ],
                //     'meeting_file' => 'required|string',
                //     'is_active' => 'required',
                //     'created_by' => 'nullable',
                //     'hasNextMeeting' => 'nullable',
                //     'previous_meeting_id' => 'nullable',
                ]);
        
                if ($validator->fails()) {
                    return  $this->error('', $validator->errors(), 401);
                }
                
                // $file = $request->meeting_file;
                // $fileName = time() . '.' . $file;
                // $fileSelf = base64_decode($request->fileSelf);
                // Storage::disk('meetings_uploads')->put('meeting/' . $fileName, $fileSelf);
                
                $meeting_start = Carbon::parse($request->meeting_start);
                $meeting_end = Carbon::parse($request->meeting_end);
                $filePathDir = empty($request->committee_id) ? 'boards' : 'committees';
                
                $meeting =   Meeting::create([
                                            "meeting_title" => $request->meeting_title,
                                            'meeting_description' => $request->meeting_description,
                                            "meeting_start" => $meeting_start,
                                            "meeting_end" => $meeting_end,
                                            "meeting_status" => $request->meeting_status?? "NOTSIGNED",
                                            "meeting_by" => $request->meeting_by,
                                            "meeting_media_name" => $request->meeting_media_name,
                                            "meeting_file" => $request->meeting_file,
                                            "is_active" => $request->is_active ?? 0,
                                            "created_by" => $request->created_by,
                                            "business_id" => $request->business_id,
                                            'committee_id' => $request->committee_id,
                                            'board_id' => $request->board_id,
                                            "hasNextMeeting" => $request->hasNextMeeting ?? false,
                                            "previous_meeting_id" => $request->previous_meeting_id ?? null,
                                        ]);
                if($request->listOfAgendas && is_array($request->listOfAgendas) && count($request->listOfAgendas) > 0){
                    
                    for($i = 0; $i < count($request->listOfAgendas); $i++){
                        
                        $file = $request->listOfAgendas[$i]['agenda_file'];
                        $fileName = time() . '.' . $file;
                        $fileSelf = base64_decode($request->listOfAgendas[$i]['fileSelf']);
                        $path = Storage::disk('meetings_uploads')->put($filePathDir.'/'. $fileName, $fileSelf);
                        $fileFullPath = 'meetings/'.$filePathDir.'/'.$fileName;
                        \Log::info($fileFullPath);
                        $agendas[] = Agenda::create([
                                        "agenda_title" => $request->listOfAgendas[$i]['agenda_title'],
                                        "agenda_description" => $request->listOfAgendas[$i]['agenda_description'],
                                        "agenda_time" => $request->listOfAgendas[$i]['agenda_time'],
                                        'agenda_presenter' => $request->listOfAgendas[$i]['presenter_id'],
                                        "agenda_file" => $fileName,
                                        "file_name" => $file,
                                        "file_full_path" => $fileFullPath,
                                        "created_by" => $request->listOfAgendas[$i]['created_by'],
                                    ]);
                                    
                    }
                    $meeting->agendas()->saveMany($agendas);
                }
                    
                    \Log::info("meeting inserted done");
                return $this->success([
                    'meeting' => $meeting,
                ]);
                    
           }catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            return $this->error('', 'some thing occurs on create meeting !!!', 500);
        }
                 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function statusType(Request $request)
    {
        // $status = $request->meeting_status;
        switch($request->meeting_status){
            case 'signed': $status = MeetingStatusEnum::SIGNED;
            break;
            case 'not_signed': $status = MeetingStatusEnum::NOTSIGNED;
            break;
            case 'partial': $status = MeetingStatusEnum::PARTIAL;
            break;
            case 'qourm_reached': $status = MeetingStatusEnum::QOURMREACHED;
            break;
        }
        
        return $status;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Meeting  $meeting
     * @return \Illuminate\Http\Response
     */
    public function updateMeetingById(Request $request)
    {
        \Log::info($request->all());
        try{
            $meeting =  Meeting::findOrFail($request->meeting_id);
            $meeting->update($request->all());
               \Log::info("meeting update done");
                return $this->success([
                    'meeting' => $meeting,
                ]);
           }catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            return $this->error('', 'some thing occurs on update meeting !!!', 500);
        }
    }

    /**
     * get Meeting BeLongs To Board the specified business resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Meeting  $meeting
     * @return \Illuminate\Http\Response
     */
    public function getMeetingBeLongsToBoard(Request $request)
    {
        \Log::info("coming requist");
        $meetings = Meeting::with([
                            'board'=> function($q){
                                return $q->with('business');
                                },
                                'user'
                                ])->where(DB::raw('YEAR(created_at)'), $request->dateYearRequest)->get();

        if (!$meetings) {
            return $this->error('', 'there\'s not meetings found ', 401);
        }

        return $this->success([
            'meetings' => $meetings,
        ]);
    }

    /**
     * get Meeting BeLongs To Committee the specified business resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Meeting  $meeting
     * @return \Illuminate\Http\Response
     */
    public function getMeetingBeLongsToCommittee(Request $request)
    {
        \Log::info($request->dateYearRequest);
        $meetings = Meeting::with([
                            'committee'=> function($q){ 
                                        return $q->with([
                                            'board'=> function($q){ 
                                                return $q->with('business');
                                            }
                                    , 'business', 
                                    'members' => function($e){return $e->with('position');}
                                    ]);
            
        },'user'])->where(DB::raw('YEAR(created_at)'), $request->dateYearRequest)->get();

        if (!$meetings) {
            return $this->error('', 'there\'s not meetings found ', 401);
        }

        return $this->success([
            'meetings' => $meetings,
        ]);
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Meeting  $meeting
     * @return \Illuminate\Http\Response
     */
    public function destroy(Meeting $meeting)
    {
        //
    }
}
