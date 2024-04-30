@extends('admin.layouts.master')

@section('content')
    <div class="content">
        <div class="mb-9">
            <div class="row g-3 mb-4">
                <div class="col-auto">
                    <h3 class="mb-0">Gelir Tablosu</h2>
                </div>
            </div>
            <div id="orderTable"
                data-list='{"valueNames":["order_no","order_image","order_project","order_amount","order_date","order_status","order_user"],"page":10,"pagination":true}'>
                <div class="mb-4">
                    <div class="row g-3">
                        <div class="col-auto">
                            <div class="search-box">
                                <div class="col-auto flex-grow-1">
                                    <p class="text-body-secondary lh-sm mb-0">EMLAK SEPETTE TOPLAM KAZANÇ :
                                        <span style="font-size: 15px">
                                            @if (isset($totalEarn))
                                                <span class="text-success"> {{ number_format($totalEarn, 0, ',', '.') }}
                                                    ₺</span>
                                            @else
                                                -
                                            @endif
                                        </span>
                                    </p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div
                    class="mx-n4 px-4 mx-lg-n6 px-lg-6 bg-white border-top border-bottom border-200 position-relative top-1">
                    <div class="table-responsive scrollbar mx-n1 px-1">
                        <table class="table table-sm fs--1 mb-0">
                            <thead>
                                <tr>
                                    <th class="sort white-space-nowrap align-middle pe-3" scope="col"
                                        data-sort="order_no">Sipariş Kodu</th>
                                    <th class="sort white-space-nowrap align-middle pe-3" scope="col"
                                        data-sort="order_image">Sipariş Tarihi</th>
                                    <th class="sort white-space-nowrap align-middle pe-3" scope="col"
                                        data-sort="order_image">Müşteri Bilgileri</th>
                                    <th class="sort white-space-nowrap align-middle pe-3" scope="col"
                                        data-sort="order_project">İlan :</th>
                                    <th class="sort white-space-nowrap align-middle pe-3" scope="col"
                                    data-sort="order_amount">Kuponlu alışveriş:</th>
                                    <th class="sort white-space-nowrap align-middle pe-3" scope="col"
                                    data-sort="order_amount">Kupon Detayı:</th>
                                    <th class="sort white-space-nowrap align-middle pe-3" scope="col"
                                        data-sort="order_amount">Emlak Kulüp Üyesi & Hakediş :</th>
                                    <th class="sort white-space-nowrap align-middle pe-3" scope="col"
                                        data-sort="order_date">Emlak Sepette Hakediş :</th>
                                    <th class="sort white-space-nowrap align-middle pe-3" scope="col"
                                        data-sort="order_status">Kurumsal Üye Hakediş :</th>
                                    <th class="sort white-space-nowrap align-middle pe-3" scope="col"
                                        data-sort="order_user">Ödenen Kapora Bedeli</th>
                                </tr>
                            </thead>
                            <tbody class="list" id="order-table-body">
                                @foreach ($mergedArray as $key => $item)
                                {{-- {{dd($item->cart->refund)}} --}}
                                @if(isset($item['is_reservation']) && $item['is_reservation'] == 1)
                                    @php($reservation = App\Models\Reservation::with('user')->find($item['reservation_id']))
                                    @if($reservation)
                                        @php($housing = App\Models\Housing::with('user')->find($reservation->housing_id))

                                        <tr @if(isset($item->cart->refund) && in_array($item->cart->refund->status, [1, 3])) style="background-color: #e54242;" @endif>


                                            <td>{{ $reservation->key ?? null }}</td>
                                            <td>{{ optional(\Carbon\Carbon::parse($reservation->created_at))->format('d.m.Y H:i:s') ?? null }}</td>
                                            <td>
                                                <span>İsim: {{ optional($reservation->user)->name ?? null }}</span><br>
                                                <span>{{ optional($reservation->user)->email ?? null }}</span>
                                            </td>
                                            <td>
                                                <strong>İlan No:</strong>
                                                <strong>{{ $reservation->id + 2000000 ?? null }}</strong><br>
                                                {{ $housing->title ?? null }}
                                            </td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>
                                                @if (isset($item->balance))
                                                    <strong>{{ optional($item->user)->name ?? null }}</strong><br>
                                                    <span><strong>E-Mail: </strong>{{ optional($item->user)->email ?? null }}</span><br>
                                                    <span><strong>Telefon: </strong>{{ optional($item->user)->phone ?? null }}</span><br>
                                                    <span><strong>IBAN: </strong>{{ optional($item->user)->iban ?? null }}</span><br>
                                                    <span class="text-success">Kazanç:  {{ number_format((float)$item->balance , 0, ',', '.') ?? null }} ₺</span>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                @if (isset($item->earn))
                                                    <span class="text-success">Kazanç: {{ $item->earn ? number_format(str_replace('.','',$item->earn) + ($reservation->money_trusted ? 1000 : 0), 0, ',', '.') : null }} ₺</span>
                                                    @if($reservation->money_trusted)
                                                        <div class="d-flex" style="align-items: center;">
                                                            1.000 ₺'si param güvende ödemesidir
                                                        </div>
                                                    @endif
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                <strong>{{ $reservation->owner->name ?? null }}</strong><br>
                                                {{ $reservation->owner->email ?? null }}
                                                @if ($reservation->owner->phone)
                                                    <br>
                                                @endif
                                                {{ $reservation->owner->phone ?? null }}
                                                <br>
                                                @if (isset($item->earn2))
                                                    <span class="text-success">Kazanç: {{ number_format((float)$item->earn2  , 0, ',', '.') ?? null }} ₺</span>
                                                @endif
                                            </td>
                                            <td>{{ number_format(($reservation->total_price / 2) + ($reservation->money_trusted ? 1000 : 0), 0, ',', '.') }}  ₺<br>
                                                @if($reservation->money_trusted)
                                                    <div class="d-flex" style="align-items: center;">
                                                        1.000 ₺'si param güvende ödemesidir
                                                    </div>
                                                @endif
                                            </td>
                                        </tr>
                                    @else
                                        <tr>
                                            <td colspan="9">Veri bulunamadı</td>
                                        </tr>
                                    @endif
                                @else
                                    @if(isset($item->cart) && isset($item->cart->cart))
                                        @php($o = json_decode($item->cart->cart))
                                        @php($project = isset($o->type) && $o->type == 'project' ? App\Models\Project::with('user')->find($o->item->id) : null)
                                        @php($housing = isset($o->type) && $o->type == 'housing' ? App\Models\Housing::with('user')->find($o->item->id) : null)
                                        <tr @if(isset($item->cart->refund) && in_array($item->cart->refund->status, [1, 3])) class="table-danger" @endif>
                                            <td>{{ $item->cart->key ?? null }}</td>
                                            <td>{{ optional(\Carbon\Carbon::parse($item->cart->created_at))->format('d.m.Y H:i:s') ?? null }}</td>
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
                                            <td>{{isset($item->cart->coupon) ? "Evet" : "Hayır"}}</td>
                                            <td>@if(isset($item->cart->coupon)) {{$item->cart->coupon->coupon->coupon_code}} <br> (@if($item->cart->coupon->coupon->discount_type == 1) %{{$item->cart->coupon->coupon->amount}} @else {{$item->cart->coupon->coupon->amount}}₺) @endif @else - @endif</td>
                                            <td>
                                                @if (isset($item->balance))
                                                    <strong>{{ optional($item->user)->name ?? null }}</strong><br>
                                                    <span><strong>E-Mail: </strong>{{ optional($item->user)->email ?? null }}</span><br>
                                                    <span><strong>Telefon: </strong>{{ optional($item->user)->phone ?? null }}</span><br>
                                                    <span><strong>IBAN: </strong>{{ optional($item->user)->iban ?? null }}</span><br>
                                                    <span class="text-success">Kazanç: {{ number_format((float)$item->balance  , 0, ',', '.') ?? null }} ₺</span>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                @if (isset($item->earn))
                                                    <span class="text-success">Kazanç: {{number_format((float)$item->earn, 2, ',', '.') ?? null }} ₺</span>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                @if ($o->type == 'project')
                                                    <strong>{{ optional(App\Models\Project::with('user')->find(json_decode($item->cart->cart)->item->id ?? 0)->user)->name ?? null }}</strong>
                                                    <br>
                                                    {{ optional(App\Models\Project::with('user')->find(json_decode($item->cart->cart)->item->id ?? 0)->user)->email ?? null }}
                                                    @if (optional(App\Models\Project::with('user')->find(json_decode($item->cart->cart)->item->id ?? 0)->user)->phone)
                                                        <br>
                                                    @endif
                                                    {{ optional(App\Models\Project::with('user')->find(json_decode($item->cart->cart)->item->id ?? 0)->user)->phone ?? null }}
                                                @else
                                                    <strong>{{ optional(App\Models\Housing::with('user')->find(json_decode($item->cart->cart)->item->id ?? 0)->user)->name ?? null }}</strong>
                                                    <br>
                                                    {{ optional(App\Models\Housing::with('user')->find(json_decode($item->cart->cart)->item->id ?? 0)->user)->email ?? null }}
                                                    @if (optional(App\Models\Housing::with('user')->find(json_decode($item->cart->cart)->item->id ?? 0)->user)->phone)
                                                        <br>
                                                    @endif
                                                    {{ optional(App\Models\Housing::with('user')->find(json_decode($item->cart->cart)->item->id ?? 0)->user)->phone ?? null }}
                                                @endif
                                                <br>
                                                @if (isset($item->earn2))
                                                    <span class="text-success">Kazanç: {{ number_format((float)$item->earn2  , 0, ',', '.') ?? null }} ₺</span>
                                                @endif
                                            </td>
                                            <td> {{ $item->cart->amount ?? null }} ₺</td>
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
@endsection

@section('css')
@endsection
