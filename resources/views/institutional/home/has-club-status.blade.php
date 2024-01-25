@extends('institutional.layouts.master')


@section('content')
    <div class="content">
        <div class="row">
            <div class="col-md-12">

                <div class="toast show" style="width: 100%" role="alert" data-bs-autohide="false" aria-live="assertive" aria-atomic="true">
                    <div class="toast-header">
                        <strong class="me-auto">Emlak Sepette | Emlak Kulüp Başvurunuz Alındı</strong>
                    </div>
                    <div class="toast-body"> Üyelik başvurunuz alındı. Bilgileriniz incelendikten sonra hesabınız aktive
                        edilecek.
                    </div>
                </div>

            </div>
        </div>
    </div>
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
