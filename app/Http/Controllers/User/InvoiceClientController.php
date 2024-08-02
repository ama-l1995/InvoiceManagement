<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoiceClientController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $invoices = $user->invoices;
        return view('client.index', compact('invoices'));
    }

    public function show($id)
    {
        $user = Auth::user();
        $invoice = $user->invoices()->findOrFail($id);

        return view('client.show', compact('invoice'));
    }

}
