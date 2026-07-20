<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tax extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'rate',
        'type',
        'status',
        'description',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'rate' => 'decimal:2',
        'status' => 'boolean',
    ];
}