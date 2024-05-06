@extends('client.layouts.master')

@section('content')
    <section class="recently portfolio bg-white homepage-5 ">
        <div class="container">
            <div class="header-search-box-page">

                @php
                    $totalCount = $projectTotalCount + $housingTotalCount + $merchant_count;
                @endphp

                <div class="mb-5" style="font-size:13px ">
                    <strong style="font-weight: bold !important">"{{$term}}"</strong> aramanız için <span style="color:#EA2B2E !important">  {{$totalCount}} </span>  sonuç bulundu. 
                </div>

                

                <div class="row">
                    <!-- plan start -->
                    <div class="col-lg-3 col-md-6 col-xs-12">
                        <div class="plan text-center">
                            <span class="plan-name">Emlak</span>
                            <p class="plan-price"><strong>{{ $housingTotalCount }}</strong><sub>Sonuç Bulundu</sub></p>
                            {{-- <p class="plan-price"><small>{{ $housingTotalCount }} İlan bulundu</small><sub></sub></p> --}}
                            <ul class="list-unstyled" id="housingList">
                                @php $count = 0 @endphp
                                @foreach ($housings as $step1_slug => $step1_data)
                                    @foreach ($step1_data as $step2_slug => $step2_data)
                                        @php $count++ @endphp
                                        <li class="housing-item"
                                            @if ($count > 3) style="display: none;" @endif>
                                            <a
                                                href="{{ url('/kategori/' . $step1_slug . '/' . $step2_slug . '?' . http_build_query(['term' => $term])) }}">
                                                {{ $step2_slug }}
                                                {{ $step1_slug }}<span>({{ $step2_data[0]['count'] }})</span>
                                            </a>
                                        </li>
                                    @endforeach
                                @endforeach
                            </ul>
                            @if ($count > 3)
                                <a class="btn btn-primary" href="#" id="showMore">Daha Fazlasını Gör</a>
                                <a class="btn btn-primary d-none" href="#" id="hideAll">Tümünü Kapat</a>
                            @endif
                        </div>
                    </div>


                    <div class="col-lg-3 col-md-6 col-xs-12">
                        <div class="plan text-center">
                            <span class="plan-name">Proje</span>

                            <p class="plan-price"><strong>{{ $projectTotalCount }}</strong><sub>Sonuç Bulundu</sub></p>

                            <ul class="list-unstyled" id="projectList">
                                @php $count = 0 @endphp
                                @foreach ($projects as $project)
                                    @php $count++ @endphp
                                    <li class="project-item"
                                        @if ($count > 3) style="display: none;" @endif>
                                        <a
                                            href="{{ url('/kategori/' . $project['status_slug'] . '?' . http_build_query(['term' => $term])) }}">
                                            {{ $project['name'] }}<span>({{ $project['count'] }})</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                            @if ($project['count'] > 3)
                                <a class="btn btn-primary" href="#" id="showMoreProjects">Daha Fazlasını Gör</a>
                            @endif
                            <a class="btn btn-primary d-none" href="#" id="hideAllProjects">Tümünü Kapat</a>
                        </div>
                    </div>


                    <div class="col-lg-3 col-md-6 col-xs-12">
                        <div class="plan text-center">
                            <span class="plan-name">Mağaza</span>
                            <p class="plan-price"><strong>{{ $merchant_count }}</strong><sub>Sonuç Bulundu</sub></p>

                            <ul class="list-unstyled" id="merchantList">
                                @php $visibleCount = 0 @endphp
                                @foreach ($merchants as $merchant)
                                    @php $visibleCount++ @endphp
                                    <li class="project-item"
                                        @if ($visibleCount > 3) style="display: none;" @endif>
                                        <a
                                            href="{{ url('/magaza/' . strtolower(str_replace(' ', '-', $merchant->name)) . '/' . $merchant['id']) }}">
                                            {{ $merchant['name'] }}<span></span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>

                            @if ($merchant_count > 3)
                                <a class="btn btn-primary" href="#" id="showMoreMerchants">Daha Fazlasını Gör</a>
                            @endif
                            <a class="btn btn-primary d-none" href="#" id="hideAllMerchants">Tümünü Kapat</a>
                        </div>
                    </div>



                    <!-- plan end -->
                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const showMoreBtn = document.getElementById('showMore');
            const hideAllBtn = document.getElementById('hideAll');
            const hiddenItems = document.querySelectorAll('.housing-item:nth-child(n+5)');

            if (showMoreBtn) {
                showMoreBtn.addEventListener('click', function() {
                    hiddenItems.forEach(item => {
                        item.style.display = 'list-item';
                    });
                    showMoreBtn.classList.add('d-none');
                    hideAllBtn.classList.remove('d-none');
                });
            }

            if (hideAllBtn) {
                hideAllBtn.addEventListener('click', function() {
                    hiddenItems.forEach(item => {
                        item.style.display = 'none';
                    });
                    hideAllBtn.classList.add('d-none');
                    showMoreBtn.classList.remove('d-none');
                });
            }
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const showMoreBtnProjects = document.getElementById('showMoreProjects');
            const hideAllBtnProjects = document.getElementById('hideAllProjects');
            const hiddenProjectItems = document.querySelectorAll('#projectList > .project-item:nth-child(n+4)');

            if (showMoreBtnProjects) {
                showMoreBtnProjects.addEventListener('click', function(event) {
                    event.preventDefault(); // Butonun varsayılan davranışını engeller

                    // Gizli öğeleri göster
                    hiddenProjectItems.forEach(item => {
                        item.style.display = 'list-item';
                    });

                    // Butonları göster/gizle
                    showMoreBtnProjects.classList.add('d-none');
                    hideAllBtnProjects.classList.remove('d-none');
                });
            }

            if (hideAllBtnProjects) {
                hideAllBtnProjects.addEventListener('click', function(event) {
                    event.preventDefault(); // Butonun varsayılan davranışını engeller

                    // Gizli öğeleri gizle
                    hiddenProjectItems.forEach(item => {
                        item.style.display = 'none';
                    });

                    // Butonları göster/gizle
                    hideAllBtnProjects.classList.add('d-none');
                    showMoreBtnProjects.classList.remove('d-none');
                });
            }
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const showMoreBtnMerchants = document.getElementById('showMoreMerchants');
            const hideAllBtnMerchants = document.getElementById('hideAllMerchants');
            const hiddenMerchantItems = document.querySelectorAll('#merchantList > .project-item:nth-child(n+4)');

            if (showMoreBtnMerchants) {
                showMoreBtnMerchants.addEventListener('click', function(event) {
                    event.preventDefault(); // Butonun varsayılan davranışını engeller

                    // Gizli öğeleri göster
                    hiddenMerchantItems.forEach(item => {
                        item.style.display = 'list-item';
                    });

                    // Butonları göster/gizle
                    showMoreBtnMerchants.classList.add('d-none');
                    hideAllBtnMerchants.classList.remove('d-none');
                });
            }

            if (hideAllBtnMerchants) {
                hideAllBtnMerchants.addEventListener('click', function(event) {
                    event.preventDefault(); // Butonun varsayılan davranışını engeller

                    // Gizli öğeleri gizle
                    hiddenMerchantItems.forEach(item => {
                        item.style.display = 'none';
                    });

                    // Butonları göster/gizle
                    hideAllBtnMerchants.classList.add('d-none');
                    showMoreBtnMerchants.classList.remove('d-none');
                });
            }
        });
    </script>
@endsection
