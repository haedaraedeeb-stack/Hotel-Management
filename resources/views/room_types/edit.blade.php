@extends('layouts.admin')

@section('title', 'Edit Room Type')

@section('content')
    <div class="py-6">
        <div class="max-w-4xl mx-auto">

            {{-- Header --}}
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Edit Room Type: {{ $roomType->type }}</h1>
                <a href="{{ route('room_types.index') }}"
                    class="text-indigo-600 hover:text-indigo-800 text-sm font-medium transition">
                    &larr; Back to List
                </a>
            </div>

            {{-- Form Card --}}
            @can('edit room_types')
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-8">

                        <form action="{{ route('room_types.update', $roomType->id) }}" method="POST"
                            enctype="multipart/form-data" class="space-y-6">
                            @csrf
                            @method('PUT')

                            {{-- Type Name --}}
                            <div>
                                <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Room Type
                                    Name</label>
                                <input type="text" name="type" id="type" value="{{ old('type', $roomType->type) }}"
                                    required
                                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                @error('type')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Description --}}
                            <div>
                                <label for="description"
                                    class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                                <textarea name="description" id="description" rows="4" required
                                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('description', $roomType->description) }}</textarea>
                                @error('description')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Price & New Images --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="base_price" class="block text-sm font-medium text-gray-700 mb-1">Base Price
                                        ($)</label>
                                    <input type="number" name="base_price" id="base_price" step="0.01"
                                        value="{{ old('base_price', $roomType->base_price) }}" required
                                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    @error('base_price')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="images" class="block text-sm font-medium text-gray-700 mb-1">Add New Images
                                        (Optional)</label>
                                    <input type="file" name="images[]" id="images" multiple
                                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 border border-gray-300 rounded-lg">
                                    <p class="text-xs text-gray-500 mt-1">Uploading new images will add to existing ones.</p>
                                </div>
                            </div>

                            {{-- Existing Images Preview --}}
                            @if ($roomType->images->isNotEmpty())
                                <div class="mt-4 p-4 bg-gray-50 rounded-lg border border-dashed border-gray-300">
                                    <p class="text-sm font-medium text-gray-700 mb-3">Current Images:</p>
                                    <div class="flex flex-wrap gap-4">
                                        @foreach ($roomType->images as $image)
                                            <div class="relative group">
                                                <img src="{{ asset('storage/' . $image->path) }}" alt="Room Image"
                                                    class="w-24 h-24 object-cover rounded-md shadow-sm">

                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <hr class="border-gray-100">

                            {{-- Services Section --}}
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Included Services</h3>
                                <div
                                    class="bg-gray-50 p-6 rounded-xl border border-gray-200 grid grid-cols-2 md:grid-cols-4 gap-4">
                                    @foreach ($services as $service)
                                        <label class="inline-flex items-center cursor-pointer group">
                                            <input type="checkbox" name="services[]" value="{{ $service->id }}"
                                                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 h-5 w-5"
                                                @if ($roomType->services->contains($service->id)) checked @endif>
                                            <span
                                                class="ml-2 text-sm text-gray-700 group-hover:text-indigo-700 transition">{{ $service->name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            {{-- Actions --}}
                            <div class="flex items-center justify-end gap-4 pt-4 border-t border-gray-100">
                                <a href="{{ route('room_types.index') }}"
                                    class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                                    Cancel
                                </a>
                                <button type="submit"
                                    class="px-6 py-2.5 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 shadow-md transition transform hover:-translate-y-0.5">
                                    Update Changes
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            @endcan

        </div>
    </div>
@endsection
