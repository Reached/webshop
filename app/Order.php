<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'amount',
        'stripe_billing_id',
        'confirmed',
        'sendSms',
        'user_id',
        'customer_name',
        'customer_address',
        'customer_city',
        'customer_country',
        'customer_zip',
        'customer_email',
        'customer_phone_number',
        'billys_contact_id',
        'billys_invoice_id'
    ];

    protected $casts = [
        'confirmed' => 'boolean',
        'sendSms' => 'boolean'
    ];

    public function orders() {
        return $this->belongsTo('App\User');
    }
}
