@extends('layout.app')

@section('title', 'Room Types List')

@section('header')
    <h1>Room Types List</h1>
@endsection

@section('content')
    <a href="{{ route('room_types.create') }}">Create</a>

    <ul>
        @foreach ($roomTypes as $type)
            <li>
                <h2>{{ $type->type }}</h2>
                <p>{{ $type->description }}</p>
                <p>Base Price: {{ $type->base_price }}$</p>

                @if ($type->images->isNotEmpty())
                    <div style="display:flex; gap:10px; margin:10px 0;">
                        @foreach ($type->images as $image)
                            <img
                                src="{{ asset('storage/' . $image->path) }}"
                                alt="{{ $type->type }}"
                                width="120"
                            >
                        @endforeach
                    </div>
                @else
                    <p>No images available</p>
                @endif
                    <a href="{{ route('room_types.show', $type->id) }}">Show</a>
                <form action="{{ route('room_types.edit', $type->id) }}" method="GET" style="display:inline;">
                    @csrf
                    @method('PUT')
                    <button type="submit">Edit</button>
                </form>

                <form action="{{ route('room_types.destroy', $type->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Are you sure?')">
                        Delete
                    </button>
                </form>
            </li>
            <hr>
        @endforeach
    </ul>
@endsection
