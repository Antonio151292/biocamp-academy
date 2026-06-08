<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Lesson extends Model implements HasMedia
{
    use HasSlug, InteractsWithMedia;

    protected $fillable = [
        'section_id',
        'title',
        'slug',
        'content',
        'video_provider',
        'video_url',
        'order',
        'is_free',
    ];

    protected $casts = [
        'is_free' => 'boolean',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    public function usersWhoCompleted(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'lesson_user')
            ->withPivot('completed_at')
            ->withTimestamps();
    }
}
