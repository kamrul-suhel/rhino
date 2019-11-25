<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DealershipRequest extends FormRequest
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
            'name' => 'required',
            'region' => 'required|exists:regions,id',
            'language_id' => 'sometimes|exists:languages,id'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Dealership name is is required',
            'regions.required' => 'Regions field is required',
            'language_id.required' => 'Language id is required'
        ];
    }
}
