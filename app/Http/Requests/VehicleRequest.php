<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VehicleRequest extends FormRequest
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
            'model' => 'required',
            'brand_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'model.required' => 'Vehicle model is is required',
            'brand.required' => 'Brand field is required',
        ];
    }
}
