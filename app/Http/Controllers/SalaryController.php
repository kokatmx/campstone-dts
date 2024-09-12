<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Salary;
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
        $salary = Salary::with('employee')->get();
        $activeMenu = 'salary';
        return view('salary.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'salary' => $salary, 'activeMenu' => $activeMenu]);
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
                return $salary->employee ? $salary->employee->name : 'N/A';
            })
            ->addColumn('aksi', function ($salary) {
                $btn  = '<div class="d-flex align-items-center justify-content-center">';
                $btn .= '<a href="' . url('/salary/' . $salary->id_salary) . '" class="btn btn-info btn-sm m-1" title="Lihat Detail"><i class="far fa-eye"></i></a>';
                $btn .= '<a href="' . url('/salary/' . $salary->id_salary . '/edit') . '" class="btn btn-warning btn-sm m-1" title="Edit Data"><i class="fas fa-pencil-alt"></i></a>';
                $btn .= '<form method="POST" action="' . url('/salary/' . $salary->id_salary) . '" onsubmit="return confirm(\'Apakah Anda yakin menghapus data ini?\');" class="d-inline">';
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
        $activeMenu = 'salary';
        return view('salary.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'employees' => $employees, 'activeMenu' => $activeMenu]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $salary = new Salary();
        $salary->id_employee = $request->input('id_employee');
        $salary->basic_salary = $request->input('basic_salary');
        $salary->allowances = $request->input('allowances');
        $salary->deductions = $request->input('deductions');
        $salary->total_salary = $salary->basic_salary + $salary->allowances - $salary->deductions;
        $salary->save();

        return redirect()->route('salary.index')->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $salary = Salary::with('employee')->find($id);
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
        return view('salary.show', ['salary' => $salary, 'breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $salary = Salary::with('employee')->find($id);

        if (!$salary) {
            return redirect()->route('salary.index')->with('error', 'Data gaji tidak ditemukan');
        }
        $breadcrumb = (object)[
            'title' => 'Tambah Data Gaji Karyawan',
            'list' => ['Home', 'Gaji Karyawan', 'Tambah'],
        ];
        $page = (object)[
            'title' => 'Edit Data Gaji Karyawan',
        ];
        $employees = Employee::all();
        $activeMenu = 'salary';
        return view('salary.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'salary' => $salary, 'employees' => $employees, 'activeMenu' => $activeMenu]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $salary = Salary::find($id);

        if (!$salary) {
            return redirect()->route('salary.index')->with('error', 'Data gaji tidak ditemukan');
        }

        $employee_name = $request->input('name');
        $employee = Employee::where('name', $employee_name)->first();

        if (!$employee) {
            return redirect()->back()->with('error', 'Karyawan tidak ditemukan');
        }

        $salary->id_employee = $employee->id_employee;
        $salary->basic_salary = $request->input('basic_salary');
        $salary->allowances = $request->input('allowances');
        $salary->deductions = $request->input('deductions');
        $salary->total_salary = $salary->basic_salary + $salary->allowances - $salary->deductions;
        $salary->save();

        return redirect()->route('salary.index')->with('success', 'Data berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $salary = Salary::find($id);
        if ($salary) {
            $salary->delete();
            return redirect()->route('salary.index')->with('success', 'Data gaji karyawan berhasil dihapus');
        } else {
            return redirect()->route('salary.index')->with('error', 'Data gaji karyawan tidak ditemukan');
        }
    }
}
