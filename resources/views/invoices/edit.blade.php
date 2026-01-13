@extends('layouts.admin')

@section('title', 'Edit Invoice')

@section('content')
<div class="py-6">
    <div class=" mx-auto">

        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Edit Invoice #{{ $invoice->id }}</h2>
            <a href="{{ route('invoices.show', $invoice->id) }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium transition">
                &larr; Back to Details
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="p-8">

                {{-- Info Box --}}
                <div class="bg-blue-50 p-4 rounded-lg border border-blue-100 mb-6 flex justify-between items-center">
                    <div>
                        <span class="block text-xs text-blue-500 font-bold uppercase">Total Amount</span>
                        <span class="text-2xl font-bold text-blue-900">${{ number_format($invoice->total_amount, 2) }}</span>
                    </div>
                    <div class="text-right text-sm text-blue-700">
                        <p>Reservation #{{ $invoice->reservation->id }}</p>
                        <p>{{ $invoice->reservation->user->name }}</p>
                    </div>
                </div>

                @if ($errors->any())
                    <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded text-red-700 text-sm">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('invoices.update', $invoice->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Payment Method</label>
                        <select name="payment_method" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm bg-white">
                            <option value="cash" {{ old('payment_method', $invoice->payment_method) == 'cash' ? 'selected' : '' }}>Cash</option>
                            <option value="credit_card" {{ old('payment_method', $invoice->payment_method) == 'credit_card' ? 'selected' : '' }}>Credit Card</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Payment Status</label>
                        <select name="payment_status" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm bg-white">
                            <option value="unpaid" {{ old('payment_status', $invoice->payment_status) == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                            <option value="paid" {{ old('payment_status', $invoice->payment_status) == 'paid' ? 'selected' : '' }}>Paid</option>
                        </select>
                    </div>

                    <div class="pt-4 border-t border-gray-100 flex justify-end gap-3">
                        <a href="{{ route('invoices.index') }}" class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">Cancel</a>
                        <button type="submit" class="px-6 py-2.5 text-sm font-bold text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 shadow-md transition transform hover:-translate-y-0.5">
                            Update Invoice
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection
