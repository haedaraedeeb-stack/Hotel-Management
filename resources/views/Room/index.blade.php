<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rooms List - Hotel</title>

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

        .btn-add-room {
            background: white;
            color: var(--primary-color);
            border: none;
            font-weight: 600;
            padding: 10px 20px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .btn-add-room:hover {
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

        .badge-available {
            background-color: rgba(28, 200, 138, 0.15);
            color: var(--success-color);
        }

        .badge-occupied {
            background-color: rgba(246, 194, 62, 0.15);
            color: var(--warning-color);
        }

        .badge-maintenance {
            background-color: rgba(231, 74, 59, 0.15);
            color: var(--danger-color);
        }

        .badge-unavailable {
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

        .no-rooms-section {
            padding: 60px 20px;
            text-align: center;
        }

        .no-rooms-icon {
            color: #d1d3e2;
            margin-bottom: 20px;
        }

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

        .stat-card-info {
            border-left: 4px solid var(--info-color);
        }

        .stat-card-secondary {
            border-left: 4px solid var(--secondary-color);
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

        .footer-section {
            text-align: center;
            padding: 20px;
            background-color: #f8f9fc;
            border-top: 1px solid #e3e6f0;
            color: #6c757d;
            font-size: 0.9rem;
            border-radius: 0 0 15px 15px;
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

            .statistics-section {
                padding: 0 15px 20px;
            }

            .table-responsive {
                font-size: 0.9rem;
            }
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
                        <i class="fas fa-door-closed me-2"></i>
                        Rooms List
                    </h1>
                    <p class="mb-0 mt-2 opacity-75">Manage all hotel rooms in one place</p>
                </div>
                <div>
                    <a href="{{ route('rooms.create') }}" class="btn btn-add-room">
                        <i class="fas fa-plus me-2"></i>Add New Room
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

        <!-- Rooms Table -->
        <div class="main-card">
            <div class="card-header-custom">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-list me-2"></i>
                        All Rooms
                    </h5>
                    <span class="badge bg-primary rounded-pill px-3 py-2">
                        <i class="fas fa-door-closed me-1"></i>
                        {{ $rooms->count() }} Rooms
                    </span>
                </div>
            </div>

            <div class="table-container">
                @if($rooms->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-custom table-hover" id="roomsTable">
                            <thead>
                                <tr>
                                    <th width="100">Room Number</th>
                                    <th>Room Type</th>
                                    <th width="120">Status</th>
                                    <th width="150">Price/Night</th>
                                    <th width="100">Floor</th>
                                    <th width="120">View</th>
                                    <th width="100">Images</th>
                                    <th width="150">Added Date</th>
                                    <th width="160" class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($rooms as $room)
                                    <tr>
                                        <td>
                                            <div class="fw-bold text-primary fs-5">#{{ $room->room_number }}</div>
                                        </td>
                                        <td>
                                            @if($room->roomType)
                                                <div class="fw-bold">{{ $room->roomType->type ?? 'Not Specified' }}</div>
                                                <small
                                                    class="text-muted">{{ Str::limit($room->roomType->description ?? '', 40) }}</small>
                                            @else
                                                <span class="text-muted">Not Specified</span>
                                            @endif
                                        </td>
                                        <td>
                                            @php
                                                $statusClasses = [
                                                    'available' => 'badge-available',
                                                    'occupied' => 'badge-occupied',
                                                    'maintenance' => 'badge-maintenance',
                                                    'unavailable' => 'badge-unavailable'
                                                ];

                                                $statusText = [
                                                    'available' => 'Available',
                                                    'occupied' => 'Occupied',
                                                    'maintenance' => 'Maintenance',
                                                    'unavailable' => 'Unavailable'
                                                ];
                                            @endphp
                                            <span class="badge {{ $statusClasses[$room->status] ?? 'badge-unavailable' }} p-2">
                                                {{ $statusText[$room->status] ?? $room->status }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="fw-bold text-dark">{{ number_format($room->price_per_night) }}</div>
                                            <small class="text-muted">$</small>
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-dark border p-2">
                                                <i class="fas fa-layer-group me-1"></i>
                                                {{ $room->floor }}
                                            </span>
                                        </td>
                                        <td>
                                            @php
                                                $viewIcons = [
                                                    'sea' => 'fas fa-water',
                                                    'city' => 'fas fa-city',
                                                    'mountain' => 'fas fa-mountain',
                                                    'pool' => 'fas fa-swimming-pool',
                                                    'garden' => 'fas fa-tree'
                                                ];

                                                $viewText = [
                                                    'sea' => 'Sea View',
                                                    'city' => 'City View',
                                                    'mountain' => 'Mountain View',
                                                    'pool' => 'Pool View',
                                                    'garden' => 'Garden View'
                                                ];
                                            @endphp
                                            <div class="d-flex align-items-center">
                                                <i
                                                    class="{{ $viewIcons[$room->view] ?? 'fas fa-binoculars' }} me-2 text-info"></i>
                                                <span>{{ $viewText[$room->view] ?? $room->view }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-image text-secondary me-2"></i>
                                                <span class="fw-bold">{{ $room->images->count() }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="text-muted">
                                                <div>{{ $room->created_at->format('Y/m/d') }}</div>
                                                <small>{{ $room->created_at->format('h:i A') }}</small>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <a href="{{ route('rooms.show', $room->id) }}"
                                                    class="btn btn-action btn-view me-2" title="View Details">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('rooms.edit', $room->id) }}"
                                                    class="btn btn-action btn-edit me-2" title="Edit Room">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('rooms.destroy', $room->id) }}" method="POST"
                                                    class="d-inline"
                                                    onsubmit="return confirm('Are you sure you want to delete room #{{ $room->room_number }}? All related data will be deleted.');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-action btn-delete" title="Delete Room">
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
                    <div class="no-rooms-section">
                        <i class="fas fa-door-closed no-rooms-icon fa-5x mb-4"></i>
                        <h3 class="text-muted mb-3">No Rooms Found</h3>
                        <p class="text-muted mb-4">No rooms have been added yet. You can start by adding the first room.</p>
                        <a href="{{ route('rooms.create') }}" class="btn btn-primary btn-lg px-5 py-3">
                            <i class="fas fa-plus-circle me-2"></i>Add New Room
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Statistics Cards -->
        @if($rooms->count() > 0)
            @php
                $availableCount = $rooms->where('status', 'available')->count();
                $occupiedCount = $rooms->where('status', 'occupied')->count();
                $maintenanceCount = $rooms->where('status', 'maintenance')->count();
                $unavailableCount = $rooms->where('status', 'unavailable')->count();
                $totalPrice = $rooms->sum('price_per_night');
                $avgPrice = $rooms->avg('price_per_night');
                $totalImages = $rooms->sum(fn($room) => $room->images->count());
            @endphp

            <div class="statistics-section">
                <h4 class="mb-4"><i class="fas fa-chart-bar me-2"></i>Room Statistics</h4>
                <div class="row">
                    <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
                        <div class="card stat-card stat-card-primary">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-8">
                                        <div class="stat-number">{{ $rooms->count() }}</div>
                                        <div class="stat-label">Total Rooms</div>
                                    </div>
                                    <div class="col-4 text-end">
                                        <i class="fas fa-door-closed stat-icon"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
                        <div class="card stat-card stat-card-success">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-8">
                                        <div class="stat-number">{{ $availableCount }}</div>
                                        <div class="stat-label">Available Rooms</div>
                                    </div>
                                    <div class="col-4 text-end">
                                        <i class="fas fa-door-open stat-icon"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
                        <div class="card stat-card stat-card-warning">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-8">
                                        <div class="stat-number">{{ $occupiedCount }}</div>
                                        <div class="stat-label">Occupied Rooms</div>
                                    </div>
                                    <div class="col-4 text-end">
                                        <i class="fas fa-bed stat-icon"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
                        <div class="card stat-card stat-card-danger">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-8">
                                        <div class="stat-number">{{ $maintenanceCount }}</div>
                                        <div class="stat-label">Under Maintenance</div>
                                    </div>
                                    <div class="col-4 text-end">
                                        <i class="fas fa-tools stat-icon"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
                        <div class="card stat-card stat-card-info">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-8">
                                        <div class="stat-number">{{ number_format($avgPrice, 0) }}</div>
                                        <div class="stat-label">Average Price</div>
                                        <small class="text-muted">SAR/Night</small>
                                    </div>
                                    <div class="col-4 text-end">
                                        <i class="fas fa-money-bill-wave stat-icon"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
                        <div class="card stat-card stat-card-secondary">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-8">
                                        <div class="stat-number">{{ $totalImages }}</div>
                                        <div class="stat-label">Total Images</div>
                                    </div>
                                    <div class="col-4 text-end">
                                        <i class="fas fa-images stat-icon"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Footer -->
        <div class="footer-section">
            <div class="row align-items-center">
                <div class="col-md-6 text-md-start text-center mb-3 mb-md-0">
                    <i class="fas fa-hotel me-2"></i>
                    Hotel Management System © {{ date('Y') }}
                </div>
                <div class="col-md-6 text-md-end text-center">
                    <span class="text-muted">
                        <i class="fas fa-clock me-1"></i>
                        Last Updated: {{ now()->format('Y/m/d h:i A') }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript Libraries -->
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- DataTables JS -->
    <script type="text/javascript" charset="utf8"
        src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" charset="utf8"
        src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function () {
            // Initialize DataTable if table exists
            if ($('#roomsTable').length) {
                $('#roomsTable').DataTable({
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
                    initComplete: function () {
                        // Add custom styling to DataTable elements
                        $('.dataTables_length select').addClass('form-select form-select-sm');
                        $('.dataTables_filter input').addClass('form-control form-control-sm');
                    }
                });
            }

            // Auto-dismiss alerts after 7 seconds
            setTimeout(function () {
                $('.alert').alert('close');
            }, 7000);

            // Add hover effect to table rows
            $('table tbody tr').hover(
                function () {
                    $(this).css('cursor', 'pointer');
                },
                function () {
                    $(this).css('cursor', 'default');
                }
            );

            // Click row to view details (except action buttons area)
            $('table tbody tr').on('click', function (e) {
                // Don't trigger if clicking on buttons or forms
                if (!$(e.target).closest('.btn-action, form, a[href*="edit"], a[href*="show"]').length) {
                    const roomId = $(this).find('a[href*="show"]').attr('href')?.split('/').pop();
                    if (roomId) {
                        window.location.href = `/rooms/${roomId}`;
                    }
                }
            });
        });
    </script>
</body>

</html>