<?php

namespace App\Models;

use App\Models\BlogCategory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;
use Storage;

class Blog extends Model
{
    use HasSlug, HasFactory;
    protected $fillable = [
        'title',
        'slug',
        'description',
        'content',
        'thumbnail',
        'blog_category_id'
    ];
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom(['title'])
            ->saveSlugsTo('slug');
    }

    public function category()
    {
        return $this->belongsTo(BlogCategory::class, 'blog_category_id');
    }

    /**
     * Accessor untuk Thumbnail
     */
    protected function thumbnail(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                // Gunakan disk 'public' karena di controller kita simpan di disk public
                if ($value && Storage::disk('public')->exists($value)) {
                    return Storage::url($value);
                }

                // Fallback jika file tidak ada
                return asset('thumbnail.png');
            },
        );
    }
}
