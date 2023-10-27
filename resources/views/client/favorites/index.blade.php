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

                <a href="{{ url('/') }}" class="btn btn-primary float-left mb-4">
                    <i class="fas fa-arrow-left"></i> Geri Dön
                </a>

                <table class="table-responsive">
                    <thead>
                        <tr>
                            <th class="pl-2">Konut</th>
                            <th class="p-0"></th>
                            <th class="pl-2">Fiyat</th>
                            <th>Kaldır</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($favorites) && count($projectFavorites) == 0)
                            <tr>
                                <td colspan="5">Favorileriniz Bulunmuyor</td>
                            </tr>
                        @else
                            @foreach ($favorites as $key => $item)
                                @php(
    $discount_amount =
        App\Models\Offer::where('type', 'housing')->where('housing_id', $item->housing->id)->where('start_date', '<=', date('Y-m-d H:i:s'))->where('end_date', '>=', date('Y-m-d H:i:s'))->first()->discount_amount ?? 0
)
                                <tr>
                                    <td class="image myelist">
                                        <a href="{{ route('housing.show', $item->housing->id) }}"><img alt="my-properties-3"
                                                src="{{ asset('housing_images/') . '/' . json_decode($item->housing->housing_type_data)->image }}"
                                                class="img-fluid"></a>
                                    </td>
                                    <td>
                                        <div class="inner">
                                            <a href="{{ route('housing.show', $item->housing->id) }}">
                                                <h2 style="font-weight: 600">{{ $item->housing->title }}</h2>
                                                <figure><i class="lni-map-marker"></i> {{ $item->housing->city->title }}
                                                </figure>
                                            </a>
                                        </div>
                                    </td>
                                    <td>
                                        <span style="color:#e54242; font-weight:600">
                                            @if ($discount_amount)
                                                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor"
                                                    stroke-width="2" fill="none" stroke-linecap="round"
                                                    stroke-linejoin="round" class="css-i6dzq1">
                                                    <polyline points="23 18 13.5 8.5 8.5 13.5 1 6"></polyline>
                                                    <polyline points="17 18 23 18 23 12"></polyline>
                                                </svg>
                                            @endif
                                            {{ number_format(json_decode($item->housing->housing_type_data)->price[0], 2, ',', '.') }}
                                            ₺
                                        </span>
                                    </td>
                                    <td class="actions">
                                        <a href="#" class="remove-from-cart"
                                            data-housing-id="{{ $item->housing->id }}" style="float: left"><i
                                                class="far fa-trash-alt"></i></a>
                                    </td>
                                    <td>
                                        <button class="CartBtn" data-type='housing' data-id='{{ $item->housing->id }}'>
                                            <span class="IconContainer">
                                                <img src="{{ asset('sc.png') }}" alt="">

                                            </span>
                                            <span class="text">Sepete Ekle</span>
                                        </button>
                                    </td>

                                </tr>
                            @endforeach
                            {{-- @foreach ($projectFavorites as $key => $item)
                                @php($data = $item->projectHousing->pluck('value', 'key')->toArray())
                                @php($discount_amount = Offer::where('type', 'housing')->where('housing_id', $item->id)->where('start_date', '<=', date('Y-m-d H:i:s'))->where('end_date', '>=', date('Y-m-d H:i:s'))->first()->discount_amount ?? 0)
                                <tr>
                                    <td class="image myelist">
                                        <a
                                            href="{{ route('project.housings.detail', [$item->project->slug,  getHouse($item->project, 'squaremeters[]', $key + 1)->room_order]) }}"><img
                                                alt="my-properties-3"
                                                src="{{ asset('project_housing_images/') . '/' . $data['Kapak Resmi'] }}"
                                                class="img-fluid"></a>
                                    </td>
                                    <td>
                                        <div class="inner">
                                            <a
                                                href="{{ route('project.housings.detail', [$item->project->slug, getHouse($item->project, 'squaremeters[]', $key + 1)->room_order]) }}">
                                                <h2 style="font-weight: 600">
                                                    {{ $data['m² (Net)'] . ' metrekare ' . $data['Oda Sayısı'] }}</h2>
                                                <h2> {{ $item->project->project_title }}</h2>
                                            </a>

                                        </div>
                                    </td>
                                    <td> {{ $item->project->address }}</td>
                                    <td> {{ $data['Fiyat'] - $discount_amount }}₺</td>
                                    <td>
                                        <button class="addToCart"
                                            style="width: 120px; border: none; background-color: black; border-radius: .25rem; padding: 5px 0px; color: white;"
                                            data-type='project' data-project='{{ $item->project_id }}'
                                            data-id={{ $item->housing_id }}>
                                        </button>
                                    </td>
                                    <td class="actions">
                                        <a href="#" class="remove-from-project-cart"
                                            data-project-housing-id="{{ $item->room_order }}"
                                            data-project-id="{{ $item->project_id }}" style="float: left"><i
                                                class="far fa-trash-alt"></i></a>
                                    </td>
                                </tr>
                            @endforeach --}}
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
                        console.log(response);
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
                // Ürünü sepetten kaldırmak için Ajax isteği gönderme
                var housingId = this.getAttribute("data-project-housing-id");
                console.log(housingId)
                var projectId = this.getAttribute("data-project-id");


                // AJAX isteği gönderme
                $.ajax({
                    url: "{{ route('add.project.housing.to.favorites', ['id' => ':id']) }}"
                        .replace(':id',
                            housingId),
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        project_id: projectId // project_id'yi AJAX isteği ile gönder
                    },
                    success: function(response) {
                        console.log(response);
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
