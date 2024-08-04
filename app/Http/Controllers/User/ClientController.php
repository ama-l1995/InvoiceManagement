<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yoeunes\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Gate;

class ClientController extends Controller
{
    public function all()
    {
        if (Gate::denies('view clients')) {
            Toastr::error('You do not have permission to view clients.');
            return redirect()->back();
        }else{
        $clients = Client::paginate(10);
        return view('users.clients.index', compact('clients'));
        }
    }

    public function showInvoices($clientId)
    {
        $client = Client::findOrFail($clientId);
        $invoices = $client->invoices;
        return view('users.clients.invoices', compact('client', 'invoices'));
    }

    public function create()
    {
        if (Gate::denies('create clients')) {
            Toastr::error('You do not have permission to create clients.');
            return redirect()->back();
        }else{
            return view('users.clients.create');
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:Clients',
                'password' => 'required|string|min:8|confirmed',
                'phone' => 'nullable|string|max:15',
                'address' => 'required|string',
            ]);

            Client::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone' => $request->phone,
                'address' => $request->address,
                'role' => 'client',
            ]);
            Toastr::success('Client created successfully.');

            return redirect()->route('clients.all')->with('success', 'Client created successfully.');
        } catch (\Exception $e) {
            Toastr::error('Failed to create Client. ' . $e->getMessage());
            return redirect()->back();
        }
    }

    public function edit($id)
    {
        if (Gate::denies('edit clients')) {
            Toastr::error('You do not have permission to edit clients.');
            return redirect()->back();
        }else{
            $client = Client::findOrFail($id);
            return view('users.clients.edit', compact('client'));
        }
    }

    public function update(Request $request, $id)
    {
        try{
            $request->validate([
                'name' => 'sometimes|string|max:255',
                // 'email' => 'sometimes|string|email|max:255|unique:Clients',
                'password' => 'sometimes|required|string|min:8|confirmed',
                'phone' => 'sometimes|nullable|string|max:15',
                'address' => 'sometimes|required|string',
            ]);

            $client = Client::findOrFail($id);
            $client->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone' => $request->phone,
                'address' => $request->address,
            ]);
            Toastr::success('Client updated successfully.');

            return redirect()->route('clients.index')->with('success', 'Client updated successfully.');

        } catch (\Exception $e) {
            Toastr::error('Failed to updated Client. ' . $e->getMessage());
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        if (Gate::denies('delete clients')) {
            Toastr::error('You do not have permission to delete clients.');
            return redirect()->back();
        }else{
            try {
            $client = Client::findOrFail($id);
            $client->invoices()->delete();
            $client->delete();
            Toastr::success('Client and their invoices deleted successfully.');
            return redirect()->route('clients.all')->with('success', 'Client and their invoices deleted successfully.');
            } catch (\Exception $e) {
                Toastr::error('Failed to delete Client. ' . $e->getMessage());
            }
        }
    }

}
