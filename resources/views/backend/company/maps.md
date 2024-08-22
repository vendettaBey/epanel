<div class="container-fluid">
    <div class="row g-4 p-4">
        <div class="col-md-12">
            <div class="card card-primary card-outline mb-4">
                <div class="card-header">
                    <div class="card-title">Şirket Adresi</div>
                </div>
                <div class="card-body">
                    <div id="map" style="height: 500px; width: 100%;"></div>
                </div>
            </div>
        </div>
    </div>
</div>



<script>
document.addEventListener('DOMContentLoaded', function () {
    // Şirketin konumu
    const companyAddress = [{{ $company->lat }}, {{ $company->long }}];
    const companyName = '{{ $company->company_name }}';

    // Harita, şirket adresine ortalanmış olarak
    const map = L.map('map').setView(companyAddress, 15);

    // OpenStreetMap katmanı
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    // İşaretçi, şirket adresine konumlanmış olarak
    const marker = L.marker(companyAddress).addTo(map);

    // Google Maps yönlendirme bağlantısı
    const googleMapsLink = `https://www.google.com/maps/dir/?api=1&destination=${companyAddress[0]},${companyAddress[1]}`;

    // Açılır pencere içeriği
    const popupContent = `
        <strong>${companyName}</strong><br>
        <a href="${googleMapsLink}" target="_blank">Google Maps ile yol tarifi al</a>
    `;

    // Açılır pencereyi işaretçiye ekle
    marker.bindPopup(popupContent).openPopup();
});
</script>


