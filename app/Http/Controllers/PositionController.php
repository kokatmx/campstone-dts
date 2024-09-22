<?php

namespace App\Http\Controllers;

use App\Models\Position;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class PositionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $position = Position::all();
        $breadcrumb = (object)[
            'title' => 'Data Posisi',
            'list' => ['Home', 'Posisi'],
        ];
        $page = (object)[
            'title' => 'Data posisi yang terdaftar di sistem',
        ];
        $activeMenu = 'position';
        return view('admin.position.index', ['breadcrumb' => $breadcrumb, 'position' => $position, 'activeMenu' => $activeMenu, 'page' => $page]);
    }

    public function list()
    {
        $positions = Position::select('id_position', 'name', 'description', 'basic_salary');
        return DataTables::of($positions)
            ->addIndexColumn()
            ->addColumn('aksi', function ($position) {
                $btn  = '<div class="d-flex align-items-center justify-content-center">';
                $btn .= '<a href="' . url('/admin/position/' . $position->id_position) . '" class="btn btn-info btn-sm m-1" title="Lihat Detail"><i class="far fa-eye"></i></a>';
                $btn .= '<a href="' . url('/admin/position/' . $position->id_position . '/edit') . '" class="btn btn-warning btn-sm m-1" title="Edit Data"><i class="fas fa-pencil-alt"></i></a>';
                $btn .= '<form method="POST" action="' . url('/admin/position/' . $position->id_position) . '" onsubmit="return confirm(\'Apakah Anda yakin menghapus data ini?\');" class="d-inline">';
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
            'title' => 'Tambah Posisi',
            'list' => ['Home', 'Posisi', 'Tambah'],
        ];
        $page = (object)[
            'title' => 'Tambah data posisi',
        ];
        $position = Position::all();
        $activeMenu = 'position';
        return view('admin.position.create', ['breadcrumb' => $breadcrumb, 'position' => $position, 'activeMenu' => $activeMenu, 'page' => $page]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'basic_salary' => 'required|numeric|min:0',
        ]);

        Position::create($request->all());

        return redirect()->route('admin.position.index')->with('success', 'Position created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Position $position, $id)
    {
        $position =  Position::find($id);
        $breadcrumb = (object)[
            'title' => 'Detail Posisi',
            'list' => ['Home', 'Posisi', 'Detail'],
        ];
        $page = (object)[
            'title' => 'Detail data posisi',
        ];
        $activeMenu = 'position';
        return view('admin.position.show', ['breadcrumb' => $breadcrumb, 'position' => $position, 'activeMenu' => $activeMenu, 'page' => $page]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Position $position, $id)
    {
        $position = Position::find($id);
        $breadcrumb = (object)[
            'title' => 'Edit Data Posisi',
            'list' => ['Home', 'Posisi', 'Edit'],
        ];
        $page = (object)[
            'title' => 'Edit data posisi',
        ];
        $activeMenu = 'position';
        return view('admin.position.edit', ['breadcrumb' => $breadcrumb, 'position' => $position, 'activeMenu' => $activeMenu, 'page' => $page]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Position $position, $id)
    {
        $position = Position::find($id);
        if (!$position) {
            return 'Data posisi tidak ditemukan';
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'basic_salary' => 'required|numeric|min:0',
        ]);

        $position->update($request->all());
        return redirect()->route('admin.position.index')->with('success', 'Data berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Position $position, $id)
    {
        $position = Position::find($id);
        if ($position) {
            $position->delete();
            return redirect()->route('admin.position.index')->with('success', 'Data berhasil dihapus');
        } else {
            return redirect()->route('admin.position.index')->with('success', 'Data gagal dihapus');
        }
    }
}
