<?php

namespace App\Http\Requests\Role;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class UpdateRoleRequest extends FormRequest
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
        $roleId = $this->route('role');
        
        // If route parameter is a string (ID), convert it to integer
        // If it's already a model instance, get the ID
        if ($roleId instanceof Role) {
            $roleId = $roleId->id;
        }
        
        return [
            'name' => [
                'nullable',
                'string',
                'max:50',
                'min:3',
                Rule::unique('roles', 'name')->ignore($roleId),
                'regex:/^[a-zA-Z0-9\s\-_]+$/'
            ],
            
            'permission' => [
                'nullable',
                'array',
                'max:50'
            ],
            
            'permission.*' => [
                'nullable',
                'string',
                Rule::exists('permissions', 'name')
            ],
            
            'guard_name' => [
                'sometimes',
                'string',
                Rule::in(['web', 'api'])
            ]
        ];
    }

    /**
     * Get custom error messages
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Role name is required',
            'name.max' => 'Role name must not exceed 50 characters',
            'name.min' => 'Role name must be at least 3 characters',
            'name.regex' => 'Role name can only contain English letters, numbers, spaces, hyphens, or underscores',
            'name.unique' => 'This role name is already taken',
            
            'permission.required' => 'At least one permission must be selected',
            'permission.max' => 'Cannot select more than 50 permissions',
            
            'permission.*.exists' => 'The selected permission does not exist in the system',
            
            'description.max' => 'Description must not exceed 500 characters',
            
            'guard_name.in' => 'Guard name must be either web or api'
        ];
    }

    /**
     * Get custom attribute names
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
     * Prepare data for validation
     */
    protected function prepareForValidation(): void
    {
        // Trim role name
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
    }

    /**
     * Additional validation after basic rules
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $roleId = $this->route('role');
            
            // Get role instance
            $role = $roleId instanceof Role ? $roleId : Role::find($roleId);
            
            if (!$role) {
                $validator->errors()->add('role', 'Role not found');
                return;
            }
            
            // Prevent changing name of protected roles
            $protectedRoles = ['super-admin', 'admin', 'owner', 'system'];
            if (in_array($role->name, $protectedRoles) && $this->name !== $role->name) {
                $validator->errors()->add('name', 'Cannot change the name of this protected role');
            }

            //Prevent removing permissions from protected roles
            if (in_array($role->name, $protectedRoles) && $this->has('permission')) {
                $currentPermissions = $role->permissions->pluck('name')->toArray();
                $newPermissions = $this->permission;
                $removedPermissions = array_diff($currentPermissions, $newPermissions);
                if (!empty($removedPermissions)) {
                    $validator->errors()->add('permission', 'Cannot remove permissions from the protected role: ' . implode(', ', $removedPermissions));
                }
            }
            
            // Check that not all permissions are removed
            // if (empty($this->permission)) {
            //     $validator->errors()->add('permission', 'Cannot remove all permissions from the role');
            // }
        });
    }
}