<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Slot;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index()
    {
        // Get all appointments with the related slot data
        $appointments = Appointment::with('slot.employee')->get();

        return view('backend.appointments.index', compact('appointments'));
    }

    public function selectSlot()
    {
        // Slotları çek ve hem çalışan hem de tarihe göre gruplandır
        $slots = Slot::with('employee')
            ->orderBy('end_date')
            ->get()
            ->groupBy(function ($slot) {
                return $slot->employee->name; // Çalışana göre gruplandır
            })->map(function ($employeeSlots) {
                return $employeeSlots->groupBy('end_date'); // Tarihe göre gruplandır
            });

        return view('backend.appointments.select-slot', compact('slots'));
    }


    public function create(Slot $slot)
    {
        return view('backend.appointments.create', compact('slot'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'slot_id' => 'required|exists:slots,id',
            'client_name' => 'required|string|max:255',
            'client_phone' => 'required|string|max:15',
            'description' => 'nullable|string',
        ]);

        // Create a new appointment
        Appointment::create([
            'slot_id' => $request->slot_id,
            'client_name' => $request->client_name,
            'client_phone' => $request->client_phone,
            'description' => $request->description,
        ]);

        // Update the slot status to occupied
        $slot = Slot::find($request->slot_id);
        $slot->status = 1;
        $slot->save();

        return redirect()->route('appointments.index')->with('success', 'Randevu başarıyla oluşturuldu.');
    }


    public function edit(Appointment $appointment)
    {
        return view('backend.appointments.edit', compact('appointment'));
    }

    public function update(Request $request, Appointment $appointment)
    {
        $request->validate([
            'client_name' => 'required|string|max:255',
            'client_phone' => 'required|string|max:15',
            'description' => 'nullable|string',
        ]);

        // Update the appointment details
        $appointment->update([
            'client_name' => $request->client_name,
            'client_phone' => $request->client_phone,
            'description' => $request->description,
        ]);

        return redirect()->route('appointments.index')->with('success', 'Randevu başarıyla güncellendi.');
    }


    public function destroy(Appointment $appointment)
    {
        $appointment->delete();
    
        return redirect()->route('appointments.index')->with('success', 'Randevu başarıyla silindi.');
    }

}