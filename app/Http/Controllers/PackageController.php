<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DataTables;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $packages =  Package::get();
        // dd($packages);
        $intervals = array('days', 'months', 'years') ;
        return view('packages.index',compact('intervals'));
    }

    public function getListPackages(Request $request)
    {

            $packages =  Package::get();
            return DataTables::of($packages)
                    ->addIndexColumn()
                    ->addColumn('actions', function($row){
                            return '<div class="btn-group">
                                        <button class="btn btn-sm btn-primary ml-1" data-id="'.$row['id'].'" id="editPackageBtn"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>  Update</button>
                                        <button class="btn btn-sm btn-danger" data-id="'.$row['id'].'" id="deletePackageBtn"><i class="fe fe-trash"></i>  Delete</button>
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
        // dd($request->all());
        try {
            $validator = \Validator::make($request->all(),[
                'package_name'=>'required|max:255',
                'description'=>'required',
                'price'=>'required',
                'package_trial_days'=>'required',
            ]);
            if(!$validator->passes()){
                return response()->json(['code'=>0,'error'=>$validator->errors()->toArray()]);
            }else{
                // DB::beginTransaction();

                $package_details = $request->only(['package_name', 'description', 'price', 'package_trial_days',
                                                    'interval', 'is_one_time', 'is_active','is_private']);
                $package = Package::create_package($package_details);
                // dd($package);
                if(!$package){
                    return response()->json(['code'=>0,'msg'=>'Something went wrong']);
                }else{
                    return response()->json(['code'=>1,'msg'=>'New Country has been successfully saved']);
                }
            }
            // return redirect()->back()->withStatus('Successfully Created');
            } catch (\Exception $e) {
                // DB::rollBack();
                \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());

                $output = ['success' => 0,
                                'msg' => __('messages.something_went_wrong')
                            ];

                return back()->with('status', 'Error')->withInput();
            }

    }


    //GET package DETAILS
    public function getPackageDetails(Request $request){
        $package_id = $request->package_id;
        $packageDetails = Package::find($package_id);
        return response()->json(['details'=>$packageDetails]);
    }

    //UPDATE package DETAILS
    public function updatePackageDetails(Request $request){
        $package_id = $request->pid;
        $package = Package::find($package_id);
        $validator = \Validator::make($request->all(),[
            'package_name'=>'required|max:255',
            'description'=>'required',
            'price'=>'required',
            'package_trial_days'=>'required',
        ]);

        if(!$validator->passes()){
                return response()->json(['code'=>0,'error'=>$validator->errors()->toArray()]);
        }else{
            $package_details = $request->only(['package_name', 'description', 'price', 'package_trial_days',
                                                    'interval', 'is_one_time', 'is_active','is_private']);
            // dd($package_id,$request->pid,);
            $update_package = Package::where('id', $request->pid)
                    ->update([
                        'name' => $package_details['package_name'],
                        'description' => $package_details['description'],
                        'price' => $package_details['price'],
                        'trial_days' => $package_details['package_trial_days'],
                        'interval' => $package_details['interval'],
                        'is_one_time' => $package_details['is_one_time'],
                        'is_active' => $package_details['is_active'],
                        'is_private' => $package_details['is_private'],
                    ]);
                    // dd($update_package);
            if($update_package){
                return response()->json(['code'=>1, 'msg'=>'Package Details have Been updated']);
            }else{
                return response()->json(['code'=>0, 'msg'=>'Something went wrong']);
            }
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function show(Package $package)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function edit(Package $package)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Package $package)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try {
            $validator = $request->validate(
                ['id' => 'required'],
            );
            // DB::beginTransaction();
            $package = Package::findOrFail($request->id);
            $package->delete();
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

    // DELETE Package RECORD
    public function deletePackage(Request $request){
        $country_id = $request->country_id;
        $query = Package::find($country_id)->delete();

        if($query){
            return response()->json(['code'=>1, 'msg'=>'Package has been deleted from database']);
        }else{
            return response()->json(['code'=>0, 'msg'=>'Something went wrong']);
        }
    }

    // DELETE all Selected Packages RECORDs
    public function deleteSelectedPackages(Request $request){
        $country_ids = $request->countries_ids;
        Package::whereIn('id', $country_ids)->delete();
        return response()->json(['code'=>1, 'msg'=>'Packages have been deleted from database']);
    }


}
