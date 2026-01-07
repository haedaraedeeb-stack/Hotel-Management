<?php

namespace App\Http\Requests\Reservation;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class StoreReservationRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'room_id' => [
                'required',
                'integer',
                'exists:rooms,id',
                // Check if room is already booked for these dates
                function ($attribute, $value, $fail) {
                    if ($this->start_date && $this->end_date) {
                        $conflicting = \App\Models\Reservation::where('room_id', $value)
                            ->where(function ($query) {
                                $query->whereBetween('start_date', [$this->start_date, $this->end_date])
                                    ->orWhereBetween('end_date', [$this->start_date, $this->end_date])
                                    ->orWhere(function ($q) {
                                        $q->where('start_date', '<=', $this->start_date)
                                            ->where('end_date', '>=', $this->end_date);
                                    });
                            })
                            ->whereNotIn('status', ['cancelled', 'rejected'])
                            ->exists();

                        if ($conflicting) {
                            $fail('This room is already booked for the selected dates.');
                        }
                    }
                },
            ],

            'start_date' => [
                'required',
                'date',
                'after_or_equal:today',

            ],

            'end_date' => [
                'required',
                'date',
                'after:start_date',

            ],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'room_id.required' => 'Please select a room.',
            'room_id.exists' => 'Selected room does not exist.',

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
            'room_id' => 'room',
            'start_date' => 'check-in date',
            'end_date' => 'check-out date',
        ];
    }
}
