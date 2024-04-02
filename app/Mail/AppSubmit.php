<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AppSubmit extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $app;

    public function __construct($user,$app)
    {
        $this->user = $user;
        $this->app = $app;
    }

    public function build()
    {
        return $this->subject('Application Submitted!')->view('emails.appSubmit',['user'=> $this->user,'app'=>$this->app]);
    }
}
