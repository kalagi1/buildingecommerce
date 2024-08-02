@extends('client.layouts.master')

@section('content')
    @php

        function getHouse($project, $key, $roomOrder)
        {
            foreach ($project->roomInfo as $room) {
                if ($room->room_order == $roomOrder && $room->name == $key) {
                    return $room;
                }
            }
        }

    @endphp
    <section class="recently portfolio bg-white homepage-5 ">
        <div class="container">

            <div class="my-properties">

                <a href="{{ url('/') }}" class="btn btn-primary float-left mb-4" style="height: auto !important">
                    <i class="fas fa-angle-left"></i> Geri Dön
                </a>

                <table class="table-responsive">
                    <thead class="mobile-hidden">
                        <tr>
                            <th class="pl-2">iLAN GÖRSELİ</th>
                            <th class="p-0">İlan Başlığı</th>
                            <th class="pl-2">Fiyat</th>
                            <th>Kaldır</th>
                            <th>Sepete Ekle</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($favorites) == 0 && count($projectFavorites) == 0)
                            <tr>
                                <td colspan="5">Favorileriniz Bulunmuyor</td>
                            </tr>
                        @else
                            @foreach ($mergedFavorites as $key => $item)
                                @if (isset($item->project_id))
                                    @php
                                        $data = $item->projectHousing->pluck('value', 'key')->toArray();

                                        $project = $item->project;
                                        $housingId = $item->housing_id;
                                        $projectDiscountAmount =
                                            App\Models\Offer::where('type', 'project')
                                                ->where('project_id', $project->id)
                                                ->where('project_housings', 'LIKE', "%\"{$project->housing_type_id}\"%")
                                                ->where('start_date', '<=', now())
                                                ->where('end_date', '>=', now())
                                                ->first()->discount_amount ?? 0;

                                             

                                        $soldQuery = 'SELECT * FROM cart_orders WHERE JSON_UNQUOTE(JSON_EXTRACT(cart, "$.type")) = "project" AND JSON_UNQUOTE(JSON_EXTRACT(cart, "$.item.housing")) = ? AND JSON_UNQUOTE(JSON_EXTRACT(cart, "$.item.id")) = ? LIMIT 1';
                                        $sold = DB::select($soldQuery, [$housingId, $project->id]);

                                        $statusID = $project->housingStatus->where('housing_type_id', '<>', 1)->first()->housing_type_id ?? 1;
                                        $status = App\Models\HousingStatus::find($statusID);
                                    @endphp

                                    <tr>
                                        <td class="image myelist">
                                            <a
                                                href="{{ route('project.housings.detail', [
                                                     'projectSlug' => $project->slug. "-".$status->slug. "-".$project->step2_slug. "-". $project->housingtype->slug,    
                                                    'projectID'   => $project->id+1000000, 
                                                    'housingOrder'=> $housingId
                                                    ]) }}">
                                                <img alt="my-properties-3"
                                                    src="{{ URL::to('/') . '/project_housing_images/' . getHouse($project, 'image[]', $housingId)->value }}"
                                                    class="img-fluid">
                                            </a>
                                        </td>
                                        <td>
                                            <div class="inner">
                                                <a href="" style="color: black;margin-bottom:9px;">İLAN NO : {{ 1000000 + $project->id + $housingId }}</a>
                                                <div class="text-center">
                                                    <a href="{{ route('project.housings.detail', [
                                                         'projectSlug' => $project->slug. "-".$status->slug. "-".$project->step2_slug. "-".$project->housingtype->slug,    
                                                        'projectID'   => $project->id+1000000, 
                                                        'housingOrder'=> $housingId
                                                        ]) }}" style="color: black;">    
                                                            {{ $project->project_title }} Projesinde {{$housingId }} No'lu {{$project->step1_slug}}<br>
                                                            <span> {!! optional($project->city)->title . ' / ' . optional($project->county)->ilce_title !!}
                                                                @if ($project->neighbourhood)
                                                                    {!! ' / ' . optional($project->neighbourhood)->mahalle_title !!}
                                                                @endif
                                                            </span>
                                                    </a>
                                                </div>

                                            </div>
                                        </td>
                                        <td>
                                            <span style="color:#e54242; font-weight:600">
                                                @if (getHouse($project, 'off_sale[]', $housingId)->value == '[]')
                                                    @if ($sold)
                                                        @if ($sold &&  $sold[0]->status != '1' && $sold[0]->status != '0')
                                                            {{ number_format(getHouse($project, 'price[]', $housingId)->value - $projectDiscountAmount, 0, ',', '.') }}
                                                            ₺
                                                        @endif
                                                    @else
                                                        {{ number_format(getHouse($project, 'price[]', $housingId)->value - $projectDiscountAmount, 0, ',', '.') }}
                                                        ₺
                                                    @endif
                                                @endif
                                            </span>
                                        </td>

                                        <td class="actions">
                                            <a href="#" class="remove-from-project-cart"
                                                data-project-housing-id="{{ getHouse($project, 'price[]', $housingId)->room_order }}"
                                                data-project-id="{{ $project->id }}" style="float: left">
                                                <i class="far fa-trash-alt"></i>
                                            </a>
                                        </td>
                                        <td>
                                            @if (getHouse($project, 'off_sale[]', $housingId)->value != '[]')
                                                <button class="btn mobileBtn second-btn"
                                                    style="background: #EC2F2E !important;width:100%;color:White">
                                                    <span class="IconContainer">
                                                        <img src="{{ asset('sc.png') }}" alt="">
                                                    </span>
                                                    <span class="text">Satışa Kapalı</span>
                                                </button>
                                            @else
                                                @if ($sold && $sold[0]->status != '2')
                                                    <button class="btn second-btn"
                                                        style="@if ($sold[0]->status == '0') background: orange !important;width:100%;color:White @else background: #EC2F2E !important;width:100%;color:White @endif">
                                                        @if ($sold[0]->status == '0')
                                                            <span class="text">Rezerve Edildi</span>
                                                        @else
                                                            <span class="text">Satıldı</span>
                                                        @endif
                                                    </button>
                                                @else
                                                    <button class="CartBtn" data-type='project'
                                                        data-project='{{ $project->id }}'
                                                        data-id='{{ getHouse($project, 'price[]', $housingId)->room_order }}'>
                                                        <span class="IconContainer">
                                                            <img src="{{ asset('sc.png') }}" alt="">
                                                        </span>
                                                        <span class="text">Sepete Ekle</span>
                                                    </button>
                                                @endif
                                            @endif
                                        </td>
                                    </tr>
                                @else
                                    @php
                                        $housing = $item->housing;
                                        $discountAmount =
                                            App\Models\Offer::where('type', 'housing')
                                                ->where('housing_id', $housing->id)
                                                ->where('start_date', '<=', now())
                                                ->where('end_date', '>=', now())
                                                ->first()->discount_amount ?? 0;

                                        $soldQuery = 'SELECT * FROM cart_orders WHERE JSON_UNQUOTE(JSON_EXTRACT(cart, "$.type")) = "housing" AND JSON_UNQUOTE(JSON_EXTRACT(cart, "$.item.id")) = ? LIMIT 1';
                                        $sold = DB::select($soldQuery, [$housing->id]);
                                    @endphp

                                    <tr>
                                        <td class="image myelist">
                                            <a href="{{ route('housing.show', ['housingSlug' => $housing->step1_slug. "-".$housing->step2_slug. "-" . $housing->slug, 'housingID' => $housing->id + 2000000]) }}">
                                                <img alt="my-properties-3"
                                                    src="{{ asset('housing_images/') . '/' . json_decode($housing->housing_type_data)->image }}"
                                                    class="img-fluid">
                                            </a>
                                        </td>
                    <td>
                        <div class="inner">
                            <a href="" style="color: black;margin-bottom:3px;">İLAN NO : {{ 2000000  + $housing->id }}</a> 
                            <div class="text-center">
                                <a href="{{route('housing.show', ['housingSlug' => $housing->step1_slug. "-".$housing->step2_slug. "-" . $housing->slug, 'housingID' => $housing->id + 2000000]) }}" style="color: black">
                                    {{ $housing->title }} <br>
                                    <span>{!! optional($housing->city)->title . 
                                    ' / ' . optional($housing->county)->title . 
                                    ' / ' . optional($housing->neighborhood)->mahalle_title ?? '' !!}
                                    </span>
                                </a>
                            </div>
                        </div>
                        
                    </td>
                                        <td>
                                            <span style="color:#e54242; font-weight:600">
                                                @if ($discountAmount)
                                                    <svg viewBox="0 0 24 24" width="24" height="24"
                                                        stroke="currentColor" stroke-width="2" fill="none"
                                                        stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                                                        <polyline points="23 18 13.5 8.5 8.5 13.5 1 6"></polyline>
                                                        <polyline points="17 18 23 18 23 12"></polyline>
                                                    </svg>
                                                @endif

                                                @if ($sold)
                                                    @if ($sold && $sold[0]->status != '1' && $sold[0]->status != '0')
                                                        @if ($housing->step2_slug == 'gunluk-kiralik')
                                                            {{ number_format(json_decode($housing->housing_type_data)->daily_rent[0], 0, ',', '.') }}
                                                            ₺ <span style="font-size:11px; color:Red"
                                                                class="mobilePriceStyle">1 Gece</span>
                                                        @else

                                                            {{ number_format(json_decode($housing->housing_type_data)->price[0], 0, ',', '.') }}
                                                            ₺
                                                        @endif
                                                    @endif
                                                @else
                                                    @if ($housing->step2_slug == 'gunluk-kiralik')
                                                        {{ number_format(json_decode($housing->housing_type_data)->daily_rent[0], 0, ',', '.') }}
                                                        ₺ <span style="font-size:11px; color:Red" class="mobilePriceStyle">1
                                                            Gece</span>
                                                    @else
                                                        {{ number_format(json_decode($housing->housing_type_data)->price[0], 0, ',', '.') }}
                                                        ₺
                                                    @endif
                                                @endif
                                            </span>
                                        </td>
                                        <td class="actions">
                                            <a href="#" class="remove-from-cart"
                                                data-housing-id="{{ $housing->id }}" style="float: left">
                                                <i class="far fa-trash-alt"></i>
                                            </a>
                                        </td>
                                        <td>
                                            @if ($housing->step2_slug != 'gunluk-kiralik')
                                                <button class="CartBtn" data-type='housing' data-id='{{ $housing->id }}'>
                                                    <span class="IconContainer">
                                                        <img src="{{ asset('sc.png') }}" alt="">
                                                    </span>
                                                    <span class="text">Sepete Ekle</span>
                                                </button>
                                            @else
                                                <button onclick="redirectToReservation()" class="reservationBtn">
                                                    <span class="IconContainer">
                                                        <img src="{{ asset('sc.png') }}" alt="">
                                                    </span>
                                                    <span class="text">Rezervasyon Yap</span>
                                                </button>

                                                <script>
                                                    function redirectToReservation() {
                                                        window.location.href = "{{ route('housing.show', ['housingSlug' => $housing->step1_slug. "-".$housing->step2_slug. "-" . $housing->slug, 'housingID' => $housing->id + 2000000]) }}";
                                                    }
                                                </script>
                                            @endif
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        @endif

                    </tbody>
                </table>
            </div>


        </div>


    </section>
