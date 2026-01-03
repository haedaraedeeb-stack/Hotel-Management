<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Role - Hotel</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    
    <style>
        :root {
            --primary-color: #4e73df;
            --success-color: #1cc88a;
            --warning-color: #f6c23e;
            --danger-color: #e74a3b;
            --info-color: #36b9cc;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', 'Tahoma', 'Geneva', 'Verdana', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            padding: 20px;
            color: #333;
        }
        
        .container-main {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        
        .header-section {
            background: linear-gradient(90deg, var(--primary-color), #6e8efb);
            color: white;
            padding: 25px 30px;
            border-radius: 15px 15px 0 0;
            position: relative;
            overflow: hidden;
        }
        
        .header-section::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 1%, transparent 20%);
        }
        
        .page-title {
            font-weight: 700;
            margin-bottom: 5px;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.2);
            position: relative;
            z-index: 1;
        }
        
        .page-subtitle {
            opacity: 0.9;
            font-size: 1rem;
            position: relative;
            z-index: 1;
        }
        
        .back-button {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.3);
            padding: 8px 20px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        
        .back-button:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateX(3px);
        }
        
        .form-section {
            padding: 30px;
        }
        
        .form-card {
            background: white;
            border-radius: 12px;
            border: 1px solid #e3e6f0;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }
        
        .form-card-title {
            color: var(--primary-color);
            font-weight: 600;
            margin-bottom: 20px;
            padding-bottom: 12px;
            border-bottom: 2px solid #f0f2f7;
            display: flex;
            align-items: center;
        }
        
        .form-card-title i {
            margin-right: 10px;
        }
        
        .form-label {
            font-weight: 600;
            color: #555;
            margin-bottom: 8px;
        }
        
        .form-control, .form-select {
            border: 2px solid #e3e6f0;
            border-radius: 8px;
            padding: 10px 15px;
            transition: all 0.3s ease;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(78, 115, 223, 0.15);
        }
        
        .form-text {
            font-size: 0.85rem;
            color: #6c757d;
        }
        
        .required-field::after {
            content: " *";
            color: var(--danger-color);
        }
        
        /* Permission Categories */
        .permission-categories {
            margin-top: 20px;
        }
        
        .category-card {
            border: 1px solid #e3e6f0;
            border-radius: 8px;
            margin-bottom: 15px;
            overflow: hidden;
        }
        
        .category-header {
            background: #f8f9fc;
            padding: 15px 20px;
            border-bottom: 1px solid #e3e6f0;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .category-header:hover {
            background: #e9ecef;
        }
        
        .category-header.active {
            background: var(--primary-color);
            color: white;
        }
        
        .category-title {
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .category-icon {
            transition: transform 0.3s ease;
        }
        
        .category-header.active .category-icon {
            transform: rotate(180deg);
        }
        
        .category-body {
            padding: 20px;
            background: white;
            display: none;
        }
        
        .category-body.active {
            display: block;
        }
        
        .permission-item {
            margin-bottom: 10px;
            padding: 10px;
            border-radius: 6px;
            transition: all 0.3s ease;
        }
        
        .permission-item:hover {
            background: #f8f9fc;
        }
        
        .permission-checkbox {
            margin-right: 10px;
        }
        
        .permission-label {
            font-weight: 500;
            cursor: pointer;
            display: flex;
            align-items: center;
        }
        
        .permission-description {
            font-size: 0.85rem;
            color: #6c757d;
            margin-left: 30px;
            margin-top: 5px;
        }
        
        /* Select All Section */
        .select-all-section {
            background: #f8f9fc;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            border: 1px solid #e3e6f0;
        }
        
        /* Quick Select Buttons */
        .quick-select-buttons {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-bottom: 20px;
        }
        
        .quick-select-btn {
            background: white;
            border: 1px solid #e3e6f0;
            border-radius: 6px;
            padding: 8px 15px;
            font-size: 0.85rem;
            font-weight: 500;
            color: #555;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .quick-select-btn:hover {
            background: #f8f9fc;
            border-color: var(--primary-color);
        }
        
        .quick-select-btn.active {
            background: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }
        
        /* Permission Badges */
        .permission-badge {
            font-size: 0.75rem;
            padding: 4px 10px;
            border-radius: 15px;
            margin: 2px;
            background: #e9ecef;
            color: #495057;
            display: inline-block;
        }
        
        .permission-badge-create {
            background: rgba(28, 200, 138, 0.15);
            color: var(--success-color);
        }
        
        .permission-badge-read {
            background: rgba(78, 115, 223, 0.15);
            color: var(--primary-color);
        }
        
        .permission-badge-update {
            background: rgba(246, 194, 62, 0.15);
            color: var(--warning-color);
        }
        
        .permission-badge-delete {
            background: rgba(231, 74, 59, 0.15);
            color: var(--danger-color);
        }
        
        /* Selected Permissions Preview */
        .selected-permissions {
            margin-top: 20px;
            padding: 15px;
            background: #f8f9fc;
            border-radius: 8px;
            border: 1px solid #e3e6f0;
        }
        
        .selected-count {
            display: inline-block;
            background: var(--info-color);
            color: white;
            padding: 2px 10px;
            border-radius: 15px;
            font-size: 0.85rem;
            margin-left: 10px;
        }
        
        /* Form Actions */
        .form-actions {
            background: #f8f9fc;
            padding: 25px;
            border-top: 1px solid #e3e6f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-radius: 0 0 15px 15px;
        }
        
        .btn-submit {
            background: linear-gradient(90deg, var(--success-color), #20d9a3);
            color: white;
            border: none;
            padding: 12px 40px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(28, 200, 138, 0.3);
        }
        
        .btn-submit:disabled {
            background: #6c757d;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }
        
        .btn-cancel {
            background: white;
            color: #6c757d;
            border: 2px solid #e3e6f0;
            padding: 10px 30px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-cancel:hover {
            border-color: var(--danger-color);
            color: var(--danger-color);
        }
        
        /* Loading Animation */
        .spinner {
            display: inline-block;
            width: 1rem;
            height: 1rem;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 1s ease-in-out infinite;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        /* Validation Styles */
        .is-invalid {
            border-color: var(--danger-color) !important;
        }
        
        .invalid-feedback {
            color: var(--danger-color);
            font-size: 0.85rem;
            margin-top: 5px;
        }
        
        /* Responsive Design */
        @media (max-width: 768px) {
            .container-main {
                margin: 10px;
                border-radius: 10px;
            }
            
            .header-section {
                padding: 20px;
            }
            
            .form-section {
                padding: 20px;
            }
            
            .form-actions {
                flex-direction: column;
                gap: 15px;
            }
            
            .btn-submit, .btn-cancel {
                width: 100%;
            }
            
            .quick-select-buttons {
                flex-direction: column;
            }
            
            .quick-select-btn {
                width: 100%;
            }
        }
        
        /* Permission Groups */
        .permission-group {
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid #e3e6f0;
        }
        
        .permission-group:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }
        
        .group-title {
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 10px;
            font-size: 1.1rem;
        }
        
        /* Custom Select2 Styles */
        .select2-container--default .select2-selection--multiple {
            border: 2px solid #e3e6f0;
            border-radius: 8px;
            min-height: 45px;
        }
        
        .select2-container--default .select2-selection--multiple:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(78, 115, 223, 0.15);
        }
        
        .select2-container--default.select2-container--focus .select2-selection--multiple {
            border-color: var(--primary-color);
        }
        
        /* Tips Section */
        .tips-section {
            background: #e8f4fd;
            border-left: 4px solid var(--info-color);
            padding: 15px;
            border-radius: 8px;
            margin-top: 20px;
        }
        
        .tips-title {
            color: var(--info-color);
            font-weight: 600;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container-main">
        <!-- Header Section -->
        <div class="header-section">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                <div class="mb-3 mb-md-0">
                    <h1 class="page-title">
                        <i class="fas fa-plus-circle me-2"></i>
                        Create New Role
                    </h1>
                    <p class="page-subtitle">Define a new role with specific permissions for the system</p>
                </div>
                <div>
                    {{-- <a href="{{ route('roles.index') }}" class="btn back-button">
                        <i class="fas fa-arrow-left me-2"></i>Back to Roles
                    </a> --}}
                </div>
            </div>
        </div>

        <!-- Messages Section -->
        @if ($errors->any())
            <div class="alert alert-danger m-4">
                <div class="d-flex align-items-center">
                    <i class="fas fa-exclamation-triangle fa-lg me-3"></i>
                    <div>
                        <h5 class="alert-heading mb-2">Please correct the following errors:</h5>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <!-- Tips Section -->
        {{-- <div class="form-section">
            <div class="tips-section">
                <h6 class="tips-title"><i class="fas fa-lightbulb me-2"></i>Tips for Creating Roles</h6>
                <ul class="mb-0">
                    <li>Use descriptive role names (e.g., "Hotel Manager", "Reception Staff")</li>
                    <li>Assign only necessary permissions to each role (Principle of Least Privilege)</li>
                    <li>Consider creating role templates for common positions</li>
                    <li>Test roles in a development environment before production use</li>
                </ul>
            </div>
        </div> --}}

        <!-- Main Form -->
        <form action="{{ route('roles.store') }}" method="POST" id="roleForm">
            @csrf
            
            <div class="form-section">
                <!-- Basic Information Card -->
                <div class="form-card">
                    <h3 class="form-card-title">
                        <i class="fas fa-info-circle"></i>
                        Basic Information
                    </h3>
                    
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="name" class="form-label required-field">Role Name</label>
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name') }}"
                                   required
                                   placeholder="e.g., Hotel Manager, Reception Staff, Housekeeping Supervisor">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                Use a descriptive name that clearly indicates the role's purpose
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Permissions Management Card -->
                <div class="form-card">
                    <h3 class="form-card-title">
                        <i class="fas fa-key"></i>
                        Role Permissions
                    </h3>
                    
                    <!-- Quick Select Buttons -->
                    <div class="select-all-section">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="selectAllPermissions">
                            <label class="form-check-label" for="selectAllPermissions">
                                <strong>Select All Permissions</strong>
                            </label>
                        </div>
                    </div>
                    
                    <!-- Quick Select Templates -->
                    {{-- <div class="quick-select-buttons">
                        <button type="button" class="quick-select-btn" data-template="admin">
                            <i class="fas fa-crown me-2"></i>Admin Template
                        </button>
                        <button type="button" class="quick-select-btn" data-template="manager">
                            <i class="fas fa-user-tie me-2"></i>Manager Template
                        </button>
                        <button type="button" class="quick-select-btn" data-template="staff">
                            <i class="fas fa-users me-2"></i>Staff Template
                        </button>
                        <button type="button" class="quick-select-btn" data-template="viewer">
                            <i class="fas fa-eye me-2"></i>Viewer Template
                        </button>
                        <button type="button" class="quick-select-btn" data-template="clear">
                            <i class="fas fa-times me-2"></i>Clear All
                        </button>
                    </div> --}}
                    
                    <!-- Categorized Permissions -->
                    <div class="permission-categories">
                        @php
                            // Group permissions by resource type
                            $groupedPermissions = [];
                            foreach ($permission as $perm) {
                                $parts = explode(' ', $perm->name);
                                if (count($parts) >= 2) {
                                    $action = $parts[0];
                                    $resource = implode(' ', array_slice($parts, 1));
                                    $resourceKey = str_replace(['-', '_'], ' ', $resource);
                                    $groupedPermissions[$resourceKey][] = [
                                        'id' => $perm->id,
                                        'name' => $perm->name,
                                        'action' => $action,
                                        'resource' => $resource
                                    ];
                                } else {
                                    $groupedPermissions[' '][] = [
                                        'id' => $perm->id,
                                        'name' => $perm->name,
                                        'action' => '',
                                        'resource' => $perm->name
                                    ];
                                }
                            }
                        @endphp
                        
                        @foreach($groupedPermissions as $resource => $permissions)
                            @php
                                $categoryId = 'category-' . \Illuminate\Support\Str::slug($resource);
                                $isFirst = $loop->first;
                            @endphp
                            
                            <div class="category-card">
                                <div class="category-header {{ $isFirst ? 'active' : '' }}" data-category="{{ $categoryId }}">
                                    <div class="category-title">
                                        <span>
                                            <i class="fas fa-folder me-2"></i>
                                            {{ ucfirst($resource) }}
                                            <span class="selected-count" id="count-{{ $categoryId }}">0</span>
                                        </span>
                                        <i class="fas fa-chevron-down category-icon"></i>
                                    </div>
                                </div>
                                
                                <div class="category-body {{ $isFirst ? 'active' : '' }}" id="{{ $categoryId }}">
                                    <div class="permission-group">
                                        <div class="group-title">
                                            <i class="fas fa-cogs me-2"></i>
                                            {{ ucfirst($resource) }} Permissions
                                        </div>
                                        
                                        @foreach($permissions as $perm)
                                            @php
                                                $badgeClass = 'permission-badge';
                                                if (str_contains($perm['action'], 'create')) {
                                                    $badgeClass .= ' permission-badge-create';
                                                } elseif (str_contains($perm['action'], 'view') || str_contains($perm['action'], 'read')) {
                                                    $badgeClass .= ' permission-badge-read';
                                                } elseif (str_contains($perm['action'], 'edit') || str_contains($perm['action'], 'update')) {
                                                    $badgeClass .= ' permission-badge-update';
                                                } elseif (str_contains($perm['action'], 'delete')) {
                                                    $badgeClass .= ' permission-badge-delete';
                                                }
                                            @endphp
                                            
                                            <div class="permission-item">
                                                <div class="form-check">
                                                    <input type="checkbox" 
                                                           class="form-check-input permission-checkbox" 
                                                           name="permission[]" 
                                                           value="{{ $perm['name'] }}" 
                                                           id="perm_{{ $perm['id'] }}"
                                                           data-category="{{ $categoryId }}"
                                                           data-action="{{ $perm['action'] }}">
                                                    <label class="permission-label" for="perm_{{ $perm['id'] }}">
                                                        <span class="{{ $badgeClass }} me-2">
                                                            {{ ucfirst($perm['action']) }}
                                                        </span>
                                                        {{ ucfirst(str_replace(['-', '_'], ' ', $perm['resource'])) }}
                                                    </label>
                                                    <div class="permission-description">
                                                        Allows user to {{ $perm['action'] }} {{ str_replace(['-', '_'], ' ', $perm['resource']) }} in the system
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <!-- Selected Permissions Preview -->
                    {{-- <div class="selected-permissions">
                        <h6 class="mb-3">
                            <i class="fas fa-check-circle me-2 text-success"></i>
                            Selected Permissions
                            <span class="selected-count" id="totalSelectedCount">0</span>
                        </h6>
                        <div id="selectedPermissionsList">
                            <p class="text-muted mb-0">No permissions selected yet. Choose permissions from the categories above.</p>
                        </div>
                    </div> --}}
                </div>

                <!-- Summary Card -->
                <div class="form-card">
                    <h3 class="form-card-title">
                        <i class="fas fa-eye"></i>
                        Role Summary
                    </h3>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Role Name:</label>
                                <div class="form-control-plaintext" id="previewRoleName">
                                    <span class="text-muted">Not specified</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Total Permissions:</label>
                                <div class="form-control-plaintext">
                                    <span class="badge bg-primary" id="previewPermissionCount">0</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Permission Categories:</label>
                        <div id="previewCategories" class="mt-2">
                            <span class="text-muted">No categories selected</span>
                        </div>
                    </div>
                    
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Note:</strong> After creating this role, you can assign it to users in the User Management section.
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="form-actions">
                <div>
                    <button type="button" class="btn btn-cancel" onclick="window.location.href='{{ route('roles.index') }}'">
                        <i class="fas fa-times me-2"></i>Cancel
                    </button>
                </div>
                <div>
                    <button type="submit" class="btn btn-submit" id="submitBtn">
                        <i class="fas fa-save me-2"></i>
                        <span id="submitText">Create Role</span>
                        <span id="submitSpinner" style="display: none;">
                            <span class="spinner me-2"></span>Creating...
                        </span>
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- JavaScript Libraries -->
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    
    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            // Initialize Select2 for permission selection
            $('#permissionSelect').select2({
                placeholder: 'Select permissions for this role',
                allowClear: true,
                width: '100%'
            });
            
            // Category toggle functionality
            $('.category-header').on('click', function() {
                const categoryId = $(this).data('category');
                const $categoryBody = $('#' + categoryId);
                const $categoryIcon = $(this).find('.category-icon');
                
                // Toggle active class
                $(this).toggleClass('active');
                $categoryBody.toggleClass('active');
                
                // Rotate icon
                if ($(this).hasClass('active')) {
                    $categoryIcon.css('transform', 'rotate(180deg)');
                } else {
                    $categoryIcon.css('transform', 'rotate(0deg)');
                }
            });
            
            // Select All Permissions checkbox
            $('#selectAllPermissions').on('change', function() {
                const isChecked = $(this).is(':checked');
                $('.permission-checkbox').prop('checked', isChecked);
                updatePermissionCounts();
                updatePreview();
            });
            
            // Individual permission checkbox handler
            $('.permission-checkbox').on('change', function() {
                updatePermissionCounts();
                updatePreview();
                
                // Update select all checkbox state
                const totalCheckboxes = $('.permission-checkbox').length;
                const checkedCheckboxes = $('.permission-checkbox:checked').length;
                $('#selectAllPermissions').prop('checked', totalCheckboxes === checkedCheckboxes);
            });
            
            // Quick select templates
            $('.quick-select-btn').on('click', function() {
                const template = $(this).data('template');
                
                switch(template) {
                    case 'admin':
                        // Select all permissions
                        $('.permission-checkbox').prop('checked', true);
                        break;
                        
                    case 'manager':
                        // Select view, create, edit permissions but not delete
                        $('.permission-checkbox').each(function() {
                            const action = $(this).data('action');
                            if (action.includes('delete')) {
                                $(this).prop('checked', false);
                            } else {
                                $(this).prop('checked', true);
                            }
                        });
                        break;
                        
                    case 'staff':
                        // Select only view and create permissions
                        $('.permission-checkbox').each(function() {
                            const action = $(this).data('action');
                            if (action.includes('view') || action.includes('read') || action.includes('create')) {
                                $(this).prop('checked', true);
                            } else {
                                $(this).prop('checked', false);
                            }
                        });
                        break;
                        
                    case 'viewer':
                        // Select only view permissions
                        $('.permission-checkbox').each(function() {
                            const action = $(this).data('action');
                            if (action.includes('view') || action.includes('read')) {
                                $(this).prop('checked', true);
                            } else {
                                $(this).prop('checked', false);
                            }
                        });
                        break;
                        
                    case 'clear':
                        // Clear all selections
                        $('.permission-checkbox').prop('checked', false);
                        break;
                }
                
                // Update UI
                updatePermissionCounts();
                updatePreview();
                updateSelectAllState();
                
                // Update button active state
                $('.quick-select-btn').removeClass('active');
                $(this).addClass('active');
            });
            
            // Role name input handler for preview
            $('#name').on('input', function() {
                updatePreview();
            });
            
            // Form submission handler
            $('#roleForm').on('submit', function(e) {
                // Validate role name
                const roleName = $('#name').val().trim();
                if (!roleName) {
                    e.preventDefault();
                    alert('Please enter a role name');
                    $('#name').focus();
                    return false;
                }
                
                // Validate at least one permission is selected
                const selectedPermissions = $('.permission-checkbox:checked').length;
                {{-- if (selectedPermissions === 0) {
                    e.preventDefault();
                    if (!confirm('No permissions selected. The role will have no access to the system. Continue anyway?')) {
                        return false;
                    }
                } --}}
                
                // Show loading state
                const submitBtn = $('#submitBtn');
                const submitText = $('#submitText');
                const submitSpinner = $('#submitSpinner');
                
                submitBtn.prop('disabled', true);
                submitText.hide();
                submitSpinner.show();
                
                return true;
            });
            
            // Initialize counts
            updatePermissionCounts();
            updatePreview();
        });
        
        // Update permission counts for each category
        function updatePermissionCounts() {
            // Update counts for each category
            $('.category-card').each(function() {
                const categoryId = $(this).find('.category-header').data('category');
                const checkboxesInCategory = $(this).find('.permission-checkbox[data-category="' + categoryId + '"]');
                const checkedInCategory = checkboxesInCategory.filter(':checked').length;
                const totalInCategory = checkboxesInCategory.length;
                
                // Update count badge
                $('#count-' + categoryId).text(checkedInCategory + '/' + totalInCategory);
                
                // Highlight category if any permissions selected
                const $categoryHeader = $(this).find('.category-header');
                if (checkedInCategory > 0) {
                    $categoryHeader.css('background', 'rgba(78, 115, 223, 0.1)');
                } else {
                    $categoryHeader.css('background', '');
                }
            });
            
            // Update total selected count
            const totalSelected = $('.permission-checkbox:checked').length;
            const totalPermissions = $('.permission-checkbox').length;
            $('#totalSelectedCount').text(totalSelected + '/' + totalPermissions);
            
            // Update selected permissions list
            updateSelectedPermissionsList();
        }
        
        // Update selected permissions list
        function updateSelectedPermissionsList() {
            const selectedPermissions = [];
            
            $('.permission-checkbox:checked').each(function() {
                const permissionId = $(this).val();
                const permissionLabel = $(this).closest('.permission-label').text().trim();
                selectedPermissions.push(permissionLabel);
            });
            
            const $selectedList = $('#selectedPermissionsList');
            
            if (selectedPermissions.length > 0) {
                let html = '<div class="row">';
                
                selectedPermissions.slice(0, 12).forEach(permission => {
                    html += `
                        <div class="col-md-6 col-lg-4 mb-2">
                            <span class="badge bg-light text-dark d-block text-truncate">
                                <i class="fas fa-check text-success me-1"></i>
                                ${permission}
                            </span>
                        </div>
                    `;
                });
                
                if (selectedPermissions.length > 12) {
                    html += `
                        <div class="col-12 mt-2">
                            <span class="badge bg-info">
                                +${selectedPermissions.length - 12} more permissions
                            </span>
                        </div>
                    `;
                }
                
                html += '</div>';
                $selectedList.html(html);
            } else {
                $selectedList.html('<p class="text-muted mb-0">No permissions selected yet. Choose permissions from the categories above.</p>');
            }
        }
        
        // Update preview section
        function updatePreview() {
            // Role name
            const roleName = $('#name').val().trim();
            $('#previewRoleName').text(roleName || 'Not specified');
            
            // Permission count
            const selectedCount = $('.permission-checkbox:checked').length;
            $('#previewPermissionCount').text(selectedCount);
            
            // Update permission categories preview
            const selectedCategories = new Set();
            $('.permission-checkbox:checked').each(function() {
                const category = $(this).data('category');
                if (category) {
                    selectedCategories.add(category.replace('category-', '').replace(/-/g, ' '));
                }
            });
            
            const $previewCategories = $('#previewCategories');
            if (selectedCategories.size > 0) {
                let categoriesHtml = '';
                Array.from(selectedCategories).forEach(category => {
                    categoriesHtml += `<span class="badge bg-secondary me-2 mb-2">${category}</span>`;
                });
                $previewCategories.html(categoriesHtml);
            } else {
                $previewCategories.html('<span class="text-muted">No categories selected</span>');
            }
        }
        
        // Update select all checkbox state
        function updateSelectAllState() {
            const totalCheckboxes = $('.permission-checkbox').length;
            const checkedCheckboxes = $('.permission-checkbox:checked').length;
            $('#selectAllPermissions').prop('checked', totalCheckboxes === checkedCheckboxes);
        }
    </script>
</body>
</html>