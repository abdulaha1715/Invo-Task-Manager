<?php

namespace App\Http\Controllers;

use App\Jobs\InvoiceMailJob;
use App\Mail\InvoiceEmail;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class InvoiceController extends Controller
{
    /**
     * Index function
     * Display invoices
     */
    public function index(Request $request) {
        $invoices = Invoice::with('client')->where('user_id', Auth::id())->latest();

        if (!empty($request->client_id)) {
            $invoices = $invoices->where('client_id', $request->client_id);
        }

        if (!empty($request->status)) {
            $invoices = $invoices->where('status', $request->status);
        }

        if (!empty($request->emailSend)) {
            $invoices = $invoices->where('email_sent', $request->emailSend);
        }

        $invoices = $invoices->paginate(10);

        return view('invoice.index')->with([
            'clients'  => Client::where('user_id', Auth::user()->id)->get(),
            'invoices' => $invoices
        ]);
    }

    /**
     * Create function
     * @param Request
     * Method Get
     * Search query
     */
    public function create(Request $request) {

        // dd($request->all());

        $tasks = false;
        // if client_id and status is not empty
        if (!empty($request->client_id) && !empty($request->status)) {
            $request->validate([
                'client_id' => ['required', 'not_in:none'],
                'status'    => ['required', 'not_in:none'],
            ]);

            $tasks = $this->getInvoiceData($request);
        }

        // return
        return view('invoice.create')->with([
            'clients' => Client::where('user_id', Auth::user()->id)->get(),
            'tasks'   => $tasks
        ]);
    }

    /**
     * getInvoiceData function
     * return tasks
     */
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

    /**
     * Generate function
     * Insert invoice PDF
     * Store invoice PDF
     */
    public function generate(Request $request) {

        $invoice_no  = 'INVO_' . rand(253684, 2584698457);
        $tasks = Task::whereIn('id', $request->invoices_ids)->get();

        if (!empty($request->discount) && !empty($request->discount_type)) {
            $discount      = $request->discount;
            $discount_type = $request->discount_type;
        } else {
            $discount = 0;
            $discount_type = '';
        }

        $pdf_data = [
            'invoice_no'    => $invoice_no,
            'user'          => Auth::user(),
            'tasks'         => $tasks,
            'discount'      => $discount,
            'discount_type' => $discount_type,
        ];

        // Generate PDF
        $pdf = PDF::loadView('invoice.pdf', $pdf_data);

        // Store PDF in Storage
        Storage::put('public/invoices/'.$invoice_no . '.pdf', $pdf->output());

        // nsert PDF into Database
        Invoice::create([
            'invoice_id'   => $invoice_no,
            'client_id'    => $tasks->first()->client->id,
            'user_id'      => Auth::user()->id,
            'status'       => 'unpaid',
            'amount'       => $tasks->sum('price'),
            'download_url' => $invoice_no. '.pdf',
        ]);

    }


    /**
     * Method invoice
     *
     * @param Request $request [explicite description]
     *
     * @return void
     */
    public function invoice(Request $request)
    {
        // dd($request->all());
        if (!empty($request->generate) && $request->generate == 'yes') {
            $this->generate($request);

            return redirect()->route('invoice.index')->with('success', "Invoice Created!");
        }

        if (!empty($request->discount) && !empty($request->discount_type)) {
            $discount      = $request->discount;
            $discount_type = $request->discount_type;
        } else {
            $discount = 0;
            $discount_type = '';
        }


        if (!empty($request->preview) && $request->preview == 'yes') {
            $tasks = Task::whereIn('id', $request->invoices_ids)->get();

            return view('invoice.preview')->with([
                'invoice_no'    => 'INVO_' . rand(253684, 2584698457),
                'user'          => Auth::user(),
                'tasks'         => $tasks,
                'discount'      => $discount,
                'discount_type' => $discount_type,
            ]);
        }
    }

    /**
     * Update function
     * @param Request, Invoice
     * Update invoice status to paid
     */
    public function update(Request $request, Invoice $invoice) {
        $invoice->update([
            'status' => $invoice->status == 'unpaid' ? 'paid' : 'unpaid'
        ]);

        return redirect()->route('invoice.index')->with('success', "Invoice Payment marked as Paid!");
    }

    /**
     * Destroy function
     * Delete invoice info
     */
    public function destroy(Invoice $invoice) {
        Storage::delete('public/invoices/'.$invoice->download_url);

        $invoice->delete();
        return redirect()->route('invoice.index')->with('success', "Invoice Deleted");
    }


    /**
     * SendEmail function
     * Send invoice info with Email and checked with Gmail
     */
    public function sendEmail(Invoice $invoice) {

        $data = [
            'user'       => Auth::user(),
            'invoice_id' => $invoice->invoice_id,
            'invoice'    => $invoice,
            'pdf'        => public_path('storage/invoices/'.$invoice->download_url),
        ];

        // InvoiceMailJob::dispatch($data);
        // dispatch(new InvoiceMailJob($data));

        Mail::to($invoice->client)->send(new InvoiceEmail($data));

        $invoice->update([
            'email_sent' => 'yes'
        ]);

        return redirect()->route('invoice.index')->with('success', "Email Send!");
    }


}
