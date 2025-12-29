<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room Details - Hotel</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <!-- Lightbox CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/css/lightbox.min.css">
    
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
        
        /* Room Header Card */
        .room-header-card {
            background: white;
            border-radius: 12px;
            border: 1px solid #e3e6f0;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }
        
        .room-number-badge {
            font-size: 1.8rem;
            font-weight: 700;
            background: linear-gradient(135deg, var(--primary-color), #6e8efb);
            color: white;
            padding: 10px 25px;
            border-radius: 50px;
            display: inline-block;
            margin-bottom: 20px;
            box-shadow: 0 4px 15px rgba(78, 115, 223, 0.3);
        }
        
        .room-type-badge {
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
        
        /* Status Badges */
        .status-badge {
            padding: 8px 20px;
            border-radius: 20px;
            font-weight: 600;
            display: inline-block;
            min-width: 120px;
            text-align: center;
        }
        
        .status-available {
            background-color: rgba(28, 200, 138, 0.15);
            color: var(--success-color);
        }
        
        .status-occupied {
            background-color: rgba(246, 194, 62, 0.15);
            color: var(--warning-color);
        }
        
        .status-maintenance {
            background-color: rgba(231, 74, 59, 0.15);
            color: var(--danger-color);
        }
        
        .status-unavailable {
            background-color: rgba(133, 135, 150, 0.15);
            color: var(--secondary-color);
        }
        
        /* Gallery Section */
        .gallery-section {
            margin-top: 20px;
        }
        
        .gallery-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .image-count {
            background: var(--info-color);
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-weight: 600;
        }
        
        .image-gallery {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        
        .gallery-item {
            position: relative;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            height: 200px;
        }
        
        .gallery-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }
        
        .gallery-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            cursor: pointer;
            transition: transform 0.3s ease;
        }
        
        .gallery-img:hover {
            transform: scale(1.05);
        }
        
        .no-images {
            text-align: center;
            padding: 40px;
            background: #f8f9fc;
            border-radius: 12px;
            color: #6c757d;
        }
        
        .no-images-icon {
            font-size: 3rem;
            color: #d1d3e2;
            margin-bottom: 15px;
        }
        
        /* Reservations Section */
        .reservations-list {
            margin-top: 20px;
        }
        
        .reservation-item {
            background: #f8f9fc;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 10px;
            border-left: 4px solid var(--primary-color);
        }
        
        .reservation-date {
            font-weight: 600;
            color: var(--primary-color);
        }
        
        .reservation-status {
            font-size: 0.85rem;
            padding: 3px 10px;
            border-radius: 15px;
            margin-left: 10px;
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
            
            .image-gallery {
                grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            }
            
            .actions-section {
                flex-direction: column;
                gap: 15px;
            }
            
            .btn-action {
                width: 100%;
            }
            
            .stats-grid {
                grid-template-columns: 1fr;
            }
        }
        
        /* Modal Styles */
        .modal-image {
            width: 100%;
            height: auto;
            border-radius: 8px;
        }
        
        /* Price Highlight */
        .price-highlight {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--success-color);
        }
        
        /* View Icons */
        .view-icon {
            font-size: 1.2rem;
            margin-right: 8px;
            color: var(--info-color);
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
                        <i class="fas fa-door-open me-2"></i>
                        Room Details
                    </h1>
                    <p class="page-subtitle">Complete information about room #{{ $room->room_number }}</p>
                </div>
                <div>
                    {{-- <a href="{{ route('rooms.index') }}" class="btn back-button">
                        <i class="fas fa-arrow-left me-2"></i>Back to List
                    </a> --}}
                </div>
            </div>
        </div>

        <!-- Content Section -->
        <div class="content-section">
            <!-- Room Header -->
            <div class="room-header-card">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                    <div>
                        <div class="room-number-badge">
                            <i class="fas fa-hotel me-2"></i>
                            Room #{{ $room->room_number }}
                            <span class="room-type-badge">
                                <i class="fas fa-bed me-1"></i>
                                {{ $room->roomType->type ?? 'Not Specified' }}
                            </span>
                        </div>
                        <div class="mt-3">
                            @php
                                $statusClasses = [
                                    'available' => 'status-available',
                                    'occupied' => 'status-occupied',
                                    'maintenance' => 'status-maintenance',
                                    'unavailable' => 'status-unavailable'
                                ];
                                
                                $statusText = [
                                    'available' => 'Available',
                                    'occupied' => 'Occupied',
                                    'maintenance' => 'Under Maintenance',
                                    'unavailable' => 'Unavailable'
                                ];
                            @endphp
                            <span class="status-badge {{ $statusClasses[$room->status] ?? 'status-unavailable' }}">
                                <i class="fas fa-circle me-1" style="font-size: 0.7rem;"></i>
                                {{ $statusText[$room->status] ?? $room->status }}
                            </span>
                        </div>
                    </div>
                    <div class="mt-3 mt-md-0">
                        <div class="price-highlight">
                            <i class="fas fa-money-bill-wave me-2"></i>
                            {{ number_format($room->price_per_night) }}  $
                            <small class="text-muted d-block">per night</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Left Column - Room Details -->
                <div class="col-lg-8">
                    <!-- Room Information Card -->
                    <div class="details-card">
                        <h3 class="details-card-title">
                            <i class="fas fa-info-circle"></i>
                            Room Information
                        </h3>
                        
                        <div class="detail-item">
                            <span class="detail-label">
                                <i class="fas fa-hashtag"></i>
                                Room Number
                            </span>
                            <span class="detail-value">
                                <strong>#{{ $room->room_number }}</strong>
                            </span>
                        </div>
                        
                        <div class="detail-item">
                            <span class="detail-label">
                                <i class="fas fa-bed"></i>
                                Room Type
                            </span>
                            <span class="detail-value">
                                {{ $room->roomType->type ?? 'Not Specified' }}
                                @if($room->roomType && $room->roomType->description)
                                    <br><small class="text-muted">{{ $room->roomType->description }}</small>
                                @endif
                            </span>
                        </div>
                        
                        <div class="detail-item">
                            <span class="detail-label">
                                <i class="fas fa-layer-group"></i>
                                Floor
                            </span>
                            <span class="detail-value">
                                <span class="badge bg-secondary">
                                    <i class="fas fa-stairs me-1"></i>
                                    Floor {{ $room->floor }}
                                </span>
                            </span>
                        </div>
                        
                        <div class="detail-item">
                            <span class="detail-label">
                                <i class="fas fa-binoculars"></i>
                                View
                            </span>
                            <span class="detail-value">
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
                                <i class="{{ $viewIcons[$room->view] ?? 'fas fa-binoculars' }} view-icon"></i>
                                {{ $viewText[$room->view] ?? $room->view }}
                            </span>
                        </div>
                        
                        <div class="detail-item">
                            <span class="detail-label">
                                <i class="fas fa-money-bill-wave"></i>
                                Price per Night
                            </span>
                            <span class="detail-value">
                                <strong class="text-success">{{ number_format($room->price_per_night) }}</strong>  $
                            </span>
                        </div>
                        
                        <div class="detail-item">
                            <span class="detail-label">
                                <i class="fas fa-calendar-alt"></i>
                                Created Date
                            </span>
                            <span class="detail-value">
                                {{ $room->created_at->format('F d, Y') }}
                                <small class="text-muted">({{ $room->created_at->diffForHumans() }})</small>
                            </span>
                        </div>
                        
                        <div class="detail-item">
                            <span class="detail-label">
                                <i class="fas fa-clock"></i>
                                Last Updated
                            </span>
                            <span class="detail-value">
                                {{ $room->updated_at->format('F d, Y h:i A') }}
                                <small class="text-muted">({{ $room->updated_at->diffForHumans() }})</small>
                            </span>
                        </div>
                    </div>

                    <!-- Images Gallery Card -->
                    <div class="details-card">
                        <div class="gallery-header">
                            <h3 class="details-card-title mb-0">
                                <i class="fas fa-images"></i>
                                Room Images
                            </h3>
                            <span class="image-count">
                                <i class="fas fa-camera me-1"></i>
                                {{ $room->images->count() }} Photos
                            </span>
                        </div>
                        
                        @if($room->images->count() > 0)
                            <div class="gallery-section">
                                <div class="image-gallery">
                                    @foreach($room->images as $image)
                                        <div class="gallery-item">
                                            {{-- <a href="{{ asset('storage/' . $image->path) }}" data-lightbox="room-gallery" data-title="Room #{{ $room->room_number }}"> --}}
                                                <img src="{{ asset('storage/' . $image->path) }}" 
                                                     alt="Room Image" 
                                                     class="gallery-img"
                                                     onerror="this.src='https://via.placeholder.com/300x200?text=Image+Not+Found'">
                                            {{-- </a> --}}
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <div class="no-images">
                                <div class="no-images-icon">
                                    <i class="fas fa-image"></i>
                                </div>
                                <h5>No Images Available</h5>
                                <p class="text-muted">No images have been uploaded for this room yet.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Right Column - Statistics & Reservations -->
                <div class="col-lg-4">
                    <!-- Statistics Card -->
                    <div class="details-card">
                        <h3 class="details-card-title">
                            <i class="fas fa-chart-bar"></i>
                            Statistics
                        </h3>
                        
                        <div class="stats-grid">
                            <div class="stat-card">
                                <div class="stat-icon">
                                    <i class="fas fa-images"></i>
                                </div>
                                <div class="stat-number">{{ $room->images->count() }}</div>
                                <div class="stat-label">Total Images</div>
                            </div>
                            
                            <div class="stat-card">
                                <div class="stat-icon">
                                    <i class="fas fa-calendar-check"></i>
                                </div>
                                <div class="stat-number">{{ $room->reservations->count() }}</div>
                                <div class="stat-label">Reservations</div>
                            </div>
                            
                            <div class="stat-card">
                                <div class="stat-icon">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div class="stat-number">
                                    @if($room->created_at->diffInDays(now()) > 0)
                                        {{ $room->created_at->diffInDays(now()) }}d
                                    @else
                                        {{ $room->created_at->diffInHours(now()) }}h
                                    @endif
                                </div>
                                <div class="stat-label">In System</div>
                            </div>
                            
                            <div class="stat-card">
                                <div class="stat-icon">
                                    <i class="fas fa-money-bill"></i>
                                </div>
                                <div class="stat-number">{{ number_format($room->price_per_night) }}</div>
                                <div class="stat-label">Price/Night</div>
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
                            <a href="{{ route('rooms.edit', $room->id) }}" class="btn btn-warning btn-action">
                                <i class="fas fa-edit"></i> Edit Room
                            </a>
                            
                      
                     
                            
                            <button type="button" 
                                    class="btn btn-secondary btn-action"
                                    onclick="window.print()">
                                <i class="fas fa-print"></i> Print Details
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions Section -->
        <div class="actions-section">
            <div>
                <a href="{{ route('rooms.edit', $room->id) }}" class="btn btn-edit btn-action">
                    <i class="fas fa-edit me-2"></i>Edit Room
                </a>
            </div>
            <div class="d-flex gap-3">
                <a href="{{ route('rooms.index') }}" class="btn btn-secondary btn-action">
                    <i class="fas fa-list me-2"></i>All Rooms
                </a>
                <form action="{{ route('rooms.destroy', $room->id) }}" 
                      method="POST" 
                      id="deleteForm"
                      onsubmit="return confirmDelete()">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-delete btn-action">
                        <i class="fas fa-trash me-2"></i>Delete Room
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
    
    <!-- Lightbox JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox.min.js"></script>
    
    <!-- Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>

    <script>
        // Initialize Lightbox
        lightbox.option({
            'resizeDuration': 200,
            'wrapAround': true,
            'albumLabel': "Image %1 of %2",
            'fadeDuration': 300,
            'imageFadeDuration': 300
        });
        
        // Confirm delete function
        function confirmDelete() {
            const roomNumber = "{{ $room->room_number }}";
            const imageCount = "{{ $room->images->count() }}";
            const reservationCount = "{{ $room->reservations->count() }}";
            
            let message = `Are you sure you want to delete Room #${roomNumber}?\n\n`;
            message += `• Room Number: #${roomNumber}\n`;
            message += `• Images: ${imageCount} will be deleted\n`;
            message += `• Reservations: ${reservationCount} will be affected\n\n`;
            message += `This action cannot be undone!`;
            
            return confirm(message);
        }
        
        // Print functionality
        $(document).ready(function() {
            // Add print button event
            $('.btn-print').on('click', function() {
                window.print();
            });
            
            // Image error handler
            $('img').on('error', function() {
                $(this).attr('src', 'https://via.placeholder.com/300x200?text=Image+Not+Found');
            });
            
            // Smooth scroll for gallery
            $('.gallery-img').on('click', function(e) {
                e.preventDefault();
                const url = $(this).attr('src');
                window.open(url, '_blank');
            });
            
            // Copy room number to clipboard
            $('.room-number-badge').on('click', function() {
                const roomNumber = "{{ $room->room_number }}";
                navigator.clipboard.writeText(`Room #${roomNumber}`).then(() => {
                    alert(`Room number #${roomNumber} copied to clipboard!`);
                });
            });
            
            // Status color animation
            $('.status-badge').hover(
                function() {
                    $(this).css('transform', 'scale(1.05)');
                },
                function() {
                    $(this).css('transform', 'scale(1)');
                }
            );
        });
        
        // Image gallery navigation
        document.addEventListener('keydown', function(e) {
            if (e.key === 'ArrowLeft') {
                // Previous image in lightbox
                $('.lb-prev').click();
            } else if (e.key === 'ArrowRight') {
                // Next image in lightbox
                $('.lb-next').click();
            } else if (e.key === 'Escape') {
                // Close lightbox
                $('.lb-close').click();
            }
        });
    </script>
</body>
</html>