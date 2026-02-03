<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = app(User::class)->paginate(10);
        $view = "Users/Index";
        return Inertia::render($view, ['users'=>$users]);
    }
}
