@extends('layouts.app')

@section('content')
<div class="container">

    <h2 class="mb-4"> Add a new service </h2>

    {{-- Show errors  --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('serv.store') }}" method="POST">
        @csrf

        {{-- Service name  --}}
        <div class="mb-3">
            <label class="form-label"> service name </label>
            <input type="text"
                   name="name"
                   class="form-control"
                   value="{{ old('name') }}"
                   required>
        </div>

        {{-- Description --}}
        <div class="mb-3">
            <label class="form-label">description</label>
            <textarea name="description"
                      class="form-control"
                      rows="3">{{ old('description') }}</textarea>
        </div>

        {{--  Link room types  --}}
        <div class="mb-3">
            <label class="form-label">room types </label>

            @foreach($roomTypes as $roomType)
                <div class="form-check">
                    <input class="form-check-input"
                           type="checkbox"
                           name="room_types[]"
                           value="{{ $roomType->id }}"
                           id="roomType{{ $roomType->id }}">

                    <label class="form-check-label"
                           for="roomType{{ $roomType->id }}">
                        {{ $roomType->name }}
                    </label>
                </div>
            @endforeach
        </div>

        {{-- Buttons --}}
        <button type="submit" class="btn btn-success">
            Save
        </button>

        <a href="{{ route('serv.index') }}" class="btn btn-secondary">
            Back
        </a>

    </form>
</div>
@endsection
