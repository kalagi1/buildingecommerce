@extends('client.layouts.masterPanel')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div class="table-breadcrumb">
            <ul>
                <li>Hesabım</li>
                <li>Siparişlerim</li>
            </ul>
        </div>
    </div>
    <section>
        <div class="alert alert-info">
            Emlak Sepette yaptığınız tüm satın alım işlemlerine aşağıdaki alandan ulaşabilirsiniz.
        </div>

        <!-- Filter Section -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <input type="text" id="searchInput" class="form-control w-25" placeholder="Siparişlerde Ara...">
            <div class="d-flex align-items-center">
                <input type="date" id="startDate" class="form-control mr-3">
                <input type="date" id="endDate" class="form-control">
                <button id="filterButton" class="btn btn-outline-primary ml-3">
                    <svg viewBox="0 0 24 24" width="18" height="18" stroke="currentColor" stroke-width="2"
                        fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                        <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon>
                    </svg>Filtrele</button>
            </div>
        </div>

        <div id="user-list-table-body">
            <div class="spinner-border text-danger d-none" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            @include('client.panel.orders_list', ['cartOrders' => $cartOrders])
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

            function filterOrders() {
                $(".spinner-border").removeClass("d-none");

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
                        endDate: endDate
                    },
                    success: function(response) {
                        $(".spinner-border").addClass("d-none");
                        $('#user-list-table-body').html(response.html);
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                        $(".spinner-border").addClass("d-none");
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

        #filterButton {
            justify-content: center;
            height: 40px;
            display: flex;
            align-items: center;
        }

        .spinner-border.text-danger {
            margin: 0 auto;
            text-align: center;
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
        }

        .popover-project-actions {
            display: none;
        }

        .project-table-content-actions-button {
            cursor: pointer;
        }
    </style>
@endsection
