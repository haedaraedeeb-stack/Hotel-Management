@extends('layout.app')

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
@endsection
