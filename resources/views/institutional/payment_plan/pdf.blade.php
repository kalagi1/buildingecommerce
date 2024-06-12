<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta charset="utf-8">
    <title>Document</title>
    <style>
        
    </style>
    <style>
        body{
            font-family: "DejaVu Sans", sans-serif;
        }
        td{
            margin: 5px 0
        }
        @font-face {
            font-family: 'DejaVuSans';
            src: url('{{ public_path('fonts/DejaVuSans.ttf') }}') format('truetype');
        }
        @page {
            margin: 100px 25px;
        }
        header {
            position: fixed;
            top: -80px;
            left: 0px;
            right: 0px;
            line-height: 35px;
            font-size: 16px;
            font-weight: bold;
        }
        footer {
            position: fixed;
            bottom: -60px;
            left: 0px;
            right: 0px;
            height: 50px;
            text-align: center;
            line-height: 35px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        
    </style>
    </style>
</head>
<body>
    <header>
        <div>
            <img style="width: 100px;opacity: .65;float: left;" src="https://emlaksepette.com/storage/profile_images/profile_image_1701198728.png" alt="">
            <h5 style="float: left;">{{$project->project_title}} {{$roomOrder}} Nolu Konut</h5>
        </div>
    </header>
    <main>
        <div class="order-detail-inner px-3 pt-3 pb-0">
            <div class="title">
                <h4>Alıcı Bilgileri</h4>
            </div>
            <div class="" style="display: flex;border: 1px solid #ebebeb !important;padding:2px 10px">
                <div class="col-md-3" style="width: 32%;float:left;margin-right: 1%;">
                    <p>İsim Soyisim</p>
                    <span>
                        <strong class="d-flex" style="align-items: center;">{{$cartOrder->full_name}}</strong>
                    </span>
                </div>
    
                <div class="col-md-3" style="width: 32%;float:left;margin-right: 1%;">
                    <p>Telefon</p>
                    <span>
                        <strong class="d-flex" style="align-items: center;">
                            {{$cartOrder->phone}}
                        </strong>
                    </span>
                </div>
    
                <div class="col-md-3" style="width: 32%;float:left;margin-right: 1%;">
                    <p>E-Posta</p>
                    <span>
                        <strong class="d-flex" style="align-items: center;">
                            {{$cartOrder->email}}
                        </strong>
                    </span>
                </div>
                <div style="clear:both;"></div>
            </div>
            <div class="title">
                <svg class="svg-inline--fa fa-user" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="user" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg=""><path fill="currentColor" d="M224 256c70.7 0 128-57.31 128-128s-57.3-128-128-128C153.3 0 96 57.31 96 128S153.3 256 224 256zM274.7 304H173.3C77.61 304 0 381.6 0 477.3c0 19.14 15.52 34.67 34.66 34.67h378.7C432.5 512 448 496.5 448 477.3C448 381.6 370.4 304 274.7 304z"></path></svg><!-- <i class="fa fa-user"></i> Font Awesome fontawesome.com -->
                <h4>Satış Bilgileri</h4>
            </div>
            <div class="" style="display: flex;border: 1px solid #ebebeb !important;padding:2px 10px;">
                
                <div class="col-md-3" style="width: 32%;float:left;margin-right: 1%;">
                    <p>Satın Alma Şekli</p>
                    <span>
                        <strong class="d-flex" style="align-items: center;">
                            {{$cartOrder->is_swap == 0 ? "Peşin" : "Taksitli"}}
                        </strong>
                    </span>
                </div>
                <div class="col-md-3" style="width: 32%;float:left;margin-right: 1%;">
                    <p>Alınan Fiyat</p>
                    @if($cartOrder->is_swap == 0)
                        <span>
                            <strong class="d-flex" style="align-items: center;">
                                {{number_format($roomPrice->value, 0, '', '.')}}₺
                            </strong>
                        </span>
                    @else 
                        <span>
                            <strong class="d-flex" style="align-items: center;">
                                {{number_format($installmentPrice->value, 0, '', '.')}}₺
                            </strong>
                        </span>
                    @endif
                </div>
                @if($cartOrder->is_swap == 1)
                <div class="col-md-3" style="width: 32%;float:left;margin-right: 1%;">
                    <p>Peşinat</p>
                    <span>
                        <strong class="d-flex" style="align-items: center;">
                            {{number_format($advance->value, 0, '', '.')}}₺
                        </strong>
                    </span>
                </div>
                @endif
                <div style="clear:both;"></div>
            </div>
            
            <div class="title">
                <h4>Ödeme Bilgileri</h4>
            </div>
            <div class="" style="display: flex;border: 1px solid #ebebeb !important;padding:2px 10px">
                <div class="col-md-3" style="width: 49%;float:left;margin-right: 1%;">
                    <p>Ödenen Tutar</p>
                    <span>
                        <strong class="d-flex" style="align-items: center;">{{number_format($paidPrice, 0, '', '.')}}₺</strong>
                    </span>
                </div>
    
                <div class="col-md-3" style="width: 49%;float:left;margin-right: 1%;">
                    <p>Kalan Ödeme</p>
                    <span>
                        <strong class="d-flex" style="align-items: center;">
                            {{number_format($remainingPayment, 0, '', '.')}}₺
                        </strong>
                    </span>
                </div>
                <div style="clear:both;"></div>
            </div>
            
            @if($cartOrder->is_swap)
                <div class="title">
                    <svg class="svg-inline--fa fa-user" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="user" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg=""><path fill="currentColor" d="M224 256c70.7 0 128-57.31 128-128s-57.3-128-128-128C153.3 0 96 57.31 96 128S153.3 256 224 256zM274.7 304H173.3C77.61 304 0 381.6 0 477.3c0 19.14 15.52 34.67 34.66 34.67h378.7C432.5 512 448 496.5 448 477.3C448 381.6 370.4 304 274.7 304z"></path></svg><!-- <i class="fa fa-user"></i> Font Awesome fontawesome.com -->
                    <h4>Genel Ödemeler ({{$payDecCount}})</h4>
                </div>
                <div style="display: flex;border: 1px solid #ebebeb !important;padding:2px 10px;">
                    <table style="width: 100%;padding: 0 20px">
                        <thead>
                            <tr>
                                <th style="text-align: left">Başlık</th>
                                <th style="text-align: left">Ödeme Tarihi</th>
                                <th style="text-align: left">Ödenen Tutar</th>
                                <th style="text-align: left">Ödeme Durumu</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="text-align: left">Kapora</td>
                                <td style="text-align: left">{{ $paymentSetting->deposit_date ? date('d.m.Y',strtotime($paymentSetting->deposit_date)) : '' }}</td>
                                <td style="text-align: left">{{number_format($paymentSetting->down_payment_price, 0, '', '.')}}₺</td>
                                
                                @if($paymentSetting->down_payment)
                                    <td style="text-align: left"><span style="background: green;padding: 3px 10px;color: #fff;">Alındı</span></td>
                                @else 
                                    <td style="text-align: left"><span style="background: red;padding: 3px 10px;color: #fff;">Alınmadı</span></td>
                                @endif
                            </tr>
                            <tr>
                                <td style="text-align: left">Peşinat</td>
                                <td style="text-align: left">{{ $paymentSetting->advance_date ? date('d.m.Y',strtotime($paymentSetting->advance_date)) : '' }}</td>
                                <td style="text-align: left">{{number_format($advance->value - $paymentSetting->down_payment_price, 0, '', '.')}}₺</td>
                                
                                @if($paymentSetting->advance)
                                    <td style="text-align: left"><span style="background: green;padding: 3px 10px;color: #fff;">Alındı</span></td>
                                @else 
                                    <td style="text-align: left"><span style="background: red;padding: 3px 10px;color: #fff;">Alınmadı</span></td>
                                @endif
                            </tr>
                            @for($i = 0; $i < $payDecCount; $i++)
                                <tr>
                                    <td style="text-align: left">{{$i + 1}}. Ara Ödeme</td>
                                    <td style="text-align: left">{{date('d.m.Y',strtotime($payDecs['pay_desc_date'.$roomOrder.$i]->value))}}</td>
                                    <td style="text-align: left">{{number_format($payDecs['pay_desc_price'.$roomOrder.$i]->value, 0, '', '.')}}₺</td>
                                    
                                    @if(in_array($i+1,$paidPayDecs))
                                        <td style="text-align: left"><span style="background: green;padding: 3px 10px;color: #fff;">Alındı</span></td>
                                    @else 
                                        <td style="text-align: left"><span style="background: red;padding: 3px 10px;color: #fff;">Alınmadı</span></td>
                                    @endif
                                </tr>
                            @endfor
                            
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="title">
                <svg class="svg-inline--fa fa-user" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="user" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg=""><path fill="currentColor" d="M224 256c70.7 0 128-57.31 128-128s-57.3-128-128-128C153.3 0 96 57.31 96 128S153.3 256 224 256zM274.7 304H173.3C77.61 304 0 381.6 0 477.3c0 19.14 15.52 34.67 34.66 34.67h378.7C432.5 512 448 496.5 448 477.3C448 381.6 370.4 304 274.7 304z"></path></svg><!-- <i class="fa fa-user"></i> Font Awesome fontawesome.com -->
                <h4>Taksitler (24)</h4>
            </div>
            <div style="display: flex;border: 1px solid #ebebeb !important;padding:2px 10px;">
                <table style="width: 100%;padding: 0 20px">
                    <thead>
                        <tr>
                            <th style="text-align: left">#</th>
                            <th style="text-align: left">Ödeme Tarihi</th>
                            <th style="text-align: left">Ödenen Tarih</th>
                            <th style="text-align: left">Ödenen Tutar</th>
                            <th style="text-align: left">Ödeme Tipi</th>
                            <th style="text-align: left">Ödeme Açıklaması</th>
                            <th style="text-align: left">Ödeme Durumu</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($installments as $key => $installment)
                        <tr>
                            <td>{{$key + 1}}</td>
                            <td style="text-align: left">{{date('d.m.Y',strtotime($installment->date))}}</td>
                            <td style="text-align: left">{{$installment->payment_date ? date('d.m.Y',strtotime($installment->payment_date)) : 'Belirtilmedi'}}</td>
                            <td style="text-align: left">{{number_format($installment->price, 0, '', '.')}}₺</td>
                            <td style="text-align: left">{{$installment->paymentType}}</td>
                            <td style="text-align: left">{{$installment->description}}</td>
                            
                            @if($installment->is_payment)
                                <td style="text-align: left"><span style="background: green;padding: 3px 10px;color: #fff;">Alındı</span></td>
                            @else 
                                <td style="text-align: left"><span style="background: red;padding: 3px 10px;color: #fff;">Alınmadı</span></td>
                            @endif
                        </tr>
                        @endforeach
                        
                    </tbody>
                </table>
            </div>
            @endif
        </div>
    </main>
</body>
</html>