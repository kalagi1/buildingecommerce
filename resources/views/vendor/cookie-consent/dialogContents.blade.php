<!-- Çerez Yönetimi Modalı -->
<div id="cookie-management-modal"
    class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black bg-opacity-50">
    <div class="bg-white rounded-lg shadow-lg p-6 w-11/12 max-w-lg">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="text-xl font-semibold mb-0 pb-0">Çerez Yönetimi</h2>

            <button id="close-modal"
                class="p-2 bg-gray-300 hover:bg-gray-400 text-sm font-medium rounded-md border-none"><svg
                    viewBox="0 0 24 24" width="15" height="16" stroke="currentColor" stroke-width="2" fill="none"
                    stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg></button>
        </div>
        <p class="mb-4">Çerezlerinizin ayarlarını burada yönetebilirsiniz. Aşağıdaki seçenekleri kullanarak çerez
            tercihlerinizi güncelleyebilirsiniz:</p>

        <!-- Çerez Yönetim Seçenekleri -->
        <div class="space-y-4">
            <ul class="accordion accordion-1 one-open">
                <li>
                    <div class="title">
                        <span>Gizliliğiniz</span>
                    </div>
                    <div class="content">
                        <p>Herhangi bir internet sitesini ziyaret ettiğinizde, sitenin işlevlerinden en iyi şekilde
                            faydalanabilmeniz için kullandığınız tarayıcı üzerinden genellikle “tanımlama bilgileri”
                            başlığı altında çeşitli bilgiler alınabilir ve depolanabilir.</p>
                        <p>Söz konusu bilgiler kullanım tercihleriniz veya kullandığınız cihaz hakkında olabilir veya
                            sitenin doğru ve beklediğiniz şekilde çalıştırılabilmesi için kullanılabilir.</p>
                        <p>Bilgiler çoğunlukla sizi doğrudan ve kişisel olarak tanımlamaz; ancak size ve kullanım
                            alışkanlıklarınıza daha uygun bir internet deneyimi sunarak, internet sitemizden en kapsamlı
                            şekilde faydalanmanızı sağlar.</p>
                        <p>Bazı tanımlama bilgisi tiplerinin sitemiz tarafından kullanılmasına izin vermemeyi tercih
                            edebilirsiniz. Ancak bu durumda sitemizdeki deneyiminizin ve size sunacağımız bazı
                            hizmetlerin bu tercihinizden olumsuz şekilde etkilenebileceğini hatırlatmak isteriz.</p>
                        <p>Tanımlama bilgisi kategorileri hakkında daha fazla bilgi almak, sitemizden en iyi şekilde
                            faydalanabilmek ve önceden belirlediğimiz ayarları değiştirmek için aşağıdaki kategori
                            başlıklarına tıklayabilirsiniz.</p>
                    </div>
                </li>
                <li class="active">
                    <div class="title">
                        <span>Hedefleme Amaçlı Tanımlama Bilgileri</span>
                    </div>
                    <div class="content">
                        <div class="d-flex align-items-center mt-3 " style="padding-left: 13px">
                            <span class="status-text" data-status="targeting">Etkin</span>
                            <input type="checkbox" id="targeting-cookies" class="ml-2" checked>
                        </div>
                        <p>Bu tanımlama bilgileri, sitemizde reklam ortaklarımız tarafından ayarlanır. Bunlar, ilgili
                            şirketler tarafından ilgi alanları profilinizi oluşturmak ve diğer sitelerde alakalı
                            reklamlar göstermek için kullanılabilir. Benzersiz olarak tarayıcınızı ve cihazınızı
                            belirleyerek çalışırlar. Bu kapsamda tarayıcınıza piksel ve çerez yerleşimi
                            yapılabilmektedir. Bu tanımlama bilgilerine izin vermezseniz farklı sitelerde size özel
                            reklam deneyimi sunamayız.</p>
                    </div>
                </li>
                <li>
                    <div class="title">
                        <span>Zorunlu Tanımlama Bilgileri</span>
                    </div>
                    <div class="content">
                        <div class="d-flex align-items-center mt-3 " style="padding-left: 13px">
                            <span class="status-text" data-status="essential" style="color: green">Her Zaman
                                Etkin</span>
                        </div>
                        <p>Bu tanımlama bilgileri, web sitesinin çalışması için gereklidir ve sistemlerimizde
                            kapatılamaz. Bunlar genellikle yalnızca sizin işlemlerinizi gerçekleştirmek için
                            ayarlanmıştır. Bu işlemler, gizlilik tercihlerinizi belirlemek, oturum açmak veya form
                            doldurmak gibi hizmet taleplerinizi içerir. Tarayıcınızı, bu tanımlama bilgilerini
                            engelleyecek veya bunlar hakkında sizi uyaracak şekilde ayarlayabilirsiniz ancak bu durumda
                            sitenin bazı bölümleri çalışmayabilir.</p>
                    </div>
                </li>
                <li>
                    <div class="title">
                        <span>İşlevsel Tanımlama Bilgileri</span>
                    </div>
                    <div class="content">
                        <div class="d-flex align-items-center mt-3 " style="padding-left: 13px">
                            <span class="status-text" data-status="functional">Devre Dışı</span>
                            <input type="checkbox" id="functional-cookies" class="ml-2">
                        </div>
                        <p>Bu tanımlama bilgileri, videolar ile canlı sohbet gibi gelişmiş işlevler ve kişiselleştirme
                            olanağı sunabilmemizi sağlar. Bunlar, bizim tarafımızdan veya sayfalarımızda hizmetlerinden
                            faydalandığımız üçüncü taraf sağlayıcılarca ayarlanabilir. Bu tanımlama bilgilerine izin
                            vermezseniz bu işlevlerden tümü veya bazıları doğru şekilde çalışmayabilir.</p>
                    </div>
                </li>
                <li>
                    <div class="title">
                        <span>Performans Tanımlama Bilgileri</span>
                    </div>
                    <div class="content">
                        <div class="d-flex align-items-center mt-3 " style="padding-left: 13px">
                            <span class="status-text" data-status="performance">Devre Dışı</span>
                            <input type="checkbox" id="performance-cookies" class="ml-2">
                        </div>
                        <p>Bu tanımlama bilgileri, sitemizin performansını ölçebilmemiz ve iyileştirebilmemiz için
                            sitenin ziyaret edilme sayısını ve trafik kaynaklarını sayabilmemizi sağlar. Hangi
                            sayfaların en fazla ve en az ziyaret edildiğini ve ziyaretçilerin sitede nasıl
                            gezindiklerini öğrenmemize yardımcı olurlar. Bu tanımlama bilgilerinin topladığı tüm
                            bilgiler derlenir ve bu nedenle anonimdir. Bu tanımlama bilgilerine izin vermezseniz
                            sitemizi ne zaman ziyaret ettiğinizi bilemeyiz.</p>
                    </div>
                </li>
            </ul>
        </div>

    </div>

