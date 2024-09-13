<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slot;
use App\Models\Employee;
use Carbon\Carbon;
use Carbon\CarbonImmutable;

class SlotController extends Controller
{
    public function index(Request $request)
    {
        $employee_id = $request->query('employee_id');
        
        // Fetch slots, optionally filtered by employee
        $slots = Slot::when($employee_id, function ($query, $employee_id) {
            return $query->where('employee_id', $employee_id);
        })->orderBy('start_time')->get();

        // Group slots by date
        $slotsGroupedByDate = $slots->groupBy(function ($slot) {
            return \Carbon\Carbon::parse($slot->end_date)->format('Y-m-d');
        });
        $employees = Employee::all();
        return view('backend.slots.index', compact('slotsGroupedByDate', 'employees'));
    }


    public function create()
    {
        $employees = Employee::all();
        return view('backend.slots.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'work_days' => 'required|array',
            'work_days.*' => 'in:pazartesi,salı,çarşamba,perşembe,cuma,cumartesi,pazar',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'time_slot' => 'required|integer|min:5',
            'break_start_time' => 'nullable|date_format:H:i|before:break_end_time',
            'break_end_time' => 'nullable|date_format:H:i|after:break_start_time',
            'end_date' => 'required|date|after_or_equal:today',
        ]);

        // Create a mapping of English day names to Turkish day names
        $daysMapping = [
            'monday' => 'pazartesi',
            'tuesday' => 'salı',
            'wednesday' => 'çarşamba',
            'thursday' => 'perşembe',
            'friday' => 'cuma',
            'saturday' => 'cumartesi',
            'sunday' => 'pazar',
        ];

        // Loop through all the work days and generate slots
        $startDate = now(); // You can modify this to the starting date you want
        $endDate = new \DateTime($request->end_date);
        $currentDate = clone $startDate;
        
        while ($currentDate <= $endDate) {
            $dayOfWeekEnglish = strtolower($currentDate->format('l')); // Get the day of the week in English
            $dayOfWeekTurkish = $daysMapping[$dayOfWeekEnglish]; // Convert it to Turkish

            if (in_array($dayOfWeekTurkish, $request->work_days)) {
                // Generate slots for the current date
                $startTime = \Carbon\Carbon::createFromFormat('H:i', $request->start_time);
                $endTime = \Carbon\Carbon::createFromFormat('H:i', $request->end_time);

                while ($startTime->lt($endTime)) {
                    // Avoid adding slots during break time
                    if ($request->break_start_time && $request->break_end_time) {
                        $breakStartTime = \Carbon\Carbon::createFromFormat('H:i', $request->break_start_time);
                        $breakEndTime = \Carbon\Carbon::createFromFormat('H:i', $request->break_end_time);

                        if ($startTime->between($breakStartTime, $breakEndTime)) {
                            $startTime->addMinutes((int) $request->time_slot); // Cast to int
                            continue;
                        }
                    }

                    // Store the slot in the database
                    Slot::create([
                        'employee_id' => $request->employee_id,
                        'work_days' => $request->work_days,
                        'start_time' => $startTime->format('H:i'),
                        'end_time' => $endTime->format('H:i'),
                        'time_slot' => (int) $request->time_slot, // Cast to int
                        'break_start_time' => $request->break_start_time,
                        'break_end_time' => $request->break_end_time,
                        'end_date' => $currentDate->format('Y-m-d'),
                    ]);

                    // Increment the time by the time slot interval
                    $startTime->addMinutes((int) $request->time_slot); // Cast to int
                }
            }
            $currentDate->modify('+1 day');
        }

        return redirect()->route('slots.index')->with('success', 'Slots created successfully.');
    }


    public function getEmployeeSlots($employee_id)
    {
        // Çalışana ait slotları getir
        $slots = Slot::where('employee_id', $employee_id)->get();

        return response()->json($slots);
    }





    



    // Show the edit form for a specific slot
    public function edit(Slot $slot)
    {
        $employees = Employee::all(); // Fetch all employees to show in the dropdown
        return view('backend.slots.edit', compact('slot', 'employees'));
    }

    // Update the existing slot
    public function update(Request $request, Slot $slot)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'work_days' => 'required|array',
            'work_days.*' => 'in:pazartesi,salı,çarşamba,perşembe,cuma,cumartesi,pazar',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'time_slot' => 'required|integer|min:5',
            'break_start_time' => 'nullable|date_format:H:i|before:break_end_time',
            'break_end_time' => 'nullable|date_format:H:i|after:break_start_time',
            'end_date' => 'required|date',
        ]);

        // Update slot data
        $slot->update([
            'employee_id' => $request->employee_id,
            'work_days' => $request->work_days,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'time_slot' => $request->time_slot,
            'break_start_time' => $request->break_start_time,
            'break_end_time' => $request->break_end_time,
            'end_date' => $request->end_date,
        ]);

        return redirect()->route('slots.index')->with('success', 'Slot güncellendi.');
    }


    public function destroy(Slot $slot)
    {
        $slot->delete();
        return redirect()->route('slots.index')->with('success', 'Slot silindi.');
    }

}

