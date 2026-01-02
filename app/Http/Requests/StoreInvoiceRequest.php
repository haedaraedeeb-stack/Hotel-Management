<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInvoiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->hasRole(['admin', 'manager', 'receptionist']);
    }

    public function rules(): array
    {
        return [
            'payment_method' => 'required|in:cash,credit_card',
            'payment_status' => 'required|in:paid,unpaid',
        ];
    }
}