@extends('layouts.admin')

@section('title', 'View Room Type')

@section('content')
<div class="py-6">
    <div class="max-w-5xl mx-auto">

        {{-- Header & Actions --}}
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">{{ $roomType->type }}</h1>
                <div class="flex items-center mt-2 text-sm text-gray-500">
                    <span class="bg-green-100 text-green-800 px-2.5 py-0.5 rounded-full font-bold mr-2">
                        ${{ number_format($roomType->base_price, 2) }} / Night
                    </span>
                    <span>Created {{ $roomType->created_at->format('M d, Y') }}</span>
                </div>
            </div>

            <div class="flex gap-3">
                <a href="{{ route('room_types.index') }}" class="px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 text-sm font-medium transition">
                    Back
                </a>
                <a href="{{ route('room_types.edit', $roomType->id) }}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 text-sm font-medium shadow-sm transition">
                    Edit Details
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- Left Column: Images (Gallery Style) --}}
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    @if ($roomType->images->isNotEmpty())
                        {{-- Main Large Image --}}
                        <div class="h-96 w-full bg-gray-100 relative">
                            <img src="{{ asset('storage/' . $roomType->images->first()->path) }}"
                                 alt="{{ $roomType->type }}"
                                 class="w-full h-full object-cover">
                        </div>

                        {{-- Thumbnails --}}
                        @if($roomType->images->count() > 1)
                            <div class="p-4 bg-gray-50 border-t border-gray-100 flex gap-3 overflow-x-auto">
                                @foreach ($roomType->images as $image)
                                    <img src="{{ asset('storage/' . $image->path) }}"
                                         class="w-20 h-20 object-cover rounded-lg border-2 border-transparent hover:border-indigo-500 cursor-pointer transition">
                                @endforeach
                            </div>
                        @endif
                    @else
                        <div class="h-64 flex items-center justify-center bg-gray-50 text-gray-400">
                            <span class="text-lg">No Images Available</span>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Right Column: Info --}}
            <div class="space-y-6">

                {{-- Description Card --}}
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-2">Description</h3>
                    <p class="text-gray-600 leading-relaxed">
                        {{ $roomType->description }}
                    </p>
                </div>

                {{-- Services Card --}}
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-2 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Included Services
                    </h3>

                    @if($roomType->services->isNotEmpty())
                        <div class="flex flex-wrap gap-2">
                            @foreach ($roomType->services as $service)
                                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium bg-indigo-50 text-indigo-700 border border-indigo-100">
                                    {{ $service->name }}
                                </span>
                            @endforeach
                        </div>
                    @else
                        <p class="text-sm text-gray-500 italic">No services listed for this room type.</p>
                    @endif
                </div>

                {{-- Quick Actions --}}
                <div class="bg-red-50 p-4 rounded-xl border border-red-100">
                    <h4 class="text-sm font-bold text-red-800 mb-2">Danger Zone</h4>
                    <p class="text-xs text-red-600 mb-3">Deleting this will remove it permanently.</p>
                    <form action="{{ route('room_types.destroy', $roomType->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Are you sure? This cannot be undone.')"
                                class="w-full bg-red-600 text-white py-2 rounded-lg text-sm font-medium hover:bg-red-700 transition">
                            Delete Room Type
                        </button>
                    </form>
                </div>

            </div>
        </div>

    </div>
</div>
@endsection
