<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Deleted Users
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                <!-- زر الرجوع -->
                <div class="mb-6">
                    <a href="{{ route('users.index') }}" 
                       class="inline-flex items-center bg-blue-200 hover:bg-blue-300 text-black font-bold px-6 py-3 rounded-lg shadow-lg">
                        ⬅️ back
                    </a>
                </div>

                <!-- جدول المستخدمين المحذوفين -->
                <div class="overflow-x-auto">
                    <table class="min-w-full border border-gray-200 rounded-lg shadow-sm">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">name</th>
                                <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">email</th>
                                <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">procedures</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($users as $user)
                            <tr>
                                <td class="px-4 py-2 text-sm text-gray-800">{{ $user->name }}</td>
                                <td class="px-4 py-2 text-sm text-gray-800">{{ $user->email }}</td>
                                <td class="px-4 py-2 text-sm text-gray-800 flex gap-3">
                                    <!-- زر الاسترجاع -->
                                    <form action="{{ route('users.restore',$user->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" 
                                                class="inline-flex items-center bg-green-200 hover:bg-green-300 text-black font-bold px-4 py-2 rounded-lg shadow">
                                            ♻️ restore
                                        </button>
                                    </form>
                                    <!-- زر الحذف النهائي -->
                                    <form action="{{ route('users.forceDelete',$user->id) }}" method="POST" 
                                          onsubmit="return confirm('Are you sure about the final deletion?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" 
                                                class="inline-flex items-center bg-red-300 hover:bg-red-400 text-black font-bold px-4 py-2 rounded-lg shadow">
                                            🗑️ Permanent deletion
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
