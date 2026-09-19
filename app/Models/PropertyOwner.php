<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PropertyOwner extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'property_id',
        'contact_id',
        'type_id',
    ];

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class);
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(ContactType::class, 'type_id');
    }
}