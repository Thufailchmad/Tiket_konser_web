<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class History extends Model
{
    protected $fillable = [
        'total',
        'userId',
        'image'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'userId');
    }

    public function historyItems(): HasMany
    {
        return $this->hasMany(History_Item::class, 'historyId');
    }
}
