<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PaymentRefundedForSeller extends Mailable
{
    use Queueable, SerializesModels;

    protected $paymentServiceOrder;
    protected $orderRelations;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($paymentServiceOrder, $orderRelations)
    {
        $this->paymentServiceOrder = $paymentServiceOrder;
        $this->orderRelations = $orderRelations;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.payments/refundedForSeller')
            ->with([
                'buyer' => $this->paymentServiceOrder->user->name,
                'orderRelation' => $this->orderRelations,
                'paymentServiceOrder' => $this->paymentServiceOrder,
                'seller' => $this->orderRelations->first()->order->channel->user,
            ]);
    }
}
