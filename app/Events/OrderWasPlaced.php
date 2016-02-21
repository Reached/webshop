<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class OrderWasPlaced extends Event
{
    use SerializesModels;

    public $amount;
    public $billing_id;
    public $sendSms;

    /**
     * Create a new event instance.
     *
     * @param Amount $amount
     * @param BillingId $billing_id
     * @param SendSms $sendSms
     */
    public function __construct($amount, $billing_id, $sendSms)
    {
        $this->amount = $amount;
        $this->billing_id = $billing_id;
        $this->sendSms = $sendSms;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
