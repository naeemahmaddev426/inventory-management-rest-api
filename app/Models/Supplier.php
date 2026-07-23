<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Supplier extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'supplier_code',
        'company_name',
        'contact_person',
        'email',
        'phone',
        'mobile',
        'ntn',
        'strn',
        'address',
        'city',
        'country',
        'credit_limit',
        'payment_days',
        'status',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'credit_limit' => 'decimal:2',
        'payment_days' => 'integer',
        'status' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /*
    |--------------------------------------------------------------------------
    | Boot Method
    |--------------------------------------------------------------------------
    */

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($supplier) {

            if (!$supplier->supplier_code) {

                $lastId = static::max('id') + 1;

                $supplier->supplier_code = 'SUP-' . str_pad($lastId, 5, '0', STR_PAD_LEFT);
            }
        });
    }
}