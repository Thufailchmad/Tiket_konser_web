<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booked_tickets extends Model
{
    protected $fillable =[
        'ticketId', 'code', 'userId'
    ];

    public function user() : BelongsTo {
    return $this->belongsTo(User::class,'userId');
    }

    public function ticket() : BelongsTo {
        return $this->belongsTo(Tickets::class, 'ticketId');
        }
}