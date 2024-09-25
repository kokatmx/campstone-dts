<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employee;
use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        // Validasi data input
        $validatedData = $request->validate([
            'id_employee' => 'required|exists:employees,id_employee', // Memastikan karyawan valid
            'start_date' => 'required|date', // Memastikan format tanggal
            'end_date' => 'required|date|after_or_equal:start_date', // Memastikan end_date >= start_date
            'shift' => 'required|in:pagi,siang,malam', // Memastikan shift adalah salah satu dari enum
            'note' => 'nullable|string'
        ]);

        try {
            $startDate = Carbon::parse($validatedData['start_date']);
            $endDate = Carbon::parse($validatedData['end_date']);

            for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
                Schedule::create([
                    'id_employee' => $validatedData['id_employee'],
                    'date' => $date->toDateString(),
                    'shift' => $validatedData['shift'],
                    'note' => $validatedData['note'],
                ]);
            }

            // Redirect dengan pesan sukses
            return redirect()->route('admin.schedule.index')->with('success', 'Jadwal berhasil ditambahkan untuk periode yang dipilih.');
        } catch (\Exception $e) {
            // Jika ada error saat menyimpan, tangani disini
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menambahkan data: ' . $e->getMessage());
        }
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
        // Cari jadwal berdasarkan ID
        $schedule = Schedule::find($id);

        // Jika jadwal tidak ditemukan, kembalikan dengan pesan error
        if (!$schedule) {
            return redirect()->route('admin.schedule.index')->with('error', 'Data jadwal karyawan tidak ditemukan');
        }

        // Validasi data input
        $validatedData = $request->validate([
            'id_employee' => 'required|exists:employees,id_employee', // Memastikan karyawan valid
            'date' => 'required|date', // Memastikan format tanggal
            'shift' => 'required|in:pagi,siang,malam', // Memastikan shift adalah salah satu dari enum
            'note' => 'nullable|string' // Catatan opsional
        ]);

        // Update data jadwal dengan data yang telah divalidasi
        $schedule->update($validatedData);

        // Redirect ke halaman jadwal dengan pesan sukses
        return redirect()->route('admin.schedule.index')->with('success', 'Data jadwal berhasil diperbarui');
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
    // todo:ini dari chatgpt
    // *untuk proses checkin
    public function checkIn(Request $request)
    {
        // Get the employee's current shift from the schedule
        $currentSchedule = Schedule::where('id_employee', $request->id_employee)
            ->where('date', now()->toDateString())
            ->first();

        if (!$currentSchedule) {
            return response()->json(['error' => 'No shift scheduled today']);
        }

        // Check the time_in and time_out against the schedule's shift time
        $timeIn = $request->time_in;
        $shift = $currentSchedule->shift;

        // Logic to determine whether the check-in is late or on time
        $status = $this->checkAttendanceStatus($timeIn, $shift);
        $attendance = Attendance::create([
            'id_employee' => $request->id_employee,
            'id_schedule' => $currentSchedule->id_schedule,
            'date' => now()->toDateString(),
            'time_in' => $timeIn,
            'time_out' => null, // Time out will be set later
            'status' => $status,
            'notes' => $request->notes
        ]);

        return response()->json($attendance);
    }

    private function checkAttendanceStatus($timeIn, $shift)
    {
        $shiftTimes = [
            'pagi' => ['start' => '07:00', 'end' => '12:00'],
            'siang' => ['start' => '12:00', 'end' => '18:00'],
            'malam' => ['start' => '18:00', 'end' => '23:00']
        ];

        $shiftStart = Carbon::createFromTimeString($shiftTimes[$shift]['start']);
        $shiftEnd = Carbon::createFromTimeString($shiftTimes[$shift]['end']);
        $timeIn = Carbon::createFromTimeString($timeIn);

        if ($timeIn->between($shiftStart->copy()->subMinutes(10), $shiftStart->copy()->addMinutes(5))) {
            return 'tepat waktu';
        } elseif ($timeIn->greaterThan($shiftStart->addMinutes(5))) {
            return 'terlambat';
        } else {
            return 'early';
        }
    }

    public function showSchedule(Request $request)
    {
        $userId = Auth::user()->id_user; // Ambil ID user yang sedang login
        $schedules = Schedule::where('id_employee', $userId)->get();

        return view('user.schedule.index', compact('schedules'));
    }
}
