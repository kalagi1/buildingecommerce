@extends('client.layouts.master')

@section('content')

<x-store-card :store="$institutional" />





    <section class="properties-right featured portfolio blog pt-5 bg-white">
        <div class="container">
                @if (count($institutional->projects))
                    <div class="properties-right list featured portfolio blog pb-5 bg-white">
                        <div class="container">
                            <div class="row project-filter-reverse blog-pots finish-projects-web">
                                @foreach ($institutional->projects as $project)
                                    <x-project-card :project="$project" />
                                @endforeach
                            </div>
                        </div>
                    </div>
                @else
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-8 text-center">
                            <h2 class="mt-5 mb-3">Mağazaya ait proje kaydı bulunamadı.</h2>
                            <p>Lütfen daha sonra tekrar deneyin veya başka bir arama yapın.</p>
                        </div>
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
