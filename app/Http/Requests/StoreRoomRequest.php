<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class StoreRoomRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // يمكنك تغيير هذا بناءً على نظام المصادقة الخاص بك
        return true; // أو return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // Room Information
            'room_number' => [
                'required',
                'string',
                'max:20',
                Rule::unique('rooms', 'room_number'),
            ],

            'room_type_id' => [
                'required',
                'integer',
                'exists:room_types,id',
            ],

            'status' => [
                'required',
                'string',
                'in:available,occupied,maintenance',
            ],

            'price' => [
                'required',
                'numeric',
                'min:0',
                'max:999999.99',
            ],

            'floor' => [
                'required',
                'integer',
                'min:1',
                'max:100',
            ],

            'view' => [
                'nullable',
                'string',
                'max:50',
            ],

            'custom_view' => [
                'nullable',
                'required_if:view,other',
                'string',
                'max:100',
            ],

            // Images
            'images' => [
                'nullable',
                'array',
                'max:10',
            ],

            'images.*' => [
                'image',
                'mimes:jpeg,png,jpg',
                'max:5120', // 5MB
                'dimensions:min_width=100,min_height=100,max_width=5000,max_height=5000',
            ],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            // Room Number
            'room_number.required' => 'Room number is required.',
            'room_number.string' => 'Room number must be a valid string.',
            'room_number.max' => 'Room number may not be greater than :max characters.',
            'room_number.unique' => 'This room number is already in use. Please choose a different number.',

            // Room Type
            'room_type_id.required' => 'Room type is required.',
            'room_type_id.integer' => 'Room type must be a valid selection.',
            'room_type_id.exists' => 'The selected room type does not exist.',

            // Status
            'status.required' => 'Room status is required.',
            'status.string' => 'Room status must be a valid string.',
            'status.in' => 'Selected status is invalid. Valid options are: available, occupied, maintenance.',

            // Price
            'price.required' => 'Price per night is required.',
            'price.numeric' => 'Price must be a valid number.',
            'price.min' => 'Price must be at least :min SAR.',
            'price.max' => 'Price may not be greater than :max SAR.',

            // Floor
            'floor.required' => 'Floor number is required.',
            'floor.integer' => 'Floor must be a valid number.',
            'floor.min' => 'Floor must be at least :min.',
            'floor.max' => 'Floor may not be greater than :max.',

            // View
            'view.string' => 'Room view must be a valid string.',
            'view.max' => 'Room view may not be greater than :max characters.',
            'view.in' => 'Selected view is invalid. Valid options are: sea, city, mountain, pool, garden, other.',

            // Custom View
            'custom_view.required_if' => 'Custom view description is required when "Other" is selected.',
            'custom_view.string' => 'Custom view must be a valid string.',
            'custom_view.max' => 'Custom view may not be greater than :max characters.',

            // Images
            'images.array' => 'Images must be uploaded as an array.',
            'images.max' => 'You can upload a maximum of :max images.',

            'images.*.image' => 'Each file must be an image.',
            'images.*.mimes' => 'Only JPG, PNG, GIF, and WEBP images are allowed.',
            'images.*.max' => 'Each image may not be larger than :max kilobytes.',
            'images.*.dimensions' => 'Each image must be between 100x100 and 5000x5000 pixels.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'room_number' => 'room number',
            'room_type_id' => 'room type',
            'status' => 'room status',
            'price' => 'price per night',
            'floor' => 'floor',
            'view' => 'room view',
            'custom_view' => 'custom view description',
            'images' => 'room images',
            'images.*' => 'image',
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param \Illuminate\Validation\Validator $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // Additional validation for custom view when "other" is selected
            if ($this->input('view') === 'other' && empty($this->input('custom_view'))) {
                $validator->errors()->add('custom_view', 'Please provide a description for the custom view.');
            }
        });
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        // Trim whitespace from all string inputs
        $this->merge([
            'room_number' => trim($this->room_number ?? ''),
            'view' => $this->view ? trim($this->view) : null,
            'custom_view' => $this->custom_view ? trim($this->custom_view) : null,
        ]);

        // If view is "other", use custom_view as the view value
        if ($this->view === 'other' && $this->custom_view) {
            $this->merge([
                'view' => $this->custom_view,
            ]);
        }

        // Convert price to float if it's a string
        if ($this->has('price') && is_string($this->price)) {
            $this->merge([
                'price' => (float) str_replace(',', '', $this->price),
            ]);
        }
    }

    /**
     * Get the validated data from the request.
     *
     * @return array
     */
    public function validatedData()
    {
        $validated = $this->validated();

        // Map price to price_per_night for database
        if (isset($validated['price'])) {
            $validated['price_per_night'] = $validated['price'];
            unset($validated['price']);
        }

        // Remove custom_view from validated data as it's not in the database
        unset($validated['custom_view']);

        return $validated;
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param \Illuminate\Contracts\Validation\Validator $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        // You can customize the failed validation response here
        throw new \Illuminate\Validation\ValidationException($validator);
    }
}
