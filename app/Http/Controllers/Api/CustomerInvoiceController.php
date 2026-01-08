<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerInvoiceController extends Controller
{
    public function index()
    {
        $userId = Auth::id(); 

        $invoices = Invoice::with(['reservation.room.roomType']) 
            ->whereHas('reservation', function ($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $invoices
        ]);
    }

    
    public function show($id)
    {
        $userId = Auth::id();

        $invoice = Invoice::with(['reservation.room'])
            ->whereHas('reservation', function ($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->find($id);

        if (!$invoice) {
            return response()->json(['message' => 'Invoice not found or access denied'], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $invoice
        ]);
    }
}
