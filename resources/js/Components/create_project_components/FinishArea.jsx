import React, { useState } from 'react'
import Modal from '@mui/material/Modal';
import Box from '@mui/material/Box';
function FinishArea({createProject}) {
    const [open,setOpen] = useState(false);
    const style = {
        position: 'absolute',
        top: '50%',
        left: '50%',
        transform: 'translate(-50%, -50%)',
        width: 400,
        bgcolor: 'background.paper',
        boxShadow: 24,
        p: 4,
    };
    return(
        <div>
            <div className="second-area-finish">
                <div className="finish-tick ">
                    <input type="checkbox" id="rules_confirmx" value="1" className="rules_confirm" />
                    <label for="rules_confirmx">
                        <span className="rulesOpen ml-2" onClick={() => {setOpen(true)}}>İlan verme kurallarını</span>
                        <span>okudum, kabul ediyorum</span>
                    </label>
                </div>
                <div className="finish-button" style={{float:'right',margin:'0'}}>
                    <button onClick={createProject} className="btn btn-info">
                        Devam
                    </button>
                </div>
            </div>
            <Modal
                open={open}
                onClose={() => {setOpen(false)}}
                aria-labelledby="modal-modal-title"
                aria-describedby="modal-modal-description"
            >
                <Box sx={style} style={{width:'70%',maxHeight:'70vh',overflow:'scroll'}}>
                    <h2>İlan Verme Kuralları</h2>
                    <hr />
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
                </Box>
            </Modal>
        </div>
    )
}
export default FinishArea