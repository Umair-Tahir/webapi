<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderNotificationEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $order,$isFrench,$toRestaurant;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($order,$isFrench,$toRestaurant)
    {
        $this->order=$order;
        $this->isFrench=$isFrench;
        $this->toRestaurant=$toRestaurant;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $view="emails.emailInvoiceEN";

        if( $this->isFrench){
            $view="emails.emailInvoiceFR";
        }
        if($this->toRestaurant){
            return $this->from("noreply@eezly.com", "eezly")->view($view)
                ->subject("New Order #".$this->order->id." from ".$this->order->user->name)
                ->with([
                    "order" => $this->order,
                    "toRestaurant" => $this->toRestaurant
                ]);
        }else{
            return $this->from("noreply@eezly.com", "eezly")->view($view)
                ->subject("New Order #".$this->order->id." to ".$this->order->foodOrders[0]->food->restaurant->name)
                ->with([
                    "order" => $this->order,
                    "toRestaurant" => $this->toRestaurant
                ]);
        }

    }
}
