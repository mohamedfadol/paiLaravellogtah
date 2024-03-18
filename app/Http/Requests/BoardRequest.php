<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BoardRequest extends FormRequest
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
            "term" => ['required'],
            "quorum" => ['required'],
            "fiscal_year" => ['required'],
            "board_name" => ['required'],
            "charter_board" => ['required'],
            "imageSelf" => ['required'],
            "business_id" => ['required'],
        ];
    }
}
