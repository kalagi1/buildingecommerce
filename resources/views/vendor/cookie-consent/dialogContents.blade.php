<div class="js-cookie-consent cookie-consent fixed bottom-0 inset-x-0 pb-2 show">
    <div class="container">

        <div class="p-2 rounded-lg bg-yellow-100">
            <div class="flex items-center justify-between flex-wrap">
                <div class="w-0 flex-1 items-center hidden md:inline text-left">
                    <span class="text-black cookie-consent__message">
                        {!! trans('cookie-consent::texts.message') !!}
                    </span>
                </div>
                <span>
                    Detaylı bilgi için <a href="{{ url('sayfa/cerez-politikasi') }}" > Çerez
                        Aydınlatma Metni’ni </a> inceleyebilirsiniz.
                </span>

                <div class="mt-2 flex-shrink-0 w-full sm:mt-0 sm:w-auto">
                    <button
                        class="js-cookie-consent-agree cookie-consent__agree cursor-pointer flex items-center justify-center px-4 py-2 rounded-md text-sm font-medium text-yellow-800 bg-yellow-400 hover:bg-yellow-300">
                        {{ trans('cookie-consent::texts.agree') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
