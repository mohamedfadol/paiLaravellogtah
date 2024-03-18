<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Disclosure;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;

class DisclosureController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getListOfDisclosures(Request $request)
    {
        try{
        \Log::info("coming requist disclosures");
        $currentYear = Carbon::now()->format('Y');
        $year = $request->dateYearRequest ?? $currentYear;
        \Log::info($year);
        $disclosures = Disclosure::with(['user','business'])->where('business_id' , $request->business_id)
        // ->whereHas('member', function($e){ $e->with('position');})
                            ->where(DB::raw('YEAR(created_at)'), $year)->get();

        if (!$disclosures) {
            return $this->error('', 'there\'s not disclosures found ', 401);
        }

        return $this->success([
            'disclosures' => $disclosures,
        ]);
        
        }catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            return $this->error('', 'some thing occurs on get list of disclosures !!!', 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createNewDisclosure(Request $request)
    {
        // \Log::info($request->all());
        try{
                $validator = Validator::make($request->all(), [
                    'disclosure_name' => 'required|string',
                    'disclosure_date' => 'required|string',
                    'disclosure_type' => 'required|string',
                    // 'member_id' => 'required|integer',
                    'add_by' => 'required|integer',
                    'business_id' => 'required|integer'
                ]);
        
                if ($validator->fails()) {
                    return  $this->error('', $validator->errors(), 401);
                }
                $string = str_replace(' ', '', $request->disclosure_file);
                $fileName = time().'.'.$string;
                $fileSelf = base64_decode($request->fileSelf);
                Storage::disk('charter_uploads')->put('disclosures/'. $fileName, $fileSelf);
               
                $disclosure = Disclosure::create([
                                    "disclosure_name" => $request->disclosure_name,
                                    'disclosure_date' => $request->disclosure_date,
                                    "disclosure_type" => $request->disclosure_type,
                                    "disclosure_file" => $fileName,
                                    "add_by" => $request->add_by,
                                    "member_id" => $request->member_id,
                                    "business_id" => $request->business_id,
                                ]);
                
                
                
                \Log::info("disclosure inserted done");
            return $this->success(['disclosure' => $disclosure->load('business','user'),]);
           }catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            return $this->error('', 'some thing occurs on create disclosure !!!', 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function deleteDisclosure(Request $request)
    {
        \Log::info($request->all());
        try{
                $validator = Validator::make($request->all(), ['disclosure_id' => 'required']);
        
                if ($validator->fails()) {return  $this->error('', $validator->errors(), 401);}
                
                $disclosure = Disclosure::findOrFail($request->disclosure_id);
                if(empty($disclosure)){ return $this->error('', 'some thing occurs on delete disclosure !!!', 401); }
                $disclosure->delete();
                 
                // \Log::info("disclosure delete done");
                return $this->success([
                    'disclosure' => null,
                ]);
           }catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            return $this->error('', 'some thing occurs on delete disclosure !!!', 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Disclosure  $disclosure
     * @return \Illuminate\Http\Response
     */
    public function show(Disclosure $disclosure)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Disclosure  $disclosure
     * @return \Illuminate\Http\Response
     */
    public function edit(Disclosure $disclosure)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Disclosure  $disclosure
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Disclosure $disclosure)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Disclosure  $disclosure
     * @return \Illuminate\Http\Response
     */
    public function destroy(Disclosure $disclosure)
    {
        //
    }
}
