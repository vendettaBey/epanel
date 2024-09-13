@extends('layouts.app')

@section('content')
    <div class="container-fluid mt-5">
        <h3 class="mb-4">Bir Slot Seçin</h3>

        <div class="accordion" id="employeeAccordion"> <!-- Bootstrap Accordion -->
            @foreach ($slots as $employee => $dateGroup)
                <!-- Çalışana göre gruplama -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="heading-{{ Str::slug($employee) }}">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapse-{{ Str::slug($employee) }}" aria-expanded="true"
                            aria-controls="collapse-{{ Str::slug($employee) }}">
                            {{ $employee }} <!-- Çalışan Adı Accordion Başlığı -->
                        </button>
                    </h2>
                    <div id="collapse-{{ Str::slug($employee) }}" class="accordion-collapse collapse"
                        aria-labelledby="heading-{{ Str::slug($employee) }}" data-bs-parent="#employeeAccordion">
                        <div class="accordion-body">
                            <!-- Tarihe göre slotları göster -->
                            @foreach ($dateGroup as $date => $slotGroup)
                                <!-- Tarihe göre gruplama -->
                                <div class="col-12">
                                    <h4>{{ date('d-m-Y', strtotime($date)) }}</h4> <!-- Gün başlığı -->
                                    <hr>
                                </div>
                                <div class="row">


                                    @foreach ($slotGroup as $slot)
                                        <div class="col-md-2">
                                            <div class="card mb-3">
                                                <div class="card-body">
                                                    <h5 class="card-title">{{ $slot->employee->name }}</h5>
                                                    <hr>
                                                    <p>{{ $slot->start_time }} - {{ $slot->end_time }}</p>
                                                    <!-- Saat aralığı -->
                                                    @if ($slot->status == 0)
                                                        <a href="{{ route('appointments.create', ['slot' => $slot->id]) }}"
                                                            class="btn btn-success">Randevu Oluştur</a>
                                                    @else
                                                        <button class="btn btn-danger" disabled>Bu Slot Dolu</button>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
