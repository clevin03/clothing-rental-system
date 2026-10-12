<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\ItemStatus;

class Item extends Model
{
    /** @use HasFactory<\Database\Factories\ItemFactory> */
    use HasFactory;

    protected $fillable = ['name', 'category', 'size', 'color', 'daily_price',
                       'condition', 'image_path', 'status'];

    protected function casts(): array
    {
        return ['status' => ItemStatus::class, 'daily_price' => 'decimal:2'];
    }

    public function bookingItems() { return $this->hasMany(BookingItem::class); }
}
