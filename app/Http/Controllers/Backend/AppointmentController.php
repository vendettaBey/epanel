<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\AppointmentSetting;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    // 1. Randevular ve Ayarlar Sayfası
    public function index()
    {
        $appointments = Appointment::orderBy('start_time')->get();
        $settings = AppointmentSetting::all();
        return view('appointments.index', compact('appointments', 'settings'));
    }

    // 2. Yeni Randevu Oluşturma
    public function create()
    {
        $settings = AppointmentSetting::all();
        return view('appointments.create', compact('settings'));
    }

    // 3. Randevu Kaydetme
    public function store(Request $request)
    {
        $request->validate([
            'client_name' => 'required|string|max:255',
            'day_of_week' => 'required|string|in:Pazartesi,Salı,Çarşamba,Perşembe,Cuma,Cumartesi,Pazar',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        $setting = AppointmentSetting::where('day_of_week', $request->day_of_week)->where('status', true)->first();

        if (!$setting) {
            return redirect()->back()->withErrors(['day_of_week' => 'Seçilen gün için randevu alınamaz, çünkü bu gün pasif durumda.']);
        }

        $startDateTime = Carbon::parse($request->start_time);
        $endDateTime = Carbon::parse($request->end_time);

        Appointment::create([
            'client_name' => $request->client_name,
            'start_time' => $startDateTime->toDateTimeString(),
            'end_time' => $endDateTime->toDateTimeString(),
        ]);

        return redirect()->route('appointments.index')->with('success', 'Randevu başarıyla oluşturuldu.');
    }

    // 4. Randevu Düzenleme Sayfası
    public function edit(Appointment $appointment)
    {
        $settings = AppointmentSetting::all();
        return view('appointments.edit', compact('appointment', 'settings'));
    }

    // 5. Randevu Güncelleme
    public function update(Request $request, Appointment $appointment)
    {
        $request->validate([
            'client_name' => 'required|string|max:255',
            'start_time' => 'required|date_format:Y-m-d H:i',
            'end_time' => 'required|date_format:Y-m-d H:i|after:start_time',
        ]);

        $appointment->update($request->all());

        return redirect()->route('appointments.index')->with('success', 'Randevu başarıyla güncellendi.');
    }

    // 6. Randevu Silme
    public function destroy(Appointment $appointment)
    {
        $appointment->delete();
        return redirect()->route('appointments.index')->with('success', 'Randevu başarıyla silindi.');
    }

    // 7. Randevu Ayarlarını Düzenleme
    public function settings()
    {
        $daysOfWeek = ['Pazartesi', 'Salı', 'Çarşamba', 'Perşembe', 'Cuma', 'Cumartesi', 'Pazar'];

        foreach ($daysOfWeek as $day) {
            AppointmentSetting::firstOrCreate(
                ['day_of_week' => $day],
                [
                    'start_time' => '09:00:00', // Varsayılan başlangıç saati
                    'end_time' => '17:00:00',   // Varsayılan bitiş saati
                    'time_slot' => 30,           // Varsayılan randevu aralığı (30 dakika)
                    'status' => true             // Varsayılan olarak aktif
                ]
            );
        }

        $settings = AppointmentSetting::all();
        return view('appointments.settings', compact('settings'));
    }


    // 8. Randevu Ayarlarını Güncelleme
    public function updateSettings(Request $request)
    {
        foreach ($request->settings as $day => $setting) {
            AppointmentSetting::where('day_of_week', $day)->update([
                'start_time' => $setting['start_time'],
                'end_time' => $setting['end_time'],
                'time_slot' => $setting['time_slot'],
                'status' => isset($setting['status']) ? true : false,
            ]);
        }
    
        return redirect()->route('appointments.settings')->with('success', 'Randevu ayarları başarıyla güncellendi.');
    }

    public function toggleStatus(Request $request, $day)
    {
        $setting = AppointmentSetting::where('day_of_week', $day)->firstOrFail();
        $setting->status = !$setting->status;
        $setting->save();

        return response()->json([
            'status' => $setting->status,
            'message' => $setting->status ? 'Gün aktif hale getirildi.' : 'Gün pasif hale getirildi.'
        ]);
    }


    // 9. Boş Saat Dilimlerini Getirme
    public function getAvailableSlots(Request $request)
    {
        $dayOfWeek = $request->day_of_week;
        $date = $request->date;

        $setting = AppointmentSetting::where('day_of_week', $dayOfWeek)->firstOrFail();
        $startTime = Carbon::parse($setting->start_time);
        $endTime = Carbon::parse($setting->end_time);
        $timeSlot = $setting->time_slot;

        $slots = [];
        while ($startTime->lessThan($endTime)) {
            $slotEndTime = $startTime->copy()->addMinutes($timeSlot);
            $isBooked = Appointment::where('start_time', $startTime)
                                    ->where('end_time', $slotEndTime)
                                    ->exists();

            if (!$isBooked) {
                $slots[] = [
                    'start_time' => $startTime->format('H:i'),
                    'end_time' => $slotEndTime->format('H:i')
                ];
            }

            $startTime->addMinutes($timeSlot);
        }

        return response()->json($slots);
    }
}
