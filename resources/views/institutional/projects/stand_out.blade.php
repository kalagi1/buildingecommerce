@extends('institutional.layouts.master')

@section('content')

  <div class="content">
    <form action="{{route('institutional.stand.out.post',$projectId)}}" method="post">
        @csrf 
        <input type="hidden" name="key">
        <input type="hidden" name="bank_id">
        <input type="hidden" name="price">
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
                <input type="checkbox" name="is_top_row" class="d-none" value="1">
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
          <span class="payment-area d-flex btn btn-info mt-3" style="display: inline-block !important">Devam</span>
        </div>
      </div>
      
        <div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="paymentModalLabel">Emlak Sepette Ödeme Adımı</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            &times;
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="invoice">
                            <div class="invoice-header mb-3">
                                <strong>Fatura Tarihi: {{ date('d.m.Y') }}</strong>
                            </div>

                            <div class="invoice-body">
                                <table class="table table-bordered d-none d-md-table"> <!-- Tabloyu sadece tablet ve daha büyük ekranlarda göster -->
                                    <thead>
                                        <tr>
                                            <th>Ürün Adı</th>
                                            <th>Miktar</th>
                                            <th>Fiyat</th>
                                            <th>Toplam</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Doping Ücreti</td>
                                            <td>1</td>
                                            <td>2500 ₺</td>
                                            <td>2500 ₺</td>
                                        </tr>
                                    </tbody>
                                </table>
                    
                                <!-- Mobilde sadece alt alta liste göster -->
                                <div class="d-md-none">
                                    <ul class="list-group">
                                        <li class="list-group-item">
                                            <strong>Ürün Adı:</strong> Doping Ücreti
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Miktar:</strong> 1
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Fiyat:</strong> 2500 ₺
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Toplam:</strong> 2500 ₺
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="invoice-total mt-3">
                                <strong class="mt-3">EFT/Havale yapacağınız bankayı seçiniz</strong>
                                <div class="row mb-3 px-5 mt-3">
                                    @foreach ($bankAccounts as $bankAccount)
                                        <div class="col-md-4 bank-account" data-id="{{ $bankAccount->id }}"
                                            data-iban="{{ $bankAccount->iban }}"
                                            data-title="{{ $bankAccount->receipent_full_name }}">
                                            <img src="{{ URL::to('/') }}/{{ $bankAccount->image }}" alt=""
                                                style="width: 100%;height:100px;object-fit:contain;cursor:pointer">
                                        </div>
                                    @endforeach
                                </div>
                                <div id="ibanInfo"></div>
                                <strong>Ödeme işlemini tamamlamak için, lütfen bu
                                    <span style="color:red" id="uniqueCode"></span> kodu kullanarak ödemenizi
                                    yapın. IBAN açıklama
                                    alanına
                                    bu kodu eklemeyi unutmayın. Ardından "Ödemeyi Tamamla" düğmesine tıklayarak işlemi
                                    bitirin.</strong>

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" @if ((Auth::check() && Auth::user()->type == '2') || (Auth::check() && Auth::user()->parent_id)) disabled @endif
                            class="btn btn-primary btn-lg btn-block mb-3" id="completePaymentButton">Satın Al
                        </button>
                    </div>
                </div>
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
        
        function generateUniqueCode() {
            return Math.random().toString(36).substring(2, 10).toUpperCase();
        }

        $('.bank-account').on('click', function() {
            // Tüm banka görsellerini seçim olmadı olarak ayarla
            $('.bank-account').removeClass('selected');

            // Seçilen banka görselini işaretle
            $(this).addClass('selected');

            // İlgili IBAN bilgisini al
            var selectedBankIban = $(this).data('iban');
            var selectedBankIbanID = $(this).data('id');
            var selectedBankTitle = $(this).data('title');
            $('input[name="bank_id"]').val(selectedBankIbanID);

            // IBAN bilgisini ekranda göster
            $('#ibanInfo').text(selectedBankTitle + " : " + selectedBankIban);
            // Ödeme düğmesini etkinleştir
            $('#completePaymentButton').prop('disabled', false);
        });

        $('#completePaymentButton').on('click', function() {
            $('#paymentModal').removeClass('show');
            $('#paymentModal').css('display','none');
            $('#finalConfirmationModal').modal('show');
        });

        $('.payment-area').click(function(e){
            e.preventDefault();
            e.stopPropagation();
            var totalPrice = '';
            $(this).append('<div class="loading-icon"><i class="fa fa-spinner"></i></div>')
            var thisx = $(this);
            var data = {
                featured : $('input[name="is_featured"]').is(':checked') ? 1 : 0,
                top_row : $('input[name="is_top_row"]').is(':checked') ? 1 : 0,
                featured_id : $('select[name="selected_featured_price"]').val(),
                top_row_id : $('select[name="selected_top_row_price"]').val(),
            }

            $.ajax({
                url: '{{route("institutional.project.stand.out.total.price")}}',
                data : data,
                type: 'GET',
                success: function(response) {
                    response = response;
                    var totalPrice = 0;
                    for(var i = 0 ; i < response.length; i++){
                        totalPrice += response[i].price; 
                    }
                    $('input[name="price"]').val(totalPrice);
                    if(totalPrice == 0){
                        $('.without-doping').trigger("click")
                    }else{
                        $('#paymentModal').addClass('show')
                        $('#paymentModal').addClass('d-block')
                        
                        var uniqueCode = generateUniqueCode();
                        $('#uniqueCode').text(uniqueCode);
                        $('#uniqueCodeRetry').text(uniqueCode);
                        $("#orderKey").val(uniqueCode);
                        $('input[name="key"]').val(uniqueCode);
                        thisx.find('.loading-icon').remove();
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Ajax isteği sırasında bir hata oluştu: " + error);
                }
            });
          
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

  