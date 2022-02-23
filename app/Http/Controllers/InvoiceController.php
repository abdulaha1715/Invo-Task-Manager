<?php

namespace App\Http\Controllers;

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
        return view('invoice.index')->with([
            'invoices' => Invoice::with('client')->latest()->paginate(10),
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
     * Preview function
     * Preview invoice
     */
    public function preview(Request $request) {
        return view('invoice.preview')->with([
            'invoice_no'  => 'INVO_' . rand(253684, 2584698457),
            'user'  => Auth::user(),
            'tasks' => $this->getInvoiceData($request),
        ]);
    }

    /**
     * Generate function
     * Insert invoice PDF
     * Store invoice PDF
     */
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

    /**
     * Update function
     * @param Request, Invoice
     * Update invoice status to paid
     */
    public function update(Request $request, Invoice $invoice) {
        $invoice->update([
            'status' => 'paid'
        ]);

        return redirect()->route('invoice.index')->with('success', "Invoice Payment mark as Paid!");
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

        $pdf = Storage::get('public/invoices/'.$invoice->download_url);

        $data = [
            'user'       => Auth::user(),
            'invoice_id' => $invoice->invoice_id,
            'invoice'    => $invoice,
            // 'pdf'        => $pdf
        ];

        Mail::send(new InvoiceEmail($data));

        // Mail::send('emails.invoice', $data, function ($message) use ($invoice, $pdf) {
        //     $message->from(Auth::user()->email, Auth::user()->name);
        //     $message->to($invoice->client->email, $invoice->client->name);
        //     $message->subject('Abnipes - '. $invoice->invoice_id);
        //     $message->attachData($pdf, $invoice->download_url, [
        //         'mime' =>'application/pdf'
        //     ]);
        // });

        $invoice->update([
            'email_sent' => 'yes'
        ]);

        return redirect()->route('invoice.index')->with('success', "Email Send!");
    }


}
