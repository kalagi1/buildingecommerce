@extends('institutional.layouts.master')

@section('content')
    <div class="content">
        <div class="card">
            <div class="row">
                <div class="col-md-6">
                    <div class="choise-adv">
                        <a href="{{route('institutional.project.create.v2')}}">
                            <div class="cardx 1">
                                <div class="card_image"> <img src="https://www.emlakrotasi.com.tr/wp-content/uploads/2021/10/Emlak-konut-kampanyasi.jpg" /> </div>
                                <div class="card_title title-white">
                                  <p>Proje İlanı Ekle</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="choise-adv">
                        <a href="{{route('institutional.housing.create.v2')}}">
                            <div class="cardx 1">
                                <div class="card_image"> <img src="https://emsal.com/wp-content/uploads/2023/08/konut-fiyatlari-2023-scaled.jpg" /> </div>
                                <div class="card_title title-white">
                                  <p>Emlak İlanı Ekle</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        
    </script>
@endsection
