@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold">Reservation Details #{{ $reservation->id }}</h2>
                    <div class="space-x-2">
                        <a href="{{ route('reservations.edit', $reservation) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                            Edit
                        </a>
                        <a href="{{ route('reservations.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Back to List
                        </a>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Guest Information -->
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Guest Information</h3>
                        <div class="space-y-2">
                            <div>
                                <label class="text-sm font-medium text-gray-500">Name:</label>
                                <p class="text-sm text-gray-900">{{ $reservation->user->name ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500">Email:</label>
                                <p class="text-sm text-gray-900">{{ $reservation->user->email ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Room Information -->
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Room Information</h3>
                        <div class="space-y-2">
                            <div>
                                <label class="text-sm font-medium text-gray-500">Room Number:</label>
                                <p class="text-sm text-gray-900">Room {{ $reservation->room->room_number }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500">Room Type:</label>
                                <p class="text-sm text-gray-900">{{ $reservation->room->roomType->type ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500">Room Status:</label>
                                <p class="text-sm text-gray-900">
                                    @if($reservation->room->status == 'available')
                                        <span class="text-green-600">Available</span>
                                    @elseif($reservation->room->status == 'occupied')
                                        <span class="text-red-600">Occupied</span>
                                    @elseif($reservation->room->status == 'under maintenance')
                                        <span class="text-yellow-600">Under Maintenance</span>
                                    @endif
                                </p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500">Price per night:</label>
                                <p class="text-sm text-gray-900">${{ $reservation->room->current_price }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Reservation Details -->
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Reservation Details</h3>
                        <div class="space-y-2">
                            <div>
                                <label class="text-sm font-medium text-gray-500">Start Date:</label>
                                <p class="text-sm text-gray-900">{{ $reservation->start_date }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500">End Date:</label>
                                <p class="text-sm text-gray-900">{{ $reservation->end_date }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500">Status:</label>
                                <p class="text-sm text-gray-900">
                                    @if($reservation->status == 'confirmed')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Confirmed
                                        </span>
                                    @elseif($reservation->status == 'pending')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            Pending
                                        </span>
                                    @elseif($reservation->status == 'rejected')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                            Rejected
                                        </span>
                                    @elseif($reservation->status == 'cancelled')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                            Cancelled
                                        </span>
                                    @endif
                                </p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500">Check-in:</label>
                                <p class="text-sm text-gray-900">{{ $reservation->check_in ?? 'Not checked in yet' }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500">Check-out:</label>
                                <p class="text-sm text-gray-900">{{ $reservation->check_out ?? 'Not checked out yet' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Invoice Information -->
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Invoice Information</h3>
                        @if($reservation->invoice)
                            <div class="space-y-2">
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Total Amount:</label>
                                    <p class="text-sm text-gray-900">${{ $reservation->invoice->total_amount }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Payment Status:</label>
                                    <p class="text-sm text-gray-900">
                                        @if($reservation->invoice->payment_status == 'paid')
                                            <span class="text-green-600">Paid</span>
                                        @else
                                            <span class="text-red-600">Unpaid</span>
                                        @endif
                                    </p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Payment Method:</label>
                                    <p class="text-sm text-gray-900">{{ $reservation->invoice->payment_method }}</p>
                                </div>
                            </div>
                        @else
                            <p class="text-sm text-gray-500">No invoice found for this reservation.</p>
                        @endif
                    </div>
                </div>

                <!-- Check-in / Check-out buttons -->
                <div class="mt-6 flex space-x-4">
                    @if(is_null($reservation->check_in) && is_null($reservation->check_out) && $reservation->status == 'confirmed')
                        <form action="{{ route('reservations.checkIn', $reservation) }}" method="POST">
                            @csrf
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Check In
                            </button>
                        </form>
                    @endif

                    @if(!is_null($reservation->check_in) && is_null($reservation->check_out))
                        <form action="{{ route('reservations.checkOut', $reservation) }}" method="POST">
                            @csrf
                            <button type="submit" class="bg-orange-500 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded">
                                Check Out
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
