<?php

namespace App\Models;

use App\Enums\PaymentMethod;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    /** @use HasFactory<\Database\Factories\PaymentFactory> */
    use HasFactory;

    protected $fillable = ['booking_id', 'user_id', 'amount', 'method', 'paid_at'];

    protected function casts(): array
    {
        return ['method' => PaymentMethod::class, 'paid_at' => 'datetime', 'amount' => 'decimal:2'];
    }

    public function booking() { return $this->belongsTo(Booking::class); }
    public function user()    { return $this->belongsTo(User::class); }
}
