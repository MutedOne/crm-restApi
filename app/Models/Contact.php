<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contact extends Model
{
    use HasFactory;
    protected $table = 'contacts';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'phone',
        'email',
        'address',
        'notes',
    ];
}