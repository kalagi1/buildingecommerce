@props([
    'project',
    'i',
    'projectHousingsList',
    'sold',
    'isUserSame',
    'lastHousingCount',
    'projectDiscountAmount',
    'bankAccounts',
])

<div class="col-md-12 col-12">
    <div class="project-card mb-3">
        <div class="row">
            <div class="col-md-3">
                <a href="{{ route('project.housings.detail', [$project->slug, $i + 1]) }}" style="height: 100%">
                    <div class="d-flex" style="height: 100%;">
                        <div style="background-color: #EA2B2E !important; border-radius: 0px 8px 0px 8px; height:100%">
                            <p
                                style="padding: 10px; color: white; height: 100%; display: flex; align-items: center; text-align:center; ">
                                No<br>{{ $i + 1 + $lastHousingCount }}
                            </p>
                        </div>
                        <div class="project-single mb-0 bb-0 aos-init aos-animate" data-aos="fade-up">
                            <div class="button-effect-div">
                                <span
                                    class="btn 
                                    @if (($sold && $sold->status == '1') || $projectHousingsList[$i + 1]['off_sale[]'] != '[]') disabledShareButton @else addCollection mobileAddCollection @endif"
                                    data-type='project' data-project='{{ $project->id }}'
                                    data-id='{{ $i + 1 }}'>
                                    <i class="fa fa-bookmark-o"></i>
                                </span>
                                <div href="javascript:void()" class="btn toggle-project-favorite bg-white"
                                    data-project-housing-id="{{ $i + 1 }}" data-project-id={{ $project->id }}>
                                    <i class="fa fa-heart-o"></i>
                                </div>
                            </div>
                            <div class="homes position-relative">
                                <img src="{{ URL::to('/') . '/project_housing_images/' . $projectHousingsList[$i + 1]['image[]'] }}"
                                    alt="home-1" class="img-responsive"
                                    style="height: 100px !important; object-fit: cover">
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-lg-9 col-md-9 homes-content pb-0 mb-44 aos-init aos-animate" data-aos="fade-up">
                <div class="row align-items-center justify-content-between mobile-position"
                    @if (($sold && $sold->status != '2') || $projectHousingsList[$i + 1]['off_sale[]'] != '[]') style="background: #EEE !important;" @endif>
                    <div class="col-md-9">
                        <div class="homes-list-div">
                            <ul class="homes-list clearfix pb-3 d-flex">
                                <li class="d-flex align-items-center itemCircleFont">
                                    <i class="fa fa-circle circleIcon mr-1" style="color: black;"
                                        aria-hidden="true"></i>
                                    <span>{{ $project->housingType->title }}</span>
                                    @foreach (['column1', 'column2', 'column3'] as $column)
                                        @php
                                            $column_name = $project->listItemValues->{$column . '_name'} ?? '';
                                            $column_additional = $project->listItemValues->{$column . '_additional'} ?? '';
                                            $column_name_exists = $column_name && isset($projectHousingsList[$i + 1][$column_name . '[]']);
                                        @endphp

                                        @if ($column_name_exists)
                                <li class="d-flex align-items-center itemCircleFont">
                                    <i class="fa fa-circle circleIcon mr-1" aria-hidden="true"></i>
                                    <span>
                                        {{ $projectHousingsList[$i + 1][$column_name . '[]'] }}
                                        @if ($column_additional)
                                            {{ $column_additional }}
                                        @endif
                                    </span>
                                </li>
                                @endif
                                @endforeach


                                <li class="the-icons mobile-hidden">
                                    <span>
                                        @php
                                            $off_sale_check = $projectHousingsList[$i + 1]['off_sale[]'] == '[]';
                                            $sold_check = $sold && in_array($sold->status, ['1', '0']);
                                            $discounted_price = $projectHousingsList[$i + 1]['price[]'] - $projectDiscountAmount;
                                        @endphp

                                        @if ($off_sale_check)
                                            @if ($sold_check)
                                                @if ($sold->status != '1' && $sold->status != '0')
                                                    @if ($projectDiscountAmount)
                                                        <h6
                                                            style="color: #274abb;position: relative;top:4px;font-weight:600;font-size:15px;">
                                                            {{ number_format($discounted_price, 0, ',', '.') }} ₺
                                                        </h6>
                                                        <h6
                                                            style="color: #e54242 !important;position: relative;top:4px;font-weight:600;font-size: 11px;text-decoration:line-through;">
                                                            {{ number_format($projectHousingsList[$i + 1]['price[]'], 0, ',', '.') }}
                                                            ₺
                                                        </h6>
                                                    @else
                                                        <h6
                                                            style="color: #274abb !important;position: relative;top:4px;font-weight:600">
                                                            {{ number_format($projectHousingsList[$i + 1]['price[]'], 0, ',', '.') }}
                                                            ₺
                                                        </h6>
                                                    @endif
                                                @else
                                                @endif
                                            @else
                                                @if ($projectDiscountAmount)
                                                    <h6
                                                        style="color: #274abb;position: relative;top:4px;font-weight:600;font-size:15px;">
                                                        {{ number_format($discounted_price, 0, ',', '.') }} ₺
                                                    </h6>
                                                    <h6
                                                        style="color: #e54242 !important;position: relative;top:4px;font-weight:600;font-size: 11px;text-decoration:line-through;">
                                                        {{ number_format($projectHousingsList[$i + 1]['price[]'], 0, ',', '.') }}
                                                        ₺
                                                    </h6>
                                                @else
                                                    <h6
                                                        style="color: #274abb !important;position: relative;top:4px;font-weight:600">
                                                        {{ number_format($projectHousingsList[$i + 1]['price[]'], 0, ',', '.') }}
                                                        ₺
                                                    </h6>
                                                @endif


                                            @endif
                                        @endif
                                    </span>
                                </li>

                            </ul>
                        </div>
                        <div class="footer">
                            <a
                                href="{{ route('institutional.profile', ['slug' => Str::slug($project->user->name), 'userID' => $project->user->id]) }}">
                                <img src="{{ url('storage/profile_images/' . $project->user->profile_image) }}"
                                    alt="" class="mr-2">
                                {{ $project->user->name }}
                            </a>
                            <span class="price-mobile">
                                @if ($projectHousingsList[$i + 1]['off_sale[]'] == '[]')
                                    @php $price = $projectHousingsList[$i + 1]['price[]']; @endphp
                                    @if ($sold && $sold->status != '1' && $sold->status != '0' && $projectDiscountAmount)
                                        <h6
                                            style="color: #274abb !important; position: relative; top: 4px; font-weight: 600; font-size: 11px; text-decoration: line-through; margin-right: 5px;">
                                            {{ number_format($price, 0, ',', '.') }} ₺
                                        </h6>
                                        <h6
                                            style="color: #274abb; position: relative; top: 4px; font-weight: 600; font-size: 20px;">
                                            {{ number_format($price - $projectDiscountAmount, 0, ',', '.') }} ₺
                                        </h6>
                                    @else
                                        <h6
                                            style="color: #274abb !important; position: relative; top: 4px; font-weight: 600;">
                                            {{ number_format($price, 0, ',', '.') }} ₺
                                        </h6>
                                    @endif
                                @endif
                            </span>
                        </div>
                    </div>

                    <div class="col-md-3 mobile-hidden" style="height: 100px; padding: 0">
                        <div class="homes-button" style="width: 100%; height: 100%">
                            @if ($sold_check && $sold->status == '1')
                                @php
                                  $neighborView = null;

