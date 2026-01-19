@extends('layouts.admin')

@section('title', 'Ratings List')

@section('content')
<div class="py-6">
    <div class="mx-auto">

        {{-- Header & Filter --}}
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Ratings Management</h2>
                <p class="text-sm text-gray-500 mt-1">Review customer feedback and scores.</p>
            </div>

            {{-- Simple Filter Form --}}
            <form action="{{ route('ratings.index') }}" method="GET" class="flex gap-2">
                <select name="score" class="rounded-lg border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500 bg-white">
                    <option value="">All Ratings</option>
                    <option value="5" {{ request('score') == 5 ? 'selected' : '' }}>5 Stars</option>
                    <option value="4" {{ request('score') == 4 ? 'selected' : '' }}>4 Stars</option>
                    <option value="3" {{ request('score') == 3 ? 'selected' : '' }}>3 Stars</option>
                    <option value="2" {{ request('score') == 2 ? 'selected' : '' }}>2 Stars</option>
                    <option value="1" {{ request('score') == 1 ? 'selected' : '' }}>1 Star</option>
                </select>
                <input type="date" value="{{ request('date_From') }}" name="date_From" id="" class="rounded-lg border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500 bg-white">
                <input type="date" value="{{ request('date_To') }}" name="date_To" id="" class="rounded-lg border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500 bg-white">
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm hover:bg-indigo-700 transition">Filter</button>
                <a href="{{ route('ratings.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg text-sm hover:bg-gray-700 transition">Reset</a>
            </form>
        </div>

        {{-- Flash Message --}}
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 rounded shadow-sm">
                <p class="text-sm text-green-700 font-medium">{{ session('success') }}</p>
            </div>
        @endif

        {{-- Table --}}
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reservation</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Score</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Comment</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($ratings as $rating)
                            <tr class="hover:bg-gray-50 transition duration-150">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">#{{ $rating->id }}</td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <a href="{{ route('reservations.show', $rating->reservation_id) }}" class="text-sm text-indigo-600 hover:underline">
                                        Res #{{ $rating->reservation_id }}
                                    </a>
                                    <span class="block text-xs text-gray-400">{{ $rating->reservation->user->name ?? 'Unknown' }}</span>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center text-yellow-400">
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg class="w-4 h-4 {{ $i <= $rating->score ? 'fill-current' : 'text-gray-300' }}" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                        @endfor
                                        <span class="ml-2 text-gray-700 text-sm font-bold">{{ $rating->score }}</span>
                                    </div>
                                </td>

                                <td class="px-6 py-4">
                                    <p class="text-sm text-gray-600 truncate max-w-xs" title="{{ $rating->description }}">
                                        {{ $rating->description ?? 'No comment provided.' }}
                                    </p>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $rating->created_at->format('M d, Y') }}
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('ratings.show', $rating->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-3 transition">View</a>

                                    <form action="{{ route('ratings.destroy', $rating->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete this rating?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 transition">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-10 text-center text-gray-500">
                                    <div class="flex flex-col items-center">
                                    <svg class="w-12 h-12 text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                    </svg>
                                        <p>No ratings found matching your criteria.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
@endsection
