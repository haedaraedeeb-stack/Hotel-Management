@extends('layouts.admin')

@section('title', 'Create Invoice')

@section('content')
<div class="py-6">
    <div class=" mx-auto">

        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Generate Invoice</h2>
            <a href="{{ url()->previous() }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium transition">
                &larr; Cancel
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="p-8">

                {{-- Reservation Info Summary --}}
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 mb-6">
                    <h3 class="text-sm font-bold text-gray-700 uppercase tracking-wider mb-2">Reservation Details</h3>
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div><span class="text-gray-500">Reservation ID:</span> <span class="font-bold text-gray-800">#{{ $reservation->id }}</span></div>
                        <div><span class="text-gray-500">Guest:</span> <span class="font-bold text-gray-800">{{ $reservation->user->name }}</span></div>
                        <div><span class="text-gray-500">Room:</span> <span class="font-bold text-gray-800">{{ $reservation->room->room_number }}</span></div>
                    </div>
                </div>

                @if ($errors->any())
                    <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded text-red-700 text-sm">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('invoices.store', $reservation->id) }}" method="POST" class="space-y-6">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Payment Method</label>
                        <select name="payment_method" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm bg-white">
                            <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Cash</option>
                            <option value="credit_card" {{ old('payment_method') == 'credit_card' ? 'selected' : '' }}>Credit Card</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Payment Status</label>
                        <select name="payment_status" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm bg-white">
                            <option value="unpaid" {{ old('payment_status') == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                            <option value="paid" {{ old('payment_status') == 'paid' ? 'selected' : '' }}>Paid</option>
                        </select>
                    </div>

                    <div class="pt-4 border-t border-gray-100 flex justify-end">
                        <button type="submit" class="px-6 py-2.5 text-sm font-bold text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 shadow-md transition transform hover:-translate-y-0.5">
                            Generate Invoice
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection
