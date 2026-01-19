<?php

namespace App\Services;

use App\Models\Invoice;
use App\Models\Reservation;
use Carbon\Carbon;

/**
 * This service handles operations related to invoicesو including calculating total amounts,
 * creating invoices, retrieving user-specific invoices, and managing soft-deleted records.
 * Summary of InvoiceService
 * @package App\Services
 */
class InvoiceService
{
    /**
     * Calculate the total amount for a reservation
     * Summary of createInvoice
     * @param Reservation $reservation
     * @param array $data
     * @return Invoice
     */

    public function calculateTotalAmount(Reservation $reservation): float
    {
        // change to start/end date
        $start_date = Carbon::parse($reservation->start_date)->startOfDay();
        $end_date = Carbon::parse($reservation->end_date)->startOfDay();
        $nights = $start_date->diffInDays($end_date);
        $nights = ($nights > 0) ? $nights : 1;
        return $nights * $reservation->room->current_price;
    }

    /**
     * Create an invoice for a reservation
     * Summary of createInvoice
     * @param Reservation $reservation
     * @param array $data
     * @return Invoice
     */
    public function createInvoice(Reservation $reservation, array $data): Invoice
    {
        $totalAmount = $this->calculateTotalAmount($reservation);

        return Invoice::create([
            'reservation_id' => $reservation->id,
            'total_amount' => $totalAmount,
            'payment_method' => $data['payment_method'],
            'payment_status' => $data['payment_status'],
        ]);
    }

    /**
     * Retrieve paginated invoices for a specific user
     * Summary of userInvoices
     * @param mixed $userId
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function userInvoices($userId)
    {
        return Invoice::whereRelation('reservation', 'user_id', $userId)
            ->with(['reservation.room', 'reservation.room.roomType'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
    }

    /**
     * Check if a reservation has an associated invoice
     * Summary of hasInvoice
     * @param Reservation $reservation
     * @return bool
     */
    public function hasInvoice(Reservation $reservation): bool
    {
        return $reservation->invoice()->exists();
    }

    /**
     * Retrieve detailed information for a specific invoice by its ID
     * Summary of invoiceDetails
     * @param mixed $invoiceId
     * @return Invoice|\Illuminate\Database\Eloquent\Collection<int, Invoice>
     */
    public function invoiceDetails($invoiceId)
    {
        return Invoice::with([
            'reservation.user',
            'reservation.room.roomType',
            'reservation.room.roomType.services'
        ])->findOrFail($invoiceId);
    }

    /**
     * Soft delete an invoice
     * Summary of softDeleteInvoice
     * @param Invoice $invoice
     * @return bool|null
     */
    public function softDeleteInvoice(Invoice $invoice): bool
    {
        return $invoice->delete();
    }

    /**
     * Permanently delete an invoice
     * Summary of permaInvoiceDelete
     * @param Invoice $invoice
     * @return bool|null
     */
    public function permaInvoiceDelete(Invoice $invoice): bool
    {
        return $invoice->forceDelete();
    }

    /**
     * Retrieve paginated soft-deleted invoices for a specific user
     * Summary of trashedInvoices
     * @param mixed $userId
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function trashedInvoices($userId)
    {
        return Invoice::onlyTrashed()
            ->whereRelation('reservation', 'user_id', $userId)
            ->with(['reservation.room', 'reservation.room.roomType'])
            ->orderBy('deleted_at', 'desc')
            ->paginate(10);
    }

    /**
     * Retrieve detailed information for a specific soft-deleted invoice by its ID
     * Summary of trashedInvoiceDetails
     * @param mixed $invoiceId
     * @return Invoice|\Illuminate\Database\Eloquent\Collection<int, Invoice>
     */
    public function trashedInvoiceDetails($invoiceId)
    {
        return Invoice::onlyTrashed()
            ->with([
                'reservation.user',
                'reservation.room.roomType',
                'reservation.room.roomType.services'
            ])->findOrFail($invoiceId);
    }

    /**
     * Restore a soft-deleted invoice
     * Summary of restoreInvoice
     * @param Invoice $invoice
     * @return bool
     */
    public function restoreInvoice(Invoice $invoice): bool
    {
        return $invoice->restore();
    }

    /**
     * Update an invoice's payment method and status
     * Summary of updateInvoice
     * @param Invoice $invoice
     * @param array $data
     * @return bool
     */
    public function updateInvoice(Invoice $invoice, array $data): bool
    {
        return $invoice->update([
            'payment_method' => $data['payment_method'],
            'payment_status' => $data['payment_status'],
        ]);
    }

    /**
     * Retrieve all invoices with their associated users
     * Summary of getAllInvoices
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getAllInvoices() {
        return Invoice::with(['reservation.user'])->latest()->paginate(10);
    }


}
