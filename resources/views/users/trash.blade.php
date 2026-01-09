@extends('layout.app')

@section('title', 'Deleted Users')

@section('header')
    <div style="padding: 20px; background-color: #ffeeba; border-bottom: 1px solid #ffdf7e; display: flex; justify-content: space-between; align-items: center;">
        <h2 style="margin: 0; color: #856404;">Deleted Users (Trash)</h2>
        <a href="{{ route('users.index') }}" style="text-decoration: none; color: #856404; font-weight: bold;">&larr; Back to Active Users</a>
    </div>
@endsection

@section('content')
    <div style="margin: 20px;">

        @if(session('success'))
            <div style="background-color: #d4edda; color: #155724; padding: 10px; margin-bottom: 15px;">{{ session('success') }}</div>
        @endif

        @can('view_user')
        <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; border-collapse: collapse; font-family: sans-serif; border-color: #ddd;">
            <thead>
                <tr style="background-color: #f8f9fa;">
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Deleted At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td style="color: #dc3545;">{{ $user->deleted_at->format('Y-m-d') }}</td>
                        <td>
                            {{-- استرجاع --}}
                            @can('edit_user')
                            <form action="{{ route('users.restore', $user->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" style="background: none; border: none; color: #28a745; cursor: pointer; font-weight: bold; margin-right: 10px;">Restore ♻️</button>
                            </form>
                            @endcan

                            {{-- حذف نهائي --}}
                            @can('delete_user')
                            <form action="{{ route('users.forceDelete', $user->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('PERMANENTLY DELETE? This cannot be undone!')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background: none; border: none; color: #dc3545; cursor: pointer; font-weight: bold;">Force Delete ❌</button>
                            </form>
                            @endcan
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align: center; color: #999;">Trash is empty.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        @endcan
    </div>
@endsection
