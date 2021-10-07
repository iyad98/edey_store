<?php

namespace App\Jobs;

use App\Mail\SendContactSellerEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendVerificationEmail;

class DispacthSendContactSellerEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    public $name_;
    public $email_;
    public $subject_;
    public $message_;

    public function __construct($name_ , $email_ ,$subject_ ,$message_)
    {
        $this->name_ = $name_;
        $this->email_ = $email_;
        $this->subject_ = $subject_;
        $this->message_ = $message_;
    }


    public function handle()
    {
        // env('MAIL_USERNAME')
        Mail::to($this->email_)->send(new SendContactSellerEmail($this->name_ , $this->email_ , $this->subject_ , $this->message_));
    }
}
