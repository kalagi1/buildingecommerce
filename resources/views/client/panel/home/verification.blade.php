@extends('client.layouts.masterPanel')


@section('content')

    <div class="table-breadcrumb">
        <ul>
            <li>
                Hesabım
            </li>
            <li>
                Belge Yükleme
            </li>
        </ul>
    </div>


    <section>
        <div class="row justify-content-center">
            <div class="col-12 col-xxl-11">
                <div class="card border-light-subtle shadow-sm">
                    <div class="row g-0">
                        <div class="col-12 col-md-12 d-flex align-items-center justify-content-center ">
                            <div class="col-12 col-lg-11 col-xl-10">
                                <div class="card-body ">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="mb-5 mt-5">
                                                <h2 class="h4 text-center">Sistemi kullanmaya devam edebilmeniz için
                                                    hesabınızı doğrulamamız gerekiyor.</h2>
                                                <h3 class="fs-6 fw-normal text-secondary text-center m-0">
                                                    <div class="text-success">
                                                        @if (!is_null(auth()->user()->tax_document) || !is_null(auth()->user()->record_document))
                                                            Belgeleriniz gönderildi. En geç 12 saat içerisinde inceleme
                                                            sonucu tarafınıza
                                                            iletilecektir.
                                                            Dilerseniz gönderdiğiniz belgeleri
                                                            güncelleyebilirsiniz. <br>
                                                            @if ($user->corporate_account_note)
                                                                <div style="color: red">
                                                                    <i class="fa fa-exclamation" aria-hidden="true"></i>
                                                                    Emlak Sepette Yönetiminden Uyarı: {{ $user->corporate_account_note }}
                                                                </div>
                                                            @endif
                                                        @else
                                                            Sistemi kullanmaya devam edebilmeniz için hesabınızı
                                                            doğrulamamız gerekiyor.<br />
                                                            Lütfen aşağıda istenen belgeleri bize gönderin.
                                                        @endif
                                                    </div>

                                                    @if (auth()->user()->identity_document_approve == 1 &&
                                                            auth()->user()->record_document_approve == 1 &&
                                                            auth()->user()->tax_document_approve == 1)
                                                        <div class="text-warning mt-2">
                                                            Hesabınıza hala erişemiyorsanız lütfen <a
                                                                href="mailto:support@emlaksepette.com">support@emlaksepette.com</a>
                                                            adresinden site yönetici
                                                            ile iletişime geçin.
                                                        </div>
                                                    @endif

                                                </h3>
                                            </div>
                                        </div>
                                    </div>
                                    <form action="{{ route('institutional.verify-account') }}" enctype="multipart/form-data"
                                        method="POST">
                                        @csrf
                                        <div class="">

                                            <div class="form-group">
                                                <label for="sicil_belgesi" class="mb-2 d-flex align-items-center">Vergi
                                                    Levhası:

                                                    @if (!is_null(auth()->user()->record_document))
                                                        <div class="ml-2 mr-2">
                                                            <a target="_blank"
                                                                href="{{ url('record_documents/' . auth()->user()->record_document) }}"
                                                                download><i class="fa fa-download"></i></a>
                                                        </div>
                                                    @endif

                                                    @if (auth()->user()->record_document_approve)
                                                        <span class="checkmark"></span> <span
                                                            style="color:green">Onaylandı</span>
                                                    @endif
                                                </label>

                                                <label for="sicil_belgesi" class="attachment">
                                                    <div class="row btn-file">
                                                        <div class="btn-file__preview"></div>
                                                        <div
                                                            class="btn-file__actions {{ auth()->user()->record_document_approve ? ' greenBorder' : '' }}">
                                                            <div class="btn-file__actions__item col-xs-12 text-center">
                                                                <div class="btn-file__actions__item--shadow">
                                                                    <i class="fa fa-plus fa-lg fa-fw"
                                                                        aria-hidden="true"></i>
                                                                    <div class="visible-xs-block"></div>
                                                                    Dosya Seç
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <input name="sicil_belgesi" type="file" id="sicil_belgesi"
                                                        class="{{ auth()->user()->record_document_approve ? ' greenBorder' : '' }}"
                                                        accept=".png,.jpeg,.jpg,.pdf"{{ auth()->user()->record_document_approve == 0 ? ' ' : null }}>

                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <label for="vergi_levhasi" class="mb-2 d-flex align-items-center">İmza
                                                    Sirküsü:

                                                    @if (!is_null(auth()->user()->tax_document))
                                                        <div class="ml-2 mr-2">
                                                            <a target="_blank"
                                                                href="{{ url('tax_documents/' . auth()->user()->tax_document) }}"
                                                                download><i class="fa fa-download"></i></a>
                                                        </div>
                                                    @endif

                                                    @if (auth()->user()->tax_document_approve)
                                                        <span class="checkmark"></span> <span
                                                            style="color:green">Onaylandı</span>
                                                    @endif
                                                </label>
                                                <label for="vergi_levhasi" class="attachment">
                                                    <div class="row btn-file">
                                                        <div class="btn-file__preview"></div>
                                                        <div
                                                            class="btn-file__actions  {{ auth()->user()->tax_document_approve ? ' greenBorder' : '' }}">
                                                            <div class="btn-file__actions__item col-xs-12 text-center">
                                                                <div class="btn-file__actions__item--shadow">
                                                                    <i class="fa fa-plus fa-lg fa-fw"
                                                                        aria-hidden="true"></i>
                                                                    <div class="visible-xs-block"></div>
                                                                    Dosya Seç
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <input type="file" name="vergi_levhasi" id="vergi_levhasi"
                                                        class="form-control {{ auth()->user()->tax_document_approve ? ' greenBorder' : '' }}"
                                                        accept=".png,.jpeg,.jpg,.pdf"{{ auth()->user()->tax_document_approve ? ' ' : null }} />
                                                </label>

                                            </div>
                                            @if (auth()->user()->type == 2 && auth()->user()->corporate_type == 'Emlak Ofisi')
                                                <div class="form-group">
                                                    <label for="kimlik_belgesi"
                                                        class="mb-2 d-flex align-items-center">Taşınmaz Yetki Belgesi:


                                                        @if (!is_null(auth()->user()->identity_document))
                                                            <div class="ml-2 mr-2">
                                                                <a target="_blank"
                                                                    href="{{ url('identity_documents/' . auth()->user()->identity_document) }}"
                                                                    download><i class="fa fa-download"></i></a>
                                                            </div>
                                                        @endif

                                                        @if (auth()->user()->identity_document_approve)
                                                            <span class="checkmark"></span> <span
                                                                style="color:green">Onaylandı</span>
                                                        @endif
                                                    </label>
                                                    <label for="kimlik_belgesi" class="attachment">
                                                        <div class="row btn-file">
                                                            <div class="btn-file__preview"></div>
                                                            <div
                                                                class="btn-file__actions {{ auth()->user()->identity_document_approve ? ' greenBorder' : '' }}">
                                                                <div class="btn-file__actions__item col-xs-12 text-center">
                                                                    <div class="btn-file__actions__item--shadow">
                                                                        <i class="fa fa-plus fa-lg fa-fw"
                                                                            aria-hidden="true"></i>
                                                                        <div class="visible-xs-block"></div>
                                                                        Dosya Seç
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <input type="file" name="kimlik_belgesi" id="kimlik_belgesi"
                                                            class="form-control {{ auth()->user()->identity_document_approve ? ' greenBorder' : '' }}"
                                                            accept=".png,.jpeg,.jpg,.pdf"{{ auth()->user()->identity_document_approve == 0 ? ' ' : null }} />
                                                    </label>
                                                </div>
                                            @endif
                                            @if (auth()->user()->type == 2 && auth()->user()->corporate_type == 'Turizm Amaçlı Kiralama')
                                                <div class="form-group">
                                                    <label for="kimlik_belgesi"
                                                        class="mb-2 d-flex align-items-center">Acenta Belgesi:


                                                        @if (!is_null(auth()->user()->identity_document))
                                                            <div class="ml-2 mr-2">
                                                                <a target="_blank"
                                                                    href="{{ url('identity_documents/' . auth()->user()->identity_document) }}"
                                                                    download><i class="fa fa-download"></i></a>
                                                            </div>
                                                        @endif
                                                        @if (auth()->user()->identity_document_approve)
                                                            <span class="checkmark"></span> <span
                                                                style="color:green">Onaylandı</span>
                                                        @endif
                                                    </label>
                                                    <label for="kimlik_belgesi" class="attachment">
                                                        <div class="row btn-file">
                                                            <div class="btn-file__preview"></div>
                                                            <div
                                                                class="btn-file__actions  {{ auth()->user()->identity_document_approve ? ' greenBorder' : '' }}">
                                                                <div class="btn-file__actions__item col-xs-12 text-center">
                                                                    <div class="btn-file__actions__item--shadow">
                                                                        <i class="fa fa-plus fa-lg fa-fw"
                                                                            aria-hidden="true"></i>
                                                                        <div class="visible-xs-block"></div>
                                                                        Dosya Seç
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <input type="file" name="kimlik_belgesi" id="kimlik_belgesi"
                                                            class="form-control {{ auth()->user()->identity_document_approve ? ' greenBorder' : '' }}"
                                                            accept=".png,.jpeg,.jpg,.pdf"{{ auth()->user()->identity_document_approve == 0 ? ' ' : null }} />
                                                    </label>
                                                </div>
                                            @endif

                                            @if (auth()->user()->type == 2 && auth()->user()->corporate_type == 'İnşaat Ofisi')
                                                <div class="form-group">
                                                    <label for="insaat_belgesi"
                                                        class="mb-2 d-flex align-items-center">Müteahhitlik Belgesi
                                                        (Opsiyonel):

                                                        @if (!is_null(auth()->user()->company_document))
                                                            <div class="ml-2 mr-2">
                                                                <a target="_blank"
                                                                    href="{{ url('company_documents/' . auth()->user()->company_document) }}"
                                                                    class=" mb-2"><i class="fa fa-download"></i></a>
                                                            </div>
                                                        @endif

                                                        @if (auth()->user()->company_document_approve)
                                                            <span class="checkmark"></span> <span
                                                                style="color:green">Onaylandı</span>
                                                        @endif

                                                    </label>
                                                    <label for="insaat_belgesi" class="attachment">
                                                        <div class="row btn-file">
                                                            <div class="btn-file__preview"></div>
                                                            <div
                                                                class="btn-file__actions {{ auth()->user()->company_document_approve ? ' greenBorder' : '' }}">
                                                                <div class="btn-file__actions__item col-xs-12 text-center">
                                                                    <div class="btn-file__actions__item--shadow">
                                                                        <i class="fa fa-plus fa-lg fa-fw"
                                                                            aria-hidden="true"></i>
                                                                        <div class="visible-xs-block"></div>
                                                                        Dosya Seç
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <input type="file" name="insaat_belgesi" id="insaat_belgesi"
                                                            class="form-control {{ auth()->user()->company_document_approve ? ' greenBorder' : '' }}"
                                                            accept=".png,.jpeg,.jpg,.pdf"{{ auth()->user()->company_document_approve == 0 ? ' ' : null }} />
                                                    </label>
                                                </div>
                                            @endif
                                            <div class="form-group">
                                                <label for="approve_website" class="mb-2 d-flex align-items-center">İmzalı
                                                    Onay Belgesi
                                                    Yükleyiniz

                                                    @if (!is_null(auth()->user()->approve_website))
                                                        <div class="ml-2 mr-2">
                                                            <a target="_blank"
                                                                href="{{ url('approve_websites/' . auth()->user()->approve_website) }}"
                                                                download><i class="fa fa-download"></i></a>
                                                        </div>
                                                    @endif

                                                    @if (auth()->user()->approve_website_approve)
                                                        <span class="checkmark"></span> <span
                                                            style="color:green">Onaylandı</span>
                                                    @endif
                                                </label>
                                                <label for="approve_website" class="attachment">
                                                    <div class="row btn-file">
                                                        <div class="btn-file__preview"></div>
                                                        <div
                                                            class="btn-file__actions {{ auth()->user()->approve_website_approve ? ' greenBorder' : '' }}">
                                                            <div class="btn-file__actions__item col-xs-12 text-center">
                                                                <div class="btn-file__actions__item--shadow">
                                                                    <i class="fa fa-plus fa-lg fa-fw"
                                                                        aria-hidden="true"></i>
                                                                    <div class="visible-xs-block"></div>
                                                                    Dosya Seç
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <input type="file" name="approve_website" id="approve_website"
                                                        class="form-control {{ auth()->user()->approve_website_approve ? ' greenBorder' : '' }}"
                                                        accept=".png,.jpeg,.jpg,.pdf"{{ auth()->user()->approve_website_approve == 0 ? ' ' : null }} />
                                                </label>
                                            </div>

                                            <div class="form-group mt-5">
                                                @if (
                                                    !is_null(auth()->user()->tax_document) ||
                                                        !is_null(auth()->user()->record_document) ||
                                                        !is_null(auth()->user()->identity_document))
                                                    <button type="submit" class="btn btn-primary">GÜNCELLE</button>
                                                @else
                                                    <button type="submit" class="btn btn-primary">ONAYA
                                                        GÖNDER</button>
                                                @endif
                                                <a href="{{ route('index') }}" class="backToHome">
                                                    <button type="button" class="btn btn-primary">Anasayfa'ya Dön
                                                    </button>
                                                </a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- <section class="d-map section-full p-t80 p-b80 overflow-hide graph-slide-image"
        style="background-image:url(images/bg/map.png);">
        <div class="section-content">
            <div class="container">
                <div class="map-animation-block clearfix p-b30">
                    <div class="map-animation-right text-white aos-init aos-animate" data-aos="fade-left">
                        <h2>Explore the World</h2>
                        <p>The best place for elit, sed do eiusmod tempor dolor sit amet, conse ctetur adipiscing elit, sed
                            do eiusmod tempor incididunt ut labore et lorna aliquatd minimam, quis nostrud exercitation oris
                            nisi ut aliquip.
                        </p>
                        <div class="bg-all">
                            <a href="listings-full-grid.html" class="btn btn-outline-light mt-2">View All</a>
                        </div>
                    </div>
                    <div class="map-animation-left">
                        <div class="map-marker-block aos-init aos-animate" data-aos="fade-right">
                            <img src="{{ asset('3d-map.png') }}" alt="" class="map-bg">
                            <div class="map-marker-position position-1">
                                <div class="map-marker  vert-move1">
                                    <div class="map-pin bg-secondry"><img src="{{ asset('10.png') }}" alt="">
                                    </div>
                                    <div class="pin-pulse"></div>
                                </div>
                            </div>
                            <div class="map-marker-position position-2 scale-75">
                                <div class="map-marker vert-move2">
                                    <div class="map-pin bg-secondry"><img src="{{ asset('10.png') }}" alt="">
                                    </div>
                                    <div class="pin-pulse"></div>
                                </div>
                            </div>
                            <div class="map-marker-position position-3 scale-75">
                                <div class="map-marker  vert-move2">
                                    <div class="map-pin bg-secondry"><img src="{{ asset('10.png') }}" alt="">
                                    </div>
                                    <div class="pin-pulse"></div>
                                </div>
                            </div>
                            <div class="map-marker-position position-4 scale-50">
                                <div class="map-marker  vert-move2">
                                    <div class="map-pin bg-secondry"><img src="{{ asset('10.png') }}" alt="">
                                    </div>
                                    <div class="pin-pulse"></div>
                                </div>
                            </div>
                            <div class="map-marker-position position-5 scale-50">
                                <div class="map-marker vert-move1">
                                    <div class="map-pin bg-secondry"><img src="{{ asset('10.png') }}" alt="">
                                    </div>
                                    <div class="pin-pulse"></div>
                                </div>
                            </div>
                            <div class="map-marker-position position-6 scale-50">
                                <div class="map-marker  vert-move2">
                                    <div class="map-pin bg-secondry"><img src="{{ asset('10.png') }}" alt="">
                                    </div>
                                    <div class="pin-pulse"></div>
                                </div>
                            </div>
                            <div class="map-marker-position position-7 scale-50">
                                <div class="map-marker vert-move1">
                                    <div class="map-pin bg-secondry"><img src="{{ asset('10.png') }}" alt="">
                                    </div>
                                    <div class="pin-pulse"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}
