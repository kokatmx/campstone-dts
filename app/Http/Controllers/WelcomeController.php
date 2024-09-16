<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Http\Request;

class WelcomeController extends BaseController
{
    public function __construct()
    {
        $this->middleware(AdminMiddleware::class);
    }
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
        // Logika untuk dashboard user biasa
        $breadcrumb = (object)[
            'title' => 'Selamat Datang',
            'list' => ['Home', 'Welcome'],
        ];
        $activeMenu = 'dashboard';
        return view('dashboard', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu]);
    }
}