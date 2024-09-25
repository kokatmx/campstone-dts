<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\UserMiddleware;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WelcomeController extends BaseController
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Selamat Datang',
            'list' => ['Home', 'Welcome'],
        ];
        $activeMenu = 'dashboard';
        return view('admin.welcome', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu]);
    }
    public function userDashboard()
    {
        return view('user.dashboard');
    }
}
