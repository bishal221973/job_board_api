<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
class MunicipalityRequest extends FormRequest
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
                'district_id'=>'required',
                'name'=> 'required|unique:municipalities,name,'.$this->id,
            ];
        }else{
            return [
                'district_id'=>'required',
                'name'=> 'required|unique:municipalities,name',
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
