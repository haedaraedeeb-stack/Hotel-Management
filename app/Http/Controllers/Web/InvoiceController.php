<?php

namespace App\Http\Controllers\Web;

use App\Exports\InvoicesExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreInvoiceRequest;
use App\Http\Requests\UpdateInvoiceRequest;
use App\Models\Reservation;
use App\Services\InvoiceService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

/**
 * This controller manages invoice-related web requests,
 * including listing, creating, updating, deleting, and exporting invoices.
 * Class InvoiceController
 */
class InvoiceController extends Controller
{
    public const PERMISSIONS = [
        'index' => 'view invoices',
        'create' => 'create invoice',
        'edit' => 'edit invoice',
        'delete' => 'delete invoice',
    ];

    protected $invoiceService;

    /**
     * InvoiceController constructor.
     * Summary of __construct
     */
    public function __construct(InvoiceService $invoiceService)
    {
        $this->middleware('auth');
        $this->invoiceService = $invoiceService;

        $this->middleware('permission:'.self::PERMISSIONS['index'])
            ->only(['index', 'show']);
        $this->middleware('permission:'.self::PERMISSIONS['create'])
            ->only(['create', 'store']);
        $this->middleware('permission:'.self::PERMISSIONS['edit'])
            ->only(['edit', 'update']);
        $this->middleware('permission:'.self::PERMISSIONS['delete'])
            ->only(['destroy', 'forceDelete', 'trashed', 'restore']);
    }

    /**
     * Display a listing of invoices.
     * Summary of index
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $invoices = $this->invoiceService->getAllInvoices();

        return view('invoices.index', compact('invoices'));
    }

    /**
     * Display the specified invoice.
     * Summary of show
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $invoice = $this->invoiceService->invoiceDetails($id);

        return view('invoices.show', compact('invoice'));
    }

    /**
     * Show the form for creating a new invoice
     * Summary of create
     *
     * @param  int  $reservationId
     * @return \Illuminate\View\View
     */
    public function create($reservationId)
    {
        $reservation = Reservation::with(['room', 'user'])->findOrFail($reservationId);

        return view('invoices.create', compact('reservation'));
    }

    /**
     * Store a newly created invoice in storage
     * Summary of store
     *
     * @param  int  $reservationId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreInvoiceRequest $request, $reservationId)
    {
        $reservation = Reservation::findOrFail($reservationId);
        $invoice = $this->invoiceService->createInvoice($reservation, $request->validated());

        return redirect()->route('invoices.show', $invoice->id)
            ->with('success', 'Invoice successfully created.');
    }

    /**
     * Show the form for editing the specified invoice
     * Summary of edit
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $invoice = $this->invoiceService->invoiceDetails($id);

        return view('invoices.edit', compact('invoice'));
    }

    /**
     * Update the specified invoice in storage
     * Summary of update
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateInvoiceRequest $request, $id)
    {
        $invoice = $this->invoiceService->invoiceDetails($id);
        $this->invoiceService->updateInvoice($invoice, $request->validated());

        return redirect()->route('invoices.show', $invoice->id)
            ->with('success', 'Invoice successfully updated.');
    }

    /**
     * Remove the specified invoice from storage (soft delete)
     * Summary of destroy
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $invoice = $this->invoiceService->invoiceDetails($id);
        $this->invoiceService->softDeleteInvoice($invoice);

        return redirect()->route('invoices.index')
            ->with('success', 'Invoice successfully deleted.');
    }

    /**
     * Permanently delete the specified invoice from storage
     * Summary of forceDelete
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function forceDelete($id)
    {
        $invoice = $this->invoiceService->trashedInvoiceDetails($id);
        $this->invoiceService->permaInvoiceDelete($invoice);

        return redirect()->route('invoices.trashed')
            ->with('success', 'Invoice permanently deleted.');
    }

    /**
     * Display a listing of soft-deleted invoices
     * Summary of trashed
     *
     * @return \Illuminate\View\View
     */
    public function trashed()
    {
        $invoices = $this->invoiceService->trashedInvoices(Auth::id());

        return view('invoices.trashed', compact('invoices'));
    }

    /**
     * Restore the specified soft-deleted invoice
     * Summary of restore
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore($id)
    {
        $invoice = $this->invoiceService->trashedInvoiceDetails($id);
        $this->invoiceService->restoreInvoice($invoice);

        return redirect()->route('invoices.index')
            ->with('success', 'Invoice successfully restored.');
    }

    /**
     * Export invoices to an Excel file
     * Summary of export
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function export()
    {
        return Excel::download(new InvoicesExport, 'Invoices.xlsx');
    }

    /**
     *
     */
    public function downloadPdf($id, InvoiceService $invoiceService)
    {
        $invoice = $invoiceService->invoiceDetails($id);

        $pdf = Pdf::loadView('invoices.pdf', [
            'invoice' => $invoice,
        ]);

        return $pdf->download('invoice-'.$invoice->id.'.pdf');
    }
}
