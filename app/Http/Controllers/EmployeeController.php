<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Employee;
use App\Models\Position;
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
        return view('employee.index', ['breadcrumb' => $breadcrumb, 'employee' => $employees, 'activeMenu' => $activeMenu, 'page' => $page]);
    }
    public function list(Request $request)
    {
        // Load the employee data and specify only the needed fields
        $employees = Employee::with('position', 'department')
            ->select('id_employee', 'name', 'email', 'address', 'gender', 'no_hp', 'id_position', 'id_department');

        // Apply any filters if needed
        // (e.g. if you want to filter by position or department)

        return DataTables::of($employees)
            ->addIndexColumn()
            ->addColumn('position.name', function ($employee) {
                // Check if position relation exists
                return $employee->position ? $employee->position->name : 'N/A';
            })
            ->addColumn('department.name', function ($employee) {
                // Check if department relation exists
                return $employee->department ? $employee->department->name : 'N/A';
            })
            ->addColumn('aksi', function ($employee) {
                $btn  = '<div class="d-flex align-items-center justify-content-center">';
                $btn .= '<a href="' . url('/employee/' . $employee->id_employee) . '" class="btn btn-info btn-sm m-1" title="Lihat Detail"><i class="far fa-eye"></i></a>';
                $btn .= '<a href="' . url('/employee/' . $employee->id_employee . '/edit') . '" class="btn btn-warning btn-sm m-1" title="Edit Data"><i class="fas fa-pencil-alt"></i></a>';
                $btn .= '<form method="POST" action="' . url('/employee/' . $employee->id_employee) . '" onsubmit="return confirm(\'Apakah Anda yakin menghapus data ini?\');" class="d-inline">';
                $btn .= csrf_field() . method_field('DELETE');
                $btn .= '<button type="submit" class="btn btn-danger btn-sm m-1" title="Hapus Data"><i class="fas fa-trash-alt"></i></button>';
                $btn .= '</form>';
                $btn .= '</div>';
                return $btn;
            })

            ->rawColumns(['aksi'])
            ->make(true);
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
        return view('employee.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu, 'positions' => $positions, 'departments' => $departments]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_department' => 'required|exists:departments,id_department',
        ]);
        $employee = new Employee();
        $employee->name = $request->input('name');
        $employee->email = $request->input('email');
        $employee->address = $request->input('address');
        $employee->gender = $request->input('gender');
        $employee->no_hp = $request->input('no_hp');
        $employee->id_position = $request->input('id_position');
        $employee->id_department = $request->input('id_department');
        $employee->save();
        return redirect()->route('employee.index')->with('success', 'Data berhasil ditambahkan');
    }

    public function show($id)
    {
        $employee = Employee::with('position', 'department')->find($id);
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
        return view('employee.show', ['employee' => $employee, 'breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    public function edit($id)
    {
        $employee = Employee::with('position', 'department')->find($id);
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
        return view('employee.edit', ['employee' => $employee, 'breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu, 'positions' => $positions, 'departments' => $departments]);
    }

    public function update(Request $request, $id)
    {
        $employee = Employee::find($id);
        if (!$employee) {
            abort(404);
        }
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'address' => 'required',
            'gender' => 'required',
            'no_hp' => 'required',
            'id_position' => 'required|exists:positions,id_position',
            'id_department' => 'required|exists:departments,id_department',
        ]);
        $employee->name = $request->input('name');
        $employee->email = $request->input('email');
        $employee->address = $request->input('address');
        $employee->gender = $request->input('gender');
        $employee->no_hp = $request->input('no_hp');
        $employee->id_position = $request->input('id_position');
        $employee->id_department = $request->input('id_department');
        $employee->save();
        return redirect()->route('employee.index')->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        $employee = Employee::find($id);
        if ($employee) {
            $employee->delete();
            return redirect()->route('employee.index')->with('success', 'Data karyawan berhasil dihapus');
        } else {
            return redirect()->route('employee.index')->with('error', 'Data karyawan tidak ditemukan');
        }
    }
}