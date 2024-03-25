@extends('client.layouts.master')

@section('content')

    <x-store-card :store="$institutional" />



    <section class="properties-right featured portfolio blog bg-white">
        <div class="container">
            @if (count($institutional->projects))
                <div class="properties-right list featured portfolio blog pb-5 pt-3 bg-white">
                    <div class="row">

                        @php
                            function addQueryParamToUrl($paramName, $paramValue)
                            {
                                $queryParams = request()->query();
                                $queryParams[$paramName] = $paramValue;

                                return request()->url() . '?' . http_build_query($queryParams);
                            }

                            $counts = [
                                'devam-eden-projeler' => 0,
                                'tamamlanan-projeler' => 0,
                                'topraktan-projeler' => 0,
                            ];
                        @endphp
                        @php
                            $filter = request('filter', 'tumu');
                        @endphp
                        @foreach ($institutional->projects as $project)
                            @php
                                $statusID =
                                    $project->housingStatus->where('housing_type_id', '<>', 1)->first()
                                        ->housing_type_id ?? 1;

                                $statusSlug = App\Models\HousingStatus::find($statusID)->slug;
                            @endphp
                            @if (in_array($statusSlug, ['devam-eden-projeler', 'tamamlanan-projeler', 'topraktan-projeler']))
                                @php
                                    $counts[$statusSlug]++;
                                @endphp
                            @endif
                        @endforeach
                        <div class="col-md-12">
                            <div class="tabbed-content button-tabs mb-3">
                                <ul class="tabs">
                                    <li class="nav-item-block {{ $filter === 'tumu' ? 'active' : '' }}">
                                        <a href="{{ addQueryParamToUrl('filter', 'tumu') }}">
                                            <div class="tab-title">
                                                <span>Tüm Projeler</span>
                                            </div>
                                        </a>
                                    </li>
                                    @foreach ($counts as $slug => $count)
                                        <li class="nav-item-block {{ $filter === $slug ? 'active' : '' }}"
                                            role="presentation">

                                            <a href="{{ addQueryParamToUrl('filter', $slug) }}">
                                                <div class="tab-title">
                                                    <span>
                                                        @if ($slug == 'devam-eden-projeler')
                                                            Devam Eden Projeler
                                                        @elseif($slug == 'tamamlanan-projeler')
                                                            Tamamlanan Projeler
                                                        @elseif($slug == 'topraktan-projeler')
                                                            Topraktan Projeler
                                                        @endif
                                                        ({{ $count }})
                                                    </span>
                                                </div>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="row project-filter-reverse blog-pots finish-projects-web">
                        @foreach ($institutional->projects as $project)
                            @php
                                $statusID =
                                    $project->housingStatus->where('housing_type_id', '<>', 1)->first()
                                        ->housing_type_id ?? 1;

                                $statusSlug = App\Models\HousingStatus::find($statusID)->slug;
                            @endphp
                            @if (
                                $filter === 'tumu' ||
                                    ($filter === 'devam-eden-projeler' && $statusSlug === 'devam-eden-projeler') ||
                                    ($filter === 'tamamlanan-projeler' && $statusSlug === 'tamamlanan-projeler') ||
                                    ($filter === 'topraktan-projeler' && $statusSlug === 'topraktan-projeler'))
                                <x-project-card :project="$project" />
                            @endif
                        @endforeach
                    </div>
                </div>
            @else
                <div class="row justify-content-center">
                    <div class="col-md-8 text-center">
                        <h2 class="mt-5 mb-3">Mağazaya ait proje kaydı bulunamadı.</h2>
                        <p>Lütfen daha sonra tekrar deneyin veya başka bir arama yapın.</p>
                    </div>
                </div>
            @endif

        </div>
    </section>




@endsection

@section('scripts')
    <script>
        'use strict';
        $('#search-project').on('input', function() {
            let val = $(this).val();
            $('.project-item').each(function() {
                if ($(this).data('title').toLowerCase().search(val) == -1)
                    $(this).addClass('d-none');
                else
                    $(this).removeClass('d-none');
            });
        });
    </script>
@endsection

@section('styles')
    <style>
        .projectMobileMargin {
            margin-bottom: 20px !important;
        }
    </style>
@endsection
