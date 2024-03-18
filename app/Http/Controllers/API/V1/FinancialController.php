<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Financial;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Services\FirebaseNotificationService;
use DB;
use Illuminate\Http\Request;

class FinancialController extends Controller
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
    public function getListOfFinancials(Request $request)
    {
        try{
        \Log::info("coming request Financial");
        $currentYear = Carbon::now()->format('Y');
        $year = $request->dateYearRequest ?? $currentYear;
        \Log::info($year);
        $financials = Financial::where('business_id',$request->business_id)->with(['user','business','meeting','members'=> function($e){return $e->with('position');}])
                            ->where(DB::raw('YEAR(created_at)'), $year)->get();

        if (!$financials) {
            return $this->error('', 'there\'s not financials found ', 401);
        }

        return $this->success([
            'financials' => $financials,
        ]);
        
        }catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            return $this->error('', 'some thing occurs on get list of financials !!!', 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createNewFinancial(Request $request)
    {
        // \Log::info($request->all());
        try{
                $validator = Validator::make($request->all(), [
                    'financial_name' => 'required|string',
                    'financial_date' => 'required|string',
                    'meeting_id' => 'required|integer',
                    'add_by' => 'required|integer',
                    'business_id' => 'required|integer',
                    'add_by' => 'required|integer'
                ]);
        
                if ($validator->fails()) {
                    return  $this->error('', $validator->errors(), 401);
                }
                $string = str_replace(' ', '', $request->financial_file);
                $fileName = time().'.'.$string;
                $fileSelf = base64_decode($request->fileSelf);
                Storage::disk('charter_uploads')->put('financials/'.$request->business_id . '/' . $fileName, $fileSelf);
               
                $financial = Financial::create([
                                    "financial_name" => $request->financial_name,
                                    'financial_date' => $request->financial_date,
                                    "financial_file" => $fileName,
                                    "add_by" => $request->add_by,
                                    "meeting_id" => $request->meeting_id,
                                    "business_id" => $request->business_id,
                                ]);
                
                
                
                \Log::info("financial inserted done");
            return $this->success(['financial' => $financial->load('business','user','meeting'),]);
           }catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            return $this->error('', 'some thing occurs on create financial !!!', 500);
        }
    }


    /**
     * Show the form for member Make Sign financial.
     *
     * @return \Illuminate\Http\Response
     */
    public function memberMakeSignFinancial(Request $request)
    {
        try{
            $is_signed = Financial::findOrFail($request->financial_id)->members()->wherePivot('is_signed', true)->wherePivot('members.id', $request->member_id)->first();
            // \Log::info($is_signed);
        if($is_signed){
            \Log::info("you have signed already");
            return   $this->error('', 'you have signed already !!!', 400);
        }else{
            $financial = Financial::findOrFail($request->financial_id);
            $financial->members()->attach($request->member_id,['financial_status' => "SIGNED", "is_signed" => true]);
            return $this->success(['financial' => $financial->load('business','user','meeting'),]);
        }
        
        }catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            return $this->error('', 'some thing occurs on create signed !!!', 500);
        }
        
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Financial  $financial
     * @return \Illuminate\Http\Response
     */
    public function deleteFinancial(Request $request)
    {
        \Log::info($request->all());
        try{
                $validator = Validator::make($request->all(), ['financial_id' => 'required']);
        
                if ($validator->fails()) {return  $this->error('', $validator->errors(), 401);}
                
                $financial = Financial::findOrFail($request->financial_id);
                if(empty($financial)){ return $this->error('', 'some thing occurs on delete financial !!!', 401); }
                $financial->members()->detach();
                $financial->delete();
                 
                // \Log::info("financial delete done");
                return $this->success([
                    'financial' => null,
                ]);
           }catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            return $this->error('', 'some thing occurs on delete financial !!!', 500);
        }
    }
}
