@extends('client.layouts.master')
@section('content')
    <section class="about-section" style="padding: 60px 0">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3">
                    <div class="main-title text-center">
                        <h2 class="mt0">{{ $pageInfo->title }}</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-xl-12">
                    <div class="about_content">
                        <p> {!! $pageInfo->content !!} </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
