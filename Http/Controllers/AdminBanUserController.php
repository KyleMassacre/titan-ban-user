<?php

namespace KyleMassacre\BanUser\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use KyleMassacre\BanUser\Entities\Ban;
use KyleMassacre\BanUser\Http\Requests\BannedUserRequest;

class AdminBanUserController extends Controller
{
    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $users = User::all();
        return view('banuser::admin.user.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     * @param BannedUserRequest $request
     * @return Response
     */
    public function store(BannedUserRequest $request)
    {
        $user = User::findOrFail($request->bannable_id);

        if($user->placeBan($request->reason, $request->ban_until, $request->forever == 'on'))
        {
            flash()->success($user->name . ' has been banned');
            return redirect()->route('admin.banuser.index');
        }
        else
        {
            flash()->success('There was an error banning that player');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('banuser::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $banned = Ban::with('bannable')->findOrFail($id);
        return view('banuser::admin.user.edit', compact('banned'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(BannedUserRequest $request, $id)
    {
        $user = User::findOrFail($request->bannable_id);
        $ban = Ban::updateOrCreate(
            ['bannable_id' => $request->bannable_id, 'bannable_type' => get_class($user)],
            ['reason' => $request->reason, 'ban_until' => ($request->ban_until != null ? \Carbon\Carbon::parse($request->ban_until)->toDateString() : null), 'forever' => $request->forever == 'on']
        );

        if($ban->exists())
        {

            flash()->success($user->name . ' has been banned');
            return redirect()->route('admin.banuser.index');
        }
        else
        {
            flash()->success('There was an error banning that player');
            return redirect()->back()->withInput();
        }
    }
}
