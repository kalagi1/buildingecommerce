@extends('institutional.layouts.master')

@section('content')
    <div class="content">
        <h3 class=" mt-2 mb-4">Başvurularım</h3>
        <div class="mx-n4 px-4 mx-lg-n6 px-lg-6 bg-white ">
            <div class="table-responsive mx-n1 px-1 scrollbar">
                <table class="table table-sm fs--1 mb-0">
                    <thead>
                        <tr>
                            <th>Profil</th>
                            <th>Teklif Veren</th>
                            <th style="width:200px">Proje Başlığı</th>
                            <th>İsim</th>
                            <th>Telefon</th>
                            <th>Meslek</th>
                            <th>E-mail</th>
                            <th>Açıklama</th>
                            <th>Yanıt Durumu</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-xl mr-2">
                                            <img src="{{ asset('storage/profile_images/' . $item->user->profile_image) }}"
                                                class="avatar-img rounded-circle" alt="">
                                        </div>
                                    </div>
                                </td>
                                <td> {{ $item->user->name }} <br><br>
                                    <span style="font-size: 10px;color:black;font-weight:700">
                                        {{ $item->city ? $item->city->title : null }}
                                        {{ $item->district ? ' - ' . $item->district->ilce_title : null }}</span>
                                </td>

                                <td>{{ $item->project->project_title . ' Projesindeki ' . $item->room_id . " No'lu İlan" }}
                                </td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->phone }}</td>
                                <td>{{ $item->title }}</td>

                                <td>{{ $item->email }}</td>
                                <td>{{ $item->offer_description }}</td>
                                <td>

                                    @if ($item->response_status == 0)
                                        Henüz yanıtlanmadı
                                        <span class="badge badge-warning">Henüz Yanıtlanmadı</span>
                                    @endif

                                    @if ($item->approval_status == 1)
                                        <span class="badge badge-success">Olumlu Dönüş Sağlandı</span>
                                    @endif

                                    @if ($item->approval_status == 0)
                                        <span class="badge badge-danger">Olumusuz Dönüş Sağlandı</span>
                                    @endif
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
