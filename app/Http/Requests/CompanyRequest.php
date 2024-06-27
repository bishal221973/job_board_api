<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CompanyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        if($this->id){
            return [
                'municipality_id'=>'required',
                'company_name'=>'required|unique:companies,company_name,'.$this->id,
                'tole'=>'required'
            ];
        }else{
            return [
                'municipality_id'=>'required',
                'company_name'=>'required|unique:companies,company_name',
                'tole'=>'required'
            ];
        }
    }

    public function failedValidation(Validator $validator){
        throw new HttpResponseException(response()->json([
            'success'=>false,
            'message'=> 'validation errors',
            'errors'=>$validator->errors()
        ]));
    }
}
