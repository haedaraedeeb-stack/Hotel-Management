<?php

namespace App\Services;

use App\Models\Invoice;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Log;

/**
 * This service handles API operations related to invoices,
 * including retrieval of all invoices and specific invoices by ID for the authenticated user.
 * Summary of ApiInvoiceService
 * @package App\Services
 */
class ApiInvoiceService
{
    /**
     * Get all invoices for the authenticated API user
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
            Log::error( $e->getMessage());
            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => 'Error',
            ], 500));
        }
    }

    /**
     * Get a specific invoice by ID for the authenticated API user
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
            Log::error( $e->getMessage());
            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => 'Error',
            ], 500));
        }
    }
}
