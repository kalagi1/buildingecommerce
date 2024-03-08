@props([
    'project',
    'i',
    'projectHousingsList',
    'sold',
    'isUserSame',
    'lastHousingCount',
    'projectDiscountAmount',
    'bankAccounts',
    'sumCartOrderQt',
    'blockHousingCount',
    'key',
    'previousBlockHousingCount',
    'allCounts',
])

@php
    if ($key == 0) {
        $keyIndex = $i + 1;
    } else {
        $keyIndex = $i + 1 + $allCounts;
    }
@endphp

<div class="col-md-12 col-12">
    <div class="project-card mb-3">
        <div class="row">
            <div class="col-md-3">
                <a href="{{ route('project.housings.detail', [
                    'projectSlug' => $project->slug,
                    'projectID' => $project->id + 1000000,
                    'housingOrder' => $i + 1,
                ]) }}"
                    style="height: 100%">

                    <div class="d-flex" style="height: 100%;">
                        <div style="background-color: #EA2B2E !important; border-radius: 0px 8px 0px 8px; height:100%">
                            <p
                                style="padding: 10px; color: white; height: 100%; display: flex; align-items: center; text-align:center; ">
                                No<br>{{ $i + 1 }}
                            </p>
                        </div>
                        <div class="project-single mb-0 bb-0 aos-init aos-animate" data-aos="fade-up">
                            <div class="button-effect-div">
                                <span
                                    class="btn 
                                    @if (($sold && $sold->status == '1') || $projectHousingsList[$keyIndex]['off_sale[]'] != '[]') disabledShareButton @else addCollection mobileAddCollection @endif"
                                    data-type='project' data-project='{{ $project->id }}'
                                    data-id='{{ $keyIndex }}'>
                                    <i class="fa fa-bookmark-o"></i>
                                </span>
                                <span class="btn toggle-project-favorite bg-white"
                                    data-project-housing-id="{{ $keyIndex }}" data-project-id={{ $project->id }}>
                                    <i class="fa fa-heart-o"></i>
                                </span>
                            </div>
                            <div class="homes position-relative">
                                <img src="{{ URL::to('/') . '/project_housing_images/' . $projectHousingsList[$keyIndex]['image[]'] }}"
                                    alt="home-1" class="img-responsive"
                                    style="height: 100% !important; object-fit: cover">
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-lg-9 col-md-9 homes-content pb-0 mb-44 aos-init aos-animate" data-aos="fade-up">
                <div class="row align-items-center justify-content-between mobile-position"
                    @if (($sold && $sold->status != '2') || $projectHousingsList[$keyIndex]['off_sale[]'] != '[]') style="background: #EEE !important;" @endif>
                    <div class="col-md-9">
                     
                        <div class="homes-list-div"  @if (isset($share_sale) && !empty($share_sale) && $number_of_share != 0) style="height: 90px; width: 100% !important; flex-direction: column;" @else style="" @endif>
                            <ul class="homes-list clearfix pb-3 d-flex">
                                <li class="d-flex align-items-center itemCircleFont">
                                    <i class="fa fa-circle circleIcon mr-1" style="color: black;"
                                        aria-hidden="true"></i>
                                    <span>{{ $project->housingType->title }}</span>
                                    @foreach (['column1', 'column2', 'column3'] as $column)
                                        @php
                                            $column_name = $project->listItemValues->{$column . '_name'} ?? '';
                                            $column_additional =
                                                $project->listItemValues->{$column . '_additional'} ?? '';
                                            $column_name_exists =
                                                $column_name &&
                                                isset($projectHousingsList[$keyIndex][$column_name . '[]']);
                                        @endphp

                                        @if ($column_name_exists)
                                <li class="d-flex align-items-center itemCircleFont">
                                    <i class="fa fa-circle circleIcon mr-1" aria-hidden="true"></i>
                                    <span>
                                        {{ $projectHousingsList[$keyIndex][$column_name . '[]'] }}
                                        @if ($column_additional)
                                            {{ $column_additional }}
                                        @endif
                                    </span>
                                </li>
                                @endif
                                @endforeach

                                <li class="the-icons mobile-hidden">
                                    <span style="width:100%;text-align:center">
                                        @php
                                            $off_sale_check = $projectHousingsList[$keyIndex]['off_sale[]'] == '[]';
                                            $share_sale = $projectHousingsList[$keyIndex]['share_sale[]'] ?? null;
                                            $number_of_share =
                                                $projectHousingsList[$keyIndex]['number_of_shares[]'] ?? null;
                                            $sold_check = $sold && in_array($sold->status, ['1', '0']);
                                            $discounted_price =
                                                $projectHousingsList[$keyIndex]['price[]'] - $projectDiscountAmount;
                                        @endphp

                                        @if (isset($share_sale) && !empty($share_sale) && $number_of_share != 0)
                                            1 Pay
                                        @endif

                                        @if ($off_sale_check && $projectDiscountAmount)
                                            <h6
                                                style="color: #274abb !important; position: relative; top: 4px; font-weight: 600">
                                                @if (isset($share_sale) && !empty($share_sale) && $number_of_share != 0)
                                                    {{ number_format($projectHousingsList[$keyIndex]['price[]'] / $number_of_share, 0, ',', '.') }}
                                                    ₺
                                                @else
                                                    {{ number_format($projectHousingsList[$keyIndex]['price[]'], 0, ',', '.') }}
                                                    ₺
                                                @endif
                                            </h6>

                                            <h6
                                                style="color: #e54242 !important;position: relative;top:4px;font-weight:600;font-size: 11px;text-decoration:line-through;">
                                                {{ number_format($projectHousingsList[$keyIndex]['price[]'], 0, ',', '.') }}
                                                ₺
                                            </h6>
                                        @elseif ($off_sale_check)
                                            <h6
                                                style="color: #274abb !important; position: relative; top: 4px; font-weight: 600">
                                                @if (isset($share_sale) && !empty($share_sale) && $number_of_share != 0)
                                                    {{ number_format($projectHousingsList[$keyIndex]['price[]'] / $number_of_share, 0, ',', '.') }}
                                                    ₺
                                                @else
                                                    {{ number_format($projectHousingsList[$keyIndex]['price[]'], 0, ',', '.') }}
                                                    ₺
                                                @endif
                                            </h6>

                                        @endif
                                    </span>
                                </li>


                            </ul>

                            @if (isset($share_sale) && !empty($share_sale) && $number_of_share != 0)
                                <div class="bar-chart">
                                    <div class="progress">
                                        <div class="progress-bar"
                                            @if (isset($sumCartOrderQt[$keyIndex]) && isset($sumCartOrderQt[$keyIndex]['qt_total']) && $maxQtTotal > 0) style="width: {{ (100 / $number_of_share) * $sumCartOrderQt[$keyIndex]['qt_total'] }}% !important"
                                @else
                                    style="width: 0% !important" @endif>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        @php
                            // Example: Set a default value for $maxQtTotal
                            $maxQtTotal = 100; // Set the appropriate default value

                            // OR check if $maxQtTotal is defined
                            if (!isset($maxQtTotal)) {
                                $maxQtTotal = 100; // Set the appropriate default value
                            }
                        @endphp




                    </div>

                    <div class="col-md-3 mobile-hidden" style="height: 100px; padding: 0">
                        <div class="homes-button" style="width: 100%; height: 100%">
                            @if ($sold_check && $sold->status == '1')
                                @php
                                    $neighborView = null;

                                    if (Auth::check()) {
                                        $neighborView = App\Models\NeighborView::where('user_id', Auth::user()->id)
                                            ->where('project_id', $project->id)
                                            ->where('housing', $keyIndex)
                                            ->first();
                                    }
                                @endphp

                                @if (!$neighborView && $sold->status == '1' && isset($sold->is_show_user) && $sold->is_show_user == 'on' && !$isUserSame)
                                    <span class="first-btn see-my-neighbor"
                                        @if (Auth::check()) data-bs-toggle="modal"
                                    data-bs-target="#paymentModal" data-order="{{ $sold->id }}" @endif>
                                        <span><svg viewBox="0 0 24 24" width="18" height="18"
                                                stroke="currentColor" stroke-width="2" fill="none"
                                                stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                                <circle cx="12" cy="12" r="3"></circle>
                                            </svg> Komşumu Gör</span>
                                    </span>
                                @elseif($neighborView && $neighborView->status == '0')
                                    <span class="first-btn see-my-neighbor payment">
                                        <span> <svg viewBox="0 0 24 24" width="18" height="18"
                                                stroke="currentColor" stroke-width="2" fill="none"
                                                stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                                                <circle cx="12" cy="12" r="10"></circle>
                                                <line x1="12" y1="8" x2="12" y2="12">
                                                </line>
                                                <line x1="12" y1="16" x2="12.01" y2="16">
                                                </line>
                                            </svg>
                                            Ödeme Onayı </span>
                                    </span>
                                @elseif($neighborView && $neighborView->status == '1')
                                    <span class="first-btn see-my-neighbor success">
                                        <a href="tel: {{ $sold->phone }}" style="color:white">
                                            <span>
                                                Komşunuz:
                                                {{ $sold->name }} <br>
                                                <svg viewBox="0 0 24 24" width="18" height="18"
                                                    stroke="currentColor" stroke-width="2" fill="none"
                                                    stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                                                    <polyline points="19 1 23 5 19 9"></polyline>
                                                    <line x1="15" y1="5" x2="23" y2="5">
                                                    </line>
                                                    <path
                                                        d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z">
                                                    </path>
                                                </svg>
                                                {{ $sold->phone }}
                                            </span>
                                        </a>

                                    </span>
                                @elseif($isUserSame == true)
                                    <span class="first-btn see-my-neighbor success">
                                        <span>
                                            İLANI SİZ SATIN ALDINIZ
                                        </span>

                                    </span>
                                @else
                                    <button class="first-btn payment-plan-button" project-id="{{ $project->id }}"
                                        data-sold="{{ ($sold && ($sold->status == 1 || $sold->status == 0) && empty($share_sale)) || $projectHousingsList[$keyIndex]['off_sale[]'] != '[]' ? '1' : '0' }}"
                                        order="{{ $keyIndex }}">
                                        Ödeme Detayı
                                    </button>
                                @endif
                            @else
                                @if ($projectHousingsList[$keyIndex]['off_sale[]'] != '[]')
                                    @if (Auth::user())
                                        <button class="first-btn payment-plan-button" data-toggle="modal"
                                            data-target="#exampleModal{{ $keyIndex }}">
                                            Başvuru Yap
                                        </button>
                                    @else
                                        <a href="{{ route('client.login') }}" class="first-btn payment-plan-button">
                                            Başvuru Yap
                                        </a>
                                    @endif
                                @else
                                    <button class="first-btn payment-plan-button" project-id="{{ $project->id }}"
                                        data-sold="{{ ($sold && ($sold->status == 1 || $sold->status == 0)) || $projectHousingsList[$keyIndex]['off_sale[]'] != '[]' ? '1' : '0' }}"
                                        order="{{ $keyIndex }}">
                                        Ödeme Detayı
                                    </button>
                                @endif



                            @endif

                            @if ($projectHousingsList[$keyIndex]['off_sale[]'] != '[]')
                                <button class="btn second-btn"
                                    style="background: #EA2B2E !important; width: 100%; color: White; height: auto !important">
                                    <span class="text">Satışa Kapatıldı</span>
                                </button>
                            @else
                                @if (
                                    ($sold && $sold->status != '2' && empty($share_sale)) ||
                                        (isset($sumCartOrderQt[$keyIndex]) && $sumCartOrderQt[$keyIndex]['qt_total'] == $number_of_share))
                                    <button class="btn second-btn"
                                        @if ($sold->status == '0') style="background: orange !important; color: White; height: auto !important" @else  style="background: #EA2B2E !important; color: White; height: auto !important" @endif>
                                        @if ($sold->status == '0' && empty($share_sale))
                                            <span class="text">Rezerve Edildi</span>
                                        @elseif (
                                            ($sold->status == '1' && empty($share_sale)) ||
                                                (isset($sumCartOrderQt[$keyIndex]) && $sumCartOrderQt[$keyIndex]['qt_total'] == $number_of_share))
                                            <span class="text">Satıldı</span>
                                        @endif
                                    </button>
                                @else
                                    <button class="CartBtn second-btn mobileCBtn" data-type='project'
                                        data-project='{{ $project->id }}' style="height: auto !important"
                                        data-id='{{ $keyIndex }}' data-share="{{ $share_sale }}"
                                        data-number-share="{{ $number_of_share }}">
                                        <span class="IconContainer">
                                            <img src="{{ asset('sc.png') }}" alt="">
                                        </span>
                                        <span class="text">Sepete Ekle</span>
                                    </button>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- Modal -->
