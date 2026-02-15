<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'iso_code',
        'iso3',
        'phone_code',
        'currency_code',
        'currency_name',
        'continent',
        'flag',
    ];

    /**
     * Get all states for this country.
     */
    public function states()
    {
        return $this->hasMany(State::class);
    }

    /**
     * Optional: get all addresses in this country
     */
    public function addresses()
    {
        return $this->hasMany(Address::class);
    }
}
