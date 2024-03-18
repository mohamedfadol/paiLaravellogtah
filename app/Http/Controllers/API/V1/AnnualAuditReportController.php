<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\AnnualAuditReport;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Services\FirebaseNotificationService;
use DB;
use Illuminate\Http\Request;

class AnnualAuditReportController extends Controller
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
    public function getListOfAnnualAuditReports(Request $request)
    {
        try{
        \Log::info("coming request Annual audit Report");
        $currentYear = Carbon::now()->format('Y');
        $year = $request->dateYearRequest ?? $currentYear;
        \Log::info($year);
        $annual_audit_reports = AnnualAuditReport::where('business_id',$request->business_id)->with(['user','business'])
                            ->where(DB::raw('YEAR(created_at)'), $year)->get();

        if (!$annual_audit_reports) {
            return $this->error('', 'there\'s not Annual audit Report found ', 401);
        }

        return $this->success([
            'annual_audit_reports' => $annual_audit_reports,
        ]);
        
        }catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            return $this->error('', 'some thing occurs on get list of annual_audit_reports !!!', 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createNewAnnualAuditReport(Request $request)
    {
        // \Log::info($request->all());
        try{
                $validator = Validator::make($request->all(), [
                    'annual_audit_report_title' => 'required|string',
                    'annual_audit_report_text' => 'required|string',
                    'created_by' => 'required|integer',
                    'business_id' => 'required|integer'
                ]);
        
                if ($validator->fails()) {
                    return  $this->error('', $validator->errors(), 401);
                }
                // $string = str_replace(' ', '', $request->annual_report_file);
                // $fileName = time().'.'.$string;
                // $fileSelf = base64_decode($request->fileSelf);
                // Storage::disk('charter_uploads')->put('annual_reports/'.$request->business_id . '/' . $fileName, $fileSelf);
               
                $annual_audit_report = AnnualAuditReport::create([
                                    "annual_audit_report_title" => $request->annual_audit_report_title,
                                    'annual_audit_report_text' => $request->annual_audit_report_text,
                                    // "annual_report_file" => $fileName,
                                    "created_by" => $request->created_by,
                                    "business_id" => $request->business_id,
                                ]);
                
                \Log::info("annual_audit_report inserted done");
            return $this->success(['annual_audit_report' => $annual_audit_report->load('business','user'),]);
           }catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            return $this->error('', 'some thing occurs on create annual_audit_report !!!', 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AnnualAuditReport  $annualAuditReport
     * @return \Illuminate\Http\Response
     */
    public function memberMakeSignAnnualAuditReport(Request $request)
    {
        try{
            $is_signed = AnnualAuditReport::findOrFail($request->annual_audit_report_id)->members()->wherePivot('is_signed', true)->wherePivot('members.id', $request->member_id)->first();
            // \Log::info($is_signed);
        if($is_signed){
            \Log::info("you have signed already");
            return   $this->error('', 'you have signed already !!!', 400);
        }else{
            $annual_audit_report = AnnualAuditReport::findOrFail($request->annual_audit_report_id);
            $annual_audit_report->members()->attach($request->member_id,['annual_audit_report_status' => "SIGNED", "is_signed" => true]);
            return $this->success(['annual_audit_report' => $annual_audit_report->load('business','user'),]);
        }
        
        }catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            return $this->error('', 'some thing occurs on create signed !!!', 500);
        }
        
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function deleteAnnualAuditReport(Request $request)
    {
        \Log::info($request->all());
        try{
                $validator = Validator::make($request->all(), ['annual_audit_report_id' => 'required']);
                if ($validator->fails()) {return  $this->error('', $validator->errors(), 401);}
                $annual_audit_report = AnnualAuditReport::findOrFail($request->annual_audit_report_id);
                if(empty($annual_audit_report)){ return $this->error('', 'some thing occurs on delete annual_audit_report !!!', 401); }
                $annual_audit_report->members()->detach();
                $annual_audit_report->delete();
                // \Log::info("annual_audit_report delete done");
                return $this->success([
                    'annual_audit_report' => null,
                ]);
           }catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            return $this->error('', 'some thing occurs on delete annual_audit_report !!!', 500);
        }
    }


}
