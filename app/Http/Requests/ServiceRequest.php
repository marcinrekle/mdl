<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ServiceRequest extends FormRequest
{
    
     /**
     * Transform the error messages into JSON
     *
     * @param array $errors
     * @return \Illuminate\Http\JsonResponse
     */
    public function response(array $errors)
    {
        return response()->json($errors, 422);
    }

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
        $rules = [
            'name' => ['required', 'min:3', 'max:256',$this->getMethod() == 'POST' ? 'unique:services' : Rule::unique('services')->ignore($this->service->id)],
            'slug' => 'string',
            'description' =>'string',
            //'defaults' => ''
        ];

        return $rules;
    }
}
