<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRatingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'reservation_id' => 'required|exists:reservations,id',
            'score' => 'required|integer|min:1|max:5',
            'description' => 'nullable|string|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'reservation_id.required' => 'Reservaion is Required to make a Rating',
            'reservation_id.exists' => 'Reservation does not exist pal',
            'score.required' => 'Hey, adding score is required',
            'score.min' => 'Minimun score is 1 star (please dont D:)',
            'score.max' => 'Maximum score is 5 stars (yes :D)',
        ];
    }
}
