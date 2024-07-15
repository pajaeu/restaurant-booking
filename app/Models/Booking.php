<?php

namespace App\Models;

use App\Events\BookingCreated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'table_id',
        'guests',
        'reserved_time'
    ];

    protected $casts = [
        'reserved_time' => 'datetime'
    ];

    protected $dispatchesEvents = [
        'created' => BookingCreated::class
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function table(): BelongsTo
    {
        return $this->belongsTo(Table::class);
    }
}
