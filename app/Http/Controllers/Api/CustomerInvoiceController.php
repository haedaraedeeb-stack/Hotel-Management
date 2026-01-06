<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;

class CustomerInvoiceController extends Controller
{
    /**
     * عرض الفاتورة الحالية أولاً، وإذا لم يتم تحديدها يعرض جميع الفواتير
     */
    public function getInvoices(Request $request, $id = null)
    {
        // نحدد الزبون من الواجهة
        $userId = $request->query('user_id');

        if (!$userId) {
            return response()->json([
                'message' => 'user_id is required'
            ], 400);
        }

        /**
         *   عرض الفاتورة الحالية فقط
         */
        if ($id !== null) {
            $invoice = Invoice::with('reservation')
                ->whereHas('reservation', function ($q) use ($userId) {
                    $q->where('user_id', $userId);
                })
                ->find($id);

            if (!$invoice) {
                return response()->json([
                    'message' => 'Invoice not found'
                ], 404);
            }

            return response()->json([
                'invoice' => $invoice
            ]);
        }

        /**
         *  عرض جميع الفواتير
         */
        $invoices = Invoice::with('reservation')
            ->whereHas('reservation', function ($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->get();

        return response()->json([
            'invoices' => $invoices
        ]);
    }
}