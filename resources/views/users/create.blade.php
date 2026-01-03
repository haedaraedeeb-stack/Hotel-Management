<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            إضافة مستخدم جديد
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('users.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- الاسم -->
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">name</label>
                        <input type="text" name="name" required
                               class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <!-- البريد الإلكتروني -->
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">email</label>
                        <input type="email" name="email" required
                               class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <!-- كلمة المرور -->
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">password</label>
                        <input type="password" name="password" required
                               class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <!-- الدور -->
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">role</label>
                        <select name="role" required
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @foreach($roles as $role)
                                <option value="{{ $role->name }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- زر الحفظ -->
                    <div>
                        <button type="submit"
                                class="bg-green-500 hover:bg-green-600 text-black font-bold px-6 py-3 rounded-lg shadow-lg">
                            💾 حفظ
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
