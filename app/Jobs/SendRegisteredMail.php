<?php

namespace App\Jobs;


use App\Mail\RegisterMail;
use Illuminate\Bus\Queueable;
use App\Mail\RegisteredMailInfo;
use Illuminate\Support\Facades\Mail;

use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendRegisteredMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $application;
    /**
     * Create a new job instance.
     */
    public function __construct($application)
    {
        $this->application = $application;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Mail::to('bishalcodeslaravel@gmail.com')->send(new RegisterMail($this->application));
        Mail::to($this->application->user->email)->send(new RegisterMail($this->application));
    }
}
