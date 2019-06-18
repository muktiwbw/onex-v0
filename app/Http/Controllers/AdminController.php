<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Level;

class AdminController extends Controller
{
    public function index(){
        return view('admin.main', [
            'user' => Auth::user()
        ]);
    }

    public function index_users(){
        return view('admin.users', [
            'users' => User::all()
        ]);
    }
    
}
