<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Business;
use App\Models\Board;
use App\Models\Searchable;
use App\Models\Committee;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use App\Http\Controllers\Controller;
use App\Http\Requests\CommitteeRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
class CommitteeController extends Controller
{
    use HttpResponses;
    /**
     * save a record of the resource. Committee
     *
     * @return \Illuminate\Http\Response
     */
    public function insertNewCommittee(Request $request)
    {
        // \Log::info("requst all");
        try{
        $validator = Validator::make($request->all(), [
            'committee_name' => 'required|string',
            'board_id' => 'required',
            'business_id' => 'required',
        ]);

        if ($validator->fails()) {
            return  $this->error('', $validator->errors(), 401);
        }
        
            $file = $request->charter_committee;
            $fileName = time() . '.' . $file;
            $fileSelf = base64_decode($request->fileSelf);
            Storage::disk('charter_uploads')->put($request->business_id . '/' . $fileName, $fileSelf);
            Searchable::create([
                'charter_name' => $request->committee_name,
                'file_name' => $fileName,
                'file_dir' => 'charters',
                'business_id' => $request->business_id,
                ]);
            $committee = Committee::create([
                                            "charter_committee" => $fileName,
                                            "charter_name" => $request->charter_committee,
                                            "committee_name" => $request->committee_name,
                                            "board_id" => $request->board_id,
                                            "business_id" => $request->business_id,
                                        ]);
            $committee = $committee->load(['board' => function($e){return $e->with('business');}]);
            \Log::info("committee inserted done");
            return $this->success(['committee' => $committee]);

        }catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            return $this->error('', 'some thing occurs on create committee !!!', 500);
        }
        
    }

    /**
     * Show the form for get a all resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getListOfCommittees(Request $request)
    {
        \Log::info($request->business_id);
        //should say where business and where board 
        $committees = Committee::where('business_id', $request->business_id)->with(['meetings','board' => function($e){return $e->with('business');},'business',
                                                                                    'members' => function($e){return $e->with('position');}])->get();

        if (!$committees) {
            return $this->error('', 'there\'s not committees found ', 401);
        }

        \Log::info($committees);
        return $this->success([
            'committees' => $committees,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getAllOfCommittees(Request $request)
    {
        \Log::info($request->business_id);
        //should say where business and where board 
        $committees = Committee::where('business_id', $request->business_id)->get();

        if (!$committees) {
            return $this->error('', 'there\'s not committees found ', 401);
        }

        \Log::info($committees);
        return $this->success([
            'committees' => $committees,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Commitee  $commitee
     * @return \Illuminate\Http\Response
     */
    public function show(Commitee $commitee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Commitee  $commitee
     * @return \Illuminate\Http\Response
     */
    public function edit(Commitee $commitee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Commitee  $commitee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Commitee $commitee)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Commitee  $commitee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Commitee $commitee)
    {
        //
    }
}
