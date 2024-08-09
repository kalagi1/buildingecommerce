@extends('client.layouts.masterPanel')
@section('content')
    <div class="content">

        <div class="table-breadcrumb mb-5">
            <ul>
                <li>
                    Hesabım
                </li>
                <li>
                    CRM
                </li>
                <li>
                    İstatistik Verileri
                </li>
            </ul>
        </div>
        {{-- Header --}}
        <div class="row">
            <div class="text-header-title">
                <p class="sales-consultants-heading"> İletişim Faaliyetleri ve Performans Göstergeleri</p>
            </div>          
        </div>
        {{-- müşterilerim nereden geliyor --}}
        <div class="row ">
            <div class="data-title">
                <span>Müşteri verilerim nereden geliyor ?
                    <i class="fas fa-info-circle info-icon" style="margin-left:5px;font-size: 16px;" data-bs-toggle="tooltip" data-bs-placement="top" title="Müşteri verilerinizin hangi platformdan ve hangi oranda geldiğini görebilirsiniz."></i>
                </span>
            </div>
            <div class="col-6">
             
                <div class="card mt-3" style="border-radius:13px">
                    <div class="card-body">
                        <div class="custom-table">
                            <div class="table-body">
                                @foreach ($sourcePlatform['platformData'] as $platform => $data)
                                    <div class="table-row">
                                        <div class="cell">{{ $platform }}</div>
                                        <div class="cellData">{{ $data['count'] }}</div>
                                        <div class="cellData">{{ $data['percentage'] }} %</div>
                                    </div>
                                @endforeach   
                                <div class="table-row total-summary">
                                    <div class="cell">Toplam Müşteri Sayısı</div>
                                    <div class="cellData">{{ $sourcePlatform['totalCount'] }}</div>
                                    <div class="cellData"></div>
                                </div>                    
                            </div>
                        </div>
                    </div>
                </div>
            </div>    
            <div class="col-6">
                <div class="card mt-3" style="border-radius:13px">
                    <div class="row" style="padding: 21px 10px;">
                        <div class="col-md-4 chart-container">
                            <span style="font-size: 12px;color: #000;font-weight: 600;">Veri Grafiği</span>
                            <canvas id="customerChart" style="margin-top:10px;"></canvas>
                        </div>
                        <div class="col-md-8 data-summary">
                            @php
                                $totalCount = $sourcePlatform['totalCount'];
                                $platformData = $sourcePlatform['platformData'];
                            @endphp
                            <ul class="data-summary-list">
                                <li>Toplam {{ $totalCount }} adet müşterimiz bulunmaktadır.</li>
                                @foreach ($platformData as $platform => $data)
                                    <li>Verilerimizin {{ $data['percentage'] }}% {{ ucfirst($platform) }} tarafından sağlanmaktadır.</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>         
        </div>
        {{-- randevu ve arama istatistiği --}}
        <div class="row mt-5">
            <div class="col-6">
                <div class="data-title">
                    <span>Randevu İstatistikleri
                        <i class="fas fa-info-circle info-icon" style="margin-left:5px;font-size: 16px;" data-bs-toggle="tooltip" data-bs-placement="top" title="Satış Temsilcilerinizin günlük, haftalık ve aylık randevu sayılarını takip edebilirsiniz."></i>
                    </span>
                </div>
                <div class="mt-3" style="background-color:white;padding: 2px;border-radius: 13px;">
                    <ul class="mt-2 consultantAppointment" style="display: flex;justify-content: space-around;">
                        <li class="nav-item active dailyAppointments" data-period="dailyAppointments">Günlük</li>
                        <li class="nav-item weeklyAppointments"       data-period="weeklyAppointments">Haftalık</li>
                        <li class="nav-item monthlyAppointments"      data-period="monthlyAppointments">Aylık</li>
                    </ul>
                </div>
                <div class="card mt-3" style="border-radius:13px">
                    <div class="card-body">
                        <div class="custom-table">
                            <div class="table-header">
                                <div class="header-item"><span>Satış Temsilcilerim</span></div>
                                <div class="header-item"><span>Randevu Sayısı</span></div>
                                <div class="header-item"><span>Arama / Randevu Oranı</span></div>
                            </div>
                            <div class="appointments-table-body" id="appointments-table-body">
                               
                                <div id="spinner" class="spinner"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-6">
                <div class="data-title">
                    <span>Arama İstatistikleri
                        <i class="fas fa-info-circle info-icon" style="margin-left:5px;font-size: 16px;" data-bs-toggle="tooltip" data-bs-placement="top" title="Satış Temsilcilerinizin günlük, haftalık ve aylık arama sayılarını takip edebilirsiniz."></i>
                    </span>
                </div>
                <div class="mt-3" style="background-color:white;padding: 2px;border-radius: 13px;">
                    <ul class="mt-2 consultantCall" style="display: flex;justify-content: space-around;">
                        <li class="nav-item active" data-period="daily">Günlük</li>
                        <li class="nav-item"        data-period="weekly" >Haftalık</li>
                        <li class="nav-item"        data-period="monthly" >Aylık</li>
                    </ul>
                </div>
                <div class="card mt-3" style="border-radius:13px">
                    <div class="card-body">
                        <div class="custom-table">
                            <div class="table-header">
                                <div class="header-item"><span>Satış Temsilcilerim</span></div>
                                <div class="header-item"><span>Arama Sayısı</span></div>
                                <div class="header-item"><span>Değerlendirme</span></div>
                            </div>
                            <div class="call-table-body" id="call-table-body">                              
                                <div id="spinner" class="spinner"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>            
        </div>
        {{-- müşteri tercihleri --}}
        <div class="row mt-5">
            <div class="col-4">
                <div style="background: #fff; color:#ea2a28; padding: 7px; font-size: 14px; border-radius: 11px; text-align: center; align-items: center; justify-content: center; font-weight: 500; position: relative; box-shadow: 0 8px 0 #ea2a28;">
                    <span>Yatırım Planı 
                        <i class="fas fa-info-circle info-icon" style="margin-left:5px;font-size: 16px;" data-bs-toggle="tooltip" data-bs-placement="top" title="Müşterilerinizin yatırım planlarının sayısını gösterir"></i>
                    </span>
                </div>
                <div class="card mt-3" style="border-radius:13px">
                    <div class="card-body">
                        <div class="custom-table">                        
                            <div class="table-body">
                                @foreach ($assetManagements as $asset)
                                    <div class="table-row">
                                        <div class="cell">{{ $asset->varlik_yonetimi }}</div>
                                        <div class="cellData">{{ $asset->total }}</div>
                                    </div>
                                @endforeach            
                                <!-- Eğer veri sayısı 3'ten azsa, eksik satırları doldur -->
                                @for ($i = count($assetManagements); $i < 3; $i++)
                                    <div class="table-row">
                                        <div class="cell">---</div>
                                        <div class="cellData">0</div>
                                    </div>
                                @endfor
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-4">
                <div style="background: #fff; color:#ea2a28; padding: 7px; font-size: 14px; border-radius: 11px; text-align: center; align-items: center; justify-content: center; font-weight: 500; position: relative; box-shadow: 0 8px 0 #ea2a28;">
                    <span>Konut Tercihi
                        <i class="fas fa-info-circle info-icon" style="margin-left:5px; font-size: 16px;" data-bs-toggle="tooltip" data-bs-placement="top" title="Müşterilerinizin konut tercihlerinin sayısını gösterir"></i>
                    </span>
                </div>
                <div class="card mt-3" style="border-radius:13px">
                    <div class="card-body">
                        <div class="custom-table">
                            <div class="table-body">
                                @foreach ($housingPreferences as $preference)
                                    <div class="table-row">
                                        <div class="cell">{{ $preference->konut_tercihi }}</div>
                                        <div class="cellData">{{ $preference->total }}</div>
                                    </div>
                                @endforeach
            
                                <!-- Eğer veri sayısı 3'ten azsa, eksik satırları doldur -->
                                @for ($i = count($housingPreferences); $i < 3; $i++)
                                    <div class="table-row">
                                        <div class="cell">---</div>
                                        <div class="cellData">0</div>
                                    </div>
                                @endfor
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-4">
                <div style="background: #fff; color: #ea2a28; padding: 7px; font-size: 14px; border-radius: 11px; text-align: center; align-items: center; justify-content: center; font-weight: 500; position: relative; box-shadow: 0 8px 0 #ea2a28;">
                    <span>Müşteri Bütçe Dağılımı
                        <i class="fas fa-info-circle info-icon" style="margin-left:5px; font-size: 16px;" data-bs-toggle="tooltip" data-bs-placement="top" title="Müşterilerinizin yoğun olarak belirttiği 3 bütçe aralığı."></i>
                    </span>
                </div>
                <div class="card mt-3" style="border-radius:13px">
                    <div class="card-body">
                        <div class="custom-table">
                            <div class="table-body">
                                @foreach ($budgetCounts as $budget)
                                    <div class="table-row">
                                        <div class="cell">{{ $budget->musteri_butcesi ?: 'Belirtilmemiş' }}</div>
                                        <div class="cellData">{{ $budget->total }}</div>
                                    </div>
                                @endforeach
            
                                <!-- Eğer veri sayısı 3'ten azsa, eksik satırları doldur -->
                                @for ($i = count($budgetCounts); $i < 3; $i++)
                                    <div class="table-row">
                                        <div class="cell">---</div>
                                        <div class="cellData">0</div>
                                    </div>
                                @endfor
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>

        {{-- <div class="row mt-5">
            <div class="data-title">
                <span>Olumlu Müşteriler
                    <i class="fas fa-info-circle info-icon" style="margin-left:5px;font-size: 16px;" data-bs-toggle="tooltip" data-bs-placement="top" title="Satış temsilcilerin olumlu müşteri sayıları."></i>
                </span>
            </div>
            <div class="card mt-3" style="border-radius:13px">
                <div class="card-body">
                    <div class="custom-table">
                        <div class="table-header">
                            <div class="header-item"><span>Satış Temsilcilerim</span></div>
                            <div class="header-item"><span>Günlük</span></div>
                            <div class="header-item"><span>Haftalık</span></div>
                            <div class="header-item"><span>Aylık</span></div>
                        </div>
                        <div class="table-body">
                            <div class="table-row">
                                <div class="cell">Ali Yılmaz</div>
                                <div class="cellData">120</div>
                                <div class="cellData">30</div>
                                <div class="cellData">30</div>
                            </div>
                            <div class="table-row">
                                <div class="cell">Ayşe Demir</div>
                                <div class="cellData">85</div>
                                <div class="cellData">80</div>
                                <div class="cellData">80</div>
                            </div>
                            <div class="table-row">
                                <div class="cell">Mehmet Öz</div>
                                <div class="cellData">95</div>
                                <div class="cellData">10</div>
                                <div class="cellData">10</div>
                            </div>
                            <div class="table-row">
                                <div class="cell">Zeynep Kaya</div>
                                <div class="cellData">110</div>
                                <div class="cellData">60</div>
                                <div class="cellData">60</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
        {{-- projelerim nerede haritası --}}
        <div class="row mt-5">
            <div style="background-color: #ffffff;border-radius: 10px;padding: 50px 20px;">
                <div class="data-title mb-5">
                    <span>Mağazamın Projeleri
                        <i class="fas fa-info-circle info-icon" style="margin-left:5px;font-size: 16px;" data-bs-toggle="tooltip" data-bs-placement="top" title="Projelerimin harita üzerindeki konumu ve detayları."></i>
                    </span>
                </div>
                <div id="map" style="height: 500px;"></div>
            </div>
        </div>
        {{-- genel müşteri durum ve görüşme sonucu istatisiği --}}
        <div class="row mt-5">
            <div class="col-6">
                <div class="data-title">
                    <span>Genel Müşteri Durum İstatistiği
                        <i class="fas fa-info-circle info-icon" style="margin-left:5px;font-size: 16px;" data-bs-toggle="tooltip" data-bs-placement="top" title="Satış temsilcilerin yaptığı görüşmeler sonucu müşteri durumlarının genel istatistiği."></i>
                    </span>
                </div>
                <div class="mt-3" style="background-color:white;padding: 2px;border-radius: 13px;">
                    <ul class="mt-2 customer-status" style="display: flex;justify-content: space-around;">
                        <li class="nav-item active" data-period="daily">Günlük</li>
                        <li class="nav-item" data-period="weekly">Haftalık</li>
                        <li class="nav-item" data-period="monthly">Aylık</li>
                    </ul>
                </div>
                <div class="card mt-3" style="border-radius:13px">
                    <div class="card-body">
                        <div class="custom-table">
                            <div class="customer-status-table-body" id="customer-status-table-body">
                                <!-- Veriler buraya yüklenecek -->
                                <div id="spinner" class="spinner"></div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            
            <div class="col-6">
                <div class="data-title">
                    <span>Genel Müşteri Görüşme Sonucu İstatistiği
                        <i class="fas fa-info-circle info-icon" style="margin-left:5px;font-size: 16px;" data-bs-toggle="tooltip" data-bs-placement="top" title="Satış temsilcilerin yaptıkları görüşmeler sonucu arama sonuçlarının genel istatistiği."></i>
                    </span>
                </div>
                <div class="mt-3" style="background-color:white;padding: 2px;border-radius: 13px;">
                    <ul class="mt-2 call-results" style="display: flex;justify-content: space-around;">
                        <li class="nav-item active" data-period="daily">Günlük</li>
                        <li class="nav-item" data-period="weekly">Haftalık</li>
                        <li class="nav-item" data-period="monthly">Aylık</li>
                    </ul>
                </div>
                <div class="card mt-3" style="border-radius:13px">
                    <div class="card-body">
                        <div class="custom-table">
                            <div class="call-results-table-body" id="call-results-table-body">
                                <!-- Veriler buraya yüklenecek -->
                                <div id="spinner" class="spinner"></div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        {{-- dışman satışları istatistiği --}}
        <div class="row mt-5">
            <div class="data-title">
                <span>Satış Temsilcilerimin Yaptığı Satışlar
                    <i class="fas fa-info-circle info-icon" style="margin-left:5px;font-size: 16px;" data-bs-toggle="tooltip" data-bs-placement="top" title="Satış temsilcilerinizin konut,proje,arsa ve iş yeri bazlı satışlarını ve toplam satışlarını görebilirsiniz."></i>
                </span>
            </div>
            <div class="card mt-3" style="border-radius:13px">
                <div class="card-body">
                    <div class="custom-table">
                        <div class="table-header">
                            <div class="header-item"><span>Satış Temsilcilerim</span></div>
                            <div class="header-item"><span>Konut</span></div>
                            <div class="header-item"><span>Arsa</span></div>
                            <div class="header-item"><span>İş Yeri</span></div>
                            <div class="header-item"><span>Toplam Satış Adedi</span></div>
                        </div>
                        <div class="table-body">
                            @foreach($getConsultantSales as $data)
                            @php
                                // Her temsilcinin toplam satış sayısını hesapla
                                $totalSales = $data['konut'] + $data['arsa'] + $data['is-yeri'];
                            @endphp
                            <div class="table-row">
                                <div class="cell">{{ $data['representative_name'] }}</div>
                                <div class="cellData">{{ $data['konut'] }}</div>
                                <div class="cellData">{{ $data['arsa'] }}</div>
                                <div class="cellData">{{ $data['is-yeri'] }}</div>
                                <div class="cellData">{{ $totalSales }}</div> <!-- Toplam satış sayısı -->
                            </div>
                        @endforeach
                        
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
    @section('scripts')
        <!-- Leaflet CSS -->
        <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
        <!-- Leaflet JS -->
        <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
       
        <script>
            $(function () {
                $('[data-toggle="tooltip"]').tooltip();
            });
    
            // Chart.js kodu
            const ctx = document.getElementById('customerChart').getContext('2d');
            const data = {
                labels: @json(array_keys($sourcePlatform['platformData'])),
                datasets: [{
                    label: 'Müşteri Verileri',
                    data: @json(array_column($sourcePlatform['platformData'], 'count')),
                    backgroundColor: ['rgba(255, 99, 132, 0.2)', 'rgba(54, 162, 235, 0.2)', 'rgba(255, 206, 86, 0.2)', 'rgba(75, 192, 192, 0.2)', 'rgba(153, 102, 255, 0.2)', 'rgba(255, 159, 64, 0.2)'],
                    borderColor: ['rgba(255, 99, 132, 1)', 'rgba(54, 162, 235, 1)', 'rgba(255, 206, 86, 1)', 'rgba(75, 192, 192, 1)', 'rgba(153, 102, 255, 1)', 'rgba(255, 159, 64, 1)'],
                    borderWidth: 1
                }]
            };
            const config = {
                type: 'pie',
                data: data,
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false // Efsane etiketleri gizle
                        },
                        tooltip: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    return `${tooltipItem.label}: ${tooltipItem.raw} müşteri`;
                                }
                            }
                        }
                    }
                }
            };
            new Chart(ctx, config);
        </script>

        {{-- satış temsilcisi arama sayıları kodları --}}    
        <script>
            // JavaScript değişkenlerine PHP verilerini aktarın
            var dailyAppointments = @json($consultantDailyAppointments);
            var weeklyAppointments = @json($consultantWeeklyAppointments);
            var monthlyAppointments = @json($consultantMonthlyAppointments);
        
            var dailyCalls = @json($getDailyCallCounts);
            var weeklyCalls = @json($getWeeklyCallCounts);
            var monthlyCalls = @json($getMonthlyCallCounts);

            var dailyCustomerStatuses = @json($getDailyCustomerStatuses);
            var weeklyCustomerStatuses = @json($getWeeklyCustomerStatus);
            var monthlyCustomerStatuses = @json($getMonthlyCustomerStatus);

            var getDailyCustomerCallResults = @json($getDailyCustomerCallResults);
            var getWeeklyCustomerCallResults = @json($getWeeklyCustomerCallResults);
            var getMonthlyCustomerCallResults = @json($getMonthlyCustomerCallResults);
        
            $(document).ready(function() {

                function updateTable(tableBodyId, data, getRowHtml, period) {
                    let tableBody = $(tableBodyId);
                    $('#spinner').show();
                    
                    // Tablonun geçiş efekti için gerekli sınıfları ekleyin
                    tableBody.addClass('table-body-transition').removeClass('visible');
                    
                    setTimeout(function() {
                        tableBody.empty(); // Mevcut içeriği temizle

                        data.forEach(item => {
                            let rowHtml = getRowHtml(item);
                            tableBody.append(rowHtml);
                        });

                        // Eksik satırlar ekle
                        const rowCount = 4; // Gösterilecek toplam satır sayısı
                        for (let i = data.length; i < rowCount; i++) {
                            let rowHtml = `
                                <div class="table-row">
                                    <div class="cell">---</div>
                                    <div class="cellData">---</div>
                                    <div class="cellData">---</div>
                                </div>
                            `;
                            tableBody.append(rowHtml);
                        }

                        tableBody.removeClass('table-body-transition').addClass('visible');
                        $('#spinner').hide();
                    }, 800); // Geçiş süresi
                }

                function updateAppointmentsTable(period) {
                    let data;
                    let ratio;

                    switch(period) {
                        case 'dailyAppointments':
                            data = dailyAppointments;
                            break;
                        case 'weeklyAppointments':
                            data = weeklyAppointments;
                            break;
                        case 'monthlyAppointments':
                            data = monthlyAppointments;
                            break;
                        default:
                            data = dailyAppointments;
                    }

                    updateTable('#appointments-table-body', data, appointment => {
                        ratio = appointment.appointment_count < 2 ? 'Kötü' : (appointment.appointment_count <= 4 ? 'İyi' : 'Çok İyi');

                        return `
                            <div class="table-row">
                                <div class="cell">${appointment.representative_name}</div>
                                <div class="cellData">${appointment.appointment_count}</div>
                                <div class="cellData">${ratio}</div>
                            </div>
                        `;
                    }, period);
                }

                function updateCallsTable(period) {
                    let data;
                    let evaluation;

                    switch(period) {
                        case 'daily':
                            data = dailyCalls;
                            break;
                        case 'weekly':
                            data = weeklyCalls;
                            break;
                        case 'monthly':
                            data = monthlyCalls;
                            break;
                        default:
                            data = dailyCalls;
                    }

                    updateTable('#call-table-body', data, call => {
                        switch(period) {
                            case 'daily':
                                evaluation = call.total < 60 ? 'Kötü' : (call.total <= 80 ? 'İyi' : 'Çok İyi');
                                break;
                            case 'weekly':
                                evaluation = call.total < 300 ? 'Kötü' : (call.total <= 400 ? 'İyi' : 'Çok İyi');
                                break;
                            case 'monthly':
                                evaluation = call.total < 1200 ? 'Kötü' : (call.total <= 1600 ? 'İyi' : 'Çok İyi');
                                break;
                        }

                        return `
                            <div class="table-row">
                                <div class="cell">${call.consultant_name}</div>
                                <div class="cellData">${call.total}</div>
                                <div class="cellData">${evaluation}</div>
                            </div>
                        `;
                    }, period);
                }

                function updateCustomerStatusTable(period) {
                    let data;

                    switch(period) {
                        case 'daily':
                            data = dailyCustomerStatuses;
                            break;
                        case 'weekly':
                            data = weeklyCustomerStatuses;
                            break;
                        case 'monthly':
                            data = monthlyCustomerStatuses;
                            break;
                        default:
                            data = dailyCustomerStatuses;
                    }

                    updateTable('#customer-status-table-body', Object.keys(data).map(status => ({status, total: data[status]?.total || 0})), item => {
                        return `
                            <div class="table-row">
                                <div class="cell">${item.status}</div>
                                <div class="cellData">${item.total}</div>
                            </div>
                        `;
                    }, period);
                }

                function updateCustomerCallResults(period) {
                    let data;

                    switch(period) {
                        case 'daily':
                            data = getDailyCustomerCallResults;
                            break;
                        case 'weekly':
                            data = getWeeklyCustomerCallResults;
                            break;
                        case 'monthly':
                            data = getMonthlyCustomerCallResults;
                            break;
                        default:
                            data = getDailyCustomerCallResults;
                    }

                    updateTable('#call-results-table-body', Object.keys(data).map(conlusion => ({conlusion, total: data[conlusion]?.total || 0})), item => {
                        return `
                            <div class="table-row">
                                <div class="cell">${item.conlusion}</div>
                                <div class="cellData">${item.total}</div>
                            </div>
                        `;
                    }, period);
                }

                // İlk yüklemede günlük verileri göster
                updateAppointmentsTable('dailyAppointments');
                updateCallsTable('daily');
                updateCustomerStatusTable('daily');
                updateCustomerCallResults('daily');

                // Tab geçişlerine tıklama olayını ekle
                $('.call-results .nav-item').click(function() {
                    $('.call-results .nav-item').removeClass('active');
                    $(this).addClass('active');

                    let period = $(this).data('period');
                    updateCustomerCallResults(period);
                });

                $('.customer-status .nav-item').click(function() {
                    $('.customer-status .nav-item').removeClass('active');
                    $(this).addClass('active');

                    let period = $(this).data('period');
                    updateCustomerStatusTable(period);
                });

                $('.consultantAppointment .nav-item').click(function() {
                    $('.consultantAppointment .nav-item').removeClass('active');
                    $(this).addClass('active');

                    let period = $(this).data('period');
                    updateAppointmentsTable(period);
                });

                $('.consultantCall .nav-item').click(function() {
                    $('.consultantCall .nav-item').removeClass('active');
                    $(this).addClass('active');

                    let period = $(this).data('period');
                    updateCallsTable(period);
                });
            });

        </script>

        {{-- mağaza projeleri harita kodu --}}
        <script>
            // Harita oluşturuluyor
            var map = L.map('map').setView([39.9334, 32.8597], 6); // Türkiye merkezli bir koordinat

            // OpenStreetMap'ten tile katmanı ekleme
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            // Laravel'den gelen veriyi işleme
            var regionCount = @json($regionCounts);

            // Tarihleri formatlamak için yardımcı fonksiyon
            function formatDate(dateString) {
                var options = { day: '2-digit', month: '2-digit', year: 'numeric' };
                return new Date(dateString).toLocaleDateString('tr-TR', options);
            }
       

            // Her bir bölge için işaretçi (marker) ekleme
            regionCount.forEach(function(region) {
                var saleOrRent = (region.step2_slug === 'satilik') ? 'Satılık' : (region.step2_slug === 'kiralik') ? 'Kiralık' : 'Bilinmiyor';
        
                // Tarihleri formatlama
                var startDateFormatted = formatDate(region.start_date);
                var endDateFormatted = formatDate(region.project_end_date);
                
                L.marker([region.latitude, region.longitude]).addTo(map)
                .bindPopup(
                    '<div class="popup-content">' +
                    '<h3>' + region.name + '</h3>' +
                    '<p><strong style="font-weight: 800 !important;">Satılık / Kiralık:</strong> ' + saleOrRent + '</p>' +
                    '<p><strong style="font-weight: 800 !important;">Tür:</strong> ' + region.step1_slug.toUpperCase() + '</p>' +
                    '<p><strong style="font-weight: 800 !important;">Adet:</strong> ' + region.room_count + '</p>' +
                    '<p><strong style="font-weight: 800 !important;">Projeye Başlama Tarihi:</strong> ' + startDateFormatted + '</p>' +
                    '<p><strong style="font-weight: 800 !important;">Proje Bitiş Tarihi:</strong> ' + endDateFormatted + '</p>' +
                    '</div>'
                );
            });
       

        </script>
    @endsection


    @section('styles')
    <style>
         .data-summary-list {
        list-style-type: disc; /* Siyah noktaları gösterir */
        padding-left: 20px; /* Liste başlıklarının soldan mesafesi */
        font-size: 12px; /* Yazı boyutu */
        font-weight: bold; /* Yazı kalınlığı */
    }
    .data-summary-list li {
        margin-bottom: 5px; /* Satırlar arasındaki boşluk */
    }
        .data-summary {
            font-size: 12px; /* Yazı boyutu */
            font-weight: bold; /* Yazı kalınlığı */
            text-align: center;
        }
        .data-summary div {
            margin-bottom: 5px; /* Satırlar arasındaki boşluk */
        }
        .chart-container {
            position: relative;
            height: 110px;
            width: 110px;
            padding: 0px 40px !important;
        }
        /* Yüklenme animasyonu */
        .spinner {
            border: 4px solid rgba(0, 0, 0, 0.1);
            border-left: 4px solid #3498db;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin: 100px auto;
        }

        /* Yüklenme animasyonu döngüsü */
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Geçiş efekti için stiller */
        .table-body-transition {
            transform: scale(0.9);
            opacity: 0;
            transition: transform 0.5s ease, opacity 0.5s ease;
        }

        .table-body-transition.visible {
            transform: scale(1);
            opacity: 1;
        }


    </style>
    <style>
        .popup-content {
            font-family: Arial, sans-serif;
            max-width: 200px;
            line-height: 1.5;
            color: #333;
        }
    
        .popup-content h3 {
            font-size: 16px;
            margin: 0;
            padding-bottom: 10px;
            color: #007bff;
        }
    
        .popup-content p {
            margin: 0;
            padding: 0;
        }
    
        .popup-content p strong {
            color: #555;
        }

        #map {
            height: 100vh; /* Harita yüksekliği */
            width: 100%;
            position: relative;
        }
       
    </style>
    
    <style>
 
        .custom-table {
            background-color: #ffffff;
            border-radius: 5px;
            overflow: hidden;
        }

        .table-header {
            display: flex;
            background: white;
            font-size: 14px;
            padding: 10px;
            border-bottom: 2px solid #d2d2dc;
        }

        .header-item {
            flex: 1;
            font-weight: 600;
            text-align: center;
            font-size: 13px;
        }

        .table-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #dfdfdf;
        }

        .cell {
            flex: 1;
            text-align: center;
            font-weight: 600;
            font-size: 13px;
            line-height: 30px;
            color: #343434;
        }
        .cellData{
            flex: 1;
            text-align: center;
            font-weight: 500;
            font-size: 13px;
            line-height: 30px;
            color: #343434;

        }

        .table-row:last-child {
            border-bottom: none;
        }
    </style>

    <style>
        table{
            background-color: #ffffff !important; 
        }
        .active{
            color: #ea2a28;
        }
        .nav-item{
            font-size: 13px;
            cursor: pointer;
        }
        .data-title{
            background-color: #ea2a28;
            color: #ffffff;
            padding: 7px;
            font-size: 18px;
            border-radius: 11px;
            text-align: center;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }
        .card-header{
            background-color: #ea2a28;
            text-align: center;
        }
        .card-header-title{
            color: white;
            font-size: 13px;
            margin-top: 3px;
        }
        .text-header {
            padding: 30px;
            margin-bottom: 25px;
            background-color: white;
            border-radius: 18px;
        }
        .project-table-content ul li {
            padding: 12px 0px;
            flex: initial;
        }

        .sales-consultants-heading {
            color: #333;
            font-weight: bold;
            position: relative;
            font-size: 15px;
        }
    
        .text-header {
            padding: 30px;
            margin-bottom: 25px;
            background-color: white;
            border-radius: 18px;
        }

        .text-header-title {
            margin-bottom: 15px;
            margin-right: 5px; 
        }

        .btnProjectAssign {
            width: 95%;
            border-color: #EC2F2E;
            background-color: #EC2F2E;
            color: white;
            border-radius: 6px !important;
        }

        .btnProjectAssign:hover {
            background-color: white !important;
            color: #EC2F2E;
            border-color: #EC2F2E;
        }

        .card {
            position: relative;
            display: flex;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-color: #fff;
            background-clip: border-box;
            border: 1px solid #d2d2dc;
            border-radius: 0;
            padding:10px;            
        } 
    </style>
    @endsection
