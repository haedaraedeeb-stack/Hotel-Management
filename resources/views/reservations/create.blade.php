@extends('layout.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Create New Reservation
    </h2>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    @if ($errors->any())
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                            <strong class="font-bold">Oops!</strong>
                            <span class="block sm:inline">Please check the errors below.</span>
                            <ul class="mt-2 list-disc list-inside text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('reservations.store') }}" method="POST">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            <div class="col-span-1">
                                <label for="user_id" class="block text-sm font-medium text-gray-700">Guest Name</label>
                                <select name="user_id" id="user_id"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <option value="" disabled selected>Select a Guest...</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}"
                                            {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }} ({{ $user->email }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-span-1">
                                <label for="room_id" class="block text-sm font-medium text-gray-700">Room</label>
                                <select name="room_id" id="room_id"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <option value="" disabled selected>Select Available Room...</option>
                                    @foreach ($rooms as $room)
                                        <option value="{{ $room->id }}"
                                            {{ old('room_id') == $room->id ? 'selected' : '' }}>
                                            Room {{ $room->room_number }} - {{ $room->roomType->type }}
                                            ({{ $room->current_price }}$/Night)
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-span-1">
                                <label for="start_date" class="block text-sm font-medium text-gray-700">Check-In
                                    Date</label>
                                <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}"
                                    min="{{ date('Y-m-d') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>

                            <div class="col-span-1">
                                <label for="end_date" class="block text-sm font-medium text-gray-700">Check-Out Date</label>
                                <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}"
                                    min="{{ date('Y-m-d') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>

                        </div>

                        <div class="mt-6 flex justify-end">
                            <a href="{{ route('reservations.index') }}"
                                class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md mr-2 hover:bg-gray-300">Cancel</a>
                            <button type="submit"
                                class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">Create
                                Reservation</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
