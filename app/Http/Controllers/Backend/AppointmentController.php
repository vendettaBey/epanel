<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\AppointmentSetting;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

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
        // Validasyon işlemleri
        $request->validate([
            'client_name' => 'required|string|max:255',
            'client_phone' => 'required|string|max:255',
            'date' => 'required|date',
            'start_time' => 'required',
            'day_of_week' => 'required|string',
        ]);

        // Seçilen gün için AppointmentSetting tablosundan time_slot değerini alın
        $appointmentSetting = AppointmentSetting::where('day_of_week', $request->day_of_week)->first();

        if (!$appointmentSetting) {
            return redirect()->back()->withErrors(['day_of_week' => 'Seçilen gün için bir randevu ayarı bulunamadı.']);
        }

        // Tarih ve zamanı birleştir
        $startDateTime = Carbon::createFromFormat('Y-m-d H:i', $request->date . ' ' . $request->start_time);

        // End time hesaplama
        $endDateTime = $startDateTime->copy()->addMinutes($appointmentSetting->time_slot);

        // Randevuyu veritabanına kaydetme
        Appointment::create([
            'client_name' => $request->client_name,
            'client_phone' => $request->client_phone,
            'message' => $request->note,
            'client_email' => $request->client_email,
            'start_time' => $startDateTime->toDateTimeString(),
            'end_time' => $endDateTime->toDateTimeString(),
            'day_of_week' => $request->day_of_week,
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
                'break_start_time' => $setting['break_start_time'],
                'break_end_time' => $setting['break_end_time'],
            ]);
        }

        return redirect()->back()->with('success', 'Randevu ayarları başarıyla güncellendi.');
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

        Log::info("Requested day of week: $dayOfWeek and date: $date");

        // Seçilen gün için ayarları getir
        $setting = AppointmentSetting::where('day_of_week', $dayOfWeek)->where('status', true)->first();

        if (!$setting) {
            Log::info("No setting found for the requested day of week: $dayOfWeek");
            return response()->json([]);
        }

        Log::info("Setting found: " . json_encode($setting));

        $startTime = Carbon::parse($setting->start_time);
        $endTime = Carbon::parse($setting->end_time);
        $breakStartTime = Carbon::parse($setting->break_start_time);
        $breakEndTime = Carbon::parse($setting->break_end_time);
        $timeSlot = $setting->time_slot;

        $slots = [];
        $currentTime = $startTime->copy();

        // Tüm potansiyel zaman dilimlerini oluştur ve mola saatlerini dışarıda bırak
        while ($currentTime->lessThan($endTime)) {
            $slotEndTime = $currentTime->copy()->addMinutes($timeSlot);

            // Mola kontrolü
            if (!($currentTime->between($breakStartTime, $breakEndTime) || $slotEndTime->between($breakStartTime, $breakEndTime))) {
                $slots[] = [
                    'start_time' => $currentTime->format('H:i'),
                    'end_time' => $slotEndTime->format('H:i'),
                ];
            }

            $currentTime->addMinutes($timeSlot);

            // Sonsuz döngü olup olmadığını kontrol et
            if ($currentTime->gte($endTime)) {
                break;
            }
        }


        Log::info("Available slots: " . json_encode($slots));

        return response()->json($slots);
    }


















}
