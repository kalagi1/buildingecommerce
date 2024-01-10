@extends('institutional.layouts.master')

@section('content')
    @php
        function getData($project, $key, $roomOrder)
        {
            foreach ($project->roomInfo as $room) {
                if ($room->room_order == $roomOrder && $room->name == $key) {
                    return $room;
                }
            }
        }
    @endphp
    <div class="content">
        <div class="mt-4">
            <div class="second-area">
                <div class="row">
                    <div class="form-area mt-4">
                        <span class="section-title">{{$project->project_title}} Projesinde ki {{getData($project, 'advertise_title[]', $roomOrder)->value}} Adlı Konutu Düzenle</span>
                        @if($errors->any())
                        <div class="alert alert-danger">
                            <h4 class="c-fff">{{$errors->first()}}</h4>
                        </div>
                        @endif
                        <form action="{{route('institutional.projects.edit.housing.post',["project_id" => $project->id, "room_order" => $roomOrder])}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="tab-content" id="pricingTabContent" role="tabpanel">
                                        <div id="renderForm"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="second-area-finish">
                                <div class="finish-tick ">
                                    <input type="checkbox" id="rules_confirmx" value="1" class="rules_confirm" >
                                    <label for="rules_confirmx">
                                        <span class="rulesOpen">İlan verme kurallarını</span>
                                        <span>okudum, kabul ediyorum</span>
                                    </label>
                                </div>
                                <div class="finish-button" style="float:right;margin:0;">
                                    <button class="btn btn-info" type="submit">
                                        Devam
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="rulesOpenModal" tabindex="-1" role="dialog"
            aria-labelledby="finalConfirmationModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="finalConfirmationModalLabel">İlan Verme Kuralları</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            &times;
                        </button>
                    </div>
                    <div class="modal-body">
                        <ol>
                            <li> İlan yayıncısı EMLAKSEPETTE’de ilanlarını yayınlayarak “İlan Yayınlama Kuralları”nı kabul etmiş sayılır. Bu sebeple ilan yayınlayan her kişi ve kurum kurallara riayet etme mecburiyetindedir.</li>
                            <li> İlan yayıncıları ilanın içeriğiyle ilgili bilgilerin doğruluğundan sorumludur. İlan bilgileri içerisindeki gerçek dışı fiyat, metrekare, açıklama, kat sayısı gibi parametreler sonucunda ilan, ilan sahibinde danışılmaksızın sistemden kaldırılabilir.</li>
                            <li> İlan içerisinde yer alan fotoğrafların emlak ile ilişkili olması, ilanı yayınlayan kurumun ya da kişinin logo, tanıtım görseli vb.. olmaması gerekmektedir. Sistemde bulunan diğer ilanlardan ayrışmak maksadıyla ve haksız rekabet yaratmak amacıyla ilan resimlerinin üzerine herhangi bir yazı, ikon, şerit, çerçeve yerleştirilmesi fotoğrafın yayından kaldırılmasına sebep olabilir.</li>
                            <li> İlan sahibi aynı gayrimenkulle ilgili sadece bir adet ilan yayınlayabilir. Aynı emlak ile ilgili girilecek çoklu kayıtlar mükerrer ilan sayılacaktır. Mükerrer ilanlar haksız rekabete yol açtığından ötürü sistemden ilan sahibine duyurmaksızın tamamen kaldırılabilir.</li>
                            <li> İlan başlığı içerisinde yalnızca ilanda söz konusu olan gayrimenkule ait bilgiler verilebilir. İlan başlığı içerisinde iletişim bilgisi gibi haksız rekabete yol açabilecek bilgilerin yer verilmesi ilanın yayından kaldırılmasına sebep olabilir.</li>
                            <li> İlan başlığı içerisinde Türkçe karakterler, Türk alfabesinde bulunmayan X, W, Q harfleri, rakamlar, nokta(.), virgül(,), ünlem(!) noktalama işaretleri kullanılabilir. Bu karakterlerin dışında kullanılacak alfanumerik olmayan, rekabete gölge düşürecek hiçbir karakterin ilanlarda yer almasına izin verilmeyecektir.</li>
                            <li> İlan sahibi tarafından satılmış ya da kiralanmış gayrimenkullere ait ilanlar, ilan sahibi tarafından arşivlenmelidir. EMLAKSEPETTE sistemindeki operasyonu tamamlanmış ilanları belirli periyotlarla sistem haricine çıkarma hakkını saklı tutar. Bu işlem sonrasında doğacak yedekleme problemlerinden EMLAKSEPETTE sorumlu değildir.</li>
                            <li> İlan bilgilerinin doluluğu ve doğruluğu, fotoğrafların kalitesi ve geçmiş hareketler göz önünde bulundurularak ilan sahiplerinin ilanları değerlendirilebilir. İlan yayınlama kurallarını sıklıkla ihlal eden kullanıcıların sözleşmesini tek taraflı olarak fesh etme hakkını EMLAKSEPETTE saklı tutar. Aynı şekilde ilan bilgilerini daimi olarak doğru ve hatasız giren kullanıcılar, haksız rekabete yol açmayacak şekilde sistem algoritması tarafından ödüllendirilerek ilanların öne çıkması sağlanabilir.</li>
                            <li> İlan içerisinde yer alan ifadelerin cinsiyet, ırk, renk, dil, din, inanç, mezhep, felsefi ve siyasi görüş, etnik köken, servet, doğum, medeni hâl, sağlık durumu, engellilik ve yaş temellerine dayalı ayrımcılık niteliği taşımaması yasal bir zorunluluktur. Bu tür ifadeler kullanılması hukuka aykırı olup, Türkiye İnsan Hakları ve Eşitlik Kurumu (TİHEK) tarafından idari para cezası verilmesine sebep olabilir. Ayrıca, İlanda belirtilen ifadelerle ayrımcılığa yol açabilecek bilgilere yer verilmesi ilgili ifadelerin ve/veya ilanın yayından kaldırılması sebebidir.</li>
                            <li> İlan yayınlama kurallarına riayet etmeyen kullanıcıların ilanlarındaki bilgilerinin bir kısmı ya da tamamının yayından kaldırılması hakkını EMLAKSEPETTE saklı tutar.</li>
                            <li> Bireysel ve Kurumsal Hesap Sahibi, Portal üzerinden ilan verme, ilan düzenleme ve ilanı yeniden yayına alma işlemlerinden önce yasal mevzuat gereği sistem üzerinden kimliklerini doğrulamalıdır. Bireysel ve Kurumsal Hesap Sahibi, doğrulama işlemi yapmadıkları takdirde ilgili mevzuat uyarınca ilan veremeyeceklerini kabul eder. </li>
                            <li> İlan başlığında ve ilan açıklama bölümünde sadece gayrimenkul hakkındaki bilgiler yer almalıdır.</li>
                            <li> İlan başlığında ve ilan açıklama bölümlerde reklam içerikli yazı yazılmaması, link ve ürüne ait fotoğrafların eklenmemesi gerekmektedir.</li>
                            <li> Yayınlanmak istenen ilanlarda kullanılan fotoğraflar, videolar ve 3 Boyutlu Tur görüntüsü, satılan/kiralanan gayrimenkule ait olmalıdır. Yayınlanan içerikler, fotoğraf, video veya link olarak ilana eklenen 3 Boyutlu Tur görüntüler hakkında EMLAKSEPETTE'nin herhangi bir sorumluluğu bulunmamaktadır.</li>
                            <li> İlan girişlerinde belirtilen kriterlerde (metrekare, oda sayısı, bulunduğu kat, fiyat v.b.) doğru bilgiler yer almalıdır.</li>
                            <li> Eklenen fotoğrafların, videoların, 3 Boyutlu Tur görüntülerinin içeriğinde firma logoları, telefon numarası veya farklı web sitelerinin link, logo ya da isimleri yer almamalıdır. Seçili vitrin resmi olarak işaretlenen görsellerde; firma logoları, telefon numarası, web sitelerinin linki, renkli arka plan, renkli çerçeve, metin içerikleri,firma isimleri, photoshop ve benzeri uygulamalarla eklentiler yer almamalıdır.</li>
                            <li> Sistem içerisindeki farklı bir kullanıcının fotoğrafı / fotoğrafları kullanılmamalıdır.</li>
                            <li> Bir gayrimenkulü satmak için ayrı, kiralamak için ayrı ilan verilmelidir. Aynı ilanda hem satılık hem kiralık detayları bulunamaz.</li>
                            <li> Girilen bir ilanın aynısı, ilk girilen ilan silinerek sisteme yeniden girilemez. Bir ilanın silinip sisteme tekrar yeni baştan girilmesi ve benzeri nitelikteki faaliyetleri gerçekleştiren hesap sahiplerinin bu ilanları silinebilir, hesapları geçici olarak durdurulabilir veya iptal edilebilir.</li>
                            <li> Aynı sitede veya blokta bulunan ve aynı özellikleri taşıyan gayrimenkuller için ayrı ilan girişi yapılmaması, tek bir ilan verilmesi ve bu ilanın açıklamasında aynı konumda farklı dairelerin de olduğunun belirtilmesi gerekmektedir. Aynı özellikte ikinci ilan girişi mükerrer (aynı kayıt) sayılmaktadır.</li>
                            <li> Her bir ilan için farklı resimler kullanılmalıdır, aynı konumda dahi olsa aynı resim ikinci bir ilanda kullanılmamalıdır.</li>
                            <li> Emlak ilan girişleri mutlaka mal sahibi tarafından veya mal sahibinin onayı alınarak yapılmalıdır. Bu sorumluluk ilan verene aittir. Mal sahibinin itirazı doğrultusunda hesap sahiplerinin bu ilanları silinebilir, hesapları geçici olarak durdurulabilir veya iptal edilebilir.</li>
                            <li> Satılık veya kiralık gayrimenkuller için temsili fiyat verilmemelidir.</li>
                            <li> İlan açıklama bölümlerinde web sayfası, mail adresi ve firma iletişim bilgilerine yer verilmemelidir. Telefon numarası ve kullanıcı adı sadece “Kullanıcı bilgileri” bölümünde yayınlanmalıdır. Mağaza kullanıcıları mağazaları için tanıtım sayfası hazırlayarak iletişim ve adres bilgilerini bu alanda yayınlayabilirler ancak web sayfası ve mail adreslerini belirtmemeleri gerekir</li>
                            <li> Satılan ya da kiralanan ürünler Satıldı / Kiralandı olarak tekrar yayına verilemez. Satış işleminin devam ettiği izlenimi yaratan ya da tüketiciyi aldatma ve yanıltma ihtimali yaratabilecek “opsiyonlanmıştır', “kaporası alınmıştır”, "satılmıştır", "ilginiz için teşekkürler" gibi ya da bunlara benzer anlamda ibareler içeren ilanlar yayına alınmaz, yayında olan ilanlar yayından kaldırılır.</li>
                            <li> İlan verme aşamasında, ilana ait belirlenmiş bazı kriterler için girilen bilgiler, ilan veren tarafından sonradan değiştirilemez, ilan veren bu konuda itirazda bulunmayacağını peşinen kabul etmektedir. EMLAKSEPETTE hangi kriterlere ait bilgilerin değiştirilemeyeceğini belirleme, zaman içinde belirlediği kriterlerde değişiklik yapma ve değişiklik yapma tarihi itibariyle belirlediği kriterleri tüm ilanlara uygulama hakkını saklı tutmaktadır.</li>
                            <li> Günlük Kiralık İlan yayınlayanlar; 22/11/2016 tarihli Olağanüstü Hal Kapsamında Bazı Düzenlemeler Yapılması Hakkında Kanun Hükmünde Kararname ile getirilen yeni düzenlemelere, yasal mevzuata ve Portal'daki İlan Yayınlama Kurallarına uygun hareket etmekle yükümlüdür. Yasal yükümlülüklerini yerine getirmeden günlük kiralık ilan yayınlayanlar hakkında uygulanacak cezalardan münhasıran Günlük Kiralık İlan Veren sorumlu olacaktır.</li>
                            <li> Turizm amaçlı kiralık ilan yayınlayanlar; “7464 sayılı “Konutların Turizm Amaçlı Kiralanmasına ve Bazı Kanunlarda Değişiklik Yapılmasına Dair Kanun” ile getirilen yeni düzenlemelere, yasal mevzuata ve Portal'daki İlan Yayınlama Kurallarına uygun hareket etmekle yükümlüdür. Yasal yükümlülüklerini yerine getirmeden turizm amaçlı kiralık ilan yayınlayanlar hakkında uygulanacak cezalardan münhasıran İlan Veren sorumlu olacaktır.</li>
                            <li> Konut> Kiralık kategorisinde sadece aylık kiralık ilanlar verilebilir. Günlük, haftalık vb. kiralık ilanların Günlük Kiralık kategorisinden verilmesi gerekmektedir.</li>
                            <li> Günlük kiralık dairelerde, fiyat kriterine günlük kiralama bedeli girilmelidir.</li>
                            <li> İlanın işyeri ya da konut olarak değerlendirilmesinin kararı ilan verenin sorumluluğundadır. Seçilmiş kategori doğru olarak kabul edilir, ilan verme kurallarına aykırı bir durum yer almıyor ise ilan yayına alınır.</li>
                            <li> Her farklı taşınmaz için ayrı ilan verilmelidir. Farklı konumdaki, taşınmazlar için toplu satış yapılamamaktadır.</li>
                            <li> Turistik Tesis kategorisinde sadece turistik bir tesisin tamamı kiralanabilir ya da tamamının satışı yapılabilir.</li>
                            <li> 13 Eylül 2018 tarihli "Türk Parasının Kıymetini Koruma hakkında 32 sayılı Kararda Değişiklik Yapılmasına Dair Karar"da, 6 Ekim 2018 tarihli “Türk Parası Kıymetini Koruma Hakkında 32 Sayılı Karara İlişkin Tebliğ”de ve 16 Kasım 2018 tarihli ve 30597 sayılı Türk Parası Kıymetini Koruma Hakkında 32 Sayılı Karara İlişkin Tebliğ'de Değişiklik Yapılmasına Dair Tebliğ'de belirtilen sözleşme tiplerine dair kategorilerdeki ilanların fiyat bilgilerinin Türk Lirası olarak girilmesi gerekmektedir.</li>
                            <li> Metaverse, OVR, sanal arazi, sanal dünya üzerinden arazi ve arsa satışları üzerinden arazi ve arsa satışlarına izin verilmez.</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $('#rulesOpenModal').click(function(){
            $(this).removeClass('show')
            $(this).removeClass('d-block')
        })

        $('#rulesOpenModal .close').click(function(){
            $(this).removeClass('show')
            $(this).removeClass('d-block')
        })

        $('#rulesOpenModal .modal-dialog').click(function(e){
            if(!$(event.target).hasClass('close')){
                e.stopPropagation();
            }
        })

        $('.rulesOpen').click(function(){
            $('#rulesOpenModal').addClass('show')
            $('#rulesOpenModal').addClass('d-block')
        })
        
        var houseCount = {{ isset($project->room_count) ? $project->room_count : 0 }};
        if (!isNaN(houseCount) && houseCount > 0) {
            var houseType = {{ isset($project->housing_type_id) ? $project->housing_type_id : 0 }};
            if (houseType != 0) {
                @if (isset($project->housing_type_id))
                    @php
                        $housingType = DB::table('housing_types')
                            ->where('id', $project->housing_type_id)
                            ->first();
                    @endphp
                    var housingTypeData = @json($housingType);
                    @if (isset($project->roomInfo))
                        var oldData = @json($project->roomInfo);
                    @else
                        var oldData = [];
                    @endif
                    var formInputs = JSON.parse(housingTypeData.form_json);
                @endif
                $('.rendered-area').removeClass('d-none')
                $.ajax({
                    method: "GET",
                    url: "{{ route('institutional.ht.getform') }}",
                    data: {
                        id: houseType
                    },
                    success: function(response) {
                        var html = "";
                        var htmlContent = "";
                        for (var i = {{$roomOrder}}; i < {{$roomOrder + 1}}; i++) {

                            htmlContent += '<div class="tab-pane fade show active' +
                                '" id="TabContent' + (i) + '" role="tabpanel">' +
                                '<div id="renderForm' + (i) + '"></div>' +
                                '</div>';
                        }

                        $('.tab-content').html(htmlContent);

                        for (let i = {{$roomOrder}}; i < {{$roomOrder + 1}}; i++) {
                            formRenderOpts = {
                                dataType: 'json',
                                formData: response.form_json
                            };

                            var renderedForm = $('<div>');
                            renderedForm.formRender(formRenderOpts);
                            var renderHtml = renderedForm.html().toString();
                            renderHtml = renderHtml.toString().split('images[][]');
                            renderHtml = renderHtml[0];
                            var json = JSON.parse(response.form_json);
                            for (var lm = 0; lm < json.length; lm++) {
                                if (json[lm].type == "checkbox-group") {
                                    var json = JSON.parse(response.form_json);
                                    var renderHtml = renderHtml.toString().split(json[lm].name + '-');
                                    renderHtmlx = "";
                                    for (var t = 0; t < renderHtml.length; t++) {
                                        if (t != renderHtml.length - 1) {
                                            renderHtmlx += renderHtml[t] + (json[lm].name.split('[]')[0]) + i +
                                                '[]-' + i;
                                        } else {
                                            renderHtmlx += renderHtml[t];
                                        }
                                    }

                                    renderHtml = renderHtmlx;
                                    var renderHtml = renderHtml.toString().split(json[lm].name + '[]');
                                    renderHtmlx = "";
                                    var json = JSON.parse(response.form_json);
                                    for (var t = 0; t < renderHtml.length; t++) {
                                        if (t != renderHtml.length - 1) {
                                            renderHtmlx += renderHtml[t] + (json[lm].name.split('[]')[0]) + i +
                                                '[][]';
                                        } else {
                                            renderHtmlx += renderHtml[t];
                                        }
                                    }


                                    renderHtml = renderHtmlx;


                                }
                            }
                            $('#renderForm' + (i)).html(renderHtmlx);



                        }
                        
                        $('.second-payment-plan').closest('div').addClass('d-none')
                        @if($project->step2_slug != "kiralık" && getData($project, 'payment-plan[]', $roomOrder))
                        @foreach(json_decode(getData($project, 'payment-plan[]', $roomOrder)->value) as $paymentPlan)

                            @if($paymentPlan[0] == "taksitli")
                                $('.second-payment-plan').closest('div').removeClass('d-none')
                            @endif
                        @endforeach
                        @endif

                        $('.next_house').click(function() {
                            var nextHousing = true;
                            $('.tab-pane.active input[required="required"]').map((key, item) => {
                                if (!$(item).val() && $(item).attr('type') != "file") {
                                    nextHousing = false;
                                    $(item).addClass("error-border")
                                }
                            })
                            $('.tab-pane.active select[required="required"]').map((key, item) => {
                                if (!$(item).val() || $(item).val() == "Seçiniz") {
                                    nextHousing = false;
                                    $(item).addClass("error-border")
                                }
                            })


                            $('.tab-pane.active input[type="file"]').map((key, item) => {
                                if ($(item).parent('div').find('.project_imaget').length == 0) {
                                    nextHousing = false;
                                    $(item).addClass("error-border")
                                }
                            })

                            var indexItem = $('.tab-pane.active').index();
                            if (nextHousing) {
                                $('html, body').animate({
                                    scrollTop: $('.tab-pane.active').offset().top - parseFloat(
                                        $('.navbar-top').css('height'))
                                }, 100);
                                $('.tab-pane.active').removeClass('active');
                                $('.tab-pane').eq(indexItem + 1).addClass('active');
                                $('.item-left-area p').removeClass('active');
                                $('.item-left-area').eq(indexItem + 1).find('p').addClass('active');
                            } else {
                                $('html, body').animate({
                                    scrollTop: $('.tab-pane.active').offset().top - parseFloat(
                                        $('.navbar-top').css('height'))
                                }, 100);
                            }
                        })

                        
                        $('.project-disabled').closest('.form-group').remove();


                        $('.prev_house').click(function() {

                            var indexItem = $('.tab-pane.active').index();
                            $('.tab-pane.active').removeClass('active');
                            $('.tab-pane').eq(indexItem - 1).addClass('active');
                        })

                        function getOldData(roomOrder, inputName) {
                            for (var q = 0; q < oldData.length; q++) {
                                if (oldData[q].room_order == roomOrder && oldData[q].name == inputName) {
                                    return oldData[q].value;
                                }
                            }
                        }
                        
                        @if(in_array(3,array_merge(array_keys($project->housingTypes->keyBy('housing_type_id')->toArray()))))
                            $('.continue-disabled').closest('.form-group').remove();
                        @endif
                        
                        for (let i = {{$roomOrder}}; i < {{$roomOrder + 1}}; i++) {
                            for (var j = 0; j < formInputs.length; j++) {
                                if (formInputs[j].type == "number" || formInputs[j].type == "text") {
                                    var inputName = formInputs[j].name;
                                    var inputNamex = inputName;
                                    inputNamex = inputNamex.split('[]')
                                    if (getOldData(i, inputName) != undefined) {
                                        $($('input[name="' + formInputs[j].name + '"]')).val(getOldData(
                                            i, inputName));
                                    }
                                } else if (formInputs[j].type == "select") {
                                    var inputName = formInputs[j].name;
                                    var inputNamex = inputName;
                                    inputNamex = inputNamex.split('[]')
                                    $($('select[name="' + formInputs[j].name + '"]')).children('option')
                                        .map((key, item) => {
                                            console.log(getOldData(i, inputName));
                                            if (getOldData(i, inputName) != undefined) {
                                                if ($(item).attr("value") == getOldData(i, inputName)) {
                                                    $(item).attr('selected', 'selected')
                                                } else {
                                                    $(item).removeAttr('selected')
                                                }
                                            } else {
                                                $(item).removeAttr('selected')
                                            }

                                        });
                                } else if (formInputs[j].type == 'checkbox-group') {
                                    var inputName = formInputs[j].name;
                                    var inputNamex = inputName;
                                    inputNamex = inputNamex.split('[]')
                                    var checkboxName = inputName;
                                    checkboxName = checkboxName.split('[]');
                                    checkboxName = checkboxName[0];
                                    $($('input[name="' + inputNamex[0] + [i] + '[][]"]')).map((key, item) => {
                                        if (getOldData(i, inputName)) {
                                            JSON.parse(getOldData(i, inputName)).map((checkbox) => {
                                                if($(item).attr("value")){
                                                    if ($(item).attr("value").trim() == "taksitli") {
                                                        if ($(item).attr("value") != undefined && checkbox == $(item).attr("value").trim()) {
                                                            $(item).closest('.tab-pane').find(
                                                                'second-payment-plan').closest(
                                                                'div').removeClass('d-none')
                                                            $(item).attr('checked', 'checked')
                                                        } else {
                                                            $(item).closest('.tab-pane').find(
                                                                'second-payment-plan').closest(
                                                                'div').addClass('d-none')
                                                        }
                                                    } else {
                                                        if ($(item).attr("value") != undefined &&
                                                            checkbox == $(item).attr("value").trim()) {
                                                            $(item).attr('checked', 'checked')
                                                        }
                                                    }
                                                }
                                                
                                            })
                                        }
                                    });
                                } else if (formInputs[j].type == 'file') {
                                    console.log("file");
                                    var inputName = formInputs[j].name;
                                    var inputNamex = inputName;
                                    inputNamex = inputNamex.split('[]')
                                    if (getOldData(i, inputName) != undefined) {
                                        $($('input[name="' + formInputs[j].name + '"]')).parent('div')
                                            .append(
                                                '<div class="project_imaget"><img src="{{ URL::to('/') }}/project_housing_images/' +
                                                getOldData(i, inputName) + '"></div>');
                                    }
                                }

                            }
                        }

                        $('.price-only').keyup(function(){
                            $('.price-only .error-text').remove();

                            if($('.price-only').val().replace('.','').replace('.','').replace('.','').replace('.','') != parseInt($('.price-only').val().replace('.','').replace('.','').replace('.','').replace('.','').replace('.','') )){
                                console.log("hatali")
                                if($('.price-only').closest('.form-group').find('.error-text').length > 0){
                                    $('.price-only').val("");
                                }else{
                                    $(this).closest('.form-group').append('<span class="error-text">Girilen değer sadece sayı olmalıdır</span>')
                                    $('.price-only').val("");
                                }
                                
                            }else{
                                let inputValue = $(this).val();

                                // Sadece sayı karakterlerine izin ver
                                inputValue = inputValue.replace(/\D/g, '');

                                // Her üç basamakta bir nokta ekleyin
                                inputValue = inputValue.replace(/\B(?=(\d{3})+(?!\d))/g, '.');

                                console.log(inputValue);
                                $(this).val(inputValue)
                                $(this).closest('.form-group').find('.error-text').remove();
                            }
                        })

                        $('.price-only').map((key,item) => {
                            console.log(item);
                            let inputValue = $(item).val();
                                console.log(inputValue)
                            if(inputValue){
                                inputValue = inputValue.replace(/\D/g, '');
                                inputValue = inputValue.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                            }
                            $(item).val(inputValue)
                        })

                        console.log($('.dropzonearea'))
                        $('.dropzonearea').closest('.formbuilder-file').remove();
                        for (let i = 1; i <= houseCount; i++) {
                            var images = '';
                            if (oldData.images) {
                                housingImages = JSON.parse(oldData.images[i - 1]);
                            } else {
                                housingImages = [];
                            }
                            for (let j = 0; j < housingImages.length; j++) {
                                images +=
                                    '<div class="project_images_area"><img class="edit_project_housing_image" src="{{ URL::to('/') . '/project_images/' }}' +
                                    housingImages[j] + '"> <span order="' + j + '" housing_order="' + i +
                                    '" class="btn btn-danger remove_housing_image">Sil</span>  </div>';
                            }
                            $('.dropzone2').eq(i - 1).parent('div').append(
                                '<div class="d-none"><input housing_order="' + i +
                                '" type="file" class="new_file_on_drop"></div>')
                            $('.dropzone2').eq(i - 1).html(images);
                        }

                        var csrfToken = "{{ csrf_token() }}";

                        $('.add-new-project-house-image').click(function() {
                            $(this).parent('div').find('.new_file_on_drop').trigger("click")
                        })

                        $('.new_project_housing_image').click(function() {
                            console.log("asd");
                        })

                        $('.item-left-area').click(function(e) {
                            var clickIndex = $(this).index();
                            var currentIndex = $('.nav-linkx.active').closest('.item-left-area')
                                .index();

                            if (clickIndex > currentIndex) {
                                var nextHousing = true;
                                $('.tab-pane.active input[required="required"]').map((key, item) => {
                                    if (!$(item).val()) {
                                        nextHousing = false;
                                        $(item).addClass("error-border")
                                    }
                                })

                                $('.tab-pane.active select[required="required"]').map((key, item) => {
                                    if (!$(item).val()) {
                                        nextHousing = false;
                                        $(item).addClass("error-border")
                                    }
                                })
                                if ($('.tab-pane.active input[required="required"]').val() == "") {
                                    nextHousing = false;
                                    $('.tab-pane.active input[name="price[]"]').addClass('error-border')
                                }

                                $('.tab-pane.active input[type="file"]').map((key, item) => {
                                    if ($(item).parent('div').find('.project_imaget').length ==
                                        0) {
                                        nextHousing = false;
                                        $(item).addClass("error-border")
                                    }
                                })

                                var indexItem = $('.tab-pane.active').index();
                                if (nextHousing) {
                                    $('.tab-pane.active').removeClass('active');
                                    $('.tab-pane').eq(indexItem + 1).addClass('active');
                                    $('.item-left-area p').removeClass('active')
                                    $(this).children('p').addClass('active');
                                } else {
                                    $('html, body').animate({
                                        scrollTop: $('.tab-pane.active').offset().top -
                                            parseFloat($('.navbar-top').css('height'))
                                    }, 100);
                                }



                            } else {

                                $('.item-left-area p').removeClass('active')
                                $(this).children('p').addClass('active');
                                $('.tab-pane.active').removeClass('active');
                                $('.tab-pane').eq(clickIndex).addClass('active');
                            }

                        })

                        $('.tab-pane select[multiple="false"]').removeAttr('multiple')
                        $('input[value="taksitli"]').change(function() {
                            if ($(this).is(':checked')) {
                                $('.second-payment-plan').closest('div').removeClass('d-none');
                            } else {
                                $('.second-payment-plan').closest('div').addClass('d-none');
                            }
                        })

                        $('.copy-item').change(function() {
                            var transactionIndex = 0;
                            $('.tab-pane').prepend(
                                '<div class="loading-icon-right"><i class="fa fa-spinner"></i></div>'
                            );
                            var order = parseInt($(this).val()) - 1;
                            var currentOrder = parseInt($(this).closest('.item-left-area').index());
                            var arrayValues = {};
                            for (var lm = 0; lm < json.length; lm++) {
                                if (json[lm].type == "checkbox-group") {
                                    arrayValues[json[lm].name.replace("[]", "").replace("[]", "") + (
                                        currentOrder + 1)] = [];
                                    for (var i = 0; i < json[lm].values.length; i++) {
                                        var isChecked = $('input[name="' + (json[lm].name.replace('[]',
                                                '')) + (order + 1) + '[][]"][value="' + json[lm]
                                            .values[i].value + '"]' + '').is(':checked')
                                        if (isChecked) {
                                            $('input[name="' + (json[lm].name.replace('[]', '')) + (
                                                    currentOrder + 1) + '[][]"][value="' + json[lm]
                                                .values[i].value + '"]' + '').prop('checked', true)

                                            arrayValues[json[lm].name.replace("[]", "").replace("[]",
                                                "") + (currentOrder + 1)].push(json[lm].values[i]
                                                .value)
                                        } else {
                                            transactionIndex++;
                                            $('input[name="' + (json[lm].name.replace('[]', '')) + (
                                                    currentOrder + 1) + '[][]"][value="' + json[lm]
                                                .values[i].value + '"]' + '').prop('checked', false)
                                        }
                                    }
                                    var formData = new FormData();
                                    var csrfToken = $("meta[name='csrf-token']").attr("content");
                                    formData.append('_token', csrfToken);
                                    formData.append('value', JSON.stringify(arrayValues));
                                    formData.append('order', currentOrder);
                                    formData.append('key', json[lm].name.replace("[]", "").replace("[]",
                                        "") + (currentOrder + 1));
                                    formData.append('item_type', 3);
                                    formData.append('checkbox', "1");
                                    $.ajax({
                                        type: "POST",
                                        url: "{{ route('institutional.temp.order.copy.checkbox') }}", // Sunucunuzun dosya yükleme işlemini karşılayan URL'sini buraya ekleyin
                                        data: formData,
                                        processData: false,
                                        contentType: false,
                                        success: function(response) {
                                            if (transactionIndex + 1 == json.length) {
                                                $('.loading-icon-right').remove();
                                            }

                                            transactionIndex++;
                                        },
                                    });
                                } else if (json[lm].type == "select") {
                                    var value = $('select[name="' + (json[lm].name) + '"]').eq(order)
                                        .val();
                                    $('select[name="' + (json[lm].name) + '"]').eq(currentOrder)
                                        .children('option').removeAttr('selected')
                                    $('select[name="' + (json[lm].name) + '"]').eq(currentOrder)
                                        .children('option[value="' + value + '"]').prop('selected',
                                            true);
                                    var formData = new FormData();
                                    var csrfToken = $("meta[name='csrf-token']").attr("content");
                                    formData.append('_token', csrfToken);
                                    formData.append('value', value);
                                    formData.append('order', currentOrder);
                                    formData.append('key', json[lm].name.replace("[]", "").replace("[]",
                                        ""));
                                    formData.append('item_type', 3);
                                    $.ajax({
                                        type: "POST",
                                        url: "{{ route('institutional.temp.order.project.housing.change') }}", // Sunucunuzun dosya yükleme işlemini karşılayan URL'sini buraya ekleyin
                                        data: formData,
                                        processData: false,
                                        contentType: false,
                                        success: function(response) {
                                            if (transactionIndex + 1 == json.length) {
                                                $('.loading-icon-right').remove();
                                            }
                                            transactionIndex++;
                                        },
                                    });

                                } else if (json[lm].type == "file" && json[lm].name == "image[]") {

                                    var formData = new FormData();
                                    var csrfToken = $("meta[name='csrf-token']").attr("content");
                                    formData.append('_token', csrfToken);
                                    formData.append('lastorder', order);
                                    formData.append('order', currentOrder);
                                    formData.append('item_type', 3);
                                    $.ajax({
                                        type: "POST",
                                        url: "{{ route('institutional.copy.item.image') }}", // Sunucunuzun dosya yükleme işlemini karşılayan URL'sini buraya ekleyin
                                        data: formData,
                                        processData: false,
                                        contentType: false,
                                        success: function(response) {
                                            if (transactionIndex + 1 == json.length) {
                                                $('.loading-icon-right').remove();
                                            }
                                            transactionIndex++;
                                        },
                                    });
                                    var cloneImage = $('.tab-pane').eq(order).find('.project_imaget')
                                        .clone();
                                    $('.tab-pane.active').find('.cover-image-by-housing-type').parent(
                                        'div').find('.project_imaget').remove();
                                    $('.tab-pane.active').find('.cover-image-by-housing-type').parent(
                                        'div').append(cloneImage)
                                } else if (json[lm].type != "file") {
                                    if (json[lm].name) {
                                        var value = $('input[name="' + (json[lm].name) + '"]').eq(order)
                                            .val();
                                        var formData = new FormData();
                                        var csrfToken = $("meta[name='csrf-token']").attr("content");
                                        formData.append('_token', csrfToken);
                                        formData.append('value', value);
                                        formData.append('order', currentOrder);
                                        formData.append('key', json[lm].name.replace("[]", "").replace(
                                            "[]", ""));
                                        formData.append('item_type', 3);
                                        $.ajax({
                                            type: "POST",
                                            url: "{{ route('institutional.temp.order.project.housing.change') }}", // Sunucunuzun dosya yükleme işlemini karşılayan URL'sini buraya ekleyin
                                            data: formData,
                                            processData: false,
                                            contentType: false,
                                            success: function(response) {
                                                if (transactionIndex + 1 == json.length) {
                                                    $('.loading-icon-right').remove();
                                                }
                                                transactionIndex++;
                                            },
                                        });

                                        $('input[name="' + (json[lm].name) + '"]').eq(currentOrder).val(
                                            value);
                                    }

                                }
                            }
                            console.log(transactionIndex);
                        })

                        $('.rendered-form input[type="file"]').removeAttr('required')
                        console.log( $('.rendered-form input[type="file"]'));
                        $('.rendered-form input[type="file"]').closest('.formbuilder-file').find('.formbuilder-file-label').find('.formbuilder-required').remove()

                        $('.rendered-form input').change(function() {
                            if ($(this).attr('type') != "file") {
                                if($(this).hasClass('only-one')){
                                    $(this).closest('.form-group').find('.only-one[value!="'+$(this).val()+'"]').prop('checked',false);
                                }

                            }
                        })

                        $('.rendered-form select').change(function() {
                            if ($(this).val()) {
                                $(this).removeClass('error-border')
                            }
                            var formData = new FormData();
                            var csrfToken = $("meta[name='csrf-token']").attr("content");
                            formData.append('_token', csrfToken);
                            formData.append('value', $(this).val());
                            console.log($(this).closest('.tab-pane').attr('id'))
                            formData.append('order', parseInt($(this).closest('.tab-pane').attr('id')
                                .replace('TabContent', "")) - 1);
                            formData.append('key', $(this).attr('name').replace("[]", ""));
                            formData.append('item_type', 3);
                            $.ajax({
                                type: "POST",
                                url: "{{ route('institutional.temp.order.project.housing.change') }}", // Sunucunuzun dosya yükleme işlemini karşılayan URL'sini buraya ekleyin
                                data: formData,
                                processData: false,
                                contentType: false,
                                success: function(response) {},
                            });

                        })

                        $('.number-only').keyup(function() {
                            $('.number-only .error-text').remove();
                            if ($(this).val() != parseInt($(this).val())) {
                                if ($(this).closest('.form-group').find('.error-text').length > 0) {
                                    $(this).val("");
                                } else {
                                    $(this).closest('.form-group').append(
                                        '<span class="error-text">Girilen değer sadece sayı olmalıdır</span>'
                                    )
                                    $(this).val("");
                                }

                            } else {
                                $(this).closest('.form-group').find('.error-text').remove();
                            }
                        })

                        $('.formbuilder-text input').change(function() {
                            if ($(this).val() != "") {
                                $(this).removeClass('error-border')
                            }
                        })

                        $('.formbuilder-number input').change(function() {
                            if ($(this).val() != "") {
                                $(this).removeClass('error-border')
                            }
                        })


                        $('.cover-image-by-housing-type').change(function() {
                            var input = this;
                            if (input.files && input.files[0]) {
                                $(this).removeClass('error-border');
                                var reader = new FileReader();

                                var formData = new FormData();
                                var csrfToken = $("meta[name='csrf-token']").attr("content");
                                formData.append('_token', csrfToken);
                                formData.append('file', this.files[0]);
                                formData.append('order', $(this).closest('.tab-pane').index());
                                formData.append('item_type', 3);
                                $.ajax({
                                    type: "POST",
                                    url: "{{ route('institutional.temp.order.project.add.image') }}", // Sunucunuzun dosya yükleme işlemini karşılayan URL'sini buraya ekleyin
                                    data: formData,
                                    processData: false,
                                    contentType: false,
                                    success: function(response) {},
                                    error: function() {
                                        // Hata durumunda kullanıcıya bir mesaj gösterebilirsiniz
                                        alert("Dosya yüklenemedi.");
                                    }
                                });

                                reader.onload = function(e) {
                                    // Resmi görüntülemek için bir div oluşturun
                                    var imageDiv = $('<div class="project_imaget"></div>');

                                    // Resmi oluşturun ve div içine ekleyin
                                    var image = $('<img>').attr('src', e.target.result);
                                    imageDiv.append(image);
                                    $('.tab-pane.active .cover-image-by-housing-type').closest(
                                            '.formbuilder-file').find('.project_imaget').eq(0)
                                        .remove()
                                    $('.tab-pane.active .cover-image-by-housing-type').closest(
                                        '.formbuilder-file').append(imageDiv)
                                };

                                // Resmi okuyun
                                reader.readAsDataURL(input.files[0]);

                            }
                        })



                    },
                    error: function(error) {
                        console.log(error)
                    }
                })
            }

        }
    </script>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ URL::to('/') }}/adminassets/vendors/choices/selectize.css" />
    <link rel="stylesheet" href="{{ URL::to('/') }}/adminassets/assets/css/daterangepicker.css">
@endsection
