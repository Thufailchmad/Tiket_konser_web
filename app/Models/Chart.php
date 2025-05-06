<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Chart extends Model
{
    protected $fillable =[
        'qty', 'userId', 'ticketId'
    ];

    public function user() : BelongsTo {
        return $this->belongsTo(Chart::class, 'userId');
    }

    public function ticket() : BelongsTo {
        return $this->belongsTo(Tickets::class, 'ticketId');
    }




}