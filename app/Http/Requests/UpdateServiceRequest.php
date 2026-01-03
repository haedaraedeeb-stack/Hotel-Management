<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateServiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $serviceId = $this->route('service')->id;

        return [
            'name' => 'required|string|max:255|unique:services,name,' . $serviceId,
            'description' => 'nullable|string',
            'room_types' => 'nullable|array',
            'room_types.*' => 'exists:room_types,id',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Service name required ',
            'name.unique' => 'The service name already exists',
        ];
    }
}