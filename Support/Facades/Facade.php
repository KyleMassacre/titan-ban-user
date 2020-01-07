<?php

namespace KyleMassacre\BanUser\Support\Facades;


use KyleMassacre\BanUser\Support\BanUser as Banned;

class Facade extends \Illuminate\Support\Facades\Facade
{

    protected static function getFacadeAccessor()
    {
        return Banned::class;
    }
}
