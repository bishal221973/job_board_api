<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Mail\RegisteredMailInfo;
use Mail;
class SendRegisteredMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $application;
    /**
     * Create a new job instance.
     */
    public function __construct($application)
    {
        $this->$application = $application;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $email=new RegisteredMailInfo() ;
        Mail::to('bishalcodeslaraavel@gmail.com')->send($email);
    }
}
