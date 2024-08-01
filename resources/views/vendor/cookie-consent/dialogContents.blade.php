<div id="cookie-management-modal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black bg-opacity-50">
    <div class="bg-white rounded-lg p-6 w-11/12 max-w-lg">
        <h2 class="text-xl font-semibold mb-4">Çerez Yönetimi</h2>
        <p>Burada çerezlerinizin ayarlarını yönetebilirsiniz.</p>
        <!-- Çerez yönetim seçenekleri buraya eklenebilir -->
        <button id="close-modal" class="mt-4 px-4 py-2 bg-gray-300 rounded-md">Kapat</button>
    </div>
</div>

<div class="js-cookie-consent cookie-consent fixed bottom-0 inset-x-0 pb-2 show">
    <div class="container">
        <div class="p-2 rounded-lg bg-yellow-100">
            <div class="flex items-center justify-between flex-wrap">
                <div class="w-0 flex-1 items-center hidden md:inline text-left">
                    <span class="text-black cookie-consent__message mb-2">
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
                    <button
                        class="js-cookie-consent-decline cookie-consent__decline cursor-pointer mr-2 flex items-center justify-center px-4 py-2 rounded-md text-sm font-medium text-red-800 bg-red-400 hover:bg-red-300">
                        {{ trans('cookie-consent::texts.decline') }}
                    </button>
                    <button
                        class="js-cookie-consent-manage cookie-consent__manage cursor-pointer flex items-center justify-center px-4 py-2 rounded-md text-sm font-medium text-blue-800 bg-blue-400 hover:bg-blue-300">
                        {{ trans('cookie-consent::texts.manage') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
