<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendEmail extends Mailable
{
    use Queueable, SerializesModels;


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


    public function build()
    {
        return $this->view($this->_view_email_ , $this->_data_)
            ->subject($this->_subject_);
    }
}
