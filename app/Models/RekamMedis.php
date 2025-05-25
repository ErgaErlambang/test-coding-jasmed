<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RekamMedis extends Model
{
    protected $fillable = [
        'patient_id',
        'berat_badan',
        'tekanan_darah',
        'keluhan',
        'hasil_diagnosa',
        'product_id',
        'is_active',
    ];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    public function obat(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
