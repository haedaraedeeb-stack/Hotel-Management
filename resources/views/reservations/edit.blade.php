@extends('layout.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Edit Reservation #{{ $reservation->id }}
    </h2>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    @if ($errors->any())
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                            <ul class="list-disc list-inside text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('reservations.update', $reservation->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            <div class="col-span-1">
                                <label class="block text-sm font-medium text-gray-700">Guest Name</label>
                                <input type="text" value="{{ $reservation->user->name }}" disabled
                                    class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 shadow-sm sm:text-sm text-gray-500">
                            </div>

                            <div class="col-span-1">
                                <label for="room_id" class="block text-sm font-medium text-gray-700">Room</label>
                                <select name="room_id" id="room_id"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    @foreach ($rooms as $room)
                                        <option value="{{ $room->id }}"
                                            {{ old('room_id', $reservation->room_id) == $room->id ? 'selected' : '' }}>
                                            Room {{ $room->room_number }} ({{ $room->roomType->type }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-span-1">
                                <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
                                <input type="date" name="start_date" id="start_date"
                                    value="{{ old('start_date', $reservation->start_date) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>

                            <div class="col-span-1">
                                <label for="end_date" class="block text-sm font-medium text-gray-700">End Date</label>
                                <input type="date" name="end_date" id="end_date"
                                    value="{{ old('end_date', $reservation->end_date) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>

                            <div class="col-span-2">
                                <label for="status" class="block text-sm font-medium text-gray-700">Reservation
                                    Status</label>
                                <select name="status" id="status"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <option value="pending" {{ $reservation->status == 'pending' ? 'selected' : '' }}>
                                        Pending (Waiting Approval)</option>
                                    <option value="confirmed" {{ $reservation->status == 'confirmed' ? 'selected' : '' }}>
                                        Confirmed (Approved)</option>
                                    <option value="cancelled" {{ $reservation->status == 'cancelled' ? 'selected' : '' }}>
                                        Cancelled</option>
                                    <option value="rejected" {{ $reservation->status == 'rejected' ? 'selected' : '' }}>
                                        Rejected</option>
                                </select>
                                <p class="text-xs text-gray-500 mt-1">Changing status to 'Confirmed' will reserve the room.
                                </p>
                            </div>

                            <div class="col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Notes (Read Only)</label>
                                <textarea disabled class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 shadow-sm sm:text-sm" rows="2">{{ $reservation->notes ?? 'No notes' }}</textarea>
                            </div>

                        </div>

                        <div class="mt-6 flex justify-end">
                            <a href="{{ route('reservations.index') }}"
                                class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md mr-2 hover:bg-gray-300">Cancel</a>
                            <button type="submit"
                                class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">Update
                                Reservation</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
