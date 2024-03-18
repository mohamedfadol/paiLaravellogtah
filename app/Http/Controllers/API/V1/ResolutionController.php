<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Resoultion;
use App\Models\Meeting;
use App\Models\Board;
use App\Models\Signature;
use App\Models\Searchable;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Enums\MeetingStatusEnum;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Support\Str;
use App\Enums;

class ResolutionController extends Controller
{
    use HttpResponses;
    
    /**
     * Display a listing of the boards resource.
     *
     * @return \Illuminate\Http\Response 
     */
     
    public function getListOfBoardResolutions(Request $request)
    {
        try{
        \Log::info("coming requist resoultion");
        // $resolutions = Resoultion::where('resoultion_status',ResolutionPuplishedStatusEnum::UNPUPLISHED)->get();
        // $resolutions = Resoultion::where('resoultion_status',ResolutionPuplishedStatusEnum::PUPLISHED)->get();
        // $resolutions = Resoultion::where('resoultion_status',ResolutionPuplishedStatusEnum::ARCHIVED)->get();
        $currentYear = Carbon::now()->format('Y');
        $year = $request->dateYearRequest ?? $currentYear;
        \Log::info($year);
        $resolutions = Resoultion::getBoardsResoultion()->where('business_id',$request->business_id)->where(DB::raw('YEAR(created_at)'), $year)->get();

        if (!$resolutions) {
            return $this->error('', 'there\'s not resolutions found ', 401);
        }

        return $this->success(['resolutions' => $resolutions]);
        
        }catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            return $this->error('', 'some thing occurs on get list of resolutions !!!', 500);
        }
    }
    
        /**
     * Display a listing of the boards resource.
     *
     * @return \Illuminate\Http\Response 
     */
     
    public function getListOfCommitteesResolutions(Request $request)
    {
        try{
        \Log::info("coming requist resoultion");
        // $resolutions = Resoultion::where('resoultion_status',ResolutionPuplishedStatusEnum::UNPUPLISHED)->get();
        // $resolutions = Resoultion::where('resoultion_status',ResolutionPuplishedStatusEnum::PUPLISHED)->get();
        // $resolutions = Resoultion::where('resoultion_status',ResolutionPuplishedStatusEnum::ARCHIVED)->get();
        $currentYear = Carbon::now()->format('Y');
        $year = $request->dateYearRequest ?? $currentYear;
        \Log::info($year);
        $resolutions = Resoultion::getCommitteesResoultion()->where('business_id',$request->business_id)->where(DB::raw('YEAR(created_at)'), $year)->get();

        if (!$resolutions) {
            return $this->error('', 'there\'s not resolutions found ', 401);
        }

        return $this->success(['resolutions' => $resolutions]);
        
        }catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            return $this->error('', 'some thing occurs on get list of resolutions !!!', 500);
        }
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function inserNewResolution(Request $request)
    {       
        \Log::info($request->all());
        try{
                $validator = Validator::make($request->all(), [
                    'resoultion_name' => 'required|string',
                    'date' => 'required|string',
                    'meeting_id' => 'required',
                    'resolution_decision' => 'required',
                    'business_id' => 'required',
                    'add_by' => 'required',
                    // 'board_id' => 'required',
                ]);
        
                if ($validator->fails()) {
                    return  $this->error('', $validator->errors(), 401);
                }
                
                 $meeting = Meeting::findOrFail($request->meeting_id);
                if($request->board_id ){
                   $board = Board::findOrFail($request->board_id); 
                }else{
                    $board = Board::active(); 
                }
                $currentYear = Carbon::now()->format('Y');
                $resoultion_numbers = $meeting->id.'-'.$board->term.'-'.$currentYear;
                
                // use meeting  date if meeting request exist instead of request date
                $date = Carbon::parse($request->date);
                
                if(!empty($request->meeting_id)){
                    $date = $meeting->meeting_start;
                }
                
                $resolution = Resoultion::create([
                        "resoultion_name" => $request->resoultion_name,
                        'resoultion_numbers' => $resoultion_numbers,
                        'date' => $date,
                        "committee_id" => $request->committee_id ?? null,
                        "resolution_decision" => $request->resolution_decision,
                        "board_id" => $request->board_id ?? null,
                        "meeting_id" => $request->meeting_id ?? null,
                        "resoultion_status" => $request->resoultion_status ?? "NOTSIGNED",
                        "add_by" => $request->add_by,
                        "business_id" => $request->business_id,
                    ]);
                \Log::info("resolution inserted done");
            return $this->success([
                'resolution' => $resolution,
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
    public function memberMakeSignResolution(Request $request)
    {
        try{
        $signature = Signature::where('member_id',$request->member_id)->where('resoultion_id',$request->resolution_id)->where('has_signed',true)->get();
        if(count($signature)> 0){
            \Log::info("you have signed already");
         return   $this->error('', 'you have signed already !!!', 400);
        }else{
            $signature = Signature::create([
                    'member_id' => $request->member_id,
                    'resoultion_id' => $request->resolution_id,
                    'has_signed' => true,
                ]);
            $resolution = Resoultion::findOrFail($request->resolution_id);
            return $this->success([
                'resolution' => $resolution,
            ]);
        }
        
        }catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            return $this->error('', 'some thing occurs on create signed !!!', 500);
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Resolution  $resolution
     * @return \Illuminate\Http\Response
     */
    public function deleteResolution(Request $request)
    {
        //  \Log::info($request->all());
        try{
                $validator = Validator::make($request->all(), ['resolution_id' => 'required']);
        
                if ($validator->fails()) {return  $this->error('', $validator->errors(), 401);}
                
                $resolution = Resoultion::findOrFail($request->resolution_id);
                if(empty($resolution)){ return $this->error('', 'some thing occurs on delete resolution !!!', 401); }
                $resolution->delete();
                 
                // \Log::info("minute delete done");
                return $this->success([
                    'resolution' => null,
                ]);
           }catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            return $this->error('', 'some thing occurs on delete resolution !!!', 500);
        }
    }
}
