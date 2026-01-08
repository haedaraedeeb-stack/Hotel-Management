@extends('layouts.admin')

@section('title', 'Create Room Type')

@section('content')
<div class="py-6">
    <div class="max-w-4xl mx-auto">

        {{-- Header & Back Link --}}
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Create New Room Type</h1>
            <a href="{{ route('room_types.index') }}"
               class="flex items-center gap-2 text-sm text-indigo-600 hover:text-indigo-800 font-medium transition">
               <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
               Back to List
            </a>
        </div>

        {{-- Main Form Card --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-8">

                <form action="{{ route('room_types.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    {{-- Room Type Name --}}
                    <div>
                        <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Room Type Name</label>
                        <input type="text" id="type" name="type" value="{{ old('type') }}" required autofocus
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition duration-150 ease-in-out sm:text-sm"
                            placeholder="e.g. Deluxe Suite">
                        @error('type') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Description --}}
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                        <textarea id="description" name="description" rows="4" required
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition duration-150 ease-in-out sm:text-sm"
                            placeholder="Describe the room features...">{{ old('description') }}</textarea>
                        @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Grid: Price & Image --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        {{-- Base Price --}}
                        <div>
                            <label for="base_price" class="block text-sm font-medium text-gray-700 mb-1">Base Price ($)</label>
                            <div class="relative rounded-md shadow-sm">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                    <span class="text-gray-500 sm:text-sm">$</span>
                                </div>
                                <input type="number" name="base_price" id="base_price" step="0.01" required
                                    class="block w-full rounded-lg border-gray-300 pl-7 pr-12 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    placeholder="0.00">
                            </div>
                            @error('base_price') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        {{-- Images Upload --}}
                        <div>
                            <label for="images" class="block text-sm font-medium text-gray-700 mb-1">Upload Images</label>
                            <input type="file" name="images[]" id="images" multiple
                                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 cursor-pointer border border-gray-300 rounded-lg bg-gray-50">
                            <p class="text-xs text-gray-500 mt-1">PNG, JPG, GIF up to 2MB</p>
                        </div>
                    </div>

                    <div class="border-t border-gray-100 my-6"></div>

                    {{-- Services Selection (Checkboxes) --}}
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Available Services</h3>
                        <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
                                @foreach ($services as $service)
                                    <label class="inline-flex items-center group cursor-pointer">
                                        <input type="checkbox" name="services[]" value="{{ $service->id }}"
                                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 cursor-pointer h-5 w-5 transition duration-150 ease-in-out">
                                        <span class="ml-2 text-sm text-gray-700 group-hover:text-indigo-700 font-medium transition">{{ $service->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                            @if($services->isEmpty())
                                <p class="text-sm text-gray-500 italic text-center">No services found. <a href="{{ route('serv.create') }}" class="text-indigo-600 hover:underline">Add services first</a>.</p>
                            @endif
                        </div>
                    </div>

                    {{-- Actions Buttons --}}
                    <div class="flex items-center justify-end gap-4 pt-4">
                        <a href="{{ route('room_types.index') }}"
                           class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:ring-4 focus:outline-none focus:ring-gray-200 transition">
                            Cancel
                        </a>
                        <button type="submit"
                                class="px-5 py-2.5 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 focus:ring-4 focus:outline-none focus:ring-indigo-300 shadow-md transition transform hover:-translate-y-0.5">
                            Save Room Type
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection
