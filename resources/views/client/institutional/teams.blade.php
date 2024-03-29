@extends('client.layouts.master')

@section('content')

    <x-store-card :store="$institutional" />


    <section class="properties-right featured portfolio blog pt-5 bg-white">
        <div class="container">
            <div class="row">
                @if ($teams->isEmpty())
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-md-8 text-center">
                                <h2 class="mt-5 mb-3">Mağazaya ait ekip kaydı bulunamadı.</h2>
                                <p>Lütfen daha sonra tekrar deneyin veya başka bir arama yapın.</p>
                            </div>
                        </div>
                    </div>
                @else
                    @foreach ($teams as $item)
                        <div class="item col-lg-3 col-md-3 col-xs-12 landscapes sale">
                            <div class="project-single">
                                <div class="project-inner project-head">
                                    <div class="homes">
                                        <!-- homes img -->
                                        <div class="homes-img">
                                            @if ($item->profile_image == 'indir.png')
                                                @php
                                                    $nameInitials = collect(preg_split('/\s+/', $item->name))
                                                        ->map(function ($word) {
                                                            return mb_strtoupper(mb_substr($word, 0, 1));
                                                        })
                                                        ->take(2)
                                                        ->implode('');
                                                @endphp

                                                <div class="profile-initial">{{ $nameInitials }}</div>
                                            @else
                                                <img src="{{ asset('storage/profile_images/' . $item->profile_image) }}"
                                                    alt="{{ $item->name }}" style="object-fit: contain !important;"
                                                    class="img-responsive">
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <!-- homes content -->
                                <div class="homes-content">
                                    <!-- homes address -->
                                    <div class="the-agents p-2 w-100">
                                        <ul class="the-agents-details mt-0 text-center w-100">
                                            <li>{{ $item->name }}</li>
                                            <li>{{ $item->title }}</li>
                                            <li>Referans Kodu: {{ $item->code }}</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif


            </div>
        </div>

    </section>
@endsection

@section('scripts')
@endsection

@section('styles')
    <style>
        .profile-initial {
            font-size: 50px;
            color: #e54242;
            padding: 5px;
            height: 184px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
@endsection
