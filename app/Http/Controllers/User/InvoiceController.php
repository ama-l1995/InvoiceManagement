<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\User;
use App\Services\PdfService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Yoeunes\Toastr\Facades\Toastr;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
class InvoiceController extends Controller
{
    protected $pdfService;

    public function __construct(PdfService $pdfService)
    {
        $this->pdfService = $pdfService;
    }

    public function all()
    {
        if (Gate::denies('view invoices')) {
            Toastr::error('You do not have permission to view invoices.');
            return redirect()->back();
        }else{
        $invoices = Invoice::with('client')->paginate(10);
        return view('users.invoices.index', compact('invoices'));
        }
    }

    public function search(Request $request)
    {
        $query = $request->input('search');

        $invoices = Invoice::where('invoice_number', 'LIKE', "%{$query}%")
                            ->orWhereHas('client', function($q) use ($query) {
                                $q->where('name', 'LIKE', "%{$query}%");
                            })
                            ->orWhereDate('invoice_date', $query)
                            ->get();

        $results = view('invoices.partials.results', compact('invoices'))->render();
        $table = view('invoices.partials.table', compact('invoices'))->render();

        return response()->json([
            'results' => $results,
            'table' => $table
        ]);
    }

    public function create()
    {
        if (Gate::denies('create invoices')) {
            Toastr::error('You do not have permission to create invoices.');
            return redirect()->back();
        }else{
            $clients = Client::all();
            return view('users.invoices.create', compact('clients'));
        }
    }

    public function store(Request $request)
    {
        if (Gate::denies('create invoices')) {
            Toastr::error('You do not have permission to create invoices.');
            return redirect()->back();
        }
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'invoice_date' => 'required|date',
            'due_date' => 'required|date',
            'items' => 'required|json',
        ]);

        try {
            $client = Client::findOrFail($request->client_id);
            $items = json_decode($request->items, true); // Decode JSON string to array

            $invoice = Invoice::create([
                'client_id' => $client->id,
                'client_name' => $client->name,
                'client_address' => $client->address,
                'invoice_date' => $request->invoice_date,
                'due_date' => $request->due_date,
                'items' => $items,
            ]);

            $invoice->total_amount = $invoice->calculateTotalAmount();
            $invoice->save();

            return redirect()->route('invoices.all');

        } catch (\Exception $e) {
            Log::error('Failed to create invoice: ' . $e->getMessage());

            return redirect()->back()->withInput();

        }
    }

    public function show($id)
    {
        $invoice = Invoice::findOrFail($id);
        return view('users.invoices.show', compact('invoice'));
    }

    public function download($id)
    {
        $invoice = Invoice::findOrFail($id);
        $pdfContent = $this->pdfService->createPdf('users.invoices.pdf', ['invoice' => $invoice]);

        return response()->stream(
            function () use ($pdfContent) {
                echo $pdfContent;
            },
            200,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="invoice_' . $invoice->invoice_number . '.pdf"',
            ]
        );
    }

    public function edit($id)
    {
        if (Gate::denies('edit invoices')) {
            Toastr::error('You do not have permission to edit invoices.');
            return redirect()->back();
        }else{
            $invoice = Invoice::findOrFail($id);
            $clients = Client::all();
            return view('users.invoices.edit', compact('invoice', 'clients'));
        }
    }

    public function update(Request $request, $id)
    {
        if (Gate::denies('edit invoices')) {
            Toastr::error('You do not have permission to edit invoices.');
            return redirect()->back();
        }
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'invoice_date' => 'required|date',
            'due_date' => 'required|date',
            'items' => 'required|json',
        ]);

        try {
            $client = Client::findOrFail($request->client_id);
            $items = json_decode($request->items, true);

            $invoice = Invoice::findOrFail($id);
            $invoice->client_id = $client->id;
            $invoice->client_name = $client->name;
            $invoice->client_address = $client->address;
            $invoice->invoice_date = $request->invoice_date;
            $invoice->due_date = $request->due_date;
            $invoice->items = $items;
            $invoice->total_amount = $invoice->calculateTotalAmount();
            $invoice->save();

            return redirect()->route('invoices.all')->with('success', 'Invoice updated successfully');

        } catch (\Exception $e) {
            Log::error('Failed to update invoice: ' . $e->getMessage());

            return redirect()->back()->withInput()->withErrors(['error' => 'Failed to update invoice.']);
        }
    }

    public function destroy($id)
    {
        if (Gate::denies('delete invoices')) {
            Toastr::error('You do not have permission to delete invoices.');
            return redirect()->back();
        }else{
            try {
                $invoice = Invoice::findOrFail($id);
                $invoice->delete();
                
                Toastr::success('Invoice deleted successfully.', 'Success');
            } catch (\Exception $e) {
                Toastr::error('Failed to delete invoice. ' . $e->getMessage(), 'Error');
        }
        return redirect()->route('invoices.all');
        }
    }

}
