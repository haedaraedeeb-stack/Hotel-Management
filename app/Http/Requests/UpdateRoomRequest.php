<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class UpdateRoomRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // يمكنك تغيير هذا بناءً على نظام المصادقة الخاص بك
        // مثال: return auth()->user()->can('update', $this->room);
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // Get the room ID from route parameter
        $roomId = $this->route('room');

        // If room is passed as object, get its ID
        if (is_object($roomId)) {
            $roomId = $roomId->id;
        }

        return [
            // Room Information
            'room_number' => [
                'nullable',
                'string',
                'max:20',
                Rule::unique('rooms', 'room_number')
                    ->ignore($roomId),
            ],

            'room_type_id' => [
                'nullable',
                'integer',
                'exists:room_types,id',
            ],

            'status' => [
                'nullable',
                'string',
                'in:available,occupied,maintenance',
            ],

            'price' => [
                'nullable',
                'numeric',
                'min:0',
                'max:999999.99',
            ],

            'floor' => [
                'nullable',
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

            // Images to delete
            'images_to_delete' => [
                'nullable',
                'array',
            ],

            'images_to_delete.*' => [
                'integer',
                'exists:images,id',
            ],

            // New images to upload
            'new_images' => [
                'nullable',
                'array',
                'max:10',
            ],

            'new_images.*' => [
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
            'room_number.string' => 'Room number must be a valid string.',
            'room_number.max' => 'Room number may not be greater than :max characters.',
            'room_number.unique' => 'This room number is already in use. Please choose a different number.',

            // Room Type
            'room_type_id.integer' => 'Room type must be a valid selection.',
            'room_type_id.exists' => 'The selected room type does not exist.',

            // Status
            'status.string' => 'Room status must be a valid string.',
            'status.in' => 'Selected status is invalid. Valid options are: available, occupied, maintenance.',

            // Price
            'price.numeric' => 'Price must be a valid number.',
            'price.min' => 'Price must be at least :min SAR.',
            'price.max' => 'Price may not be greater than :max SAR.',

            // Floor
            'floor.integer' => 'Floor must be a valid number.',
            'floor.min' => 'Floor must be at least :min.',
            'floor.max' => 'Floor may not be greater than :max.',

            // View
            'view.string' => 'Room view must be a valid string.',
            'view.max' => 'Room view may not be greater than :max characters.',

            // Custom View
            'custom_view.required_if' => 'Custom view description is required when "Other" is selected.',
            'custom_view.string' => 'Custom view must be a valid string.',
            'custom_view.max' => 'Custom view may not be greater than :max characters.',

            // Images to Delete
            'images_to_delete.array' => 'Images to delete must be an array.',
            'images_to_delete.*.integer' => 'Each image ID must be an integer.',
            'images_to_delete.*.exists' => 'One or more selected images do not exist.',

            // New Images
            'new_images.array' => 'New images must be uploaded as an array.',
            'new_images.max' => 'You can upload a maximum of :max new images.',

            'new_images.*.image' => 'Each new file must be an image.',
            'new_images.*.mimes' => 'Only JPG, PNG, GIF, and WEBP images are allowed.',
            'new_images.*.max' => 'Each new image may not be larger than :max kilobytes.',
            'new_images.*.dimensions' => 'Each new image must be between 100x100 and 5000x5000 pixels.',
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
            'images_to_delete' => 'images to delete',
            'images_to_delete.*' => 'image to delete',
            'new_images' => 'new images',
            'new_images.*' => 'new image',
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

            // Validate room number format (optional)
            $roomNumber = $this->input('room_number');
            if ($roomNumber && !preg_match('/^[A-Za-z0-9\-_ ]+$/', $roomNumber)) {
                $validator->errors()->add('room_number', 'Room number can only contain letters, numbers, spaces, hyphens, and underscores.');
            }

            // Validate price format (optional)
            $price = $this->input('price');
            if ($price && !preg_match('/^\d+(\.\d{1,2})?$/', $price)) {
                $validator->errors()->add('price', 'Price must be a valid number with up to 2 decimal places.');
            }

            // Check if trying to delete all images without adding new ones
            if ($this->has('images_to_delete')) {
                $room = $this->route('room');
                if (is_object($room) && method_exists($room, 'images')) {
                    $totalImages = $room->images->count();
                    $imagesToDeleteCount = count($this->input('images_to_delete', []));
                    $newImagesCount = count($this->file('new_images', []));


                }
            }

            // Check total images limit (existing + new - deleted)
            $room = $this->route('room');
            if (is_object($room) && method_exists($room, 'images')) {
                $existingImagesCount = $room->images->count();
                $imagesToDeleteCount = count($this->input('images_to_delete', []));
                $newImagesCount = count($this->file('new_images', []));

                $remainingImages = $existingImagesCount - $imagesToDeleteCount;
                $totalAfterUpdate = $remainingImages + $newImagesCount;

                if ($totalAfterUpdate > 20) {
                    $validator->errors()->add('new_images', 'Total images after update cannot exceed 20. You currently have ' . $existingImagesCount . ' images.');
                }
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
            'view' => $this->view ? trim($this->view) : null,
            'custom_view' => $this->custom_view ? trim($this->custom_view) : null,
            'images_to_delete' => $this->images_to_delete ? array_filter((array)$this->images_to_delete) : [],
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

        // Ensure images_to_delete is an array of integers
        if ($this->has('images_to_delete')) {
            $imagesToDelete = array_map('intval', (array)$this->images_to_delete);
            $this->merge([
                'images_to_delete' => array_values(array_filter($imagesToDelete)),
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

        // Ensure images_to_delete is always an array
        if (!isset($validated['images_to_delete'])) {
            $validated['images_to_delete'] = [];
        }

        // Ensure new_images is always an array
        if (!isset($validated['new_images'])) {
            $validated['new_images'] = [];
        }

        return $validated;
    }

    /**
     * Get additional validated data including room ID.
     *
     * @return array
     */
    public function validatedDataWithRoom()
    {
        $data = $this->validatedData();

        // Add room ID from route
        $roomId = $this->route('room');
        if (is_object($roomId)) {
            $data['room_id'] = $roomId->id;
        } else {
            $data['room_id'] = $roomId;
        }

        return $data;
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
        // For example, you can add additional context

        // Add room information to the response if available
        $room = $this->route('room');
        if (is_object($room)) {
            $validator->errors()->add('room_info', 'Updating room: #' . $room->room_number);
        }

        throw new \Illuminate\Validation\ValidationException($validator);
    }

    /**
     * Get the room being updated.
     *
     * @return \App\Models\Room|null
     */
    public function getRoom()
    {
        return $this->route('room');
    }

    /**
     * Check if any images are being updated.
     *
     * @return bool
     */
    public function hasImageUpdates(): bool
    {
        return $this->has('images_to_delete') || $this->hasFile('new_images');
    }

    /**
     * Get the count of images that will remain after update.
     *
     * @return int|null
     */
    public function getRemainingImagesCount(): ?int
    {
        $room = $this->getRoom();
        if (!$room || !method_exists($room, 'images')) {
            return null;
        }

        $existingCount = $room->images->count();
        $deleteCount = count($this->input('images_to_delete', []));
        $newCount = count($this->file('new_images', []));

        return ($existingCount - $deleteCount) + $newCount;
    }
}
