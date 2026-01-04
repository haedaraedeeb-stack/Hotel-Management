@extends('layouts.app')

@section('content')
<div class="container">

    <h2 class="mb-4"> Service management </h2>

    {{-- Success messages  --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{--  Control buttons --}}
    <div class="mb-3">
        <a href="{{ route('serv.create') }}" class="btn btn-primary">
              Add a new service
        </a>

        <a href="{{ route('serv.trash') }}" class="btn btn-secondary">
            Trash
        </a>
    </div>

    {{-- Table of services  --}}
    <table class="table table-bordered text-center">
        <thead>
            <tr>
                <th>#</th>
                <th>Service name </th>
                <th>Description</th>
                <th>Room types </th>
                <th> Actions</th>
            </tr>
        </thead>

        <tbody>
        @forelse($services as $service)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $service->name }}</td>
                <td>{{ $service->description ?? '-' }}</td>

                <td>
                    @forelse($service->roomTypes as $roomType)
                        <span class="badge bg-info text-dark">
                            {{ $roomType->name }}
                        </span>
                    @empty
                        <span class="text-muted">nothing </span>
                    @endforelse
                </td>

                <td>
                    <a href="{{ route('serv.edit', $service->id) }}"
                       class="btn btn-sm btn-warning">
                        edit
                    </a>

                    <form action="{{ route('serv.destroy', $service->id) }}"
                          method="POST"
                          style="display:inline-block">
                        @csrf
                        @method('DELETE')

                        <button type="submit"
                                class="btn btn-sm btn-danger"
                                onclick="return confirm(' Are you sure ? ')">
                            delete
                        </button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5"> There are no services </td>
            </tr>
        @endforelse
        </tbody>
    </table>

</div>
@endsection
