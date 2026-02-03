<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role as SpatieRole;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Role extends SpatieRole
{
    use HasFactory;

    protected $fillable = [
        'name',
        'guard_name',
        'is_active'
    ];

    public function scopeIsUser(Builder $query)
    {
        return $query->where('name','!=','super-admin');
    }

    public function scopeActive(Builder $query)
    {
        return $query->where('is_active', true);
    }
}