<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Schedule;
use App\Models\ShiftChange;
use Illuminate\Http\Request;

class ShiftSwapController extends Controller
{
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

    // public function approveShiftSwap($id)
    // {
    //     // Find the shift change request
    //     $shiftChange = ShiftChange::find($id);

    //     if (!$shiftChange || $shiftChange->status !== 'pending') {
    //         return response()->json(['error' => 'Invalid or already processed request'], 400);
    //     }

    //     // Perform the swap by swapping the employees in the schedules
    //     $fromSchedule = Schedule::find($shiftChange->id_schedule_from);
    //     $toSchedule = Schedule::find($shiftChange->id_schedule_to);

    //     // Swap the employees
    //     $tempEmployee = $fromSchedule->id_employee;
    //     $fromSchedule->id_employee = $toSchedule->id_employee;
    //     $toSchedule->id_employee = $tempEmployee;

    //     // Save the updated schedules
    //     $fromSchedule->save();
    //     $toSchedule->save();

    //     // Update the shift change request status to approved
    //     $shiftChange->status = 'approved';
    //     $shiftChange->save();

    //     return response()->json(['success' => 'Shift swap approved']);
    // }

    // public function rejectShiftSwap($id)
    // {
    //     // Find the shift change request
    //     $shiftChange = ShiftChange::find($id);

    //     if (!$shiftChange || $shiftChange->status !== 'pending') {
    //         return response()->json(['error' => 'Invalid or already processed request'], 400);
    //     }

    //     // Update the shift change request status to rejected
    //     $shiftChange->status = 'rejected';
    //     $shiftChange->save();

    //     return response()->json(['success' => 'Shift swap rejected']);
    // }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_schedule_from' => 'required|exists:schedules,id_schedule',
            'id_schedule_to' => 'required|exists:schedules,id_schedule|different:id_schedule_from',
        ]);

        $shiftChange = ShiftChange::create([
            'id_schedule_from' => $validated['id_schedule_from'],
            'id_schedule_to' => $validated['id_schedule_to'],
            'status' => 'diproses',
        ]);

        return response()->json(['message' => 'Permintaan pergantian shift berhasil diajukan'], 201);
    }

    public function approve(ShiftChange $shiftChange)
    {
        $shiftChange->update(['status' => 'disetujui']);

        // Logika untuk menukar jadwal dan kehadiran
        $scheduleFrom = $shiftChange->scheduleFrom;
        $scheduleTo = $shiftChange->scheduleTo;

        // Tukar shift
        $tempShift = $scheduleFrom->shift;
        $scheduleFrom->update(['shift' => $scheduleTo->shift]);
        $scheduleTo->update(['shift' => $tempShift]);

        // Perbarui kehadiran terkait
        Attendance::where('id_schedule', $scheduleFrom->id_schedule)->update(['shift' => $scheduleFrom->shift]);
        Attendance::where('id_schedule', $scheduleTo->id_schedule)->update(['shift' => $scheduleTo->shift]);

        return response()->json(['message' => 'Pergantian shift disetujui dan diterapkan'], 200);
    }
}
