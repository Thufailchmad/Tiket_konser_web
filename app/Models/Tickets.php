<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tickets extends Model
{
    protected $fillable = [
        'name', 'expired','lokasi', 'description', 'price', 'images'
    ];

    public function chart() : HasMany {
        return $this->hasMany(Chart::class);
        }

    public function historyItems() : HasMany {
        return $this->hasMany(History_Item::class);
    }

    public function bookedTickets() : HasMany {
        return $this->hasMany(Booked_tickets::class);
        }

}
