<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    public function index(Request $request) {
        return view('invoice.index')->with([
            'invoices' => Invoice::with('client')->latest()->paginate(10),
        ]);
    }

    public function create() {
        return view('invoice.create')->with([
            'clients' => Client::where('user_id', Auth::user()->id)->get(),
        ]);
    }

    public function edit() {

    }

    public function store(Request $request) {

    }

    public function update() {

    }

    public function show() {

    }

    public function destroy() {

    }
}