if (Auth::check()) {
    $neighborView = App\Models\NeighborView::where('user_id', Auth::user()->id)
                                           ->where('order_id', $sold->id)
                                           ->first();
}
                                @endphp

                                @if (!$neighborView && $sold->status == '1' && isset($sold->is_show_user) && $sold->is_show_user == 'on' && !$isUserSame)
                                    <span class="first-btn see-my-neighbor" data-bs-toggle="modal"
                                        data-bs-target="#paymentModal" data-order="{{ $sold->id }}">
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
                                            250 TL Ödeme Onayı </span>
                                    </span>
                                @elseif($neighborView && $neighborView->status == '1')
                                <span class="first-btn see-my-neighbor success">
                                  <a href="tel: {{ $sold->phone }}" style="color:white">
                                    <span>
                                        Komşunuz: 
                                         {{ $sold->name }} <br>
                                         <svg viewBox="0 0 24 24" width="18" height="18" stroke="currentColor"
                                         stroke-width="2" fill="none" stroke-linecap="round"
                                         stroke-linejoin="round" class="css-i6dzq1">
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
                                @endif
                            @else
                                <button class="first-btn payment-plan-button" project-id="{{ $project->id }}"
                                    data-sold="{{ ($sold && ($sold->status == 1 || $sold->status == 0)) || $projectHousingsList[$i + 1]['off_sale[]'] != '[]' ? '1' : '0' }}"
                                    order="{{ $i + 1 }}">
                                    Ödeme Detayı
                                </button>
                            @endif

                            @if ($projectHousingsList[$i + 1]['off_sale[]'] != '[]')
                                <button class="btn second-btn"
                                    style="background: #EA2B2E !important; width: 100%; color: White; height: auto !important">
                                    <span class="text">Satışa Kapatıldı</span>
                                </button>
                            @else
                                @if ($sold && $sold->status != '2')
                                    <button class="btn second-btn"
                                        @if ($sold->status == '0') style="background: orange !important; color: White; height: auto !important" @else  style="background: #EA2B2E !important; color: White; height: auto !important" @endif>
                                        @if ($sold->status == '0')
                                            <span class="text">Onay Bekleniyor</span>
                                        @else
                                            <span class="text">Satıldı</span>
                                        @endif
                                    </button>
                                @else
                                    <button class="CartBtn second-btn mobileCBtn" data-type='project'
                                        data-project='{{ $project->id }}' style="height: auto !important"
                                        data-id='{{ $i + 1 }}'>
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
