<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserCreationRequest extends FormRequest
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
            'table1.*' => 'in:true,false,0,1',
            'table2.*' => 'sometimes|boolean',
            'table3.*' => 'sometimes|boolean',
            'table4.*' => 'sometimes|boolean',
            'table5.*' => 'sometimes|boolean',
            'table6.*' => 'sometimes|boolean',
            'table7.*' => 'sometimes|boolean',
            'table8.*' => 'sometimes|boolean',
            'table9.*' => 'sometimes|boolean',
            'table10.*' => 'sometimes|boolean',
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

} //end class
