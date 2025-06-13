<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{
    use HasFactory;

    protected $fillable = [
        'loading_country',
        'loading_index',
        'loading_city',
        'loading_date',
        'weight_tons',
        'volume_m3',
        'can_co_load',
        'additional_info',
        'unloading_country',
        'unloading_index',
        'unloading_city',
        'unloading_date',
        'price',
        'nds',
        'prepayment',
        'loading_type',
        'body_type',
        'company_id',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}