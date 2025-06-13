<?php

namespace App\Models;

use App\Models\Company;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory;

    protected $fillable = [
        'name',
        'surname',
        'email',
        'phone',
        'avatar',
        'position',
        'info',
        'password',
        'is_admin',
        'company_id',
        'is_active'
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'sanctum_tokens'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}