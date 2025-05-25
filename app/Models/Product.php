<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use Sluggable;
    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'base_price',
        'stock',
        'image',
        'is_active',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'category_id', 'id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * slug for product model
     *
     * @return  array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ],
        ];
    }
}
