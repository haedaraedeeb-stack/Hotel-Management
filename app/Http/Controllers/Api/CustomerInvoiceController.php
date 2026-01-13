<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Services\ApiInvoiceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerInvoiceController extends Controller
{
    protected $service;

    public function __construct(ApiInvoiceService $apiInvoiceService)
    {
        $this->service =  $apiInvoiceService;
    }

    /**
     * Summary of index
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $invoices = $this->service->getAllInvoice();
        return response()->json([
            'status' => 'success',
            'data' => $invoices
        ]);
    }

    /**
     * Summary of show
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    
    public function show($id)
    {
       $invoice = $this->service->getInvoiceById($id);

        if (!$invoice) {
            return response()->json(['message' => 'Invoice not found or access denied'], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $invoice
        ]);
    }
}
