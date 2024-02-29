@extends('institutional.layouts.master')

@section('content')

<div class="content">
    <h3 class="text-center mt-2 mb-4">Verilen Teklifler</h3>
    <table class="table table-sm border-top border-200 fs--1 mb-0">
        <thead>
            <tr>
                <th>Proje Başlığı</th>
                <th>Oda No</th>
                <th>E-mail</th>
                <th>Teklif Aralığı</th>
                <th>Açıklama</th>
                <th>Yanıt Durumu</th>
                <th>Satış Durumu</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $item)
                <tr>
                    {{-- <td>{{ \App\Models\Project::find($item->project_id)->project_title }}</td> --}}
                    <td>{{ \App\Models\Project::find($item->project_id)->project_title }}</td>
                    <td>{{ $item->room_id }}</td>
                    <td>{{ $item->email }}</td>
                    <td>{{ $item->offer_price_range }}</td>
                    <td>{{ $item->offer_description }}</td>
                    <td>
                        @if($item->response_status == 0)
                            Henüz yanıtlanmadı
                            <span class="badge badge-warning">Henüz Yanıtlanmadı</span>

                        @elseif($item->response_status == 1 && $item->approval_status == 1)
                            <span class="badge badge-success">Olumlu Dönüş Sağlandı</span>

                        @elseif($item->response_status == 1 && $item->approval_status == 1)
                            <span class="badge badge-danger">Olumusuz Dönüş Sağlandı</span>

                        @endif
                    </td>
                   
                    <td>
                        @if($item->sales_status == 0)
                            Satışa Hazır Değil
                        @elseif($item->sales_status == 1 && $item->response_status == 1)
                            Satışa Hazır
                        @endif
                   </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    

</div>

@endsection



