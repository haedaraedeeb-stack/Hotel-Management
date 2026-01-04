@extends('layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold">Reservations</h2>
                        <a href="{{ route('reservations.create') }}"
                            class="bg-blue-500 hover:bg-blue-700 text-blue font-bold py-2 px-4 rounded">
                            New Reservation
                        </a>
                    </div>

                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                            role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4"
                            role="alert">
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        ID
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Guest
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Room
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Dates
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Payment
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Check-in/Check-out
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($reservations as $reservation)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $reservation->id }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $reservation->user->name ?? 'N/A' }}</div>
                                            <div class="text-sm text-gray-500">{{ $reservation->user->email ?? '' }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">Room
                                                {{ $reservation->room->room_number }}</div>
                                            <div class="text-sm text-gray-500">
                                                {{ $reservation->room->roomType->type ?? 'N/A' }}</div>
                                            <div class="text-xs">
                                                @if ($reservation->room->status == 'available')
                                                    <span class="text-green-600">Available</span>
                                                @elseif($reservation->room->status == 'occupied')
                                                    <span class="text-red-600">Occupied</span>
                                                @elseif($reservation->room->status == 'under maintenance')
                                                    <span class="text-yellow-600">Under Maintenance</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">From: {{ $reservation->start_date }}</div>
                                            <div class="text-sm text-gray-900">To: {{ $reservation->end_date }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($reservation->status == 'confirmed')
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    Confirmed
                                                </span>
                                            @elseif($reservation->status == 'pending')
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                    Pending
                                                </span>
                                            @elseif($reservation->status == 'rejected')
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                    Rejected
                                                </span>
                                            @elseif($reservation->status == 'cancelled')
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                    Cancelled
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($reservation->invoice)
                                                <div class="text-sm text-gray-900">Total:
                                                    ${{ $reservation->invoice->total_amount }}</div>
                                                <div class="text-sm">
                                                    @if ($reservation->invoice->payment_status == 'paid')
                                                        <span class="text-green-600">Paid</span>
                                                    @else
                                                        <span class="text-red-600">Unpaid</span>
                                                    @endif
                                                </div>
                                            @else
                                                <div class="text-sm text-gray-500">No invoice</div>
                                            @endif
                                        <td class="py-3 px-6 text-center">


                                            @if ($reservation->status == 'pending' && is_null($reservation->check_in))
                                                <form method="POST"
                                                    action="{{ route('reservations.checkIn', $reservation->id) }}">
                                                    @csrf
                                                    <button type="submit"
                                                        class="bg-blue-600 hover:bg-blue-700 text-blue font-bold py-1.5 px-3 rounded text-xs transition shadow-sm animate-pulse"
                                                        title="Confirm & Check In & Pay">
                                                        Check In (Confirm)
                                                    </button>
                                                </form>

                                            @elseif ($reservation->status == 'confirmed' && is_null($reservation->check_in))
                                                <form method="POST"
                                                    action="{{ route('reservations.checkIn', $reservation->id) }}">
                                                    @csrf
                                                    <button type="submit"
                                                        class="bg-green-600 hover:bg-green-700 text-blue font-bold py-1.5 px-3 rounded text-xs transition shadow-sm">
                                                        Check In Now
                                                    </button>
                                                </form>

                                            @elseif (!is_null($reservation->check_in) && is_null($reservation->check_out))
                                                <div class="flex flex-col items-center gap-1">
                                                    <span class="text-[10px] text-gray-500 font-mono">In:
                                                        {{ \Carbon\Carbon::parse($reservation->check_in)->format('H:i') }}</span>
                                                    <form method="POST"
                                                        action="{{ route('reservations.checkOut', $reservation->id) }}">
                                                        @csrf
                                                        <button type="submit"
                                                            class="bg-orange-500 hover:bg-orange-600 text-blue font-bold py-1.5 px-3 rounded text-xs transition shadow-sm">
                                                            Check Out
                                                        </button>
                                                    </form>
                                                </div>

                                            @elseif (!is_null($reservation->check_out))
                                                <div class="text-center">
                                                    <span
                                                        class="text-gray-400 text-xs font-bold flex items-center justify-center gap-1">
                                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd"
                                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                        Done
                                                    </span>
                                                    <span
                                                        class="block text-[10px] text-gray-400 font-mono">{{ \Carbon\Carbon::parse($reservation->check_out)->format('d M') }}</span>
                                                </div>

                                            @else
                                                <span class="text-gray-400 text-xs italic">-</span>
                                            @endif

                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('reservations.show', $reservation) }}"
                                                class="text-indigo-600 hover:text-indigo-900 mr-3">View</a>
                                            <a href="{{ route('reservations.edit', $reservation) }}"
                                                class="text-yellow-600 hover:text-yellow-900 mr-3">Edit</a>
                                            <form action="{{ route('reservations.destroy', $reservation) }}" method="POST"
                                                class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900"
                                                    onclick="return confirm('Are you sure?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
