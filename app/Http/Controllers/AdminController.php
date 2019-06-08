<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Level;

class AdminController extends Controller
{
    public function index(){
        $user = Auth::user();

        return view('admin.main', [
            'name' => $user->name
        ]);
    }

    public function index_users(){
        $users = User::all();

        return view('admin.users', [
            'users' => $users
        ]);
    }
    
}
