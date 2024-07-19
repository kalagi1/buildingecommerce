@extends('client.layouts.masterPanel')
@section('content')
    <div class="content">
        <div class="row mb-3">
            <div class="col-xl-3 col-lg-3">
                <div class="card l-bg-red">
                    <div class="card-statistic-3" style="padding: 1rem 1rem ">
                        <div class="d-flex align-items-center">
                            <div class="divSvg">                            
                                <svg xmlns="http://www.w3.org/2000/svg" width="29" height="28" viewBox="0 0 37 23" fill="none">
                                    <path d="M25.7464 5.8036C25.7464 3.34142 23.8205 1.34717 21.4426 1.34717C19.0648 1.34717 17.1388 3.34142 17.1388 5.8036C17.1388 8.26578 19.0648 10.26 21.4426 10.26C23.8205 10.26 25.7464 8.26578 25.7464 5.8036ZM27.8984 8.03181V10.26H31.1262V13.6024H33.2781V10.26H36.506V8.03181H33.2781V4.68949H31.1262V8.03181H27.8984ZM12.835 16.9447V22.0002H29.0503C29.6026 22.0002 30.0503 21.5524 30.0503 21.0002V16.9447C30.0503 13.9811 24.3154 12.4882 21.4426 12.4882C18.5698 12.4882 12.835 13.9811 12.835 16.9447Z" fill="url(#paint0_linear_134_453)"/>
                                    <path d="M14.7632 5.57781C14.7632 2.78899 12.5772 0.5 9.8421 0.5C7.10705 0.5 4.92105 2.78899 4.92105 5.57781C4.92105 8.36663 7.10705 10.6556 9.8421 10.6556C12.5772 10.6556 14.7632 8.36663 14.7632 5.57781ZM0.5 17.0223V21C0.5 21.8284 1.17157 22.5 2 22.5H17.6842C18.5126 22.5 19.1842 21.8284 19.1842 21V17.0223C19.1842 16.0842 18.7265 15.2953 18.0631 14.6613C17.4037 14.0311 16.5137 13.525 15.5614 13.13C13.6582 12.3405 11.3825 11.9445 9.8421 11.9445C8.30173 11.9445 6.02603 12.3405 4.12283 13.13C3.17046 13.525 2.28055 14.0311 1.62114 14.6613C0.957737 15.2953 0.5 16.0842 0.5 17.0223Z" fill="url(#paint1_linear_134_453)" stroke="white"/>
                                    <defs>
                                    <linearGradient id="paint0_linear_134_453" x1="24.6705" y1="20.07" x2="24.6705" y2="-24.3243" gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#EA2B2E"/>
                                    <stop offset="1" stop-color="#84181A"/>
                                    </linearGradient>
                                    <linearGradient id="paint1_linear_134_453" x1="9.84211" y1="20.0374" x2="9.84211" y2="-25.1028" gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#EA2B2E"/>
                                    <stop offset="1" stop-color="#84181A"/>
                                    </linearGradient>
                                    </defs>
                                    </svg>
                            </div>
                            <div>
                                <span class="ml-3 mb-2 text-white">Toplam Müşteri</span>
                                <h2 class=" ml-3 d-flex align-items-center mb-0 text-white">{{ $totalCustomers }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3">
                <div class="card l-bg-red">
                    <div class="card-statistic-3" style="padding: 1rem 1rem ">
                        <div class="d-flex align-items-center">
                            <div class="divSvg">                            
                                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="28" viewBox="0 0 31 31" fill="none">
                                    <g clip-path="url(#clip0_134_396)">
                                    <path d="M10.3356 10.3332C10.3356 7.4797 12.6497 5.1665 15.5042 5.1665C18.3588 5.1665 20.6729 7.4797 20.6729 10.3332C20.6729 13.1866 18.3588 15.4998 15.5042 15.4998C14.1334 15.4998 12.8188 14.9555 11.8495 13.9866C10.8802 13.0176 10.3356 11.7035 10.3356 10.3332ZM25.6993 23.9603L23.8386 20.2273C23.1812 18.9109 21.8346 18.0803 20.3627 18.0832H10.6457C9.17383 18.0803 7.82728 18.9109 7.16983 20.2273L5.30913 23.9603C5.10759 24.36 5.12752 24.8357 5.3618 25.2172C5.59608 25.5987 6.01129 25.8318 6.45914 25.8332H24.5493C24.9972 25.8318 25.4124 25.5987 25.6467 25.2172C25.8809 24.8357 25.9009 24.36 25.6993 23.9603Z" fill="url(#paint0_linear_134_396)"/>
                                    <circle cx="22.2812" cy="24.2188" r="3.875" fill="white"/>
                                    <path d="M22.7656 21.3125C20.894 21.3125 19.375 22.8315 19.375 24.7031C19.375 26.5748 20.894 28.0938 22.7656 28.0938C24.6373 28.0938 26.1563 26.5748 26.1563 24.7031C26.1563 22.8315 24.6373 21.3125 22.7656 21.3125ZM22.0875 26.3984L20.3922 24.7031L20.8703 24.225L22.0875 25.4389L24.661 22.8654L25.1391 23.3469L22.0875 26.3984Z" fill="url(#paint1_linear_134_396)"/>
                                    </g>
                                    <defs>
                                    <linearGradient id="paint0_linear_134_396" x1="15.5042" y1="23.9017" x2="15.5042" y2="-20.522" gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#EA2B2E"/>
                                    <stop offset="1" stop-color="#84181A"/>
                                    </linearGradient>
                                    <linearGradient id="paint1_linear_134_396" x1="22.7656" y1="27.46" x2="22.7656" y2="12.8835" gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#EA2B2E"/>
                                    <stop offset="1" stop-color="#84181A"/>
                                    </linearGradient>
                                    <clipPath id="clip0_134_396">
                                    <rect width="31" height="31" fill="white"/>
                                    </clipPath>
                                    </defs>
                                    </svg>
                            </div>
                            <div>
                                <span class="ml-3 mb-2 text-white">Olumlu Müşteri</span>
                                <h2 class=" ml-3 d-flex align-items-center mb-0 text-white">{{ $positiveCustomersCount }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3">
                <div class="card l-bg-red">
                    <div class="card-statistic-3" style="padding: 1rem 1rem ">
                        <div class="d-flex align-items-center">
                            <div class="divSvg">                            
                                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="28" viewBox="0 0 32 32" fill="none">
                                    <g clip-path="url(#clip0_133_200)">
                                    <path d="M10.6682 10.6668C10.6682 7.72131 13.0569 5.3335 16.0036 5.3335C18.9502 5.3335 21.3389 7.72131 21.3389 10.6668C21.3389 13.6123 18.9502 16.0002 16.0036 16.0002C14.5886 16.0002 13.2315 15.4383 12.2309 14.4381C11.2303 13.4379 10.6682 12.0813 10.6682 10.6668ZM26.5276 24.7335L24.6068 20.8802C23.9282 19.5213 22.5382 18.6638 21.0188 18.6668H10.9884C9.46897 18.6638 8.07898 19.5213 7.40033 20.8802L5.4796 24.7335C5.27156 25.1462 5.29214 25.6371 5.53397 26.031C5.77581 26.4248 6.20442 26.6654 6.66672 26.6668H25.3404C25.8027 26.6654 26.2314 26.4248 26.4732 26.031C26.715 25.6371 26.7356 25.1462 26.5276 24.7335Z" fill="url(#paint0_linear_133_200)"/>
                                    <circle cx="25.5" cy="23.5" r="4.5" fill="white"/>
                                    <g clip-path="url(#clip1_133_200)">
                                    <path d="M26.4955 20.2915V19.2419C26.4946 19.1798 26.5195 19.1201 26.5643 19.0769L26.656 18.9853C26.6991 18.9419 26.7578 18.9175 26.8189 18.9175C26.8801 18.9175 26.9387 18.9419 26.9818 18.9853L28.606 20.6032C28.694 20.6938 28.694 20.8379 28.606 20.9286L26.9818 22.5465C26.9387 22.5899 26.8801 22.6143 26.8189 22.6143C26.7578 22.6143 26.6991 22.5899 26.656 22.5465L26.5643 22.4549C26.5195 22.4117 26.4946 22.352 26.4955 22.2899V21.2082C25.0036 21.2126 23.7867 22.4033 23.7515 23.8932C23.7162 25.3831 24.8755 26.63 26.3655 26.7047C27.8555 26.7795 29.134 25.655 29.2483 24.169C29.2579 24.0497 29.3579 23.9578 29.4777 23.9582H29.9366C30.0007 23.9588 30.0619 23.9853 30.1063 24.0315C30.148 24.0778 30.1695 24.1389 30.166 24.2011C30.0338 26.1891 28.3367 27.708 26.344 27.6214C24.3514 27.5348 22.7926 25.8745 22.8338 23.8825C22.875 21.8905 24.501 20.2959 26.4955 20.2915Z" fill="url(#paint1_linear_133_200)"/>
                                    </g>
                                    </g>
                                    <defs>
                                    <linearGradient id="paint0_linear_133_200" x1="16.0036" y1="24.6731" x2="16.0036" y2="-21.1836" gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#EA2B2E"/>
                                    <stop offset="1" stop-color="#84181A"/>
                                    </linearGradient>
                                    <linearGradient id="paint1_linear_133_200" x1="26.4997" y1="26.8111" x2="26.4997" y2="8.09424" gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#EA2B2E"/>
                                    <stop offset="1" stop-color="#84181A"/>
                                    </linearGradient>
                                    <clipPath id="clip0_133_200">
                                    <rect width="32" height="32" fill="white"/>
                                    </clipPath>
                                    <clipPath id="clip1_133_200">
                                    <rect width="11" height="11" fill="white" transform="translate(21 18)"/>
                                    </clipPath>
                                    </defs>
                                    </svg>
                            </div>
                            <div>
                                <span class="ml-3 mb-2 text-white">Geri Dönülecek Müşteri</span>
                                <h2 class=" ml-3 d-flex align-items-center mb-0 text-white">{{ $geri_donus_yapilacak_musterilerCount }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3">
                <div class="card l-bg-red">
                    <div class="card-statistic-3" style="padding: 1rem 1rem ">
                        <div class="d-flex align-items-center">
                            <div class="divSvg">                            
                                <svg width="26" height="28" viewBox="0 0 32 33" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_134_365)">
                                        <path d="M9.33132 9.625C9.33132 6.58743 11.72 4.125 14.6667 4.125C17.6133 4.125 20.002 6.58743 20.002 9.625C20.002 12.6626 17.6133 15.125 14.6667 15.125C13.2516 15.125 11.8946 14.5455 10.894 13.5141C9.89343 12.4826 9.33132 11.0837 9.33132 9.625ZM25.1906 24.1313L23.2699 20.1575C22.5913 18.7562 21.2013 17.8719 19.6819 17.875H9.65144C8.13206 17.8719 6.74207 18.7562 6.06341 20.1575L4.14269 24.1313C3.93465 24.5568 3.95522 25.0631 4.19706 25.4693C4.43889 25.8754 4.8675 26.1236 5.3298 26.125H24.0035C24.4658 26.1236 24.8944 25.8754 25.1363 25.4693C25.3781 25.0631 25.3987 24.5568 25.1906 24.1313Z" fill="url(#paint0_linear_134_365)"/>
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M22.3056 28.5584C20.3758 28.5582 16.7734 24.6628 16.7734 22.737C16.7734 20.8112 18.3378 19.25 20.2675 19.25C21.0347 19.25 21.7442 19.4968 22.3206 19.9152C22.8915 19.4963 23.5898 19.25 24.3438 19.25C26.2735 19.25 27.8379 20.8632 27.8379 22.8532C27.8379 24.8432 24.2354 28.5582 22.3057 28.5584" fill="white"/>
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M22.2477 26.8125C20.965 26.8125 18.5703 24.223 18.5703 22.9429C18.5703 21.6628 19.6102 20.625 20.8929 20.625C21.403 20.625 21.8747 20.7891 22.2579 21.0673C22.6374 20.7888 23.1016 20.625 23.603 20.625C24.8857 20.625 25.9255 21.6973 25.9255 23.0202C25.9255 24.343 23.5308 26.8125 22.2481 26.8125C22.2481 26.8125 22.248 26.8123 22.2479 26.812C22.2478 26.8123 22.2477 26.8125 22.2477 26.8125Z" fill="url(#paint1_linear_134_365)"/>
                                    </g>
                                    <defs>
                                        <linearGradient id="paint0_linear_134_365" x1="14.6667" y1="24.0689" x2="14.6667" y2="-23.2208" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="#EA2B2E"/>
                                            <stop offset="1" stop-color="#84181A"/>
                                        </linearGradient>
                                        <linearGradient id="paint1_linear_134_365" x1="22.2479" y1="26.2342" x2="22.2479" y2="12.934" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="#EA2B2E"/>
                                            <stop offset="1" stop-color="#84181A"/>
                                        </linearGradient>
                                        <clipPath id="clip0_134_365">
                                            <rect width="32" height="33" fill="white"/>
                                        </clipPath>
                                    </defs>
                                </svg>
                            </div>
                            <div>
                                <span class="ml-3 mb-2 text-white">Favori Müşteri</span>
                                <h2 class=" ml-3 d-flex align-items-center mb-0 text-white">{{ $favoriteCustomers }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>   
        
        <div class="row mb-3" style="margin-left:0px; ">
            <div class="col-md-6 bestDiv">
                <h5>Olumlu Müşteri Sayıları</h5><hr>
                <canvas id="salesChart"></canvas>
            </div>
            <div class="col-md-5  bestDiv" >
                <h5>En İyi Danışmanlar</h5><hr>
                <div class="row">
                    <div class="col-md-6">
                        <div class="cardDanisman">
                            <div class="card-title">En Çok Arama Yapan</div>
                            <div class="card-body">
                                <hr style="clear: both;">
                                <span class="medal-icon">🏅</span>
                                <div class="text-center" style="border-radius: 55%;">
                                    {{-- <img src="{{asset('woman.png')}}" class="danismanImg"> --}}
                                    <img src="{{ asset('storage/profile_images/' . $topCaller->profile_image ) }}" class="danismanListImg">
                                </div>
                                <p class="text-center">{{$topCaller->name}} </p>
                                <p class="text-center" style="background: linear-gradient(to top, #EA2B2E, #84181A) !important;color:white; border-radius: 7px;  margin-top: 10px !important;">
                                    {{$danisman->total_calls}} Arama
                                </p>
                            </div>
                        </div>
                        
                    </div>
                    <div class="col-md-6">
                        <div class="cardDanisman">
                            <div class="card-title">En Çok Satış Yapan</div>
                            <hr style="clear: both;">
                            <span class="medal-icon">🏅</span>
                            <div class="card-body">
                                <div class="text-center" style="border-radius: 55%">
                                    {{-- <img src="{{asset('man.jpg')}}" class="danismanImg"> --}}
                                    <img src="{{ asset('storage/profile_images/' . $enCokSatisYapan->profile_image ) }}" class="danismanListImg">

                                </div>
                                <p class="text-center">{{ $enCokSatisYapan ? $enCokSatisYapan->name : '' }}</p>
                                <p class="text-center" style="background: linear-gradient(to top, #EA2B2E, #84181A) !important;color:white; border-radius: 7px; margin-top: 10px !important;">
                                    {{ $enCokSatisYapan && $enCokSatisYapan->satis_sayisi ? $enCokSatisYapan->satis_sayisi : '' }} Adet Satış
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @php
            $awards = App\Models\Award::latest()->take(3)->get();
            $allInactive = $awards->every(function ($award) {
                return $award->status == 0;
            });
        @endphp
        
        @if(!$allInactive)
            <div class="row">
                @foreach($awards as $award)
                    @if($award->status == 1)
                        <div class="col-md-4">
                            <div style="position: relative;">
                                <img src="{{ asset('odul.jpeg') }}" alt="Ödül Arka Plan">
                                <img src="{{ asset('awards/' . $award->award_image) }}" alt="{{ $award->title }}" style="position: absolute; top: 30%; left: 55%; transform: translate(-50%, -50%); max-width: 80%; max-height: 80%;">
                                <h4 style="position: absolute; bottom: 65px; left: 135px; color: white; z-index: 10;font-size:14px;">{{ $award->title }}</h4>
                                <h4 style="position: absolute; bottom: 35px; left: 135px; color: white; z-index: 10;font-size:13px;">{{ $award->award_name }}</h4>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        @endif   

        <div id="danismanCarousel" class="row bestDiv mb-3 carousel slide" style="padding: 0px 20px 40px 0px" data-ride="carousel">
            <div class="carousel-inner" style="border: none;">
                @foreach ($satisDanismanlari->chunk(4) as $chunkIndex => $danismanChunk)
                    <div class="carousel-item {{ $chunkIndex == 0 ? 'active' : '' }}">
                        <div class="row mb-3 bestDiv" style="padding: 45px 35px;border:none;">
                            @foreach ($danismanChunk as $danisman)
                                <div class="col-md-3">
                                    <div class="cardDanismanList">
                                        <div class="card-body">
                                            <div class="text-center" style="border-radius: 55%">
                                                {{-- <img src="{{ asset('woman.png') }}" class="danismanListImg"> --}}
                                                <img src="{{ asset('storage/profile_images/' . $danisman->profile_image ) }}" class="danismanListImg">
                                            </div>
                                            <p class="text-center" style="font-size: 16px; font-weight:400; color:#1b1b1b">{{ $danisman->name }}</p>
                                            <p class="text-center" style="color: #8b8b8b">Referans Kodu</p>
                                            <p class="text-center" style="color: #8b8b8b">#{{$danisman->code}}</p>
                                            <div class="stats-section mt-4">
                                                <div class="row">
                                                    <div class="col-6 border-right border-top">
                                                        <div class="stat-item">
                                                            <span>Toplam Satış Adedi</span>
                                                            <h3>{{ $danismanVerileri[$danisman->id]['satis_sayisi'] }}</h3>
                                                        </div>
                                                    </div>
                                                    <div class="col-6 border-top">
                                                        <div class="stat-item">
                                                            <span>Arama Sayısı</span>
                                                            <h3>{{ $danismanVerileri[$danisman->id]['arama_sayisi'] }}</h3>
                                                        </div>
                                                    </div>
                                                    <div class="col-6 border-right border-top">
                                                        <div class="stat-item">
                                                            <span>Müşteri Sayısı</span>
                                                            <h3>{{ $danismanVerileri[$danisman->id]['musteri_sayisi'] }}</h3>
                                                        </div>
                                                    </div>
                                                    <div class="col-6 border-top">
                                                        <div class="stat-item">
                                                            <span>Dönüş Yapılan Müşteri</span>
                                                            <h3>{{ $danismanVerileri[$danisman->id]['donus_yapilan_musteri'] }}</h3>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
            <a class="carousel-control-prev" href="#danismanCarousel" role="button" data-slide="prev">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" width="38" height="38" style=" background-color: gainsboro;border-radius: 50%;padding: 7px;"><path d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l192 192c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L77.3 256 246.6 86.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-192 192z"/></svg>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#danismanCarousel" role="button" data-slide="next">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" width="38" height="38" style=" background-color: gainsboro;border-radius: 50%;padding: 7px;"><path d="M310.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L242.7 256 73.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z"/></svg>
                <span class="sr-only">Next</span>
            </a>            
        </div>
        
        <div class="row" style="margin-left:-3px;">
            <div class="col-md-6">
                <div id="totalSalesPieChart" class="chart-container" style="width: 98%; height: 250px;"></div>
            </div>
            <div class="col-md-6">
                <div id="salesTypePieChart" class="chart-container" style="width: 98%; height: 250px;"></div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 bestDiv">
                <h5>Satışlarım</h5><hr>
                <table class="table align-middle mb-0 bg-white">
                    <thead class="">
                        <tr>
                            <th>Müşteri Adı</th>
                            <th>İlan Kodu</th>
                            <th>Ödenecek Miktar</th>
                            <th>Ödeme Şekli</th>
                            <th>Ödeme Durumu</th>
                            <th>Tarih </th>
                            <th>Kazancım </th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($danismanSatislari->isNotEmpty())
                            @foreach ($danismanSatislari as $authSale)
                                @php
                                    $cart = json_decode(($authSale->cart));
                                    $musteri =App\Models\User::find( $authSale->user_id);
                                @endphp
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                             {{-- <img src="https://mdbootstrap.com/img/new/avatars/8.jpg" alt="" style="width: 30px; height: 30px" class="rounded-circle" />
                                              --}}
                                            <img src="{{ asset('storage/profile_images/' . $musteri->profile_image ?: 'woman.png') }}" style="width: 30px; height: 30px" class="rounded-circle">

                                            <p class="fw-bold ml-5">{{ $musteri->name }}</p>
                                        </div>
                                    </td>
                                    <td>
                                        @if(isset($cart->type->housing))
                                            {{ $cart->item->id + 2000000 }}
                                        @else
                                            {{ $cart->item->id + 1000000 }}
                                        @endif
                                    </td>
                                    <td><span class="badge badge-success rounded-pill d-inline" style="font-size: 10px">{{ $authSale->amount }}</span></td>
                                    <td>
                                        @if($authSale->is_swap == 0)
                                            Peşin
                                        @else
                                            @if(isset($cart->item->taksitSayisi))
                                                {{ $cart->item->taksitSayisi }} Ay Taksit
                                            @else
                                                Taksit
                                            @endif                          
                                        @endif
                                    </td>
                                    <td>
                                        @if ($authSale->status == 1)
                                            <button class="btn btn-success btnOdemeDurumu"> Ödeme Yapıldı </button>
                                        @elseif ($authSale->status == 0)
                                            <button class="btn btn-warning btnOdemeDurumu"> Bekleniyor</button>
                                        @else
                                            <button class="btn btn-warning btnOdemeDurumu"> Sipariş İptal </button>
                                        @endif
                                    </td>
                                    <td>{{ date('d-m-Y H:i:s', strtotime($authSale->created_at)) }}</td>
                                    <td>{{ number_format($satisKazanc[$authSale->id], 2) }} TL</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="7">Henüz Satışınız Bulunmamaktadır...</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
            
    </div>    
    
@endsection

@section('styles')

    <style>
        .carousel-control-prev , .carousel-control-next{
            width: 6% !important;
        } 
        .medal-icon {
            font-size: 27px;
            line-height: 0; /* Ensures the icon doesn't affect the vertical alignment */
            margin-right: 120px;
        }

        .cardGift {
            width: 100%;
            height: 55%;
            border-radius: 10px;
            background: linear-gradient(332deg, #EA2B2E, #84181A 50%, #ffffff 50%);
            flex-direction: column; /* İçerikleri dikey yönde hizalar */
            justify-content: center;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            color: #ffffff;
            position: relative;
        }
        .card-headerGift {
            display: flex;
            justify-content: space-between;
            color: #000;
            background: white;
        }

        .icon {
            font-size: 24px;
        }

        .title {
            font-size: 18px;
            font-weight: bold;
        }

        .menu {
            font-size: 24px;
            top: -60px;
            right: -118px;
        }

        .card-bodyGift {
            text-align: center;
            margin-top: 20px;
        }

        .main-gift {
            position: relative;
            top: -131px;
            left: -101px;
            width: 100px;
        }

        .small-gift {
            width: 50px;
            position: absolute;
            bottom: 20px;
            left: 20px;
        }

        .text {
            font-size: 16px;
        }

        .reward {
            font-size: 24px;
            font-weight: bold;
        }
    </style>

    <style>
        .btnOdemeDurumu{
            border-radius: 8px !important;
            padding: 5px !important;
            
        }
        .table {
            border-top: 2px solid #ccc;
        }

        .table tbody tr {
            border: none;
        }

        .table thead {
            border-bottom: 2px solid #ccc;
        }

        .table thead th {
            border: none;
        }

        .table td, .table th {
            border: none !important;
        }
        .chart-container {
            margin-bottom: 20px; /* Mesafe */
            border-radius: 10px; /* Köşe yuvarlama */
            border: 1px solid #ccc; /* Kenar çizgisi */
            padding: 10px; /* İçerik boşluğu */
            background: rgb(255, 255, 255);
            text-align: center;
        }
        .card {
            padding: 1px !important;
            background-color: #fff !important;
            border-radius: 10px;
            border: none;
            position: relative;
            margin-bottom: 30px;
            width: 95%;
            box-shadow: 0 0.46875rem 2.1875rem rgba(90,97,105,0.1), 0 0.9375rem 1.40625rem rgba(90,97,105,0.1), 0 0.25rem 0.53125rem rgba(90,97,105,0.12), 0 0.125rem 0.1875rem rgba(90,97,105,0.1);
        }

        .l-bg-red {
            background: linear-gradient(to top, #EA2B2E, #84181A) !important;
            color: #fff;
        }

        .card .card-statistic-3 .card-icon {
            text-align: center;
            line-height: 50px;
            margin-right: 15px; /* Sağa boşluk verildi */
            color: #000;
            /* opacity: 0.1; */
            font-size: 40px;
            background-color: white;
            border-radius: 50%;
        }

        .divSvg{
            background-color: #ffffff;
            padding: 11px;
            border-radius: 55%;
            margin: 5px;
        }
        .danismanImg{
            max-width: 54%;
            height: 100px;
            border-radius: 45%;
        }
        .danismanListImg{
            max-width: 54%;
            height: 100px;
            border-radius: 45%;
            position: relative;
            top: -18px;
            border-top: 1px solid #EA2B2E;
        }

        .cardDanisman{
            padding: 20px;
            border: 1px solid rgb(206, 206, 206);
            border-radius: 10px;
            text-align: center;
        }
        .cardDanismanList{
            padding: 0px 20px;
            border-top: 1px solid #EA2B2E; /* Top border color */
            border-bottom: 1px solid #EA2B2E; /* Bottom border color */
            border-left: 1px solid #84181A; /* Left border color */
            border-right: 1px solid #84181A; 
            border-radius: 10px;
            text-align: center;
            width: 110%;
        }
        .btnDanisman{
            background: linear-gradient(to top, #EA2B2E, #84181A) !important;
            color: #ffffff;
            border-color: #EA2B2E !important;
            padding: 5px 25px;
            border-radius: 6px !important; 
            margin-top:5px;
        }
        p{
            margin:-5px !important;
        }
    
        .bestDiv{
            background-color: #ffffff;
            padding: 20px;
            border: 1px solid rgb(206, 206, 206);
            border-radius: 15px;
            margin: 10px;
        }

        .cardDanismanList .stats-section {
            margin-top: 20px;
            padding-top: 20px;
        }

        .cardDanismanList .stats-section .col-6{
            padding: 10px;
        }

        .cardDanismanList .stats-section .border-right{
            border-right: 1px solid #ddd;
        }

        .cardDanismanList .stats-section .border-top{
            border-top: 1px solid #ddd;
        }

        .cardDanismanList .stat-item {
            text-align: center;
            margin-bottom: 15px;
        }

        .cardDanismanList .stat-item span {
            white-space: nowrap;
            color: #797979;
            font-size: 9px !important; 
        }

        .cardDanismanList .stat-item h3 {
            color: #1b1b1b;
            font-size: 13px !important; 
            margin: 5px 0 0;
        }
        .cardDanismanList .stat-item:not(:last-child) {
            border-bottom: 1px solid #ddd; /* Add bottom border to all but last item */
        }

    </style>
@endsection
@section('scripts')
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawCharts);
  
        function drawCharts() {
            // PHP değişkenlerini JavaScript'e aktar
            var totalKazanc = {{$totalKazanc ?? 0}};
            var pesinSatisSayisi = {{$pesinSatisSayisi ?? 0}};
            var taksitliSatisSayisi = {{$taksitliSatisSayisi ?? 0}};
  
            // Toplam satışlar için pasta grafik verisi ve ayarları
            var totalSalesData;
            var totalSalesOptions;
  
            if (totalKazanc === 0) {
                totalSalesData = google.visualization.arrayToDataTable([
                    ['Satış Türü', 'Miktar'],
                    ['Satış Yok', 1] // Grafik 0 olarak gösterilecektir
                ]);
                totalSalesOptions = {
                    title: 'Toplam Satış',
                    pieSliceText: 'label',
                    slices: {
                        0: { color: '#e5e5e5', textStyle: {color: 'black'} } // Grafik rengi ghostwhite ve yazı rengi siyah
                    }
                };
            } else {
                totalSalesData = google.visualization.arrayToDataTable([
                    ['Satış Türü', 'Miktar'],
                    ['Toplam Kazancım', totalKazanc]
                ]);
                totalSalesOptions = {
                    title: 'Toplam Satış',
                    pieSliceText: 'value',
                    slices: {
                        0: { color: '#EA2B2E' } // Kırmızı tonu
                    }
                };
            }
  
            var totalSalesChart = new google.visualization.PieChart(document.getElementById('totalSalesPieChart'));
            totalSalesChart.draw(totalSalesData, totalSalesOptions);
  
            // Satış türleri için pasta grafik verisi ve ayarları
            var salesTypeData;
            var salesTypeOptions;
  
            if (pesinSatisSayisi === 0 && taksitliSatisSayisi === 0) {
                salesTypeData = google.visualization.arrayToDataTable([
                    ['Satış Türü', 'Miktar'],
                    ['Satış Yok', 1] // Grafik 0 olarak gösterilecektir
                ]);
                salesTypeOptions = {
                    title: 'Satış Türü',
                    pieSliceText: 'label',
                    slices: {
                        0: { color: '#e5e5e5', textStyle: {color: 'black'} } // Grafik rengi ghostwhite ve yazı rengi siyah
                    }
                };
            } else {
                salesTypeData = google.visualization.arrayToDataTable([
                    ['Satış Türü', 'Miktar'],
                    ['Peşin Satış', pesinSatisSayisi],
                    ['Taksitli Satış', taksitliSatisSayisi]
                ]);
                salesTypeOptions = {
                    title: 'Satış Türü',
                    pieSliceText: 'value',
                    slices: {
                        0: { color: '#EA2B2E' }, // Kırmızı tonu
                        1: { color: '#FF8E90' }  // Kırmızı tonu
                    }
                };
            }
  
            var salesTypeChart = new google.visualization.PieChart(document.getElementById('salesTypePieChart'));
            salesTypeChart.draw(salesTypeData, salesTypeOptions);
        }
    </script>

    <script>
    document.addEventListener("DOMContentLoaded", function() {
    // Canvas elementini seçin
    var ctx = document.getElementById('salesChart').getContext('2d');
    var labels = @json($satisDanismanlari->pluck('name'));
    var data = @json(array_values($olumluMusteriSayilari));

        // Eğer data boşsa, tüm değerleri sıfır olarak doldurun
        if (data.length === 0) {
            data = Array(labels.length).fill(0);
        }

    var salesData = {
        labels: labels,
        datasets: [{
            label: 'Olumlu Müşteri Sayıları',
            data: data,
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
            ],
            borderWidth: 1
        }]
    };

    // Grafik ayarlarını tanımlayın
    var salesChart = new Chart(ctx, {
        type: 'bar',
        data: salesData,
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
    });
    </script>

@endsection