@extends('layouts.admin')

@section('title', 'Create Service')

@section('content')
<div class="py-6">
    <div class="max-w-3xl mx-auto">

        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Add New Service</h2>
            <a href="{{ route('serv.index') }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium transition">
                &larr; Back to Services
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="p-8">

                @if ($errors->any())
                    <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded text-red-700 text-sm">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                        </ul>
                    </div>
                @endif

                @can('create services')
                    <form action="{{ route('serv.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Service Name</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required autofocus
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                placeholder="e.g. Free Wi-Fi">
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                            <textarea name="description" id="description" rows="3"
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                placeholder="Brief description...">{{ old('description') }}</textarea>
                        </div>

                        <div class="border-t border-gray-100 my-4"></div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-3">Available in Room Types:</label>
                            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 grid grid-cols-2 md:grid-cols-3 gap-3">
                                @foreach($roomTypes as $roomType)
                                    <label class="inline-flex items-center cursor-pointer group">
                                        <input type="checkbox" name="room_types[]" value="{{ $roomType->id }}"
                                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 h-4 w-4">
                                        <span class="ml-2 text-sm text-gray-700 group-hover:text-indigo-700">{{ $roomType->type }}</span>
                                    </label>
                                @endforeach
                            </div>
                            @if($roomTypes->isEmpty())
                                <p class="text-xs text-gray-500 mt-2">No room types available.</p>
                            @endif
                        </div>

                        <div class="flex items-center justify-end pt-4 border-t border-gray-100">
                            <a href="{{ route('serv.index') }}" class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 mr-3 transition">
                                Cancel
                            </a>
                            <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 shadow-md transition transform hover:-translate-y-0.5">
                                Save Service
                            </button>
                        </div>
                        </form>
                @endcan

            </div>
        </div>
    </div>
</div>
@endsection