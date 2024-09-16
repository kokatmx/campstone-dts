<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use Illuminate\Http\Request;

class LeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Data Kehadiran Karyawan',
            'list' => ['Home', 'Kehadiran'],
        ];
        $page = (object)[
            'title' => 'Data kehadiran karyawan yang tersimpan dalam sistem',
        ];
        $leave = Leave::with('employee')->get();
        $activeMenu = 'leave';
        return view('admin.leave.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'leave' => $leave, 'activeMenu' => $activeMenu]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Leave $leave)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Leave $leave)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Leave $leave)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Leave $leave)
    {
        //
    }
}