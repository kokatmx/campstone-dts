<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use App\Http\Middleware\AdminMiddleware;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        // Mengambil data pengguna yang sedang login
        $user = Auth::user();

        // Cek apakah pengguna sudah login
        if (!$user) {
            // Jika pengguna tidak terautentikasi, arahkan ke halaman login
            return redirect()->route('login');
        }

        $breadcrumb = (object)[
            'title' => 'Selamat Datang',
            'list' => ['Home', 'Welcome'],
        ];

        $activeMenu = 'dashboard';

        return view('dashboard', [
            'breadcrumb' => $breadcrumb,
            'user' => $user,
            'activeMenu' => $activeMenu
        ]);
    }
}
