<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['amount', 'stripe_billing_id', 'confirmed', 'sendSms', 'user_id'];

    protected $casts = [
        'confirmed' => 'boolean',
        'sendSms' => 'boolean'
    ];

    public function orders() {
        return $this->belongsTo('App\User');
    }
}
