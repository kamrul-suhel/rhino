<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookingRequest extends FormRequest
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
            'date' => 'required|date',
            'event_id' => 'required|exists:events,id',
            'user_id' => 'exists:users,id',
            'guest_id' => 'exists:guests,id',
            'slot_id' => 'required|integer',
            'start' => 'required|date',
            'end' => 'required|date',
            'vehicles' => 'array'
        ];
    }
}
