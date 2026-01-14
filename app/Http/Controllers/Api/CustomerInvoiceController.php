<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Services\ApiInvoiceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * This controller manages API requests related to customer invoices, including
 * listing all invoices and viewing specific invoice details for the authenticated user.
 * Summary of CustomerInvoiceController
 * @package App\Http\Controllers\Api
 */
class CustomerInvoiceController extends Controller
{
    protected $service;

    /**
     * Constructor to initialize the API invoice service.
     * Summary of __construct
     * @param ApiInvoiceService $apiInvoiceService
     * @return void
     */

    public function __construct(ApiInvoiceService $apiInvoiceService)
    {
        $this->service =  $apiInvoiceService;
    }

    /**
     * List all invoices
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
     * Show a specific invoice by ID
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
