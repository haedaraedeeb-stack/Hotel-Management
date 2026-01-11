<?php

namespace App\Services;

use App\Models\Invoice;
use Illuminate\Support\Facades\Log;

class ApiInvoiceService
{
    /**
     * Summary of getAllInvoice
     * @return \Illuminate\Database\Eloquent\Collection<int, Invoice>
     */
    public function getAllInvoice()
    {
        try {
            $userId = auth('api')->id();

            $invoices = Invoice::with(['reservation.room.roomType'])
                ->whereHas('reservation', function ($q) use ($userId) {
                    $q->where('user_id', $userId);
                })
                ->get();

            return $invoices;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            abort(500);
        }
    }

    /**
     * Summary of getInvoiceById
     * @param mixed $invoiceId
     * @return Invoice|\Illuminate\Database\Eloquent\Collection<int, Invoice>|null
     */
    public function getInvoiceById($invoiceId)
    {
        try {
            $userId = auth('api')->id();

            $invoice = Invoice::with(['reservation.room'])
                ->whereHas('reservation', function ($q) use ($userId) {
                    $q->where('user_id', $userId);
                })
                ->find($invoiceId);

            return $invoice;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            abort(500);
        }
    }
}
