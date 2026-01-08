@extends('layouts.admin')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h2 class="text-2xl font-bold mb-6">Edit Reservation #{{ $reservation->id }}</h2>

                <form action="{{ route('reservations.update', $reservation) }}" method="POST" id="reservation-form">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- User Selection -->
                        <div>
                            <label for="user_id" class="block text-sm font-medium text-gray-700">Guest</label>
                            <select name="user_id" id="user_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md" required>
                                <option value="">Select Guest</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ old('user_id', $reservation->user_id) == $user->id ? 'selected' : '' }}>{{ $user->name }} ({{ $user->email }})</option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Room Selection (will be dynamically loaded) -->
                        <div>
                            <label for="room_id" class="block text-sm font-medium text-gray-700">Room</label>
                            <select name="room_id" id="room_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md" required>
                                <!-- سيتم ملؤه تلقائياً بالجافاسكريبت -->
                                <option value="">Loading available rooms...</option>
                            </select>
                            <div id="room-loading" class="mt-2">
                                <div class="flex items-center">
                                    <div class="animate-spin rounded-full h-4 w-4 border-b-2 border-indigo-600"></div>
                                    <span class="ml-2 text-sm text-gray-600">Loading available rooms...</span>
                                </div>
                            </div>
                            <input type="hidden" id="current_room_id" value="{{ $reservation->room_id }}">
                            <input type="hidden" id="reservation_id" value="{{ $reservation->id }}">
                            <input type="hidden" id="initial_start_date" value="{{ $reservation->start_date }}">
                            <input type="hidden" id="initial_end_date" value="{{ $reservation->end_date }}">
                            @error('room_id')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Start Date -->
                        <div>
                            <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
                            <input type="date" name="start_date" id="start_date" 
                                   value="{{ old('start_date', $reservation->start_date) }}" 
                                   min="{{ date('Y-m-d') }}"
                                   class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                            @error('start_date')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- End Date -->
                        <div>
                            <label for="end_date" class="block text-sm font-medium text-gray-700">End Date</label>
                            <input type="date" name="end_date" id="end_date" 
                                   value="{{ old('end_date', $reservation->end_date) }}"
                                   min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                   class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                            @error('end_date')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                            <select name="status" id="status" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md" required>
                                <option value="pending" {{ old('status', $reservation->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="confirmed" {{ old('status', $reservation->status) == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                <option value="rejected" {{ old('status', $reservation->status) == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                <option value="cancelled" {{ old('status', $reservation->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                            @error('status')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Room Information Display -->
                    <div id="room-info" class="mt-4 hidden">
                        <div class="bg-blue-50 p-4 rounded-md">
                            <h4 class="font-medium text-blue-800">Available Rooms Information</h4>
                            <div id="room-count" class="text-sm text-blue-700 mt-1"></div>
                            <div id="room-note" class="text-xs text-blue-600 mt-2">
                                <i class="fas fa-info-circle"></i> The current room is always available for this reservation
                            </div>
                        </div>
                    </div>

                    <!-- Error Display -->
                    <div id="date-error" class="mt-4 hidden">
                        <div class="bg-red-50 p-4 rounded-md">
                            <h4 class="font-medium text-red-800">Date Error</h4>
                            <div id="error-message" class="text-sm text-red-700 mt-1"></div>
                        </div>
                    </div>

                    <div class="mt-6">
                        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Update Reservation
                        </button>
                        <a href="{{ route('reservations.index') }}" class="ml-3 inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const startDateInput = document.getElementById('start_date');
    const endDateInput = document.getElementById('end_date');
    const roomSelect = document.getElementById('room_id');
    const roomLoading = document.getElementById('room-loading');
    const roomInfo = document.getElementById('room-info');
    const roomCount = document.getElementById('room-count');
    const dateError = document.getElementById('date-error');
    const errorMessage = document.getElementById('error-message');
    const currentRoomId = document.getElementById('current_room_id').value;
    const reservationId = document.getElementById('reservation_id').value;
    const initialStartDate = document.getElementById('initial_start_date').value;
    const initialEndDate = document.getElementById('initial_end_date').value;
    
    let debounceTimer;

    // Set minimum dates dynamically
    function updateMinDates() {
        const today = new Date().toISOString().split('T')[0];
        startDateInput.min = today;
        
        if (startDateInput.value) {
            const nextDay = new Date(startDateInput.value);
            nextDay.setDate(nextDay.getDate() + 1);
            endDateInput.min = nextDay.toISOString().split('T')[0];
            
            if (endDateInput.value && new Date(endDateInput.value) <= new Date(startDateInput.value)) {
                endDateInput.value = '';
            }
        }
    }

    // Initialize min dates
    updateMinDates();

    function fetchAvailableRooms() {
        const startDate = startDateInput.value;
        const endDate = endDateInput.value;
        
        // Hide previous messages
        roomInfo.classList.add('hidden');
        dateError.classList.add('hidden');
        
        if (!startDate || !endDate) {
            resetRoomSelect();
            return;
        }
        
        // Validate dates
        const today = new Date().toISOString().split('T')[0];
        const start = new Date(startDate);
        const end = new Date(endDate);
        const todayDate = new Date(today);
        
        if (start < todayDate) {
            showDateError('Check-in date must be today or later.');
            resetRoomSelect();
            return;
        }
        
        if (end <= start) {
            showDateError('Check-out date must be after check-in date.');
            resetRoomSelect();
            return;
        }
        
        // Show loading
        roomLoading.classList.remove('hidden');
        roomSelect.disabled = true;
        
        // Make AJAX request
        fetch('{{ route("reservations.getAvailableRooms") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                start_date: startDate,
                end_date: endDate,
                reservation_id: reservationId
            })
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => {
                    throw new Error(err.message || 'Network response was not ok');
                });
            }
            return response.json();
        })
        .then(data => {
            updateRoomSelect(data.rooms);
        })
        .catch(error => {
            console.error('Error fetching rooms:', error);
            showDateError(error.message || 'Error loading rooms. Please try again.');
            resetRoomSelect();
        })
        .finally(() => {
            roomLoading.classList.add('hidden');
            roomSelect.disabled = false;
        });
    }
    
    function updateRoomSelect(rooms) {
        // Start building options
        let optionsHtml = '<option value="">Select Room</option>';
        let availableCount = 0;
        let currentRoomFound = false;
        
        // Add current room first if exists
        if (currentRoomId) {
            currentRoomFound = true;
            optionsHtml += `<option value="${currentRoomId}" selected>
                Room {{ $reservation->room->room_number }} 
                ({{ $reservation->room->roomType->type ?? 'N/A' }}) 
                - ${{ number_format($reservation->room->current_price, 2) }}/night (Current)
            </option>`;
            availableCount++;
        }
        
        // Add other available rooms
        if (rooms && rooms.length > 0) {
            rooms.forEach(room => {
                // Skip if it's the current room (already added)
                if (room.id == currentRoomId) return;
                
                const roomType = room.room_type || (room.roomType ? room.roomType.type : 'N/A');
                const price = room.current_price ? parseFloat(room.current_price).toFixed(2) : '0.00';
                
                optionsHtml += `<option value="${room.id}">
                    Room ${room.room_number} (${roomType}) - $${price}/night
                </option>`;
                availableCount++;
            });
        }
        
        // Update select
        roomSelect.innerHTML = optionsHtml;
        
        // Show/hide info
        if (availableCount > 0) {
            roomCount.textContent = `Found ${availableCount} available room(s) for the selected dates`;
            roomInfo.classList.remove('hidden');
        } else {
            roomCount.textContent = 'No rooms available for these dates';
            roomInfo.classList.remove('hidden');
        }
    }
    
    function resetRoomSelect() {
        roomSelect.innerHTML = '<option value="">Select Room</option>';
        roomSelect.disabled = false;
    }
    
    function showDateError(message) {
        errorMessage.textContent = message;
        dateError.classList.remove('hidden');
    }
    
    // Debounce function to prevent too many requests
    function debounceFetch() {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(fetchAvailableRooms, 500);
    }
    
    // Event listeners
    startDateInput.addEventListener('change', function() {
        updateMinDates();
        debounceFetch();
    });
    
    endDateInput.addEventListener('change', function() {
        updateMinDates();
        debounceFetch();
    });
    
    startDateInput.addEventListener('input', debounceFetch);
    endDateInput.addEventListener('input', debounceFetch);
    
    // Load available rooms immediately on page load
    function loadInitialRooms() {
        // Set a small timeout to ensure DOM is fully loaded
        setTimeout(() => {
            if (initialStartDate && initialEndDate) {
                // Set the dates if they're not already set
                if (!startDateInput.value) startDateInput.value = initialStartDate;
                if (!endDateInput.value) endDateInput.value = initialEndDate;
                
                updateMinDates();
                
                // Validate dates before fetching
                const start = new Date(initialStartDate);
                const end = new Date(initialEndDate);
                const today = new Date();
                
                if (start >= today && end > start) {
                    fetchAvailableRooms();
                } else {
                    // If dates are in the past, still try to fetch but show warning
                    showDateError('The reservation dates are in the past. You can still update the reservation with these dates.');
                    fetchAvailableRooms();
                }
            }
        }, 100);
    }
    
    // Initialize
    loadInitialRooms();
});
</script>

<style>
#room-loading .animate-spin {
    animation: spin 1s linear infinite;
}

@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}
</style>
@endsection