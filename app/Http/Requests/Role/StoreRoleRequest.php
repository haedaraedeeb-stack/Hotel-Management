<?php

namespace App\Http\Requests\Role;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StoreRoleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:100',
                'min:3',
                'unique:roles,name',
                'regex:/^[a-zA-Z0-9\s\-_]+$/'
            ],
            
            'permission' => [
                'required',
                'array',
                'min:1',
                'max:100'
            ],
            
            'permission.*' => [
                'required',
                'string',
                'exists:permissions,name'
            ],
            
            'guard_name' => [
                'sometimes',
                'string',
                Rule::in(['web', 'api'])
            ]
        ];
    }

    /**
     * Custom error messages
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Role name is required',
            'name.max' => 'Role name must not exceed 100 characters',
            'name.min' => 'Role name must be at least 3 characters',
            'name.regex' => 'Role name can only contain letters, numbers, spaces, hyphens, and underscores',
            'name.unique' => 'This role name already exists',
            
            'permission.required' => 'At least one permission is required',
            'permission.min' => 'At least one permission must be selected',
            'permission.max' => 'Maximum 100 permissions can be selected',
            
            'permission.*.required' => 'Permission ID is required',
            'permission.*.string' => 'Permission ID must be a string',
            'permission.*.exists' => 'Selected permission does not exist in the system',
            
            
            'guard_name.in' => 'Guard name must be either web or api'
        ];
    }

    /**
     * Custom attribute names
     */
    public function attributes(): array
    {
        return [
            'name' => 'role name',
            'permission' => 'permissions',
            'description' => 'description',
            'guard_name' => 'guard name'
        ];
    }

    /**
     * Prepare the data for validation
     */
    protected function prepareForValidation(): void
    {
        // Trim and format role name
        if ($this->has('name')) {
            $this->merge([
                'name' => trim($this->name)
            ]);
        }
        
        // Ensure permission is an array
        if ($this->has('permission') && !is_array($this->permission)) {
            $this->merge([
                'permission' => (array) $this->permission
            ]);
        }
        
        // Set default guard_name if not provided
        if (!$this->has('guard_name') || empty($this->guard_name)) {
            $this->merge([
                'guard_name' => 'web'
            ]);
        }
        
        // Convert permission IDs to integers
        // if ($this->has('permission') && is_array($this->permission)) {
        //     $this->merge([
        //         'permission' => array_map('intval', $this->permission)
        //     ]);
        // }
    }

    /**
     * After validation passes
     */
    public function passedValidation(): void
    {
        // Additional processing can be added here
        // For example: format the role name
        if ($this->has('name')) {
            $this->merge([
                'name' => ucwords(strtolower(trim($this->name)))
            ]);
        }
    }
}