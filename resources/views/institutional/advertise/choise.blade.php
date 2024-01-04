@extends('institutional.layouts.master')

@section('content')
    <div class="content">
        <div class="row justify-content-center">
            <div class="col-md-4 col-6">
                <div class="choise-adv">
                    <a class="choise-adv-inner" href="{{ route('institutional.project.create.v2') }}">
                        <div class="card_image"> 
                            <img
                                src="{{URL::to('/')}}/proje.png" />
                        </div>
                        <div class="card_title title-white">
                            <p style="background: #ea2a28;">Proje İlanı Ekle</p>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-md-4 col-6">
                <div class="choise-adv">
                    <a class="choise-adv-inner" href="{{ route('institutional.housing.create.v2') }}">
                        <div class="card_image"> <img
                                src="{{URL::to('/')}}/emlak.png" />
                        </div>
                        <div class="card_title title-white">
                            <p style="background: #004aad;">Emlak İlanı Ekle</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script></script>
@endsection
