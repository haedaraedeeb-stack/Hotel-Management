@extends('layouts.app')

@section('content')
<div class="container">

    <h2 class="mb-4">Trash - Deleted services</h2>

    {{-- Success message --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('serv.index') }}" class="btn btn-secondary mb-3">
        Back to services
    </a>

    <table class="table table-bordered text-center">
        <thead>
            <tr>
                <th>#</th>
                <th>Service name</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
        @forelse($services as $service)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $service->name }}</td>
                <td>{{ $service->description ?? '-' }}</td>
                <td>
                    {{-- Restore --}}
                    <form action="{{ route('serv.restore', $service->id) }}"
                          method="POST"
                          style="display:inline-block">
                        @csrf
                        @method('PATCH')

                        <button type="submit"
                                class="btn btn-sm btn-success">
                            Restore
                        </button>
                    </form>

                    {{-- Permanent delete --}}
                    <form action="{{ route('serv.forceDelete', $service->id) }}"
                          method="POST"
                          style="display:inline-block">
                        @csrf
                        @method('DELETE')

                        <button type="submit"
                                class="btn btn-sm btn-danger"
                                onclick="return confirm('Are you sure you want to permanently delete?')">
                            Delete permanently
                        </button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4">No services in trash</td>
            </tr>
        @endforelse
        </tbody>
    </table>

</div>
@endsection
