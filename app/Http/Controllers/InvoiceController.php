<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index(Request $request) {
        return view('invoice.index')->with([
            'invoices' => Invoice::with('client')->latest()->paginate(10),
        ]);
    }

    public function create() {

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
