@extends('client.layouts.master')

@section('content')
    <section class="notfound pt-0">
        <div class="container">
            <div class="top-headings text-center">
                <img src="https://code-theme.com/html/findhouses/images/bg/error-404.jpg" alt="Page 404">
                <h3 class="text-center">Sayfa Bulunamadı</h3>
                <p class="text-center">Hata! Bir şeyler ters gidiyor gibi görünüyor Aradığınız sayfayı bulamıyoruz, doğru
                    URL'yi yazdığınızdan emin olun </p>
            </div>
            <a href="{{ url('/') }}" class="btn btn-primary"
                style="margin: 0 auto;
            display: flex;
            justify-content: center;
            width: 150px;">Anasayfaya
                Dön</a>

        </div>
    </section>
@endsection

@section('scripts')
    <script></script>
@endsection

@section('styles')
@endsection
