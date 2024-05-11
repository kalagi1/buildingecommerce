@extends('institutional.layouts.master')

@section('content')
    @if (!in_array('CreateProject', $userPermissions))
        @php
            abort(403, 'Bu sayfaya erişim yetkiniz yok.');
        @endphp
    @else
        <div class="content">
            <div id="react_render_area">

            </div>
        </div>
    @endif
@endsection

@section('css')
@endsection
