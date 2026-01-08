@extends('layouts.admin')

@section('title', 'Invoice Details')

@section('content')
<div class="py-6">
    <div class="max-w-4xl mx-auto">

        {{-- Actions Bar --}}
        <div class="flex justify-between items-center mb-6 print:hidden">
            <a href="{{ route('invoices.index') }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium transition">
                &larr; Back to Invoices
            </a>
            <div class="flex gap-3">
                <a href="{{ route('invoices.edit', $invoice->id) }}" class="px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 text-sm font-medium transition shadow-sm">
                    Edit Status
                </a>
                <button onclick="window.print()" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 text-sm font-medium shadow-md transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                    Print Invoice
                </button>
            </div>
        </div>

        {{-- Invoice Paper --}}
        <div class="bg-white shadow-lg rounded-xl border border-gray-200 overflow-hidden print:shadow-none print:border-none">
            <div class="p-10">

                {{-- Header --}}
                <div class="flex justify-between items-start border-b border-gray-100 pb-8 mb-8">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-800">INVOICE</h1>
                        <p class="text-gray-500 mt-1">#INV-{{ str_pad($invoice->id, 5, '0', STR_PAD_LEFT) }}</p>

                        <div class="mt-4 inline-block px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wide
                            {{ $invoice->payment_status == 'paid' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $invoice->payment_status }}
                        </div>
                    </div>
                    <div class="text-right">
                        <h2 class="text-xl font-bold text-indigo-600">Vistana Hotel</h2>
                        <p class="text-sm text-gray-500 mt-1">123 Luxury Street<br>Damascus, Syria<br>info@vistana.com</p>
                        <p class="text-sm text-gray-500 mt-2">Date: {{ $invoice->created_at->format('M d, Y') }}</p>
                    </div>
                </div>

                {{-- Bill To --}}
                <div class="grid grid-cols-2 gap-8 mb-8">
                    <div>
                        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Bill To</h3>
                        <p class="text-lg font-bold text-gray-800">{{ $invoice->reservation->user->name }}</p>
                        <p class="text-gray-500">{{ $invoice->reservation->user->email }}</p>
                    </div>
                    <div class="text-right">
                        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Payment Details</h3>
                        <p class="text-gray-800"><span class="font-medium">Method:</span> {{ ucfirst($invoice->payment_method) }}</p>
                        <p class="text-gray-800"><span class="font-medium">Reservation ID:</span> #{{ $invoice->reservation->id }}</p>
                    </div>
                </div>

                {{-- Items Table --}}
                <table class="w-full mb-8">
                    <thead class="bg-gray-50 border-y border-gray-200">
                        <tr>
                            <th class="py-3 px-4 text-left text-xs font-bold text-gray-500 uppercase">Description</th>
                            <th class="py-3 px-4 text-center text-xs font-bold text-gray-500 uppercase">Duration</th>
                            <th class="py-3 px-4 text-right text-xs font-bold text-gray-500 uppercase">Amount</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        <tr>
                            <td class="py-4 px-4 border-b border-gray-100">
                                <span class="font-bold block">Room Stay (Room {{ $invoice->reservation->room->room_number }})</span>
                                <span class="text-xs text-gray-500">Check-in: {{ $invoice->reservation->start_date }} / Out: {{ $invoice->reservation->end_date }}</span>
                            </td>
                            <td class="text-center py-4 px-4 border-b border-gray-100">
                                {{ \Carbon\Carbon::parse($invoice->reservation->start_date)->diffInDays($invoice->reservation->end_date) }} Nights
                            </td>
                            <td class="text-right py-4 px-4 border-b border-gray-100 font-bold">
                                ${{ number_format($invoice->total_amount, 2) }}
                            </td>
                        </tr>
                    </tbody>
                </table>

                {{-- Total --}}
                <div class="flex justify-end">
                    <div class="w-64">
                        <div class="flex justify-between py-2 border-b border-gray-100">
                            <span class="font-medium text-gray-600">Subtotal</span>
                            <span class="font-bold text-gray-800">${{ number_format($invoice->total_amount, 2) }}</span>
                        </div>
                        <div class="flex justify-between py-2 border-b border-gray-100">
                            <span class="font-medium text-gray-600">Tax (0%)</span>
                            <span class="font-bold text-gray-800">$0.00</span>
                        </div>
                        <div class="flex justify-between py-4">
                            <span class="text-xl font-bold text-indigo-600">Total</span>
                            <span class="text-xl font-bold text-indigo-600">${{ number_format($invoice->total_amount, 2) }}</span>
                        </div>
                    </div>
                </div>

                {{-- Footer --}}
                <div class="mt-12 text-center border-t border-gray-100 pt-8">
                    <p class="text-gray-500 text-sm">Thank you for staying with Vistana Hotel!</p>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
