<?php

namespace App\Http\Controllers\API\V1;

use Carbon\Carbon;
use App\Models\Board;
use App\Models\Searchable;
use App\Models\Business;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use App\Http\Requests\BoardRequest;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class BoardController extends Controller
{
    use HttpResponses;
   
    /**
     * Display a listing of the boards resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getListOfBoards(Request $request)
    {
        \Log::info($request->business_id);
        $boards = Board::where('business_id', $request->business_id)->with(['business','members' => function($e){return $e->with('position');}])->get();

        if (!$boards) {
            return $this->error('', 'there\'s not boards found ', 401);
        }

        \Log::info($boards);
        
        return $this->success([
            'boards' => $boards,
        ]);
    }

    /**
     * Store a newly created resource of board in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function insertNewBoard(Request $request)
    {
        // \Log::info($request->all());
        try{
                $validator = Validator::make($request->all(), [
                    'board_name' => 'required',
                    'term' => 'required|string',
                    'quorum' => 'required',
                    'fiscal_year' => 'required',
                    'business_id' => 'required',
                ]);
        
                if ($validator->fails()) {
                    return  $this->error('', $validator->errors(), 401);
                }
                
                $file = $request->charter_board;
                $fileName = time() . '.' . $file;
                $fileSelf = base64_decode($request->fileSelf);
                Storage::disk('charter_uploads')->put($request->business_id . '/' . $fileName, $fileSelf);
                Searchable::create([
                'charter_name' => $request->board_name,
                'file_name' => $fileName,
                'file_dir' => 'charters',
                'business_id' => $request->business_id,
                ]);
                
                $term = Carbon::parse($request->term);
                $threeYearsAdd = $term->addYears(3);
                $last_board = Board::orderby('created_at', 'desc')->first();
                
                if(!is_null($last_board) || !empty($last_board)){
                    $fiscal_year = $last_board->fiscal_year;
                    $quorum = $last_board->quorum;
                    $max_id = $last_board->id;
                    $serial_numbaer = $max_id.'-'.$fiscal_year.'-'.$quorum;
                    $board = Board::create([
                                        "charter_board" => $fileName,
                                        'charter_name' => $request->charter_board,
                                        "board_name" => $request->board_name,
                                        "term" => $threeYearsAdd,
                                        'serial_number' => $serial_numbaer,
                                        "quorum" => $request->quorum,
                                        "fiscal_year" => $request->fiscal_year,
                                        "business_id" => $request->business_id,
                                    ]);
                }else{
                    $board = Board::create([
                                        "charter_board" => $fileName,
                                        'charter_name' => $request->charter_board,
                                        "board_name" => $request->board_name,
                                        "term" => $threeYearsAdd,
                                        'serial_number' => '1',
                                        "quorum" => $request->quorum,
                                        "fiscal_year" => $request->fiscal_year,
                                        "business_id" => $request->business_id,
                                    ]);
                }
                
                
                \Log::info("board inserted done");
            return $this->success(['board' => $board->load('business'),]);
           }catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            return $this->error('', 'some thing occurs on create board !!!', 500);
        }
                 
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function uploadCharter(Request $request)
    {
        \Log::info($request->all());
        Storage::disk('charter_uploads')->put($request->fielding, $request->folder);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Board  $board
     * @return \Illuminate\Http\Response
     */
    public function getBoardById($id)
    {
         // \Log::info($request->all());
        try{
            $board = Board::find(1);
            \Log::info("board inserted done");
            // \Log::info($board);
            return $this->success([
                'board' => $board,
            ]);
           }catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            return $this->error('', 'some thing occurs on get board !!!', 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Board  $board
     * @return \Illuminate\Http\Response
     */
    public function edit(Board $board)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Board  $board
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Board $board)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Board  $board
     * @return \Illuminate\Http\Response
     */
    public function destroy(Board $board)
    {
        //
    }
}
