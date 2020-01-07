<?php

namespace KyleMassacre\BanUser\Entities;

use Illuminate\Database\Eloquent\Model;

/** @mixin \Eloquent */
class Ban extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'forever' => 'boolean',
        'ban_until' => 'datetime:Y-m-d'
    ];

    protected $dates = [
        'ban_until'
    ];

    public function bannable()
    {
        return $this->morphTo();
    }


}
