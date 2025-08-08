<?php

namespace App\Http\Requests\Event;

use Illuminate\Foundation\Http\FormRequest;

class StoreEventRequest extends FormRequest
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
        return [
            "event_name" => "required|min:3|string",
            "latitude" => "required",
            "longtitude" => "required",
            "start_date" => "required|date",
            "end_date" => "required|date|after_or_equal:start_date",
            "available_tickets" => "required|min:0",
            "status" => "required",
        ];
    }
}
