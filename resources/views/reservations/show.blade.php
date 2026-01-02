@extends('layout.app')

@section('header')
    <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Reservation Details #{{ $reservation->id }}
        </h2>
        <a href="{{ route('reservations.index') }}" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">
            &larr; Back to List
        </a>
    </div>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-white border-b border-gray-200">

                    <div class="flex justify-between items-center mb-8 pb-4 border-b">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">Guest: {{ $reservation->user->name }}</h3>
                            <p class="text-sm text-gray-500">{{ $reservation->user->email }}</p>
                        </div>
                        <div class="text-right">
                            <span class="block text-sm text-gray-500 mb-1">Current Status</span>
                            <span
                                class="px-3 py-1 rounded-full text-sm font-bold
                            {{ $reservation->status == 'confirmed'
                                ? 'bg-green-100 text-green-700'
                                : ($reservation->status == 'pending'
                                    ? 'bg-yellow-100 text-yellow-700'
                                    : 'bg-gray-100 text-gray-700') }}">
                                {{ ucfirst($reservation->status) }}
                            </span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">

                        <div>
                            <h4
                                class="text-md font-semibold text-gray-700 mb-3 uppercase tracking-wider border-l-4 border-indigo-500 pl-2">
                                Room Information</h4>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="flex justify-between py-2 border-b border-gray-200">
                                    <span class="text-gray-600">Room Number:</span>
                                    <span class="font-bold text-gray-900">{{ $reservation->room->room_number }}</span>
                                </p>
                                <p class="flex justify-between py-2 border-b border-gray-200">
                                    <span class="text-gray-600">Type:</span>
                                    <span class="text-gray-900">{{ $reservation->room->roomType->type }}</span>
                                </p>
                                <p class="flex justify-between py-2 border-b border-gray-200">
                                    <span class="text-gray-600">View:</span>
                                    <span class="text-gray-900">{{ $reservation->room->view ?? 'Standard' }}</span>
                                </p>
                                <p class="flex justify-between py-2">
                                    <span class="text-gray-600">Floor:</span>
                                    <span class="text-gray-900">{{ $reservation->room->floor ?? 'N/A' }}</span>
                                </p>
                            </div>
                        </div>

                        <div>
                            <h4
                                class="text-md font-semibold text-gray-700 mb-3 uppercase tracking-wider border-l-4 border-green-500 pl-2">
                                Stay Details</h4>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="flex justify-between py-2 border-b border-gray-200">
                                    <span class="text-gray-600">Check-In Date:</span>
                                    <span class="font-bold text-green-700">{{ $reservation->start_date }}</span>
                                </p>
                                <p class="flex justify-between py-2 border-b border-gray-200">
                                    <span class="text-gray-600">Check-Out Date:</span>
                                    <span class="font-bold text-red-700">{{ $reservation->end_date }}</span>
                                </p>
                                <p class="flex justify-between py-2 border-b border-gray-200">
                                    <span class="text-gray-600">Actual Arrival:</span>
                                    <span class="text-gray-900">{{ $reservation->check_in ?? 'Not yet' }}</span>
                                </p>
                                <p class="flex justify-between py-2">
                                    <span class="text-gray-600">Actual Departure:</span>
                                    <span class="text-gray-900">{{ $reservation->check_out ?? 'Not yet' }}</span>
                                </p>
                            </div>
                        </div>
                    </div>

                    @if ($reservation->invoice)
                        <div class="mt-8 border-t pt-6">
                            <h4 class="text-md font-semibold text-gray-700 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-gray-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                                Invoice Information
                            </h4>

                            <div
                                class="flex flex-col md:flex-row justify-between items-center bg-indigo-50 p-5 rounded-lg border border-indigo-100">
                                <div class="mb-4 md:mb-0">
                                    <span class="block text-xs text-indigo-500 uppercase font-bold tracking-wide">Total
                                        Amount</span>
                                    <span
                                        class="text-3xl font-extrabold text-indigo-900">{{ $reservation->invoice->total_amount }}
                                        $</span>
                                </div>

                                <div class="mb-4 md:mb-0 text-center md:text-left">
                                    <span class="block text-xs text-gray-500 uppercase font-bold tracking-wide">Payment
                                        Status</span>
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                {{ $reservation->invoice->payment_status == 'paid' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ ucfirst($reservation->invoice->payment_status) }}
                                    </span>
                                </div>

                                <div class="text-right">
                                    <span
                                        class="block text-xs text-gray-500 uppercase font-bold tracking-wide mb-1">Method</span>
                                    <span
                                        class="text-gray-700 font-medium">{{ ucfirst($reservation->invoice->payment_method) }}</span>
                                </div>

                            </div>
                        </div>
                    @else
                        <div class="mt-8 border-t pt-6 text-center text-gray-500 italic">
                            No invoice generated for this reservation.
                        </div>
                    @endif

                    <div class="mt-8 flex justify-end gap-3 border-t pt-6">

                        <a href="{{ route('reservations.edit', $reservation->id) }}"
                            class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded shadow">
                            Edit Details
                        </a>

                        @if ($reservation->status == 'confirmed' && is_null($reservation->check_in))
                            <form method="POST" action="{{ route('reservations.checkIn', $reservation->id) }}">
                                @csrf
                                <button type="submit"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow font-bold">
                                    Check In Guest
                                </button>
                            </form>
                        @elseif (!is_null($reservation->check_in) && is_null($reservation->check_out))
                            <form method="POST" action="{{ route('reservations.checkOut', $reservation->id) }}">
                                @csrf
                                <button type="submit"
                                    class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded shadow font-bold">
                                    Check Out Guest
                                </button>
                            </form>
                        @endif

                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
