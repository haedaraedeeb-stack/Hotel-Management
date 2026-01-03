@extends('layouts.app')

@section('content')
<div class="container">

    <h2 class="mb-4"> edit service </h2>

    {{-- Errors--}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('services.update', $service->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Service name  --}}
        <div class="mb-3">
            <label class="form-label"> service name </label>
            <input type="text"
                   name="name"
                   class="form-control"
                   value="{{ old('name', $service->name) }}"
                   required>
        </div>

        {{-- Description --}}
        <div class="mb-3">
            <label class="form-label">description</label>
            <textarea name="description"
                      class="form-control"
                      rows="3">{{ old('description', $service->description) }}</textarea>
        </div>

        {{-- Room types --}}
        <div class="mb-3">
            <label class="form-label"> room types </label>

            @foreach($roomTypes as $roomType)
                <div class="form-check">
                    <input class="form-check-input"
                           type="checkbox"
                           name="room_types[]"
                           value="{{ $roomType->id }}"
                           id="roomType{{ $roomType->id }}"
                           {{ $service->roomTypes->contains($roomType->id) ? 'checked' : '' }}>

                    <label class="form-check-label"
                           for="roomType{{ $roomType->id }}">
                        {{ $roomType->name }}
                    </label>
                </div>
            @endforeach
        </div>

        {{-- Buttons --}}
        <button type="submit" class="btn btn-success">
             Update
        </button>

        <a href="{{ route('services.index') }}" class="btn btn-secondary">
            Back
        </a>

    </form>
</div>
@endsection