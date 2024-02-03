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
                    <i class="fas fa-arrow-left"></i> Geri Dön
                </a>

                <table class="table-responsive">
                    <thead class="mobile-hidden">
                        <tr>
                            <th class="pl-2">Konut</th>
                            <th class="p-0"></th>
                            <th class="pl-2">Fiyat</th>
                            <th>Sepete Ekle</th>
                            <th>Kaldır</th>
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
                                @if ($item->project_id)
                                    @php($data = $item->projectHousing->pluck('value', 'key')->toArray())

                                    @php(
                                            $discount_amount =
                                                App\Models\Offer::where('type', 'project')->where('project_id', $item->project->id)->where('project_housings', 'LIKE', "%\"{$item->project->housing_type_id}\"%")->where('start_date', '<=', date('Y-m-d H:i:s'))->where('end_date', '>=', date('Y-m-d H:i:s'))->first()->discount_amount ?? 0
                                        )

                                    @php($sold = DB::select('SELECT * FROM cart_orders WHERE JSON_UNQUOTE(JSON_EXTRACT(cart, "$.type")) = "project" AND JSON_UNQUOTE(JSON_EXTRACT(cart, "$.item.housing")) = ? AND JSON_UNQUOTE(JSON_EXTRACT(cart, "$.item.id")) = ? LIMIT 1', [getHouse($item->project, 'price[]', $item->housing_id)->room_order, $item->project->id]))

                                    <tr>
                                        <td class="image myelist">
                                            <a
                                                href="{{ route('project.housings.detail', [$item->project->slug, getHouse($item->project, 'squaremeters[]', $item->housing_id)->room_order]) }}"><img
                                                    alt="my-properties-3"
                                                    src="{{ URL::to('/') . '/project_housing_images/' . getHouse($item->project, 'image[]', $item->housing_id)->value }}"
                                                    class="img-fluid"></a>
                                        </td>
                                        <td>
                                            <div class="inner">
                                                <a
                                                    href="{{ route('project.housings.detail', [$item->project->slug, getHouse($item->project, 'squaremeters[]', $item->housing_id)->room_order]) }}">
                                                    <h2 style="font-weight: 600">
                                                        {{ getHouse($item->project, 'squaremeters[]', $item->housing_id)->value . ' metrekare ' . getHouse($item->project, 'room_count[]', $item->housing_id)->value }}
                                                    </h2>
                                                    <h2> {{ $item->project->project_title }}</h2>
                                                </a>

                                            </div>
                                        </td>
                                        <td>
                                            <span style="color:#e54242; font-weight:600">


                                                @if (getHouse($item->project, 'off_sale[]', $item->housing_id)->value == '[]')
                                                    @if ($sold)
                                                        @if ($sold[0]->status != '1' && $sold[0]->status != '0')
                                                            {{ number_format(getHouse($item->project, 'price[]', $item->housing_id)->value - $discount_amount, 0, ',', '.') }}
                                                            ₺
                                                        @endif
                                                    @else
                                                        {{ number_format(getHouse($item->project, 'price[]', $item->housing_id)->value - $discount_amount, 0, ',', '.') }}
                                                        ₺
                                                    @endif
                                                @endif

                                            </span>
                                        </td>

                                        <td class="actions">
                                            <a href="#" class="remove-from-project-cart"
                                                data-project-housing-id="{{ getHouse($item->project, 'price[]', $item->housing_id)->room_order }}"
                                                data-project-id="{{ $item->project_id }}" style="float: left"><i
                                                    class="far fa-trash-alt"></i></a>
                                        </td>
                                        <td>
                                            @if (getHouse($item->project, 'off_sale[]', $item->housing_id)->value != '[]')
                                                <button class="btn mobileBtn second-btn " 
                                                    style="background: #EA2B2E !important;width:100%;color:White">
                                                    <span class="IconContainer">
                                                        <img src="{{ asset('sc.png') }}" alt="">
                                                    </span>
                                                    <span class="text">Satışa Kapatıldı</span>
                                                </button>
                                            @else
                                                @if ($sold && $sold[0]->status != '2')
                                                    <button class="btn second-btn " 
                                                        @if ($sold[0]->status == '0') style="background: orange !important;width:100%;color:White"
                                        @else 
                                        style="background: #EA2B2E !important;width:100%;color:White" @endif>
                                                        @if ($sold[0]->status == '0')
                                                            <span class="text">Rezerve Edildi</span>
                                                        @else
                                                            <span class="text">Satıldı</span>
                                                        @endif
                                                    </button>
                                                @else
                                                    <button class="CartBtn" data-type='project'
                                                        data-project='{{ $item->project_id }}'
                                                        data-id='{{ getHouse($item->project, 'price[]', $item->housing_id)->room_order }}'>
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
                                    @php(
                                            $discount_amount =
                                                App\Models\Offer::where('type', 'housing')->where('housing_id', $item->housing->id)->where('start_date', '<=', date('Y-m-d H:i:s'))->where('end_date', '>=', date('Y-m-d H:i:s'))->first()->discount_amount ?? 0
                                        )

                                    @php($sold = DB::select('SELECT * FROM cart_orders WHERE JSON_EXTRACT(cart, "$.type") = "housing"  AND  JSON_EXTRACT(cart, "$.item.id") = ? LIMIT 1', [$item->housing->id]))

                                    <tr>
                                        <td class="image myelist">
                                            <a href="{{ route('housing.show', $item->housing->id) }}"><img
                                                    alt="my-properties-3"
                                                    src="{{ asset('housing_images/') . '/' . json_decode($item->housing->housing_type_data)->image }}"
                                                    class="img-fluid"></a>
                                        </td>
                                        <td>
                                            <div class="inner">
                                                <a href="{{ route('housing.show', $item->housing->id) }}">
                                                    <h2 style="font-weight: 600">{{ $item->housing->title }}</h2>
                                                    <figure><i class="lni-map-marker"></i>
                                                        {{ $item->housing->city->title }}
                                                    </figure>
                                                </a>
                                            </div>
                                        </td>
                                        <td>
                                            <span style="color:#e54242; font-weight:600">
                                                @if ($discount_amount)
                                                    <svg viewBox="0 0 24 24" width="24" height="24"
                                                        stroke="currentColor" stroke-width="2" fill="none"
                                                        stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                                                        <polyline points="23 18 13.5 8.5 8.5 13.5 1 6"></polyline>
                                                        <polyline points="17 18 23 18 23 12"></polyline>
                                                    </svg>
                                                @endif
                                                @if ($sold)
                                                    @if ($sold[0]->status != '1' && $sold[0]->status != '0')
                                                        @if ($item->housing->step2_slug == 'gunluk-kiralik')
                                                            {{ number_format(json_decode($item->housing->housing_type_data)->daily_rent[0], 0, ',', '.') }}
                                                            ₺ <span style="font-size:11px; color:Red" class="mobilePriceStyle">1 Gece</span>
                                                        @else
                                                            {{ number_format(json_decode($item->housing->housing_type_data)->price[0], 0, ',', '.') }}
                                                            ₺
                                                        @endif
                                                    @endif
                                                @else
                                                    @if ($item->housing->step2_slug == 'gunluk-kiralik')
                                                        {{ number_format(json_decode($item->housing->housing_type_data)->daily_rent[0], 0, ',', '.') }}
                                                        ₺ <span style="font-size:11px; color:Red" class="mobilePriceStyle">1 Gece</span>
                                                    @else
                                                        {{ number_format(json_decode($item->housing->housing_type_data)->price[0], 0, ',', '.') }}
                                                        ₺
                                                    @endif
                                                @endif

                                            </span>
                                        </td>
                                     
                                        <td>
                                            @if ($item->housing->step2_slug != 'gunluk-kiralik')
                                                <button class="CartBtn" data-type='housing'
                                                    data-id='{{ $item->housing->id }}'>
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
                                                        window.location.href = "{{ route('housing.show', [$item->housing->id]) }}";
                                                    }
                                                </script>
                                            @endif
                                        </td>
                                        <td class="actions">
                                            <a href="#" class="remove-from-cart"
                                                data-housing-id="{{ $item->housing->id }}" style="float: left"><i
                                                    class="far fa-trash-alt"></i></a>
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
                        // Hata durumunda buraya gelir
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
