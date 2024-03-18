<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Searchable;
use App\Models\Business;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;

class SearchableController extends Controller
{
    use HttpResponses;
    
    /**
     * Display a listing of the searchables resource.
     *
     * @return \Illuminate\Http\Response
    */
    public function getListOfSearchables(Request $request)
    {
        \Log::info($request->business_id);
        $searchables = Searchable::where('business_id', $request->business_id)->get();

        if (!$searchables) {
            return $this->error('', 'there\'s not searchables found ', 401);
        }

        \Log::info($searchables);
        return $this->success([
            'searchables' => $searchables, //->load('business')
        ]);
    }
    
    
}
