@extends('institutional.layouts.master')

@section('content')
    <div class="content">
        <div id="choise">
            <div class="row">
                <div class="col-lg-6 col-md-12 col-12">
                    <div class="group-icon">
                        <div class="box-icons flex">
                            <div class="images">
                                <img src="assets/images/icon/choise-icon-1.png" alt="images">
                            </div>
                            <div class="content">
                                <div class="title-icon fs-30 lh-45 fw-7 text-color-2">You need a house</div>
                                <p class="font-2 text-color-2">Tell us your needs, we will give you thousands of suggestions for the dream home.</p>
                            </div>
                        </div>
                        <div class="button-choise center">
                            <a class="sc-button" href="contact.html">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M2.25 6.75C2.25 15.034 8.966 21.75 17.25 21.75H19.5C20.0967 21.75 20.669 21.5129 21.091 21.091C21.5129 20.669 21.75 20.0967 21.75 19.5V18.128C21.75 17.612 21.399 17.162 20.898 17.037L16.475 15.931C16.035 15.821 15.573 15.986 15.302 16.348L14.332 17.641C14.05 18.017 13.563 18.183 13.122 18.021C11.4849 17.4191 9.99815 16.4686 8.76478 15.2352C7.53141 14.0018 6.58087 12.5151 5.979 10.878C5.817 10.437 5.983 9.95 6.359 9.668L7.652 8.698C8.015 8.427 8.179 7.964 8.069 7.525L6.963 3.102C6.90214 2.85869 6.76172 2.6427 6.56405 2.48834C6.36638 2.33397 6.1228 2.25008 5.872 2.25H4.5C3.90326 2.25 3.33097 2.48705 2.90901 2.90901C2.48705 3.33097 2.25 3.90326 2.25 4.5V6.75Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>                               
                                <span>Contact Seller</span>
                            </a>
                        </div>  
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 col-12">
                    <div class="group-icon">
                        <div class="box-icons flex">
                            <div class="images">
                                <img src="assets/images/icon/choise-icon-1.png" alt="images">
                            </div>
                            <div class="content">
                                <div class="title-icon fs-30 lh-45 fw-7 text-color-2">You need a house</div>
                                <p class="font-2 text-color-2">Tell us your needs, we will give you thousands of suggestions for the dream home.</p>
                            </div>
                        </div>
                        <div class="button-choise center">
                            <a class="sc-button" href="contact.html">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M2.25 6.75C2.25 15.034 8.966 21.75 17.25 21.75H19.5C20.0967 21.75 20.669 21.5129 21.091 21.091C21.5129 20.669 21.75 20.0967 21.75 19.5V18.128C21.75 17.612 21.399 17.162 20.898 17.037L16.475 15.931C16.035 15.821 15.573 15.986 15.302 16.348L14.332 17.641C14.05 18.017 13.563 18.183 13.122 18.021C11.4849 17.4191 9.99815 16.4686 8.76478 15.2352C7.53141 14.0018 6.58087 12.5151 5.979 10.878C5.817 10.437 5.983 9.95 6.359 9.668L7.652 8.698C8.015 8.427 8.179 7.964 8.069 7.525L6.963 3.102C6.90214 2.85869 6.76172 2.6427 6.56405 2.48834C6.36638 2.33397 6.1228 2.25008 5.872 2.25H4.5C3.90326 2.25 3.33097 2.48705 2.90901 2.90901C2.48705 3.33097 2.25 3.90326 2.25 4.5V6.75Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>                               
                                <span>Contact Seller</span>
                            </a>
                        </div>  
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row justify-content-center">
            <div class="col-md-4 col-6">
                <div class="choise-adv">
                    <a class="choise-adv-inner" href="{{ route('institutional.project.create.v2') }}">
                        <div class="card_image"> 
                            <img
                                src="{{URL::to('/')}}/proje.png" />
                        </div>
                        <div class="card_title title-white">
                            <p style="background: #ea2a28;">Proje İlanı Ekle</p>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-md-4 col-6">
                <div class="choise-adv">
                    <a class="choise-adv-inner" href="{{ route('institutional.housing.create.v2') }}">
                        <div class="card_image"> <img
                                src="{{URL::to('/')}}/emlak.png" />
                        </div>
                        <div class="card_title title-white">
                            <p style="background: #004aad;">Emlak İlanı Ekle</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script></script>
@endsection


@section('css')
<style>
    -------------------------------------------------------------- */
#choise {
  padding: 100px 0 43px;
  background: #1C1C1E;
  position: relative;
  color: #fff;
}
#choise .group-icon {
  margin-bottom: 113px;
}
#choise .group-icon .box-icons {
  background-color: #FFF5E0;
  border-radius: 12px;
  padding: 30px 31px 45px 30px;
}
#choise .group-icon .box-icons .images {
  flex: none;
  margin-right: 30px;
}
#choise .group-icon .box-icons .images img {
  transition: all 0.8s ease;
}
#choise .group-icon .box-icons .title-icon {
  margin-bottom: 13px;
}
#choise .group-icon .box-icons:hover .images img {
  transform: rotateY(180deg);
}
#choise .group-icon .button-choise {
  margin-top: -26px;
}
#choise .group-icon .button-choise .sc-button {
  width: 212px;
  margin-right: 8px;
}
#choise .group-icon .button-choise .sc-button span {
  position: relative;
}
#choise .group-icon .button-choise .sc-button span::before {
  content: "";
  width: 1px;
  height: 22px;
  background-color: rgba(255, 255, 255, 0.2);
  margin-left: -11px;
  position: absolute;
}
#choise h3 {
  margin-bottom: 24px;
}
#choise.home2 {
  background: #fff;
  color: #120A21;
  padding: 0 0 43px;
}
#choise.home2 .widget-menu .box-menu li a {
  color: #120A21;
}
#choise.home2 .widget-menu .box-menu li a:hover {
  color: #FFA920;
}
#choise.home2 .widget-form button {
  color: #FFA920;
  background: linear-gradient(0deg, #FFF5E0, #FFF5E0), linear-gradient(0deg, rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0.1));
}
#choise.home2 .widget-form button::after {
  color: #FFA920;
}
#choise.home2 .widget-form button:hover {
  background: #FFA920;
  color: #fff;
}
#choise.home2 .widget-form button:hover::after {
  color: #fff;
}
#choise.home2 .widget-form .btn-checkbox {
  border: 1px solid #E5E5EA;
}

.widget-info .sub-title {
  margin-bottom: 6px;
}
.widget-info h5 {
  margin-bottom: 16px;
}
.widget-info .text-1 {
  margin-bottom: 13px;
}
.text-color-2 {
    color: #000 !important;
}
.fs-30 {
    font-size: 30px;
}
.fw-7 {
    font-weight: 700;
}
.sc-button {
    display: inline-block;
    background-color: #FFA920;
    box-sizing: border-box;
    padding: 15px 18.5px;
    border-radius: 10px;
    -webkit-transition: all 0.3s ease;
    -moz-transition: all 0.3s ease;
    -ms-transition: all 0.3s ease;
    -o-transition: all 0.3s ease;
    transition: all 0.3s ease;
}

.lh-45 {
    line-height: 45px;
}
</style>
    
@endsection
