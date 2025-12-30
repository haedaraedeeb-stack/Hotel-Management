<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoomTypeFilterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // الزائر والزبون مسموح لهم
    }

    public function rules(): array
    {
        return [
            'search'     => 'nullable|string|max:255',
            'order_by'   => 'nullable|in:type,base_price',
            'direction'  => 'nullable|in:asc,desc',
        ];
    }

    /**
     * معالجة الاستجابة في حال الفشل
     * بدل ما يطلع 422، نرجع JSON فارغ أو رسالة مناسبة
     */
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $response = response()->json([
            'data' => [],
            'message' => 'Invalid filter parameters',
            'errors' => $validator->errors(),
        ], 422);

        throw new \Illuminate\Validation\ValidationException($validator, $response);
    }
}