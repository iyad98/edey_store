<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class TicketEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $order_id;
    public $title;
    public $email;
    public $description;
    public $files;
    public function __construct($order_id,$title,$email,$description,$files)
    {
        $this->order_id = $order_id;
        $this->title = $title;
        $this->email = $email;
        $this->description = $description;
        $this->files = $files;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $order_id = $this->order_id;
        $title = $this->title;
        $email = $this->email;
        $description = $this->description;
        $files = $this->files;

        $email =  $this->view('website_v2.emails.ticket',compact('order_id','title','email','description'));
        if ($files != null){
            for($i = 0 ; $i < count($files) ; $i++ ){
                $email->attach(
                    $files[$i]->getRealPath(),array(
                    'as'=>$files[$i]->getClientOriginalName(),
                    'mime'=>$files[$i]->getMimeType()
                ));
            }
        }





        return $email;


    }
}
