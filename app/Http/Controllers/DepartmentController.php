<?php

namespace App\Http\Controllers;

use App\Models\Departement;
use App\Models\Department;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Data Departemen',
            'list' => ['Home', 'Department'],
        ];
        $page = (object)[
            'title' => 'Data karyawan yang tersimpan dalam sistem',
        ];
        $department = Department::all();
        $activeMenu = 'department';
        return view('department.index', ['breadcrumb' => $breadcrumb, 'department' => $department, 'activeMenu' => $activeMenu, 'page' => $page]);
    }

    // list the department
    public function list()
    {
        $departments = Department::select('id_department', 'name', 'description');
        return DataTables::of($departments)
            ->addIndexColumn()
            ->addColumn('aksi', function ($department) {
                $btn  = '<div class="d-flex align-items-center justify-content-center">';
                $btn .= '<a href="' . url('/department/' . $department->id_department) . '" class="btn btn-info btn-sm m-1" title="Lihat Detail"><i class="far fa-eye"></i></a>';
                $btn .= '<a href="' . url('/department/' . $department->id_department . '/edit') . '" class="btn btn-warning btn-sm m-1" title="Edit Data"><i class="fas fa-pencil-alt"></i></a>';
                $btn .= '<form method="POST" action="' . url('/department/' . $department->id_department) . '" onsubmit="return confirm(\'Apakah Anda yakin menghapus data ini?\');" class="d-inline">';
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
            'title' => 'Tambah Departemen',
            'list' => ['Home', 'Department', 'Tambah'],
        ];
        $page = (object)[
            'title' => 'Tambah data departemen',
        ];
        $department = Department::all();
        $activeMenu = 'department';
        return view('department.create', ['breadcrumb' => $breadcrumb, 'department' => $department, 'activeMenu' => $activeMenu, 'page' => $page]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $department = new Department();
        $department->name = $request->input('name');
        $department->description = $request->input('description');
        $department->save();

        return redirect()->route('department.index')->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Department $department, $id)
    {
        $department = Department::find($id);
        $breadcrumb = (object)[
            'title' => 'Detail Departemen',
            'list' => ['Home', 'Department', 'Detail'],
        ];
        $page = (object)[
            'title' => 'Detail data departemen',
        ];
        $activeMenu = 'department';
        return view('department.show', ['breadcrumb' => $breadcrumb, 'department' => $department, 'activeMenu' => $activeMenu, 'page' => $page]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Department $department, $id)
    {
        $department = Department::find($id);
        $breadcrumb = (object)[
            'title' => 'Edit Data Departemen',
            'list' => ['Home', 'Department', 'Edit'],
        ];
        $page = (object)[
            'title' => 'Edit data departemen',
        ];
        $activeMenu = 'department';
        return view('department.edit', ['breadcrumb' => $breadcrumb, 'department' => $department, 'activeMenu' => $activeMenu, 'page' => $page]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Department $department, $id)
    {
        $department = Department::find($id);
        if (!$department) {
            return "Data departemen tidak ditemukan";
        }
        $department->name = $request->input('name');
        $department->description = $request->input('description');
        $department->save();

        return redirect()->route('department.index')->with('success', 'Data berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department, $id)
    {
        $department = Department::find($id);
        if ($department) {
            $department->delete();
            return redirect()->route('department.index')->with('success', 'Data departemen berhasil dihapus');
        } else {
            return redirect()->route('department.index')->with('success', 'Data departemen gagal dihapus');
        }
    }
}
