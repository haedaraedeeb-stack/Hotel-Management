<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class UpdateReservationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // $reservation = $this->route('api_reservation');
        // return $reservation && $reservation->user_id == auth('sanctum')->id();

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {

        return [
            'user_id' => 'nullable|integer|exists:users,id',
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
                            ->where('status', [ 'confirmed'])
                            ->where('id', '!=', $this->route('reservation')->id)
                            ->exists();

                        if ($conflicting) {
                            $fail('This room is already booked for the selected dates.');
                        }
                    }
                },
            ],

            'start_date' => [
                'nullable',
                'date',
            ],

            'end_date' => [
                'nullable',
                'date',
                'after:start_date',
            ],

            'status' => [
                'nullable',
                Rule::in(['pending','completed']),
            ],

            'check_in' => [
                'nullable',
                'date',
                'after_or_equal:start_date',
            ],

            'check_out' => [
                'nullable',
                'date',
                'after:check_in',
            ],

        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'user_id.integer' => 'User ID must be an integer.',
            'user_id.exists' => 'User does not exist',
            
            'room_id.exists' => 'Room does not exist',
            'room_id.integer' => 'Room ID must be an integer.',

            'start_date.required' => 'start_date date is required',
            'start_date.date' => 'Invalid start_date date',

            'end_date.required' => 'end_date date is required',
            'end_date.date' => 'Invalid end_date date',
            'end_date.after' => 'end_date date must be after check-in date',

            // 'status.in' => 'Invalid status value.',

            'check_in.date' => 'Invalid check-in date',
            'check_out.date' => 'Invalid check-out date',
            'check_out.after' => 'Check-out date must be after check-in date',

        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'user_id' => 'user',
            'room_id' => 'room number',
            'start_date' => 'start_date date',
            'end_date' => 'end_date date',
            'status' => 'status',
            'check_in' => 'check-in date',
            'check_out' => 'check-out date',
        ];
    }


}