@endsection
@section('scripts')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        $("#createOrder").click(function() {
            // Sepete eklenecek verileri burada hazırlayabilirsiniz

            // Ajax isteği gönderme
            $.ajax({
                url: "{{ route('client.create.order') }}", // Sepete veri eklemek için uygun URL'yi belirtin
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}"
                }, // Veriyi göndermek için POST kullanabilirsiniz, // Sepete eklemek istediğiniz ürün verilerini gönderin
                success: function(response) {
                    // İşlem başarılı olduğunda buraya gelir
                    toast.success(response)
                    console.log("Ürün sepete eklendi: " + response);

                },
                error: function(error) {
                    // Hata durumunda buraya gelir
                    toast.error(error)
                    console.error("Hata oluştu: " + error);
                }
            });
        });
    </script>
    <script>
        // "Sil" düğmesine tıklanıldığında
        $(".remove-from-cart").click(function() {
            var productId = $(this).data('id');
            var confirmation = confirm("Ürünü favorilerden kaldırmak istiyor musunuz?");

            if (confirmation) {
                // Ürünü sepetten kaldırmak için Ajax isteği gönderme
                var housingId = this.getAttribute("data-housing-id");

                // AJAX isteği gönderme
                $.ajax({
                    url: "{{ route('add.housing.to.favorites', ['id' => ':id']) }}"
                        .replace(':id',
                            housingId),
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {

                        toastr.success("Konut favorilerden kaldırıldı");
                        console.log("Konut favorilerden kaldırıldı: " + response);
                        location.reload();

                    },
                    error: function(error) {
                        window.location.href = "/giris-yap";

                        toastr.error("Hata oluştu: " + error.responseText, "Hata");
                        console.error("Hata oluştu: " + error);
                    }
                });
            }
        });

        // "Sil" düğmesine tıklanıldığında
        $(".remove-from-project-cart").click(function() {
            var productId = $(this).data('id');
            var confirmation = confirm("Ürünü favorilerden kaldırmak istiyor musunuz?");

            if (confirmation) {
                var housingId = this.getAttribute("data-project-housing-id");
                var projectId = this.getAttribute("data-project-id");

                $.ajax({
                    url: "{{ route('add.project.housing.to.favorites', ['id' => ':id']) }}"
                        .replace(':id',
                            housingId),
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        project_id: projectId,
                        housing_id: housingId
                    },
                    success: function(response) {

                        toastr.success("Konut favorilerden kaldırıldı");
                        console.log("Konut favorilerden kaldırıldı: " + response);
                        location.reload();

                    },
                    error: function(error) {
                        // Hata durumunda buraya gelir
                        toastr.error("Hata oluştu: " + error.responseText, "Hata");
                        console.error("Hata oluştu: " + error);
                    }
                });
            }
        });
    </script>
@endsection