<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Position;
use App\Models\Salary;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class SalaryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Data Gaji Karyawan',
            'list' => ['Home', 'Salary'],
        ];
        $page = (object)[
            'title' => 'Data gaji karyawan yang tersimpan dalam sistem',
        ];
        $salary = Salary::with('employee.user')->get();
        $activeMenu = 'salary';
        return view('admin.salary.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'salary' => $salary, 'activeMenu' => $activeMenu]);
    }

    // salary list
    public function list(Request $request)
    {
        $salary = Salary::with('employee')
            ->select('id_salary', 'id_employee', 'basic_salary', 'allowances', 'deductions', 'total_salary');

        return DataTables::of($salary)
            ->addIndexColumn()
            ->addColumn('employee.name', function ($salary) {
                // Check if position relation exists
                return $salary->employee ? $salary->employee->user->name : 'N/A';
            })
            ->addColumn('aksi', function ($salary) {
                $btn  = '<div class="d-flex align-items-center justify-content-center">';
                $btn .= '<a href="' . url('/admin/salary/' . $salary->id_salary) . '" class="btn btn-info btn-sm m-1" title="Lihat Detail"><i class="far fa-eye"></i></a>';
                $btn .= '<a href="' . url('/admin/salary/' . $salary->id_salary . '/edit') . '" class="btn btn-warning btn-sm m-1" title="Edit Data"><i class="fas fa-pencil-alt"></i></a>';
                $btn .= '<form method="POST" action="' . url('/admin/salary/' . $salary->id_salary) . '" onsubmit="return confirm(\'Apakah Anda yakin menghapus data ini?\');" class="d-inline">';
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
            'title' => 'Tambah Data Gaji Karyawan',
            'list' => ['Home', 'Gaji Karyawan', 'Tambah'],
        ];
        $page = (object)[
            'title' => 'Tambah Data Gaji Karyawan',
        ];
        $employees = Employee::all();
        $positions = Position::all();
        $users = User::all();
        $activeMenu = 'salary';
        return view('admin.salary.create', ['users' => $users, 'breadcrumb' => $breadcrumb, 'page' => $page, 'employees' => $employees, 'positions' => $positions, 'activeMenu' => $activeMenu]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_employee' => 'required|exists:employees,id_employee',
            'id_position' => 'required|exists:positions,id_position',
            'allowances' => 'required|numeric',
            'deductions' => 'nullable|numeric',
        ]);

        // Mendapatkan posisi karyawan dan gaji pokoknya
        $position = Position::find($request->id_position);

        // Hitung total gaji
        $totalSalary = $position->basic_salary + $request->allowances - $request->deductions;

        // Simpan data gaji
        Salary::create([
            'id_employee' => $request->id_employee,
            'basic_salary' => $position->basic_salary,
            'allowances' => $request->allowances,
            'deductions' => $request->deductions ?? 0,
            'total_salary' => $totalSalary,
        ]);

        return redirect()->route('admin.salary.index')->with('success', 'Data gaji berhasil ditambahkan');
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $salary = Salary::with('employee.user')->find($id);
        if (!$salary) {
            abort(404);
        }
        $breadcrumb = (object)[
            'title' => 'Detail Gaji Karyawan',
            'list' => ['Home', 'Karyawan', 'Detail Gaji'],
        ];
        $page = (object)[
            'title' => 'Detail Gaji Karyawan',
        ];
        $activeMenu = 'salary';
        return view('admin.salary.show', ['salary' => $salary, 'breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $salary = Salary::with('employee.user')->find($id);

        if (!$salary) {
            return redirect()->route('admin.salary.index')->with('error', 'Data gaji tidak ditemukan');
        }
        $breadcrumb = (object)[
            'title' => 'Tambah Data Gaji Karyawan',
            'list' => ['Home', 'Gaji Karyawan', 'Tambah'],
        ];
        $page = (object)[
            'title' => 'Edit Data Gaji Karyawan',
        ];
        $employees = Employee::all();
        $users  = User::all();
        $activeMenu = 'salary';
        return view('admin.salary.edit', ['users' => $users, 'breadcrumb' => $breadcrumb, 'page' => $page, 'salary' => $salary, 'employees' => $employees, 'activeMenu' => $activeMenu]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $salary = Salary::findOrFail($id);

        $request->validate([
            // 'id_employee' => 'required|exists:employees,id_employee',
            'id_position' => 'required|exists:positions,id_position',
            'allowances' => 'required|numeric',
            'deductions' => 'nullable|numeric',
        ]);

        // Get the updated position and its basic salary
        $position = Position::find($request->id_position);

        // Calculate the new total salary
        $totalSalary = $position->basic_salary + $request->allowances - $request->deductions;

        $salary->update([
            'id_employee' => $request->id_employee,
            'basic_salary' => $position->basic_salary,
            'allowances' => $request->allowances,
            'deductions' => $request->deductions ?? 0,
            'total_salary' => $totalSalary,
        ]);
        return redirect()->route('admin.salary.index')->with('success', 'Data gaji berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $salary = Salary::find($id);
        if ($salary) {
            $salary->delete();
            return redirect()->route('admin.salary.index')->with('success', 'Data gaji karyawan berhasil dihapus');
        } else {
            return redirect()->route('admin.salary.index')->with('error', 'Data gaji karyawan tidak ditemukan');
        }
    }

    public function getEmployeePosition($id_employee)
    {
        $employee = Employee::with('position')->find($id_employee);

        if ($employee) {
            return response()->json([
                'position' => $employee->position->name,
                'basic_salary' => $employee->position->basic_salary
            ]);
        }

        return response()->json(['error' => 'Employee not found'], 404);
    }
}
