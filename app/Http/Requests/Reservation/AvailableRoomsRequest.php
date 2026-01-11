<?php

namespace App\Http\Requests\Reservation;

use Illuminate\Foundation\Http\FormRequest;

class AvailableRoomsRequest extends FormRequest
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
   /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [

            'start_date' => [
                'required',
                'date',
                // 'after_or_equal:today',

            ],

            'end_date' => [
                'required',
                'date',
                'after:start_date',

            ],

            'reservation_id' => 'nullable|exists:reservations,id',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'start_date.required' => 'Check-in date is required.',
            'start_date.date' => 'Invalid check-in date.',
            'start_date.after_or_equal' => 'Check-in date must be today or later.',

            'end_date.required' => 'Check-out date is required.',
            'end_date.date' => 'Invalid check-out date.',
            'end_date.after' => 'Check-out date must be after check-in date.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'start_date' => 'check-in date',
            'end_date' => 'check-out date',
        ];
    }
}
