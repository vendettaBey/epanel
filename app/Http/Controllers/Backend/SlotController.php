<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slot;
use Carbon\Carbon;
use Carbon\CarbonImmutable;

class SlotController extends Controller
{
    public function index()
    {
        $slots = Slot::all();
        return view('backend.slots.index', compact('slots'));
    }

    public function create()
    {
        return view('backend.slots.create');
    }

    public function store(Request $request)
{
    Carbon::setLocale('tr'); // Gün adlarını Türkçe yapmak için

    $startTime = Carbon::parse($request->start_time);
    $endTime = Carbon::parse($request->end_time);
    $breakStart = Carbon::parse($request->break_start);
    $breakEnd = Carbon::parse($request->break_end);
    $timeSlot = (int)$request->time_slot;

    // Gün adını Türkçe olarak al
    $dayOfWeek = Carbon::parse($request->date)->translatedFormat('l');
    $date = Carbon::parse($request->date)->format('Y-m-d');

    while ($startTime->lessThan($endTime)) {
        $slotEndTime = $startTime->copy()->addMinutes($timeSlot);

        // Mola saatlerine giren slotları kontrol et ve dışarıda kalanları kaydet
        if (
            !($startTime->between($breakStart, $breakEnd) || $slotEndTime->between($breakStart, $breakEnd))
        ) {
            Slot::create([
                'date' => $date, // Date alanını kaydet
                'start_time' => $startTime->format('H:i'),
                'end_time' => $slotEndTime->format('H:i'),
                'day_of_week' => $dayOfWeek, // Gün adını Türkçe olarak kaydet
                'interval' => $timeSlot,
            ]);
        }

        // Bir sonraki slotun başlangıç zamanını hesapla
        $startTime->addMinutes($timeSlot);
    }

    return redirect()->route('slots.index')->with('success', 'Slotlar başarıyla oluşturuldu.');
}


    



    public function edit(Slot $slot)
    {
        return view('backend.slots.edit', compact('slot'));
    }

    public function update(Request $request, Slot $slot)
    {
        $request->validate([
            'day_of_week' => 'required|string',
            'start_time' => 'required',
            'end_time' => 'required',
            'interval' => 'required|integer',
            'break_start' => 'nullable',
            'break_end' => 'nullable',
        ]);

        $slot->update($request->all());

        return redirect()->route('slots.index')->with('success', 'Slot başarıyla güncellendi.');
    }

    public function destroy(Slot $slot)
    {
        $slot->delete();

        return redirect()->route('slots.index')->with('success', 'Slot başarıyla silindi.');
    }

    public function toggleStatus(Slot $slot)
    {
        $slot->status = !$slot->status;
        $slot->save();

        return response()->json([
            'status' => $slot->status,
            'message' => 'Slot durumu güncellendi.'
        ]);
    }
}

