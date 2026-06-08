<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ForumAnswer extends Model
{
    protected $fillable = [
        'question_id',
        'user_id',
        'content',
    ];

    public function question(): BelongsTo
    {
        return $this->belongsTo(ForumQuestion::class, 'question_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
