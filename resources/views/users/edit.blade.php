<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
             edit user
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('users.update',$user->id) }}" method="POST" class="space-y-6">
                    @csrf @method('PUT')

                    <!-- الاسم -->
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">name</label>
                        <input type="text" name="name" value="{{ $user->name }}" required
                               class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <!-- البريد الإلكتروني -->
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">email</label>
                        <input type="email" name="email" value="{{ $user->email }}" required
                               class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <!-- كلمة المرور -->
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">
                             password <span class="text-sm text-gray-500">(Leave it blank if you don't want to change it.)</span>
                        </label>
                        <input type="password" name="password"
                               class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <!-- الدور -->
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">role</label>
                        <select name="role" required
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @foreach($roles as $role)
                                <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- زر التحديث -->
                    <div>
                        <button type="submit"
                                class="bg-yellow-300 hover:bg-yellow-400 text-black font-bold px-6 py-3 rounded-lg shadow-lg">
                            ✏️ update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
