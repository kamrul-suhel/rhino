<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventRequest extends FormRequest
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
            'greeting' => 'required',
            'dealership_id' => 'required|exists:dealerships,id',
            'type_id' => 'required|exists:types,id',
            'start' => 'required|date',
            'end'=> 'required|date'
        ];
    }
}
