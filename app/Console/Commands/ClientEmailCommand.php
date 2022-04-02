<?php

namespace App\Console\Commands;

use App\Events\ActivityEvent;
use App\Mail\ClientYearlyEmail;
use App\Models\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class ClientEmailCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'client:yearlyemail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Yearly Email to Client';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $clients = Client::all();

        foreach ($clients as $client) {
            $joined = $client->created_at->diffInYears();

            if ( $joined >= 1 && $client->yearly_email != $joined ) {
                // Todo : send email to client

                info('Email  send');
                Mail::send(new ClientYearlyEmail($client));
                event(new ActivityEvent('Email send to '.$client->name, 'Client', $client->user_id));
                $client->yearly_email = $joined;
                $client->save();
            }

        }
    }
}
