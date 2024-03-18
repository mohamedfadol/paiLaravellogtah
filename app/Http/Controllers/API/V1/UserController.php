<?php

namespace App\Http\Controllers\API\V1;

use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ProfileUpdateRequest;

class UserController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function updateProfile(ProfileUpdateRequest $request)
    {
        try{
            $request->validated($request->only(['email', 'first_name','last_name', 'contact_number','biography']));
            $userBody = User::where(['id' => $request->id,'email' => $request->email])->first();
    
            if(!$userBody) {
                return $this->error('', 'Your Credentials Do Not Match ID or E-mail', 401);
            } 
            
            $signatureName = 'admin_signature_'.time().'_.png';
            $signatureSelf = base64_decode($request->uploadSignature);
            Storage::disk('signatures_uploads')->put($signatureName, $signatureSelf);
    
            $imageName = time().'_'.$request->profile_image;
            $imageSelf = base64_decode($request->imageSelf);
            Storage::disk('public_uploads')->put($imageName, $imageSelf);
            
            $userBody->update([
                            'first_name' => $request->first_name ,
                            'last_name' => $request->last_name,
                            'signature' => $signatureName,
                            'email' => $request->email ,
                            'profile_image' => $imageName,
                            'contact_number' => $request->contact_number,
                            'biography' => $request->biography
                        ]);
    
            if($userBody){
                \Log::info($request->id);
               
                $user = User::where('email', $request->email)->first();
                return $this->success([
                    'user' => $user,
                ]);
            }else{
                return $this->error('', 'Your Credentials Do Not Match  or not existing', 401);
            }
        }catch (\Exception $e) {
                    \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
                    return $this->error('', 'some thing occurs on edit actions trackers !!!', 500);
                }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getUserProfile(Request $request)
    {
        \Log::info($request->id);
        \Log::info($request->all());
        $user = User::findOrFail($request->id);
        \Log::info($user);
        if(!$user || is_null($user)) { return $this->error('', 'User Not have this ID', 401); }
        
        if($user){
            \Log::info($request->id);
            return $this->success(['user' => $user]);
        }else{
            return $this->error('', 'User not existing', 401);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function updataFcm(Request $request)
    {
        try{
            \Log::info($request->token);
            \Log::info($request->email);
             User::where($request->email)->update(['fcm' => $request->token]);
            return $this->success(['fcm'=>'done']);
        }catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            return $this->error('', 'some thing occurs !!!', 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
