<div class="support-chat-container">
    <div class="container-fluid support-chat">
        <div class="card bg-white">
            <div class="card-header d-flex flex-between-center px-4 py-3 border-bottom">
                <h5 class="mb-0 d-flex align-items-center gap-2">Demo widget<span
                        class="fa-solid fa-circle text-success fs--3"></span></h5>
                <div class="btn-reveal-trigger"><button
                        class="btn btn-link p-0 dropdown-toggle dropdown-caret-none transition-none d-flex" type="button"
                        id="support-chat-dropdown" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true"
                        aria-expanded="false" data-bs-reference="parent"><span
                            class="fas fa-ellipsis-h text-900"></span></button>
                    <div class="dropdown-menu dropdown-menu-end py-2" aria-labelledby="support-chat-dropdown"><a
                            class="dropdown-item" href="#!">Request a callback</a><a class="dropdown-item"
                            href="#!">Search in chat</a><a class="dropdown-item" href="#!">Show history</a><a
                            class="dropdown-item" href="#!">Report to Admin</a><a
                            class="dropdown-item btn-support-chat" href="#!">Close Support</a></div>
                </div>
            </div>
            <div class="card-body chat p-0">
                <div class="d-flex flex-column-reverse scrollbar h-100 p-3">
                    <div class="text-end mt-6"><a
                            class="mb-2 d-inline-flex align-items-center text-decoration-none text-1100 hover-bg-soft rounded-pill border border-primary py-2 ps-4 pe-3"
                            href="#!">
                            <p class="mb-0 fw-semi-bold fs--1">I need help with something</p><span
                                class="fa-solid fa-paper-plane text-primary fs--1 ms-3"></span>
                        </a><a
                            class="mb-2 d-inline-flex align-items-center text-decoration-none text-1100 hover-bg-soft rounded-pill border border-primary py-2 ps-4 pe-3"
                            href="#!">
                            <p class="mb-0 fw-semi-bold fs--1">I can’t reorder a product I previously ordered</p><span
                                class="fa-solid fa-paper-plane text-primary fs--1 ms-3"></span>
                        </a><a
                            class="mb-2 d-inline-flex align-items-center text-decoration-none text-1100 hover-bg-soft rounded-pill border border-primary py-2 ps-4 pe-3"
                            href="#!">
                            <p class="mb-0 fw-semi-bold fs--1">How do I place an order?</p><span
                                class="fa-solid fa-paper-plane text-primary fs--1 ms-3"></span>
                        </a><a
                            class="false d-inline-flex align-items-center text-decoration-none text-1100 hover-bg-soft rounded-pill border border-primary py-2 ps-4 pe-3"
                            href="#!">
                            <p class="mb-0 fw-semi-bold fs--1">My payment method not working</p><span
                                class="fa-solid fa-paper-plane text-primary fs--1 ms-3"></span>
                        </a></div>
                    <div class="text-center mt-auto">
                        <div class="avatar avatar-3xl status-online"><img
                                class="rounded-circle border border-3 border-white"
                                src="{{ URL::to('/') }}/adminassets/assets//img/team/30.webp" alt="" /></div>
                        <h5 class="mt-2 mb-3">Eric</h5>
                        <p class="text-center text-black mb-0">Ask us anything – we’ll get back to you here or by email
                            within 24 hours.</p>
                    </div>
                </div>
            </div>
            <div class="card-footer d-flex align-items-center gap-2 border-top ps-3 pe-4 py-3">
                <div class="d-flex align-items-center flex-1 gap-3 border rounded-pill px-4"><input
                        class="form-control outline-none border-0 flex-1 fs--1 px-0" type="text"
                        placeholder="Write message" /><label class="btn btn-link d-flex p-0 text-500 fs--1 border-0"
                        for="supportChatPhotos"><span class="fa-solid fa-image"></span></label><input class="d-none"
                        type="file" accept="image/*" id="supportChatPhotos" /><label
                        class="btn btn-link d-flex p-0 text-500 fs--1 border-0" for="supportChatAttachment"> <span
                            class="fa-solid fa-paperclip"></span></label><input class="d-none" type="file"
                        id="supportChatAttachment" /></div><button class="btn p-0 border-0 send-btn"><span
                        class="fa-solid fa-paper-plane fs--1"></span></button>
            </div>
        </div>
    </div>
</div>
</main><!-- ===============================================-->
<!--    End of Main Content-->
<!-- ===============================================-->

<!-- ===============================================-->
<!--    JavaScripts-->
<!-- ===============================================-->
<script src="{{ URL::to('/') }}/adminassets/vendors//popper/popper.min.js" ></script>
<script src="{{ URL::to('/') }}/adminassets/vendors//bootstrap/bootstrap.min.js" ></script>
<script src="{{ URL::to('/') }}/adminassets/vendors//anchorjs/anchor.min.js" ></script>
<script src="{{ URL::to('/') }}/adminassets/vendors//is/is.min.js" ></script>
<script src="{{ URL::to('/') }}/adminassets/vendors//fontawesome/all.min.js" ></script>
<script src="{{ URL::to('/') }}/adminassets/vendors//lodash/lodash.min.js" ></script>
<script src="{{ URL::to('/') }}/adminassets/polyfill.io/v3/polyfill.min58be.js?features=window.scroll"></script>
<script src="{{ URL::to('/') }}/adminassets/vendors//list.js/list.min.js" ></script>
<script src="{{ URL::to('/') }}/adminassets/vendors//feather-icons/feather.min.js" ></script>
<script src="{{ URL::to('/') }}/adminassets/vendors//dayjs/dayjs.min.js" ></script>
<script src="{{ URL::to('/') }}/adminassets/assets//js/phoenix.js" ></script>
<script src="{{ URL::to('/') }}/adminassets/vendors//echarts/echarts.min.js" ></script>
<script src="{{ URL::to('/') }}/adminassets/vendors//leaflet/leaflet.js" ></script>
<script src="{{ URL::to('/') }}/adminassets/vendors//leaflet.markercluster/leaflet.markercluster.js" ></script>
<script
    src="{{ URL::to('/') }}/adminassets/vendors//leaflet.tilelayer.colorfilter/leaflet-tilelayer-colorfilter.min.js" >
</script>


<!--FormBuilder-->
<script src="https://code.jquery.com/jquery-2.2.4.min.js" ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js" ></script>
<script src="https://formbuilder.online/assets/js/form-builder.min.js" ></script>
<script type="text/javascript" src="https://formbuilder.online/assets/js/form-render.min.js" ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.6.0/leaflet.js"></script>
<script src="https://www.jqueryscript.net/demo/leaflet-location-picker/src/leaflet-locationpicker.js"></script>

<script src="{{URL::to('/')}}/build/assets/app-4312f8fc.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.6.0/leaflet.js" ></script>
<script src="https://www.jqueryscript.net/demo/leaflet-location-picker/src/leaflet-locationpicker.js" ></script>
<script>
    $('*[data-bs-toggle="dropdown"]').click(function(){
        if($(this).hasClass('show')){
            $(this).removeClass('show');
            $(this).parent().children('.dropdown-menu').removeClass('show');
            $(this).parent().children('.dropdown-menu').removeAttr('data-bs-popper')
        }else{
            $(this).addClass('show');
            $(this).parent().children('.dropdown-menu').addClass('show');
            $(this).parent().children('.dropdown-menu').attr('data-bs-popper','static')
        }
    })
</script>

@yield('scripts')
</body>


</html>