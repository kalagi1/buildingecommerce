@extends('institutional.layouts.master')

@section('content')
    <div class="content">
        <div class="row">
            @if (in_array('CreateProject', $userPermissions))

            <div class="col-lg-6 col-md-12 col-12">
                <div class="group-icon">
                    <div class="box-icons d-flex">
                        <div class="images">
                            <img src="{{ URL::to('/') }}/proje.png" alt="images">
                        </div>
                        <div class="contents">
                            <div class="title-icon fs-30 lh-45 fw-7 text-color-2">Proje İlanı Ekle</div>
                            <p class="font-2 text-color-2"> Kendi proje ilanınızı ekleyin ve hayalinizdeki projenizi
                                paylaşın. Binlerce kişiye ulaşın!
                            </p>
                        </div>
                    </div>
                    @if (in_array('CreateProject', $userPermissions))
                        <div class="button-footer center">
                            <a class="sc-button" href="{{ route('institutional.project.create.v3') }}">
                                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor"
                                    stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"
                                    class="css-i6dzq1">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <line x1="12" y1="8" x2="12" y2="16"></line>
                                    <line x1="8" y1="12" x2="16" y2="12"></line>
                                </svg>
                                <span>Proje İlanı Ekle</span>
                            </a>
                        </div>
                    @else
                        <p></p>
                    @endif
                </div>
            </div>
            @endif
            <div class="col-lg-6 col-md-12 col-12">
                <div class="group-icon">
                    <div class="box-icons d-flex">
                        <div class="images">
                            <img src="{{ URL::to('/') }}/emlak.png" alt="images">
                        </div>
                        <div class="contents">
                            <div class="title-icon fs-30 lh-45 fw-7 text-color-2">Emlak İlanı Ekle</div>
                            <p class="font-2 text-color-2"> Kendi emlak ilanınızı ekleyin ve ev, daire veya arsa satışınızı
                                hızlandırın. Hemen ilan verin!</p>
                        </div>
                    </div>
                    <div class="button-footer center">
                        @if (in_array('CreateHousing', $userPermissions))
                            <a class="sc-button" href="{{ route('institutional.housing.create.v3') }}">
                                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor"
                                    stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"
                                    class="css-i6dzq1">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <line x1="12" y1="8" x2="12" y2="16"></line>
                                    <line x1="8" y1="12" x2="16" y2="12"></line>
                                </svg>
                                <span>Emlak İlanı Ekle</span>
                            </a>
                        @else
                        @endif


                    </div>
                </div>
            </div>
            {{-- <div class="col-md-4 col-6">
                <div class="choise-adv">
                    <a class="choise-adv-inner" href="{{ route('institutional.project.create.v2') }}">
                        <div class="card_image"> 
                            <img
                                src="{{URL::to('/')}}/proje.png" />
                        </div>
                        <div class="card_title title-white">
                            <p style="background: #ea2a28;">Proje İlanı Ekle</p>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-md-4 col-6">
                <div class="choise-adv">
                    <a class="choise-adv-inner" href="{{ route('institutional.housing.create.v2') }}">
                        <div class="card_image"> <img
                                src="{{URL::to('/')}}/emlak.png" />
                        </div>
                        <div class="card_title title-white">
                            <p style="background: #004aad;">Emlak İlanı Ekle</p>
                        </div>
                    </a>
                </div>
            </div> --}}
        </div>
    </div>
@endsection

@section('scripts')
    <script></script>
@endsection


@section('css')
    <style>
        .group-icon .box-icons {
            align-items: center;
            background-color: #FFF5E0;
            border-radius: 12px;
            padding: 30px 31px 45px 30px;
        }

        .group-icon .box-icons .title-icon {
            margin-bottom: 13px;
            margin-top: 13px;

        }

        .text-color-2 {
            color: #000 !important;
        }

        .fs-30 {
            font-size: 20px;
        }

        .fw-7 {
            font-weight: 700;
        }

        .text-color-2 {
            color: #000 !important;
        }

        .sc-button svg {
            margin-right: 17px;
        }

        svg:not(:root) {
            overflow: hidden;
        }

        .font-2 {
            font-family: "Mulish", sans-serif;
        }

        .text-p,
        p {
            font-weight: 400;
            font-size: 14px;
            line-height: 21px;
            color: #8E8E93;
        }

        .group-icon .button-footer .sc-button {
            width: 212px;
            margin-right: 8px;
        }

        .sc-button {
            display: inline-block;
            background-color: #FFA920;
            box-sizing: border-box;
            padding: 15px 18.5px;
            border-radius: 10px;
            -webkit-transition: all 0.3s ease;
            -moz-transition: all 0.3s ease;
            -ms-transition: all 0.3s ease;
            -o-transition: all 0.3s ease;
            transition: all 0.3s ease;
        }

        .group-icon .button-footer .sc-button span {
            position: relative;
        }

        .sc-button span {
            color: #fff;
            font-weight: 700;
            font-size: 15px;
            position: relative;
            -webkit-transition: all 0.3s ease;
            -moz-transition: all 0.3s ease;
            -ms-transition: all 0.3s ease;
            -o-transition: all 0.3s ease;
            transition: all 0.3s ease;
        }

        .group-icon .button-footer {
            margin-top: -26px;
        }

        .center,
        .text-center {
            text-align: center;
        }

        .center {
            text-align: center;
        }

        .group-icon .box-icons .images img {
            transition: all 0.8s ease;
            width: 130px;
        }

        img {
            max-width: 100%;
            height: auto;
            transform: scale(1);
            vertical-align: middle;
            -ms-interpolation-mode: bicubic;
        }

        .group-icon .box-icons .images {
            flex: none;
            margin-right: 30px;
        }

        .group-icon .button-footer .sc-button span::before {
            content: "";
            width: 1px;
            height: 22px;
            background-color: rgba(255, 255, 255, 0.2);
            margin-left: -11px;
            position: absolute;
        }

        @media (max-width: 768px) {
            .d-flex {
                flex-wrap: wrap
            }

            .group-icon .box-icons .images {
                flex: none;
                width: 100%;
                margin-right: 30px;
                margin: 0 auto;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .contents {
                text-align: center
            }

            .group-icon .button-footer {
                margin-bottom: 30px
            }

        }
    </style>
@endsection
