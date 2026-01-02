@extends('layout.app')

@section('header')
    <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Reservations List
        </h2>
        <a href="{{ route('reservations.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
            + New Reservation
        </a>
    </div>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 overflow-x-auto">

                    <table class="min-w-full w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                                <th class="py-3 px-6">ID</th>
                                <th class="py-3 px-6">Guest Name</th>
                                <th class="py-3 px-6">Room Info</th>
                                <th class="py-3 px-6">Dates</th>
                                <th class="py-3 px-6">Status</th>
                                <th class="py-3 px-6 text-center">Check-In/Out</th>
                                <th class="py-3 px-6 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light">
                            @foreach ($reservations as $res)
                                <tr class="border-b border-gray-200 hover:bg-gray-50">
                                    <td class="py-3 px-6 text-gray-400">#{{ $res->id }}</td>

                                    <td class="py-3 px-6 font-medium">
                                        {{ $res->user->name ?? 'Unknown' }}
                                    </td>

                                    <td class="py-3 px-6">
                                        <div class="flex flex-col">
                                            <span class="font-bold">Room {{ $res->room->room_number }}</span>
                                            <span
                                                class="text-xs text-gray-500">{{ $res->room->roomType->type ?? '' }}</span>
                                        </div>
                                    </td>

                                    <td class="py-3 px-6">
                                        <div class="text-xs">
                                            <span class="block text-green-600">Start: {{ $res->start_date }}</span>
                                            <span class="block text-red-600">End: {{ $res->end_date }}</span>
                                        </div>
                                    </td>

                                    <td class="py-3 px-6">
                                        <span
                                            class="px-2 py-1 rounded text-xs font-bold
                                            {{ $res->status == 'confirmed'
                                                ? 'bg-green-100 text-green-700'
                                                : ($res->status == 'pending'
                                                    ? 'bg-yellow-100 text-yellow-700'
                                                    : ($res->status == 'cancelled'
                                                        ? 'bg-red-100 text-red-700'
                                                        : 'bg-gray-100 text-gray-700')) }}">
                                            {{ ucfirst($res->status) }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-6 text-center">
                                        @if ($res->status == 'confirmed' && is_null($res->check_in))
                                            <form method="POST" action="{{ route('reservations.checkIn', $res->id) }}">
                                                @csrf
                                                <button type="submit"
                                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded text-xs transition">
                                                    Check In
                                                </button>
                                            </form>
                                        @elseif (!is_null($res->check_in) && is_null($res->check_out))
                                            <div class="flex flex-col items-center gap-1">
                                                <span class="text-[10px] text-gray-500">In: {{ $res->check_in }}</span>
                                                <form method="POST"
                                                    action="{{ route('reservations.checkOut', $res->id) }}">
                                                    @csrf
                                                    <button type="submit"
                                                        class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded text-xs transition">
                                                        Check Out
                                                    </button>
                                                </form>
                                            </div>
                                        @elseif (!is_null($res->check_out))
                                            <div class="text-center">
                                                <span class="text-green-600 text-xs font-bold">Checked Out</span>
                                                <span class="block text-[10px] text-gray-400">{{ $res->check_out }}</span>
                                            </div>
                                        @else
                                            <span class="text-gray-400 text-xs italic">Waiting Confirmation</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-6 text-center">
                                        <div class="flex item-center justify-center">
                                            <a href="{{ route('reservations.show', $res->id) }}"
                                                class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </a>
                                            <a href="{{ route('reservations.edit', $res->id) }}"
                                                class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                </svg>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
@endsection
