@extends('admin.layouts.master')

@section('content')
    <div class="content">
        <div class="mb-9">
            <div class="row g-3 mb-4">
                <div class="col-auto">
                    <h2 class="mb-0">Emlak Sepette Muhasabe Yönetimi</h2>
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
                                @foreach ($mergedArray as $item)
                                    @php($o = json_decode($item->cart->cart ?? null))
                                    @php($project = $o->type == 'project' ? App\Models\Project::with('user')->find($o->item->id) : null)
                                    @php($housing = $o->type == 'housing' ? App\Models\Housing::with('user')->find($o->item->id) : null)
                                    <tr>
                                        <td>{{ $item->cart->key }}</td>
                                        <td>{{ optional(\Carbon\Carbon::parse($item->cart->created_at))->format('d.m.Y H:i:s') ?? '-' }}
                                        </td>
                                        <td>
                                            <span>İsim: {{ optional($item->cart->user)->name ?? '-' }}</span>
                                            <br>
                                            <span>{{ optional($item->cart->user)->email ?? '-' }}</span>
                                        </td>

                                        <td>
                                            <strong>İlan No:</strong>
                                            @if ($o->type == 'project')
                                                <strong>{{ $o->item->id + 1000000 + json_decode($item->cart->cart)->item->housing }}
                                                </strong>
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
                                                <strong>{{ optional($item->user)->name ?? '-' }}</strong>
                                                <br>
                                                <span> <strong>E-Mail: </strong>
                                                    {{ optional($item->user)->email ?? '-' }}</span>
                                                <br>
                                                <span><strong>Telefon: </strong>
                                                    {{ optional($item->user)->phone ?? '-' }}</span>
                                                <br>
                                                <span><strong>IBAN: </strong>
                                                    {{ optional($item->user)->iban ?? '-' }}</span>
                                                <br>
                                                <span class="text-success">Kazanç: {{ $item->balance ?? '-' }} ₺</span>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            @if (isset($item->earn))
                                                <span class="text-success">Kazanç: {{ $item->earn ?? '-' }} ₺</span>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>


                                            @if ($o->type == 'project')
                                                <strong>{{ optional(App\Models\Project::with('user')->find(json_decode($item->cart->cart)->item->id ?? 0)->user)->name ?? '-' }}</strong>
                                                <br>
                                                {{ optional(App\Models\Project::with('user')->find(json_decode($item->cart->cart)->item->id ?? 0)->user)->email ?? '-' }}
                                                @if (optional(App\Models\Project::with('user')->find(json_decode($item->cart->cart)->item->id ?? 0)->user)->phone)
                                                    <br>
                                                @endif
                                                {{ optional(App\Models\Project::with('user')->find(json_decode($item->cart->cart)->item->id ?? 0)->user)->phone ?? '-' }}
                                            @else
                                                <strong>{{ optional(App\Models\Housing::with('user')->find(json_decode($item->cart->cart)->item->id ?? 0)->user)->name ?? '-' }}</strong>
                                                <br>
                                                {{ optional(App\Models\Housing::with('user')->find(json_decode($item->cart->cart)->item->id ?? 0)->user)->email ?? '-' }}
                                                @if (optional(App\Models\Housing::with('user')->find(json_decode($item->cart->cart)->item->id ?? 0)->user)->phone)
                                                    <br>
                                                @endif
                                                {{ optional(App\Models\Housing::with('user')->find(json_decode($item->cart->cart)->item->id ?? 0)->user)->phone ?? '-' }}
                                            @endif
                                            <br>
                                            @if (isset($item->earn2))
                                                <span class="text-success">Kazanç: {{ $item->earn2 ?? '-' }} ₺</span>
                                            @endif

                                        </td>
                                        <td>{{ $item->cart->amount ?? '-' }} ₺</td>
                                    </tr>
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
