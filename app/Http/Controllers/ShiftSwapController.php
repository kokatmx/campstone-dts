<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Schedule;
use App\Models\ShiftChange;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShiftSwapController extends Controller
{

    public function index()
    {

        $breadcrumb = (object)[
            'title' => 'Data Kehadiran Karyawan',
            'list' => ['Home', 'Kehadiran'],
        ];
        $page = (object)[
            'title' => 'Data kehadiran karyawan yang tersimpan dalam sistem',
        ];
        $shiftChanges = ShiftChange::with(['scheduleFrom.employee', 'scheduleTo.employee'])->get();
        $schedules = Schedule::with('employee')->get();
        return view('admin.shift_changes.index', ['breadcrumb' => $breadcrumb, 'schedules' => $schedules, 'shiftChanges' => $shiftChanges, 'page' => $page]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_schedule_from' => 'required|exists:schedules,id_schedule',
            'id_schedule_to' => 'required|exists:schedules,id_schedule|different:id_schedule_from',
        ]);

        ShiftChange::create([
            'id_schedule_from' => $validated['id_schedule_from'],
            'id_schedule_to' => $validated['id_schedule_to'],
            'status' => 'diproses',
        ]);

        return redirect()->route('shift-changes.index')->with('success', 'Permintaan pergantian shift berhasil diajukan');
    }

    // public function reject(ShiftChange $shiftChange)
    // {
    //     $shiftChange->update(['status' => 'ditolak']);
    //     return redirect()->route('shift-changes.index')->with('success', 'Pergantian shift ditolak');
    // }

    // public function requestShiftSwap(Request $request)
    // {
    //     // Validate that both schedule IDs exist
    //     $fromSchedule = Schedule::find($request->id_schedule_from);
    //     $toSchedule = Schedule::find($request->id_schedule_to);

    //     if (!$fromSchedule || !$toSchedule) {
    //         return response()->json(['error' => 'Invalid schedules'], 400);
    //     }

    //     // Create a new shift change request
    //     $shiftChange = ShiftChange::create([
    //         'id_schedule_from' => $request->id_schedule_from,
    //         'id_schedule_to' => $request->id_schedule_to,
    //         'status' => 'pending'
    //     ]);

    //     return response()->json(['success' => 'Shift swap request submitted', 'shift_change' => $shiftChange]);
    // }
    // public function showSwapRequestForm()
    // {
    //     $mySchedules = Schedule::where('id_employee', auth()->user()->id_employee)->get();
    //     $otherSchedules = Schedule::where('id_employee', '!=', auth()->user()->id_employee)->get();

    //     return view('shift_swap.request', compact('mySchedules', 'otherSchedules'));
    // }

    // public function approveShiftSwap($id)
    // {
    //     $shiftChange = ShiftChange::findOrFail($id);

    //     // Update shift change status to approved
    //     $shiftChange->status = 'approved';
    //     $shiftChange->save();

    //     // Get the schedules involved in the swap
    //     $scheduleFrom = Schedule::findOrFail($shiftChange->id_schedule_from);
    //     $scheduleTo = Schedule::findOrFail($shiftChange->id_schedule_to);

    //     // Swap the shifts between the employees in the schedules
    //     $tempShift = $scheduleFrom->shift;
    //     $scheduleFrom->shift = $scheduleTo->shift;
    //     $scheduleTo->shift = $tempShift;

    //     $scheduleFrom->save();
    //     $scheduleTo->save();

    //     // Update attendance records for both employees after swap
    //     Attendance::where('id_employee', $scheduleFrom->id_employee)
    //         ->where('date', $scheduleFrom->date)
    //         ->update(['shift' => $scheduleFrom->shift]);

    //     Attendance::where('id_employee', $scheduleTo->id_employee)
    //         ->where('date', $scheduleTo->date)
    //         ->update(['shift' => $scheduleTo->shift]);

    //     return redirect()->back()->with('success', 'Shift swap approved and attendance updated.');
    // }

    // public function manageShiftSwaps()
    // {
    //     $shiftChanges = ShiftChange::with(['fromSchedule.employee', 'toSchedule.employee'])->get();

    //     return view('shift_swap.manage', compact('shiftChanges'));
    // }


    // todo:yang baru coy!!!
    public function requestShiftSwap(Request $request)
    {
        // Validate that both schedule IDs exist
        $fromSchedule = Schedule::find($request->id_schedule_from);
        $toSchedule = Schedule::find($request->id_schedule_to);

        if (!$fromSchedule || !$toSchedule) {
            return response()->json(['error' => 'Invalid schedules'], 400);
        }

        // Create a new shift change request
        $shiftChange = ShiftChange::create([
            'id_schedule_from' => $request->id_schedule_from,
            'id_schedule_to' => $request->id_schedule_to,
            'status' => 'pending'
        ]);

        return response()->json(['success' => 'Shift swap request submitted', 'shift_change' => $shiftChange]);
    }

    public function approveShiftSwap($id)
    {
        $shiftChange = ShiftChange::findOrFail($id);

        // Update shift change status to approved
        $shiftChange->status = 'disetujui';
        $shiftChange->save();

        // Get the schedules involved in the swap
        $scheduleFrom = Schedule::findOrFail($shiftChange->id_schedule_from);
        $scheduleTo = Schedule::findOrFail($shiftChange->id_schedule_to);

        // Swap the shifts between the employees in the schedules
        $tempShift = $scheduleFrom->shift;
        $scheduleFrom->shift = $scheduleTo->shift;
        $scheduleTo->shift = $tempShift;

        $scheduleFrom->save();
        $scheduleTo->save();

        // Update attendance records for both employees after swap
        Attendance::where('id_employee', $scheduleFrom->id_employee)
            ->where('date', $scheduleFrom->date)
            ->update(['shift' => $scheduleFrom->shift]);

        Attendance::where('id_employee', $scheduleTo->id_employee)
            ->where('date', $scheduleTo->date)
            ->update(['shift' => $scheduleTo->shift]);

        return redirect()->back()->with('success', 'Shift swap approved and attendance updated.');
    }


    public function rejectShiftSwap($id)
    {
        // Find the shift change request
        $shiftChange = ShiftChange::find($id);

        if (!$shiftChange || $shiftChange->status !== 'pending') {
            return response()->json(['error' => 'Invalid or already processed request'], 400);
        }

        // Update the shift change request status to rejected
        $shiftChange->status = 'rejected';
        $shiftChange->save();

        return response()->json(['success' => 'Shift swap rejected']);
    }

    public function showSwapRequestForm()
    {
        $mySchedules = Schedule::where('id_employee', Auth::user()->id_employee)->get();
        $otherSchedules = Schedule::where('id_employee', '!=', Auth::user()->id_employee)->get();

        return view('admin.shift_swap.request', compact('mySchedules', 'otherSchedules'));
    }

    public function manageShiftSwaps()
    {
        $shiftChanges = ShiftChange::with(['fromSchedule.employee', 'toSchedule.employee'])->get();

        return view('admin.shift_swap.manage', compact('shiftChanges'));
    }
}
