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
                    <span>Randevu İstatistikleri</span>
                </div>
                <div style="background-color:white;padding: 10px;border-radius: 13px;">
                    <ul style="display: flex">
                        <li class="nav-item active">Günlük</li>
                        <li class="nav-item">Haftalık</li>
                        <li class="nav-item">Aylık</li>
                    </ul>
                </div>
            </div>
            <div class="col-6">
                <div class="data-title">
                    <span>Arama İstatistikleri</span>
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
            .data-title{
                background-color: #ea2a28;
                color: #ffffff;
                padding: 7px;
                font-size: 18px;
                border-radius: 13px;
                text-align: center;
                align-items: center;
                justify-content: center;
                font-weight: 700;
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
