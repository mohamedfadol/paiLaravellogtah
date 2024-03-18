<?php

namespace App\Http\Controllers\API\V1;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Models\Criteria;
use App\Models\Member;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class CriteriaController extends Controller
{
    use HttpResponses;
    
    /**
     * Display a listing of the criterias resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getListOfCriterias(Request $request)
    {
        \Log::info($request->business_id);
        $criterias = Criteria::with(['business','user'])->where('business_id', $request->business_id)->get();

        if (!$criterias) {
            return $this->error('', 'there\'s not criterias found ', 401);
        }

        \Log::info($criterias);
        return $this->success([
            'criterias' => $criterias,
        ]);
    }


    /**
     * Display a listing of the criterias resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getListOfCriteriasByBusinessId(Request $request)
    {
        \Log::info($request->business_id);
        $criterias = Criteria::with(['business','user'])->where('business_id', $request->business_id)->get();

        if (!$criterias) {
            return $this->error('', 'there\'s not criterias found ', 401);
        }

        \Log::info($criterias);
        return $this->success([
            'criterias' => $criterias,
        ]);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function insertNewCriteria(Request $request)
    {
        // \Log::info($request->listOfCriteria);
        try{
                $validator = Validator::make($request->all(), [
                    '*.listOfCriteria.*.criteria_category' => 'required',
                    '*.listOfCriteria.*.criteria_text' => 'required',
                    '*.listOfCriteria.*.created_by' => 'required',
                    '*.listOfCriteria.*.business_id' => 'required',
                ]);
        
                if ($validator->fails()) {
                    return  $this->error('', $validator->errors(), 401);
                }
                
                if($request->listOfCriteria && is_array($request->listOfCriteria) && count($request->listOfCriteria) > 0){
                    for($i = 0; $i < count($request->listOfCriteria); $i++){
                        $criteria = new Criteria;
                        $criteria->criteria_category = $request->listOfCriteria[$i]['criteria_category'];
                        $criteria->criteria_text = $request->listOfCriteria[$i]['criteria_text'];
                        $criteria->created_by = $request->listOfCriteria[$i]['created_by'];
                        $criteria->business_id = $request->listOfCriteria[$i]['business_id'];
                        $criteria->save();
                        // $this->criteriasAttachMembers($criteria->business_id,$criteria);
                    }
                }
                \Log::info($criteria);
            return $this->success(['criteria' => $criteria->load('business','user'),]);
           }catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            return $this->error('', 'some thing occurs on create criteria !!!', 500);
        }
                 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function criteriasAttachMembers($business_id,$criteria)
    {
        $members = Member::where('business_id',$business_id)->get();
        foreach($members as $member){
            $member->criterias()->attach($criteria,['business_id'=>$business_id]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Criteria  $criteria
     * @return \Illuminate\Http\Response
     */
    public function insertNewCriteriaEvaluationsMember(Request $request)
    {
          \Log::info($request->listOfCriteriaEvaluations);
          
            try{
                $validator = Validator::make($request->all(), [
                    '*.listOfCriteriaEvaluations.*.criteria_degree' => 'required',
                    '*.listOfCriteriaEvaluations.*.elected_by' => 'required|integer',
                    '*.listOfCriteriaEvaluations.*.criteria_id' => 'required|integer',
                    '*.listOfCriteriaEvaluations.*.business_id' => 'required|integer',
                    '*.listOfCriteriaEvaluations.*.member_id' => 'required|integer',
                ]);
        
                if ($validator->fails()) {
                    return  $this->error('', $validator->errors(), 401);
                }
                
                $member = Member::findOrFail($request->member_id);
                        
                if($request->listOfCriteriaEvaluations && is_array($request->listOfCriteriaEvaluations) && count($request->listOfCriteriaEvaluations) > 0){ 
                    for($i = 0; $i < count($request->listOfCriteriaEvaluations); $i++){
                        $member->criterias()->attach($request->listOfCriteriaEvaluations[$i]['criteria_id'],[
                                                                    'criteria_degree'=>$request->listOfCriteriaEvaluations[$i]['criteria_degree'],
                                                                    'criteria_id'=>$request->listOfCriteriaEvaluations[$i]['criteria_id'],
                                                                    'business_id'=>$request->listOfCriteriaEvaluations[$i]['business_id'],
                                                                    'elected_by'=> $request->listOfCriteriaEvaluations[$i]['elected_by'],
                                                                    'has_vote' => true
                                                                ]);
                    }
                }
                
                // \Log::info($criteria);
            return $this->success(['criteria' => 'add evaluations has been done',]);
          }catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            return $this->error('', 'some thing occurs on create criteria !!!', 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Criteria  $criteria
     * @return \Illuminate\Http\Response
     */
    public function edit(Criteria $criteria)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Criteria  $criteria
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Criteria $criteria)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Criteria  $criteria
     * @return \Illuminate\Http\Response
     */
    public function destroy(Criteria $criteria)
    {
        //
    }
}
