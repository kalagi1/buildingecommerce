@extends('admin.layouts.master')

@section('content')
<div class="content">
    <div class="mb-9">
        <div class="row g-3 mb-4">
            <div class="col-auto">
                <h3 class="mb-0">Cep Güncelleme Talepleri</h3>
            </div>
        </div>
        <div id="orderTable">
            

            <div class="mx-n4 px-4 mx-lg-n6 px-lg-6 bg-white border-top border-bottom border-200 position-relative top-1">
                <div class="table-responsive scrollbar mx-n1 px-1">
                    <table class="table table-sm fs--1 mb-0">
                        <thead>
                            <tr>
                                <th class="sort white-space-nowrap align-middle pe-3" scope="col" data-sort="order_no">#</th>
                                <th class="sort white-space-nowrap align-middle pe-3" scope="col" data-sort="order_no">İsim Soyisim</th>
                                <th class="sort white-space-nowrap align-middle pe-3" scope="col" data-sort="order_no">Email</th>
                                <th class="sort white-space-nowrap align-middle pe-3" scope="col" data-sort="order_no">Telefon Numarası</th>
                                <th class="sort white-space-nowrap align-middle pe-3" scope="col" data-sort="order_name">Talep Edilen Numara</th>
                                <th class="sort white-space-nowrap align-middle pe-3" scope="col" data-sort="order_date">Talep belgesi</th>
                                <th class="sort white-space-nowrap align-middle pe-3" scope="col" data-sort="order_ok">Durum</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($phoneNumbers as $phoneNumber)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $phoneNumber->user->name }}</td>
                                    <td>{{ $phoneNumber->user->email }}</td>
                                    <td>{{ $phoneNumber->user->mobile_phone }}</td>
                                    <td>{{ $phoneNumber->new_phone_number }}</td>
                                    <td>
                                        @if($phoneNumber->image_path)
                                            <button class="btn btn-primary btn-sm" onclick="openImage('{{ asset($phoneNumber->image_path) }}')">Görüntüyü Aç</button>
                                        @else
                                            Görüntü yok
                                        @endif
                                    </td>
                                    <td>
                                        @if($phoneNumber->phone_number_changed == 1)
                                            Onaylandı
                                        @else
                                            <form action="{{ route('admin.change-phone-number-status-by-user', ['userId' => $phoneNumber->user->id]) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm">Durumu Değiştir</button>
                                            </form>
                                        @endif
                                    </td>
                                    <script>
                                        function openImage(imagePath) {
                                            window.open(imagePath, '_blank');
                                        }

                                       
                                    </script>
                                    
                                    <td>{{-- Durum alanı --}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            
        </div>
    </div>
</div>
@endsection
