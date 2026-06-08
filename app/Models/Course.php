<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Course extends Model implements HasMedia
{
    use HasSlug, InteractsWithMedia;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'price',
        'is_published',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'price' => 'decimal:2',
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

    public function sections(): HasMany
    {
        return $this->hasMany(Section::class)->orderBy('order');
    }

    public function group(): HasOne
    {
        return $this->hasOne(Group::class);
    }

    public function purchases(): HasMany
    {
        return $this->hasMany(Purchase::class);
    }
}