@endsection


@section('scripts')
    <script>
        jQuery(($) => {
            $('input[type="file"]').on('change', (event) => {
                const el = $(event.target).closest('.attachment').find('.btn-file');
                const file = event.target.files[0];
                const preview = el.find('.btn-file__preview');

                if (file) {
                    const fileType = file.type;

                    // Temizle
                    preview.css('background-image', 'none').html('');

                    if (fileType.startsWith('image/')) {
                        // Resim dosyaları için küçük önizleme
                        preview.css({
                            'background-image': 'url(' + window.URL.createObjectURL(file) + ')',
                            'background-size': 'contain',
                            'background-repeat': 'no-repeat',
                            'background-position': 'center'
                        });
                    } else if (fileType === 'application/pdf') {
                        // PDF dosyaları için simge
                        preview.html('<i class="fa fa-file-pdf-o fa-2x"></i>').css({
                            'display': 'flex',
                            'justify-content': 'center',
                            'align-items': 'center',
                            'height': '100%'
                        });
                    } else {
                        // Diğer dosya türleri için simge
                        preview.html('<i class="fa fa-file fa-2x"></i>').css({
                            'display': 'flex',
                            'justify-content': 'center',
                            'align-items': 'center',
                            'height': '100%'
                        });
                    }

                    el.find('.btn-file__actions__item').css('padding', '135px');
                }
            });
        });
    </script>
