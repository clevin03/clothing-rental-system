<?php

namespace App\Models;

use App\Enums\BookingStatus;
use App\Enums\PaymentStatus;
use Database\Factories\BookingFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    /** @use HasFactory<BookingFactory> */
    use HasFactory;

    protected $fillable = ['booking_reference', 'customer_id', 'user_id', 'start_date', 'expected_return_date',
        'actual_return_date', 'status', 'total_amount'];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'expected_return_date' => 'date',
            'actual_return_date' => 'date',
            'status' => BookingStatus::class,
            'total_amount' => 'decimal:2',
        ];
    }

    public function scopeBlocking(Builder $query): Builder
    {
        return $query->whereIn('status', [BookingStatus::Reserved, BookingStatus::Active]);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bookingItems()
    {
        return $this->hasMany(BookingItem::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    // Overdue is calculated, never stored
    public function scopeOverdue(Builder $query): Builder
    {
        return $query->whereNull('actual_return_date')
            ->whereNot('status', BookingStatus::Cancelled)
            ->whereDate('expected_return_date', '<', today());
    }

    protected function paidAmount(): Attribute
    {
        return Attribute::get(fn () => (float) $this->payments->sum('amount'));
    }

    protected function balance(): Attribute
    {
        return Attribute::get(fn () => (float) $this->total_amount - $this->paid_amount);
    }

    protected function paymentStatus(): Attribute
    {
        return Attribute::get(fn () => match (true) {
            $this->paid_amount <= 0 => PaymentStatus::Pending,
            $this->balance > 0 => PaymentStatus::PartiallyPaid,
            default => PaymentStatus::Paid,
        });
    }
}
