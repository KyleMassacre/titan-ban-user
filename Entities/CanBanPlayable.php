<?php

namespace KyleMassacre\BanUser\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @mixin Model
 */

trait CanBanPlayable
{
    public function banned()
    {
        return $this->morphMany(Ban::class, 'bannable');
    }

    public function placeBan(string $reason, $time = null, bool $forever = false)
    {
        return Ban::updateOrCreate([
            'bannable_id' => $this->attributes['id'],
            'bannable_type' => get_class($this)
        ], [
            'reason' => $reason,
            'ban_until' => ($time != null ? Carbon::parse($time)->toDateString() : null),
            'forever' => $forever
        ])->exists();
    }

    public function isBanned()
    {
        return $this->banned()->exists();
    }

    public function getNameAttribute()
    {
        return $this->attributes['display_name'] ?? $this->attributes['name'];
    }
}
