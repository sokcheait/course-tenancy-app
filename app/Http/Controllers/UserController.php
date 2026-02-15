<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;
use App\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $this->authorize('admin.users.index');
        $users = app(User::class)->paginate(10);
        $view = "Users/Index";
        return Inertia::render($view, ['users'=>$users]);
    }
    public function create()
    {
        // $user = auth()->user();
        // // $user->assignRole(1);
        // dd($user);
        $this->authorize('admin.users.create');
        $roles = app(Role::class)->active()->IsUser()->select('id','name')->get();
        $view = "Users/Create";
        return Inertia::render($view,['roles'=>$roles]);
    }

    public function store(Request $request)
    {
        dd($request->all());
    }
}
