<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RequisitionItem extends Model
{
    protected $fillable = ['event_id', 'item_name', 'is_public', 'claimed_by_user_id', 'is_gift', 'added_by_user_id'];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function claimedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'claimed_by_user_id');
    }

    public function addedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'added_by_user_id');
    }
}