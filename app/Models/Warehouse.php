<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Warehouse extends Model
{
    use SoftDeletes;

    protected $fillable = [

        'name',

        'code',

        'manager_name',

        'phone',

        'email',

        'address',

        'city',

        'state',

        'country',

        'postal_code',

        'status',
    ];

    protected $casts = [

        'status' => 'boolean',
    ];
}
