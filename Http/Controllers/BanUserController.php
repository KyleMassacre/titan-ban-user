<?php

namespace KyleMassacre\BanUser\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use KyleMassacre\BanUser\Entities\Ban;
use Illuminate\Database\Eloquent\Builder;

class BanUserController extends \App\Http\Controllers\Controller
{

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {

        $type = null;
        $ban = Ban::where(function(Builder $query) use (&$type) {
            $query->where('bannable_id', auth()->user()->id);
            $query->where('bannable_type', get_class(auth()->user()));
            $type = 'Account';
        })->orWhere(function(Builder $query) use (&$type) {
            if(session()->has('character_logged_in'))
            {
                $query->where('bannable_id', auth()->user()->character->id);
                $query->where('bannable_type', get_class(auth()->user()->character));
                $type = 'Character';
            }
        })->first();

        if($ban)
        {
            flash()->error('You are Banned!!');
            return view('banuser::game.index', compact('ban', 'type'));
        }
        else
        {
            return redirect()->route('game.home');
        }
    }

}
