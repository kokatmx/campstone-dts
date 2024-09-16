<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class AttendanceController extends Controller
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
        $attendance = Attendance::with('employee')->get();
        $activeMenu = 'attendance';
        return view('admin.attendance.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'attendance' => $attendance, 'activeMenu' => $activeMenu]);
    }

    // show list of available datas attendances
    public function list(Request $request)
    {
        $attendances = Attendance::with('employee')
            ->select('id_attendance', 'id_employee', 'date', 'time_in', 'time_out', 'status', 'notes');

        return DataTables::of($attendances)
            ->addIndexColumn()
            ->addColumn('employee.name', function ($attendance) {
                // Check if position relation exists
                return $attendance->employee ? $attendance->employee->name : 'N/A';
            })
            ->addColumn('aksi', function ($attendance) {
                $btn  = '<div class="d-flex align-items-center justify-content-center">';
                $btn .= '<a href="' . url('/admin/attendance/' . $attendance->id_attendance) . '" class="btn btn-info btn-sm m-1" title="Lihat Detail"><i class="far fa-eye"></i></a>';
                $btn .= '<a href="' . url('/admin/attendance/' . $attendance->id_attendance . '/edit') . '" class="btn btn-warning btn-sm m-1" title="Edit Data"><i class="fas fa-pencil-alt"></i></a>';
                $btn .= '<form method="POST" action="' . url('/admin/attendance/' . $attendance->id_attendance) . '" onsubmit="return confirm(\'Apakah Anda yakin menghapus data ini?\');" class="d-inline">';
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
            'title' => 'Tambah Data Kehadiran Karyawan',
            'list' => ['Home', 'Kehadiran Karyawan', 'Tambah'],
        ];
        $page = (object)[
            'title' => 'Tambah data kehadiran karyawan',
        ];
        $employees = Employee::all();
        $activeMenu = 'attendance';
        return view('admin.attendance.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'employees' => $employees, 'activeMenu' => $activeMenu]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id_employee' => 'required|exists:employees,id_employee',
            'date' => 'required|date',
            'time_in' => 'required|date_format:H:i',
            'time_out' => 'required|date_format:H:i',
            'status' => 'required|in:approved,rejected,in_process',
            'notes' => 'nullable|string',
        ]);
        try {
            //Membuat instance baru menggunakan create
            Attendance::create([
                'id_employee' => $validatedData['id_employee'],
                'date' => $validatedData['date'],
                'time_in' => $validatedData['time_in'],
                'time_out' => $validatedData['time_out'],
                'status' => $validatedData['status'],
                'notes' => $validatedData['notes'],
            ]);
            return redirect()->route('admin.attendance.index')->with('succes', 'Data berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menambahkan data: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Attendance $attendance, $id)
    {
        $attendance = Attendance::with('employee')->find($id);
        if (!$attendance) {
            return "<script>alert('data tidak ada'); document.location.href=admin.attendace.index;</script>";
        }
        $breadcrumb = (object)[
            'title' => 'Detail Kehadiran Karyawan',
            'list' => ['Home', 'Kehadiran', 'Detail'],
        ];
        $page = (object)[
            'title' => 'Data detail kehadiran karyawan',
        ];
        $activeMenu = 'attendanace';
        return view('admin.attendance.show', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu, 'page' => $page, 'attendance' => $attendance]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Attendance $attendance, $id)
    {
        $attendance = Attendance::findOrFail($id);
        $employees = Employee::all();
        if (!$attendance) {
            return "<script>alert('data tidak ada'); document.location.href=admin.attendace.index;</script>";
        }
        $breadcrumb = (object)[
            'title' => 'Edit Data Kehadiran Karyawan',
            'list' => ['Home', 'Kehadiran', 'Edit'],
        ];
        $page = (object)[
            'title' => 'Edit data kehadiran karyawan',
        ];
        $activeMenu = 'attendanace';
        return view('admin.attendance.edit', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu, 'page' => $page, 'attendance' => $attendance, 'employees' => $employees]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validasi data input
        $validatedData = $request->validate([
            'id_employee' => 'required|exists:employees,id_employee',
            'date' => 'required|date',
            'time_in' => 'required|date_format:H:i',
            'time_out' => 'required|date_format:H:i',
            'status' => 'required|in:approved,rejected,in_process',
            'note' => 'nullable|string',
        ]);

        try {
            // Temukan entri yang akan diperbarui
            $attendance = Attendance::findOrFail($id);

            // Perbarui data
            $attendance->id_employee = $validatedData['id_employee'];
            $attendance->date = $validatedData['date'];
            $attendance->time_in = $validatedData['time_in'];
            $attendance->time_out = $validatedData['time_out'];
            $attendance->status = $validatedData['status'];
            $attendance->save();

            // Redirect dengan pesan sukses
            return redirect()->route('admin.attendance.index')->with('success', 'Data berhasil diperbarui');
        } catch (\Exception $e) {
            // Tangani kesalahan
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attendance $attendance, $id)
    {
        try {
            $attendance = Attendance::findOrFail($id);
            $attendance->delete();
            return redirect()->route('admin.attendance.index')->with('success', 'Data berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }
    }
}
