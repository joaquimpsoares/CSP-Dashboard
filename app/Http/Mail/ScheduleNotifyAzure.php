<?php

namespace Tagydes\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;


class ScheduleNotifyAzure extends Mailable
{


    use Queueable, SerializesModels;

    public $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     //
    // }

    public function __construct($data)
    {
        $this->data = $data;
    }


    // public function customer(){

        //     $customer;

        // }



        /**
         * Build the message.
         *
         * @return $this
         */
        public function build()
        {

            // public $variable;
        return $this->markdown('emails.schedulenotifyazure');
    }
}
