<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employee;
use App\Models\Schedule;
use Carbon\Carbon;
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
        $attendance = Attendance::with('employee', 'schedule')->get();
        $activeMenu = 'attendance';
        return view('admin.attendance.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'attendances' => $attendance, 'activeMenu' => $activeMenu]);
    }

    // show list of available datas attendances
    public function list(Request $request)
    {
        $attendances = Attendance::with('employee')
            ->select('id_attendance', 'id_employee', 'date', 'time_in', 'time_out', 'status', 'note', 'shift');

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
        $request->validate([
            'id_employee' => 'required|exists:employees,id_employee',
            'date' => 'required|date',
            'time_in' => 'required|date_format:H:i',
            'time_out' => 'required|date_format:H:i',
            'shift' => 'required|in:pagi,siang,malam',
            'note' => 'nullable|string|max:255', // Ganti 'notes' menjadi 'note'
        ]);

        // Mendapatkan jadwal karyawan
        $currentSchedule = Schedule::where('id_employee', $request->id_employee)
            ->where('date', $request->date)
            ->first();

        if (!$currentSchedule) {
            return redirect()->back()->with('error', 'No shift scheduled for this date');
        }

        // Menentukan status kehadiran
        $status = $this->checkAttendanceStatus($request->time_in, $request->time_out, $currentSchedule->shift);

        // Menyimpan data kehadiran
        try {
            Attendance::create([
                'id_employee' => $request->id_employee,
                'id_schedule' => $currentSchedule->id_schedule,
                'date' => $request->date,
                'time_in' => $request->time_in,
                'time_out' => $request->time_out,
                'status' => $status,
                'note' => $request->note, // Ganti 'notes' menjadi 'note'
            ]);
        } catch (\Exception $e) {
            Attendance::error('Error saving attendance:', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Failed to save attendance');
        }

        return redirect()->route('admin.attendance.index')->with('success', 'Attendance recorded successfully');
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
    // public function update(Request $request, $id)
    // {
    //     // Validasi data input
    //     $validatedData = $request->validate([
    //         'id_employee' => 'required|exists:employees,id_employee',
    //         'date' => 'required|date',
    //         'time_in' => 'required|date_format:H:i',
    //         'time_out' => 'required|date_format:H:i',
    //         'status' => 'required|in:approved,rejected,in_process',
    //         'note' => 'nullable|string',
    //     ]);

    //     try {
    //         // Temukan entri yang akan diperbarui
    //         $attendance = Attendance::findOrFail($id);

    //         // Perbarui data
    //         $attendance->id_employee = $validatedData['id_employee'];
    //         $attendance->date = $validatedData['date'];
    //         $attendance->time_in = $validatedData['time_in'];
    //         $attendance->time_out = $validatedData['time_out'];
    //         $attendance->status = $validatedData['status'];
    //         $attendance->save();

    //         // Redirect dengan pesan sukses
    //         return redirect()->route('admin.attendance.index')->with('success', 'Data berhasil diperbarui');
    //     } catch (\Exception $e) {
    //         // Tangani kesalahan
    //         return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage());
    //     }
    // }

    public function update(Request $request, Attendance $attendance, $id)
    {
        $attendance = Attendance::findOrFail($id);
        $validated = $request->validate([
            'time_in' => 'required|date_format:H:i',
            'time_out' => 'required|date_format:H:i|after:time_in',
        ]);

        $shift = $attendance->shift;
        $timeIn = Carbon::parse($validated['time_in']);

        // Logika untuk menentukan status kehadiran
        if ($shift === 'pagi' && $timeIn->between('06:50', '07:00')) {
            $status = 'tepat waktu';
        } elseif ($shift === 'siang' && $timeIn->between('11:50', '12:00')) {
            $status = 'tepat waktu';
        } elseif ($shift === 'malam' && $timeIn->between('17:50', '18:00')) {
            $status = 'tepat waktu';
        } else {
            $status = 'terlambat';
        }

        $attendance->update([
            'time_in' => $validated['time_in'],
            'time_out' => $validated['time_out'],
            'status' => $status,
        ]);

        return redirect()->route('admin.attendance.index')->with('success', 'Data berhasil diperbarui');
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

    // Determine status based on shift
    private function checkTimeStatus($timeIn, $shift)
    {
        $shiftTimes = [
            'pagi' => ['start' => '07:00', 'end' => '07:06'],
            'siang' => ['start' => '12:00', 'end' => '12:06'],
            'malam' => ['start' => '18:00', 'end' => '18:06'],
        ];

        // Mengubah format waktu masuk ke Carbon
        $timeIn = Carbon::createFromFormat('H:i', $timeIn);

        // Menentukan waktu mulai dan akhir shift
        $shiftStart = Carbon::createFromFormat('H:i', $shiftTimes[$shift]['start']);
        $shiftEnd = Carbon::createFromFormat('H:i', $shiftTimes[$shift]['end']);

        if ($timeIn->between($shiftStart, $shiftEnd)) {
            return 'tepat waktu';
        }

        return 'terlambat';
    }

    private function checkAttendanceStatus($timeIn, $timeOut, $shift)
    {
        $shiftTimes = [
            'pagi' => ['start' => '07:00', 'end' => '12:00'],
            'siang' => ['start' => '12:00', 'end' => '18:00'],
            'malam' => ['start' => '18:00', 'end' => '23:00'],
        ];

        $shiftStart = Carbon::createFromTimeString($shiftTimes[$shift]['start']);
        $shiftEnd = Carbon::createFromTimeString($shiftTimes[$shift]['end']);
        $timeIn = Carbon::createFromTimeString($timeIn);
        $timeOut = $timeOut ? Carbon::createFromTimeString($timeOut) : null;

        // Tentukan status untuk waktu masuk
        if ($timeIn->lessThanOrEqualTo($shiftStart->addMinutes(5))) {
            $statusIn = 'tepat waktu';
        } else {
            $statusIn = 'terlambat';
        }

        // Tentukan status untuk waktu keluar
        $statusOut = $timeOut && $timeOut->greaterThan($shiftEnd) ? 'lembur' : 'tepat waktu';

        return $statusIn === 'tepat waktu' && ($statusOut ?? true) === 'tepat waktu' ? 'tepat waktu' : 'terlambat';
    }


    public function checkIn(Request $request)
    {
        $request->validate([
            'id_employee' => 'required|exists:employees,id_employee',
            'time_in' => 'required|date_format:H:i',
            'notes' => 'nullable|string|max:255',
        ]);

        // Mendapatkan jadwal karyawan saat ini
        $currentSchedule = Schedule::where('id_employee', $request->id_employee)
            ->where('date', now()->toDateString())
            ->first();

        if (!$currentSchedule) {
            return response()->json(['error' => 'No shift scheduled today'], 404);
        }

        // Cek waktu masuk
        $timeIn = $request->time_in;
        $shift = $currentSchedule->shift;

        // Tentukan status kehadiran
        $status = $this->checkAttendanceStatus($timeIn, null, $shift);

        // Buat catatan kehadiran
        $attendance = Attendance::create([
            'id_employee' => $request->id_employee,
            'id_schedule' => $currentSchedule->id_schedule,
            'date' => now()->toDateString(),
            'time_in' => $timeIn,
            'time_out' => null, // Waktu keluar akan diatur nanti
            'status' => $status,
            'notes' => $request->notes
        ]);

        return response()->json($attendance);
    }

    public function checkOut(Request $request)
    {
        $request->validate([
            'id_employee' => 'required|exists:employees,id_employee',
            'time_out' => 'required|date_format:H:i',
        ]);

        $attendance = Attendance::where('id_employee', $request->id_employee)
            ->where('date', now()->toDateString())
            ->first();

        if (!$attendance) {
            return response()->json(['error' => 'Attendance record not found'], 404);
        }

        // Dapatkan jadwal yang dijadwalkan
        $schedule = Schedule::find($attendance->id_schedule);
        $shift = $schedule->shift;

        // Definisikan waktu shift
        $shiftTimes = [
            'pagi' => ['start' => '07:00', 'end' => '12:00'],
            'siang' => ['start' => '12:00', 'end' => '18:00'],
            'malam' => ['start' => '18:00', 'end' => '23:00']
        ];

        // Bandingkan waktu keluar karyawan dengan waktu akhir shift
        $shiftEndTime = Carbon::createFromTimeString($shiftTimes[$shift]['end']);
        $timeOut = Carbon::createFromTimeString($request->time_out);

        // Tentukan status berdasarkan waktu keluar
        $status = $timeOut->greaterThan($shiftEndTime) ? 'lembur' : 'tepat waktu';

        // Perbarui catatan kehadiran
        $attendance->time_out = $request->time_out;
        $attendance->status = $status;
        $attendance->save();

        return response()->json(['success' => 'Check-out recorded', 'attendance' => $attendance]);
    }
}
