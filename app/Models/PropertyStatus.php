<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyStatus extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'description',
    ];
}
