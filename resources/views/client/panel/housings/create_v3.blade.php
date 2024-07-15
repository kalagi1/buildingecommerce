@extends('client.layouts.masterPanel')

@section('content')
    <div class="content">
        <div id="react_render_area">
        </div>
    </div>
@endsection

@section('css')
@endsection

@section('scripts')
    <script>
        $('.advert_title').keyup(function() {
            if ($(this).val().length > 70) {
                $(this).val($(this).val().substring(0, 70))
            } else {
                changeData($(this).val(), 'name')
                $('.max-character').html(($(this).val().length) + '/70');

                if ($(this).val() != "") {
                    $(this).removeClass('error-border');
                }
            }


        })
    </script>
@endsection
