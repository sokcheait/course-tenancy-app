<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Stancl\Tenancy\Contracts\Domain as DomainContract;

class Domain extends Model implements DomainContract
{
    use HasFactory;

    protected $fillable = [
        'domain',
        'tenant_id',
        'data',
    ];

    protected $casts = [
        'data' => 'array',
    ];

    /**
     * Relation: Domain belongs to a Tenant
     */
    public function tenant()
    {
        return $this->belongsTo(\Stancl\Tenancy\Database\Models\Tenant::class);
    }

    /**
     * Get the domain string
     */
    public function getDomain(): string
    {
        return $this->domain;
    }
}
