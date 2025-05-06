<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class History_Item extends Model
{
    protected $fillable =[
        'qty', 'ticketId', 'historyid'
    ];

    public function history() : BelongsTo {
        return $this->belongsTo(History::class, 'historyid');
    }

    public function ticket() : BelongsTo {
        return $this->belongsTo(Tickets::class, 'ticketId');
    }
}
