<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyType extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'description',
    ];
}
