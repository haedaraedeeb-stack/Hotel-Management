<?php

namespace App\Services;

use App\Models\Invoice;
use App\Models\Reservation;
use Carbon\Carbon;

class InvoiceService
{
    /**
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
        return $nights * $reservation->room->current_price;    }

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

    public function userInvoices($userId)
    {
        return Invoice::whereRelation('reservation', 'user_id', $userId)
            ->with(['reservation.room', 'reservation.room.roomType'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
    }


    public function hasInvoice(Reservation $reservation): bool
    {
        return $reservation->invoice()->exists();
    }


    public function invoiceDetails($invoiceId)
    {
        return Invoice::with([
            'reservation.user',
            'reservation.room.roomType',
            'reservation.room.roomType.services'
        ])->findOrFail($invoiceId);
    }

    public function softDeleteInvoice(Invoice $invoice): bool
    {
        return $invoice->delete();
    }

    public function permaInvoiceDelete(Invoice $invoice): bool
    {
        return $invoice->forceDelete();
    }

    public function trashedInvoices($userId)
    {
        return Invoice::onlyTrashed()
            ->whereRelation('reservation', 'user_id', $userId)
            ->with(['reservation.room', 'reservation.room.roomType'])
            ->orderBy('deleted_at', 'desc')
            ->paginate(10);
    }

    public function trashedInvoiceDetails($invoiceId)
    {
        return Invoice::onlyTrashed()
            ->with([
                'reservation.user',
                'reservation.room.roomType',
                'reservation.room.roomType.services'
            ])->findOrFail($invoiceId);
    }

    public function restoreInvoice(Invoice $invoice): bool
    {
        return $invoice->restore();
    }

    public function updateInvoice(Invoice $invoice, array $data): bool
    {
        return $invoice->update([
            'payment_method' => $data['payment_method'],
            'payment_status' => $data['payment_status'],
        ]);
    }
public function getAllInvoices() {
    return Invoice::with(['reservation.user'])->latest()->paginate(10);
}


}
