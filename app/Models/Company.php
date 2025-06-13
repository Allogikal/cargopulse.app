<?php

namespace App\Models;

use App\Models\User;
use App\Models\Cargo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'inn',
        'country',
        'registration_address',
        'postal_address',
        'city',
        'email',
        'name',
        'phone',
        'rate',
        'activity',
        'actual_cargos',
        'cargos_statistics_month',
        'cargos_statistics_year',
        'cargos_statistics_all_time',
        'registered_at',
        'last_login'
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function cargos()
    {
        return $this->hasMany(Cargo::class);
    }
}