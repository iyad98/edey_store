<?php

namespace App\Jobs;

use App\Mail\SendEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendVerificationEmail;

class DispatchSendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    public $_view_email_;
    public $_email_;
    public $_data_;
    public $_subject_;

    public function __construct($_view_email_ ,$_email_ , $_data_  , $_subject_)
    {
        $this->_view_email_ = $_view_email_;
        $this->_email_ = $_email_;
        $this->_data_ = $_data_;
        $this->_subject_ = $_subject_;
    }

    public function handle()
    {
        // env('MAIL_USERNAME')
        Mail::to($this->_email_)->send(new SendEmail($this->_view_email_ , $this->_email_ , $this->_data_ , $this->_subject_));
    }
}
