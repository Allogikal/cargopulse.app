<?php

namespace App\Models;

use App\Models\Company;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Application extends Model
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
        'customer',
        'loading_type',
        'body_type',
        'status'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}