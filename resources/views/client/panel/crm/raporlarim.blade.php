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
        {{-- <div class="text-header-title">
            <p class="sales-consultants-heading">İstatistik Verileri</p>
        </div> --}}

        <div class="row">
            <div class="text-header-title">
                <p class="sales-consultants-heading"> İletişim Faaliyetleri ve Performans Göstergeleri</p>
            </div>
            <div class="col-6 text-header">
                <!-- Sekme Başlıkları -->
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" href="#" id="daily-tab">Günlük</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" id="weekly-tab">Haftalık</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" id="monthly-tab">Aylık</a>
                    </li>
                </ul>
                <!-- Tablo Alanı -->
                <div class="tab-content mt-3">
                    <div id="data-table" class="table-responsive">
                        <!-- Tablo Burada Gösterilecek -->
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
    @section('scripts')
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
    @endsection


    @section('styles')
        <style>
            .nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active {
                border-bottom: none;
                background-color: #ea2a28;
                color: white;
                border-radius: 5px;
            }

            .nav-item{
                color: #ea2a28 !important;
                border: #ea2a28 !important;
                background-color: white !important;
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

            input.success:checked + .slider {
                background-color: #8bc34a;
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
        </style>
    @endsection
