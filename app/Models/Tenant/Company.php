<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'nade',
        'emme',
        'coail',
        'phone',
        'tax_number',
        'vat_number',
        'registration_number',
        'timezone',
        'is_active',
    ];
}
