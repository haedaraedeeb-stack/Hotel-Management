<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $role->name }} - Role Details</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary-color: #4e73df;
            --success-color: #1cc88a;
            --warning-color: #f6c23e;
            --danger-color: #e74a3b;
            --info-color: #36b9cc;
            --secondary-color: #858796;
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
            max-width: 1400px;
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
        
        .content-section {
            padding: 30px;
        }
        
        /* Role Header Card */
        .role-header-card {
            background: white;
            border-radius: 12px;
            border: 1px solid #e3e6f0;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }
        
        .role-badge {
            font-size: 1.8rem;
            font-weight: 700;
            background: linear-gradient(135deg, var(--primary-color), #6e8efb);
            color: white;
            padding: 10px 30px;
            border-radius: 50px;
            display: inline-block;
            margin-bottom: 20px;
            box-shadow: 0 4px 15px rgba(78, 115, 223, 0.3);
        }
        
        .permissions-count-badge {
            background: var(--info-color);
            color: white;
            padding: 8px 20px;
            border-radius: 20px;
            font-weight: 600;
            display: inline-block;
            margin-left: 15px;
        }
        
        /* Details Cards */
        .details-card {
            background: white;
            border-radius: 12px;
            border: 1px solid #e3e6f0;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }
        
        .details-card-title {
            color: var(--primary-color);
            font-weight: 600;
            margin-bottom: 20px;
            padding-bottom: 12px;
            border-bottom: 2px solid #f0f2f7;
            display: flex;
            align-items: center;
        }
        
        .details-card-title i {
            margin-right: 10px;
        }
        
        .detail-item {
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid #f5f5f5;
            display: flex;
            align-items: center;
        }
        
        .detail-item:last-child {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none;
        }
        
        .detail-label {
            font-weight: 600;
            color: #555;
            min-width: 200px;
            display: flex;
            align-items: center;
        }
        
        .detail-label i {
            margin-right: 10px;
            color: var(--primary-color);
            width: 20px;
        }
        
        .detail-value {
            color: #333;
            flex: 1;
        }
        
        /* Permissions Section */
        .permissions-section {
            margin-top: 20px;
        }
        
        .permissions-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .permissions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 15px;
            margin-top: 20px;
        }
        
        .permission-item {
            background: #f8f9fc;
            border-radius: 8px;
            padding: 15px;
            border-left: 4px solid var(--primary-color);
            transition: all 0.3s ease;
        }
        
        .permission-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            background: white;
        }
        
        .permission-name {
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 5px;
            display: flex;
            align-items: center;
        }
        
        .permission-name i {
            margin-right: 8px;
        }
        
        .permission-description {
            color: #6c757d;
            font-size: 0.9rem;
            margin-bottom: 10px;
        }
        
        .permission-badge {
            font-size: 0.75rem;
            padding: 4px 10px;
            border-radius: 15px;
            margin-right: 5px;
        }
        
        .badge-create {
            background-color: rgba(28, 200, 138, 0.15);
            color: var(--success-color);
        }
        
        .badge-read {
            background-color: rgba(78, 115, 223, 0.15);
            color: var(--primary-color);
        }
        
        .badge-update {
            background-color: rgba(246, 194, 62, 0.15);
            color: var(--warning-color);
        }
        
        .badge-delete {
            background-color: rgba(231, 74, 59, 0.15);
            color: var(--danger-color);
        }
        
        .no-permissions {
            text-align: center;
            padding: 40px;
            background: #f8f9fc;
            border-radius: 12px;
            color: #6c757d;
        }
        
        .no-permissions-icon {
            font-size: 3rem;
            color: #d1d3e2;
            margin-bottom: 15px;
        }
        
        /* Categories */
        .permission-category {
            margin-bottom: 30px;
        }
        
        .category-header {
            background: var(--primary-color);
            color: white;
            padding: 12px 20px;
            border-radius: 8px 8px 0 0;
            font-weight: 600;
            margin-bottom: 0;
        }
        
        .category-body {
            border: 1px solid #e3e6f0;
            border-top: none;
            border-radius: 0 0 8px 8px;
            padding: 20px;
        }
        
        /* Statistics Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        
        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            border-top: 4px solid var(--primary-color);
            transition: transform 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
        }
        
        .stat-icon {
            font-size: 2.5rem;
            color: var(--primary-color);
            margin-bottom: 10px;
        }
        
        .stat-number {
            font-size: 1.8rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 5px;
        }
        
        .stat-label {
            color: #6c757d;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        /* Users Section */
        .users-list {
            margin-top: 20px;
        }
        
        .user-item {
            background: #f8f9fc;
            border-radius: 8px;
            padding: 12px 15px;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .user-info {
            display: flex;
            align-items: center;
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--primary-color);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            margin-right: 12px;
        }
        
        .user-name {
            font-weight: 600;
        }
        
        .user-email {
            font-size: 0.85rem;
            color: #6c757d;
        }
        
        /* Actions Section */
        .actions-section {
            background: #f8f9fc;
            padding: 25px;
            border-top: 1px solid #e3e6f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-radius: 0 0 15px 15px;
        }
        
        .btn-action {
            padding: 10px 25px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 120px;
        }
        
        .btn-action i {
            margin-right: 8px;
        }
        
        .btn-edit {
            background: var(--warning-color);
            color: white;
            border: none;
        }
        
        .btn-edit:hover {
            background: #e0a800;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(240, 173, 78, 0.3);
        }
        
        .btn-delete {
            background: var(--danger-color);
            color: white;
            border: none;
        }
        
        .btn-delete:hover {
            background: #c82333;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(220, 53, 69, 0.3);
        }
        
        /* Quick Actions Card */
        .quick-actions-card {
            background: linear-gradient(135deg, #f8f9fc 0%, #e9ecef 100%);
            border: 2px solid #e3e6f0;
            border-radius: 12px;
            padding: 20px;
            margin-top: 20px;
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
            
            .content-section {
                padding: 20px;
            }
            
            .detail-item {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .detail-label {
                min-width: auto;
                margin-bottom: 5px;
            }
            
            .permissions-grid {
                grid-template-columns: 1fr;
            }
            
            .stats-grid {
                grid-template-columns: 1fr;
            }
            
            .actions-section {
                flex-direction: column;
                gap: 15px;
            }
            
            .btn-action {
                width: 100%;
            }
        }
        
        /* Permission Type Colors */
        .permission-type-indicator {
            width: 4px;
            height: 20px;
            border-radius: 2px;
            margin-right: 10px;
        }
        
        .type-create {
            background-color: var(--success-color);
        }
        
        .type-read {
            background-color: var(--primary-color);
        }
        
        .type-update {
            background-color: var(--warning-color);
        }
        
        .type-delete {
            background-color: var(--danger-color);
        }
        
        /* Copy Role ID */
        .role-id {
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .role-id:hover {
            color: var(--primary-color);
            text-decoration: underline;
        }
        
        /* Timeline */
        .timeline-item {
            display: flex;
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid #e3e6f0;
        }
        
        .timeline-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #e3e6f0;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            flex-shrink: 0;
        }
        
        .timeline-content {
            flex: 1;
        }
        
        .timeline-title {
            font-weight: 600;
            margin-bottom: 5px;
        }
        
        .timeline-date {
            font-size: 0.85rem;
            color: #6c757d;
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
                        <i class="fas fa-user-shield me-2"></i>
                        Role Details
                    </h1>
                    <p class="page-subtitle">Complete information about the {{ $role->name }} role</p>
                </div>
                <div>
                    <a href="{{ route('roles.index') }}" class="btn back-button">
                        <i class="fas fa-arrow-left me-2"></i>Back to Roles
                    </a>
                </div>
            </div>
        </div>

        <!-- Content Section -->
        <div class="content-section">
            <!-- Role Header -->
            <div class="role-header-card">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                    <div>
                        <div class="role-badge">
                            <i class="fas fa-user-tag me-2"></i>
                            {{ $role->name }}
                            <span class="permissions-count-badge">
                                <i class="fas fa-key me-1"></i>
                                {{ $role->permissions->count() }} Permissions
                            </span>
                        </div>
                        <div class="mt-3">
                            <span class="badge bg-secondary">
                                <i class="fas fa-hashtag me-1"></i>
                                ID: <span class="role-id" onclick="copyToClipboard('{{ $role->id }}')">{{ $role->id }}</span>
                            </span>
                        </div>
                    </div>
                    <div class="mt-3 mt-md-0">
                        <div class="text-md-end">
                            <div class="mb-2">
                                <span class="badge bg-light text-dark">
                                    <i class="fas fa-calendar-alt me-1"></i>
                                    Created: {{ $role->created_at->format('M d, Y') }}
                                </span>
                            </div>
                            <div>
                                <span class="badge bg-light text-dark">
                                    <i class="fas fa-clock me-1"></i>
                                    Last Updated: {{ $role->updated_at->diffForHumans() }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Left Column - Role Details & Permissions -->
                <div class="col-lg-8">
                    <!-- Role Information Card -->
                    <div class="details-card">
                        <h3 class="details-card-title">
                            <i class="fas fa-info-circle"></i>
                            Role Information
                        </h3>
                        
                        <div class="detail-item">
                            <span class="detail-label">
                                <i class="fas fa-hashtag"></i>
                                Role ID
                            </span>
                            <span class="detail-value">
                                <code>{{ $role->id }}</code>
                                <button class="btn btn-sm btn-outline-secondary ms-2" onclick="copyToClipboard('{{ $role->id }}')">
                                    <i class="fas fa-copy me-1"></i>Copy
                                </button>
                            </span>
                        </div>
                        
                        <div class="detail-item">
                            <span class="detail-label">
                                <i class="fas fa-user-tag"></i>
                                Role Name
                            </span>
                            <span class="detail-value">
                                <strong>{{ $role->name }}</strong>
                            </span>
                        </div>
                        
                        <div class="detail-item">
                            <span class="detail-label">
                                <i class="fas fa-key"></i>
                                Total Permissions
                            </span>
                            <span class="detail-value">
                                <span class="badge bg-primary">{{ $role->permissions->count() }}</span>
                                permissions assigned
                            </span>
                        </div>
                        
                        <div class="detail-item">
                            <span class="detail-label">
                                <i class="fas fa-calendar-plus"></i>
                                Created Date
                            </span>
                            <span class="detail-value">
                                {{ $role->created_at->format('F d, Y') }}
                                <small class="text-muted">({{ $role->created_at->format('h:i A') }})</small>
                            </span>
                        </div>
                        
                        <div class="detail-item">
                            <span class="detail-label">
                                <i class="fas fa-clock"></i>
                                Last Updated
                            </span>
                            <span class="detail-value">
                                {{ $role->updated_at->format('F d, Y h:i A') }}
                                <small class="text-muted">({{ $role->updated_at->diffForHumans() }})</small>
                            </span>
                        </div>
                    </div>

                    <!-- Permissions Card -->
                    <div class="details-card">
                        <div class="permissions-header">
                            <h3 class="details-card-title mb-0">
                                <i class="fas fa-key"></i>
                                Assigned Permissions
                            </h3>
                            <span class="badge bg-primary">
                                {{ $role->permissions->count() }} Permissions
                            </span>
                        </div>
                        
                        @if($role->permissions->count() > 0)
                            <div class="permissions-section">
                                <!-- Statistics -->
                                @php
                                    $createCount = 0;
                                    $readCount = 0;
                                    $updateCount = 0;
                                    $deleteCount = 0;
                                    $otherCount = 0;
                                    
                                    foreach ($role->permissions as $permission) {
                                        $permissionName = strtolower($permission->name);
                                        if (str_contains($permissionName, 'create')) {
                                            $createCount++;
                                        } elseif (str_contains($permissionName, 'view') || str_contains($permissionName, 'read')) {
                                            $readCount++;
                                        } elseif (str_contains($permissionName, 'edit') || str_contains($permissionName, 'update')) {
                                            $updateCount++;
                                        } elseif (str_contains($permissionName, 'delete')) {
                                            $deleteCount++;
                                        } else {
                                            $otherCount++;
                                        }
                                    }
                                    
                                    // Group permissions by resource
                                    $groupedPermissions = [];
                                    foreach ($role->permissions as $permission) {
                                        $parts = explode(' ', $permission->name);
                                        if (count($parts) >= 2) {
                                            $resource = implode(' ', array_slice($parts, 1));
                                            $resourceKey = str_replace(['-', '_'], ' ', $resource);
                                            $groupedPermissions[$resourceKey][] = $permission;
                                        } else {
                                            $groupedPermissions[''][] = $permission;
                                        }
                                    }
                                @endphp
                                
                               
                                
                                <!-- Permission Categories -->
                                <div class="permission-categories mt-4">
                                    @foreach($groupedPermissions as $resource => $permissions)
                                        <div class="permission-category">
                                            
                                            <div class="category-body">
                                                <div class="permissions-grid">
                                                    @foreach($permissions as $permission)
                                                        @php
                                                            $badgeClass = 'badge-secondary';
                                                            $typeClass = '';
                                                            $icon = 'fa-key';
                                                            
                                                            $permissionName = strtolower($permission->name);
                                                            if (str_contains($permissionName, 'create')) {
                                                                $badgeClass = 'badge-create';
                                                                $typeClass = 'type-create';
                                                                $icon = 'fa-plus-circle';
                                                            } elseif (str_contains($permissionName, 'view') || str_contains($permissionName, 'read')) {
                                                                $badgeClass = 'badge-read';
                                                                $typeClass = 'type-read';
                                                                $icon = 'fa-eye';
                                                            } elseif (str_contains($permissionName, 'edit') || str_contains($permissionName, 'update')) {
                                                                $badgeClass = 'badge-update';
                                                                $typeClass = 'type-update';
                                                                $icon = 'fa-edit';
                                                            } elseif (str_contains($permissionName, 'delete')) {
                                                                $badgeClass = 'badge-delete';
                                                                $typeClass = 'type-delete';
                                                                $icon = 'fa-trash';
                                                            }
                                                        @endphp
                                                        
                                                        <div class="permission-item">
                                                            <div class="permission-name">
                                                                <div class="permission-type-indicator {{ $typeClass }}"></div>
                                                                <i class="fas {{ $icon }} me-2"></i>
                                                                {{ $permission->name }}
                                                            </div>
                                                            <div class="permission-description">
                                                                Allows users to {{ explode(' ', $permission->name)[0] }} {{ str_replace(['-', '_'], ' ', implode(' ', array_slice(explode(' ', $permission->name), 1))) }}
                                                            </div>
                                                            <div>
                                                                <span class="permission-badge {{ $badgeClass }}">
                                                                    {{ ucfirst(explode(' ', $permission->name)[0]) }} Access
                                                                </span>
                                                                <span class="badge bg-light text-dark">
                                                                    ID: {{ $permission->id }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <div class="no-permissions">
                                <i class="fas fa-key no-permissions-icon fa-5x mb-4"></i>
                                <h5>No Permissions Assigned</h5>
                                <p class="text-muted mb-4">This role doesn't have any permissions assigned yet.</p>
                                <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-primary">
                                    <i class="fas fa-plus-circle me-2"></i>Add Permissions
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Right Column - Statistics & Actions -->
                <div class="col-lg-4">
                    <!-- Statistics Card -->
                    <div class="details-card">
                        <h3 class="details-card-title">
                            <i class="fas fa-chart-bar"></i>
                            Role Statistics
                        </h3>
                        
                        <div class="timeline-item">
                            <div class="timeline-icon">
                                <i class="fas fa-calendar-plus"></i>
                            </div>
                            <div class="timeline-content">
                                <div class="timeline-title">Role Created</div>
                                <div class="timeline-date">{{ $role->created_at->format('F d, Y h:i A') }}</div>
                            </div>
                        </div>
                        
                        <div class="timeline-item">
                            <div class="timeline-icon">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="timeline-content">
                                <div class="timeline-title">Last Updated</div>
                                <div class="timeline-date">{{ $role->updated_at->diffForHumans() }}</div>
                            </div>
                        </div>
                        
                        <div class="timeline-item">
                            <div class="timeline-icon">
                                <i class="fas fa-key"></i>
                            </div>
                            <div class="timeline-content">
                                <div class="timeline-title">Total Permissions</div>
                                <div class="timeline-date">{{ $role->permissions->count() }} permissions assigned</div>
                            </div>
                        </div>
                        
                        <div class="timeline-item">
                            <div class="timeline-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="timeline-content">
                                <div class="timeline-title">Users with this Role</div>
                                <div class="timeline-date">
                                    @php
                                        // This would typically come from a relationship
                                        $userCount = 0; // You'll need to implement this
                                    @endphp
                                    {{ $userCount }} user(s) assigned
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions Card -->
                    <div class="details-card">
                        <h3 class="details-card-title">
                            <i class="fas fa-bolt"></i>
                            Quick Actions
                        </h3>
                        
                        <div class="d-grid gap-2">
                            <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-warning btn-action">
                                <i class="fas fa-edit"></i> Edit Role
                            </a>
                            <button type="button" 
                                    class="btn btn-secondary btn-action"
                                    onclick="window.print()">
                                <i class="fas fa-print"></i> Print Details
                            </button>
                            
                            
                        </div>
                    </div>

                    <!-- User Assignment Card -->
                    
                </div>
            </div>

            <!-- Quick Info Card -->
            <div class="quick-actions-card">
                <div class="row">
                    <div class="col-md-6">
                        <h6><i class="fas fa-info-circle me-2 text-primary"></i>Role Summary</h6>
                        <p class="text-muted mb-0">
                            The <strong>{{ $role->name }}</strong> role has 
                            <strong>{{ $role->permissions->count() }}</strong> permissions assigned 
                            across <strong>{{ count($groupedPermissions ?? []) }}</strong> resource categories.
                        </p>
                    </div>
                    <div class="col-md-6">
                        <h6><i class="fas fa-shield-alt me-2 text-success"></i>Security Level</h6>
                        <p class="text-muted mb-0">
                            @if($role->permissions->count() > 20)
                                <span class="badge bg-danger">High Privileges</span>
                            @elseif($role->permissions->count() > 10)
                                <span class="badge bg-warning">Medium Privileges</span>
                            @else
                                <span class="badge bg-success">Standard Privileges</span>
                            @endif
                            Based on permission count and types.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions Section -->
        <div class="actions-section">
            <div>
                <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-edit btn-action">
                    <i class="fas fa-edit me-2"></i>Edit Role
                </a>
            </div>
            <div class="d-flex gap-3">
                <a href="{{ route('roles.index') }}" class="btn btn-secondary btn-action">
                    <i class="fas fa-list me-2"></i>All Roles
                </a>
                <a href="{{ route('roles.create') }}" class="btn btn-primary btn-action">
                    <i class="fas fa-plus me-2"></i>Create New
                </a>
                <form action="{{ route('roles.destroy', $role->id) }}" 
                      method="POST" 
                      id="deleteForm"
                      onsubmit="return confirmDelete()">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-delete btn-action">
                        <i class="fas fa-trash me-2"></i>Delete Role
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- JavaScript Libraries -->
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    
    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Copy to clipboard function
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(() => {
                showToast('Copied to clipboard: ' + text);
            }).catch(err => {
                console.error('Failed to copy: ', err);
            });
        }
        
        // Show toast notification
        function showToast(message) {
            // Create toast element
            const toast = $(`
                <div class="toast align-items-center text-white bg-success border-0 position-fixed bottom-0 end-0 m-3" role="alert">
                    <div class="d-flex">
                        <div class="toast-body">
                            <i class="fas fa-check-circle me-2"></i>${message}
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                    </div>
                </div>
            `);
            
            // Add to page
            $('body').append(toast);
            
            // Initialize and show toast
            const bsToast = new bootstrap.Toast(toast[0]);
            bsToast.show();
            
            // Remove after hiding
            toast.on('hidden.bs.toast', function () {
                $(this).remove();
            });
        }
        
        // Confirm delete function
        function confirmDelete() {
            const roleName = "{{ $role->name }}";
            const permissionsCount = {{ $role->permissions->count() }};
            
            let message = `Are you sure you want to delete the role "${roleName}"?\n\n`;
            message += `• Role: ${roleName}\n`;
            message += `• Permissions: ${permissionsCount} permission(s) will be removed\n`;
            message += `• Users: All users with this role will lose these permissions\n\n`;
            message += `This action cannot be undone!\n`;
            message += `Consider editing the role instead of deleting it.`;
            
            return confirm(message);
        }
        
        // Duplicate role function
        function duplicateRole() {
            if (confirm('Duplicate this role to create a new one with the same permissions?')) {
                // This would typically make an AJAX call or redirect
                window.location.href = "{{ route('roles.create') }}?duplicate={{ $role->id }}";
            }
        }
        
        // Export role as JSON
        function exportRole() {
            const roleData = {
                id: {{ $role->id }},
                name: "{{ $role->name }}",
                permissions: [
                    @foreach($role->permissions as $permission)
                    {
                        id: {{ $permission->id }},
                        name: "{{ $permission->name }}"
                    },
                    @endforeach
                ],
                created_at: "{{ $role->created_at }}",
                updated_at: "{{ $role->updated_at }}"
            };
            
            const dataStr = JSON.stringify(roleData, null, 2);
            const dataUri = 'data:application/json;charset=utf-8,'+ encodeURIComponent(dataStr);
            
            const exportFileDefaultName = `role-{{ $role->name }}-{{ date('Y-m-d') }}.json`;
            
            const linkElement = document.createElement('a');
            linkElement.setAttribute('href', dataUri);
            linkElement.setAttribute('download', exportFileDefaultName);
            linkElement.click();
            
            showToast('Role exported successfully as JSON');
        }
        
        $(document).ready(function() {
            // Add click effect to permission items
            $('.permission-item').on('click', function() {
                $(this).toggleClass('bg-light');
            });
            
            // Initialize tooltips
            $('[title]').tooltip({
                trigger: 'hover',
                placement: 'top'
            });
            
            // Role ID copy on click
            $('.role-id').on('click', function() {
                const roleId = $(this).text();
                copyToClipboard(roleId);
            });
            
            // Print functionality
            $(document).on('keydown', function(e) {
                if (e.ctrlKey && e.key === 'p') {
                    e.preventDefault();
                    window.print();
                }
            });
            
            // Highlight permissions based on type
            $('.permission-item').each(function() {
                const badge = $(this).find('.permission-badge');
                if (badge.hasClass('badge-create')) {
                    $(this).css('border-left-color', 'var(--success-color)');
                } else if (badge.hasClass('badge-read')) {
                    $(this).css('border-left-color', 'var(--primary-color)');
                } else if (badge.hasClass('badge-update')) {
                    $(this).css('border-left-color', 'var(--warning-color)');
                } else if (badge.hasClass('badge-delete')) {
                    $(this).css('border-left-color', 'var(--danger-color)');
                }
            });
        });
    </script>
</body>
</html>