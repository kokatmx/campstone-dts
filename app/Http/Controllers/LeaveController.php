<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Leave;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class LeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Data Cuti Karyawan',
            'list' => ['Home', 'Cuti'],
        ];
        $page = (object)[
            'title' => 'Data cuti karyawan yang tersimpan dalam sistem',
        ];
        $leave = Leave::with('employee')->get();
        $activeMenu = 'leave';
        return view('admin.leave.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'leave' => $leave, 'activeMenu' => $activeMenu]);
    }

    // show list of leaves employee
    public function list(Request $request)
    {
        $leaves = Leave::with('employee')
            ->select('id_leave', 'id_employee', 'start_date', 'end_date', 'reason', 'status');

        return DataTables::of($leaves)
            ->addIndexColumn()
            ->addColumn('employee.name', function ($leave) {
                // Check if position relation exists
                return $leave->employee ? $leave->employee->name : 'N/A';
            })
            ->addColumn('aksi', function ($leave) {
                $btn  = '<div class="d-flex align-items-center justify-content-center">';
                $btn .= '<a href="' . url('/admin/leave/' . $leave->id_leave) . '" class="btn btn-info btn-sm m-1" title="Lihat Detail"><i class="far fa-eye"></i></a>';
                $btn .= '<a href="' . url('/admin/leave/' . $leave->id_leave . '/edit') . '" class="btn btn-warning btn-sm m-1" title="Edit Data"><i class="fas fa-pencil-alt"></i></a>';
                $btn .= '<form method="POST" action="' . url('/admin/leave/' . $leave->id_leave) . '" onsubmit="return confirm(\'Apakah Anda yakin menghapus data ini?\');" class="d-inline">';
                $btn .= csrf_field() . method_field('DELETE');
                $btn .= '<button type="submit" class="btn btn-danger btn-sm m-1" title="Hapus Data"><i class="fas fa-trash-alt"></i></button>';
                $btn .= '</form>';
                $btn .= '</div>';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $breadcrumb = (object)[
            'title' => 'Tambah Data Cuti Karyawan',
            'list' => ['Home', 'Cuti', 'Tambah'],
        ];
        $page = (object)[
            'title' => 'Tambah data cuti karyawan',
        ];
        $employees = Employee::all();
        $activeMenu = 'leave';
        return view('admin.leave.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'employees' => $employees, 'activeMenu' => $activeMenu]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id_employee' => 'required|exists:employees,id_employee',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'status' => 'required|in:approved,rejected,in_process',
            'reason' => 'required|string',
        ]);
        try {
            //Membuat instance baru menggunakan create
            Leave::create([
                'id_employee' => $validatedData['id_employee'],
                'start_date' => $validatedData['start_date'],
                'end_date' => $validatedData['end_date'],
                'status' => $validatedData['status'],
                'reason' => $validatedData['reason'],
            ]);
            return redirect()->route('admin.leave.index')->with('succes', 'Data berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menambahkan data: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Leave $leave, $id)
    {
        $leave = Leave::with('employee')->find($id);
        if (!$leave) {
            return "<script>alert('data tidak ada'); document.location.href=admin.leave.index;</script>";
        }
        $breadcrumb = (object)[
            'title' => 'Detail CUti Karyawan',
            'list' => ['Home', 'Cuti', 'Detail'],
        ];
        $page = (object)[
            'title' => 'Data detail cuti karyawan',
        ];
        $activeMenu = 'attendanace';
        return view('admin.leave.show', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu, 'page' => $page, 'leave' => $leave]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Leave $leave, $id)
    {
        $leave = Leave::findOrFail($id);
        $employees = Employee::all();
        if (!$leave) {
            return "<script>alert('data tidak ada'); document.location.href=admin.leave.index;</script>";
        }
        $breadcrumb = (object)[
            'title' => 'Edit Data Kehadiran Karyawan',
            'list' => ['Home', 'Kehadiran', 'Edit'],
        ];
        $page = (object)[
            'title' => 'Edit data kehadiran karyawan',
        ];
        $activeMenu = 'attendanace';
        return view('admin.leave.edit', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu, 'page' => $page, 'leave' => $leave, 'employees' => $employees]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Leave $leave, $id)
    {
        // Validasi data input
        $validatedData = $request->validate([
            'id_employee' => 'required|exists:employees,id_employee',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'status' => 'required|in:approved,rejected,in_process',
            'reason' => 'required|string',
        ]);

        try {
            // Temukan entri yang akan diperbarui
            $leave = Leave::findOrFail($id);

            // Perbarui data
            $leave->id_employee = $validatedData['id_employee'];
            $leave->start_date = $validatedData['start_date'];
            $leave->end_date = $validatedData['end_date'];
            $leave->status = $validatedData['status'];
            $leave->reason = $validatedData['reason'];
            $leave->save();

            // Redirect dengan pesan sukses
            return redirect()->route('admin.leave.index')->with('success', 'Data berhasil diperbarui');
        } catch (\Exception $e) {
            // Tangani kesalahan
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Leave $leave, $id)
    {
        try {
            $leave = Leave::findOrFail($id);
            $leave->delete();
            return redirect()->route('admin.leave.index')->with('success', 'Data berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }
    }
}
