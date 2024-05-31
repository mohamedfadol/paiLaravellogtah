<?php

namespace App\Http\Controllers\API\V1;

use DB;
use App\Models\User;
use App\Models\Member;
use App\Utils\ModuleUtil;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Http\Requests\MemberRequest;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash; 
use Illuminate\Support\Facades\Storage;
use App\Mail\WelcomeOneTimePasswordEmail;
use Illuminate\Support\Facades\Validator;

class MemberController extends Controller
{
    use HttpResponses;

         /**
     * Constructor
     *
     * @param Util $commonUtil
     * @return void
    */

    public function __construct(ModuleUtil $moduleUtil)
    {
        $this->moduleUtil = $moduleUtil;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function inserNewMember(Request $request)
    {
        \Log::info($request->all());
        try{
                $validator = Validator::make($request->all(), [
                                                                'member_first_name' => 'required|string',
                                                                'member_last_name' => 'required',
                                                                'member_email' => 'required|unique:members,member_email',
                                                                "business_id" => 'required',
                                                                // "uploadSignature" => 'required',
                                                                // "position_id" => 'required',
                                                                "member_profile_image" => 'required',
                                                            ]);
        
                if ($validator->fails()) {
                    return  $this->error('', $validator->errors(), 401);
                }
                if (!empty($request->uploadSignature)) {
                    $signatureName = 'member_signature_'.time().'_.png';
                    $signatureSelf = base64_decode($request->uploadSignature);
                    Storage::disk('signatures_uploads')->put($signatureName, $signatureSelf);
                }
                
                if (!empty($request->member_profile_image)) {
                    $file = $request->member_profile_image;
                    $imageName = time() . '.' . $file;
                    $imageSelf = base64_decode($request->imageSelf);
                    Storage::disk('public_uploads')->put($request->business_id . '/' . $imageName, $imageSelf);
                }

                // $member = $this->moduleUtil->createMember($request);
                
                $member = Member::create([
                                            "member_first_name" =>  $request->member_first_name,
                                            "member_middel_name" => $request->member_middel_name,
                                            // 'signature' => $request->uploadSignature,
                                            "member_last_name" =>  $request->member_last_name,
                                            "member_email" =>  $request->member_email,
                                            "is_active" =>  $request->is_active  == 1 ? true : false,
                                            "has_vote" =>  $request->has_vote  == 1 ? true : false,
                                            "business_id" =>  $request->business_id,
                                            "position_id" => $request->position_id,
                                            // "name_password" => $request->member_password ?? null,
                                            // "member_password" => Hash::make($request->member_password) ?? null,
                                            "member_profile_image" =>  $imageName ?? null,
                                            // "member_biography" =>  $request->member_biography ?? null,
                                        ]);
                $password_round = rand(120,127);
                $details = [
                                'surname' => $request->member_first_name,
                                'first_name' => $request->member_first_name,
                                'user_type' => 'member',
                                'member_id' => $member->id,
                                'last_name' => $request->member_last_name,
                                'username' => $request->member_first_name,
                                'business_id' =>  $request->business_id,
                                'email' => $request->member_email,
                                'name_password' => $password_round,
                                'password' => Hash::make($password_round),
                                'language' => 'ar'
                            ];                       
                $user = User::create_user($details);  
                // send email to member with password one time but need server config for email
                // Mail::to($user->email)->send(new WelcomeOneTimePasswordEmail($user));
                     
                if(!empty($request->board_id)){
                    $member->boards()->attach( $request->board_id );
                }
                if(!empty($request->committee_id)){
                    $member->committees()->sync( $request->committee_id );
                }
                // $role = Role::findOrFail((int) $request->role);
                // $member->assignRole($role);
                
                \Log::info($member->load('position'));
                return $this->success([
                    'member' => $member->load('position'),
                ]);
        }catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            return $this->error('', 'some thing occurs on create member !!!', 500);
        }
       
    }

    /**
     * fetch all members resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getListOfMember(Request $request)
    {
        \Log::info($request->business_id);
        $members = Member::where('business_id', $request->business_id)->with(['position','committees' => function($q){
            return $q->with(['business','board'=> function($q){return $q->with(['business']);}]);
        },'boards'=> function($e){return $e->with('business');},
        'criterias' => function($q){ return $q->with(['business','user']);}
        ])->get();

        if (!$members) {
            return $this->error('', 'there\'s not members found ', 401);
        }

        \Log::info($members);
        return $this->success([
            'members' => $members,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function show(Member $member)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function edit(Member $member)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Member $member)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function destroy(Member $member)
    {
        //
    }
}
