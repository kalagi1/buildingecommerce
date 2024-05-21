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


                <div class="row mb-3">
                    <div class="col-auto">
                        <label for="filter_month" class="form-label">Ay:</label>
                        <select class="form-select" id="filter_month">
                            <option value="">Tümü</option>
                            <option value="1">Ocak</option>
                            <option value="2">Şubat</option>
                            <!-- Diğer aylar buraya eklenebilir -->
                        </select>
                    </div>
                    <div class="col-auto">
                        <label for="filter_year" class="form-label">Yıl:</label>
                        <select class="form-select" id="filter_year">
                            <option value="">Tümü</option>
                            <option value="2022">2022</option>
                            <option value="2023">2023</option>
                            <!-- Diğer yıllar buraya eklenebilir -->
                        </select>
                    </div>

                    <div class="col-auto ml-auto">
                        <button class="btn btn-link text-body me-4 px-0"><svg
                                class="svg-inline--fa fa-file-export fs-9 me-2" aria-hidden="true" focusable="false"
                                data-prefix="fas" data-icon="file-export" role="img" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 576 512" data-fa-i2svg="">
                                <path fill="currentColor"
                                    d="M192 312C192 298.8 202.8 288 216 288H384V160H256c-17.67 0-32-14.33-32-32L224 0H48C21.49 0 0 21.49 0 48v416C0 490.5 21.49 512 48 512h288c26.51 0 48-21.49 48-48v-128H216C202.8 336 192 325.3 192 312zM256 0v128h128L256 0zM568.1 295l-80-80c-9.375-9.375-24.56-9.375-33.94 0s-9.375 24.56 0 33.94L494.1 288H384v48h110.1l-39.03 39.03C450.3 379.7 448 385.8 448 392s2.344 12.28 7.031 16.97c9.375 9.375 24.56 9.375 33.94 0l80-80C578.3 319.6 578.3 304.4 568.1 295z">
                                </path>
                            </svg>Çıktı Al</button>
                    </div>
                    <!-- Diğer filtreleme seçenekleri buraya eklenebilir -->
                </div>

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
                                                            {{ number_format((float) $item->balance, 0, ',', '.') ?? null }}
                                                            ₺</span>
                                                        <br>


                                                       
                                                            <select class="form-select payment-status" data-id="{{ $item->id }}" data-type="payment_balance">
                                                                <option value="1" {{ $item->payment_balance == true ? 'selected' : '' }}>Ödeme Yapıldı</option>
                                                                <option value="0" {{ $item->payment_balance == false ? 'selected' : '' }}>Ödeme Yapılmadı</option>
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
                                                            {{ number_format((float) $item->earn2, 0, ',', '.') ?? null }}
                                                            ₺</span>
                                                        <br>
                                                        
                                                            <select class="form-select payment-status" data-id="{{ $item->id }}" data-type="payment_earn2">
                                                                <option value="1" {{ $item->payment_earn2 == true ? 'selected' : '' }}>Ödeme Yapıldı</option>
                                                                <option value="0" {{ $item->payment_earn2 == false ? 'selected' : '' }}>Ödeme Yapılmadı</option>
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
                                                            {{ number_format((float) $item->balance, 0, ',', '.') ?? null }}
                                                            ₺</span>
                                                        <br>
                                                        <select class="form-select payment-status" data-id="{{ $item->id }}" data-type="payment_balance">
                                                            <option value="1" {{ $item->payment_balance == true ? 'selected' : '' }}>Ödeme Yapıldı</option>
                                                            <option value="0" {{ $item->payment_balance == false ? 'selected' : '' }}>Ödeme Yapılmadı</option>
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
                                                                {{ number_format((float) $item->earn2, 0, ',', '.') ?? null }}
                                                                ₺</span>
                                                            <br>
                                                            <select class="form-select payment-status" data-id="{{ $item->id }}" data-type="payment_earn2">
                                                                <option value="1" {{ $item->payment_earn2 == true ? 'selected' : '' }}>Ödeme Yapıldı</option>
                                                                <option value="0" {{ $item->payment_earn2 == false ? 'selected' : '' }}>Ödeme Yapılmadı</option>
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
    <script>
        // Filtreleme işlevi
        function filterTable() {
            var monthFilter = document.getElementById('filter_month').value;
            var yearFilter = document.getElementById('filter_year').value;

            // Tabloyu yeniden oluşturma işlemleri burada yapılacak
            // Örneğin, AJAX ile verileri yeniden çekip tabloyu güncellemek gibi
            // Bu örnekte, sadece seçilen ay ve yılın tablodaki verileri gösterildiğini varsayalım
        }

        // Filtreleme seçeneklerinin değişikliklerini dinleme
        document.getElementById('filter_month').addEventListener('change', filterTable);
        document.getElementById('filter_year').addEventListener('change', filterTable);

        // Sayfa yüklendiğinde tabloyu filtrelemek için
        filterTable();
    </script>

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
            var type = $(this).data('type'); // 'payment_balance' veya 'payment_earn2'

            $.ajax({
                url: '{{ route("admin.updatePaymentStatus") }}', // Güncelleme rotası
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: itemId,
                    type: type,
                    payment_status: paymentStatus
                },
                success: function(response) {
                    toastr.success('Ödeme durumu güncellendi');
                    // Ödeme durumu güncellendikten sonra select kutusunun rengini güncelle
                    updateSelectColor($(this));
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
