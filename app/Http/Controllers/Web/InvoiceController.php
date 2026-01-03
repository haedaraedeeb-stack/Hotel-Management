<?php

namespace App\Http\Controllers\Web;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreInvoiceRequest;
use App\Http\Requests\UpdateInvoiceRequest;
use App\Services\InvoiceService;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{

    protected $invoiceService;
    public function __construct(InvoiceService $invoiceService)
    {
        $this->middleware('auth');
        $this->invoiceService = $invoiceService;
    }

    public function index()
    {
        $invoices = $this->invoiceService->userInvoices(Auth::id());
        return view('invoices.index', compact('invoices'));
    }

    public function show($id)
    {
        $invoice = $this->invoiceService->invoiceDetails($id);
        return view('invoices.show', compact('invoice'));
    }


    public function create($reservationId)
    {
        $reservation = Reservation::with(['room', 'user'])->findOrFail($reservationId);
        return view('invoices.create', compact('reservation'));
    }


    public function store(StoreInvoiceRequest $request, $reservationId)
    {
        $reservation = Reservation::findOrFail($reservationId);
        $invoice = $this->invoiceService->createInvoice($reservation, $request->validated());
        return redirect()->route('invoices.show', $invoice->id)
            ->with('success', 'Invoice successfully created.');
    }

    public function edit($id)
    {
        $invoice = $this->invoiceService->invoiceDetails($id);
        return view('invoices.edit', compact('invoice'));
    }

    public function update(UpdateInvoiceRequest $request, $id)
    {
        $invoice = $this->invoiceService->invoiceDetails($id);
        $this->invoiceService->updateInvoice($invoice, $request->validated());
        return redirect()->route('invoices.show', $invoice->id)
            ->with('success', 'Invoice successfully updated.');
    }

    public function destroy($id)
    {
        $invoice = $this->invoiceService->invoiceDetails($id);
        $this->invoiceService->softDeleteInvoice($invoice);
        return redirect()->route('invoices.index')
            ->with('success', 'Invoice successfully deleted.');
    }

    public function forceDelete($id)
    {
        $invoice = $this->invoiceService->trashedInvoiceDetails($id);
        $this->invoiceService->permaInvoiceDelete($invoice);
        return redirect()->route('invoices.trashed')
            ->with('success', 'Invoice permanently deleted.');
    }

    public function trashed()
    {
        $invoices = $this->invoiceService->trashedInvoices(Auth::id());
        return view('invoices.trashed', compact('invoices'));
    }

    public function restore($id)
    {
        $invoice = $this->invoiceService->trashedInvoiceDetails($id);
        $this->invoiceService->restoreInvoice($invoice);
        return redirect()->route('invoices.index')
            ->with('success', 'Invoice successfully restored.');
    }
}
