@extends('client.layouts.master')
@section('content')
    <section class="properties-right list featured portfolio blog pt-5 bg-white">
        <div class="container">
            {!! $pageInfo->content !!}
        </div>
    </section>
@endsection
