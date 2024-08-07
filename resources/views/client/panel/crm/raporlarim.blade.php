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

        <div class="row">
            <div class="text-header-title">
                <p class="sales-consultants-heading"> İletişim Faaliyetleri ve Performans Göstergeleri</p>
            </div>          
        </div>

        <div class="row">
            <div class="col-6">
                <div class="data-title">
                    <span>Randevu İstatistikleri
                        <i class="fas fa-info-circle info-icon" style="margin-left:5px;font-size: 16px;" data-bs-toggle="tooltip" data-bs-placement="top" title="Danışmanlarınızın günlük, haftalık ve aylık randevu sayılarını takip edebilirsiniz."></i>
                    </span>
                </div>
                <div class="mt-3" style="background-color:white;padding: 2px;border-radius: 13px;">
                    <ul class="mt-2" style="display: flex;justify-content: space-around;">
                        <li class="nav-item active">Günlük</li>
                        <li class="nav-item">Haftalık</li>
                        <li class="nav-item">Aylık</li>
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
                            <div class="table-body">
                                @forelse ($consultantAppointments as $appointment)
                                    <div class="table-row">
                                        <div class="cell">{{ $appointment->name }}</div>
                                        <div class="cellData">{{ $appointment->randevu_sayisi }}</div>
                                        <div class="cellData">% 12</div>
                                    </div>
                                @empty
                                    <div class="table-row">
                                        <div class="cell">Veri bulunamadı</div>
                                        <div class="cellData"></div>
                                        <div class="cellData"></div>
                                    </div>
                                @endforelse
                                
                                <!-- Fill remaining rows if less than 4 -->
                                @for ($i = count($consultantAppointments); $i < 4; $i++)
                                    <div class="table-row">
                                        <div class="cell" style="">---</div>
                                        <div class="cellData">---</div>
                                        <div class="cellData">---</div>
                                    </div>
                                @endfor
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-6">
                <div class="data-title">
                    <span>Arama İstatistikleri
                        <i class="fas fa-info-circle info-icon" style="margin-left:5px;font-size: 16px;" data-bs-toggle="tooltip" data-bs-placement="top" title="Danışmanlarınızın günlük, haftalık ve aylık arama sayılarını takip edebilirsiniz."></i>
                    </span>
                </div>
                <div class="mt-3" style="background-color:white;padding: 2px;border-radius: 13px;">
                    <ul class="mt-2" style="display: flex;justify-content: space-around;">
                        <li class="nav-item active">Günlük</li>
                        <li class="nav-item">Haftalık</li>
                        <li class="nav-item">Aylık</li>
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
                            <div class="table-body">
                                @foreach ($getDailyCallCounts as $call)
                                    <div class="table-row">
                                        <div class="cell">{{ $call->consultant_name }}</div>
                                        <div class="cellData">{{ $call->call_count }}</div>
                                        <div class="cellData">Çok İyi</div>
                                    </div>
                                @endforeach
                                
                                <!-- Eğer veri sayısı 4'ten azsa, eksik satırları doldur -->
                                @for ($i = count($getDailyCallCounts); $i < 4; $i++)
                                    <div class="table-row">
                                        <div class="cell">---</div>
                                        <div class="cellData">---</div>
                                        <div class="cellData">---</div>
                                    </div>
                                @endfor
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>

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

        <div class="row mt-5">
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
        </div>

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

        <div class="row mt-5">
            <div class="col-6">
                <div class="data-title">
                    <span>Genel Müşteri Durum İstatistiği
                        <i class="fas fa-info-circle info-icon" style="margin-left:5px;font-size: 16px;" data-bs-toggle="tooltip" data-bs-placement="top" title="Satış temsilcilerin olumlu müşteri sayıları."></i>
                    </span>
                </div>
                <div class="mt-3" style="background-color:white;padding: 2px;border-radius: 13px;">
                    <ul class="mt-2" style="display: flex;justify-content: space-around;">
                        <li class="nav-item active">Günlük</li>
                        <li class="nav-item">Haftalık</li>
                        <li class="nav-item">Aylık</li>
                    </ul>
                </div>
                <div class="card mt-3" style="border-radius:13px">
                    <div class="card-body">
                        <div class="custom-table">
                            <div class="table-body">
                                @foreach (['Olumlu', 'Ulaşılamadı', 'Olumsuz', 'Sıcak Müşteri', 'Hatalı Numara', 'Nötr','Opsiyon'] as $status)
                                    <div class="table-row">
                                        <div class="cell">{{ $status }}</div>
                                        <div class="cellData">{{ $getDailyCustomerStatuses[$status]->total ?? 0 }} </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-6">
                <div class="data-title">
                    <span>Genel Müşteri Görüşme Sonucu İstatistiği
                        <i class="fas fa-info-circle info-icon" style="margin-left:5px;font-size: 16px;" data-bs-toggle="tooltip" data-bs-placement="top" title="Satış temsilcilerin olumlu müşteri sayıları."></i>
                    </span>
                </div>
                <div class="mt-3" style="background-color:white;padding: 2px;border-radius: 13px;">
                    <ul class="mt-2" style="display: flex;justify-content: space-around;">
                        <li class="nav-item active">Günlük</li>
                        <li class="nav-item">Haftalık</li>
                        <li class="nav-item">Aylık</li>
                    </ul>
                </div>
                <div class="card mt-3" style="border-radius:13px">
                    <div class="card-body">
                        <div class="custom-table">
                            <div class="table-body">
                                <div class="table-row">
                                    <div class="cell">Takip Edilecek</div>
                                    <div class="cellData">1200</div>
                                </div>
                                <div class="table-row">
                                    <div class="cell">Randevu (Zoom & Yüz Yüze)</div>
                                    <div class="cellData">85</div>
                                </div>
                                <div class="table-row">
                                    <div class="cell">Yeni Projelerde Aranacak </div>
                                    <div class="cellData">95</div>
                                </div>
                                <div class="table-row">
                                    <div class="cell">Olumsuz</div>
                                    <div class="cellData">110</div>
                                </div>
                                <div class="table-row">
                                    <div class="cell">Bir Daha Aranmayacak</div>
                                    <div class="cellData">110</div>
                                </div>
                                <div class="table-row">
                                    <div class="cell">Satış</div>
                                    <div class="cellData">110</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

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
                            <div class="header-item"><span>Proje</span></div>
                            <div class="header-item"><span>Arsa</span></div>
                            <div class="header-item"><span>İş Yeri</span></div>
                            <div class="header-item"><span>Toplam Satış</span></div>
                        </div>
                        <div class="table-body">
                            <div class="table-row">
                                <div class="cell">Yavuz Türk</div>
                                <div class="cellData">1200</div>
                                <div class="cellData">1200</div>
                                <div class="cellData">1200</div>
                                <div class="cellData">1200</div>
                                <div class="cellData">1200</div>
                            </div>
                            <div class="table-row">
                                <div class="cell">Yavuz Türk</div>
                                <div class="cellData">85</div>
                                <div class="cellData">85</div>
                                <div class="cellData">85</div>
                                <div class="cellData">85</div>
                                <div class="cellData">85</div>
                            </div>
                            <div class="table-row">
                                <div class="cell">Yavuz Türk</div>
                                <div class="cellData">95</div>
                                <div class="cellData">95</div>
                                <div class="cellData">95</div>
                                <div class="cellData">95</div>
                                <div class="cellData">95</div>
                            </div>
                            <div class="table-row">
                                <div class="cell">Yavuz Türk</div>
                                <div class="cellData">110</div>
                                <div class="cellData">110</div>
                                <div class="cellData">110</div>
                                <div class="cellData">110</div>
                                <div class="cellData">110</div>
                            </div>
                            <div class="table-row">
                                <div class="cell">Yavuz Türk</div>
                                <div class="cellData">110</div>
                                <div class="cellData">110</div>
                                <div class="cellData">110</div>
                                <div class="cellData">110</div>
                                <div class="cellData">110</div>
                            </div>
                            <div class="table-row">
                                <div class="cell">Yavuz Türk</div>
                                <div class="cellData">110</div>
                                <div class="cellData">110</div>
                                <div class="cellData">110</div>
                                <div class="cellData">110</div>
                                <div class="cellData">110</div>
                            </div>
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

        <script>
            $(document).ready(function() {
                // Günlük verileri başlangıç olarak göster
                showDailyData();
            
                // Tab Click Event Handler
                $('#daily-tab').on('click', function(e) {
                    e.preventDefault();
                    setActiveTab(this);
                    showDailyData();
                });
            
                $('#weekly-tab').on('click', function(e) {
                    e.preventDefault();
                    setActiveTab(this);
                    showWeeklyData();
                });
            
                $('#monthly-tab').on('click', function(e) {
                    e.preventDefault();
                    setActiveTab(this);
                    showMonthlyData();
                });
                
                // Aktif sekmeyi ayarlayan fonksiyon
                function setActiveTab(tab) {
                    // Tüm tab linklerinden 'active' sınıfını kaldır
                    $('.nav-link').removeClass('active');
                    // Tıklanan tab linkine 'active' sınıfını ekle
                    $(tab).addClass('active');
                }

                // Verileri gösteren fonksiyonlar
                function showDailyData() {
                    var dailyData = @json($getDailyCallCounts);
                    renderTable(dailyData);
                }
            
                function showWeeklyData() {
                    var weeklyData = @json($getWeeklyCallCounts);
                    renderTable(weeklyData);
                }
            
                function showMonthlyData() {
                    var monthlyData = @json($getMonthlyCallCounts);
                    renderTable(monthlyData);
                }
            
                function renderTable(data) {
                    var html = '<table class="table table-bordered"><thead ><tr><th style="background: #ea2a28;color: white;font-size: 10px;">Danışman Adı</th><th style="background: #ea2a28;color: white;font-size: 10px;">Toplam Arama</th></tr></thead><tbody>';
                    $.each(data, function(index, item) {
                        html += '<tr><td>' + item.consultant_name + '</td><td>' + item.total + '</td></tr>';
                    });
                    html += '</tbody></table>';
                    $('#data-table').html(html);
                }
            });
        </script>  

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

        .table-body {
          
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
