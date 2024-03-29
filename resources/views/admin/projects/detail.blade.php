@extends('admin.layouts.master')

@section('content')
    @php
        function getData($itemOrder, $key, $housingData)
        {
            foreach ($housingData as $data) {
                if ($data->room_order == $itemOrder && $data->name == $key) {
                    return $data->value;
                }
            }
        }
    @endphp
    <div class="content">
        <div class="row g-3 flex-between-end mb-5">
            <div class="col-auto">
                <div class="card-body position-relative">
                    <div class="badge badge-phoenix fs-10 badge-phoenix-warning mb-4"><span class="fw-bold">İlan No:
                            {{ $project->id + 1000000 }}</span><svg class="svg-inline--fa fa-award ms-1" aria-hidden="true"
                            focusable="false" data-prefix="fas" data-icon="award" role="img"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" data-fa-i2svg="">
                            <path fill="currentColor"
                                d="M288 358.3c13.98-8.088 17.53-30.04 28.88-41.39c11.35-11.35 33.3-14.88 41.39-28.87c7.98-13.79 .1658-34.54 4.373-50.29C366.7 222.5 383.1 208.5 383.1 192c0-16.5-17.27-30.52-21.34-45.73c-4.207-15.75 3.612-36.5-4.365-50.29c-8.086-13.98-30.03-17.52-41.38-28.87c-11.35-11.35-14.89-33.3-28.87-41.39c-13.79-7.979-34.54-.1637-50.29-4.375C222.5 17.27 208.5 0 192 0C175.5 0 161.5 17.27 146.3 21.34C130.5 25.54 109.8 17.73 95.98 25.7C82 33.79 78.46 55.74 67.11 67.08C55.77 78.43 33.81 81.97 25.72 95.95C17.74 109.7 25.56 130.5 21.35 146.2C17.27 161.5 .0008 175.5 .0008 192c0 16.5 17.27 30.52 21.34 45.73c4.207 15.75-3.615 36.5 4.361 50.29C33.8 302 55.74 305.5 67.08 316.9c11.35 11.35 14.89 33.3 28.88 41.4c13.79 7.979 34.53 .1582 50.28 4.369C161.5 366.7 175.5 384 192 384c16.5 0 30.52-17.27 45.74-21.34C253.5 358.5 274.2 366.3 288 358.3zM112 192c0-44.27 35.81-80 80-80s80 35.73 80 80c0 44.17-35.81 80-80 80S112 236.2 112 192zM1.719 433.2c-3.25 8.188-1.781 17.48 3.875 24.25c5.656 6.75 14.53 9.898 23.12 8.148l45.19-9.035l21.43 42.27C99.46 507 107.6 512 116.7 512c.3438 0 .6641-.0117 1.008-.0273c9.5-.375 17.65-6.082 21.24-14.88l33.58-82.08c-53.71-4.639-102-28.12-138.2-63.95L1.719 433.2zM349.6 351.1c-36.15 35.83-84.45 59.31-138.2 63.95l33.58 82.08c3.594 8.797 11.74 14.5 21.24 14.88C266.6 511.1 266.1 512 267.3 512c9.094 0 17.23-4.973 21.35-13.14l21.43-42.28l45.19 9.035c8.594 1.75 17.47-1.398 23.12-8.148c5.656-6.766 7.125-16.06 3.875-24.25L349.6 351.1z">
                            </path>
                        </svg><!-- <span class="fa-solid fa-award ms-1"></span> Font Awesome fontawesome.com --></div>
                    <h3 class="mb-5">{{ $project->project_title }}</h3>
                </div>

            </div>
            <div class="col-auto">
                @if ($project->status == 1)
                    <a href="{{ route('admin.project.set.status', $project->id) }}" project_id="{{ $project->id }}"
                        class="btn btn-danger set_status">Pasife Al</a>
                    <a href="{{ route('admin.project.set.status', $project->id) }}" class="btn btn-danger reject">Reddet</a>
                @elseif($project->status == 2)
                    <a href="{{ route('admin.project.set.status', $project->id) }}"
                        class="btn btn-success set_status">Onayla</a>
                    <a href="{{ route('admin.project.set.status', $project->id) }}" class="btn btn-danger reject">Reddet</a>
                @elseif($project->status == 3)
                    <span class="btn btn-info show-reason">Sebebini Gör</span>
                    <a href="#" class="btn btn-success confirm_rejected_after">Önceden Reddedilmiş Bir Proje Onaya
                        Al</a>
                    <a href="#" class="btn btn-danger reject">Tekrar Reddet</a>
                @else
                    <a href="{{ route('admin.project.set.status', $project->id) }}"
                        class="btn btn-success set_status">Aktife
                        Al</a>
                @endif
                <a class="btn btn-primary mb-2 mb-sm-0 download_document"
                    href="{{ URL::to('/') }}/housing_documents/{{ $project->document }}" download>Proje Belgesini İndir</a>
            </div>
        </div>
        <div class="row g-5">
            <div class="col-12 col-xl-8">
                <div class="mb-6">
                    <div class="card p-3 scrollbar to-do-list-body" style="height: 500px; overflow-y:scroll">
                        {!! $project->description !!}
                    </div>
                </div>
                <h4 class="mb-3">Projenin Kapak Fotoğrafı</h4>
                <div>
                    <img style="width:150px;" class="mb-5"
                        src="{{ URL::to('/') . '/' . str_replace('public/', 'storage/', $project->image) }}"
                        alt="">
                </div>
                <h4 class="mb-3">Proje Görselleri</h4>
                <div class="images owl-carousel mb-4">
                    @foreach ($project->images as $key => $image)
                        <img src="{{ URL::to('/') . '/' . str_replace('public/', 'storage/', $image->image) }}"
                            class="img-fluid" alt="slider-listing">
                    @endforeach
                </div>

                <div class="admin-house-count">
                    <h4 class="mb-3">Emlak Sayısı</h4>
                    <p style="font-weight: bold;">{{ $project->room_count }}</p>
                </div>


            </div>
            <div class="col-12 col-xl-4">
                <div class="row g-2">
                    <div class="col-12 col-xl-12">
                        <div class="card mb-3">
                            <div class="card-body">
                                <table class="table homes-content" style="margin-bottom: 0 !important">
                                    <tbody class="tBodyTable">
                                        <tr>
                                            <td>
                                                <strong class="autoWidthTr">Mağaza:</strong>
                                                <span class="det" style="color: black;">{!! $project->user->name !!}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <strong class="autoWidthTr">Proje Durumu:</strong>
                                                <span class="det" style="color: black;">{{ $status->name }}</span>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td colspan="2">
                                                <strong class="autoWidthTr"><span>
                                                    {!! 'İl-İlçe' !!}
                                                    @if ($project->neighbourhood)
                                                        {!! '-Mahalle: ' !!}
                                                    @else
                                                        {!! ': ' !!}
                                                    @endif
                                                    </span></strong>
                                                <span class="det" style="color: black;">
                                                    {!! optional($project->city)->title . ' / ' . optional($project->county)->ilce_title !!}
                                                    @if ($project->neighbourhood)
                                                        {!! ' / ' . optional($project->neighbourhood)->mahalle_title !!}
                                                    @endif
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <strong class="autoWidthTr">Yapımcı Firma:</strong>
                                                <span class="det"
                                                    style="color: black;">{{ $project->create_company ? $project->create_company : 'Belirtilmedi' }}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <strong class="autoWidthTr">Başlangıç Tarihi:</strong>
                                                <span class="det" style="color: black;">
                                                    {{ $project->start_date ? \Carbon\Carbon::parse($project->start_date)->format('d.m.Y') : 'Belirtilmedi' }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <strong class="autoWidthTr">Bitiş Tarihi:</strong>
                                                <span class="det" style="color: black;">
                                                    {{ $project->project_end_date ? \Carbon\Carbon::parse($project->project_end_date)->format('d.m.Y') : 'Belirtilmedi' }}
                                                </span>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <strong class="autoWidthTr">Toplam Proje Alanı m<sup>2</sup>:</strong>
                                                <span class="det"
                                                    style="color: black;">{{ $project->total_project_area ? $project->total_project_area : 'Belirtilmedi' }}</span>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <strong class="autoWidthTr">İletişim No:</strong>
                                                <span class="det" style="color: black;">{!! $project->user->phone ? $project->user->phone : 'Belirtilmedi' !!}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <strong class="autoWidthTr"><span>E-Posta:</span></strong>
                                                <span class="det" style="color: black;">{!! $project->user->email !!}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <strong class="autoWidthTr"><span>{{ ucfirst($project->step1_slug) }}
                                                        Tipi:</span></strong>
                                                <span class="det"
                                                    style="color: black;">{{ $project->housingtype->title }}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <strong class="autoWidthTr"><span>Toplam
                                                        @if (isset($projectHousingsList[1]['share-sale[]']) && $projectHousingsList[1]['share-sale[]'] != '[]')
                                                            Hisse
                                                        @else
                                                            {{ ucfirst($project->step1_slug) }}
                                                        @endif
                                                        Sayısı:
                                                    </span></strong>
                                                <span class="det"
                                                    style="color: black;">{{ $project->room_count }}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <strong class="autoWidthTr"><span>Satışa Açık
                                                        @if (isset($projectHousingsList[1]['share-sale[]']) && $projectHousingsList[1]['share-sale[]'] != '[]')
                                                            Hisse
                                                        @else
                                                            {{ ucfirst($project->step1_slug) }}
                                                        @endif
                                                        Sayısı:
                                                    </span></strong>
                                                <span class="det"
                                                    style="color: black;">{{ $project->room_count - $project->cartOrders - $salesCloseProjectHousingCount }}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <strong class="autoWidthTr"><span>Satışa Kapalı
                                                        @if (isset($projectHousingsList[1]['share-sale[]']) && $projectHousingsList[1]['share-sale[]'] != '[]')
                                                            Hisse
                                                        @else
                                                            {{ ucfirst($project->step1_slug) }}
                                                        @endif
                                                        Sayısı:
                                                    </span></strong>
                                                <span class="det"
                                                    style="color: black;">{{ $salesCloseProjectHousingCount }}</span>
                                            </td>
                                        </tr>
                                    </tbody>

                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="rendered-area card p-3">
                <h4 class="mb-3">Daire Bilgileri</h4>

                <div class="row g-0 border-top border-bottom border-300">
                    <div class="col-sm-4">
                        <div id="tablist"
                            class="nav flex-sm-column border-bottom border-bottom-sm-0 border-end-sm border-300 fs--1 vertical-tab justify-content-between"
                            role="tablist" aria-orientation="vertical">
                            @for ($i = 0; $i < $project->room_count; $i++)
                                <a class="nav-link border-end border-end-sm-0 border-bottom-sm border-300 text-center text-sm-start cursor-pointer outline-none d-sm-flex align-items-sm-center @if ($i == 0) active @endif"
                                    id="Tab1" data-bs-toggle="tab" data-bs-target="#TabContent{{ $i }}"
                                    role="tab" aria-controls="TabContent{{ $i }}" aria-selected="true">
                                    <span class="me-sm-2 fs-4 nav-icons" data-feather="tag"></span>
                                    <span class="d-none d-sm-inline">{{ $i + 1 }} Nolu
                                        {{ $project->step1_slug }} Bilgileri</span>
                                </a>
                            @endfor
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="tab-content py-3 ps-sm-4 h-100">
                            @for ($i = 0; $i < $project->room_count; $i++)
                                <div class="tab-pane fade show row @if ($i == 0) active @endif"
                                    id="TabContent{{ $i }}" role="tabpanel">

                                    @if ($project->have_blocks)
                                        @php $count = 0; @endphp
                                        <div class="admin-blocks">
                                            <ul>
                                                @foreach ($project->blocks as $key => $block)
                                                    @php
                                                        $tempCount = $count;
                                                        $count += $block->housing_count;
                                                    @endphp
                                                    @if ($i < $count && $i >= $tempCount)
                                                        <li class="active">{{ $block->block_name }}</li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    @foreach ($housingTypeData as $housingType)
                                        @if ($housingType->type != 'file' && isset($housingType->name))
                                            @if ($housingType->type == 'checkbox-group')
                                                @if (isset($projectHousingsList[$i + 1][$housingType->name]) &&
                                                        is_array(json_decode($projectHousingsList[$i + 1][$housingType->name])))
                                                    <div class="view-form-json col-md-12 mt-2">
                                                        <label for=""
                                                            style="font-weight: bold;">{!! $housingType->label !!}</label>
                                                        @foreach (json_decode($projectHousingsList[$i + 1][$housingType->name]) as $checkboxItem)
                                                            <p class="mb-1">
                                                                {{ $checkboxItem == 'pesin' ? 'Peşin' : $checkboxItem }}
                                                            </p>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            @else
                                                @if (isset($projectHousingsList[$i + 1][$housingType->name]))
                                                    <div class="view-form-json col-md-3 mt-2">
                                                        <label for=""
                                                            style="font-weight: bold;">{!! $housingType->label !!}</label>
                                                        <p>{{ $projectHousingsList[$i + 1][$housingType->name] ? $projectHousingsList[$i + 1][$housingType->name] : '' }}
                                                        </p>
                                                    </div>
                                                @endif
                                            @endif
                                        @elseif($housingType->type == 'file')
                                            @if ($housingType->multiple)
                                            @else
                                                <div class="view-form-json mt-4 col-md-12">
                                                    <img style="width:150px;"
                                                        src="{{ URL::to('/') . '/project_housing_images/' . $projectHousingsList[$i + 1][$housingType->name] }}"
                                                        alt="">
                                                </div>
                                            @endif
                                        @endif
                                    @endforeach
                                </div>
                            @endfor
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="paymentModalLabel">Emlak Sepette Ödeme Onay Adımı</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="contentx">
                            <div class="invoice-body">
                                <table class="table table-bordered d-none d-md-table">
                                    <!-- Tabloyu sadece tablet ve daha büyük ekranlarda göster -->
                                    <thead>
                                        <tr>
                                            <th>Doping Adı</th>
                                            <th>Kullanıcı</th>
                                            <th>Ödeme Keyi</th>
                                            <th>Ödenen Banka</th>
                                            <th>Ödenen Tutar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($project->dopingOrder as $doping)
                                            <tr>
                                                <td>
                                                    @if ($doping->standOut->housing_type_id == 0)
                                                        Öne Çıkarılanlar
                                                    @else
                                                        Üst Sıradayım
                                                    @endif
                                                </td>
                                                <td>{{ $doping->user->name }}</td>
                                                <td>{{ $doping->key }}</td>
                                                <td>{{ $doping->bank->receipent_full_name }}</td>
                                                <td>{{ $doping->price }} ₺</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <!-- Mobilde sadece alt alta liste göster -->
                                <div class="d-md-none">
                                    <ul class="list-group">
                                        <li class="list-group-item">
                                            <strong>Ürün Adı:</strong> Doping Ücreti
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Miktar:</strong> 1
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Fiyat:</strong> 2500 ₺
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Toplam:</strong> 2500 ₺
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="{{ route('admin.project.set.status.get', $project->id) }}"
                            class="btn btn-primary btn-lg btn-block mb-3" id="completePaymentButton">
                            Ödemeyi Onayla ve Projeyi Aktife Al
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="finalConfirmationModal" tabindex="-1" role="dialog"
            aria-labelledby="finalConfirmationModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="finalConfirmationModalLabel">Ödeme Onayı</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Ödemeniz başarıyla tamamlamak için lütfen aşağıdaki adımları takip edin:</p>
                        <ol>
                            <li>
                                <strong style="color:red" id="uniqueCodeRetry"></strong> kodunu EFT/Havale açıklama
                                alanına yazdığınızdan emin olun.
                            </li>
                            <li>
                                Son olarak, işlemi bitirmek için aşağıdaki butona tıklayın: <br>
                                <button type="submit" class="btn btn-primary without-doping mt-3">Ödemeyi Tamamla
                                    <svg viewBox="0 0 576 512" style="width: 16px;color: #fff;fill: #fff;"
                                        class="svgIcon">
                                        <path
                                            d="M512 80c8.8 0 16 7.2 16 16v32H48V96c0-8.8 7.2-16 16-16H512zm16 144V416c0 8.8-7.2 16-16 16H64c-8.8 0-16-7.2-16-16V224H528zM64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H512c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64zm56 304c-13.3 0-24 10.7-24 24s10.7 24 24 24h48c13.3 0 24-10.7 24-24s-10.7-24-24-24H120zm128 0c-13.3 0-24 10.7-24 24s10.7 24 24 24H360c13.3 0 24-10.7 24-24s-10.7-24-24-24H248z">
                                        </path>
                                    </svg></button>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"
        integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.js"
        integrity="sha512-zlWWyZq71UMApAjih4WkaRpikgY9Bz1oXIW5G0fED4vk14JjGlQ1UmkGM392jEULP8jbNMiwLWdM8Z87Hu88Fw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $('.owl-carousel').owlCarousel({
            loop: true,
            nav: false,
            dots : true,
            margin: 10,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 3
                },
                1000: {
                    items: 5
                }
            }
        })

        $('.set_status').click(function(e) {
            e.preventDefault();
            @if ($project->confirmDopingOrder)
                $('#paymentModal').addClass('show')
                $('#paymentModal').css('display', 'block')
            @else
                var projectId = $(this).attr('project_id');
                Swal.fire({
                    @if ($project->status != 1)
                        title: 'Aktife almak istediğine emin misin?',
                    @else
                        title: 'Pasife almak istediğine emin misin?',
                    @endif
                    showCancelButton: true,
                    confirmButtonText: 'Evet',
                    denyButtonText: `İptal`,
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "{{ route('admin.project.set.status.get', $project->id) }}"
                    }
                })
            @endif
        })
        var defaultMessagesItems = @json($defaultMessages);

        function defaultMessages() {
            var messages =
                "<div class='mb-2'><label style='text-align:left;width:100%;'>Örnek Mesajlardan Seç</label><select class='form-control change-default-text'><option value=''>Seç</option>";
            for (var i = 0; i < defaultMessagesItems.length; i++) {
                messages += '<option value="' + defaultMessagesItems[i].content + '">' + defaultMessagesItems[i].title +
                    '-' + defaultMessagesItems[i].content + '</option>'
            }
            messages += "</select></div>";

            return messages;
        }
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        $('.reject').click(function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Projeyi reddetmek istediğine emin misin ?',
                showCancelButton: true,
                confirmButtonText: 'Evet',
                denyButtonText: `İptal`,
                html: defaultMessages() +
                    "<div><input class='form-control reason' placeholder='Neden reddediyorsun'></div>",
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    var data = {
                        _token: csrfToken, // CSRF tokeni ekle
                        reason: $('.reason').val(),
                        status: 3
                    };

                    // Ajax isteği oluştur
                    $.ajax({
                        type: 'POST', // Veri gönderme yöntemi (POST)
                        url: '{{ route('admin.project.set.status', $project->id) }}', // Hedef URL
                        data: data, // Gönderilecek veriler
                        success: function(response) {
                            response = JSON.parse(response);
                            if (response.status) {
                                $.toast({
                                    heading: 'Başarılı',
                                    text: 'Başarıyla projeyi reddetiniz',
                                    position: 'top-right',
                                    stack: false
                                });
                                location.reload();

                            }

                        },
                        error: function(xhr, status, error) {
                            // Hata durumunda burada işlemleri gerçekleştirin
                            console.error('İstek sırasında bir hata oluştu.');
                            console.error('Hata detayı:', error);
                        }
                    });
                }
            })

            $('.change-default-text').change(function() {
                $('.reason').val($(this).val());
            })
        })

        $('.confirm_rejected_after').click(function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Projeyi onaylamak istediğine emin misin ?',
                showCancelButton: true,
                confirmButtonText: 'Evet',
                denyButtonText: `İptal`,
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    var data = {
                        _token: csrfToken, // CSRF tokeni ekle
                        reason: "",
                        status: 1
                    };

                    // Ajax isteği oluştur
                    $.ajax({
                        type: 'POST', // Veri gönderme yöntemi (POST)
                        url: '{{ route('admin.project.set.status', $project->id) }}', // Hedef URL
                        data: data, // Gönderilecek veriler
                        success: function(response) {
                            response = JSON.parse(response);
                            if (response.status) {
                                $.toast({
                                    heading: 'Başarılı',
                                    text: 'Başarıyla projeyi aktife aldınız',
                                    position: 'top-right',
                                    stack: false
                                })
                            }
                        },
                        error: function(xhr, status, error) {
                            // Hata durumunda burada işlemleri gerçekleştirin
                            console.error('İstek sırasında bir hata oluştu.');
                            console.error('Hata detayı:', error);
                        }
                    });
                }
            })
        })
        @if ($project->status == 3)
            $('.show-reason').click(function() {
                Swal.fire({
                    title: 'Reddilme sebebi',
                    showCancelButton: false,
                    confirmButtonText: 'Tamam',
                    html: '{{ $project->rejectedLog->reason }}',
                })
            })
        @endif
    </script>
@endsection

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.css"
        integrity="sha512-UTNP5BXLIptsaj5WdKFrkFov94lDx+eBvbKyoe1YAfjeRPC+gT5kyZ10kOHCfNZqEui1sxmqvodNUx3KbuYI/A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ URL::to('/') }}/adminassets/vendors/choices/selectize.css" />
    <link href="https://cdn.jsdelivr.net/npm/fine-uploader@5.16.2/fine-uploader/fine-uploader-gallery.min.css"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.css"
        integrity="sha512-8D+M+7Y6jVsEa7RD6Kv/Z7EImSpNpQllgaEIQAtqHcI0H6F4iZknRj0Nx1DCdB+TwBaS+702BGWYC0Ze2hpExQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .leaflet-container {
            height: 100%;
        }

        .tBodyTable tr td {
            display: flex;
            justify-content: space-between
        }
    </style>
@endsection
