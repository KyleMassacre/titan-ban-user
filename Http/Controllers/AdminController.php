<?php

namespace KyleMassacre\BanUser\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use KyleMassacre\BanUser\Entities\Ban;
use Symfony\Component\HttpFoundation\JsonResponse;

class AdminController extends Controller
{

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(): View
    {
        $users = \App\User::all();
        $characters = \PbbgIo\Titan\Character::all();

        return view('banuser::admin.list', compact('users', 'characters'));
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     * @throws \Exception
     */
    public function destroy($id)
    {
//        $ban = Ban::find($id);
        if(Ban::destroy($id))
        {
            flash()->success('Player has been un-banned');
            return redirect()->route('admin.banuser.index');
        }
        else
        {
            flash()->error('There was an error un-banning that player');
            return redirect()->back()->withInput();
        }
    }

    public function dataTable() :JsonResponse
    {
        return datatables(\BanUser::getUsersBanned())
            ->addColumn('action', function($banned) {
                $routeUnban = route('admin.banuser.unban', $banned);
                switch ($banned->bannable_type) {
                    case \PbbgIo\Titan\Character::class :
                        $routeEdit = route('admin.banchar.edit', $banned);
                        break;
                    case \App\User::class :
                        $routeEdit = route('admin.banuser.edit', $banned);
                        break;
                }
                $buttons = '';
                $buttons .= '<a href="' . $routeUnban . '" class="btn btn-xs btn-danger mr-3"><i class="fas fa-user-minus fa-sm text-white-50"></i>Unban</a>';
                $buttons .= '<a href="' . $routeEdit . '" class="btn btn-xs btn-primary mr-3"><i class="fas fa-user-edit fa-sm text-white-50"></i>Edit</a>';
                return $buttons;
            })
            ->editColumn('display_name', function($banned) {
                return $banned->bannable->display_name ?: $banned->bannable->name;
            })
            ->editColumn('type', function($banned) {
                switch ($banned->bannable_type) {
                    case \PbbgIo\Titan\Character::class :
                        $type = 'Character';
                        break;
                    case \App\User::class :
                        $type = 'User';
                        break;
                    default :
                        $type = 'Unknown';
                }
                return $type;
            })
            ->editColumn('banned_until', function($banned) {
                if($banned->forever == true)
                {
                    return 'Forever';
                }
                else
                {
                    return $banned->ban_until;
                }
            })
            ->toJson();
    }
}
