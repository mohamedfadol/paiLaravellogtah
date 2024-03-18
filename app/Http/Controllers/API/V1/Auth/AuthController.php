<?php

namespace App\Http\Controllers\API\V1\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\StoreUserRequest;

class AuthController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response of login
     */
    public function login(LoginUserRequest $request)
    {
        try{
            \Log::info($request->token);
            // \Log::info($request->email);
            $request->validated($request->only(['email', 'password']));
    
            if(!Auth::attempt($request->only(['email', 'password']))) {
                return $this->error('', 'Your Credentials Do Not Match Password or E-mail', 401);
            }
    
            $user = User::where('email', $request->email)->first();
            $user->update(['fcm' => $request->token]);
            return $this->success([
                'user' => $user,
                'token' => $user->createToken('APIDiligovToken')->plainTextToken
            ]);
        }catch (\Exception $e) {
                \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
                return $this->error('', 'some thing occurs on user login !!!', 500);
        }
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response of register
    */
    public function register(StoreUserRequest $request)
    {
        $request->validated($request->all());
        //Create owner.

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'name_password' => $request->password,
            'password' => Hash::make($request->password),
        ]);
        return $this->success([
            'user' => $user,
            'token' => $user->createToken('API Token')->plainTextToken
              ]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response of logout
    */
    public function logout()
    {
        Auth::user()->currentAccessToken()->delete();

        return $this->success([
            'message' => 'You have succesfully been logged out and your token has been removed'
        ]);
    }

}
