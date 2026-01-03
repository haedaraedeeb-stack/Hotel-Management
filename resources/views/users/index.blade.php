<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
             User Management
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <!-- أزرار أعلى الجدول -->
                <div class="flex gap-4 mb-6">
                    <a href="{{ route('users.create') }}" 
                       class="inline-flex items-center bg-blue-200 hover:bg-blue-300 text-black font-bold text-lg px-6 py-3 rounded-lg shadow-lg">
                        ➕  create user
                    </a>
                    <a href="{{ route('users.trash') }}" 
                       class="inline-flex items-center bg-red-200 hover:bg-red-300 text-black font-bold text-lg px-6 py-3 rounded-lg shadow-lg">
                        🗑️ Deleted accounts
                    </a>
                </div>

                <!-- جدول المستخدمين -->
                <div class="overflow-x-auto">
                    <table class="min-w-full border border-gray-200 rounded-lg shadow-sm">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">name</th>
                                <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">email</th>
                                <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">role</th>
                                <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">procedures</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($users as $user)
                            <tr>
                                <td class="px-4 py-2 text-sm text-gray-800">{{ $user->name }}</td>
                                <td class="px-4 py-2 text-sm text-gray-800">{{ $user->email }}</td>
                                <td class="px-4 py-2 text-sm text-gray-800">
                                    {{ $user->roles->pluck('name')->join(', ') }}
                                </td>
                                <td class="px-4 py-2 text-sm text-gray-800 flex gap-3">
                                    <!-- زر تعديل -->
                                    <a href="{{ route('users.edit',$user->id) }}" 
                                       class="inline-flex items-center bg-green-200 hover:bg-green-300 text-black font-bold text-sm px-5 py-2 rounded-lg shadow-lg">
                                        ✏️ edit
                                    </a>
                                    <!-- زر حذف -->
                                    <form action="{{ route('users.destroy',$user->id) }}" method="POST" 
                                          onsubmit="return confirm('Are you sure about deleting it?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" 
                                                class="inline-flex items-center bg-red-300 hover:bg-red-400 text-black font-bold text-sm px-5 py-2 rounded-lg shadow-lg">
                                            🗑️ delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
