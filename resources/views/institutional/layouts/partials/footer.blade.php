
</main><!-- ===============================================-->
<!--    End of Main Content-->
<!-- ===============================================-->

<!-- ===============================================-->
<!--    JavaScripts-->
<!-- ===============================================-->
<script src="{{ URL::to('/') }}/adminassets/vendors/popper/popper.min.js" defer></script>
<script src="{{ URL::to('/') }}/adminassets/vendors/bootstrap/bootstrap.min.js" defer></script>
<script src="{{ URL::to('/') }}/adminassets/vendors/anchorjs/anchor.min.js" defer></script>
<script src="{{ URL::to('/') }}/adminassets/vendors/is/is.min.js" defer></script>
<script src="{{ URL::to('/') }}/adminassets/vendors/fontawesome/all.min.js" defer></script>
<script src="{{ URL::to('/') }}/adminassets/vendors/lodash/lodash.min.js" defer></script>
<script src="{{ URL::to('/') }}/adminassets/polyfill.io/v3/polyfill.min58be.js?features=window.scroll"></script>
<script src="{{ URL::to('/') }}/adminassets/vendors/list.js/list.min.js" defer></script>
<script src="{{ URL::to('/') }}/adminassets/vendors/feather-icons/feather.min.js" defer></script>
<script src="{{ URL::to('/') }}/adminassets/vendors/dayjs/dayjs.min.js" defer></script>
<script src="{{ URL::to('/') }}/adminassets/assets//js/phoenix.js" defer></script>
<script src="{{ URL::to('/') }}/adminassets/vendors/echarts/echarts.min.js" defer></script>
<script src="{{ URL::to('/') }}/adminassets/vendors/leaflet/leaflet.js" defer></script>
<script src="{{ URL::to('/') }}/adminassets/vendors/leaflet.markercluster/leaflet.markercluster.js" defer></script>
<script
    src="{{ URL::to('/') }}/adminassets/vendors/leaflet.tilelayer.colorfilter/leaflet-tilelayer-colorfilter.min.js" defer>
</script>


<!--FormBuilder-->
<script src="https://code.jquery.com/jquery-2.2.4.min.js" defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js" defer></script>
<script src="https://formbuilder.online/assets/js/form-builder.min.js" defer></script>
<script type="text/javascript" src="https://formbuilder.online/assets/js/form-render.min.js" defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.6.0/leaflet.js"></script>
<script src="https://www.jqueryscript.net/demo/leaflet-location-picker/src/leaflet-locationpicker.js"></script>

@vite('resources/js/app.jsx')

<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.6.0/leaflet.js" defer></script>
<script src="https://www.jqueryscript.net/demo/leaflet-location-picker/src/leaflet-locationpicker.js" defer></script>
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
