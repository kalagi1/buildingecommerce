@extends('client.layouts.masterPanel')


@section('content')
<div class="table-breadcrumb">
    <ul>
        <li>
            Hesabım
        </li>
        <li>
            Emlak Kulüp Başvurunuz Alındı
        </li>
    </ul>
</div>

<section>
    <div class="row justify-content-center">
        <div class="col-12 col-xxl-11">
            <div class="card border-light-subtle shadow-sm">
                <div class="row g-0">
                    <div class="col-12 col-md-12 d-flex align-items-center justify-content-center ">
                        <div class="col-12 col-lg-11 col-xl-10">
                            <div class="card-body ">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="mb-5 mt-5">
                                            <h2 class="h4 text-center"> Emlak Sepette | Emlak Kulüp Başvurunuz Alındı</h2>
                                            <p class="text-body-tertiary text-center">Üyelik başvurunuz alındı. Bilgileriniz incelendikten sonra hesabınız aktive
                                                edilecek.
                                            </p>
                                            
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection


@section('css')
    <style>
        .btn-blue {
            background-color: #0080c7 !important;
            color: white
        }

        label {
            color: black;
            font-weight: 700 !important;
            font-size: 14px
        }

        /* Add this to your CSS file */
        .green-border {
            border: 2px solid green;
        }

        .ml-2 {
            margin-left: 5px;
        }

        .mr-2 {
            margin-right: 5px;
        }

        .checkmark::after {
            content: '\2713';
            color: green;
            font-size: 16px;
            margin-left: 5px;
        }

        /* CSS for the "crossmark" icon */
        .crossmark::after {
            content: '✗';
            /* Unicode character for the 'X' symbol */
            color: #EA2B2E;
            /* Color of the crossmark */
            font-size: 16px;
            /* Adjust the font size as needed */
            margin-left: 5px;
            /* Adjust the spacing as needed */
        }
    </style>
@endsection
