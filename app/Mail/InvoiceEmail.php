<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvoiceEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $data, $pdf;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data, $pdf)
    {
        $this->data = $data;
        $this->pdf  = $pdf;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data = $this->data;
        $pdf  = $this->pdf;

        return $this->markdown('email.invoice')->to($data['client']->email,$data['client']->name)->subject($data['invoice_id'])->from($data['user']->email,$data['user']->name)->attachData($pdf, $data['invoice']->download_url, [
                'mime' =>'application/pdf'
            ]);
    }
}
