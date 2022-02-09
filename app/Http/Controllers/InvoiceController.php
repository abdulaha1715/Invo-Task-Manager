<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Invoice;
use App\Models\Task;
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
            'tasks'   => false,
        ]);
    }

    public function search(Request $request) {
        // dd($request->all());

        $request->validate([
            'client_id' => ['required', 'not_in:none'],
            'status'    => ['required', 'not_in:none'],
        ]);

        $tasks = Task::latest();

        if( !empty($request->client_id) ) {
            $tasks = $tasks->where('client_id', '=', $request->client_id);
        }

        if( !empty($request->status) ) {
            $tasks = $tasks->where('status', '=', $request->status);
        }

        if( !empty($request->fromDate) ) {
            $tasks = $tasks->whereDate('created_at', '>=', $request->fromDate);
        }

        if( !empty($request->endDate) ) {
            $tasks = $tasks->whereDate('created_at', '<=', $request->endDate);
        }

        return view('invoice.create')->with([
            'clients' => Client::where('user_id', Auth::user()->id)->get(),
            'tasks'   => $tasks->get(),
        ]);

    }

    public function preview() {
        return view('invoice.preview');
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
