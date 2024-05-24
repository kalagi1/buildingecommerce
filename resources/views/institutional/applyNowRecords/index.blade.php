@extends('institutional.layouts.master')

@section('content')
    <div class="content">
        <h3 class="mt-2 mb-4">Başvurularım</h3>
        <div class="mx-n4 px-4 mx-lg-n6 px-lg-6 bg-white">
            <div class="table-responsive mx-n1 px-1 scrollbar">
                <table class="table table-sm fs--1 mb-0">
                    <thead>
                        <tr>
                            <th>Ad</th>
                            <th>Soyad</th>
                            <th>Email</th>
                            <th>Telefon</th>
                            <th>Başlık</th>
                            <th>Proje ID</th>
                            <th>Oluşturma Tarihi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($applyNowRecords as $record)
                            <tr>
                                <td>{{ $record->name }}</td>
                                <td>{{ $record->surname }}</td>
                                <td>{{ $record->email }}</td>
                                <td>{{ $record->phone }}</td>
                                <td>{{ $record->title }}</td>
                                <td>{{ $record->project->name }}</td>
                                <td>{{ $record->created_at }}</td>
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
