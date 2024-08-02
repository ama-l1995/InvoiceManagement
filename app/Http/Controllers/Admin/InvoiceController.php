<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Invoice;
use App\Models\User;
use App\Services\PdfService;
use Illuminate\Http\Request;


class InvoiceController extends Controller
{
    protected $pdfService;

    public function __construct(PdfService $pdfService)
    {
        $this->pdfService = $pdfService;
    }

    public function index()
    {
        $invoices = Invoice::with('user', 'items')->paginate(10);

        return view('admin.invoices.index', compact('invoices'));
    }

    public function create()
    {
        $clients = User::all();
        return view('admin.invoices.create', compact('clients'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'invoice_date' => 'required|date',
            'items.*.description' => 'required|string',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0.01',
        ]);

        $invoice = Invoice::create([
            'user_id' => $request->user_id,
            'invoice_number' => 'INV-' . time(),
            'invoice_date' => $request->invoice_date,
            'notes' => $request->notes,
        ]);

        foreach ($request->items as $item) {
            $invoice->items()->create($item);
        }

        return redirect()->route('invoices.index')->with('success', 'Invoice created successfully.');
    }

    public function show($id)
    {
        $invoice = Invoice::with('user', 'items')->findOrFail($id);
        $pdfContent = $this->pdfService->createPdf('admin.invoices.pdf', compact('invoice'));

        return response()->stream(
            function () use ($pdfContent) {
                echo $pdfContent;
            },
            200,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="invoice-' . $invoice->invoice_number . '.pdf"',
            ]
        );
    }

    public function edit($id)
    {
        $invoice = Invoice::with('items')->findOrFail($id);
        $clients = User::all();
        return view('admin.invoices.edit', compact('invoice', 'clients'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'invoice_date' => 'required|date',
            'items.*.description' => 'required|string',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0.01',
        ]);

        $invoice = Invoice::findOrFail($id);
        $invoice->update([
            'user_id' => $request->user_id,
            'invoice_date' => $request->invoice_date,
            'notes' => $request->notes,
        ]);

        $invoice->items()->delete();
        foreach ($request->items as $item) {
            $invoice->items()->create($item);
        }

        return redirect()->route('invoices.index')->with('success', 'Invoice updated successfully.');
    }

    public function destroy($id)
    {
        $invoice = Invoice::findOrFail($id);
        $invoice->delete();
        return redirect()->route('invoices.index')->with('success', 'Invoice deleted successfully.');
    }
}
