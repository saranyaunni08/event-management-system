<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    protected $fillable = [
        'title',
        'date',
        'time',
        'event_type',
        'user_id',
        'event_for_user_id',
        'event_guidelines',
    ];

    public function photos()
    {
        return $this->hasMany(Photo::class, 'event_id');
    }

    public function invitations()
    {
        return $this->hasMany(Invitation::class, 'event_id');
    }

    public function requisitionItems()
    {
        return $this->hasMany(RequisitionItem::class, 'event_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function eventForUser()
    {
        return $this->belongsTo(User::class, 'event_for_user_id');
    }

    public function isExpired()
    {
        return \Carbon\Carbon::parse($this->date . ' ' . $this->time)->isPast();
    }
}