<div class="modal fade" id="exampleModal{{ $keyIndex }}" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="exampleModalLabel">Başvuru Yap</h3>

            </div>
            <div class="modal-body">
                <!-- Modal içeriği -->
                <form method="POST" action="{{ route('give_offer') }}">
                    @csrf
                    {{-- {{ $i+1 }} --}}
                    <input type="hidden" value="{{ $keyIndex }}" name="roomId">
                    <input type="hidden" value="{{ $project->id }}" name="projectId">
                    <input type="hidden" value="{{ $project->user_id }}" name="projectUserId">
                    <div class="form-group">
                        <label for="surname" class="modal-label">Emailiniz : </label>
                        <input type="text" class="modal-input" id="email" name="email">
                    </div>
                    <div class="form-group">
                        <label for="offer_price" class="modal-label">Fiyat Aralığı (TL):</label>
                        <div class="input-group">
                            <input type="text" class="modal-input" id="offer_price_min" name="offer_price_min"
                                placeholder="Minimum" aria-label="Minimum Fiyat" aria-describedby="basic-addon2">
                            {{-- <div class="input-group-append">
                                        <span class="input-group-text modal-input" style="height: 10px" id="basic-addon2">-</span>
                                    </div> --}}
                            <input type="text" class="modal-input" id="offer_price_max" name="offer_price_max"
                                placeholder="Maksimum" aria-label="Maksimum Fiyat" aria-describedby="basic-addon2">
                        </div>
                    </div>


                    <div class="form-group">
                        <label for="comment" class="modal-label">Açıklama:</label>
                        <textarea class="modal-input" id="offer_description" rows="45" style="height: 130px !important;"
                            name="offer_description"></textarea>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="modal-btn-gonder">Gönder</button>
                        <button type="button" class="modal-btn-kapat" data-dismiss="modal">Kapat</button>
                    </div>
                </form>



            </div>

        </div>
    </div>
</div>
