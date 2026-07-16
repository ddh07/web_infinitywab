<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'subject',
        'message',
        'status',
        'read_at',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'read_at' => 'datetime',
    ];

    // Accessor for is_read (converts status to boolean)
    public function getIsReadAttribute()
    {
        return $this->status === 'lu' || $this->status === 'traite';
    }

    // Mutator for is_read (converts boolean to status)
    public function setIsReadAttribute($value)
    {
        $this->attributes['status'] = $value ? 'lu' : 'non_lu';
        if ($value && !$this->read_at) {
            $this->attributes['read_at'] = now();
        }
    }

    public function scopeUnread($query)
    {
        return $query->where('status', 'non_lu');
    }

    public function scopeRead($query)
    {
        return $query->whereIn('status', ['lu', 'traite']);
    }

    public function markAsRead()
    {
        $this->update([
            'status' => 'lu',
            'read_at' => now()
        ]);
    }

    public function markAsUnread()
    {
        $this->update([
            'status' => 'non_lu',
            'read_at' => null
        ]);
    }
}
