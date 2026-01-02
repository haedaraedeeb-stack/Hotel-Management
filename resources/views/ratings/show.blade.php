<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rating Details - Hotel</title>
    
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
            max-width: 1200px;
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
        
        .info-card {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
            border-left: 5px solid var(--rating-color);
        }
        
        .info-title {
            color: var(--rating-color);
            font-weight: 600;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #f0f2f7;
            display: flex;
            align-items: center;
        }
        
        .info-title i {
            margin-right: 10px;
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        
        .info-item {
            display: flex;
            flex-direction: column;
            padding: 15px;
            background: #f8f9fc;
            border-radius: 8px;
            border: 1px solid #e3e6f0;
        }
        
        .info-label {
            font-size: 0.85rem;
            color: #6c757d;
            margin-bottom: 5px;
            font-weight: 500;
        }
        
        .info-value {
            font-weight: 600;
            color: #333;
            font-size: 1.1rem;
        }
        
        .info-value-sm {
            font-size: 0.9rem;
        }
        
        /* Star Rating Styles */
        .star-display {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .stars-large {
            font-size: 2.5rem;
            color: var(--rating-color);
            letter-spacing: 2px;
        }
        
        .rating-score {
            font-size: 3rem;
            font-weight: 700;
            color: var(--rating-color);
            background: rgba(255, 193, 7, 0.1);
            padding: 10px 20px;
            border-radius: 12px;
            border: 2px solid rgba(255, 193, 7, 0.2);
        }
        
        .rating-score-sm {
            font-size: 1.5rem;
            padding: 5px 10px;
        }
        
        /* Description Box */
        .description-box {
            background: #f8f9fc;
            padding: 20px;
            border-radius: 10px;
            border: 1px solid #e3e6f0;
            margin-top: 15px;
            line-height: 1.6;
        }
        
        /* Status Badges */
        .status-badge {
            padding: 6px 15px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            display: inline-block;
        }
        
        .status-confirmed {
            background: rgba(28, 200, 138, 0.15);
            color: var(--success-color);
        }
        
        .status-pending {
            background: rgba(246, 194, 62, 0.15);
            color: var(--warning-color);
        }
        
        .status-cancelled {
            background: rgba(231, 74, 59, 0.15);
            color: var(--danger-color);
        }
        
        .status-completed {
            background: rgba(78, 115, 223, 0.15);
            color: var(--primary-color);
        }
        
        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 15px;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e3e6f0;
        }
        
        .btn-edit {
            background: var(--primary-color);
            color: white;
            border: none;
            padding: 10px 25px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .btn-edit:hover {
            background: #3e63d6;
            transform: translateY(-2px);
            color: white;
            box-shadow: 0 5px 15px rgba(78, 115, 223, 0.3);
        }
        
        .btn-delete {
            background: white;
            color: var(--danger-color);
            border: 2px solid var(--danger-color);
            padding: 10px 25px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .btn-delete:hover {
            background: var(--danger-color);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(231, 74, 59, 0.3);
        }
        
        .btn-back {
            background: #6c757d;
            color: white;
            border: none;
            padding: 10px 25px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .btn-back:hover {
            background: #5a6268;
            transform: translateY(-2px);
            color: white;
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
            
            .stars-large {
                font-size: 2rem;
            }
            
            .rating-score {
                font-size: 2rem;
            }
            
            .action-buttons {
                flex-direction: column;
            }
            
            .btn-edit, .btn-delete, .btn-back {
                width: 100%;
                justify-content: center;
            }
        }
        
        /* Card Styles */
        .user-card, .room-card, .reservation-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            border: 1px solid #e3e6f0;
            transition: transform 0.3s ease;
        }
        
        .user-card:hover, .room-card:hover, .reservation-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0,0,0,0.1);
        }
        
        .card-header {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid #e3e6f0;
        }
        
        .card-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: rgba(255, 193, 7, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            color: var(--rating-color);
            font-size: 1.5rem;
        }
        
        /* Timeline */
        .timeline {
            position: relative;
            padding-left: 30px;
            margin-top: 20px;
        }
        
        .timeline::before {
            content: '';
            position: absolute;
            left: 10px;
            top: 0;
            bottom: 0;
            width: 2px;
            background: #e3e6f0;
        }
        
        .timeline-item {
            position: relative;
            margin-bottom: 20px;
            padding-left: 20px;
        }
        
        .timeline-item::before {
            content: '';
            position: absolute;
            left: -12px;
            top: 5px;
            width: 14px;
            height: 14px;
            border-radius: 50%;
            background: var(--rating-color);
            border: 3px solid white;
            box-shadow: 0 0 0 2px var(--rating-color);
        }
        
        .timeline-date {
            font-size: 0.85rem;
            color: #6c757d;
            margin-bottom: 5px;
        }
        
        .timeline-content {
            font-weight: 500;
        }
        
        /* Alert Messages */
        .alert-custom {
            border-radius: 10px;
            border: none;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }
        
        .alert-info {
            background: rgba(54, 185, 204, 0.1);
            color: #0c5460;
            border-left: 4px solid var(--info-color);
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
                        Rating Details
                    </h1>
                    <p class="page-subtitle">Guest review and reservation information</p>
                </div>
                <div>
                    {{-- <a href="{{ route('ratings.index') }}" class="btn back-button">
                        <i class="fas fa-arrow-left me-2"></i>Back to Ratings
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
            @if(!$rating)
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Rating not found.
                </div>
                <div class="text-center mt-4">
                    <a href="{{ route('ratings.index') }}" class="btn btn-back">
                        <i class="fas fa-arrow-left me-2"></i>Back to Ratings List
                    </a>
                </div>
            @else
                <!-- Rating Information Card -->
                <div class="info-card">
                    <h3 class="info-title">
                        <i class="fas fa-star"></i>
                        Rating Information
                    </h3>
                    
                    <div class="d-flex flex-column flex-md-row align-items-center justify-content-between mb-4">
                        <div class="star-display mb-3 mb-md-0">
                            <div class="stars-large">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $rating->score)
                                        ★
                                    @else
                                        ☆
                                    @endif
                                @endfor
                            </div>
                            <div class="rating-score">
                                {{ $rating->score }}/5
                            </div>
                        </div>
                        
                        <div class="text-md-end">
                            <div class="info-item">
                                <span class="info-label">Rating ID</span>
                                <span class="info-value">#{{ $rating->id }}</span>
                            </div>
                            <div class="info-item mt-2">
                                <span class="info-label">Created Date</span>
                                <span class="info-value info-value-sm">
                                    {{ $rating->created_at->format('M d, Y - h:i A') }}
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <span class="info-label">Guest Review</span>
                        <div class="description-box">
                            @if($rating->description)
                                {{ $rating->description }}
                            @else
                                <em class="text-muted">No review comment provided by the guest.</em>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Reservation Information Card -->
                <div class="info-card">
                    <h3 class="info-title">
                        <i class="fas fa-calendar-check"></i>
                        Reservation Details
                    </h3>
                    
                    @if($rating->reservation)
                        @php
                            $reservation = $rating->reservation;
                            // Determine status badge class
                            $statusClass = 'status-';
                            switch(strtolower($reservation->status)) {
                                case 'confirmed':
                                case 'active':
                                    $statusClass .= 'confirmed';
                                    break;
                                case 'pending':
                                case 'processing':
                                    $statusClass .= 'pending';
                                    break;
                                case 'cancelled':
                                case 'canceled':
                                    $statusClass .= 'cancelled';
                                    break;
                                case 'completed':
                                case 'finished':
                                    $statusClass .= 'completed';
                                    break;
                                default:
                                    $statusClass .= 'pending';
                            }
                        @endphp
                        
                        <div class="info-grid">
                            <div class="info-item">
                                <span class="info-label">Reservation ID</span>
                                <span class="info-value">#{{ $reservation->id }}</span>
                            </div>
                            
                            <div class="info-item">
                                <span class="info-label">Status</span>
                                <span class="status-badge {{ $statusClass }}">
                                    {{ ucfirst($reservation->status) }}
                                </span>
                            </div>
                            
                            <div class="info-item">
                                <span class="info-label">Start Reservation</span>
                                <span class="info-value">
                                    @if($reservation->start_date)
                                        {{ \Carbon\Carbon::parse($reservation->start_date)->format('M d, Y') }}
                                    @else
                                        N/A
                                    @endif
                                </span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">End Reservation</span>
                                <span class="info-value">
                                    @if($reservation->end_date)
                                        {{ \Carbon\Carbon::parse($reservation->end_date)->format('M d, Y') }}
                                    @else
                                        N/A
                                    @endif
                                </span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Check-in Date</span>
                                <span class="info-value">
                                    @if($reservation->check_in)
                                        {{ \Carbon\Carbon::parse($reservation->check_in)->format('M d, Y') }}
                                    @else
                                        N/A
                                    @endif
                                </span>
                            </div>
                            
                            <div class="info-item">
                                <span class="info-label">Check-out Date</span>
                                <span class="info-value">
                                    @if($reservation->check_out)
                                        {{ \Carbon\Carbon::parse($reservation->check_out)->format('M d, Y') }}
                                    @else
                                        N/A
                                    @endif
                                </span>
                            </div>
                            
                            <div class="info-item">
                                <span class="info-label">Duration</span>
                                <span class="info-value">
                                    @php
                                        $checkIn = $reservation->check_in ?? $reservation->start_date;
                                        $checkOut = $reservation->check_out ?? $reservation->end_date;
                                        if ($checkIn && $checkOut) {
                                            $start = \Carbon\Carbon::parse($checkIn);
                                            $end = \Carbon\Carbon::parse($checkOut);
                                            $nights = $start->diffInDays($end);
                                            echo $nights . ' night' . ($nights != 1 ? 's' : '');
                                        } else {
                                            echo 'N/A';
                                        }
                                    @endphp
                                </span>
                            </div>
                            
                            <div class="info-item">
                                <span class="info-label">Created Date</span>
                                <span class="info-value info-value-sm">
                                    {{ $reservation->created_at->format('M d, Y - h:i A') }}
                                </span>
                            </div>
                        </div>
                        
                       
                    @else
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Reservation information not available for this rating.
                        </div>
                    @endif
                </div>



                <!-- Room Information Card -->
                <div class="info-card">
                    <h3 class="info-title">
                        <i class="fas fa-bed"></i>
                        Room Information
                    </h3>
                    
                    @if($rating->reservation && $rating->reservation->room)
                        @php
                            $room = $rating->reservation->room;
                        @endphp
                        
                        <div class="room-card">
                            <div class="card-header">
                                <div class="card-icon">
                                    <i class="fas fa-hotel"></i>
                                </div>
                                <div>
                                    <h5 class="mb-0">{{ $room->name ?? 'Room #' . $room->id }}</h5>
                                 
                                </div>
                            </div>
                            
                            <div class="info-grid">
                                <div class="info-item">
                                    <span class="info-label">Room ID</span>
                                    <span class="info-value">#{{ $room->id }}</span>
                                </div>
                                
                                <div class="info-item">
                                    <span class="info-label">Room Number</span>
                                    <span class="info-value">{{ $room->room_number ?? 'N/A' }}</span>
                                </div>
                                
                                <div class="info-item">
                                    <span class="info-label">Room Type</span>
                                    <span class="info-value">{{ $room->roomType->type ?? 'N/A' }}</span>
                                </div>
                                
                                <div class="info-item">
                                    <span class="info-label">Price per Night</span>
                                    <span class="info-value">${{ number_format($room->price_per_night ?? 0, 2) }}</span>
                                </div>
                                
                                {{-- <div class="info-item">
                                    <span class="info-label">Capacity</span>
                                    <span class="info-value">{{ $room->capacity ?? 'N/A' }} person(s)</span>
                                </div> --}}
                                
                                <div class="info-item">
                                    <span class="info-label">Status</span>
                                    <span class="status-badge 
                                        @if(($room->status ?? '') === 'available') status-confirmed
                                        @elseif(($room->status ?? '') === 'occupied') status-pending
                                        @elseif(($room->status ?? '') === 'maintenance') status-cancelled
                                        @else status-pending
                                        @endif">
                                        {{ ucfirst($room->status ?? 'unknown') }}
                                    </span>
                                </div>
                            </div>
                            
                            @if($room->description)
                                <div class="mt-3">
                                    <span class="info-label">Room Description</span>
                                    <div class="description-box" style="font-size: 0.9rem;">
                                        {{ $room->description }}
                                    </div>
                                </div>
                            @endif
                            
                            @if($room->amenities && is_array($room->amenities))
                                <div class="mt-3">
                                    <span class="info-label">Amenities</span>
                                    <div class="d-flex flex-wrap gap-2 mt-2">
                                        @foreach($room->amenities as $amenity)
                                            <span class="badge bg-light text-dark border">
                                                <i class="fas fa-check-circle text-success me-1"></i>
                                                {{ $amenity }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            Room information not available for this reservation.
                        </div>
                    @endif
                </div>

                <!-- Action Buttons -->
                <div class="action-buttons">
                    <a href="{{ route('ratings.index') }}" class="btn btn-back">
                        <i class="fas fa-arrow-left me-2"></i>Back to Ratings
                    </a>
                    
                    <div class="d-flex gap-2">
                        
                        
                        <form action="{{ route('ratings.destroy', $rating->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-delete" 
                                    onclick="confirmDelete({{ $rating->id }})">
                                <i class="fas fa-trash me-2"></i>Delete Rating
                            </button>
                        </form>
                    </div>
                </div>
                
                <!-- Related Information Alert -->
                <div class="alert alert-info alert-custom mt-4">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-link fa-lg me-3"></i>
                        <div>
                            <h5 class="alert-heading mb-2">Related Information</h5>
                            <p class="mb-0">
                                This rating is linked to Reservation #{{ $rating->reservation_id }}. 
                                @if($rating->reservation)
                                    You can view the full reservation details 
                                    <a href="{{ route('reservations.show', $rating->reservation_id) }}" class="alert-link">here</a>.
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- JavaScript Libraries -->
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    
    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


</body>
</html>