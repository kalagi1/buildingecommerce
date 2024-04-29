@extends('institutional.layouts.master')


@section('content')
    <div class="content">
        @if ($errors->any())
            <div class="alert alert-danger">
                {{ $errors->first() }}
            </div>
        @endif

        <div class="p-5 bg-white border rounded-3 shadow-lg">

            <div class="row flex-center py-5">
                <div class="col-sm-10 col-md-8 col-lg-5 col-xxl-4">
                    <div class="d-flex align-items-center fw-bolder fs-3 d-inline-block justify-content-center mb-3"><img
                            src="{{ asset('/images/emlaksepettelogo.png') }}" alt="phoenix" height="100%" width="40%">
                    </div>

                   
                        <div class="px-xxl-5">
                            <div class="text-center mb-6">
                                <h4 class="text-body-highlight" >Kurumsal Dünyaya Hoşgeldiniz</h4>
                                
                                <div class="px-xxl-5">
                                    <div class="text-center mb-6">
                                        <p class="text-body-tertiary mb-5" style="font-size: 16px;letter-spacing:1.5px;">Telefon doğrulaması başarıyla gerçekleşti.</p>                                   
                                    </div>
                                </div>

                                <p class="text-body-tertiary mb-4" style="font-size: 16px;letter-spacing:1.5px;">
                                    Ekibimiz en kısa sürede size dönüş yapacaktır.
                                </p>
                            </div>
                        </div>
                 
                
                    
                 

                </div>
            </div>


        </div>

    </div>
@endsection

@section('css')
@endsection
