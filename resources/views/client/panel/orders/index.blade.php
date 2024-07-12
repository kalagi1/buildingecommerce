@extends('client.layouts.masterPanel')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="table-breadcrumb">
            <ul>
                <li>Hesabım</li>
                <li>Sattıklarım</li>
            </ul>
        </div>
    </div>
    <section>
        <div class="alert alert-info">
            Emlak Sepette platformunda yaptığınız tüm satış işlemlerine aşağıdaki alandan ulaşabilirsiniz.
        </div>

        <!-- Filter Section -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <input type="text" id="searchInput" class="form-control w-25" placeholder="Siparişlerde Ara...">
            <div class="d-flex align-items-center">
                <input type="date" id="startDate" class="form-control mr-3">
                <input type="date" id="endDate" class="form-control">
                <button id="filterButton" class="btn btn-outline-primary ml-3">
                    <svg viewBox="0 0 24 24" width="15" height="15" stroke="currentColor" stroke-width="2"
                        fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                        <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon>
                    </svg>Filtrele</button>
                <button id="clearButton" class="btn btn-outline-secondary ml-2">
                    Temizle
                </button>
            </div>
        </div>
        <div id="user-list-table-body">

            @include('client.panel.orders_list', ['cartOrders' => $cartOrders, 'key' => 'my-sells'])
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#filterButton').on('click', function() {
                filterOrders();
            });

            $('#searchInput').on('input', function() {
                filterOrders();
            });
            $('#clearButton').on('click', function() {
                $('#searchInput').val('');
                $('#startDate').val('');
                $('#endDate').val('');
                filterOrders(); // Optionally refresh results after clearing
            });

            function filterOrders() {
                // $(".spinBorder").removeClass("d-none");

                var searchInput = $('#searchInput').val();
                var startDate = $('#startDate').val();
                var endDate = $('#endDate').val();

                $.ajax({
                    url: "{{ route('institutional.orders.filter') }}",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        search: searchInput,
                        startDate: startDate,
                        endDate: endDate,
                        key: "my-sells"
                    },
                    success: function(response) {
                        $('#user-list-table-body').html(response.html);

                        if (response.html.trim() === '') {
                            $('#user-list-table-body').html('<ul><li>Sonuç bulunamadı</li></ul>');
                            // $(".spinner-border").addClass("d-none");

                        } else if ($('#user-list-table-body').find('ul').length === 0) {
                            // $(".spinner-border").addClass("d-none");
                        }
                    },
                    error: function(xhr) {
                        $(".spinBorder").addClass("d-none");
                    }
                });
            }

            // Toggle popovers
            $(document).on('click', '.project-table-content-actions-button', function() {
                var targetId = $(this).data('toggle');
                var $popover = $('#' + targetId);

                // Hide other popovers
                $('.popover-project-actions').not($popover).addClass('d-none');

                // Toggle current popover
                $popover.toggleClass('d-none');
            });

            // Close popover when clicking outside
            $(document).on('click', function(event) {
                if (!$(event.target).closest('.project-table-content').length) {
                    $('.popover-project-actions').addClass('d-none');
                }
            });
        });
    </script>
@endsection

@section('styles')
    <style>
        .avatar {
            position: relative;
            display: inline-block;
            vertical-align: middle;
        }

        .avatar-m {
            height: 50px;
            width: 50px;
            border: 1px solid #bebebe;
            border-radius: 50%
        }

        .avatar img,
        .avatar .avatar-name {
            width: 100%;
            height: 100%;
        }

        .avatar img {
            -o-object-fit: cover;
            object-fit: cover;
        }

        .avatar img {
            display: block;
        }

        .rounded-circle {
            float: left;
            height: 2rem;
            width: 2rem;
        }

        .table-breadcrumb {
            margin-bottom: 0 !important
        }

        .visually-hidden {
            overflow: hidden !important;
        }

        #filterButton,
        #clearButton {
            justify-content: center;
            height: 30px;
            display: flex;
            align-items: center;
        }

        .spinBorder.text-danger {
            margin: 0 auto;
            text-align: center;
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
        }


        .project-table-content-actions-button {
            cursor: pointer;
        }

        .spinner {
            -webkit-animation: rotator 1.4s linear infinite;
            animation: rotator 1.4s linear infinite;
        }

        @-webkit-keyframes rotator {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(270deg);
            }
        }

        @keyframes rotator {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(270deg);
            }
        }

        .path {
            stroke-dasharray: 187;
            stroke-dashoffset: 0;
            transform-origin: center;
            -webkit-animation: dash 1.4s ease-in-out infinite, colors 5.6s ease-in-out infinite;
            animation: dash 1.4s ease-in-out infinite, colors 5.6s ease-in-out infinite;
        }

        @-webkit-keyframes colors {
            0% {
                stroke: #DE3E35;
            }

            25% {
                stroke: #DE3E35;
            }

            50% {
                stroke: #DE3E35;
            }

            75% {
                stroke: #DE3E35;
            }

            100% {
                stroke: #DE3E35;
            }
        }

        @keyframes colors {
            0% {
                stroke: #DE3E35;
            }

            25% {
                stroke: #DE3E35;
            }

            50% {
                stroke: #DE3E35;
            }

            75% {
                stroke: #DE3E35;
            }

            100% {
                stroke: #DE3E35;
            }
        }

        @-webkit-keyframes dash {
            0% {
                stroke-dashoffset: 187;
            }

            50% {
                stroke-dashoffset: 46.75;
                transform: rotate(135deg);
            }

            100% {
                stroke-dashoffset: 187;
                transform: rotate(450deg);
            }
        }

        @keyframes dash {
            0% {
                stroke-dashoffset: 187;
            }

            50% {
                stroke-dashoffset: 46.75;
                transform: rotate(135deg);
            }

            100% {
                stroke-dashoffset: 187;
                transform: rotate(450deg);
            }
        }
    </style>
@endsection
