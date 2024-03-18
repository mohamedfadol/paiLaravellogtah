<?php

namespace App\Http\Controllers;

use App\Models\Tax;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class TaxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $taxs =  Tax::get();
        return view('taxs.index',compact('taxs'));
    }

    public function getListTaxs(Request $request)
    {

            $taxs =  Tax::get();
            return DataTables::of($taxs)
                    ->addIndexColumn()
                    ->addColumn('actions', function($row){
                            return '<div class="btn-group">
                                        <button class="btn btn-sm btn-primary ml-1" data-id="'.$row['id'].'" id="editTaxBtn"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>  Update</button>
                                        <button class="btn btn-sm btn-danger" data-id="'.$row['id'].'" id="deleteTaxBtn"><i class="fe fe-trash"></i>  Delete</button>
                                    </div>';
                        })
                        ->addColumn('checkbox', function($row){
                            return '<input type="checkbox" name="country_checkbox" data-id="'.$row['id'].'"><label></label>';
                        })

                    ->rawColumns(['actions','checkbox'])
                    ->make(true);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $validator = \Validator::make($request->all(),[
                'tax_name' => 'required|max:255',
                'tax_amount' => 'required|max:255',
            ]);
            if(!$validator->passes()){
                return response()->json(['code'=>0,'error'=>$validator->errors()->toArray()]);
            }else{
                    // DB::beginTransaction();
                    $tax_details = $request->only(['tax_name', 'tax_amount']);
                    $business_id = session()->get('user.business_id');
                    $user_id = $request->session()->get('user.id');
                    $tax_details['business_id'] = $business_id;
                    $tax_details['created_by'] = $user_id;

                    $tax = Tax::create_tax($tax_details);
                if(!$tax){
                    return response()->json(['code'=>0,'msg'=>'Something went wrong']);
                }else{
                    return response()->json(['code'=>1,'msg'=>'New Tax has been successfully saved']);
                }
            }
            } catch (\Exception $e) {
                // DB::rollBack();
                \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());

                // $output = ['success' => 0, 'msg' => __('messages.something_went_wrong')];
                return response()->json(['code'=>0,'msg'=>'Something went wrong']);
                // return back()->with('status', 'Error')->withInput();
            }

    }


    //GET Tax DETAILS
    public function getTaxDetails(Request $request){
        $tax_id = $request->tax_id;
        $taxDetails = Tax::find($tax_id);
        return response()->json(['details'=>$taxDetails]);
    }

    //UPDATE tax DETAILS
    public function updateTaxDetails(Request $request){
        $tax_id = $request->txid;
        $package = Tax::find($tax_id);
        $validator = \Validator::make($request->all(),[
            'tax_name'=>'required|max:255',
            'tax_amount'=>'required',
        ]);

        if(!$validator->passes()){
                return response()->json(['code'=>0,'error'=>$validator->errors()->toArray()]);
        }else{
            $tax_details = $request->only(['tax_name', 'tax_amount']);
            // dd($tax_id,$request->txid,);
            $update_tax = Tax::where('id', $request->txid)
                    ->update([
                        'name' => $tax_details['tax_name'],
                        'amount' => $tax_details['tax_amount'],
                    ]);
                    // dd($update_tax);
            if($update_tax){
                return response()->json(['code'=>1, 'msg'=>'Tax Details have Been updated']);
            }else{
                return response()->json(['code'=>0, 'msg'=>'Something went wrong']);
            }
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tax  $tax
     * @return \Illuminate\Http\Response
     */
    public function show(Tax $tax)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tax  $tax
     * @return \Illuminate\Http\Response
     */
    public function edit(Tax $tax)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tax  $tax
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tax $tax)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tax  $tax
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try {
            $validator = $request->validate(
                ['id' => 'required'],
                ['id.required' => __('validation.required', ['attribute' => __('business.id')])]
            );
            // DB::beginTransaction();
            $tax = Tax::findOrFail($request->id);
            $tax->delete();
            return redirect()->back()->withStatus('Successfully Deleted');
        } catch (\Exception $e) {
            // DB::rollBack();
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());

            $output = ['success' => 0,
                            'msg' => __('messages.something_went_wrong')
                        ];

            return back()->with('status', 'Error')->withInput();
        }

    }


        // DELETE Tax RECORD
        public function deleteTax(Request $request){
            $country_id = $request->country_id;
            $query = Tax::find($country_id)->delete();
    
            if($query){
                return response()->json(['code'=>1, 'msg'=>'Tax has been deleted from database']);
            }else{
                return response()->json(['code'=>0, 'msg'=>'Something went wrong']);
            }
        }
    
        // DELETE all Selected Taxs RECORDs
        public function deleteSelectedTaxs(Request $request){
            $country_ids = $request->countries_ids;
            Tax::whereIn('id', $country_ids)->delete();
            return response()->json(['code'=>1, 'msg'=>'Taxs have been deleted from database']);
        }
    

        

}
