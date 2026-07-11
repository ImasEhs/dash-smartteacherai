<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Hash;
use Session;
use Auth;

class LoginController extends Controller
{
    public function index()
    {
        if (Session::has('name')) {
            return redirect('/dashboard');
        }
        else
        {
            return view('login');
        }
    }


    public function logout()
    {
        Session::flush();

        return redirect('/');
    }

    public function bypass()
    {
        // Buat user di lokal DB jika belum ada
        $user = \App\Models\User::firstOrCreate(
            ['email' => 'dev@lokal.com'],
            [
                'name' => 'Developer Lokal',
                'username' => 'dev@lokal.com',
                'password' => \Hash::make('password')
            ]
        );

        // Fitur ini khusus untuk testing di local
        Session::put('id', $user->id);
        Session::put('name', $user->name);
        Session::put('email', $user->email);
        Session::put('lms_token', 'dummy_token');
        
        return redirect('/dashboard');
    }
}
