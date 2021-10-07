<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendContactsEmail extends Mailable
{
    use Queueable, SerializesModels;


    public $name_;
    public $email_;
    public $subject_;
    public $message_;

    public function __construct($name_ , $email_ ,$subject_ ,$message_ )
    {
        $this->name_ = $name_;
        $this->email_ = $email_;
        $this->subject_ = $subject_;
        $this->message_ = $message_;
    }


    public function build()
    {
        return $this->view('email.contact' , ['name' => $this->name_ , 'email' =>$this->email_ ,
            'subject' =>$this->subject_, 'content' => $this->message_])
            ->subject($this->name_ ." - ".$this->email_);
    }
}
