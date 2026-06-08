<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Subscription extends Model
{
    protected $fillable = [
        'user_id',
        'plan_type',
        'payment_method',
        'subscription_id',
        'status',
        'starts_at',
        'ends_at',
        'receipt_path',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isActive(): bool
    {
        return $this->status === 'active' && 
               ($this->ends_at === null || $this->ends_at->isFuture());
    }
}
