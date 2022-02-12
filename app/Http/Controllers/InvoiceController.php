<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Invoice;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Support\Facades\Storage;

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

    public function getInvoiceData(Request $request) {

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

        return $tasks->get();
    }

    public function search(Request $request) {
        // dd($request->all());

        $request->validate([
            'client_id' => ['required', 'not_in:none'],
            'status'    => ['required', 'not_in:none'],
        ]);

        return view('invoice.create')->with([
            'clients' => Client::where('user_id', Auth::user()->id)->get(),
            'tasks'   => $this->getInvoiceData($request),
        ]);

    }

    public function preview(Request $request) {
        return view('invoice.preview')->with([
            'invoice_no'  => 'INVO_' . rand(253684, 2584698457),
            'user'  => Auth::user(),
            'tasks' => $this->getInvoiceData($request),
        ]);
    }

    public function generate(Request $request) {

        $invoice_no  = 'INVO_' . rand(253684, 2584698457);

        $pdf_data = [
            'invoice_no'  => $invoice_no,
            'user'  => Auth::user(),
            'tasks' => $this->getInvoiceData($request),
        ];

        // Generate PDF
        $pdf = PDF::loadView('invoice.pdf', $pdf_data);

        // Store PDF in Storage
        Storage::put('public/invoices/'.$invoice_no . '.pdf', $pdf->output());

        // nsert PDF into Database
        Invoice::create([
            'invoice_id'   => $invoice_no,
            'client_id'    => $request->client_id,
            'user_id'      => Auth::user()->id,
            'status'       => 'unpaid',
            'download_url' => $invoice_no. '.pdf',
        ]);

        return redirect()->route('invoice.index')->with('success', "Invoice Created!");

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