@endsection


@section('styles')
    <link rel="stylesheet" href="{{ asset('css/map.css') }}">
    <style>
        .btn-file {
            margin: 0;
            padding: 0;
            position: relative;
            z-index: 1;
        }

        .btn-file__actions {
            margin: 0;
            padding: 0;
            width: 100%;
        }

        .btn-file__actions__item {
            padding: 35px;
            font-size: 1.5em;
            color: #d3e0e9;
            cursor: pointer;
            text-decoration: none;
            border-top: 1px dashed #d3e0e9;
            border-left: 1px dashed #d3e0e9;
            border-bottom: 1px dashed #d3e0e9;
        }

        .greenBorder .btn-file__actions__item {

            border-top: 1px dashed green;
            border-left: 1px dashed green;
            border-bottom: 1px dashed green;
        }

        .btn-file__actions__item:first-child {
            border-top-left-radius: 35px;
            border-bottom-left-radius: 35px;
        }

        .greenBorder .btn-file__actions__item:last-child {
            border-top-right-radius: 35px;
            border-bottom-right-radius: 35px;
            border-right: 1px dashed green;
        }

        .btn-file__actions__item:last-child {
            border-top-right-radius: 35px;
            border-bottom-right-radius: 35px;
            border-right: 1px dashed #d3e0e9;
        }

        .btn-file__actions__item:hover,
        .btn-file__actions__item:focus {
            color: #636b6f;
            background-color: rgba(211, 224, 233, 0.1);
        }

        .btn-file__actions__item:hover--shadow,
        .btn-file__actions__item:focus--shadow {
            box-shadow: #d3e0e9 0 0 60px 15px;
        }

        .btn-file__actions__item--shadow {
            display: inline-block;
            position: relative;
            z-index: 1;
            font-size: 13px
        }

        .btn-file__actions__item--shadow::before {
            content: " ";
            box-shadow: #fff 0 0 60px 40px;
            display: inline-block;
            position: absolute;
            top: 50%;
            left: 0;
            width: 100%;
            z-index: -1;
        }

        .btn-file__preview {
            opacity: 0.5;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;
            position: absolute;
            z-index: -1;
            border-radius: 35px;
            background-size: cover;
            background-position: center;
        }

        .form-group label.attachment {
            width: 100%;
        }

        .form-group label.attachment .btn-create>a,
        .form-group label.attachment .btn-create>div {
            margin-top: 5px;
        }

        .form-group label.attachment input[type='file'] {
            display: none;
        }
    </style>
@endsection
