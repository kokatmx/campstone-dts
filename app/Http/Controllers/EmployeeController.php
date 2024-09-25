<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Employee;
use App\Models\Position;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class EmployeeController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Data Karyawan',
            'list' => ['Home', 'Employees'],
        ];
        $page = (object)[
            'title' => 'Data karyawan yang tersimpan dalam sistem',
        ];
        $employees = Employee::with('position', 'department')->get();
        $activeMenu = 'employee';
        return view('admin.employee.index', ['breadcrumb' => $breadcrumb, 'employee' => $employees, 'activeMenu' => $activeMenu, 'page' => $page]);
    }
    public function list(Request $request)
    {
        try {
            $employees = Employee::with('position', 'department', 'user')
                ->select('id_employee', 'id_user', 'address', 'gender', 'no_hp', 'id_position', 'id_department');

            return DataTables::of($employees)
                ->addIndexColumn()
                ->addColumn('user.name', function ($employee) {
                    return $employee->user ? $employee->user->name : 'N/A';
                })
                ->addColumn('user.email', function ($employee) {
                    return $employee->user ? $employee->user->email : 'N/A';
                })
                ->addColumn('position.name', function ($employee) {
                    return $employee->position ? $employee->position->name : 'N/A';
                })
                ->addColumn('department.name', function ($employee) {
                    return $employee->department ? $employee->department->name : 'N/A';
                })
                ->addColumn('aksi', function ($employee) {
                    $btn  = '<div class="d-flex align-items-center justify-content-center">';
                    $btn .= '<a href="' . url('/admin/employee/' . $employee->id_employee) . '" class="btn btn-info btn-sm m-1" title="Lihat Detail"><i class="far fa-eye"></i></a>';
                    $btn .= '<a href="' . url('/admin/employee/' . $employee->id_employee . '/edit') . '" class="btn btn-warning btn-sm m-1" title="Edit Data"><i class="fas fa-pencil-alt"></i></a>';
                    $btn .= '<form method="POST" action="' . url('/admin/employee/' . $employee->id_employee) . '" onsubmit="return confirm(\'Apakah Anda yakin menghapus data ini?\');" class="d-inline">';
                    $btn .= csrf_field() . method_field('DELETE');
                    $btn .= '<button type="submit" class="btn btn-danger btn-sm m-1" title="Hapus Data"><i class="fas fa-trash-alt"></i></button>';
                    $btn .= '</form>';
                    $btn .= '</div>';
                    return $btn;
                })
                ->rawColumns(['aksi'])
                ->make(true);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);  // Untuk debugging, kirim error ke front-end
        }
    }

    public function create()
    {
        $breadcrumb = (object)[
            'title' => 'Tambah Karyawan',
            'list' => ['Home', 'Karyawan', 'Tambah'],
        ];
        $page = (object)[
            'title' => 'Tambah Data Karyawan',
        ];
        $activeMenu = 'employee';
        $positions = Position::all();
        $departments = Department::all();
        $users = User::all();
        return view('admin.employee.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu, 'positions' => $positions, 'departments' => $departments, 'users' => $users]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_user' => 'required|exists:users,id_user',
            'address' => 'required',
            'gender' => 'required',
            'no_hp' => 'required',
            'id_position' => 'required|exists:positions,id_position',
            'id_department' => 'required|exists:departments,id_department',
        ]);

        // Create the employee record, associating it with the existing user
        Employee::create([
            'id_user' => $request->id_user,
            'address' => $request->address,
            'gender' => $request->gender,
            'no_hp' => $request->no_hp,
            'id_position' => $request->id_position,
            'id_department' => $request->id_department,
        ]);
        return redirect()->route('admin.employee.index')->with('success', 'Data berhasil ditambahkan');
    }

    public function show($id)
    {
        $employee = Employee::with('position', 'department', 'user')->find($id);
        if (!$employee) {
            abort(404);
        }
        $breadcrumb = (object)[
            'title' => 'Detail Karyawan',
            'list' => ['Home', 'Karyawan', 'Detail'],
        ];
        $page = (object)[
            'title' => 'Detail Data Karyawan',
        ];
        $activeMenu = 'employee';
        return view('admin.employee.show', ['employee' => $employee, 'breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    public function edit($id)
    {
        $employee = Employee::with('position', 'department', 'user')->find($id);
        if (!$employee) {
            abort(404);
        }
        $breadcrumb = (object)[
            'title' => 'Edit Karyawan',
            'list' => ['Home', 'Karyawan', 'Edit'],
        ];
        $page = (object)[
            'title' => 'Edit Data Karyawan',
        ];
        $activeMenu = 'employee';
        $positions = Position::all();
        $departments = Department::all();
        $users = User::all();
        return view('admin.employee.edit', ['users' => $users, 'employee' => $employee, 'breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu, 'positions' => $positions, 'departments' => $departments]);
    }

    public function update(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);
        if (!$employee) {
            abort(404);
        }
        $request->validate([
            'id_user' => 'required|exists:users,id_user',
            'address' => 'required',
            'gender' => 'required',
            'no_hp' => 'required',
            'id_position' => 'required|exists:positions,id_position',
            'id_department' => 'required|exists:departments,id_department',
        ]);
        $employee->update([
            'id_user' => $request->id_user,
            'address' => $request->address,
            'gender' => $request->gender,
            'no_hp' => $request->no_hp,
            'id_position' => $request->id_position,
            'id_department' => $request->id_department,
        ]);

        return redirect()->route('admin.employee.index')->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        $employee = Employee::find($id);
        if ($employee) {
            $employee->delete();
            return redirect()->route('admin.employee.index')->with('success', 'Data karyawan berhasil dihapus');
        } else {
            return redirect()->route('admin.employee.index')->with('error', 'Data karyawan tidak ditemukan');
        }
    }

    // public function getSalaryInfo($id)
    // {
    //     // Cari employee berdasarkan ID
    //     $employee = Employee::with('position')->find($id);

    //     // Pastikan data employee ditemukan
    //     if ($employee) {
    //         return response()->json([
    //             'position' => $employee->position->name,
    //             'basic_salary' => $employee->position->basic_salary,
    //         ]);
    //     } else {
    //         return response()->json(['error' => 'Employee not found'], 404);
    //     }
    // }
}
