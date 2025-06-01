<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Invitation extends Model
{
    protected $fillable = ['event_id', 'user_id', 'status'];

    protected $attributes = [
        'status' => 'pending', // Default to pending
    ];

    protected $casts = [
        'status' => 'string',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function setStatusAttribute($value)
    {
        $validStatuses = ['pending', 'accepted', 'rejected'];
        if (!in_array($value, $validStatuses)) {
            throw new \InvalidArgumentException('Invalid invitation status.');
        }
        $this->attributes['status'] = $value;
    }
}