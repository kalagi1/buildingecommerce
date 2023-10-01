@extends('admin.layouts.master')

@section('content')
    <div class="content">
        <h2 class="mb-2 lh-sm">Konut Yorumları</h2>
        <div class="mt-4">
            <div class="row g-4">
                <div class="col-12 col-xl-12  order-1 order-xl-0">
                    <div class="mb-9">
                        <div class="card shadow-none border border-300 my-4 p-5">
                            <div class="table-responsive scrollbar">
                                <table class="table fs--1 mb-0 border-top border-200">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Yorum</th>
                                            <th>Oy</th>
                                            <th>Tarih</th>
                                            <th>Durum</th>
                                        </tr>
                                    </thead>
                                    <tbody class="list">
                                        @foreach ($housing as $housingType)
                                            <tr>
                                                <td class="align-middle id">{{ $housingType->id }}</td>
                                                <td class="align-middle housing_type">{{ $housingType->comment }}
                                                    <div class="row">
                                                        @foreach (json_decode($housingType->images) as $image)
                                                            @php
                                                                $imagePath = str_replace('public/', '', $image);
                                                            @endphp
                                                            <div class="col-md-2">
                                                                <a href="{{ asset('storage/' . $imagePath) }}" data-lightbox="gallery">
                                                                    <img src="{{ asset('storage/' . $imagePath) }}" class="d-inline-block me-2" style="width: 100%" />
                                                                </a>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </td>
                                                <td class="align-middle housing_type">{{ $housingType->rate }}
                                                    Yıldız</td>
                                                <td class="align-middle created_at">
                                                    {{ $housingType->created_at->format('d/m/Y') }}</td>
                                                <td class="align-middle">
                                                    @if ($housingType->status)
                                                        <a class="btn btn-danger"
                                                            href="{{ route('admin.housings.unapprove', $housingType->id) }}">Onayı
                                                            Kaldır</a>
                                                    @else
                                                        <a class="btn btn-primary"
                                                            href="{{ route('admin.housings.approve', $housingType->id) }}">Onayla</a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>

                            </div>


                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    </div>
@endsection

@section('scripts')
<!-- lightbox2 CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet">
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- lightbox2 JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>

@endsection
