<?php

namespace App\Console\Commands;

use App\MccExcursion;
use App\Newsletter;
use Illuminate\Console\Command;

class SendNewsletter extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:newsletter';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send newsletter to user';

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
     * @return mixed
     */
    public function handle()
    {
        $lmd_images = MccExcursion::where('last_minute_deal', 1)->with('header_image')->limit(2)->inRandomOrder()->get();
        $emails = Newsletter::all();
        foreach ($emails as $recipient) {
          //  Mail::to($recipient->email)->send(new \App\Mail\SendNewsletter($lmd_images));
        }
//                   Mail::to('marija@ch.hr')->send(new \App\Mail\SendNewsletter($lmd_images));
    }
}
