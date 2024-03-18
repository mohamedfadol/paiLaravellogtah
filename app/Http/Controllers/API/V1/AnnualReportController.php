<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\AnnualReport;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Services\FirebaseNotificationService;
use DB;
use Illuminate\Http\Request;

class AnnualReportController extends Controller
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
    public function getListOfAnnualReports(Request $request)
    {
        try{
        \Log::info("coming request Annual Report");
        $currentYear = Carbon::now()->format('Y');
        $year = $request->dateYearRequest ?? $currentYear;
        \Log::info($year);
        $annual_reports = AnnualReport::where('business_id',$request->business_id)->with(['user','business','meeting','members'=> function($e){return $e->with('position');}])
                            ->where(DB::raw('YEAR(created_at)'), $year)->get();

        if (!$annual_reports) {
            return $this->error('', 'there\'s not Annual Report found ', 401);
        }

        return $this->success([
            'annual_reports' => $annual_reports,
        ]);
        
        }catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            return $this->error('', 'some thing occurs on get list of annual_reports !!!', 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createNewAnnualReport(Request $request)
    {
        // \Log::info($request->all());
        try{
                $validator = Validator::make($request->all(), [
                    'annual_report_name' => 'required|string',
                    'annual_report_date' => 'required|string',
                    'meeting_id' => 'required|integer',
                    'add_by' => 'required|integer',
                    'business_id' => 'required|integer'
                ]);
        
                if ($validator->fails()) {
                    return  $this->error('', $validator->errors(), 401);
                }
                $string = str_replace(' ', '', $request->annual_report_file);
                $fileName = time().'.'.$string;
                $fileSelf = base64_decode($request->fileSelf);
                Storage::disk('charter_uploads')->put('annual_reports/'.$request->business_id . '/' . $fileName, $fileSelf);
               
                $annual_reports = AnnualReport::create([
                                    "annual_report_name" => $request->annual_report_name,
                                    'annual_report_date' => $request->annual_report_date,
                                    "annual_report_file" => $fileName,
                                    "add_by" => $request->add_by,
                                    "meeting_id" => $request->meeting_id,
                                    "business_id" => $request->business_id,
                                ]);
                
                
                
                \Log::info("annual_report inserted done");
            return $this->success(['annual_report' => $annual_reports->load('business','user','meeting'),]);
           }catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            return $this->error('', 'some thing occurs on create annual_report !!!', 500);
        }
    }


    /**
     * Show the form for member Make Sign annual_report.
     *
     * @return \Illuminate\Http\Response
     */
    public function memberMakeSignAnnualReport(Request $request)
    {
        try{
            $is_signed = AnnualReport::findOrFail($request->annual_report_id)->members()->wherePivot('is_signed', true)->wherePivot('members.id', $request->member_id)->first();
            // \Log::info($is_signed);
        if($is_signed){
            \Log::info("you have signed already");
            return   $this->error('', 'you have signed already !!!', 400);
        }else{
            $annual_report = AnnualReport::findOrFail($request->annual_report_id);
            $annual_report->members()->attach($request->member_id,['annual_report_status' => "SIGNED", "is_signed" => true]);
            return $this->success(['annual_report' => $annual_report->load('business','user','meeting'),]);
        }
        
        }catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            return $this->error('', 'some thing occurs on create signed !!!', 500);
        }
        
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\annual_report  $annual_report
     * @return \Illuminate\Http\Response
     */
    public function deleteAnnualReport(Request $request)
    {
        \Log::info($request->all());
        try{
                $validator = Validator::make($request->all(), ['annual_report_id' => 'required']);
        
                if ($validator->fails()) {return  $this->error('', $validator->errors(), 401);}
                
                $annual_report = AnnualReport::findOrFail($request->annual_report_id);
                if(empty($annual_report)){ return $this->error('', 'some thing occurs on delete annual_report !!!', 401); }
                $annual_report->members()->detach();
                $annual_report->delete();
                 
                // \Log::info("annual_report delete done");
                return $this->success([
                    'annual_report' => null,
                ]);
           }catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            return $this->error('', 'some thing occurs on delete annual_report !!!', 500);
        }
    }
}
