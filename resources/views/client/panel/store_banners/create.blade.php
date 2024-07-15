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


