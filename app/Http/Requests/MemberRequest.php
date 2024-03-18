<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MemberRequest extends FormRequest
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
     * ['required', 'mimes:pdf,csv,xls,xlsx,doc,docx','mimes:pdf,csv,xls,xlsx,doc,docx'],
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'member_first_name' => ['required'],
            'member_last_name' => ['required'],
            'member_email' => ['required'],
            'member_password' => ['required'],            
            'is_active' => ['required'],
            'has_vote' => ['required'],
        ];
    }
}
