@extends('client.layouts.masterPanel')
@section('content')
    <section>
        <div class="">
            <section id="header">
                <div class="container">        
                    <div class="row mt-3">
                        <div class="col-md-12 ">
                            <div class="card shadow">
                                <ul class="nav nav-tabs justify-content-start">
                                    <li class="nav-item col-1" id="housingsTab">
                                        <a class="nav-link actived" id="housingTabA">Emlak</a>
                                    </li>
                                    <li class="nav-item col-1" id="projectsTab">
                                        <a class="nav-link" id="projectTabA">Projeler</a>
                                    </li>
                                </ul>
                            </div>        
                        </div>
                    </div>        
                </div>
            </section>
        
            <section id="content" class="mt-3 mb-5">
                <div class="container">
                    <div class="row mb-3">
                     
                        @if ($user && $user->type == 2)
                            <div class="col-3 pb-3">
                                <div class="card" style="box-shadow: 0px 2px 5px 0px #0000001A; padding: 20px; border: 1px solid #ebebeb; background: white;">
                                    <div class="d-flex flex-column">
                                        <div>Alt Çalışan Sayısı</div>
                                        <div ><strong>{{ $subWorkerCount  }}</strong></div>
                                        <div style="color: #6B6B6B9E;">Son 1 Ayda</div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="col-3 pb-3">
                            <div class="card" style="box-shadow: 0px 2px 5px 0px #0000001A;padding: 20px;border: 1px solid #ebebeb;background: white;">
                                <div class="d-flex flex-column">
                                    <div >Aktif İlanlar</div>
                                    <div id="activeAdvert" class=""><strong>{{ $activeAdvertHousings  }}</strong></div>
                                    <div >Son 1 Ayda</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-3 pb-3">
                            <div class="card" style="box-shadow: 0px 2px 5px 0px #0000001A;padding: 20px;border: 1px solid #ebebeb;background: white;">
                                <div class="d-flex flex-column">
                                    <div >Onay Bekleyen İlanlar</div>
                                    <div id="pendingAdvert"><strong>{{ $pendingAdvertHousings  }}</strong></div>
                                    <div style="color: #6B6B6B9E;">Son 1 Ayda</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-3 pb-3">
                            <div class="card" style="box-shadow: 0px 2px 5px 0px #0000001A;padding: 20px;border: 1px solid #ebebeb;background: white;">
                                <div class="d-flex flex-column">
                                    <div >Toplam İlan Sayısı</div>
                                    <div id="totalAdvert"><strong>{{ $totalAdvertHousings  }}</strong></div>
                                    <div style="color: #6B6B6B9E;">Son 1 Ayda</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-3 ">
                            <div class="card" style="box-shadow: 0px 2px 5px 0px #0000001A;padding: 20px;border: 1px solid #ebebeb;background: white;">
                                <div class="d-flex flex-column">
                                    <div >Askıya Alınan İlanlar</div>
                                    <div id="passiveAdvert"><strong>{{ $passiveAdvertHousings }}</strong></div>
                                    <div style="color: #6B6B6B9E;">Son 1 Ayda</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-3 ">
                            <div class="card" style="box-shadow: 0px 2px 5px 0px #0000001A;padding: 20px;border: 1px solid #ebebeb;background: white;">
                                <div class="d-flex flex-column">
                                    <div >Koleksiyon Sayısı</div>
                                    <div ><strong>{{ $collectionCount  }}</strong></div>
                                    <div style="color: #6B6B6B9E;">Son 1 Ayda</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-3 ">
                            <div class="card" style="box-shadow: 0px 2px 5px 0px #0000001A;padding: 20px;border: 1px solid #ebebeb;background: white;">
                                <div class="d-flex flex-column">
                                    <div >Görüntülenme Sayısı</div>
                                    <div id="viewCount"><strong>{{ $viewCountHousings  }}</strong></div>
                                    <div style="color: #6B6B6B9E;">Son 1 Ayda</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-3 ">
                            <div class="card" style="box-shadow: 0px 2px 5px 0px #0000001A;padding: 20px;border: 1px solid #ebebeb;background: white;">
                                <div class="d-flex flex-column">
                                    <div class="">Pazar Teklifleri</div>
                                    <div class=""><strong>{{ $bidsCount  }}</strong></div>
                                    <div class="" style="color: #6B6B6B9E;">Son 1 Ayda</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <div class="card shadow rounded" style="padding:10px;">
                                <div class="card-header" style="background-color:#FFFFFF;">
                                    <div class="row p-2">
                                        <h5 class="pl-2" style="border-left: 4px solid red;">
                                            {{ Auth::user()->name }} Ayın Yıldızları
                                        </h5>
                                    </div>
                                </div>
                                <div class="table-responsive" style="background-color: white;">
                                    <table id="salesTable" class="table m-0" style="background-color: white;">
                                        <thead>
                                            <tr>
                                                <th scope="col"></th>
                                                <th scope="col">Satışı Yapılan Emlak İlanı Sayısı</th>
                                                <th scope="col">Emlak Kulüp Kazancı</th>
                                                <th scope="col">Koleksiyon Satışları</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Dinamik olarak güncellenen satırlar buraya gelecek -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>                            
                        </div>
                        <div class="col-6">
                            <div class="shadow card rounded" style="height: 100%;padding:10px;">
                                <div class="card-header" style="background-color:#FFFFFF;">
                                    <div class="row p-2">
                                        <h5 class="pl-2" style="border-left: 4px solid red;">İstatistikler</h5>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <canvas id="statisticsChart"></canvas>
                                </div>
                            </div>
        
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4">
                            <div class="d-flex flex-column" style="height: 100%;">
                                <div class="card mb-1" style="height: 100%;padding:10px;">
                                    <div class="card-header" style="background-color:#FFFFFF;">
        
                                        <div class="row p-2">
                                            <h5 class="pl-2" style="font-size:11px;border-left: 4px solid red;">Emlak Sepette Ayın Kurumsal Üye 1.si</h5>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <img src="{{ URL::to('/storage/profile_images/'.$getTopCorporateStore->profile_image) }}" style="width: 60px">
                                        <span>{{ $getTopCorporateStore->name }}</span>

                                    </div>
                                </div>
                                <div class="card mt-1 mb-1" style="height: 100%;padding:10px;">
                                    <div class="card-header" style="background-color:#FFFFFF;">
        
                                        <div class="row p-2">
                                            <h5 class="pl-2" style="font-size:11px;border-left: 4px solid red;">Emlak Sepette Ayın En Çok Satış Yapan Danışmanı</h5>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <img src="{{ URL::to('/storage/profile_images/'.$getTopConsultantForCorporate->profile_image) }}" style="width: 60px">
                                        <span>{{ $getTopConsultantForCorporate->name }}</span>
                                    </div>
                                </div>
                                <div class="card mt-1" style="height: 100%;padding:10px;">
                                    <div class="card-header" style="background-color:#FFFFFF;">
        
                                        <div class="row p-2">
                                            <h5 class="pl-2" style="font-size:11px;border-left: 4px solid red;">Emlak Kulüp Ayın En Çok Satış Yapan Üyesi</h5>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <img src="{{ URL::to('/storage/profile_images/'.$getTopCorporateUser->profile_image) }}" style="width: 60px">
                                        <span>{{ $getTopCorporateUser->name }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-4 ">               
                            <div class="card shadow rounded" style="height: 100%; padding: 10px;">
                                <div class="d-flex flex-column" style="height: 100%;">
                                    <h5 id="mostViewedCountH5" class="pl-2" style="font-size:11px;border-left: 4px solid red;">En Çok Ziyaret Edilen Emlak İlanları</h5>
                                    <div id="mostViewedContent"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="d-flex flex-column" style="height: 100%;">
                                <div class="card shadow mb-1" style="height: 100%;padding:10px;">
                                    <div class="card-header" style="background-color:#FFFFFF;">
                                        <div class="row p-2">
                                            <h5 class="pl-2" style="border-left: 4px solid red;">Satılık / Kiralık İstatistikleri</h5>
                                        </div>
                                    </div>
        
                                    <div class="row">
                                        <div class="col-12">
                                            <canvas id="revenueChart"></canvas>
                                        </div>
                                        {{-- <div class="col-12">
                                            <div class="d-flex flex-column">
                                                <div class="p-2">Satış / Kira İstatistikleri</div>
                                                <div class="p-2">%123,4353</div>
                                            </div>
                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-8">
                            <div class="card shadow rounded" style="height: 100%;padding:10px;">
                                <div class="card-header p-3" style="background-color:#FFFFFF;">
                                    <div class="row p-2">
                                        <h5 class="pl-2" style="border-left: 4px solid red;">Satışı Yapılanlar</h5>
                                    </div>
                                </div>
                                <table class="table m-0" style="height: 100%;" id="satisiYapilanlar">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Emlak Başlığı</th>
                                            <th scope="col">Görüntülenme Sayısı</th>
                                            <th scope="col">Ödenen Kapora Bedeli</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                                
                                <div class="d-flex justify-content-end pt-3">
                                    <nav aria-label="Page navigation example ">
                                        <ul class="pagination">
                                            <li class="page-item">
                                                <a class="page-link" href="#" aria-label="Previous">
                                                    <span aria-hidden="true">&laquo;</span>
                                                </a>
                                            </li>
                                            <li class="page-item"><a class="page-link" href="#">1</a></li>
                                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                                            <li class="page-item">
                                                <a class="page-link" href="#" aria-label="Next">
                                                    <span aria-hidden="true">&raquo;</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                        <div class="col-4 d-flex flex-column">
                            <div class="card shadow mb-2" style="height: 50%;">
                                <div class="d-flex flex-column" style="width: 100%;">
                                    <div class="d-flex justify-content-end m-0 pr-5">
                                        <h6 class=" "></h6>
                                    </div>
                                    <div class="" style="width: 100%;">
                                        <div class="row">
                                            <div class="col-2">
                                                <div class="d-flex flex-column">
                                                    <div class="p-2"></div>
                                                    <div class="p-4">
                                                        <img src="https://via.placeholder.com/40">
                                                    </div>
                                                    <div class="p-2"></div>
                                                </div>
                                            </div>
                                            <div class="col-8">
                                                <div class="d-flex flex-column">
                                                    <div class="p-2"></div>
                                                    <div class="pt-3 pl-2">Toplam Kazancım</div>
                                                    <div class="pl-2 pt-1">2.301.102</div>
                                                </div>
                                            </div>
                                            <div class="col-2"></div>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <a href="#" class="view-more-link" style="color: #EA2B2E">
                                            Tamamını Gör <i class="fas fa-chevron-right view-more-icon" style="color: #EA2B2E"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="card shadow mb-2" style="height: 50%;">
                                <div class="d-flex flex-column" style="width: 100%;">
                                    <div class="d-flex justify-content-end m-0 pr-5">
                                        <h6 class=" "></h6>
                                    </div>
                                    <div class="" style="width: 100%;">
                                        <div class="row">
                                            <div class="col-2">
                                                <div class="d-flex flex-column">
                                                    <div class="p-2"></div>
                                                    <div class="p-4">
                                                        <img src="https://via.placeholder.com/40">
                                                    </div>
                                                    <div class="p-2"></div>
                                                </div>
                                            </div>
                                            <div class="col-8">
                                                <div class="d-flex flex-column">
                                                    <div class="p-2"></div>
                                                    <div class="pt-3 pl-2">Son 30 Gün Kazancım</div>
                                                    <div class="pl-2 pt-1">458.637</div>
                                                </div>
                                            </div>
                                            <div class="col-2"></div>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <a href="#" class="view-more-link" style="color: #FF9907">
                                            Tamamını Gör <i class="fas fa-chevron-right view-more-icon" style="color: #FF9907"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="card shadow " style="height: 50%;">
                                <div class="d-flex flex-column" style="width: 100%;">
                                    <div class="d-flex justify-content-end m-0 pr-5">
                                        <h6 class=" "></h6>
                                    </div>
                                    <div class="" style="width: 100%;">
                                        <div class="row">
                                            <div class="col-2">
                                                <div class="d-flex flex-column">
                                                    <div class="p-2"></div>
                                                    <div class="p-4">
                                                        <img src="https://via.placeholder.com/40">
                                                    </div>
                                                    <div class="p-2"></div>
                                                </div>
                                            </div>
                                            <div class="col-8">
                                                <div class="d-flex flex-column">
                                                    <div class="p-2"></div>
                                                    <div class="pt-3 pl-2">Emlak Kulüp Kazancım</div>
                                                    <div class="pl-2 pt-1">1.587.632</div>
                                                </div>
                                            </div>
                                            <div class="col-2"></div>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <a href="#" class="view-more-link" style="color: #153D8C">
                                            Tamamını Gör <i class="fas fa-chevron-right view-more-icon"  style="color: #153D8C"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-3" style="padding:10px;">
                        <div class="card-header" style="background-color:#FFFFFF;">
                            <div class="row">
                                <div class="col">
                                    <h5 class="pl-2 mt-2" style="border-left: 4px solid red;">Müşteriler</h5>
                                </div>                              
                                {{-- <div class="col">
                                    <div class="d-flex justify-content-end">
                                        <div class="date-range-display">
                                            <i class="far fa-calendar-alt"></i>
                                            <span>20 Haz - 20 Tem</span>
                                        </div>
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                        <table class="table m-0">
                            <thead>
                                <tr>                               
                                    <th scope="col">Müşteri No</th>
                                    <th scope="col">Müşteri Adı</th>
                                    <th scope="col">Satın Alma Şekli</th>
                                    <th scope="col">İlandaki Fiyat</th>
                                    <th scope="col">Ödeme Durumu</th>
                                    <th scope="col">Satın Alma Tarihi</th>
                                </tr>
                            </thead>
                            <tbody id="customerTableBody"></tbody>
                        </table>
                        <div class="d-flex justify-content-end pt-3 pr-2">
                            {{ $salesHousingsCustomerInfo->links() }} <!-- Pagination links -->
                        </div>
                    </div>
                </div>
            </section>      
        </div>
        </div>

    </section>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-5o8GF3Euf0cMnxLvsZG6g0Iu/R6fybQ4yQvlkZ5KhA2Sy8Y02v65J1ueZMEt1C7F" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    {{-- emlak ve proje değişim kodları --}}
    <script>
        $(document).ready(function() {

            //ayın yıldızları tablosu
            updateTable('housings');
            updateMostViewedContent('housings');
            updateSalesAdvertTable('housing');
            updateCustomerTable('housing');

            $('#projectsTab').click(function() {           
                $('#housingTabA').removeClass('actived');
                $('#projectTabA').addClass('actived');
                
                $('#activeAdvert') .html('<strong>{{ $activeAdvertProjects }}</strong>');
                $('#pendingAdvert').html('<strong>{{ $pendingAdvertProjects }}</strong>');
                $('#totalAdvert')  .html('<strong>{{ $totalAdvertProjects }}</strong>');
                $('#passiveAdvert').html('<strong>{{ $passiveAdvertProjects }}</strong>');
                $('#viewCount')    .html('<strong>{{ $viewCountProjects }}</strong>');

                updateTable('projects');
                updateMostViewedContent('projects');
                updateSalesAdvertTable('projects');
                updateCustomerTable('projects');
            });

            // Emlak tıklandığında çalışacak fonksiyon
            $('#housingsTab').click(function() {
                $('#projectTabA').removeClass('actived');
                $('#housingTabA').addClass('actived');

                $('#activeAdvert') .html('<strong>{{ $activeAdvertHousings }}</strong>');
                $('#pendingAdvert').html('<strong>{{ $pendingAdvertHousings }}</strong>');
                $('#totalAdvert')  .html('<strong>{{ $totalAdvertHousings }}</strong>');
                $('#passiveAdvert').html('<strong>{{ $passiveAdvertHousings }}</strong>');
                $('#viewCount')    .html('<strong>{{ $viewCountHousings }}</strong>');

                updateTable('housings');
                updateMostViewedContent('housings');
                updateSalesAdvertTable('housing');
                updateCustomerTable('housing');
            });
        });

        //ayın yıldızları tablosu
        function updateTable(type) {
            var data;
            if (type === 'projects') {
                data = @json($salesDetailsProjects);
            } else {
                data = @json($salesDetailsHousings);
            }
  
            var tableBody = $('#salesTable tbody');
            tableBody.empty();

            $.each(data, function(index, detail) {
                var row = `
                    <tr>
                        <td>
                            <img src="https://via.placeholder.com/60" alt="image">
                            <span class="badge text-small text-black d-block">${detail.user.name}</span>
                        </td>
                        <td>${detail.totalSales}</td>
                        <td>${detail.totalEarnings}</td>
                        <td>${detail.totalCollectionSales}</td>
                    </tr>
                `;
                tableBody.append(row);
            });
        }

        // En çok ziyaret edilen tablosunu güncelleme fonksiyonu
        function updateMostViewedContent(type) {
            var data;
            var contentContainer = $('#mostViewedContent');
            contentContainer.empty();
            if (type === 'projects') {
                data = @json($mostViewedProjects);
                $('#mostViewedCountH5').text('En Çok Ziyaret Edilen Proje İlanları');
            } else {
                data = @json($mostViewedHousings);
                $('#mostViewedCountH5').text('En Çok Ziyaret Edilen Emlak İlanları');
            }

        

            $.each(data, function(index, item) {
                var imageUrl;
                if (type === 'projects') {
                    imageUrl =  '{{ URL::to("/") }}/' + (item.image || 'default.jpg');;
                    var title = item.project_title;
                } else {
                    // Housing türündeki veriler için image URL'sini belirleme
                    var housingTypeData = JSON.parse(item.housing_type_data);
                    imageUrl = '{{ URL::to("/housing_images/") }}/' + (housingTypeData.image || 'default.jpg');
                    var title = item.title;
                }
                
                var row = `
                    <div class="row p-2">
                        <div class="col-3">
                            <img src="${imageUrl}" alt="image" class="img-fluid" style="width:60px;height:60px">
                        </div>
                        <div class="col-6">
                            <div class="d-flex flex-column">
                                <div class="fs-5">${title}</div>
                                <div class="fs-6">${item.step1_slug}</div>
                            </div>
                        </div>
                        <div class="col-3">
                            <a href="${item.link}" class="btn btn-danger">İncele</a>
                        </div>
                    </div>
                `;
                contentContainer.append(row);
            });
        }

        function updateSalesAdvertTable(type) {
            var data;
            var url;
            if (type === 'projects') {
                data = @json($salesAdvertProject);
                url = '{{ URL::to('/') }}';
            } else {
                data = @json($salesAdvertHousing);
                url = '{{ URL::to('/housing_images/') }}';
            }

            var tbody = $('#satisiYapilanlar tbody');
            tbody.empty();

            $.each(data, function(index, item) {
                var imageUrl = type === 'projects' ? item.image : (item.housing_type_data ? JSON.parse(item.housing_type_data).image : 'default.jpg');
                var imageSrc = type === 'projects' ? url + '/' + imageUrl : url + '/' + imageUrl;

                var row = `
                    <tr>
                        <td>
                            <img src="${imageSrc}" alt="image" class="img-fluid">
                        </td>
                        <td><span class="badge text-black">${type === 'projects' ? item.project_title : item.title}</span></td>
                        <td>${item.view_count}</td>
                        <td>${item.amount}</td>
                    </tr>
                `;
                tbody.append(row);
            });
        }

        function updateCustomerTable(type) {
            var salesHousingsCustomerInfo = @json($salesHousingsCustomerInfo);
            var salesProjectsCustomerInfo = @json($salesProjectsCustomerInfo);
            var data;
            var url;
            var paginationLinks;
            
            if (type === 'projects') {
                data = salesProjectsCustomerInfo.data;
                //url = '{{ URL::to('/') }}'; // Projeler için uygun URL
                paginationLinks = salesProjectsCustomerInfo.links;
            } else {
                data = salesHousingsCustomerInfo.data;
                //url = '{{ URL::to('/housing_images/') }}'; // Emlaklar için uygun URL
                paginationLinks = salesHousingsCustomerInfo.links;
            }

            var tbody = $('#customerTableBody');
            tbody.empty();
            var rows = '';

            $.each(data, function(index, item) {
                try {
                    var cartData = JSON.parse(item.cart || '{}');
                    var imageSrc ='{{ URL::to('/storage/profile_images/') }}' + (item.customer.profile_image ?? 'default.jpg');

                    var purchaseType = item.payment_result ? 'Kredi Kartı' : 'EFT / Havale';
                    var status = '';
                    if (item.status == 1) {
                        status = 'Ödendi';
                    } else if (item.status == 2) {
                        status = 'Reddedildi';
                    } else {
                        status = 'Ödeme Onayı Bekliyor';
                    }

                    rows += `
                        <tr style="height: 80px;">        
                            <td>#${item.id}</td>
                            <td>
                                <span style="float:left;margin-left:10px"><img src="${imageSrc}" alt="image" style="width: 50px; height: 50px; object-fit: cover;">
                                    <span class="badge text-black">${item.customer.name || 'Başlık Yok'}</span></span>
                            </td>
                            <td>${purchaseType}</td>
                            <td>${item.amount}</td>
                            <td>${status}</td>
                            <td>${item.status == 1 ? item.updated_at : ''}</td>
                        </tr>
                    `;
                } catch (e) {
                    console.error('JSON ayrıştırma hatası:', e);
                }
            });

            tbody.html(rows);
            $('#paginationLinks').html(paginationLinks);
        }

    </script>
   

    {{-- görüntülenme sayısı grafiği --}}
    <script>
            var mostViewedHousings = @json($mostViewedHousings);
            document.addEventListener('DOMContentLoaded', function() {
            var ctx = document.getElementById('statisticsChart').getContext('2d');

            // Verileri işleyin
            var labels = mostViewedHousings.map(function(item) {
                return item.title; // Emlak isimleri
            });
            var data = mostViewedHousings.map(function(item) {
                return item.view_count; // Görüntülenme sayıları
            });

            // Chart.js ile bar grafiği oluşturun
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Görüntülenme Sayısı',
                        data: data,
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>

    <script>
         var salesAdvertHousing = @json($salesAdvertHousing);
            document.addEventListener('DOMContentLoaded', function() {
            var ctx = document.getElementById('revenueChart').getContext('2d');

            // Verileri işleyin
            var saleCount = salesAdvertHousing.filter(item => item.step2_slug === 'satilik').length;
            var rentalCount = salesAdvertHousing.filter(item => item.step2_slug === 'kiralik').length;

            var data = {
                labels: ['Satılık', 'Kiralık'],
                datasets: [{
                    label: 'Satış / Kira Dağılımı',
                    data: [saleCount, rentalCount],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)'
                    ],
                    borderWidth: 1
                }]
            };

            // Chart.js ile pasta grafiği oluşturun
            new Chart(ctx, {
                type: 'pie',
                data: data,
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    var label = tooltipItem.label || '';
                                    if (label) {
                                        label += ': ' + tooltipItem.raw;
                                    }
                                    return label;
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
    {{-- <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            // Buttonları seç
            const button1 = document.getElementById('button1');
            const button2 = document.getElementById('button2');


            // Buttonlara tıklama olaylarını ekle
            button1.addEventListener('click', function() {
                toggleActive(button1);
            });

            button2.addEventListener('click', function() {
                toggleActive(button2);
            });


            // Düğmeyi aktif veya pasif yapacak fonksiyon
            function toggleActive(button) {
                // Tüm düğmelerden 'active' sınıfını kaldır
                button1.classList.remove('active');
                button2.classList.remove('active');


                // Tıklanan düğmeye 'active' sınıfını ekle
                button.classList.add('active');

                console.log(button.id + " active");
            }
        });
    </script>

    <script>
        function openChart(chartId) {
            // Remove 'active' class from all chart buttons
            $('.chart-button').removeClass('active');

            // Add 'active' class to the clicked button
            $('#' + chartId + '-btn').addClass('active');

            // Hide all tab panes
            $('.tab-pane').removeClass('show active');

            // Show the corresponding tab pane
            $('#' + chartId).addClass('show active');

            // Optional: Render chart based on chartId
            renderChart(chartId);
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var options1 = {
                chart: {
                    type: 'line',
                    height: 350,
                    width: '100%',
                    toolbar: {
                        show: true
                    }
                },
                series: [{
                    name: 'Emlaklar',
                    data: {!! $monthlyCounts['countsListings'] !!},
                    color: '#FF0000' // İlk veri seti için renk
                }, 
                @if ($monthlyCounts['user']->type == 2 && $monthlyCounts['user']->corporate_type = 'Banka' && $monthlyCounts['user']->corporate_type = 'İnşaat Ofisi' )
                {
                    name: 'Projeler',
                    data: {!! $monthlyCounts['countsProjects'] !!},
                    color: '#007BFF' // İkinci veri seti için renk
                }
                @endif
            ],
                xaxis: {
                    categories: {!! $monthlyCounts['monthsListings'] !!},


                },
                yaxis: {
                    title: {
                        text: ''
                    }
                },
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            width: '100%'
                        }
                    }
                }]
            };

            var chart1 = new ApexCharts(document.querySelector("#chart1Content"), options1);
            chart1.render();
        });



        document.addEventListener('DOMContentLoaded', function() {
            var options2 = {
                chart: {
                    type: 'line',
                    height: 350,
                    width: '100%',
                    toolbar: {
                        show: true
                    }
                },
                series: [

                    {
                        name: 'Emlak Koleksiyonu',
                        data: {!! $monthlyCollectionCounts['countsListings'] !!}, // Emlak koleksiyon verileri
                        color: '#FF0000'
                    },
                    @if ($monthlyCollectionCounts['user']->type == 2 && $monthlyCounts['user']->corporate_type = 'Banka' && $monthlyCounts['user']->corporate_type = 'İnşaat Ofisi')
                        {
                            name: 'Proje Koleksiyonu',
                            data: {!! $monthlyCollectionCounts['countsProjects'] !!}, // Proje koleksiyon verileri  
                            color: '#007BFF'
                        }
                    @endif
                ],
                xaxis: {
                    categories: {!! $monthlyCollectionCounts['months'] !!} // Ayların listesi
                },
                yaxis: {
                    title: {
                        text: ''
                    }
                },
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            width: '100%'
                        }
                    }
                }]
            };

            var chart2 = new ApexCharts(document.querySelector("#chart2Content"), options2);
            chart2.render();
        });
    </script> --}}
