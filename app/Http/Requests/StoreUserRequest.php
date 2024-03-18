<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Validation\Rules;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['required','max:255'],
            // 'country' => ['required','max:255'],
            // 'state' => ['required','max:255'],
            // 'city' => ['required','max:255'],
            // 'zip_code' => ['required','max:255'],
            // 'time_zone' => ['required','max:255'],
            // 'surname' => ['max:10'],
            // 'first_name' => ['required','max:255'],
            // 'username' => ['required','min:4','max:255','unique:users'],
            // 'password' => ['required','min:4','max:255','same:password_confirmation'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
         ];
    }
}
