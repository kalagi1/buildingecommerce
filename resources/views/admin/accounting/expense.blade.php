@extends('admin.layouts.master')

@section('content')
    <div class="content">
        <div class="mb-9">
            <div class="row g-3 mb-4">
                <div class="col-auto">
                    <h3 class="mb-0">Gider Tablosu</h2>
                </div>
            </div>
            <div id="orderTable"
                data-list='{"valueNames":["order_no","order_image","order_project","order_amount","order_date","order_status","order_user"],"page":10,"pagination":true}'>
                <div class="mb-4">
                    <div class="row g-3">
                        <div class="col-auto">
                            <div class="search-box">
                                <div class="col-auto flex-grow-1">
                                    {{-- <p class="text-body-secondary lh-sm mb-0">EMLAK SEPETTE TOPLAM KAZANÇ :
                                        <span style="font-size: 15px">
                                            @if (isset($totalEarn))
                                                <span class="text-success"> {{ number_format($totalEarn, 0, ',', '.') }}
                                                    ₺</span>
                                            @else
                                                0 
                                            @endif
                                        </span>
                                    </p> --}}
                                </div>
                            </div>

                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-6 mb-2">
                        <form action="{{ route('admin.filterByDate') }}" method="GET" class="d-flex align-items-center">
                            <div class="me-2">
                                <label for="start-date">Başlangıç Tarihi:</label>
                                <input type="date" class="form-control" id="start-date" name="start_date" required>
                            </div>
                            <div class="me-2">
                                <label for="end-date">Bitiş Tarihi:</label>
                                <input type="date" class="form-control" id="end-date" name="end_date" required>
                            </div>
                            <div class="me-2 mt-4">
                                <button type="submit" class="btn btn-primary">Filtrele</button>
                            </div>
                            <div class="me-2 mt-4">
                                <a href="{{ route('admin.expense') }}" class="btn btn-secondary">Tümünü Göster</a>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-6 d-flex justify-content-end">
                        <form action="{{ route('admin.expenseExcel') }}" method="POST" class="d-flex align-items-center ms-auto">
                            @csrf
                            <input type="hidden" name="start_date" value="{{ request('start_date') }}">
                            <input type="hidden" name="end_date" value="{{ request('end_date') }}">
                            <input type="hidden" name="mergedArray" value="{{ json_encode($mergedArray) }}">
                            <button type="submit" class="btn btn-link text-body me-4 px-0 d-flex align-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="30" height="30" viewBox="0 0 50 50" class="me-2">
                                    <path fill="currentColor"
                                        d="M 28.875 0 C 28.855469 0.0078125 28.832031 0.0195313 28.8125 0.03125 L 0.8125 5.34375 C 0.335938 5.433594 -0.0078125 5.855469 0 6.34375 L 0 43.65625 C -0.0078125 44.144531 0.335938 44.566406 0.8125 44.65625 L 28.8125 49.96875 C 29.101563 50.023438 29.402344 49.949219 29.632813 49.761719 C 29.859375 49.574219 29.996094 49.296875 30 49 L 30 44 L 47 44 C 48.09375 44 49 43.09375 49 42 L 49 8 C 49 6.90625 48.09375 6 47 6 L 30 6 L 30 1 C 30.003906 0.710938 29.878906 0.4375 29.664063 0.246094 C 29.449219 0.0546875 29.160156 -0.0351563 28.875 0 Z M 28 2.1875 L 28 6.53125 C 27.867188 6.808594 27.867188 7.128906 28 7.40625 L 28 42.8125 C 27.972656 42.945313 27.972656 43.085938 28 43.21875 L 28 47.8125 L 2 42.84375 L 2 7.15625 Z M 30 8 L 47 8 L 47 42 L 30 42 L 30 37 L 34 37 L 34 35 L 30 35 L 30 29 L 34 29 L 34 27 L 30 27 L 30 22 L 34 22 L 34 20 L 30 20 L 30 15 L 34 15 L 34 13 L 30 13 Z M 36 13 L 36 15 L 44 15 L 44 13 Z M 6.6875 15.6875 L 12.15625 25.03125 L 6.1875 34.375 L 11.1875 34.375 L 14.4375 28.34375 C 14.664063 27.761719 14.8125 27.316406 14.875 27.03125 L 14.90625 27.03125 C 15.035156 27.640625 15.160156 28.054688 15.28125 28.28125 L 18.53125 34.375 L 23.5 34.375 L 17.75 24.9375 L 23.34375 15.6875 L 18.65625 15.6875 L 15.6875 21.21875 C 15.402344 21.941406 15.199219 22.511719 15.09375 22.875 L 15.0625 22.875 C 14.898438 22.265625 14.710938 21.722656 14.5 21.28125 L 11.8125 15.6875 Z M 36 20 L 36 22 L 44 22 L 44 20 Z M 36 27 L 36 29 L 44 29 L 44 27 Z M 36 35 L 36 37 L 44 37 L 44 35 Z"></path>
                                </svg>
                                <strong class="pt-2">Excel Çıktısı Al</strong>
                            </button>
                        </form>
                    </div>
                </div>
                
                

                <!-- Diğer filtreleme seçenekleri buraya eklenebilir -->


                <div
                    class="mx-n4 px-4 mx-lg-n6 px-lg-6 bg-white border-top border-bottom border-200 position-relative top-1">
                    <div class="table-responsive scrollbar mx-n1 px-1">
                        <table class="table table-sm fs--1 mb-0">
                            <thead>
                                <tr>
                                    <th class="sort white-space-nowrap align-middle pe-3" scope="col"
                                        data-sort="order_no">İlan Kodu</th>
                                    <th class="sort white-space-nowrap align-middle pe-3" scope="col"
                                        data-sort="order_image">Oluşturulma Tarihi</th>
                                    <th class="sort white-space-nowrap align-middle pe-3" scope="col"
                                        data-sort="order_image">Müşteri Bilgileri</th>
                                    <th class="sort white-space-nowrap align-middle pe-3" scope="col"
                                        data-sort="order_project">İlan :</th>
                                    <th class="sort white-space-nowrap align-middle pe-3" scope="col"
                                        data-sort="order_amount">Emlak Kulüp Üyesi :</th>
                                    <th class="sort white-space-nowrap align-middle pe-3" scope="col"
                                        data-sort="order_amount">Emlak Kulüp Üyesi Hakediş :</th>
                                    <th class="sort white-space-nowrap align-middle pe-3" scope="col"
                                        data-sort="order_status">Kurumsal Üye :</th>
                                    <th class="sort white-space-nowrap align-middle pe-3" scope="col"
                                        data-sort="order_status">Kurumsal Üye Hakediş :</th>
                                    <th class="sort white-space-nowrap align-middle pe-3" scope="col"
                                        data-sort="order_user">Detay</th>
                                </tr>
                            </thead>
                            <tbody class="list" id="order-table-body">
                                @foreach ($mergedArray as $key => $item)
                                    @if (isset($item['is_reservation']) && $item['is_reservation'] == 1)
                                        @php($reservation = App\Models\Reservation::with('user')->find($item['reservation_id']))
                                        @if ($reservation)
                                            @php($housing = App\Models\Housing::with('user')->find($reservation->housing_id))

                                            <tr @if (isset($item->cart->refund) && in_array($item->cart->refund->status, [1, 3])) style="background-color: #e54242;" @endif>
                                                <td>{{ $reservation->key ?? null }}</td>
                                                <td>{{ optional(\Carbon\Carbon::parse($reservation->created_at))->format('d.m.Y H:i:s') ?? null }}
                                                </td>
                                                <td>
                                                    <span>İsim: {{ optional($reservation->user)->name ?? null }}</span><br>
                                                    <span>{{ optional($reservation->user)->email ?? null }}</span>
                                                </td>
                                                <td>
                                                    <strong>İlan No:</strong>
                                                    <strong>{{ $reservation->id + 2000000 ?? null }}</strong><br>
                                                    {{ $housing->title ?? null }}
                                                </td>
                                                <td>
                                                    @if (isset($item->balance))
                                                        <strong>{{ optional($item->user)->name ?? null }}</strong><br>
                                                        <span><strong>E-Mail:
                                                            </strong>{{ optional($item->user)->email ?? null }}</span><br>
                                                        <span><strong>Telefon:
                                                            </strong>{{ optional($item->user)->phone ?? null }}</span><br>
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td>
                                                    @if (isset($item->balance))
                                                        <span><strong>IBAN:
                                                            </strong>{{ optional($item->user)->iban ?? null }}</span><br>
                                                        @if (optional($item->user)->bank_name)
                                                            <span><strong>Alıcı Adı:
                                                                </strong>{{ optional($item->user)->bank_name ?? null }}</span><br>
                                                        @endif

                                                        <span class="text-success">Kazanç:
                                                            {{ number_format((float) $item->balance, 2, ',', '.') ?? null }}
                                                            ₺</span>
                                                        <br>



                                                        <select class="form-select payment-status"
                                                            data-id="{{ $item->id }}"
                                                            data-source="{{ $item->source }}" data-type="payment_balance">
                                                            <option value="1"
                                                                {{ $item->payment_balance == true ? 'selected' : '' }}>
                                                                Ödeme Yapıldı</option>
                                                            <option value="0"
                                                                {{ $item->payment_balance == false ? 'selected' : '' }}>
                                                                Ödeme Yapılmadı</option>
                                                        </select>
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td>
                                                    @if (isset($item->earn2))
                                                        <strong>{{ optional($reservation->owner)->name ?? null }}</strong><br>
                                                        <span><strong>E-Mail:
                                                            </strong>{{ optional($reservation->owner)->email ?? null }}</span><br>
                                                        <span><strong>Telefon:
                                                            </strong>{{ optional($reservation->owner)->phone ?? null }}</span><br>
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td>
                                                    @if (isset($item->earn2))
                                                        <span><strong>IBAN:
                                                            </strong>{{ optional($reservation->owner)->iban ?? null }}</span><br>

                                                        @if (optional($reservation->owner)->bank_name)
                                                            <span><strong>Alıcı Adı:
                                                                </strong>{{ optional($reservation->owner)->bank_name ?? null }}</span><br>
                                                        @endif

                                                        <span class="text-success">Kazanç:
                                                            {{ number_format((float) $item->earn2, 2, ',', '.') ?? null }}
                                                            ₺</span>
                                                        <br>
                                                </td>
                                                <td>{{ number_format($reservation->down_payment, 2, ',', '.') }} ₺<br>
                                                    @if ($reservation->money_trusted)
                                                        <div class="d-flex" style="align-items: center;">
                                                            {{ $reservation->money_is_safe }} ₺'si param güvende ödemesidir
                                                        </div>
                                                    @endif
                                                </td>

                                                <select class="form-select payment-status" data-id="{{ $item->id }}"
                                                    data-source="{{ $item->source }}" data-type="payment_earn2">
                                                    <option value="1"
                                                        {{ $item->payment_earn2 == true ? 'selected' : '' }}>Ödeme Yapıldı
                                                    </option>
                                                    <option value="0"
                                                        {{ $item->payment_earn2 == false ? 'selected' : '' }}>Ödeme
                                                        Yapılmadı</option>
                                                </select>
                                            @else
                                                -
                                        @endif
                                        </td>
                                        <td class="order_details">
                                            <a href="{{ route('admin.reservation.detail', ['reservation_id' => $reservation->id]) }}"
                                                class="badge badge-phoenix badge-phoenix-success">Rezervasyon
                                                Detayı</a>
                                        </td>
                                        </tr>
                                    @endif
                                @else
                                    @if (isset($item->cart) && isset($item->cart->cart))
                                        @php($o = json_decode($item->cart->cart))
                                        @php($project = isset($o->type) && $o->type == 'project' ? App\Models\Project::with('user')->find($o->item->id) : null)
                                        @php($housing = isset($o->type) && $o->type == 'housing' ? App\Models\Housing::with('user')->find($o->item->id) : null)
                                        <tr @if (isset($item->cart->refund) && in_array($item->cart->refund->status, [1, 3])) class="table-danger" @endif>
                                            <td>{{ $item->cart->key ?? null }}</td>
                                            <td>{{ optional(\Carbon\Carbon::parse($item->cart->created_at))->format('d.m.Y H:i:s') ?? null }}
                                            </td>
                                            <td>
                                                <span>İsim: {{ optional($item->cart->user)->name ?? null }}</span><br>
                                                <span>{{ optional($item->cart->user)->email ?? null }}</span>
                                            </td>
                                            <td>
                                                <strong>İlan No:</strong>
                                                @if ($o->type == 'project')
                                                    <strong>{{ $o->item->id + 1000000 + json_decode($item->cart->cart)->item->housing }}</strong>
                                                @else
                                                    <strong>{{ json_decode($item->cart->cart)->item->id + 2000000 }}</strong>
                                                @endif <br>
                                                @if ($o->type == 'project')
                                                    <span>{{ mb_convert_case($project->project_title, MB_CASE_TITLE, 'UTF-8') }}{{ ' ' }}Projesinde
                                                        {{ json_decode($item->cart->cart)->item->housing }}
                                                        {{ "No'lu" }}
                                                        {{ $project->step1_slug }}
                                                    </span>
                                                @else
                                                    {{ App\Models\Housing::find(json_decode($item->cart->cart)->item->id ?? 0)->title ?? null }}
                                                @endif
                                            </td>
                                            <td>
                                                @if (isset($item->balance))
                                                    <strong>{{ optional($item->user)->name ?? null }}</strong><br>
                                                    <span><strong>E-Mail:
                                                        </strong>{{ optional($item->user)->email ?? null }}</span><br>
                                                    <span><strong>Telefon:
                                                        </strong>{{ optional($item->user)->phone ?? null }}</span><br>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                @if (isset($item->balance))
                                                    <span><strong>IBAN:
                                                        </strong>{{ optional($item->user)->iban ?? null }}</span><br>
                                                    @if (optional($item->user)->bank_name)
                                                        <span><strong>Alıcı Adı:
                                                            </strong>{{ optional($item->user)->bank_name ?? null }}</span><br>
                                                    @endif

                                                    <span class="text-success">Kazanç:
                                                        {{ number_format((float) $item->balance, 2, ',', '.') ?? null }}
                                                        ₺</span>
                                                    <br>
                                                    <select class="form-select payment-status"
                                                        data-id="{{ $item->id }}" data-source="{{ $item->source }}"
                                                        data-type="payment_balance">
                                                        <option value="1"
                                                            {{ $item->payment_balance == true ? 'selected' : '' }}>Ödeme
                                                            Yapıldı</option>
                                                        <option value="0"
                                                            {{ $item->payment_balance == false ? 'selected' : '' }}>Ödeme
                                                            Yapılmadı</option>
                                                    </select>
                                                @else
                                                    -
                                                @endif
                                            </td>



                                            <td>
                                                @if ($o->type == 'project')
                                                    <span><strong>{{ optional(App\Models\Project::with('user')->find(json_decode($item->cart->cart)->item->id ?? 0)->user)->name ?? null }}</strong></span>
                                                    <br>
                                                    <span><strong>E-Mail:</strong>
                                                        {{ optional(App\Models\Project::with('user')->find(json_decode($item->cart->cart)->item->id ?? 0)->user)->email ?? null }}</span>
                                                    @if (optional(App\Models\Project::with('user')->find(json_decode($item->cart->cart)->item->id ?? 0)->user)->phone)
                                                        <br>
                                                    @endif
                                                    <span><strong>Telefon:</strong>
                                                        {{ optional(App\Models\Project::with('user')->find(json_decode($item->cart->cart)->item->id ?? 0)->user)->phone ?? null }}</span>
                                                @else
                                                    <span><strong>{{ optional(App\Models\Housing::with('user')->find(json_decode($item->cart->cart)->item->id ?? 0)->user)->name ?? null }}</strong></span>
                                                    <br>
                                                    <span><strong>E-Mail:</strong>
                                                        {{ optional(App\Models\Housing::with('user')->find(json_decode($item->cart->cart)->item->id ?? 0)->user)->email ?? null }}</span>
                                                    @if (optional(App\Models\Housing::with('user')->find(json_decode($item->cart->cart)->item->id ?? 0)->user)->phone)
                                                        <br>
                                                    @endif
                                                    <span><strong>Telefon:</strong>
                                                        {{ optional(App\Models\Housing::with('user')->find(json_decode($item->cart->cart)->item->id ?? 0)->user)->phone ?? null }}
                                                    </span>
                                                @endif
                                            </td>

                                            <td>
                                                @if (isset($item->earn2))
                                                    @if ($o->type == 'project')
                                                        <span><strong>IBAN:
                                                            </strong>{{ optional(App\Models\Project::with('user')->find(json_decode($item->cart->cart)->item->id ?? 0)->user)->iban ?? null }}</span><br>

                                                        @if (optional(App\Models\Project::with('user')->find(json_decode($item->cart->cart)->item->id ?? 0)->user)->bank_name)
                                                            </strong>{{ optional(App\Models\Project::with('user')->find(json_decode($item->cart->cart)->item->id ?? 0)->user)->bank_name ?? null }}</span><br>
                                                        @endif
                                                    @else
                                                        <span><strong>IBAN:
                                                            </strong>{{ optional(App\Models\Housing::with('user')->find(json_decode($item->cart->cart)->item->id ?? 0)->user)->iban ?? null }}</span><br>

                                                        @if (optional(App\Models\Housing::with('user')->find(json_decode($item->cart->cart)->item->id ?? 0)->user)->bank_name)
                                                            </strong>{{ optional(App\Models\Housing::with('user')->find(json_decode($item->cart->cart)->item->id ?? 0)->user)->bank_name ?? null }}</span><br>
                                                        @endif
                                                        <span class="text-success">Kazanç:
                                                            {{ number_format((float) $item->earn2, 2, ',', '.') ?? null }}
                                                            ₺</span>
                                                        <br>
                                                        <select class="form-select payment-status"
                                                            data-id="{{ $item->id }}"
                                                            data-source="{{ $item->source }}" data-type="payment_earn2">
                                                            <option value="1"
                                                                {{ $item->payment_earn2 == true ? 'selected' : '' }}>Ödeme
                                                                Yapıldı</option>
                                                            <option value="0"
                                                                {{ $item->payment_earn2 == false ? 'selected' : '' }}>Ödeme
                                                                Yapılmadı</option>
                                                        </select>
                                                    @endif
                                                @endif
                                            </td>

                                            <td>
                                                <a href="{{ route('admin.order.detail', ['order_id' => $item->cart->id]) }}"
                                                    class="badge badge-phoenix fs--2 badge-phoenix-success">Sipariş
                                                    Detayı</a>
                                            </td>
                                        </tr>
                                    @endif
                                @endif
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            function updateSelectColor(selectElement) {
                if (selectElement.val() == '1') {
                    selectElement.removeClass('text-danger').addClass('text-success');
                } else {
                    selectElement.removeClass('text-success').addClass('text-danger');
                }
            }

            // Sayfa yüklendiğinde mevcut select kutularının rengini güncelle
            $('.payment-status').each(function() {
                updateSelectColor($(this));
            });

            $('.payment-status').on('change', function() {
                var paymentStatus = $(this).val();
                var itemId = $(this).data('id');
                var source = $(this).data('source');
                var type = $(this).data('type');

                console.log(paymentStatus, itemId, source, type);

                $.ajax({
                    url: '{{ route('admin.updatePaymentStatus') }}', // Güncelleme rotası
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: itemId,
                        source: source,
                        type: type,
                        payment_status: paymentStatus
                    },
                    success: function(response) {
                        toastr.success('Ödeme durumu güncellendi');
                        // Ödeme durumu güncellendikten sonra select kutusunun rengini güncelle
                        updateSelectColor($(this));
                        location.reload();
                    }.bind(this),
                    error: function(xhr, status, error) {
                        toastr.error('Bir hata oluştu');
                    }
                });
            });
        });
    </script>
@endsection

@section('css')
@endsection
