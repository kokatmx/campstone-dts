<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employee;
use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Data Jadwal Karyawan',
            'list' => ['Home', 'Jadwal'],
        ];
        $page = (object)[
            'title' => 'Data gaji karyawan yang tersimpan dalam sistem',
        ];
        $schedule = Schedule::with('employee')->get();
        $activeMenu = 'schedule';
        return view('admin.schedule.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'schedule' => $schedule, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
    {
        $schedules = Schedule::with('employee')
            ->select('id_schedule', 'id_employee', 'date', 'shift');

        return DataTables::of($schedules)
            ->addIndexColumn()
            ->addColumn('employee.name', function ($schedule) {
                // Check if position relation exists
                return $schedule->employee ? $schedule->employee->name : 'N/A';
            })
            ->addColumn('aksi', function ($schedule) {
                $btn  = '<div class="d-flex align-items-center justify-content-center">';
                $btn .= '<a href="' . url('/admin/schedule/' . $schedule->id_schedule) . '" class="btn btn-info btn-sm m-1" title="Lihat Detail"><i class="far fa-eye"></i></a>';
                $btn .= '<a href="' . url('/admin/schedule/' . $schedule->id_schedule . '/edit') . '" class="btn btn-warning btn-sm m-1" title="Edit Data"><i class="fas fa-pencil-alt"></i></a>';
                $btn .= '<form method="POST" action="' . url('/admin/schedule/' . $schedule->id_schedule) . '" onsubmit="return confirm(\'Apakah Anda yakin menghapus data ini?\');" class="d-inline">';
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
            'title' => 'Tambah Data Jadwal Karyawan',
            'list' => ['Home', 'Jadwal Karyawan', 'Tambah'],
        ];
        $page = (object)[
            'title' => 'Tambah Data Jadwal Karyawan',
        ];
        $employees = Employee::all();
        $activeMenu = 'schedule';
        return view('admin.schedule.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'employees' => $employees, 'activeMenu' => $activeMenu]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_employee' => 'required|exists:employees,id_employee',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'shift' => 'required|in:pagi,siang,malam',
            'note' => 'nullable|string',
        ]);

        $schedule = Schedule::create($validated);

        // Buat entri kehadiran untuk setiap hari dalam rentang jadwal
        $currentDate = Carbon::parse($schedule->start_date);
        $endDate = Carbon::parse($schedule->end_date);

        while ($currentDate <= $endDate) {
            Attendance::create([
                'id_employee' => $schedule->id_employee,
                'id_schedule' => $schedule->id_schedule,
                'date' => $currentDate->toDateString(),
                'shift' => $schedule->shift,
                // Atur waktu default sesuai shift
                'time_in' => $this->getDefaultTimeIn($schedule->shift),
                'time_out' => $this->getDefaultTimeOut($schedule->shift),
                'status' => 'tepat waktu', // Status default
            ]);

            $currentDate->addDay();
        }

        return redirect()->route('admin.schedule.index')->with('success', 'Jadwal berhasil diperbarui');
    }


    /**
     * Display the specified resource.
     */
    public function show(Schedule $schedule, $id)
    {
        $schedule = Schedule::with('employee')->find($id);
        if (!$schedule) {
            abort(404);
        }
        $breadcrumb = (object)[
            'title' => 'Detail Gaji Karyawan',
            'list' => ['Home', 'Karyawan', 'Detail Gaji'],
        ];
        $page = (object)[
            'title' => 'Detail Gaji Karyawan',
        ];
        $activeMenu = 'schedule';
        return view('admin.schedule.show', ['schedule' => $schedule, 'breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Schedule $schedule, $id)
    {
        $schedule = Schedule::with('employee')->find($id);

        if (!$schedule) {
            abort(404);
        }

        $breadcrumb = (object)[
            'title' => 'Tambah Edit Jadwal Karyawan',
            'list' => ['Home', 'Jadwal', 'Edit'],
        ];
        $page = (object)[
            'title' => 'Edit Data Jadwal Karyawan',
        ];
        $employees = Employee::all();
        $activeMenu = 'schedule';
        return view('admin.schedule.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'schedule' => $schedule, 'employees' => $employees, 'activeMenu' => $activeMenu]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $schedule = Schedule::find($id);

        if (!$schedule) {
            return redirect()->route('admin.schedule.index')->with('error', 'Data jadwal karyawan tidak ditemukan');
        }

        // Validasi data input
        $request->validate([
            'id_employee' => 'required|exists:employees,id_employee', // Memastikan karyawan valid
            'date' => 'required|date', // Memastikan format tanggal
            'shift' => 'required|in:pagi,siang,malam', // Memastikan shift adalah salah satu dari enum
        ]);

        $schedule->id_employee = $request->input('id_employee');
        $schedule->date = $request->input('date');
        $schedule->shift = $request->input('shift');
        $schedule->save();

        return redirect()->route('admin.schedule.index')->with('success', 'Data berhasil diperbarui');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Schedule $schedule, $id)
    {
        $schedule = Schedule::find($id);
        if ($schedule) {
            $schedule->delete();
            return redirect()->route('admin.schedule.index')->with('success', 'Data jadwal karyawan berhasil dihapus');
        } else {
            return redirect()->route('admin.schedule.index')->with('error', 'Data jadwal karyawan tidak ditemukan');
        }
    }

    private function getDefaultTimeIn($shift)
    {
        switch ($shift) {
            case 'pagi':
                return '07:00:00';
            case 'siang':
                return '12:00:00';
            case 'malam':
                return '18:00:00';
        }
    }

    private function getDefaultTimeOut($shift)
    {
        switch ($shift) {
            case 'pagi':
                return '12:00:00';
            case 'siang':
                return '18:00:00';
            case 'malam':
                return '23:00:00';
        }
    }
}
