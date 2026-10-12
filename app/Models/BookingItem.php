<?php

namespace App\Models;

use App\Enums;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingItem extends Model
{
    /** @use HasFactory<\Database\Factories\BookingItemFactory> */
    use HasFactory;

    protected $fillable = ['booking_id', 'item_id', 'daily_price_at_booking', 'return_condition_note'];

    public function booking() { return $this->belongsTo(Booking::class); }
    public function item()    { return $this->belongsTo(Item::class); }
}
