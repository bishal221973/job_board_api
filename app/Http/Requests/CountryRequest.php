<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
class CountryRequest extends FormRequest
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
        $id = $this->id;
        if($id){
            return [
                'country_code'=>'required|unique:countries,country_code,'.$id,
                'name'=>'required|unique:countries,name,'.$id,
            ];
        }else{
            return [
                'country_code'=>'required|unique:countries,country_code',
                'name'=>'required|unique:countries,name',
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
