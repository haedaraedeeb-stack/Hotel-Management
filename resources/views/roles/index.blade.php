<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Roles Management - Hotel</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    
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
        }
        
        .page-title {
            font-weight: 700;
            margin-bottom: 0;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.2);
        }
        
        .btn-add-role {
            background: white;
            color: var(--primary-color);
            border: none;
            font-weight: 600;
            padding: 10px 20px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        
        .btn-add-role:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }
        
        .alert {
            border-radius: 10px;
            border: none;
            margin: 20px 30px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
        }
        
        .alert-success {
            background-color: rgba(28, 200, 138, 0.1);
            border-left: 4px solid var(--success-color);
            color: #155724;
        }
        
        .alert-danger {
            background-color: rgba(231, 74, 59, 0.1);
            border-left: 4px solid var(--danger-color);
            color: #721c24;
        }
        
        .main-card {
            margin: 0 30px 30px;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid #e3e6f0;
        }
        
        .card-header-custom {
            background: white;
            padding: 20px 25px;
            border-bottom: 2px solid #f8f9fc;
        }
        
        .table-container {
            padding: 0;
        }
        
        .table-custom {
            margin-bottom: 0;
        }
        
        .table-custom thead th {
            background-color: #f8f9fc;
            color: var(--primary-color);
            font-weight: 700;
            padding: 15px 12px;
            border-bottom: 2px solid #e3e6f0;
            text-align: center;
            vertical-align: middle;
        }
        
        .table-custom tbody td {
            padding: 12px;
            vertical-align: middle;
            border-bottom: 1px solid #f0f0f0;
        }
        
        .table-custom tbody tr {
            transition: all 0.2s ease;
        }
        
        .table-custom tbody tr:hover {
            background-color: rgba(78, 115, 223, 0.05);
            transform: scale(1.002);
        }
        
        .badge {
            font-weight: 600;
            letter-spacing: 0.3px;
            border-radius: 20px;
        }
        
        .badge-admin {
            background-color: rgba(125, 125, 198, 0.66);
            color: var(--primary-color);
        }
        
        .badge-user {
            background-color: rgba(28, 200, 138, 0.15);
            color: var(--success-color);
        }
        
        .badge-staff {
            background-color: rgba(246, 194, 62, 0.15);
            color: var(--warning-color);
        }
        
        .badge-guest {
            background-color: rgba(133, 135, 150, 0.15);
            color: var(--secondary-color);
        }
        
        .btn-action {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
            border: none;
        }
        
        .btn-action:hover {
            transform: translateY(-2px);
        }
        
        .btn-view {
            background-color: rgba(54, 185, 204, 0.1);
            color: var(--info-color);
        }
        
        .btn-edit {
            background-color: rgba(246, 194, 62, 0.1);
            color: var(--warning-color);
        }
        
        .btn-delete {
            background-color: rgba(231, 74, 59, 0.1);
            color: var(--danger-color);
        }
        
        .no-roles-section {
            padding: 60px 20px;
            text-align: center;
        }
        
        .no-roles-icon {
            color: #d1d3e2;
            margin-bottom: 20px;
        }
        
        .permissions-badge {
            font-size: 0.75rem;
            margin: 2px;
            background-color: #e9ecef;
            color: #495057;
        }
        
        .permissions-count {
            background: var(--info-color);
            color: white;
            padding: 3px 10px;
            border-radius: 15px;
            font-size: 0.85rem;
            margin-left: 8px;
        }
        
        .created-date {
            font-size: 0.85rem;
            color: #6c757d;
        }
        
        .role-name {
            font-weight: 600;
            color: var(--primary-color);
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
            
            .main-card {
                margin: 0 15px 20px;
            }
            
            .table-responsive {
                font-size: 0.9rem;
            }
            
            .btn-action {
                width: 32px;
                height: 32px;
                margin: 2px;
            }
        }
        
        /* Role Statistics */
        .statistics-section {
            padding: 0 30px 30px;
        }
        
        .stat-card {
            border-radius: 12px;
            overflow: hidden;
            margin-bottom: 20px;
            height: 100%;
            border: none;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
        }
        
        .stat-card-primary {
            border-left: 4px solid var(--primary-color);
        }
        
        .stat-card-success {
            border-left: 4px solid var(--success-color);
        }
        
        .stat-card-warning {
            border-left: 4px solid var(--warning-color);
        }
        
        .stat-card-danger {
            border-left: 4px solid var(--danger-color);
        }
        
        .stat-icon {
            font-size: 2.5rem;
            opacity: 0.2;
        }
        
        .stat-number {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 5px;
        }
        
        .stat-label {
            font-size: 0.85rem;
            color: #6c757d;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
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
                        Roles Management
                    </h1>
                    <p class="mb-0 mt-2 opacity-75">Manage user roles and permissions in the system</p>
                </div>
                <div>
                    <a href="{{ route('roles.create') }}" class="btn btn-add-role">
                        <i class="fas fa-plus me-2"></i>Add New Role
                    </a>
                </div>
            </div>
        </div>

        <!-- Messages Section -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <div class="d-flex align-items-center">
                    <i class="fas fa-check-circle fa-lg me-3"></i>
                    <div class="flex-grow-1">
                        <strong>Success!</strong> {{ session('success') }}
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <div class="d-flex align-items-center">
                    <i class="fas fa-exclamation-circle fa-lg me-3"></i>
                    <div class="flex-grow-1">
                        <strong>Error!</strong> {{ session('error') }}
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif

        <!-- Roles Table -->
        <div class="main-card">
            <div class="card-header-custom">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-list me-2"></i>
                        All Roles
                    </h5>
                    <span class="badge bg-primary rounded-pill px-3 py-2">
                        <i class="fas fa-user-shield me-1"></i>
                        {{ $roles->count() }} Roles
                    </span>
                </div>
            </div>
            
            <div class="table-container">
                @if($roles->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-custom table-hover" id="rolesTable">
                            <thead>
                                <tr>
                                    <th width="60">ID</th>
                                    <th>Role Name</th>
                                    <th width="120">Permissions</th>
                                    <th width="150">Created Date</th>
                                    <th width="160" class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($roles as $role)
                                    @php
                                        // Get role with permissions for this iteration
                                        $roleWithPermissions = app(App\Services\RoleService::class)->getRoleById($role->id);
                                        $permissionsCount = $roleWithPermissions ? $roleWithPermissions->permissions->count() : 0;
                                        
                                        // Determine badge class based on role name
                                        $badgeClass = 'badge-secondary';
                                        $roleName = strtolower($role->name);
                                        
                                        if (strpos($roleName, 'admin') !== false) {
                                            $badgeClass = 'badge-admin';
                                        } elseif (strpos($roleName, 'user') !== false) {
                                            $badgeClass = 'badge-user';
                                        } elseif (strpos($roleName, 'staff') !== false || strpos($roleName, 'employee') !== false) {
                                            $badgeClass = 'badge-staff';
                                        } else {
                                            $badgeClass = 'badge-guest';
                                        }
                                    @endphp
                                    
                                    <tr>
                                        <td>
                                            <span class="badge bg-light text-dark">#{{ $role->id }}</span>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <span class="badge {{ $badgeClass }} me-3 px-3 py-2">
                                                    <i class="fas fa-user-tag me-2"></i>
                                                    {{ $role->name }}
                                                </span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <span class="permissions-count">
                                                    <i class="fas fa-key me-1"></i>
                                                    {{ $permissionsCount }}
                                                </span>
                                                @if($roleWithPermissions && $permissionsCount > 0)
                                                    <div class="ms-2">
                                                        @foreach($roleWithPermissions->permissions->take(3) as $permission)
                                                            <span class="badge permissions-badge">
                                                                {{ str_replace(['create ', 'edit ', 'delete ', 'view '], '', $permission->name) }}
                                                            </span>
                                                        @endforeach
                                                        @if($permissionsCount > 3)
                                                            <span class="badge permissions-badge">+{{ $permissionsCount - 3 }}</span>
                                                        @endif
                                                    </div>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <div class="created-date">
                                                @if($role->created_at)
                                                    {{ $role->created_at->format('Y/m/d') }}
                                                    <br>
                                                    <small>{{ $role->created_at->format('h:i A') }}</small>
                                                @else
                                                    <span class="text-muted">N/A</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <a href="{{ route('roles.show', $role->id) }}" 
                                                   class="btn btn-action btn-view me-2" 
                                                   title="View Details">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('roles.edit', $role->id) }}" 
                                                   class="btn btn-action btn-edit me-2" 
                                                   title="Edit Role">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('roles.destroy', $role->id) }}" 
                                                      method="POST" 
                                                      class="d-inline"
                                                      onsubmit="return confirmDeleteRole('{{ $role->name }}', {{ $permissionsCount }})">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-action btn-delete" title="Delete Role">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="no-roles-section">
                        <i class="fas fa-user-shield no-roles-icon fa-5x mb-4"></i>
                        <h3 class="text-muted mb-3">No Roles Found</h3>
                        <p class="text-muted mb-4">No roles have been created yet. You can start by adding the first role.</p>
                        <a href="{{ route('roles.create') }}" class="btn btn-primary btn-lg px-5 py-3">
                            <i class="fas fa-plus-circle me-2"></i>Add New Role
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Statistics Cards -->
     

    <!-- JavaScript Libraries -->
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    
    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- DataTables JS -->
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            // Initialize DataTable if table exists
            if ($('#rolesTable').length) {
                $('#rolesTable').DataTable({
                    order: [[0, 'asc']],
                    pageLength: 25,
                    responsive: true,
                    dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>tip',
                    language: {
                        lengthMenu: "Show _MENU_ entries",
                        search: "Search:",
                        info: "Showing _START_ to _END_ of _TOTAL_ entries",
                        paginate: {
                            first: "First",
                            last: "Last",
                            next: "Next",
                            previous: "Previous"
                        }
                    },
                    initComplete: function() {
                        // Add custom styling to DataTable elements
                        $('.dataTables_length select').addClass('form-select form-select-sm');
                        $('.dataTables_filter input').addClass('form-control form-control-sm');
                    }
                });
            }
            
            // Auto-dismiss alerts after 7 seconds
            setTimeout(function() {
                $('.alert').alert('close');
            }, 7000);
            
            // Add hover effect to table rows
            $('table tbody tr').hover(
                function() {
                    $(this).css('cursor', 'pointer');
                },
                function() {
                    $(this).css('cursor', 'default');
                }
            );
            
            // Click row to view details (except action buttons area)
            $('table tbody tr').on('click', function(e) {
                // Don't trigger if clicking on buttons or forms
                if (!$(e.target).closest('.btn-action, form, a[href*="edit"], a[href*="show"]').length) {
                    const roleId = $(this).find('a[href*="show"]').attr('href')?.split('/').pop();
                    if (roleId) {
                        window.location.href = `/roles/${roleId}`;
                    }
                }
            });
            
            // Initialize tooltips
            $('[title]').tooltip({
                trigger: 'hover',
                placement: 'top'
            });
        });

        // Confirm delete function
        function confirmDeleteRole(roleName, permissionsCount) {
            let message = `Are you sure you want to delete the role "${roleName}"?\n\n`;
            message += `• Role: ${roleName}\n`;
            message += `• Permissions: ${permissionsCount} permission(s) will be removed\n\n`;
            message += `This action cannot be undone!\n\n`;
            message += `Note: Users assigned to this role will lose their permissions.`;
            
            return confirm(message);
        }
    </script>
</body>
</html>