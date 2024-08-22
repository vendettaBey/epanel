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
        $appointments = Appointment::with('slot')->get();
        return view('backend.appointments.index', compact('appointments'));
    }

    public function create()
    {
        return view('backend.appointments.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'client_name' => 'required|string|max:255',
            'client_phone' => 'required|string|max:255',
            'date' => 'required|date',
            'slot_id' => 'required|exists:slots,id',
        ]);

        $slot = Slot::where('id', $request->slot_id)->first();
        $slot->status = false;
        $slot->save();

        Appointment::create([
            'client_name' => $request->client_name,
            'client_phone' => $request->client_phone,
            'date' => $request->date,
            'slot_id' => $request->slot_id,
        ]);

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
            'client_phone' => 'required|string|max:255',
            'date' => 'required|date',
            'slot_id' => 'required|exists:slots,id',
        ]);

        $appointment->update($request->all());

        return redirect()->route('appointments.index')->with('success', 'Randevu başarıyla güncellendi.');
    }

    public function destroy(Appointment $appointment)
    {
        $appointment->delete();

        return redirect()->route('appointments.index')->with('success', 'Randevu başarıyla silindi.');
    }

    public function getSlotsForDate(Request $request)
    {
        $date = $request->input('date');
        $dayOfWeek = date('l', strtotime($date));

        $slots = Slot::where('day_of_week', $dayOfWeek)
            ->where('status', true)
            ->get();

        return response()->json($slots);
    }

    public function getSlots(Request $request)
{
    $date = $request->input('date');

    if (!$date) {
        return response()->json(['error' => 'Date is required'], 400);
    }

    $slots = Slot::whereDate('date', $date)->get();

    return response()->json($slots);
}

}