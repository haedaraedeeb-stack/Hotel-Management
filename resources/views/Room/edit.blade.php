<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Room - Hotel</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

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
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 1%, transparent 20%);
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

        .form-control,
        .form-select {
            border: 2px solid #e3e6f0;
            border-radius: 8px;
            padding: 10px 15px;
            transition: all 0.3s ease;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(78, 115, 223, 0.15);
        }

        .form-text {
            font-size: 0.85rem;
            color: #6c757d;
        }

        . -field::after {
            content: " *";
            color: var(--danger-color);
        }

        /* Image Upload Styles */
        .upload-section {
            margin-top: 30px;
        }

        .upload-area {
            border: 3px dashed #d1d3e2;
            border-radius: 12px;
            padding: 40px 20px;
            text-align: center;
            background: #f8f9fc;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .upload-area:hover {
            border-color: var(--primary-color);
            background: rgba(78, 115, 223, 0.03);
        }

        .upload-icon {
            font-size: 3rem;
            color: var(--primary-color);
            margin-bottom: 15px;
        }

        .upload-text {
            color: #555;
            margin-bottom: 10px;
        }

        .upload-subtext {
            color: #6c757d;
            font-size: 0.9rem;
        }

        /* Image Preview Styles */
        .image-preview-container {
            margin-top: 20px;
        }

        .existing-images-section {
            margin-bottom: 30px;
        }

        .existing-images-title {
            color: var(--info-color);
            font-weight: 600;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
        }

        .image-preview-item {
            position: relative;
            border-radius: 8px;
            overflow: hidden;
            border: 2px solid #e3e6f0;
            transition: all 0.3s ease;
            height: 150px;
        }

        .image-preview-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .image-preview-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .image-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .image-preview-item:hover .image-overlay {
            opacity: 1;
        }

        .image-actions {
            display: flex;
            gap: 10px;
        }

        .btn-image-action {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-view-image {
            background: var(--info-color);
            color: white;
        }

        .btn-view-image:hover {
            background: #2a9d9f;
            transform: scale(1.1);
        }

        .btn-delete-image {
            background: var(--danger-color);
            color: white;
        }

        .btn-delete-image:hover {
            background: #c82333;
            transform: scale(1.1);
        }

        .image-checkbox {
            position: absolute;
            top: 10px;
            right: 10px;
            width: 20px;
            height: 20px;
            z-index: 10;
        }

        /* New Images Preview */
        .new-images-section {
            margin-top: 30px;
        }

        .new-images-title {
            color: var(--success-color);
            font-weight: 600;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
        }

        .new-image-preview {
            position: relative;
        }

        .remove-new-image {
            position: absolute;
            top: 10px;
            right: 10px;
            background: rgba(231, 74, 59, 0.9);
            color: white;
            border: none;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .remove-new-image:hover {
            background: var(--danger-color);
            transform: scale(1.1);
        }

        /* Preview Card */
        .preview-card {
            background: linear-gradient(135deg, #f8f9fc 0%, #e9ecef 100%);
            border: 2px solid #e3e6f0;
            border-radius: 12px;
            padding: 20px;
            margin-top: 20px;
        }

        .preview-title {
            color: var(--primary-color);
            font-weight: 600;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
        }

        .preview-item {
            margin-bottom: 10px;
            display: flex;
            align-items: center;
        }

        .preview-label {
            font-weight: 600;
            color: #555;
            min-width: 120px;
        }

        .preview-value {
            color: #333;
        }

        .preview-badge {
            font-size: 0.85rem;
            padding: 5px 12px;
            border-radius: 20px;
        }

        /* Status Badges */
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
            background: linear-gradient(90deg, var(--warning-color), #f8c146);
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
            box-shadow: 0 5px 15px rgba(240, 173, 78, 0.3);
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
            to {
                transform: rotate(360deg);
            }
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

        /* Price Input */
        .price-input-group {
            position: relative;
        }

        .price-symbol {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
            font-weight: 600;
        }

        .price-input {
            padding-right: 40px;
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

            .btn-submit,
            .btn-cancel {
                width: 100%;
            }

            .image-actions {
                flex-direction: column;
                gap: 5px;
            }

            .btn-image-action {
                width: 35px;
                height: 35px;
            }
        }

        /* Room Info Badge */
        .room-info-badge {
            background: var(--primary-color);
            color: white;
            padding: 8px 20px;
            border-radius: 20px;
            font-weight: 600;
            display: inline-block;
            margin-bottom: 20px;
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
                        <i class="fas fa-edit me-2"></i>
                        Edit Room #{{ $room->room_number }}
                    </h1>
                    <p class="page-subtitle">Update room information and images</p>
                </div>
                <div>
                    {{-- <a href="{{ route('rooms.show', $room->id) }}" class="btn back-button me-2">
                        <i class="fas fa-eye me-2"></i>View Room
                    </a>
                    <a href="{{ route('rooms.index') }}" class="btn back-button">
                        <i class="fas fa-arrow-left me-2"></i>Back to List
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

        @if(session('success'))
            <div class="alert alert-success m-4">
                <div class="d-flex align-items-center">
                    <i class="fas fa-check-circle fa-lg me-3"></i>
                    <div>
                        <strong>Success!</strong> {{ session('success') }}
                    </div>
                </div>
            </div>
        @endif

        <!-- Main Form -->
        <form action="{{ route('rooms.update', $room->id) }}" method="POST" enctype="multipart/form-data" id="roomForm">
            @csrf
            @method('PUT')

            <div class="form-section">
                <!-- Room Info Badge -->
                <div class="room-info-badge">
                    <i class="fas fa-hotel me-2"></i>
                    Editing Room #{{ $room->room_number }}
                    <span class="badge bg-light text-dark ms-2">
                        <i class="fas fa-images me-1"></i>
                        {{ $room->images->count() }} images
                    </span>
                </div>

                <!-- Basic Information Card -->
                <div class="form-card">
                    <h3 class="form-card-title">
                        <i class="fas fa-info-circle"></i>
                        Basic Information
                    </h3>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="room_number" class="form-label  -field">Room Number</label>
                            <input type="text" class="form-control @error('room_number') is-invalid @enderror"
                                id="room_number" name="room_number" value="{{ old('room_number', $room->room_number) }}"
                                  placeholder="Example: 101">
                            @error('room_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Room number must be unique</div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="room_type_id" class="form-label  -field">Room Type</label>
                            <select class="form-select @error('room_type_id') is-invalid @enderror" id="room_type_id"
                                name="room_type_id"  >
                                <option value="">Select Room Type</option>
                                @foreach($roomtypes as $type)
                                    <option value="{{ $type->id }}" {{ old('room_type_id', $room->room_type_id) == $type->id ? 'selected' : '' }}>
                                        {{ $type->type }} - {{ number_format($type->base_price) }}  $
                                    </option>
                                @endforeach
                            </select>
                            @error('room_type_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="status" class="form-label  -field">Room Status</label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status"
                                 >
                                <option value="">Select Status</option>
                                <option value="available" {{ old('status', $room->status) == 'available' ? 'selected' : '' }}>Available</option>
                                <option value="occupied" {{ old('status', $room->status) == 'occupied' ? 'selected' : '' }}>Occupied</option>
                                <option value="maintenance" {{ old('status', $room->status) == 'maintenance' ? 'selected' : '' }}>Under Maintenance</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="floor" class="form-label  -field">Floor</label>
                            <select class="form-select @error('floor') is-invalid @enderror" id="floor" name="floor"
                                 >
                                <option value="">Select Floor</option>
                                @for($i = 1; $i <= 20; $i++)
                                    <option value="{{ $i }}" {{ old('floor', $room->floor) == $i ? 'selected' : '' }}>
                                        Floor {{ $i }}
                                    </option>
                                @endfor
                            </select>
                            @error('floor')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="price" class="form-label  -field">Price Per Night</label>
                            <div class="price-input-group">
                                <span class="price-symbol"> $</span>
                                <input type="number"
                                    class="form-control price-input @error('price') is-invalid @enderror" id="price"
                                    name="price" value="{{ old('price', $room->price_per_night) }}"   min="0"
                                    step="0.01" placeholder="0.00">
                            </div>
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Price in Saudi Riyal</div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="view" class="form-label">Room View</label>
                            <select class="form-select @error('view') is-invalid @enderror" id="view" name="view">
                                <option value="">Select View</option>
                                <option value="sea" {{ old('view', $room->view) == 'sea' ? 'selected' : '' }}>Sea View
                                </option>
                                <option value="city" {{ old('view', $room->view) == 'city' ? 'selected' : '' }}>City View
                                </option>
                                <option value="mountain" {{ old('view', $room->view) == 'mountain' ? 'selected' : '' }}>
                                    Mountain View</option>
                                <option value="pool" {{ old('view', $room->view) == 'pool' ? 'selected' : '' }}>Pool View
                                </option>
                                <option value="garden" {{ old('view', $room->view) == 'garden' ? 'selected' : '' }}>Garden
                                    View</option>
                                <option value="other" {{ old('view', $room->view) == 'other' ? 'selected' : '' }}>Other
                                </option>
                            </select>
                            @error('view')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 mb-3" id="customViewContainer"
                            style="{{ old('view', $room->view) == 'other' ? '' : 'display: none;' }}">
                            <label for="custom_view" class="form-label">Custom View Description</label>
                            <input type="text" class="form-control" id="custom_view" name="custom_view"
                                value="{{ old('custom_view', $room->view == 'other' ? $room->view : '') }}"
                                placeholder="Enter view description">
                        </div>
                    </div>
                </div>

                <!-- Images Management Card -->
                <div class="form-card">
                    <h3 class="form-card-title">
                        <i class="fas fa-images"></i>
                        Room Images Management
                    </h3>

                    <!-- Existing Images -->
                    @if($room->images->count() > 0)
                        <div class="existing-images-section">
                            <h5 class="existing-images-title">
                                <i class="fas fa-images me-2"></i>
                                Existing Images ({{ $room->images->count() }})
                                <small class="text-muted ms-2">Select images to delete</small>
                            </h5>

                            <div class="row" id="existingImagesRow">
                                @foreach($room->images as $image)
                                    <div class="col-md-3 col-sm-4 col-6 mb-3">
                                        <div class="image-preview-item">
                                            <input type="checkbox" class="form-check-input image-checkbox"
                                                name="images_to_delete[]" value="{{ $image->id }}" id="image_{{ $image->id }}">
                                            <img src="{{ asset('storage/' . $image->path) }}" alt="Room Image"
                                                class="image-preview-img"
                                                onerror="this.src='https://via.placeholder.com/300x200?text=Image+Not+Found'">
                                            <div class="image-overlay">
                                                <div class="image-actions">
                                                    <a href="{{ asset('storage/' . $image->path) }}"
                                                        class="btn-image-action btn-view-image" data-lightbox="existing-images"
                                                        data-title="Room #{{ $room->room_number }}">
                                                        <i class="fas fa-search-plus"></i>
                                                    </a>
                                                    <button type="button" class="btn-image-action btn-delete-image"
                                                        onclick="toggleImageDelete('image_{{ $image->id }}')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <label for="image_{{ $image->id }}"
                                            class="form-check-label small text-muted mt-1 d-block text-center">
                                            Click to select for deletion
                                        </label>
                                    </div>
                                @endforeach
                            </div>

                            <div class="form-check mt-3">
                                <input type="checkbox" class="form-check-input" id="selectAllImages">
                                <label class="form-check-label" for="selectAllImages">
                                    <strong>Select All Images for Deletion</strong>
                                </label>
                            </div>
                        </div>
                    @endif

                    <!-- Upload New Images -->
                    <div class="upload-section">
                        <div class="upload-area" id="dropzoneArea">
                            <div class="upload-icon">
                                <i class="fas fa-cloud-upload-alt"></i>
                            </div>
                            <h5 class="upload-text">Drag & drop new images here or click to select</h5>
                            <p class="upload-subtext">
                                You can upload up to 10 new images<br>
                                Allowed types: JPG, PNG, JPEG (Max 5MB per image)
                            </p>
                            <input type="file" id="imageInput" name="new_images[]" multiple accept="image/*"
                                style="display;">
                        </div>

                        <!-- New Images Preview -->
                        <div class="new-images-section" id="newImagesSection" style="display: none;">
                            <h5 class="new-images-title">
                                <i class="fas fa-plus-circle me-2"></i>
                                New Images to Upload
                                <span class="badge bg-success ms-2" id="newImagesCount">0</span>
                            </h5>

                            <div class="row" id="newImagesRow">
                                <!-- New images will be previewed here -->
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Live Preview Card -->
                <div class="form-card">
                    <h3 class="form-card-title">
                        <i class="fas fa-eye"></i>
                        Updated Data Preview
                    </h3>

                    <div class="preview-card" id="livePreview">
                        <div class="preview-title">
                            <i class="fas fa-door-closed me-2"></i>
                            Updated Room Data Preview
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="preview-item">
                                    <span class="preview-label">Room Number:</span>
                                    <span class="preview-value" id="previewRoomNumber">#{{ $room->room_number }}</span>
                                </div>
                                <div class="preview-item">
                                    <span class="preview-label">Room Type:</span>
                                    <span class="preview-value"
                                        id="previewRoomType">{{ $room->roomType->type ?? 'Not Specified' }}</span>
                                </div>
                                <div class="preview-item">
                                    <span class="preview-label">Status:</span>
                                    <span class="preview-value">
                                        @php
                                            $statusClasses = [
                                                'available' => 'badge-available',
                                                'occupied' => 'badge-occupied',
                                                'maintenance' => 'badge-maintenance',
                                            ];

                                            $statusText = [
                                                'available' => 'Available',
                                                'occupied' => 'Occupied',
                                                'maintenance' => 'Under Maintenance',
                                            ];
                                        @endphp
                                        <span
                                            class="preview-badge {{ $statusClasses[$room->status] ?? 'badge-unavailable' }}"
                                            id="previewStatus">
                                            {{ $statusText[$room->status] ?? $room->status }}
                                        </span>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="preview-item">
                                    <span class="preview-label">Price/Night:</span>
                                    <span class="preview-value"
                                        id="previewPrice">{{ number_format($room->price_per_night) }}  $</span>
                                </div>
                                <div class="preview-item">
                                    <span class="preview-label">Floor:</span>
                                    <span class="preview-value" id="previewFloor">Floor {{ $room->floor }}</span>
                                </div>
                                <div class="preview-item">
                                    <span class="preview-label">View:</span>
                                    <span class="preview-value" id="previewView">
                                        @php
                                            $viewText = [
                                                'sea' => 'Sea View',
                                                'city' => 'City View',
                                                'mountain' => 'Mountain View',
                                                'pool' => 'Pool View',
                                                'garden' => 'Garden View'
                                            ];
                                        @endphp
                                        {{ $viewText[$room->view] ?? $room->view }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="preview-item mt-3">
                            <span class="preview-label">Total Images:</span>
                            <span class="preview-value">
                                <span id="previewTotalImages">{{ $room->images->count() }}</span>
                                <small class="text-muted ms-2">
                                    (<span id="previewExistingImages">{{ $room->images->count() }}</span> existing +
                                    <span id="previewNewImages">0</span> new -
                                    <span id="previewDeletedImages">0</span> deleted)
                                </small>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="form-actions">
                <div>
                    <button type="button" class="btn btn-cancel"
                        onclick="window.location.href='{{ route('rooms.show', $room->id) }}'">
                        <i class="fas fa-times me-2"></i>Cancel
                    </button>
                </div>
                <div>
                    <button type="button" class="btn btn-danger me-2" onclick="resetForm()">
                        <i class="fas fa-redo me-2"></i>Reset Form
                    </button>
                    <button type="submit" class="btn btn-submit" id="submitBtn">
                        <i class="fas fa-save me-2"></i>
                        <span id="submitText">Update Room</span>
                        <span id="submitSpinner" style="display: none;">
                            <span class="spinner me-2"></span>Updating...
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

    <!-- Lightbox JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox.min.js"></script>

    <script>
        // Array to store new files
        let newFiles = [];
        let deletedImagesCount = 0;

        $(document).ready(function () {
            // Initialize Lightbox
            lightbox.option({
                'resizeDuration': 200,
                'wrapAround': true,
                'albumLabel': "Image %1 of %2"
            });

            // View select change handler
            $('#view').on('change', function () {
                if ($(this).val() === 'other') {
                    $('#customViewContainer').slideDown();
                } else {
                    $('#customViewContainer').slideUp();
                }
                updatePreview();
            });

            // Select All Images checkbox
            $('#selectAllImages').on('change', function () {
                const isChecked = $(this).is(':checked');
                $('input[name="images_to_delete[]"]').prop('checked', isChecked);
                deletedImagesCount = isChecked ? {{ $room->images->count() }} : 0;
                updatePreview();
            });

            // Individual image checkbox handler
            $('input[name="images_to_delete[]"]').on('change', function () {
                updateDeletedImagesCount();
            });

            // File upload handler
            $('#dropzoneArea').on('click', function () {
                $('#imageInput').click();
            });

            $('#imageInput').on('change', function (e) {
                handleFiles(e.target.files);
                $(this).val(''); // Reset input
            });

            // Drag and drop functionality
            $('#dropzoneArea').on('dragover', function (e) {
                e.preventDefault();
                e.stopPropagation();
                $(this).css({
                    'border-color': 'var(--primary-color)',
                    'background': 'rgba(78, 115, 223, 0.05)'
                });
            });

            $('#dropzoneArea').on('dragleave', function (e) {
                e.preventDefault();
                e.stopPropagation();
                $(this).css({
                    'border-color': '#d1d3e2',
                    'background': '#f8f9fc'
                });
            });

            $('#dropzoneArea').on('drop', function (e) {
                e.preventDefault();
                e.stopPropagation();
                $(this).css({
                    'border-color': '#d1d3e2',
                    'background': '#f8f9fc'
                });

                if (e.originalEvent.dataTransfer.files.length) {
                    handleFiles(e.originalEvent.dataTransfer.files);
                }
            });

            // Handle selected files
            function handleFiles(files) {
                const maxFiles = 10;
                const currentCount = newFiles.length;

                if (files.length + currentCount > maxFiles) {
                    alert(`You can upload maximum ${maxFiles} new images`);
                    return;
                }

                for (let i = 0; i < files.length; i++) {
                    const file = files[i];

                    // Validate file type
                    if (!file.type.match('image.*')) {
                        alert(`File ${file.name} is not an image. Please select images only.`);
                        continue;
                    }

                    // Validate file size (5MB)
                    if (file.size > 5 * 1024 * 1024) {
                        alert(`Image ${file.name} is too large. Maximum size is 5MB.`);
                        continue;
                    }

                    const reader = new FileReader();

                    reader.onload = function (e) {
                        const fileId = 'new-file-' + Date.now() + '-' + Math.random().toString(36).substr(2, 9);

                        // Add file to array
                        newFiles.push({
                            id: fileId,
                            file: file,
                            preview: e.target.result
                        });

                        addNewImagePreview(fileId, e.target.result);
                        updateFileInput();
                        updatePreview();
                    };

                    reader.readAsDataURL(file);
                }

                // Show new images section
                if (newFiles.length > 0) {
                    $('#newImagesSection').slideDown();
                }
            }

            // Add new image preview to DOM
            function addNewImagePreview(fileId, previewUrl) {
                const col = $('<div class="col-md-3 col-sm-4 col-6 mb-3"></div>').attr('id', 'new-preview-' + fileId);

                col.html(`
                    <div class="new-image-preview">
                        <img src="${previewUrl}" 
                             class="img-fluid rounded" 
                             style="height: 150px; width: 100%; object-fit: cover;">
                        <button type="button" 
                                class="remove-new-image" 
                                onclick="removeNewImage('${fileId}')">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                `);

                $('#newImagesRow').append(col);
            }

            // Update the actual file input with DataTransfer
            function updateFileInput() {
                const fileInput = $('#imageInput')[0];
                const dataTransfer = new DataTransfer();

                // Add all new files
                newFiles.forEach(fileObj => {
                    dataTransfer.items.add(fileObj.file);
                });

                fileInput.files = dataTransfer.files;

                // Update new images count
                $('#newImagesCount').text(newFiles.length);
            }

            // Update deleted images count
            function updateDeletedImagesCount() {
                deletedImagesCount = $('input[name="images_to_delete[]"]:checked').length;
                updatePreview();
            }

            // Real-time preview update
            function updatePreview() {
                // Room number
                const roomNumber = $('#room_number').val() || '-';
                $('#previewRoomNumber').text(roomNumber ? '#' + roomNumber : '-');

                // Room type
                const roomTypeSelect = $('#room_type_id');
                const roomTypeText = roomTypeSelect.find('option:selected').text().split(' - ')[0] || '-';
                $('#previewRoomType').text(roomTypeText);

                // Status
                const status = $('#status').val();
                let statusBadge = '-';
                if (status === 'available') {
                    statusBadge = '<span class="preview-badge badge-available">Available</span>';
                } else if (status === 'occupied') {
                    statusBadge = '<span class="preview-badge badge-occupied">Occupied</span>';
                } else if (status === 'maintenance') {
                    statusBadge = '<span class="preview-badge badge-maintenance">Under Maintenance</span>';
                } 
                $('#previewStatus').html(statusBadge);

                // Price
                const price = $('#price').val();
                $('#previewPrice').text(price ? numberFormat(price) + '  $' : '-');

                // Floor
                const floor = $('#floor').val();
                $('#previewFloor').text(floor ? 'Floor ' + floor : '-');

                // View
                const view = $('#view').val();
                let viewText = '-';
                if (view === 'sea') viewText = 'Sea View';
                else if (view === 'city') viewText = 'City View';
                else if (view === 'mountain') viewText = 'Mountain View';
                else if (view === 'pool') viewText = 'Pool View';
                else if (view === 'garden') viewText = 'Garden View';
                else if (view === 'other') viewText = $('#custom_view').val() || 'Other';
                $('#previewView').text(viewText);

                // Update image counts
                const existingImages = {{ $room->images->count() }};
                const newImagesCount = newFiles.length;
                const totalImages = existingImages + newImagesCount - deletedImagesCount;

                $('#previewExistingImages').text(existingImages);
                $('#previewNewImages').text(newImagesCount);
                $('#previewDeletedImages').text(deletedImagesCount);
                $('#previewTotalImages').text(totalImages);
            }

            // Number formatter
            function numberFormat(number) {
                return new Intl.NumberFormat('en-US').format(number);
            }

            // Update preview on input changes
            $('input, select').on('input change', function () {
                updatePreview();
            });

            // Form submission handler
            $('#roomForm').on('submit', function (e) {
                // Validate   fields
                const  Fields = $('#roomForm').find('[ ]');
                let isValid = true;

                 Fields.each(function () {
                    if (!$(this).val()) {
                        $(this).addClass('is-invalid');
                        isValid = false;
                    }
                });

                // Check if all images will be deleted
                const existingImages = {{ $room->images->count() }};
                if (deletedImagesCount >= existingImages && newFiles.length === 0) {
                    if (!confirm('You are deleting all existing images without adding new ones. Are you sure you want to continue?')) {
                        e.preventDefault();
                        return false;
                    }
                }

                if (!isValid) {
                    e.preventDefault();
                    alert('Please fill in all   fields');
                    return false;
                }

                // Show loading state
                const submitBtn = $('#submitBtn');
                const submitText = $('#submitText');
                const submitSpinner = $('#submitSpinner');

                submitBtn.prop('disabled', true);
                submitText.hide();
                submitSpinner.show();

                return true;
            });

            // Initial preview update
            updatePreview();
        });

        // Toggle image delete
        function toggleImageDelete(imageId) {
            const checkbox = $('#' + imageId);
            checkbox.prop('checked', !checkbox.is(':checked'));
            updateDeletedImagesCount();
        }

        // Remove new image function
        function removeNewImage(fileId) {
            // Remove from array
            newFiles = newFiles.filter(fileObj => fileObj.id !== fileId);

            // Remove from DOM
            $('#new-preview-' + fileId).remove();

            // Update file input
            const fileInput = $('#imageInput')[0];
            const dataTransfer = new DataTransfer();

            newFiles.forEach(fileObj => {
                dataTransfer.items.add(fileObj.file);
            });

            fileInput.files = dataTransfer.files;

            // Update new images count
            $('#newImagesCount').text(newFiles.length);

            // Hide section if no new images
            if (newFiles.length === 0) {
                $('#newImagesSection').slideUp();
            }

            // Update preview
            updatePreview();
        }

        // Reset form function
        function resetForm() {
            if (confirm('Are you sure you want to reset the form? All changes will be lost.')) {
                // Reset form values to original
                $('#room_number').val('{{ $room->room_number }}');
                $('#room_type_id').val('{{ $room->room_type_id }}');
                $('#status').val('{{ $room->status }}');
                $('#floor').val('{{ $room->floor }}');
                $('#price').val('{{ $room->price_per_night }}');
                $('#view').val('{{ $room->view }}');

                // Reset custom view
                if ('{{ $room->view }}' === 'other') {
                    $('#customViewContainer').show();
                    $('#custom_view').val('{{ $room->view }}');
                } else {
                    $('#customViewContainer').hide();
                    $('#custom_view').val('');
                }

                // Reset image selections
                $('input[name="images_to_delete[]"]').prop('checked', false);
                $('#selectAllImages').prop('checked', false);
                deletedImagesCount = 0;

                // Clear new files
                newFiles = [];
                $('#newImagesRow').empty();
                $('#newImagesSection').hide();
                $('#newImagesCount').text('0');

                // Reset file input
                const fileInput = $('#imageInput')[0];
                fileInput.files = new DataTransfer().files;

                // Update preview
                updatePreview();

                alert('Form has been reset to original values.');
            }
        }
    </script>
</body>

</html>