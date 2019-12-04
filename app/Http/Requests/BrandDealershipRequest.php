<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BrandDealershipRequest extends FormRequest
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
            'brand_id' => 'required|exists:brands,id',
            'dealership_id' => 'required|exists:dealerships,id',
            'region_id' => 'required|exists:regions,id'
        ];
    }
}
