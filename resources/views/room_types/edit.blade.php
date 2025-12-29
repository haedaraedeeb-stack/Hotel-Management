@extends('layout.app')

@section('title' , 'edit Room_Type')

@section('header')
    <h1>Edit Room_Type</h1>
@endsection

@section('content')
        <a href={{ route('room_types.index') }}>Back</a>
        <form action ="{{ route('room_types.update' , $roomType->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <label id="type">Type:</label>
            <input type="text" name="type" id="type" value="{{ $roomType->type }}" required>
            <br>
            <label id="description">Description:</label>
            <textarea name="description" id="description" required>{{ $roomType->description }}</textarea>
            <br>
            <label id="base_price">Base Price:</label>
            <input type="number" name="base_price" id="base_price" step="0.01" value="{{ $roomType->base_price }}" required>
            <br>
            <label id="images">Images:</label>
            <input type="file" name="images[]" id="images"  multiple >
            <br>
            <button type="submit">Update</button>
        </form>
@endsection
