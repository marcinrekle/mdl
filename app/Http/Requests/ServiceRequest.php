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
            'name' => ['required', 'min:1', 'max:128',$this->getMethod() == 'POST' ? 'unique:services' : Rule::unique('services')->ignore($this->service->id)],
            'slug' => ['required','string','max:64',$this->getMethod() == 'POST' ? 'unique:services' : Rule::unique('services')->ignore($this->service->id)],
            'description' =>'required|string',
            'defaults' => 'required'
        ];

        return $rules;
    }
}
