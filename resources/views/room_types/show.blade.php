@extends('layout.app')

@section('title', 'Edit Room Types')

@section('header')
    <h1>Edit Room Types</h1>
@endsection
@section('content')
    <a href={{ route('room_types.index') }}>Back</a>
    <ul>
        <li>
            <h2>{{ $roomType->type }}</h2>
            <p>{{ $roomType->description }}</p>
            <p>Base Price: {{ $roomType->base_price }}</p>
            @if ($roomType->images->isNotEmpty())
                <div style="display:flex; gap:10px; margin:10px 0;">
                    @foreach ($roomType->images as $image)
                        <img src="{{ asset('storage/' . $image->path) }}" alt="{{ $roomType->type }}" width="120">
                    @endforeach
                </div>
            @endif
    </ul>
@endsection
