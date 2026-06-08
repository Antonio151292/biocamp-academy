<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Group extends Model
{
    protected $fillable = [
        'course_id',
        'name',
        'description',
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(GroupMessage::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'group_user')
            ->withTimestamps();
    }

    public function questions(): HasMany
    {
        return $this->hasMany(ForumQuestion::class);
    }
}
