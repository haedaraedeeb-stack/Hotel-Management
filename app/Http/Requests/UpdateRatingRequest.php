<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRatingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'score' => 'required|integer|min:1|max:5',
            'description' => 'nullable|string|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'score.required' => 'adding score is required',
            'score.min' => 'Minimun score is 1 star',
            'score.max' => 'Maximum score is 5 stars',
        ];
    }
}
