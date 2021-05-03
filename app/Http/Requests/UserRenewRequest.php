<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRenewRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'fault.*' => 'boolean',
            'time.*' => 'boolean',
            'timeframe' => 'numeric|max:999',
            'selectorder' => 'required|string|max:30|in:normal,reverse,random'
        ];
    }

    public function messages()
    {
        return [
            'selectorder.required' => 'Selecteer de volgorde',
            'selectorder.in' => 'Alleen toegestaan:normal,reverse,random'
        ];
    }

}  //end class
