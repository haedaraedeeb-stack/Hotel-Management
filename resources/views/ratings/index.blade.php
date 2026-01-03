<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ratings Management - Hotel</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    
    <style>
        :root {
            --primary-color: #4e73df;
            --success-color: #1cc88a;
            --warning-color: #f6c23e;
            --danger-color: #e74a3b;
            --info-color: #36b9cc;
            --rating-color: #ffc107;
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
            background: linear-gradient(90deg, var(--rating-color), #ffd54f);
            color: #333;
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
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.1);
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
            background: rgba(255, 255, 255, 0.3);
            color: #333;
            border: 1px solid rgba(255, 255, 255, 0.4);
            padding: 8px 20px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        
        .back-button:hover {
            background: rgba(255, 255, 255, 0.5);
            transform: translateX(3px);
        }
        
        .content-section {
            padding: 30px;
        }
        
        .stats-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 25px;
            border-left: 5px solid var(--rating-color);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
        }
        
        .stat-card-primary {
            border-left-color: var(--primary-color);
        }
        
        .stat-card-success {
            border-left-color: var(--success-color);
        }
        
        .stat-card-warning {
            border-left-color: var(--warning-color);
        }
        
        .stat-card-danger {
            border-left-color: var(--danger-color);
        }
        
        .stat-icon {
            font-size: 2.5rem;
            margin-bottom: 15px;
            opacity: 0.8;
        }
        
        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 5px;
        }
        
        .stat-label {
            color: #6c757d;
            font-size: 0.9rem;
        }
        
        .table-container {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
        }
        
        .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .table-title {
            color: var(--rating-color);
            font-weight: 600;
            margin: 0;
        }
        
        .table-actions {
            display: flex;
            gap: 10px;
        }
        
        .btn-refresh {
            background: var(--info-color);
            color: white;
            border: none;
            padding: 8px 20px;
            border-radius: 6px;
            transition: all 0.3s ease;
        }
        
        .btn-refresh:hover {
            background: #2aa3b6;
            transform: rotate(15deg);
        }
        
        .btn-export {
            background: var(--success-color);
            color: white;
            border: none;
            padding: 8px 20px;
            border-radius: 6px;
            transition: all 0.3s ease;
        }
        
        .btn-export:hover {
            background: #17a673;
        }
        
        /* Star Rating Styles */
        .star-rating {
            display: flex;
            align-items: center;
        }
        
        .stars {
            color: var(--rating-color);
            margin-right: 8px;
        }
        
        .rating-badge {
            background: rgba(255, 193, 7, 0.1);
            color: #856404;
            padding: 4px 12px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.9rem;
            border: 1px solid rgba(255, 193, 7, 0.2);
        }
        
        /* DataTable Custom Styles */
        table.dataTable {
            border-collapse: collapse !important;
            border-radius: 8px;
            overflow: hidden;
        }
        
        table.dataTable thead th {
            background-color: #f8f9fc;
            border-bottom: 2px solid #e3e6f0;
            color: #5a5c69;
            font-weight: 600;
            padding: 15px 10px;
        }
        
        table.dataTable tbody td {
            padding: 12px 10px;
            vertical-align: middle;
        }
        
        table.dataTable tbody tr {
            transition: background-color 0.3s ease;
        }
        
        table.dataTable tbody tr:hover {
            background-color: #f8f9fc;
        }
        
        table.dataTable tbody tr:nth-child(even) {
            background-color: #fcfcfc;
        }
        
        table.dataTable tbody tr:nth-child(even):hover {
            background-color: #f8f9fc;
        }
        
        /* Action Buttons */
        .btn-action {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin: 0 3px;
            transition: all 0.3s ease;
            border: none;
        }
        
        .btn-view {
            background: rgba(78, 115, 223, 0.1);
            color: var(--primary-color);
        }
        
        .btn-view:hover {
            background: var(--primary-color);
            color: white;
        }
        
        .btn-delete {
            background: rgba(231, 74, 59, 0.1);
            color: var(--danger-color);
        }
        
        .btn-delete:hover {
            background: var(--danger-color);
            color: white;
        }
        
        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }
        
        .empty-icon {
            font-size: 4rem;
            color: #dee2e6;
            margin-bottom: 20px;
        }
        
        .empty-title {
            color: #6c757d;
            margin-bottom: 10px;
        }
        
        .empty-subtitle {
            color: #adb5bd;
            margin-bottom: 30px;
        }
        
        /* Filter Section */
        .filter-section {
            background: #f8f9fc;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 25px;
            border: 1px solid #e3e6f0;
        }
        
        .filter-title {
            color: var(--rating-color);
            font-weight: 600;
            margin-bottom: 15px;
        }
        
        .filter-group {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }
        
        .filter-input {
            min-width: 200px;
        }
        
        .btn-filter {
            background: var(--rating-color);
            color: #333;
            border: none;
            padding: 8px 20px;
            border-radius: 6px;
            font-weight: 500;
        }
        
        .btn-reset {
            background: #e9ecef;
            color: #6c757d;
            border: none;
            padding: 8px 20px;
            border-radius: 6px;
            font-weight: 500;
        }
        
        .btn-reset:hover {
            background: #dee2e6;
        }
        
        /* Alert Messages */
        .alert-custom {
            border-radius: 10px;
            border: none;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }
        
        .alert-success {
            background: rgba(28, 200, 138, 0.1);
            color: #155724;
            border-left: 4px solid var(--success-color);
        }
        
        .alert-error {
            background: rgba(231, 74, 59, 0.1);
            color: #721c24;
            border-left: 4px solid var(--danger-color);
        }
        
        /* Rating Score Colors */
        .rating-5 { color: #28a745; }
        .rating-4 { color: #20c997; }
        .rating-3 { color: #ffc107; }
        .rating-2 { color: #fd7e14; }
        .rating-1 { color: #dc3545; }
        
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
            
            .stats-cards {
                grid-template-columns: 1fr;
            }
            
            .table-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }
            
            .table-actions {
                width: 100%;
                justify-content: flex-start;
            }
            
            .filter-group {
                flex-direction: column;
            }
            
            .filter-input {
                width: 100%;
            }
        }
        
        /* Description Preview */
        .description-preview {
            max-width: 300px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        .description-full {
            display: none;
            position: absolute;
            background: white;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            z-index: 1000;
            max-width: 400px;
            border: 1px solid #e3e6f0;
        }
        
        .description-container:hover .description-full {
            display: block;
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
    </style>
</head>
<body>
    <div class="container-main">
        <!-- Header Section -->
        <div class="header-section">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                <div class="mb-3 mb-md-0">
                    <h1 class="page-title">
                        <i class="fas fa-star me-2"></i>
                        Ratings Management
                    </h1>
                    <p class="page-subtitle">View and manage guest ratings and reviews</p>
                </div>
                <div>
                    {{-- <a href="{{  }}" class="btn back-button">
                        <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
                    </a> --}}
                </div>
            </div>
        </div>

        <!-- Alert Messages -->
        @if(session('success'))
            <div class="alert alert-success alert-custom m-4">
                <div class="d-flex align-items-center">
                    <i class="fas fa-check-circle fa-lg me-3"></i>
                    <div>{{ session('success') }}</div>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-custom m-4">
                <div class="d-flex align-items-center">
                    <i class="fas fa-exclamation-triangle fa-lg me-3"></i>
                    <div>{{ session('error') }}</div>
                </div>
            </div>
        @endif

        <!-- Content Section -->
        <div class="content-section">
            <!-- Statistics Cards -->
            <div class="stats-cards">
                <div class="stat-card">
                    <div class="stat-icon text-warning">
                        <i class="fas fa-star"></i>
                    </div>
                    <div class="stat-value" id="totalRatings">{{ $ratings->count() }}</div>
                    <div class="stat-label">Total Ratings</div>
                </div>
                
                <div class="stat-card stat-card-success">
                    <div class="stat-icon text-success">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div class="stat-value" id="averageRating">
                        {{ number_format($ratings->avg('score') ?? 0, 1) }}
                    </div>
                    <div class="stat-label">Average Rating</div>
                </div>
                
                <div class="stat-card stat-card-primary">
                    <div class="stat-icon text-primary">
                        <i class="fas fa-thumbs-up"></i>
                    </div>
                    <div class="stat-value" id="positiveRatings">
                        {{ $ratings->where('score', '>=', 4)->count() }}
                    </div>
                    <div class="stat-label">Positive Ratings (4-5)</div>
                </div>
                
                <div class="stat-card stat-card-danger">
                    <div class="stat-icon text-danger">
                        <i class="fas fa-thumbs-down"></i>
                    </div>
                    <div class="stat-value" id="negativeRatings">
                        {{ $ratings->where('score', '<=', 2)->count() }}
                    </div>
                    <div class="stat-label">Negative Ratings (1-2)</div>
                </div>
            </div>

            <!-- Filter Section -->
            <form action="{{ route('ratings.index') }}" method="GET" id="filterForm">
            <div class="filter-section">
                <h5 class="filter-title"><i class="fas fa-filter me-2"></i>Filter Ratings</h5>
                <div class="filter-group">
                    <div class="filter-input">
                        <label for="ratingFilter" class="form-label">Rating Score</label>
                        <select class="form-select" name="score" id="ratingFilter">
                            <option value="">All Ratings</option>
                            <option value="5" @if (isset($data['score']) && $data['score'] == 5) selected
                            
                            @endif>★★★★★ (5 Stars)</option>
                            <option value="4" @if (isset($data['score']) && $data['score'] == 4) selected

                            @endif>★★★★☆ (4 Stars)</option>
                            <option value="3" @if (isset($data['score']) && $data['score'] == 3) selected

                            @endif>★★★☆☆ (3 Stars)</option>
                            <option value="2" @if (isset($data['score']) && $data['score'] == 2) selected

                            @endif>★★☆☆☆ (2 Stars)</option>
                            <option value="1">★☆☆☆☆ (1 Star)</option>
                        </select>
                    </div>
                    
                    <div class="filter-input">
                        <label for="dateFilter" class="form-label">Date Range</label>
                        <input type="date" value="{{ $data['date_From'] ?? '' }}" name="date_From" class="form-control" id="dateFrom" placeholder="From Date">
                    </div>
                    
                    <div class="filter-input">
                        <label for="dateFilter" class="form-label" style="visibility: hidden;">To</label>
                        <input type="date" value="{{ $data['date_To'] ?? '' }}" name="date_To" class="form-control" id="dateTo" placeholder="To Date">
                    </div>
                    
                    <div class="filter-input d-flex align-items-end">
                        <button type="submit" class="btn btn-filter me-2" id="applyFilter">
                            <i class="fas fa-search me-2"></i>Apply Filter
                        </button>
                        <button type="button" class="btn btn-reset" id="resetFilter" onclick="window.location='{{ route('ratings.index') }}'">
                            <i class="fas fa-redo me-2"></i>Reset
                        </button>
                    </div>
                </div>
            </div>
            </form>

            <!-- Ratings Table -->
            <div class="table-container">
                <div class="table-header">
                    <h3 class="table-title">
                        <i class="fas fa-list me-2"></i>
                        All Ratings
                    </h3>
                </div>
                
                @if($ratings->isEmpty())
                    <div class="empty-state">
                        <div class="empty-icon">
                            <i class="far fa-star"></i>
                        </div>
                        <h4 class="empty-title">No Ratings Found</h4>
                        <p class="empty-subtitle">There are no ratings in the system yet.</p>
                        <a href="#" class="btn btn-filter">
                            <i class="fas fa-plus me-2"></i>Add First Rating
                        </a>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover" id="ratingsTable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Reservation ID</th>
                                    <th>Rating</th>
                                    <th>Score</th>
                                    <th>Description</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($ratings as $rating)
                                    @php
                                        $scoreClass = 'rating-' . $rating->score;
                                        $stars = str_repeat('★', $rating->score) . str_repeat('☆', 5 - $rating->score);
                                    @endphp
                                    <tr data-rating-id="{{ $rating->id }}">
                                        <td>
                                            <span class="badge bg-secondary">#{{ $rating->id }}</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-info">
                                                #{{ $rating->reservation_id }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="star-rating">
                                                <div class="stars" title="{{ $rating->score }} out of 5 stars">
                                                    {{ $stars }}
                                                </div>
                                                <span class="rating-badge {{ $scoreClass }}">
                                                    {{ $rating->score }}/5
                                                </span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="progress" style="height: 20px; width: 100px;">
                                                <div class="progress-bar 
                                                    @if($rating->score >= 4) bg-success
                                                    @elseif($rating->score >= 3) bg-warning
                                                    @else bg-danger
                                                    @endif" 
                                                    role="progressbar" 
                                                    style="width: {{ ($rating->score / 5) * 100 }}%"
                                                    aria-valuenow="{{ $rating->score }}" 
                                                    aria-valuemin="0" 
                                                    aria-valuemax="5">
                                                    {{ $rating->score }}
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="description-container">
                                                <div class="description-preview" title="Click to view full description">
                                                    {{ Str::limit($rating->description, 50) }}
                                                </div>
                                                <div class="description-full">
                                                    <strong>Full Description:</strong><br>
                                                    {{ $rating->description ?? 'No description provided' }}
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            {{ $rating->created_at ? $rating->created_at->format('M d, Y') : 'N/A' }}
                                        </td>
                                        <td>
                                            <div class="d-flex">
                                                <a
                                                href="{{ route('ratings.show', $rating->id) }}"
                                                    class="btn btn-action btn-view view-rating"  
                                                    title="View Details">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <form action="{{ route('ratings.destroy', $rating->id) }}" 
                                                      method="POST" 
                                                      class="d-inline delete-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submet" 
                                                            class="btn btn-action btn-delete delete-rating"
                                                            title="Delete Rating">
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
                @endif
            </div>
        </div>
    </div>

    

  

    <!-- JavaScript Libraries -->
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    
    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    
    <!-- Chart.js for future use -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


</body>
</html>