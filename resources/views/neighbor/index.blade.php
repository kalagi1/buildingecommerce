@extends('institutional.layouts.master')

@section('content')
  
    <div class="content">
        <nav class="mb-3 mt-3" aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="#!">Emlak Sepette</a></li>
                <li class="breadcrumb-item active">Sahibini Gör</li>
            </ol>
        </nav>

        @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
        @endif

        <div class="mx-n4 px-4 mx-lg-n6 px-lg-6 bg-white border-top border-bottom border-200 position-relative top-1">
            <div class="table-responsive scrollbar mx-n1 px-1">
                <table class="table table-sm fs--1 mb-0">
                    <thead>
                        <tr>
                            <th class="sort white-space-nowrap align-middle pe-3" scope="col" data-sort="no">
                                #
                            </th>
                            <th class="sort white-space-nowrap align-middle pe-3" scope="col" data-sort="order_date">
                                Mülk Sahibi Adı</th>
                            <th class="sort white-space-nowrap align-middle pe-3" scope="col" data-sort="order_no">
                                Mülk Sahibi Telefonu
                            </th>
                            <th class="sort white-space-nowrap align-middle pe-3" scope="col" data-sort="order_project">
                                Proje Adı</th>
                            <th class="sort white-space-nowrap align-middle pe-3" scope="col" data-sort="order_project">
                                Proje No </th>

                            <th class="sort white-space-nowrap align-middle pe-3" scope="col" data-sort="order_project">
                                    İlanı Görüntüle </th>
                        </tr>
                    </thead>
                    <tbody class="list" id="order-table-body">
                        @foreach($neighborViews as $neighborView)
                        @php
                            $cart = json_decode($neighborView->order->cart, true);
                        @endphp
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $neighborView->owner->name }}</td>
                            <td>{{ $neighborView->owner->phone }}</td>
                            <td>{{ $neighborView->project->project_title }}</td>
                            <td>{{ $cart['item']['housing'] }}</td>
                            <td>
                                <a
                                    href="{{ $cart['type'] == 'housing'
                                        ? route('housing.show', ['housingSlug' => $cart['item']['slug'], 'housingID' => $cart['item']['id'] + 2000000])
                                        : route('project.housings.detail', [
                                            'projectSlug' =>
                                                optional(App\Models\Project::find($cart['item']['id']))->slug .
                                                '-' .
                                                optional(App\Models\Project::find($cart['item']['id']))->step2_slug .
                                                '-' .
                                                optional(App\Models\Project::find($cart['item']['id']))->housingtype->slug,
                                            'projectID' => optional(App\Models\Project::find($cart['item']['id']))->id + 1000000,
                                            'housingOrder' => $cart['item']['housing'],
                                        ]) }}">
                                    <div class="mobile">İlanı Gör</div>
                                </a>

                            </td>
                          
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        
           
    </div>
@endsection

@section('scripts')
@endsection

