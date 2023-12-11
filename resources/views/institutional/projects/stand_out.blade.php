@extends('institutional.layouts.master')

@section('content')

  <div class="content">
    <form action="{{route('institutional.stand.out.post',$projectId)}}">
      <div class="row">
        <div class="col-md-4">
          <div class="doping-square" data-id="1">
              <input type="checkbox" name="is_featured" class="d-none" value="1">
              <div class="row" style="align-items: center">
                  <div class="col-md-12">
                      <span class="doping-is-selected"> Seçilmedi</span>
                      <img src="{{ URL::to('/') }}/images/emlaksepettelogo.png" alt="">
                      <h4 class="mt-3">Öne Çıkarılanlar Vitrini</h4>
                      <span>İlanınız anasayfamızda önce çıkan emlak ilanları sekmesinde yer alsın.</span>
                      <select name="selected_featured_price" id="" class="form-control mt-3">
                          @foreach($featuredPrices as $price)
                              <option @if(isset($tempDataFull) && isset($tempData) && isset($tempData->featured_data_day) && $tempData->featured_data_day == $price->day) selected @endif value="{{$price->day}}">{{$price->day / 7}} Hafta ({{$price->price}} TL)</option>
                          @endforeach
                      </select>
                  </div>
              </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="doping-square @if(isset($tempDataFull) && isset($tempData) && isset($tempData->top_row) && $tempData->top_row) selected @endif" data-id="2">
              <div class="row" style="align-items: center">
                  <div class="col-md-12">
                      <span class="doping-is-selected">@if(isset($tempDataFull) && isset($tempData) && isset($tempData->top_row) && $tempData->top_row) Seçildi @else Seçilmedi @endif</span>
                      <img src="{{ URL::to('/') }}/images/emlaksepettelogo.png" alt="">
                      <h4 class="mt-3">Üst Sıradayım</h4>
                      <span>İlanınız anasayfamızda önce çıkan emlak ilanları sekmesinde yer alsın.</span>
                      <select name="selected_top_row_price" id="" class="form-control mt-3">
                          @foreach($topRowPrices as $price)
                              <option @if(isset($tempDataFull) && isset($tempData) && isset($tempData->top_row_data_day) && $tempData->top_row_data_day == $price->day) selected @endif value="{{$price->day}}">{{$price->day / 7}} Hafta ({{$price->price}} TL)</option>
                          @endforeach
                      </select>
                  </div>
              </div>
          </div>
        </div>
        <div class="col-md-12">
          <button class="payment-area d-flex btn btn-info">Devam</button>
        </div>
      </div>
      <div class="modal fade" id="finalConfirmationModal" tabindex="-1" role="dialog"
          aria-labelledby="finalConfirmationModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg" role="document">
              <div class="modal-content">
                  <div class="modal-header">
                      <h5 class="modal-title" id="finalConfirmationModalLabel">Ödeme Onayı</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
                  <div class="modal-body">
                      <p>Ödemeniz başarıyla tamamlamak için lütfen aşağıdaki adımları takip edin:</p>
                      <ol>
                          <li>
                              <strong style="color:red" id="uniqueCodeRetry"></strong> kodunu EFT/Havale açıklama
                              alanına yazdığınızdan emin olun.
                          </li>
                          <li>
                              Son olarak, işlemi bitirmek için aşağıdaki butona tıklayın: <br>
                              <button type="submit" class="btn btn-primary without-doping mt-3">Ödemeyi Tamamla
                                  <svg viewBox="0 0 576 512" style="width: 16px;color: #fff;fill: #fff;" class="svgIcon">
                                      <path
                                          d="M512 80c8.8 0 16 7.2 16 16v32H48V96c0-8.8 7.2-16 16-16H512zm16 144V416c0 8.8-7.2 16-16 16H64c-8.8 0-16-7.2-16-16V224H528zM64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H512c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64zm56 304c-13.3 0-24 10.7-24 24s10.7 24 24 24h48c13.3 0 24-10.7 24-24s-10.7-24-24-24H120zm128 0c-13.3 0-24 10.7-24 24s10.7 24 24 24H360c13.3 0 24-10.7 24-24s-10.7-24-24-24H248z">
                                      </path>
                                  </svg></button>
                          </li>
                      </ol>
                  </div>
              </div>
          </div>
      </div>
    </form>
  </div>

  @endsection

  @section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.css" integrity="sha512-8D+M+7Y6jVsEa7RD6Kv/Z7EImSpNpQllgaEIQAtqHcI0H6F4iZknRj0Nx1DCdB+TwBaS+702BGWYC0Ze2hpExQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.min.css">
  @endsection

  @section('scripts')
  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.js" integrity="sha512-zlWWyZq71UMApAjih4WkaRpikgY9Bz1oXIW5G0fED4vk14JjGlQ1UmkGM392jEULP8jbNMiwLWdM8Z87Hu88Fw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.min.js"></script>
    <script>
        $('.payment-area').click(function(e){
          e.preventDefault();
          var totalPrice = '';
          $(this).append('<div class="loading-icon"><i class="fa fa-spinner"></i></div>')
          var thisx = $(this);
          $.ajax({
              url: '{{route("institutional.project.stand.out.total.price")}}?item_type='+1,
              type: 'GET',
              success: function(response) {
                  response = response;
                  var totalPrice = 0;
                  for(var i = 0 ; i < response.length; i++){
                      totalPrice += response[i].price; 
                  }
                  if(totalPrice == 0){
                      $('.without-doping').trigger("click")
                  }else{
                      $('.invoice-body table tbody tr').eq(0).find('td').eq(2).html(totalPrice.toFixed(2)+'₺')
                      $('.invoice-body table tbody tr').eq(0).find('td').eq(3).html(totalPrice.toFixed(2)+'₺')
                      $('#paymentModal').addClass('show')
                      $('#paymentModal').addClass('d-block')
                      
                      var uniqueCode = generateUniqueCode();
                      $('#uniqueCode').text(uniqueCode);
                      $('#uniqueCodeRetry').text(uniqueCode);
                      $("#orderKey").val(uniqueCode);
                      changeData(uniqueCode,"key");
                      thisx.find('.loading-icon').remove();
                  }
              },
              error: function(xhr, status, error) {
                  console.error("Ajax isteği sırasında bir hata oluştu: " + error);
              }
          });
          for(var i = 0; i < selectedDopings.length; i++){
              totalPrice += parseFloat(selectedDopings[i].price);
          }
          
      })
        $('#paymentModal').click(function(){
          $(this).removeClass('show')
          $(this).removeClass('d-block')
        })

        $('#paymentModal .close').click(function(){
          $(this).removeClass('show')
          $(this).removeClass('d-block')
        })

        $('#paymentModal .modal-dialog').click(function(e){
          if(!$(event.target).hasClass('close')){
              e.stopPropagation();
          }
        })

        $('#completePaymentButton').on('click', function() {
            $('#paymentModal').removeClass('show');
            $('#paymentModal').css('display','none');
            $('#finalConfirmationModal').modal('show');
        });

        $('.doping-square').click(function(){
          if($(this).hasClass('selected')){
              $(this).find('input[type="checkbox"]').prop("checked", false);
              $(this).removeClass('selected')
              $(this).find('.doping-is-selected').html('Seçilmedi')
          }else{
              $(this).find('input[type="checkbox"]').prop("checked", true);
              $(this).addClass('selected')
              $(this).find('.doping-is-selected').html('Seçildi')
          }
        })
        $('.doping-square select').click(function(e){
            e.stopPropagation();
        })
        $('.doping-square select').change(function(e) {
            var dataId = $(this).closest('.doping-square').attr('data-id')
            $(this).closest('.doping-square').find('input[type="checkbox"]').prop("checked", true);
            $(this).closest('.doping-square').addClass('selected');
            
        })
    </script>
  @endsection

  