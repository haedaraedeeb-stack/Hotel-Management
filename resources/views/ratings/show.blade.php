@extends('layouts.admin')

@section('title', 'Rating Details')

@section('content')
<div class="py-6">
    <div class="max-w-5xl mx-auto">

        {{-- Header & Back --}}
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                    <svg class="w-6 h-6 text-yellow-500" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    Rating Details #{{ $rating->id }}
                </h2>
                <p class="text-sm text-gray-500 mt-1">Review submitted on {{ $rating->created_at->format('M d, Y') }}</p>
            </div>
            <a href="{{ route('ratings.index') }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium transition flex items-center">
                &larr; Back to Ratings
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Left Column: Rating Info & Review --}}
            <div class="lg:col-span-2 space-y-6">

                {{-- 1. Rating Score Card --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b border-gray-100 pb-2">Guest Review</h3>

                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center gap-1">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-8 h-8 {{ $i <= $rating->score ? 'text-yellow-400' : 'text-gray-200' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                @endfor
                                <span class="ml-3 text-2xl font-bold text-gray-800">{{ $rating->score }}/5</span>
                            </div>
                            <span class="text-xs text-gray-400 font-mono">ID: #{{ $rating->id }}</span>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-100 italic text-gray-700">
                            "{{ $rating->description ?? 'No written comment provided.' }}"
                        </div>
                    </div>
                </div>

                {{-- 2. Reservation Details --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <h3 class="text-lg font-semibold text-gray-800">Reservation Info</h3>
                    </div>
                    <div class="p-6 grid grid-cols-2 gap-4">
                        @if($rating->reservation)
                            <div>
                                <p class="text-xs text-gray-500 uppercase font-bold">Reservation ID</p>
                                <a href="{{ route('reservations.show', $rating->reservation->id) }}" class="text-indigo-600 hover:underline font-medium">
                                    #{{ $rating->reservation->id }}
                                </a>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 uppercase font-bold">Status</p>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    {{ ucfirst($rating->reservation->status) }}
                                </span>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 uppercase font-bold">Check-In</p>
                                <p class="text-sm font-medium text-gray-800">{{ $rating->reservation->start_date }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 uppercase font-bold">Check-Out</p>
                                <p class="text-sm font-medium text-gray-800">{{ $rating->reservation->end_date }}</p>
                            </div>
                        @else
                            <p class="text-gray-500 text-sm col-span-2">Reservation data not available.</p>
                        @endif
                    </div>
                </div>

            </div>

            {{-- Right Column: Room & Actions --}}
            <div class="space-y-6">

                {{-- 3. Room Info --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        <h3 class="text-lg font-semibold text-gray-800">Room Details</h3>
                    </div>
                    <div class="p-6">
                        @if($rating->reservation && $rating->reservation->room)
                            <div class="mb-4 text-center">
                                <span class="block text-3xl font-bold text-gray-800">{{ $rating->reservation->room->room_number }}</span>
                                <span class="text-sm text-gray-500 uppercase tracking-wide">{{ $rating->reservation->room->roomType->type ?? 'Room' }}</span>
                            </div>

                            <div class="space-y-3">
                                <div class="flex justify-between border-b border-gray-100 pb-2">
                                    <span class="text-sm text-gray-600">Price</span>
                                    <span class="text-sm font-bold text-gray-900">${{ number_format($rating->reservation->room->price_per_night) }}</span>
                                </div>
                                <div class="flex justify-between border-b border-gray-100 pb-2">
                                    <span class="text-sm text-gray-600">View</span>
                                    <span class="text-sm font-medium text-gray-900">{{ ucfirst($rating->reservation->room->view) }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-600">Floor</span>
                                    <span class="text-sm font-medium text-gray-900">{{ $rating->reservation->room->floor }}</span>
                                </div>
                            </div>

                            <div class="mt-6 pt-4 border-t border-gray-100 text-center">
                                <a href="{{ route('rooms.show', $rating->reservation->room->id) }}" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium">View Full Room Details &rarr;</a>
                            </div>
                        @else
                            <p class="text-gray-500 text-sm text-center">Room info not found.</p>
                        @endif
                    </div>
                </div>

                {{-- 4. Actions --}}
                <div class="bg-red-50 rounded-xl border border-red-100 p-6">
                    <h4 class="text-sm font-bold text-red-800 uppercase mb-2">Management</h4>
                    <p class="text-xs text-red-600 mb-4">If this review violates policy, you can remove it.</p>

                    <form action="{{ route('ratings.destroy', $rating->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this rating?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full bg-white border border-red-300 text-red-700 py-2 rounded-lg text-sm font-medium hover:bg-red-50 transition shadow-sm">
                            Delete Rating
                        </button>
                    </form>
                </div>

            </div>
        </div>

    </div>
</div>
@endsection