@section('css')
    <style>
        @media(max-width: 768px) {
            .mobile-shadow {
                background: white;
                box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.103)
            }

            .my-properties table tr {
                margin-bottom: 20px;
            }

            .ps-section--account {
                padding: 60px 0;
            }

            .my-properties table tr td {
                padding: 10px !important;
            }

            .my-properties {
                background: transparent;
                padding: 0 !important;
                margin-top: 20px;
                box-shadow: none !important;
            }
        }

        .invoiceBtn {
            width: 150px !important;
            -moz-appearance: none;
            -webkit-appearance: none;
            appearance: none;
            border: none;
            background: none;
            color: #0f1923;
            cursor: pointer;
            position: relative;
            padding: 8px;
            margin-bottom: 20px;
            font-weight: 600;
            font-size: 11px;
            transition: all .15s ease;
        }

        .invoiceBtn::before,
        .invoiceBtn::after {
            content: '';
            display: block;
            position: absolute;
            right: 0;
            left: 0;
            height: calc(50% - 5px);
            border: 1px solid #7D8082;
            transition: all .15s ease;
        }

        .invoiceBtn::before {
            top: 0;
            border-bottom-width: 0;
        }

        .invoiceBtn::after {
            bottom: 0;
            border-top-width: 0;
        }

        .invoiceBtn:active,
        .invoiceBtn:focus {
            outline: none;
        }

        .invoiceBtn:active::before,
        .invoiceBtn:active::after {
            right: 3px;
            left: 3px;
        }

        .invoiceBtn:active::before {
            top: 3px;
        }

        .invoiceBtn:active::after {
            bottom: 3px;
        }

        .invoiceBtn_lg {
            position: relative;
            display: block;
            padding: 10px 20px;
            color: #fff;
            background-color: #0f1923;
            overflow: hidden;
            box-shadow: inset 0px 0px 0px 1px transparent;
        }

        .invoiceBtn_lg::before {
            content: '';
            display: block;
            position: absolute;
            top: 0;
            left: 0;
            width: 2px;
            height: 2px;
            background-color: #0f1923;
        }

        .invoiceBtn_lg::after {
            content: '';
            display: block;
            position: absolute;
            right: 0;
            bottom: 0;
            width: 4px;
            height: 4px;
            background-color: #0f1923;
            transition: all .2s ease;
        }

        .invoiceBtn_sl {
            display: block;
            position: absolute;
            top: 0;
            bottom: -1px;
            left: -8px;
            width: 0;
            background-image: linear-gradient(to bottom right, #00c6ff,
                    #0072ff);
            transform: skew(-15deg);
            transition: all .2s ease;
        }

        .invoiceBtn_text {
            position: relative;
        }

        .invoiceBtn:hover {
            color: #0f1923;
        }

        .invoiceBtn:hover .invoiceBtn_sl {
            width: calc(100% + 15px);
        }

        .invoiceBtn:hover .invoiceBtn_lg::after {
            background-color: #fff;
        }

        #orders-container .header-bar {
            border: 1px solid #e2e2e2;
            background: #fff;
            border-radius: 8px;
            display: flex;
            padding: 15px 20px;
            justify-content: space-between;
            align-items: center;
            font-size: 11px;
            color: #2a2a2a;
            font-weight: bold;
            margin-bottom: 20px;
        }

        #orders-container .header-bar .order-search-box-warn {
            font-size: 11px;
            font-weight: 600;
            color: #d21313;
            margin: 5px;
            display: block;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        #orders-container .header-bar .order-search-box-container {
            position: relative;
            display: flex;
        }

        #orders-container .header-bar .order-search-box-container>div {
            display: inline-block;
            width: 100%;
        }

        #orders-container .header-bar .order-search-box-container>div input {
            padding-right: 30px;
            border-radius: 4px;
        }

        #orders-container .header-bar .order-search-box-container .osb-give-up {
            position: absolute;
            left: 310px;
        }

        #orders-container .header-bar .order-search-box-container .osb-give-up span {
            position: absolute;
            font-size: 11px;
            font-weight: 600;
            color: #333333;
            left: 15px;
            top: 9px;
        }

        #orders-container .header-bar .order-search-box-container .osb-give-up span:hover {
            cursor: pointer;
            color: #f27a1a;
            text-decoration: underline;
        }

        #orders-container .header-bar .order-search-box-container .ty-button {
            border: none;
            position: absolute;
            right: 0;
            height: 34px;
            width: 25px;
        }

        #orders-container .header-bar .order-search-box-container .i-search {
            position: absolute;
            right: 9px;
            top: 9px;
            color: #f27a1a;
            font-size: 11px;
            cursor: pointer;
        }

        #orders-container .header-bar .ty-input {
            height: 34px;
        }

        #orders-container .header-bar .ty-form {
            width: 310px;
        }

        #orders-container .header-bar .ty-form .ty-input-w div {
            display: none;
        }

        #orders-container .header-bar h1 {
            font-size: 18px;
        }

        #orders-container .header-bar .sorting {
            width: 130px;
        }

        #orders-container .header-bar .sorting>div>div:last-child {
            display: none;
        }

        #orders-container .header-bar .sorting .ty-input {
            border-radius: 4px;
        }

        #orders-container .header-info-box {
            border: 1px solid #deddbe;
            padding: 20px 20px 18px 64px;
            background: url("https://cdn.dsmcdn.com/web/production/orders-info-icon.svg") no-repeat 20px center #fffff1;
            display: flex;
            line-height: 20px;
            color: #333;
            background-size: 24px 24px;
            margin-bottom: 20px;
            border-radius: 3px;
        }

        #orders-container .order {
            border: 1px solid #e2e2e2;
            margin-bottom: 15px;
            border-radius: 8px;
        }

        .text-red {
            color: #EA2B2E !important;
            font-weight: 600 !important
        }

        #orders-container .order .last-operation-text {
            padding: 25px 20px 0 20px;
        }

        #orders-container .order .order-header {
            display: flex;
            justify-content: space-between;
            border-bottom: solid 1px #e2e2e2;
            border-radius: 8px 8px 0 0;
            background-color: #fafafa;
            padding: 15px 20px;
            align-items: center;
        }

        .list-group {
            display: flex;
            flex-wrap: wrap;
            flex-direction: initial;
        }

        .list-group-item {
            width: 50%
        }

        #orders-container .order .order-header .order-header-info {
            color: #666;
            font-weight: bold;
            font-size: 13px;
            display: flex;
        }

        #orders-container .order .order-header .order-header-info b {
            text-overflow: ellipsis;
            white-space: nowrap;
            overflow: hidden;
            color: #333;
            width: 100%;
            font-weight: 400;
        }

        #orders-container .order .order-header .order-header-info b.orange {
            color: #f27a1a;
        }

        #orders-container .order .order-header button {
            width: 150px;
            border-radius: 4px;
        }

        #orders-container .order .order-list {
            padding: 20px;
        }

        #orders-container .order .order-item {
            display: flex;
            align-items: center;
            border: 1px solid #e2e2e2;
            border-radius: 4px;
            margin-bottom: 15px;
            padding: 15px 20px;
        }

        #orders-container .order .order-item:last-child {
            margin-bottom: 0;
        }

        .list-group-item+.list-group-item {
            border-top-width: none !important;
        }

        #orders-container .order .order-item .order-item-status {
            display: flex;
            flex-direction: column;
            width: 80%;
            color: #333;
            font-size: 11px;
        }

        #orders-container .order .order-item .order-item-status .title {
            display: flex;
            vertical-align: center;
        }

        #orders-container .order .order-item .order-item-status .title .icon {
            margin-right: 10px;
        }

        #orders-container .order .order-item .order-item-status .title .at_collection_point {
            margin-right: 8px;
            height: 20px;
        }

        #orders-container .order .order-item .order-item-status .title .shipment-info {
            color: #666;
            font-size: 11px;
            margin-left: 10px;
            line-height: 18px;
            text-decoration: underline;
            transition: all 0.2s ease;
        }

        #orders-container .order .order-item .order-item-status .title .shipment-info:hover {
            color: #f27a1a;
        }

        #orders-container .order .order-item .order-item-status .title.preparing_defective~.description,
        #orders-container .order .order-item .order-item-status .title.shipped_defective~.description,
        #orders-container .order .order-item .order-item-status .title.at_collection_point_defective~.description,
        #orders-container .order .order-item .order-item-status .title.delivered_defective~.description,
        #orders-container .order .order-item .order-item-status .title.undelivered_defective~.description,
        #orders-container .order .order-item .order-item-status .title.returned_defective~.description {
            width: 380px;
        }

        #orders-container .order .order-item .order-item-status .at_collection_point {
            align-items: center;
        }

        #orders-container .order .order-item .order-item-status .description {
            margin-top: 5px;
            font-size: 11px;
        }

        #orders-container .order .order-item .order-item-status .description .cargo-info {
            display: flex;
            align-items: center;
            color: #666666;
            font-weight: normal;
        }

        #orders-container .order .order-item .order-item-status .description .cargo-info .provider-name {
            margin-right: 5px;
        }

        #orders-container .order .order-item .order-item-status .description .cargo-info .tracking-number {
            padding: 2px 5px 0 5px;
            border: dashed 1px #efe1d3;
            background-color: #fff9f3;
            border-radius: 3px;
            color: #333333;
        }

        #orders-container .order .order-item .order-item-status .description .cargo-info .tracking-number .highlighted {
            font-weight: 600;
        }

        #orders-container .order .order-item .order-item-status .description b {
            vertical-align: middle;
        }

        #orders-container .order .order-item .order-item-status .description .refund-info {
            display: inline-block;
            border-left: 1px solid #e2e2e2;
            padding-left: 5px;
            margin-left: 5px;
            vertical-align: top;
        }

        #orders-container .order .order-item .order-item-status .description .refund-info.wallet {
            background: url("https://cdn.dsmcdn.com/web/production/orders-wallet-icon.svg") no-repeat 5px center;
            padding-left: 30px;
        }

        #orders-container .order .order-item .order-item-status .description .refund-info img {
            height: 10px;
            margin-right: 7px;
        }

        #orders-container .order .order-item .order-item-status strong {
            font-weight: bold;
        }

        #orders-container .order .order-item .order-item-status .at_collection_point,
        #orders-container .order .order-item .order-item-status .az_at_collection_point,
        #orders-container .order .order-item .order-item-status .created_assembly,
        #orders-container .order .order-item .order-item-status .appointed_assembly,
        #orders-container .order .order-item .order-item-status .completed_assembly,
        #orders-container .order .order-item .order-item-status .at_collection_point_defective,
        #orders-container .order .order-item .order-item-status .creating,
        #orders-container .order .order-item .order-item-status .created,
        #orders-container .order .order-item .order-item-status .preparing,
        #orders-container .order .order-item .order-item-status .shipped,
        #orders-container .order .order-item .order-item-status .az_shipped,
        #orders-container .order .order-item .order-item-status .delivered,
        #orders-container .order .order-item .order-item-status .az_delivered,
        #orders-container .order .order-item .order-item-status .preparing_defective,
        #orders-container .order .order-item .order-item-status .shipped_defective,
        #orders-container .order .order-item .order-item-status .delivered_defective,
        #orders-container .order .order-item .order-item-status .replacement_request_created,
        #orders-container .order .order-item .order-item-status .replacement_request_shipped,
        #orders-container .order .order-item .order-item-status .replacement_request_waiting,
        #orders-container .order .order-item .order-item-status .replacement_accepted,
        #orders-container .order .order-item .order-item-status .replacement_rejected {
            color: #0bc15c;
        }

        #orders-container .order .order-item .order-item-status .created_inbound,
        #orders-container .order .order-item .order-item-status .shipped_inbound,
        #orders-container .order .order-item .order-item-status .waiting_in_action,
        #orders-container .order .order-item .order-item-status .accepted,
        #orders-container .order .order-item .order-item-status .rejected,
        #orders-container .order .order-item .order-item-status .uncompleted_assembly,
        #orders-container .order .order-item .order-item-status .cancel,
        #orders-container .order .order-item .order-item-status .un_delivered,
        #orders-container .order .order-item .order-item-status .returned,
        #orders-container .order .order-item .order-item-status .payment_failed,
        #orders-container .order .order-item .order-item-status .undelivered_defective,
        #orders-container .order .order-item .order-item-status .returned_defective {
            color: #bb0000;
        }

        #orders-container .order .order-item .order-item-images {
            flex: 1;
            width: 20%;
            display: flex;
            align-items: center;
        }

        #orders-container .order .order-item .order-item-images .image-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 41px;
            height: 62px;
            border: 2px solid #e6e6e6;
            border-radius: 3px;
            margin-right: 10px;
            cursor: pointer;
        }

        #orders-container .order .order-item .order-item-images img {
            width: 90%;
        }

        #orders-container .order .order-item .order-item-images span {
            color: #666;
            width: 25px;
            text-align: center;
            font-size: 11px;
        }

        #orders-container .order .order-item .order-item-easy-return,
        #orders-container .order .order-item .order-item-group-deal-info {
            width: 130px;
        }

        #orders-container .order .order-item .order-item-easy-return button.ty-bordered,
        #orders-container .order .order-item .order-item-group-deal-info button.ty-bordered {
            border-radius: 2px;
        }

        #orders-container .loader {
            display: block;
            position: relative;
            clear: both;
        }

        #orders-container .spinner {
            display: block;
            position: relative;
            width: 64px;
            height: 64px;
            margin: 0 auto;
        }

        #orders-container .spinner div {
            transform-origin: 32px 32px;
            animation: spin 1.2s linear infinite;
        }

        #orders-container .spinner div:after {
            content: ' ';
            display: block;
            position: absolute;
            top: 3px;
            left: 29px;
            width: 5px;
            height: 14px;
            border-radius: 20%;
            background: #eee;
        }

        #orders-container .spinner div:nth-child(12) {
            transform: rotate(330deg);
            animation-delay: 0s;
        }

        #orders-container .spinner div:nth-child(11) {
            transform: rotate(300deg);
            animation-delay: -0.1s;
        }

        #orders-container .spinner div:nth-child(10) {
            transform: rotate(270deg);
            animation-delay: -0.2s;
        }

        #orders-container .spinner div:nth-child(9) {
            transform: rotate(240deg);
            animation-delay: -0.3s;
        }

        #orders-container .spinner div:nth-child(8) {
            transform: rotate(210deg);
            animation-delay: -0.4s;
        }

        #orders-container .spinner div:nth-child(7) {
            transform: rotate(180deg);
            animation-delay: -0.5s;
        }

        #orders-container .spinner div:nth-child(6) {
            transform: rotate(150deg);
            animation-delay: -0.6s;
        }

        #orders-container .spinner div:nth-child(5) {
            transform: rotate(120deg);
            animation-delay: -0.7s;
        }

        #orders-container .spinner div:nth-child(4) {
            transform: rotate(90deg);
            animation-delay: -0.8s;
        }

        #orders-container .spinner div:nth-child(3) {
            transform: rotate(60deg);
            animation-delay: -0.9s;
        }

        #orders-container .spinner div:nth-child(2) {
            transform: rotate(30deg);
            animation-delay: -1s;
        }

        #orders-container .spinner div:nth-child(1) {
            transform: rotate(0deg);
            animation-delay: -1.1s;
        }

        @keyframes spin {
            0% {
                opacity: 1;
            }

            100% {
                opacity: 0;
            }
        }

        #orders-container .orders-error {
            font-size: 11px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 400px;
        }

        #orders-container .orders-error .orders-error-icon {
            width: 100px;
            height: 100px;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            border: solid 1px #e6e6e6;
            border-radius: 50%;
            margin-bottom: 10px;
            background: url("https://cdn.dsmcdn.com/web/production/orders-error-icon.svg") center no-repeat #fff;
        }

        #orders-container .orders-error .orders-error-icon img {
            margin-left: 3px;
        }

        #orders-container .orders-error button {
            width: 300px;
            height: 38px;
            font-size: 16px;
            margin-top: 10px;
        }

        #orders-container .icon.creating:before {
            content: url("https://cdn.dsmcdn.com/web/production/preparing.svg");
        }

        #orders-container .icon.created:before,
        #orders-container .icon.created_assembly {
            content: url("https://cdn.dsmcdn.com/web/production/created.svg");
        }

        #orders-container .icon.appointed_assembly:before {
            content: url("https://cdn.dsmcdn.com/web/production/assembly-appointed.svg");
        }

        #orders-container .icon.az_delivered:before,
        #orders-container .icon.delivered:before,
        #orders-container .icon.delivered_defective:before,
        #orders-container .icon.completed_assembly:before {
            content: url("https://cdn.dsmcdn.com/web/production/delivered.svg");
        }

        #orders-container .icon.rejected:before {
            content: url("https://cdn.dsmcdn.com/web/production/rejected.svg");
        }

        #orders-container .icon.un_delivered:before,
        #orders-container .icon.undelivered_defective:before,
        #orders-container .icon.uncompleted_assembly:before {
            content: url("https://cdn.dsmcdn.com/web/production/undelivered-icon.svg");
        }

        #orders-container .icon.returned:before,
        #orders-container .icon.returned_defective:before {
            content: url("https://cdn.dsmcdn.com/web/production/returned.svg");
        }

        #orders-container .icon.cancel:before {
            content: url("https://cdn.dsmcdn.com/web/production/cancel-icon.svg");
        }

        #orders-container .icon.payment_failed:before {
            content: url("https://cdn.dsmcdn.com/web/production/cancel-icon.svg");
        }

        #orders-container .icon.accepted:before {
            content: url("https://cdn.dsmcdn.com/web/production/accepted.svg");
        }

        #orders-container .icon.created_inbound:before {
            content: url("https://cdn.dsmcdn.com/web/production/createdinbound.svg");
        }

        #orders-container .icon.az_shipped:before,
        #orders-container .icon.shipped:before,
        #orders-container .icon.shipped_defective:before {
            content: url("https://cdn.dsmcdn.com/web/production/shipped.svg");
        }

        #orders-container .icon.waiting_in_action:before {
            content: url("https://cdn.dsmcdn.com/web/production/waitinginaction.svg");
        }

        #orders-container .icon.shipped_inbound:before {
            content: url("https://cdn.dsmcdn.com/web/production/shipped-in-bound.svg");
        }

        #orders-container .icon.preparing:before,
        #orders-container .icon.preparing_defective:before {
            content: url("https://cdn.dsmcdn.com/web/production/preparing.svg");
        }

        #orders-container .icon.at_collection_point:before,
        #orders-container .icon.at_collection_point_defective:before {
            content: url("https://cdn.dsmcdn.com/web/production/at-collection-point.svg");
        }

        #orders-container .icon.az_at_collection_point:before {
            content: url("https://cdn.dsmcdn.com/web/production/delivered.svg");
        }

        #orders-container .icon.replacement_request_created:before {
            content: url("https://cdn.dsmcdn.com/web/production/replacementrequestcreated.svg");
        }

        #orders-container .icon.replacement_request_shipped:before {
            content: url("https://cdn.dsmcdn.com/web/production/replacementrequestshipped.svg");
        }

        #orders-container .icon.replacement_request_waiting:before {
            content: url("https://cdn.dsmcdn.com/web/production/replacementrequestwaiting.svg");
        }

        #orders-container .icon.replacement_accepted:before {
            content: url("https://cdn.dsmcdn.com/web/production/replacementaccepted.svg");
        }

        #orders-container .icon.replacement_rejected:before {
            content: url("https://cdn.dsmcdn.com/web/production/replacementrejected.svg");
        }

        #orders-container .photo-gallery img {
            max-height: 90vh;
        }

        #orders-container .photo-gallery a {
            position: absolute;
            height: 50px;
            top: calc(50% - 25px);
            width: 50px;
            left: -50px;
            display: flex;
            justify-content: center;
            align-items: center;
            opacity: 0.6;
        }

        #orders-container .photo-gallery a:hover {
            opacity: 1;
        }

        #orders-container .photo-gallery a.next {
            left: auto;
            right: -50px;
        }

        #orders-container .empty-order-search-container {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 445px;
            border-radius: 3px;
            border: solid 1px #e2e2e2;
            background-color: #ffffff;
            flex-direction: column;
            line-height: 30px;
        }

        #orders-container .empty-order-search-container .ty-button {
            width: 210px;
            height: 44px;
            margin: 20px;
            border-radius: 6px;
            background-color: #f27a1a;
            font-size: 11px;
            font-weight: 600;
        }

        #orders-container .empty-order-search-container .eos-icon {
            width: 94px;
            height: 94px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background-color: #fff4ec;
            font-size: 40px;
            color: #f27a1a;
            margin-bottom: 10px;
        }

        #orders-container .empty-order-search-container .eos-title {
            font-size: 20px;
            font-weight: 600;
            color: #000000;
        }

        #orders-container .empty-order-search-container .eos-desc {
            font-size: 16px;
            font-weight: normal;
            color: #000000;
        }

        #orders-container .empty-order-search-container .eos-desc .highlighted {
            font-weight: 600;
        }

        #orders-container .order-search-info {
            margin: 0 0 15px 20px;
            font-size: 11px;
            color: #2a2a2a;
        }

        #orders-container .order-search-info .highlighted {
            font-weight: 600;
        }

        #orders-container .tooltip {
            position: relative;
        }

        #orders-container .tooltip .tooltip-content {
            position: absolute;
            bottom: -100%;
            left: 50%;
            transform: translateX(-50%);
            min-width: 12em;
            border-radius: 3px;
            z-index: 2;
            width: 100%;
            box-sizing: border-box;
            border: solid 1px #ffcfcf;
            background-color: #fff9f9;
        }

        #orders-container .tooltip .tooltip-content:after {
            content: '';
            position: absolute;
            width: 0;
            height: 0;
            left: 10%;
            z-index: -1;
            border-style: solid;
            border-width: 5px;
            border-color: #fff9f9 transparent transparent transparent;
            filter: drop-shadow(0 1px 0 #ffcfcf);
            transform: translateX(-50%) rotate(180deg);
            transition: bottom 300ms ease;
        }

        #orders-container .tooltip.is-visible .tooltip-content {
            transform: translateY(0%) translateX(-50%);
            opacity: 1;
            visibility: visible;
            transition: transform 300ms ease, opacity 300ms, visibility 300ms 0s;
        }

        #orders-container .tooltip.is-visible .tooltip-content:after {
            bottom: 100%;
        }

        #orders-container .tooltip.is-hidden .tooltip-content {
            transform: translateY(0%) translateX(-50%);
            opacity: 0;
            visibility: hidden;
            transition: transform 300ms ease, opacity 300ms, visibility 300ms 300ms;
        }

        #orders-container .tooltip.is-hidden .tooltip-content:after {
            bottom: 0;
        }

        @keyframes fade {
            0% {
                top: 0;
                opacity: 1;
            }

            100% {
                top: -1em;
                opacity: 0;
            }
        }

        #orders-container .orders-collection-point-description {
            margin: 15px 20px 0 20px;
        }

        #orders-container .orders-collection-point-description .delivery-point-desc {
            font-size: 11px;
            font-weight: 400;
            letter-spacing: -0.1px;
            color: #333333;
            display: flex;
            align-items: center;
        }

        #orders-container .orders-collection-point-description .highlighted-text {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 24px;
            background-color: #FEF4EC;
            color: #F27A1A;
            font-size: 11px;
            font-family: source_sans_prosemibold, sans-serif;
            border-top-right-radius: 2px;
            border-bottom-right-radius: 2px;
            padding-right: 6px;
            margin-right: 6px;
        }

        #orders-container .orders-collection-point-description .i-collection-point-orders {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 24px;
            background-color: #FEF4EC;
            color: #f27a1a;
            border-top-left-radius: 2px;
            border-bottom-left-radius: 2px;
            padding: 0 6px;
            margin-left: 6px;
        }

        #orders-container .orders-collection-point-description .otp-code-description {
            margin-left: 5px;
            font-family: source_sans_prosemibold, sans-serif;
        }

        #orders-container .orders-collection-point-description .otp-code-description .otp-number {
            font-family: source_sans_prosemibold, sans-serif;
            color: #F27A1A;
        }

        #orders-container .collection-point-information-banner {
            display: flex;
            align-items: center;
            background: #FEF4EC;
            border-radius: 4px;
            height: 48px;
            box-sizing: border-box;
            margin-top: 15px;
        }

        #orders-container .collection-point-information-banner .collection-point-information {
            font-size: 11px;
            color: #333333;
        }

        #orders-container .collection-point-information-banner .collection-point-information strong {
            font-family: source_sans_prosemibold, sans-serif;
        }

        #orders-container .collection-point-information-banner .i-warning1-fill {
            font-size: 16px;
            padding-bottom: 1px;
            margin: 0 15px 0 20px;
        }

        #orders-container .collection-point-information-banner .i-warning1-fill .path1::before {
            color: #F27A1A;
        }

        #orders-container .no-order-container {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 445px;
            border-radius: 6px;
            border: solid 1px #e2e2e2;
            background-color: #ffffff;
            flex-direction: column;
            line-height: 30px;
        }

        #orders-container .no-order-container .ty-button {
            width: 210px;
            height: 44px;
            margin: 20px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 600;
        }

        #orders-container .no-order-container .no-icon {
            width: 70px;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background-color: #fff4ec;
            font-size: 32px;
            color: #f27a1a;
            margin-bottom: 10px;
            box-sizing: border-box;
        }

        #orders-container .no-order-container .no-title {
            font-size: 20px;
            font-weight: 600;
            color: #f27a1a;
        }

        #orders-container .no-order-container .no-desc {
            font-size: 16px;
            font-weight: normal;
            color: #666;
        }

        #orders-container .status-quick-filters-wrapper .sticky {
            top: 0;
        }

        #orders-container .status-quick-filters-wrapper .scrolled {
            position: fixed;
            box-shadow: 0 1px 4px 0 rgba(0, 0, 0, 0.05);
            border: solid 1px #e6e6e6;
            z-index: 999;
        }

        #orders-container .status-quick-filters-wrapper .scrolled .status-quick-filter-tabs-wrapper {
            border-bottom: 1px solid #e6e6e6;
            box-shadow: 0 1px 4px 0 rgba(0, 0, 0, 0.05);
            background-color: #fff;
            padding: 20px 0 20px 20px;
        }

        #orders-container .status-quick-filters-wrapper .status-quick-filter-tabs-wrapper {
            display: flex;
            align-items: center;
            padding-bottom: 20px;
            padding-left: 20px;
        }

        #orders-container .status-quick-filters-wrapper .status-quick-filter-tabs-wrapper .filter-tab {
            padding: 9px 11px;
            border-radius: 8px;
            box-sizing: border-box;
            box-shadow: 0 1px 4px 0 rgba(0, 0, 0, 0.05), 0px 0px 0px 1px #e6e6e6;
            border: 2px solid transparent;
            color: #333333;
            font-family: source_sans_prosemibold, sans-serif;
            -webkit-font-smoothing: antialiased;
            font-size: 11px;
            cursor: pointer;
            transition: all 0.4s ease;
            margin-right: 10px;
        }

        #orders-container .status-quick-filters-wrapper .status-quick-filter-tabs-wrapper .filter-tab:hover,
        #orders-container .status-quick-filters-wrapper .status-quick-filter-tabs-wrapper .filter-tab.active {
            border-color: #f27a1a;
            color: #f27a1a;
            box-shadow: 0 1px 4px 0 rgba(0, 0, 0, 0.05);
        }

        #orders-container .countdown {
            display: flex;
            flex-direction: column;
            width: 125px;
            align-items: center;
        }

        #orders-container .countdown .title {
            color: #fff;
            font-size: 10px;
            font-weight: bold;
            align-self: center;
            margin-bottom: 4px;
        }

        #orders-container .countdown .times {
            display: flex;
            align-items: center;
        }

        #orders-container .countdown .times .break {
            color: #fff;
            margin: 0 4px 0 4px;
        }

        #orders-container .countdown .times .time {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 34px;
            height: 34px;
            background: #fff;
            border-radius: 2px;
            font-family: source_sans_prosemibold, sans-serif;
            -webkit-font-smoothing: antialiased;
            font-style: normal;
            font-weight: 700;
            font-size: 18px;
        }

        #orders-container .group-deal-info {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: linear-gradient(90deg, #0BC15C -54.18%, #84B3EC 106.8%);
            border-radius: 4px;
            height: 86px;
            padding: 20px;
            margin-bottom: 20px;
            box-sizing: border-box;
        }

        #orders-container .group-deal-info .gdi-details {
            display: flex;
        }

        #orders-container .group-deal-info .gdi-details i {
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #fff;
            color: #008040;
            font-size: 10px;
            border-radius: 50%;
            width: 20px;
            height: 20px;
        }

        #orders-container .group-deal-info .gdi-details .gdi-d-content {
            display: flex;
            flex-direction: column;
            margin-left: 10px;
        }

        #orders-container .group-deal-info .gdi-details .gdi-d-content div {
            color: #fff;
            font-family: source_sans_proregular, sans-serif;
        }

        #orders-container .group-deal-info .gdi-details .gdi-d-content div.gdi-d-c-title {
            font-size: 16px;
            margin-bottom: 4px;
        }

        #orders-container .group-deal-info .gdi-details .gdi-d-content div.gdi-d-c-details {
            font-size: 11px;
        }

        #orders-container .group-deal-info .gdi-details .gdi-d-content div.gdi-d-c-details span {
            font-family: source_sans_prosemibold, sans-serif;
            font-weight: 600;
            -webkit-font-smoothing: antialiased;
        }

        #orders-container .group-deal-share-modal {
            width: 445px;
            font-family: source_sans_proregular, sans-serif;
            color: #333;
            border-radius: 4px;
        }

        #orders-container .group-deal-share-modal .gd-sm-header {
            padding: 20px;
            border-bottom: 1px solid #e6e6e6;
        }

        #orders-container .group-deal-share-modal .gd-sm-header h1 {
            width: 300px;
            margin: 0 auto;
            font-size: 18px;
            font-weight: 600;
            text-align: center;
        }

        #orders-container .group-deal-share-modal .gd-sm-content {
            padding: 0 20px 20px;
        }

        #orders-container .gd-share-description-item {
            display: flex;
            margin-top: 30px;
        }

        #orders-container .gd-share-description-item .gd-sdi-icon {
            display: flex;
            width: 48px;
            height: 48px;
            justify-content: center;
            align-items: center;
            flex-shrink: 0;
            border-radius: 50%;
            background-color: #effbf5;
        }

        #orders-container .gd-share-description-item .gd-sdi-icon i {
            font-size: 24px;
            font-style: normal;
        }

        #orders-container .gd-share-description-item .gd-sdi-icon i:before {
            color: #008040;
        }

        #orders-container .gd-share-description-item .gd-sdi-description-container {
            margin-left: 12px;
        }

        #orders-container .gd-share-description-item .gd-sdi-description-container h2 {
            font-size: 16px;
            font-weight: 600;
        }

        #orders-container .gd-share-description-item .gd-sdi-description-container p {
            margin-top: 6px;
            font-size: 11px;
        }

        #orders-container .gd-copy-link-box {
            margin-top: 30px;
            padding: 12px;
            border-radius: 4px;
            background-color: #f5f5f5;
        }

        #orders-container .gd-copy-link-box .gd-cp-lb-container {
            display: flex;
            height: 42px;
            padding: 0 10px 0 15px;
            justify-content: space-between;
            align-items: center;
            border: 1px solid #e6e6e6;
            border-radius: 3px;
            background-color: #fff;
        }

        #orders-container .gd-copy-link-box .gd-cp-lb-container>span {
            display: block;
            max-width: 278px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            font-size: 11px;
            flex-shrink: 0;
        }

        #orders-container .gd-copy-link-box .gd-cp-lb-container button {
            padding: 0;
            align-self: stretch;
            border: none;
            outline: none;
            background-color: transparent;
            color: #1f6bc1;
            cursor: pointer;
        }

        #orders-container .gd-copy-link-box .gd-cp-lb-container button .i-copy-filled {
            font-size: 18px;
            vertical-align: middle;
        }

        #orders-container .gd-copy-link-box .gd-cp-lb-container button span {
            font-size: 11px;
            font-weight: 600;
            margin-left: 5px;
        }

        #orders-container .gd-copy-link-box .gd-cp-lb-container .i-check {
            font-size: 18px;
        }

        #orders-container .gd-copy-link-box .gd-cp-lb-container .i-check i {
            font-style: normal;
        }

        #orders-container .gd-copy-link-box .gd-cp-lb-container .i-check i.path1:before {
            color: #0BC15C;
        }

        #orders-container .gd-social-share-box {
            margin-top: 10px;
            padding: 19px 25px;
            display: flex;
            justify-content: space-between;
            border: 1px solid #e6e6e6;
            border-radius: 4px;
        }

        #orders-container .gd-social-share-box button {
            padding: 0;
            border: none;
            outline: none;
            background-color: transparent;
            cursor: pointer;
        }

        #orders-container .gd-social-share-box button i {
            font-style: normal;
        }

        #orders-container .gd-social-share-box button span {
            font-size: 32px;
        }

        #orders-container .gd-social-share-box button span.i-gmail {
            font-size: 24px;
        }

        #orders-container .gd-social-share-box .separator {
            width: 1px;
            background-color: #e6e6e6;
        }

        #orders-container .cobranded-card-offer-information {
            min-height: 54px;
            background: linear-gradient(94.54deg, #FFE6D8 0%, #FFFAF8 100%);
            border-radius: 8px;
            padding: 12px 50px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        #orders-container .cobranded-card-offer-information>img {
            border-radius: 4px;
            width: 110px;
            height: 70px;
            margin-right: 40px;
        }

        #orders-container .cobranded-card-offer-information .offer-information-text-wrapper {
            min-height: 70px;
            flex: 1;
        }

        #orders-container .cobranded-card-offer-information .offer-information-text-wrapper h4 {
            margin-bottom: 6px;
            font-family: source_sans_proregular, sans-serif;
            font-weight: 600;
            -webkit-font-smoothing: antialiased;
            font-size: 20px;
            line-height: 26px;
            color: #333333;
        }

        #orders-container .cobranded-card-offer-information .offer-information-text-wrapper .information-bullets {
            display: flex;
            flex-wrap: wrap;
            column-gap: 24px;
            row-gap: 6px;
        }

        #orders-container .cobranded-card-offer-information .offer-information-text-wrapper .information-bullets li {
            display: flex;
            align-items: center;
        }

        #orders-container .cobranded-card-offer-information .offer-information-text-wrapper .information-bullets li>i {
            font-size: 11px;
            margin-right: 6px;
        }

        #orders-container .cobranded-card-offer-information .offer-information-text-wrapper .information-bullets li>i>span.path1::before {
            color: #f27a1a;
        }

        #orders-container .cobranded-card-offer-information .offer-information-text-wrapper .information-bullets li>p {
            font-family: source_sans_proregular, sans-serif;
            font-style: normal;
            font-size: 11px;
            line-height: 16px;
            color: #1C1C1C;
        }

        #orders-container .cobranded-card-offer-information .offer-information-text-wrapper .information-bullets li>p>strong {
            color: #F27A1A;
        }

        #orders-container .cobranded-card-offer-information>.apply-button {
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 200px;
            height: 28px;
            box-sizing: border-box;
            background: #f27a1a;
            border-radius: 4px;
            padding: 8px;
            transition: 0.3s ease-in;
        }

        #orders-container .cobranded-card-offer-information>.apply-button>p {
            margin-top: 1px;
            font-family: source_sans_proregular, sans-serif;
            font-weight: 600;
            -webkit-font-smoothing: antialiased;
            font-size: 11px;
            line-height: 16px;
            color: #ffffff;
        }

        #orders-container .cobranded-card-offer-information>.apply-button:hover {
            background-color: #ff8b38;
        }

        #orders-container .page-loader {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 400px;
        }

        .ty-scroll-disabled-body {
            overflow: hidden;
            position: absolute;
        }

        .type-tag {
            background: #EA2B2E !important;
            right: 15px;
            text-align: center;
            width: 60px !important;
            margin-top: 15px;
            position: absolute;
        }
    </style>
@endsection