</div>


<div class="js-cookie-consent cookie-consent fixed bottom-0 inset-x-0 pb-2 show">
    <div class="container">
        <div class="p-2 rounded-lg bg-yellow-100">
            <div class="flex items-center justify-between flex-wrap">
                <div class="w-0 flex-1 items-center hidden md:inline text-left">
                    <span class="text-white cookie-consent__message mb-2">
                        {!! trans('cookie-consent::texts.message') !!}
                    </span><br><br>
                    <span>
                        Detaylı bilgi için <a href="{{ url('sayfa/cerez-politikasi') }}" style="color: white"> Çerez
                            Aydınlatma Metni’ni </a> inceleyebilirsiniz.
                    </span>
                </div>

                <div class="mt-2 flex-shrink-0 w-full sm:mt-0 d-flex justify-content-end gap-2">
                    <button
                        class="js-cookie-consent-agree cookie-consent__agree cursor-pointer mr-2 flex items-center justify-center px-4 py-2 rounded-md text-sm font-medium text-yellow-800 bg-yellow-400 hover:bg-yellow-300">
                        {{ trans('cookie-consent::texts.agree') }}
                    </button>

                    <button style="color: black"
                        class="js-cookie-consent-manage cookie-consent__manage cursor-pointer mr-2 flex items-center justify-center px-4 py-2 rounded-md text-sm font-medium text-blue-800 bg-blue-400 hover:bg-blue-300">
                        {{ trans('cookie-consent::texts.manage') }}
                    </button>
                    <button style="color: black"
                        class="js-cookie-consent-decline cookie-consent__decline cursor-pointer flex items-center justify-center px-4 py-2 rounded-md text-sm font-medium text-red-800 bg-red-400 hover:bg-red-300">
                        {{ trans('cookie-consent::texts.decline') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
