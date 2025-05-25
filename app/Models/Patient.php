<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Patient extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'sex',
        'date_of_birth',
        'no_identity',
        'insurance',
        'address',
        'city',
        'state',
        'registered_at',
        'is_active',
        'country',
    ];

    protected static function booted()
    {
        static::creating(function ($patient) {
            $patient->registered_at = now();
        });
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function emr(): BelongsTo
    {
        return $this->belongsTo(RekamMedis::class, 'id', 'patient_id');
    }
}
