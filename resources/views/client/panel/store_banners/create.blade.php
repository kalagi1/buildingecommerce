@extends('client.layouts.masterPanel')

@section('content')
    <div class="table-breadcrumb">
        <ul>
            <li>
                Hesabım
            </li>
            <li>
                Reklam Görselleri Oluştur
            </li>
        </ul>
    </div>
    <section>
        <div class="single homes-content details mb-30">
            <div class="container">
                <p>Bu alana eklenen görseller, her mağazanın kendi profilinde tanıtım ve reklam amaçlı slider'da gösterilecek. Mağazalarınızı doğru bir şekilde tanıtabilmek için bu adım çok önemlidir. Görsellerinizi yüklemek için aşağıdaki alana tıklayarak dosyalarınızı sürükleyip bırakabilir veya seçebilirsiniz. Görsellerinizi yükledikten sonra "Kaydet" butonuna basarak işlemi tamamlayabilirsiniz.</p>

                <form class="row g-3 needs-validation" novalidate method="POST"
                      action="{{ route('institutional.storeBanners.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="col-md-12">
                        <div class="file-drop-area">
                            <span class="fake-btn"> <i class="fa fa-cloud-upload"></i>Reklam Görselleri (350 × 184)</span>
                            <span class="file-msg">Yüklemek için buraya tıklayın veya dosyaları bırakın</span>
                            <label class="form-label" for="image"> </label><br>
                            <input name="images[]" class="form-control file-input" id="image" type="file"
                                   accept="image/*" required multiple>
                            <div class="valid-feedback">İyi Görünüyor !</div>
                        </div>
                    </div>
                    <div class="col-12 mt-3">
                        <button class="btn btn-primary" type="submit">Kaydet</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script src="{{ asset('js/dropzone.js') }}"></script>

    <script>
        var $fileInput = $('.file-input');
        var $droparea = $('.file-drop-area');

        // highlight drag area
        $fileInput.on('dragenter focus click', function() {
            $droparea.addClass('is-active');
        });

        // back to normal state
        $fileInput.on('dragleave blur drop', function() {
            $droparea.removeClass('is-active');
        });

        // change inner text
        $fileInput.on('change', function() {
            var filesCount = $(this)[0].files.length;
            var $textContainer = $(this).prev();

            if (filesCount === 1) {
                // if single file is selected, show file name
                var fileName = $(this).val().split('\\').pop();
                $(".file-msg").text(fileName);
            } else {
                // otherwise show number of files
                $(".file-msg").text(filesCount + ' dosya seçildi');
            }
        });

        
    </script>
@endsection

@section('styles')
    <style>
        .dz-message {
            background: #fff none repeat scroll 0 0;
            border: 2px dashed #1ABC9C;
            padding: 50px 20px;
            text-align: center;
        }

        .file-input {
            width: 100% !important;
            height: 220px !important;
        }

        .fa-cloud-upload {
            color: #1ABC9C;
            display: block;
            font-size: 60px;
            margin-bottom: 20px;
        }

        .file-drop-area {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            max-width: 100%;
            padding: 25px;
            height: 220px;
            border: 2px dashed #1ABC9C;
            border-radius: 3px;
            transition: 0.2s;
            flex-direction: column;
            cursor: pointer;
        }

        .file-drop-area.is-active {
            background-color: rgba(255, 255, 255, 0.05);
        }

        .fake-btn {
            flex-shrink: 0;
            border-radius: 3px;
            padding: 8px 15px;
            margin-right: 10px;
            font-size: 12px;
            text-transform: uppercase;
            width: 100%;
            text-align: center;
        }

        .file-msg {
            font-size: small;
            font-weight: 300;
            line-height: 1.4;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .file-input {
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 100%;
            cursor: pointer;
            opacity: 0;
        }

        .file-input:focus {
            outline: none;
        }
    </style>
@endsection
