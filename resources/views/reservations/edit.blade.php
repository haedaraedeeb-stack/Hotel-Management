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
                            <select name="user_id" id="user_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md" >
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
                            <select name="room_id" id="room_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md" required disabled>
                                <option value="">Loading available rooms...</option>
                            </select>
                            <div id="room-loading" class="mt-2 hidden">
                                <div class="animate-spin rounded-full h-5 w-5 border-b-2 border-indigo-600"></div>
                                <span class="ml-2 text-sm text-gray-600">Updating available rooms...</span>
                            </div>
                            @error('room_id')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Start Date -->
                        <div>
                            <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
                            <input type="date" name="start_date" id="start_date" value="{{ old('start_date', $reservation->start_date) }}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" >
                            @error('start_date')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- End Date -->
                        <div>
                            <label for="end_date" class="block text-sm font-medium text-gray-700">End Date</label>
                            <input type="date" name="end_date" id="end_date" value="{{ old('end_date', $reservation->end_date) }}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" >
                            @error('end_date')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                            <input type="text"  id="status" value="{{ old('status', $reservation->status) }}" readonly class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            {{-- <select name="status" id="status" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md" >
                                <option value="pending" {{ old('status', $reservation->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="confirmed" {{ old('status', $reservation->status) == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                <option value="rejected" {{ old('status', $reservation->status) == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                <option value="cancelled" {{ old('status', $reservation->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                <option value="completed" {{ old('status', $reservation->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                            </select> --}}
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
    const reservationId = {{ $reservation->id }};
    const currentRoomId = {{ $reservation->room_id }};
    
    let debounceTimer;

    // Initialize with current dates
    fetchAvailableRooms();

    function fetchAvailableRooms() {
        const startDate = startDateInput.value;
        const endDate = endDateInput.value;
        
        if (!startDate || !endDate) {
            roomSelect.innerHTML = '<option value="">First select dates</option>';
            roomSelect.disabled = true;
            roomInfo.classList.add('hidden');
            return;
        }
        
        // Validate dates
        if (new Date(startDate) >= new Date(endDate)) {
            roomSelect.innerHTML = '<option value="">End date must be after start date</option>';
            roomSelect.disabled = true;
            roomInfo.classList.add('hidden');
            return;
        }
        
        // Show loading
        roomSelect.disabled = true;
        roomLoading.classList.remove('hidden');
        roomInfo.classList.add('hidden');
        
        // Get CSRF token
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        // Make AJAX request with reservation_id
        fetch('{{ route("reservations.getAvailableRooms") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                start_date: startDate,
                end_date: endDate,
                reservation_id: reservationId // إرسال ID الحجز الحالي
            })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            // Update room select options
            roomSelect.innerHTML = '<option value="">Select Room</option>';
            
            if (data.rooms && data.rooms.length > 0) {
                data.rooms.forEach(room => {
                    const option = document.createElement('option');
                    option.value = room.id;
                    option.textContent = `Room ${room.room_number} (${room.room_type}) - $${room.current_price}/night`;
                    
                    // Select current room if available
                    if (room.id == currentRoomId) {
                        option.selected = true;
                    }
                    
                    roomSelect.appendChild(option);
                });
                roomSelect.disabled = false;
                
                // Show room info
                roomCount.textContent = `Found ${data.rooms.length} available room(s) for the selected dates`;
                roomInfo.classList.remove('hidden');
            } else {
                roomSelect.innerHTML = '<option value="">No rooms available for these dates</option>';
                roomSelect.disabled = true;
                roomInfo.classList.add('hidden');
            }
        })
        .catch(error => {
            console.error('Error fetching rooms:', error);
            roomSelect.innerHTML = '<option value="">Error loading rooms. Please try again.</option>';
            roomSelect.disabled = true;
            roomInfo.classList.add('hidden');
        })
        .finally(() => {
            roomLoading.classList.add('hidden');
        });
    }
    
    // Debounce function to prevent too many requests
    function debounceFetch() {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(fetchAvailableRooms, 300);
    }
    
    // Event listeners for date changes
    startDateInput.addEventListener('change', debounceFetch);
    endDateInput.addEventListener('change', debounceFetch);
    
    // Also trigger on input for better UX
    startDateInput.addEventListener('input', debounceFetch);
    endDateInput.addEventListener('input', debounceFetch);
});
</script>
@endsection