@endsection

@section('styles')
    <style>
         /* #satisiYapilanlar tr {
            height: 80px; 
        } */
       a.actived {
            color: #EA2B2E !important; /* Yazı rengini kırmızı yap */
            text-decoration: none; /* Varsayılan alt çizgiyi kaldır */
            position: relative; /* Konumlandırma yapabilmek için */
        }

        a.actived::after {
            content: ''; /* İçerik kısmı boş */
            display: block; /* Bloğa dönüştür */
            height: 2px; 
            background: red; 
            position: absolute; /* Konumlandırma */
            bottom: 12px; /* Çizginin metnin altında olması için */
            left: 0; /* Soldan hizalama */
            width: 100%; /* Çizginin genişliği metinle aynı */
        }

       #logo {
        margin-right: 0px;
        }

        #logo {
        display: inline-block;
        margin-top: 1px;
        }

        .resized-image {
        width: 200px;
        height: auto;
        }

        .rectangular-search {
        border-radius: 0;
        }

        .btn {
        border-radius: 0;
        }

        .fa-circle {
        color: red;
        font-size: 5px;
        padding: 2px;
        }

        .link {
        text-decoration: none;
        color: white;
        }

        .link1 {
        text-decoration: none;
        color: black;
        }

        .list-group-item {
        border: none;
        background-color: black;
        font-size: small;
        }

        .home-top-banner {
        background-color: #f8f9fa;
        padding: 10px;
        border-radius: 5px;
        }

        .logo {
        width: 100%;
        padding: 0px;
        margin: 0px !important;
        margin-left: 50px !important;
        }

        li a {
        color: black;
        }

        li a:hover {
        color: red;
        }

      .nav-item{
        cursor: pointer;
      }

        .nav-tabs .nav-link {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 50px;
            color: #000;
            margin-right: 5px;
            font-size: 12px;
        }

        .nav-tabs .nav-link:hover{
            border:none;
        }

        .flex-container {
            display: flex;
            flex-wrap: nowrap;
            gap: 10px; /* Optional: Adds space between items */
        }

        .flex-item {
            background-color: #f1f1f1;
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
            flex: 1;
        }

        body {
           background-color: #f8f9fa;
        }

  
        .card-header {
            background-color: #FFFFFF;
            border-bottom: 1px solid #FFFFFF;
        }

        .card-header h5 {
            margin: 0;
            font-weight: 600;
            padding-left: 10px;
        }

        .card-body h3 {
            font-size: 24px;
            margin: 0;
        }

        .table th,
        .table td {
            text-align: center;
            vertical-align: middle;
        }

        .date-range-display {
            display: inline-flex;
            align-items: center;
            padding: 0.5em 1em;
            border: 1px solid #ccc;
            border-radius: 0.25em;
        }
        .date-range-display i {
            margin-right: 0.5em;
        }   

        .view-more-link {
            font-weight: bold;
            margin-right: 15px;
            margin-top: 25px;
        }
        .view-more-link:hover {
            color: #FF4500; /* Koyu turuncu renk */
            text-decoration: underline;
        }
        .view-more-icon {
            color: #FF4500; /* Koyu turuncu renk */
        }

        .nav-link a{
            color: #000;
            font-weight: bold;
        }

        .nav-link a:hover{
            color: #FF4500; /* Koyu turuncu renk */
        }

        /* .nav-link a.active{
            color: #FF4500; 
        } */
    </style>
@endsection
