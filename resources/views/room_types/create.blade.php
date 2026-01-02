{{-- @extends('layout.app')

@section('title', 'Create Room_Type')

@section('header')
    <h1>Create New Room_Type</h1>
@endsection

@section('content')
    <a href={{ route('room_types.index') }}>Back</a>
    <form action ="{{ route('room_types.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label id="type">Type:</label>
        <input type="text" name="type" id="type" required>
        <br>
        <label id="description">Description:</label>
        <textarea name="description" id="description" required></textarea>
        <br>
        <label id="base_price">Base Price:</label>
        <input type="number" name="base_price" id="base_price" step="0.01" required>
        <br>
        <label id="images">Images:</label>
        <input type="file" name="images[]" id="images" multiple>
        <br>
        <button type="submit">Send</button>
    </form>
    <div class="form-group">
        <label>Services:</label>
        <div class="row">
            @foreach ($services as $service)
                <div class="col-md-3">
                    <input type="checkbox" name="services[]" value="{{ $service->id }}" id="service_{{ $service->id }}">
                    <label for="service_{{ $service->id }}">{{ $service->name }}</label>
                </div>
            @endforeach
        </div>
    </div>
@endsection --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create New Room Type') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-4">
                <a href="{{ route('room_types.index') }}" class="text-sm text-indigo-600 hover:text-indigo-900 font-medium">
                    &larr; Back to List
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8">
                    <form action="{{ route('room_types.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <div>
                            <x-input-label for="type" :value="__('Room Type Name')" />
                            <x-text-input id="type" name="type" type="text" class="mt-1 block w-full" :value="old('type')" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('type')" />
                        </div>

                        <div>
                            <x-input-label for="description" :value="__('Description')" />
                            <textarea id="description" name="description" rows="4"
                                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                required>{{ old('description') }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('description')" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="base_price" :value="__('Base Price ($)')" />
                                <x-text-input id="base_price" name="base_price" type="number" step="0.01" class="mt-1 block w-full" required />
                                <x-input-error class="mt-2" :messages="$errors->get('base_price')" />
                            </div>

                            <div>
                                <x-input-label for="images" :value="__('Upload Images')" />
                                <input type="file" name="images[]" id="images" multiple
                                    class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none p-2">
                            </div>
                        </div>

                        <hr class="border-gray-100">

                        <div>
                            <x-input-label class="mb-4 text-lg" :value="__('Available Services')" />
                            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4 bg-gray-50 p-4 rounded-lg border border-gray-100">
                                @foreach ($services as $service)
                                    <div class="flex items-center">
                                        <input type="checkbox" name="services[]" value="{{ $service->id }}" id="service_{{ $service->id }}"
                                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                        <label for="service_{{ $service->id }}" class="ml-2 text-sm text-gray-600 cursor-pointer hover:text-indigo-600 transition">
                                            {{ $service->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-8 border-t pt-6">
                            <a href="{{ route('room_types.index') }}" class="mr-4 text-sm text-gray-600 hover:underline">Cancel</a>
                            <x-primary-button>
                                {{ __('Save Room Type') }}
                            </x-primary-button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
