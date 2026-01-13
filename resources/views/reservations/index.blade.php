@extends('layouts.admin')

@section('content')
    <div class="py-8">
        <div >
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Header with Title and Button -->
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800">Reservations Management</h2>
                            <p class="text-gray-600 mt-1 text-sm">Manage all hotel bookings and reservations</p>
                        </div>
                        @can('reservation-create')
                        <a href="{{ route('reservations.create') }}"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2.5 px-4 rounded-lg transition duration-200 shadow-md flex items-center gap-2 hover:shadow-lg transform hover:-translate-y-0.5">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            New Reservation
                        </a>
                        @endcan
                    </div>

                    <!-- Filter Section -->
                    <div class="mb-8 bg-gray-50 p-5 rounded-xl border border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-700 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                            </svg>
                            Filter Reservations
                        </h3>
                        
                        <form action="{{ route('reservations.index') }}" method="GET" id="filterForm">
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                                <!-- Status Filter -->
                                <div>
                                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                                        Reservation Status
                                    </label>
                                    <select name="status" id="status" 
                                            class="w-full border border-gray-300 rounded-lg p-3 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                                        <option value="">All Status</option>
                                        <option value="pending" @if(request('status') == 'pending') selected @endif>Pending</option>
                                        <option value="confirmed" @if(request('status') == 'confirmed') selected @endif>Confirmed</option>
                                        <option value="cancelled" @if(request('status') == 'cancelled') selected @endif>Cancelled</option>
                                        <option value="rejected" @if(request('status') == 'rejected') selected @endif>Rejected</option>
                                        <option value="completed" @if(request('status') == 'completed') selected @endif>Completed</option>
                                    </select>
                                </div>
                                
                                <!-- Date Range Filters -->
                                <div>
                                    <label for="start_date" class="block text-sm font-medium text-gray-700 mb-2">
                                        From Date
                                    </label>
                                    <input type="date" id="start_date" name="start_date" 
                                           value="{{ request('start_date') }}" 
                                           class="w-full border border-gray-300 rounded-lg p-3 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                                </div>
                                
                                <div>
                                    <label for="end_date" class="block text-sm font-medium text-gray-700 mb-2">
                                        To Date
                                    </label>
                                    <input type="date" id="end_date" name="end_date" 
                                           value="{{ request('end_date') }}" 
                                           class="w-full border border-gray-300 rounded-lg p-3 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                                </div>

                                <!-- Limit Filter -->
                                <div>
                                <label for="limit" class="block text-sm font-medium text-gray-700 mb-2">Limit</label>
                                <select name="limit" id="limit" class="w-full border border-gray-300 rounded-lg p-3 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                                    <option value="10" @if(request('limit') == 10) selected @endif>10</option>
                                    <option value="25" @if(request('limit') == 25) selected @endif>25</option>
                                    <option value="50" @if(request('limit') == 50) selected @endif>50</option>
                                    <option value="100" @if(request('limit') == 100) selected @endif>100</option>
                                </select>
                                </div>
                                
                                <!-- Filter Buttons -->
                                <div class="flex flex-col justify-end gap-2">
                                    <div class="flex gap-2">
                                        <button type="submit" 
                                                class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-4 py-3 rounded-lg font-medium transition flex items-center justify-center gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                            </svg>
                                            Search
                                        </button>
                                        <a href="{{ route('reservations.index') }}" 
                                           class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-3 rounded-lg font-medium transition flex items-center justify-center gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                            </svg>
                                            Reset
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>


                    </div>

                    <!-- Alerts -->
                    @if (session('success'))
                        <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 rounded-lg flex items-start">
                            <svg class="w-5 h-5 text-green-500 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <p class="text-green-700 font-medium">{{ session('success') }}</p>
                            </div>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-lg flex items-start">
                            <svg class="w-5 h-5 text-red-500 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <p class="text-red-700 font-medium">{{ session('error') }}</p>
                            </div>
                        </div>
                    @endif

                    <!-- Reservations Table -->
                    <div class="overflow-x-auto rounded-lg border border-gray-200 shadow-sm">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                        ID
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                        Guest
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                        Room Details
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                        Stay Period
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                        Payment
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                        Check-in/out
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($reservations as $reservation)
                                    <tr class="hover:bg-gray-50 transition duration-150">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="text-sm font-mono text-gray-600">#{{ $reservation->id }}</span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                                    <svg class="h-5 w-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                    </svg>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">{{ $reservation->user->name ?? 'N/A' }}</div>
                                                    <div class="text-sm text-gray-500">{{ $reservation->user->email ?? '' }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                <span class="inline-flex items-center gap-1">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                                    </svg>
                                                    Room {{ $reservation->room->room_number }}
                                                </span>
                                            </div>
                                            <div class="text-sm text-gray-500 mt-1">{{ $reservation->room->roomType->type ?? 'N/A' }}</div>
                                            <div class="mt-1">
                                                @if ($reservation->room->status == 'available')
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                        Available
                                                    </span>
                                                @elseif($reservation->room->status == 'occupied')
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                        Occupied
                                                    </span>
                                                @elseif($reservation->room->status == 'under maintenance')
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                        Maintenance
                                                    </span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm text-gray-900 flex items-center gap-1">
                                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                                {{ \Carbon\Carbon::parse($reservation->start_date)->format('M d, Y') }}
                                            </div>
                                            <div class="text-sm text-gray-500 flex items-center gap-1 mt-1">
                                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                                {{ \Carbon\Carbon::parse($reservation->end_date)->format('M d, Y') }}
                                            </div>
                                            <div class="text-xs text-gray-400 mt-1">
                                                {{  \Carbon\Carbon::parse($reservation->start_date)->diffInDays($reservation->end_date) ?? 0 }} night(s)
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($reservation->status == 'confirmed')
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                                    <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                                                    Confirmed
                                                </span>
                                            @elseif($reservation->status == 'completed')
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                                    <span class="w-2 h-2 bg-blue-500 rounded-full mr-2"></span>
                                                    Completed
                                                </span>
                                            @elseif($reservation->status == 'pending')
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                                    <span class="w-2 h-2 bg-yellow-500 rounded-full mr-2"></span>
                                                    Pending
                                                </span>
                                            @elseif($reservation->status == 'rejected')
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                                    <span class="w-2 h-2 bg-red-500 rounded-full mr-2"></span>
                                                    Rejected
                                                </span>
                                            @elseif($reservation->status == 'cancelled')
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                                    <span class="w-2 h-2 bg-gray-500 rounded-full mr-2"></span>
                                                    Cancelled
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            @if ($reservation->invoice)
                                                <div class="text-sm font-semibold text-gray-900">
                                                    ${{ number_format($reservation->invoice->total_amount, 2) }}
                                                </div>
                                                <div class="mt-1">
                                                    @if ($reservation->invoice->payment_status == 'paid')
                                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                            Paid
                                                        </span>
                                                    @else
                                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                            Unpaid
                                                        </span>
                                                    @endif
                                                </div>
                                            @else
                                                <span class="text-sm text-gray-500 italic">No invoice</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex flex-col gap-2">
                                                @if ($reservation->status == 'pending' && is_null($reservation->check_in))
                                                   
                                                    <div class="text-xs text-gray-500 bg-gray-50 p-2 rounded">
                                                        waiting for confirmation
                                                    </div>
                                                @elseif ($reservation->status == 'confirmed' && is_null($reservation->check_in))
                                                    <form method="POST" action="{{ route('reservations.checkIn', $reservation->id) }}">
                                                        @csrf
                                                        <button type="submit"
                                                                class="w-full bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-3 rounded-lg text-sm transition shadow-sm flex items-center justify-center gap-2">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                                            </svg>
                                                            Check In Now
                                                        </button>
                                                    </form>
                                                @elseif (!is_null($reservation->check_in) && is_null($reservation->check_out))
                                                    <div class="space-y-2">
                                                        <div class="text-xs text-gray-500 bg-gray-50 p-2 rounded">
                                                            Checked in: {{ \Carbon\Carbon::parse($reservation->check_in)->format('M d, H:i') }}
                                                        </div>
                                                        <form method="POST" action="{{ route('reservations.checkOut', $reservation->id) }}">
                                                            @csrf
                                                            <button type="submit"
                                                                    class="w-full bg-orange-500 hover:bg-orange-600 text-white font-medium py-2 px-3 rounded-lg text-sm transition shadow-sm flex items-center justify-center gap-2">
                                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                                                </svg>
                                                                Check Out
                                                            </button>
                                                        </form>
                                                    </div>
                                                @elseif (!is_null($reservation->check_out))
                                                    <div class="text-center space-y-1">
                                                        <div class="flex items-center justify-center gap-1 text-green-600">
                                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                            </svg>
                                                            <span class="text-sm font-medium">Completed</span>
                                                        </div>
                                                        <div class="text-xs text-gray-500">
                                                            Out: {{ \Carbon\Carbon::parse($reservation->check_out)->format('M d, H:i') }}
                                                        </div>
                                                    </div>
                                                @else
                                                    <span class="text-gray-400 text-sm italic">-</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex flex-col space-y-2">
                                                <div class="flex space-x-2">
                                                    @can('reservation-show')
                                                        <a href="{{ route('reservations.show', $reservation) }}"
                                                           class="inline-flex items-center px-3 py-1.5 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition">
                                                            View
                                                        </a>
                                                    @endcan
                                                    @can('reservation-edit')
                                                        <a href="{{ route('reservations.edit', $reservation) }}"
                                                           class="inline-flex items-center px-3 py-1.5 border border-yellow-300 text-sm font-medium rounded-lg text-yellow-700 bg-white hover:bg-yellow-50 transition">
                                                            Edit
                                                        </a>
                                                    @endcan
                                                </div>
                                                
                                                <div class="flex flex-col space-y-1">
                                                    @can('reservation-delete')
                                                        <form action="{{ route('reservations.destroy', $reservation) }}" method="POST"
                                                              onsubmit="return confirm('Are you sure you want to delete this reservation?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                    class="inline-flex items-center px-3 py-1.5 border border-red-300 text-sm font-medium rounded-lg text-red-700 bg-white hover:bg-red-50 transition w-full justify-center">
                                                                Delete
                                                            </button>
                                                        </form>
                                                    @endcan
                                                    
                                                    @can('reservation-confirm-reject')
                                                        @if ($reservation->status == 'pending')
                                                            <a href="{{ route('comfirme_Reservation', $reservation) }}"
                                                               class="inline-flex items-center px-3 py-1.5 bg-green-100 text-green-700 text-sm font-medium rounded-lg hover:bg-green-200 transition w-full justify-center">
                                                                Confirm
                                                            </a>
                                                        @endif
                                                        @if ($reservation->status != 'completed') 
                                                        <a href="{{ route('rejected_Reservation', $reservation) }}"
                                                           class="inline-flex items-center px-3 py-1.5 bg-red-100 text-red-700 text-sm font-medium rounded-lg hover:bg-red-200 transition w-full justify-center">
                                                            Reject
                                                        </a>
                                                        @endif
                                                    @endcan
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination (if applicable) -->
                    @if ($reservations->hasPages())
                        <div class="mt-6">
                            {{ $reservations->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    /* Custom scrollbar for table */
    .overflow-x-auto {
        scrollbar-width: thin;
        scrollbar-color: #cbd5e0 #f7fafc;
    }
    
    .overflow-x-auto::-webkit-scrollbar {
        height: 8px;
    }
    
    .overflow-x-auto::-webkit-scrollbar-track {
        background: #f7fafc;
        border-radius: 4px;
    }
    
    .overflow-x-auto::-webkit-scrollbar-thumb {
        background-color: #cbd5e0;
        border-radius: 4px;
    }
    
    /* Hover effects */
    tr:hover {
        background-color: #f9fafb;
    }
    
    /* Status badge animations */
    @keyframes pulse {
        0%, 100% {
            opacity: 1;
        }
        50% {
            opacity: 0.7;
        }
    }
    
    .animate-pulse {
        animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }
</style>
@endpush