@extends('client.layouts.masterPanel')

@section('content')
    <div class="d-flex justify-content-between align-items-center">
        <div class="table-breadcrumb">
            <ul>
                <li>Hesabım</li>
                <li>İlan Tipi Seç
                </li>
            </ul>
        </div>
    </div>
    <section>
        <div class="container">
            <div class="row">
                @if (in_array('CreateProject', $userPermissions))
                    <div class="col-lg-6 col-md-12 col-12">
                        <a href="{{ route('institutional.project.create.v3') }}"> <img
                                src="{{ asset('proje-ilani-ekle.png') }}" alt="">
                        </a>
                    </div>
                @endif
                <div class="col-lg-6 col-md-12 col-12">
                    <a href="{{ route('institutional.housing.create.v3') }}"> <img src="{{ asset('emlak-ilani-ekle.png') }}"
                            alt="">
                    </a>
            
                </div>
            </div>
        </div>
    </section>
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
