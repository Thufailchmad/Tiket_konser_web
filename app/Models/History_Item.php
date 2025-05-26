<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class History_Item extends Model
{
    protected $table = "history_items";

    protected $fillable = [
        'qty',
        'ticketId',
        'historyId'
    ];

    public function history(): BelongsTo
    {
        return $this->belongsTo(History::class, 'historyId', 'id');
    }

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Tickets::class, 'ticketId');
    }
}
