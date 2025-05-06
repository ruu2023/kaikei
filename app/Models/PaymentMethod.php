<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    protected $fillable = [
        'name',
        'type',
        'user_id'
    ];

    public $timestamps = false;

    public function user() {
        return $this->belognsTo(User::class);
    }
}
