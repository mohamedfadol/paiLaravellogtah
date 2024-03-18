<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommitteeRequest extends FormRequest
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
            'committee_name' => ['required'],
            'charter_committee' => ['required'],
            // 'board_id' => ['required'],
            // 'business_id' => ['required'],
            // ['required', 'mimes:pdf,csv,xls,xlsx,doc,docx','mimes:pdf,csv,xls,xlsx,doc,docx'],
            // 'business_id' => ['required', 'integer'],
        ];
    }
}
