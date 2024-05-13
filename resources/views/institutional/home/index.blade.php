@extends('institutional.layouts.master')


@section('content')
    <div class="content">
        @if (isset($userLog->parent))
            <div class="row gy-3 mb-5 justify-content-between">
                <div class="col-md-12 col-auto">
                    <span class="badge bg-info "> Kurumsal Hesap:
                        {{ $userLog->parent->name }}</span>
                    <span class="badge bg-info "> Referans Kodu:
                        {{ $userLog->code }}</span>

                </div>

            </div>
        @else
            <div class="row gy-3 mb-5 justify-content-between">
                <div class="col-md-12 col-auto">
                    <span class="badge bg-info ">
                        {{ $userLog->corporate_type }}</span>

                </div>

            </div>
        @endif

        @if (Auth::check() && Auth::user()->type == '2')
        <div class="row g-4">
            <div class="col-12 col-xxl-6">
              <div class="mb-8">
                <h2 class="mb-2">Ecommerce Dashboard</h2>
                <h5 class="text-body-tertiary fw-semibold">Here’s what’s going on at your business right now</h5>
              </div>
              <div class="row align-items-center g-4">
                <div class="col-12 col-md-auto">
                  <div class="d-flex align-items-center"><span class="fa-stack" style="min-height: 46px;min-width: 46px;"><svg class="svg-inline--fa fa-square fa-stack-2x dark__text-opacity-50 text-success-light" data-fa-transform="down-4 rotate--10 left-4" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="square" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="" style="transform-origin: 0.1875em 0.75em;"><g transform="translate(224 256)"><g transform="translate(-128, 128)  scale(1, 1)  rotate(-10 0 0)"><path fill="currentColor" d="M0 96C0 60.65 28.65 32 64 32H384C419.3 32 448 60.65 448 96V416C448 451.3 419.3 480 384 480H64C28.65 480 0 451.3 0 416V96z" transform="translate(-224 -256)"></path></g></g></svg><!-- <span class="fa-solid fa-square fa-stack-2x dark__text-opacity-50 text-success-light" data-fa-transform="down-4 rotate--10 left-4"></span> Font Awesome fontawesome.com --><svg class="svg-inline--fa fa-circle fa-stack-2x stack-circle text-stats-circle-success" data-fa-transform="up-4 right-3 grow-2" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="" style="transform-origin: 0.6875em 0.25em;"><g transform="translate(256 256)"><g transform="translate(96, -128)  scale(1.125, 1.125)  rotate(0 0 0)"><path fill="currentColor" d="M512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256z" transform="translate(-256 -256)"></path></g></g></svg><!-- <span class="fa-solid fa-circle fa-stack-2x stack-circle text-stats-circle-success" data-fa-transform="up-4 right-3 grow-2"></span> Font Awesome fontawesome.com --><svg class="svg-inline--fa fa-star fa-stack-1x text-success" data-fa-transform="shrink-2 up-8 right-6" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="" style="transform-origin: 0.9375em 0em;"><g transform="translate(288 256)"><g transform="translate(192, -256)  scale(0.875, 0.875)  rotate(0 0 0)"><path fill="currentColor" d="M381.2 150.3L524.9 171.5C536.8 173.2 546.8 181.6 550.6 193.1C554.4 204.7 551.3 217.3 542.7 225.9L438.5 328.1L463.1 474.7C465.1 486.7 460.2 498.9 450.2 506C440.3 513.1 427.2 514 416.5 508.3L288.1 439.8L159.8 508.3C149 514 135.9 513.1 126 506C116.1 498.9 111.1 486.7 113.2 474.7L137.8 328.1L33.58 225.9C24.97 217.3 21.91 204.7 25.69 193.1C29.46 181.6 39.43 173.2 51.42 171.5L195 150.3L259.4 17.97C264.7 6.954 275.9-.0391 288.1-.0391C300.4-.0391 311.6 6.954 316.9 17.97L381.2 150.3z" transform="translate(-288 -256)"></path></g></g></svg><!-- <span class="fa-stack-1x fa-solid fa-star text-success " data-fa-transform="shrink-2 up-8 right-6"></span> Font Awesome fontawesome.com --></span>
                    <div class="ms-3">
                      <h4 class="mb-0">57 new orders</h4>
                      <p class="text-body-secondary fs-9 mb-0">Awating processing</p>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-md-auto">
                  <div class="d-flex align-items-center"><span class="fa-stack" style="min-height: 46px;min-width: 46px;"><svg class="svg-inline--fa fa-square fa-stack-2x dark__text-opacity-50 text-warning-light" data-fa-transform="down-4 rotate--10 left-4" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="square" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="" style="transform-origin: 0.1875em 0.75em;"><g transform="translate(224 256)"><g transform="translate(-128, 128)  scale(1, 1)  rotate(-10 0 0)"><path fill="currentColor" d="M0 96C0 60.65 28.65 32 64 32H384C419.3 32 448 60.65 448 96V416C448 451.3 419.3 480 384 480H64C28.65 480 0 451.3 0 416V96z" transform="translate(-224 -256)"></path></g></g></svg><!-- <span class="fa-solid fa-square fa-stack-2x dark__text-opacity-50 text-warning-light" data-fa-transform="down-4 rotate--10 left-4"></span> Font Awesome fontawesome.com --><svg class="svg-inline--fa fa-circle fa-stack-2x stack-circle text-stats-circle-warning" data-fa-transform="up-4 right-3 grow-2" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="" style="transform-origin: 0.6875em 0.25em;"><g transform="translate(256 256)"><g transform="translate(96, -128)  scale(1.125, 1.125)  rotate(0 0 0)"><path fill="currentColor" d="M512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256z" transform="translate(-256 -256)"></path></g></g></svg><!-- <span class="fa-solid fa-circle fa-stack-2x stack-circle text-stats-circle-warning" data-fa-transform="up-4 right-3 grow-2"></span> Font Awesome fontawesome.com --><svg class="svg-inline--fa fa-pause fa-stack-1x text-warning" data-fa-transform="shrink-2 up-8 right-6" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="pause" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg="" style="transform-origin: 0.6875em 0em;"><g transform="translate(160 256)"><g transform="translate(192, -256)  scale(0.875, 0.875)  rotate(0 0 0)"><path fill="currentColor" d="M272 63.1l-32 0c-26.51 0-48 21.49-48 47.1v288c0 26.51 21.49 48 48 48L272 448c26.51 0 48-21.49 48-48v-288C320 85.49 298.5 63.1 272 63.1zM80 63.1l-32 0c-26.51 0-48 21.49-48 48v288C0 426.5 21.49 448 48 448l32 0c26.51 0 48-21.49 48-48v-288C128 85.49 106.5 63.1 80 63.1z" transform="translate(-160 -256)"></path></g></g></svg><!-- <span class="fa-stack-1x fa-solid fa-pause text-warning " data-fa-transform="shrink-2 up-8 right-6"></span> Font Awesome fontawesome.com --></span>
                    <div class="ms-3">
                      <h4 class="mb-0">5 orders</h4>
                      <p class="text-body-secondary fs-9 mb-0">On hold</p>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-md-auto">
                  <div class="d-flex align-items-center"><span class="fa-stack" style="min-height: 46px;min-width: 46px;"><svg class="svg-inline--fa fa-square fa-stack-2x dark__text-opacity-50 text-danger-light" data-fa-transform="down-4 rotate--10 left-4" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="square" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="" style="transform-origin: 0.1875em 0.75em;"><g transform="translate(224 256)"><g transform="translate(-128, 128)  scale(1, 1)  rotate(-10 0 0)"><path fill="currentColor" d="M0 96C0 60.65 28.65 32 64 32H384C419.3 32 448 60.65 448 96V416C448 451.3 419.3 480 384 480H64C28.65 480 0 451.3 0 416V96z" transform="translate(-224 -256)"></path></g></g></svg><!-- <span class="fa-solid fa-square fa-stack-2x dark__text-opacity-50 text-danger-light" data-fa-transform="down-4 rotate--10 left-4"></span> Font Awesome fontawesome.com --><svg class="svg-inline--fa fa-circle fa-stack-2x stack-circle text-stats-circle-danger" data-fa-transform="up-4 right-3 grow-2" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="" style="transform-origin: 0.6875em 0.25em;"><g transform="translate(256 256)"><g transform="translate(96, -128)  scale(1.125, 1.125)  rotate(0 0 0)"><path fill="currentColor" d="M512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256z" transform="translate(-256 -256)"></path></g></g></svg><!-- <span class="fa-solid fa-circle fa-stack-2x stack-circle text-stats-circle-danger" data-fa-transform="up-4 right-3 grow-2"></span> Font Awesome fontawesome.com --><svg class="svg-inline--fa fa-xmark fa-stack-1x text-danger" data-fa-transform="shrink-2 up-8 right-6" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="xmark" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg="" style="transform-origin: 0.6875em 0em;"><g transform="translate(160 256)"><g transform="translate(192, -256)  scale(0.875, 0.875)  rotate(0 0 0)"><path fill="currentColor" d="M310.6 361.4c12.5 12.5 12.5 32.75 0 45.25C304.4 412.9 296.2 416 288 416s-16.38-3.125-22.62-9.375L160 301.3L54.63 406.6C48.38 412.9 40.19 416 32 416S15.63 412.9 9.375 406.6c-12.5-12.5-12.5-32.75 0-45.25l105.4-105.4L9.375 150.6c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0L160 210.8l105.4-105.4c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25l-105.4 105.4L310.6 361.4z" transform="translate(-160 -256)"></path></g></g></svg><!-- <span class="fa-stack-1x fa-solid fa-xmark text-danger " data-fa-transform="shrink-2 up-8 right-6"></span> Font Awesome fontawesome.com --></span>
                    <div class="ms-3">
                      <h4 class="mb-0">15 products</h4>
                      <p class="text-body-secondary fs-9 mb-0">Out of stock</p>
                    </div>
                  </div>
                </div>
              </div>
              <hr class="bg-body-secondary mb-6 mt-4">
              <div class="row flex-between-center mb-4 g-3">
                <div class="col-auto">
                  <h3>Total sells</h3>
                  <p class="text-body-tertiary lh-sm mb-0">Payment received across all channels</p>
                </div>
                <div class="col-8 col-sm-4"><select class="form-select form-select-sm" id="select-gross-revenue-month">
                    <option>Mar 1 - 31, 2022</option>
                    <option>April 1 - 30, 2022</option>
                    <option>May 1 - 31, 2022</option>
                  </select></div>
              </div>
              <div class="echart-total-sales-chart" style="min-height: 320px; width: 100%; user-select: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); position: relative;" _echarts_instance_="ec_1715613235385"><div style="position: relative; width: 878px; height: 320px; padding: 0px; margin: 0px; border-width: 0px; cursor: default;"><canvas data-zr-dom-id="zr_0" width="878" height="320" style="position: absolute; left: 0px; top: 0px; width: 878px; height: 320px; user-select: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); padding: 0px; margin: 0px; border-width: 0px;"></canvas></div><div class="" style="position: absolute; display: block; border-style: solid; white-space: nowrap; z-index: 9999999; box-shadow: rgba(0, 0, 0, 0.2) 1px 2px 10px; background-color: rgb(239, 242, 246); border-width: 1px; border-radius: 4px; color: rgb(20, 24, 36); font: 14px / 21px &quot;Microsoft YaHei&quot;; padding: 10px; top: 0px; left: 0px; transform: translate3d(356px, 58px, 0px); border-color: rgb(203, 208, 221); pointer-events: none; visibility: hidden; opacity: 0;"><div class="ms-1">
              <h6 class="fs-9 text-body-tertiary false"><svg class="svg-inline--fa fa-circle me-2" style="color: #3874ff;" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""><path fill="currentColor" d="M512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256z"></path></svg><!-- <span class="fas fa-circle me-2" style="color:#3874ff"></span> Font Awesome fontawesome.com -->
      May 12 : 500
    </h6><h6 class="fs-9 text-body-tertiary mb-0"><svg class="svg-inline--fa fa-circle me-2" style="color: #0097eb;" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""><path fill="currentColor" d="M512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256z"></path></svg><!-- <span class="fas fa-circle me-2" style="color:#0097eb"></span> Font Awesome fontawesome.com -->
      Apr 12 : 50
    </h6>
            </div></div></div>
            </div>
            <div class="col-12 col-xxl-6">
              <div class="row g-3">
                <div class="col-12 col-md-6">
                  <div class="card h-100">
                    <div class="card-body">
                      <div class="d-flex justify-content-between">
                        <div>
                          <h5 class="mb-1">Total orders<span class="badge badge-phoenix badge-phoenix-warning rounded-pill fs-9 ms-2"><span class="badge-label">-6.8%</span></span></h5>
                          <h6 class="text-body-tertiary">Last 7 days</h6>
                        </div>
                        <h4>16,247</h4>
                      </div>
                      <div class="d-flex justify-content-center px-4 py-6">
                        <div class="echart-total-orders" style="height: 85px; width: 115px; user-select: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); position: relative;" _echarts_instance_="ec_1715613235391"><div style="position: relative; width: 115px; height: 85px; padding: 0px; margin: 0px; border-width: 0px;"><canvas data-zr-dom-id="zr_0" width="115" height="85" style="position: absolute; left: 0px; top: 0px; width: 115px; height: 85px; user-select: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); padding: 0px; margin: 0px; border-width: 0px;"></canvas></div><div class=""></div></div>
                      </div>
                      <div class="mt-2">
                        <div class="d-flex align-items-center mb-2">
                          <div class="bullet-item bg-primary me-2"></div>
                          <h6 class="text-body fw-semibold flex-1 mb-0">Completed</h6>
                          <h6 class="text-body fw-semibold mb-0">52%</h6>
                        </div>
                        <div class="d-flex align-items-center">
                          <div class="bullet-item bg-primary-subtle me-2"></div>
                          <h6 class="text-body fw-semibold flex-1 mb-0">Pending payment</h6>
                          <h6 class="text-body fw-semibold mb-0">48%</h6>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-md-6">
                  <div class="card h-100">
                    <div class="card-body">
                      <div class="d-flex justify-content-between">
                        <div>
                          <h5 class="mb-1">New customers<span class="badge badge-phoenix badge-phoenix-warning rounded-pill fs-9 ms-2"> <span class="badge-label">+26.5%</span></span></h5>
                          <h6 class="text-body-tertiary">Last 7 days</h6>
                        </div>
                        <h4>356</h4>
                      </div>
                      <div class="pb-0 pt-4">
                        <div class="echarts-new-customers" style="height: 180px; width: 100%; user-select: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); position: relative;" _echarts_instance_="ec_1715613235386"><div style="position: relative; width: 381px; height: 180px; padding: 0px; margin: 0px; border-width: 0px;"><canvas data-zr-dom-id="zr_0" width="381" height="180" style="position: absolute; left: 0px; top: 0px; width: 381px; height: 180px; user-select: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); padding: 0px; margin: 0px; border-width: 0px;"></canvas></div><div class=""></div></div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-md-6">
                  <div class="card h-100">
                    <div class="card-body">
                      <div class="d-flex justify-content-between">
                        <div>
                          <h5 class="mb-2">Top coupons</h5>
                          <h6 class="text-body-tertiary">Last 7 days</h6>
                        </div>
                      </div>
                      <div class="pb-4 pt-3">
                        <div class="echart-top-coupons" style="height: 115px; width: 100%; user-select: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); position: relative;" _echarts_instance_="ec_1715613235387"><div style="position: relative; width: 381px; height: 115px; padding: 0px; margin: 0px; border-width: 0px; cursor: default;"><canvas data-zr-dom-id="zr_0" width="381" height="115" style="position: absolute; left: 0px; top: 0px; width: 381px; height: 115px; user-select: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); padding: 0px; margin: 0px; border-width: 0px;"></canvas></div><div class=""></div></div>
                      </div>
                      <div>
                        <div class="d-flex align-items-center mb-2">
                          <div class="bullet-item bg-primary me-2"></div>
                          <h6 class="text-body fw-semibold flex-1 mb-0">Percentage discount</h6>
                          <h6 class="text-body fw-semibold mb-0">72%</h6>
                        </div>
                        <div class="d-flex align-items-center mb-2">
                          <div class="bullet-item bg-primary-lighter me-2"></div>
                          <h6 class="text-body fw-semibold flex-1 mb-0">Fixed card discount</h6>
                          <h6 class="text-body fw-semibold mb-0">18%</h6>
                        </div>
                        <div class="d-flex align-items-center">
                          <div class="bullet-item bg-info-dark me-2"></div>
                          <h6 class="text-body fw-semibold flex-1 mb-0">Fixed product discount</h6>
                          <h6 class="text-body fw-semibold mb-0">10%</h6>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-md-6">
                  <div class="card h-100">
                    <div class="card-body d-flex flex-column">
                      <div class="d-flex justify-content-between">
                        <div>
                          <h5 class="mb-2">Paying vs non paying</h5>
                          <h6 class="text-body-tertiary">Last 7 days</h6>
                        </div>
                      </div>
                      <div class="d-flex justify-content-center pt-3 flex-1">
                        <div class="echarts-paying-customer-chart" style="height: 100%; width: 100%; user-select: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); position: relative;" _echarts_instance_="ec_1715613235390"><div style="position: relative; width: 381px; height: 144px; padding: 0px; margin: 0px; border-width: 0px;"><canvas data-zr-dom-id="zr_0" width="381" height="144" style="position: absolute; left: 0px; top: 0px; width: 381px; height: 144px; user-select: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); padding: 0px; margin: 0px; border-width: 0px;"></canvas></div><div class=""></div></div>
                      </div>
                      <div class="mt-3">
                        <div class="d-flex align-items-center mb-2">
                          <div class="bullet-item bg-primary me-2"></div>
                          <h6 class="text-body fw-semibold flex-1 mb-0">Paying customer</h6>
                          <h6 class="text-body fw-semibold mb-0">30%</h6>
                        </div>
                        <div class="d-flex align-items-center">
                          <div class="bullet-item bg-primary-subtle me-2"></div>
                          <h6 class="text-body fw-semibold flex-1 mb-0">Non-paying customer</h6>
                          <h6 class="text-body fw-semibold mb-0">70%</h6>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
            <div class="d-flex mb-5 " id="scrollspyStats">
                <div class="col">
                    <h3 class="mb-0 text-black position-relative fw-bold" style="margin-bottom: 10px !important">
                        <span class="bg-soft pe-2">
                            Sayın {{ $userLog->name }}, Emlak Sepette'ye Hoş Geldiniz.
                        </span><span
                            class="border border-primary-200 position-absolute top-50 translate-middle-y w-100 start-0 z-index--1"></span>
                    </h3>
                    {{-- <span class="mt-5">Emlak Sepette, ücretsiz, sınırsız ve süresiz ilan paylaşımı
                        imkanı sunarak ilanlarınızın satışına aracılık eder. Değerli kurumsal üyelerimizden aylık sabit
                        ücret talep
                        etmeyiz. İlanlarınızın daha hızlı satılmasına ve kiralanmasına aracılık ederiz.

                        Emlak ilanlarınızın, emlak sepette ile satılması durumunda %0.5 hizmet bedeli alınır.
                        .</span> --}}


                </div>
            </div>
        @else
            <div class="d-flex mb-5 " id="scrollspyStats">
                <div class="col">
                    <h3 class="mb-0 text-black position-relative fw-bold" style="margin-bottom: 10px !important">
                        <span class="bg-soft pe-2">
                            Sayın {{ $userLog->name }}, Emlak Sepette'ye Hoş Geldiniz.
                        </span><span
                            class="border border-primary-200 position-absolute top-50 translate-middle-y w-100 start-0 z-index--1"></span>
                    </h3>
                    <span class="mt-5">Emlak Sepette'ye üye olduğunuz için teşekkür ederiz. Sitemizde keyifli alışverişler
                        dileriz.</span>


                </div>
            </div>
        @endif


        {{-- @if (Auth::check() && Auth::user()->type != '3')
            <!-- HTML -->
            <button class="chatbox-open">
                <i class="fa fa-comment" aria-hidden="true"></i>
            </button>
            <button class="chatbox-close">
                <i class="fa fa-close" aria-hidden="true"></i>
            </button>
            <div class="chatbox-popup">
                <header class="chatbox-popup__header">
                    <aside style="flex:8">
                        <h4 style="color: white">Emlak Sepette Canlı Destek</h4>
                    </aside>
                </header>
                <main class="chatbox-popup__main">
                    <div class="chatbox-messages">
                        <div class="msg left-msg">

                            <div class="msg-bubble">

                                <div class="msg-text">
                                    Merhaba size nasıl yardımcı olabiliriz ?
                                </div>
                            </div>
                        </div>

                    </div>
                </main>
                <footer class="chatbox-popup__footer">
                    <aside style="flex:10">
                        <textarea id="userMessage" type="text" placeholder="Mesajınızı Yazınız..." autofocus
                            onkeydown="handleKeyPress(event)"></textarea>
                    </aside>
                    <aside style="flex:1;color:#888;text-align:center;">
                        <button onclick="sendMessage()" class="btn btn-primary"><i class="fa fa-paper-plane"
                                aria-hidden="true"></i></button>
                    </aside>
                </footer>
            </div>
        @endif --}}

        @if (Auth::check() && Auth::user()->has_club == 1)
            <div class="row">
                <div class="col-xl-5 col-xxl-4">
                    <div class="sticky-leads-sidebar">
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-12 col-sm-auto flex-1">

                                        <div class="d-md-flex d-xl-block align-items-center justify-content-between">
                                            <div class="d-flex align-items-center">
                                                <div class="avatar avatar-xl me-3"><img class="rounded-circle"
                                                        src="{{ asset('storage/profile_images/' . Auth::user()->profile_image) }}"
                                                        alt=""></div>
                                                <div>
                                                    <h5>{{ Auth::user()->name }}</h5>
                                                    <span style="display: flex"> <img style="height: 21px;"
                                                            class="lazy entered loading"
                                                            src="https://emlaksepette.com/yeniler_2.svg" alt="Yeniler"
                                                            data-ll-status="loading">Emlak Kulüp Üyesi</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="border-top border-bottom border-translucent" id="leadDetailsTable">
                                        <div class="table-responsive scrollbar mx-n1 px-1">
                                            <table class="table fs-9 mb-0">
                                                <thead>
                                                    <tr>
                                                        <th class="sort white-space-nowrap align-middle pe-3 ps-0 "
                                                            scope="col" data-sort="dealName"
                                                            style="width:15%; min-width:200px">
                                                            @if (Auth::user()->corporate_type == 'Emlak Ofisi')
                                                                Portföy Adı:
                                                            @else
                                                                Koleksiyon Adı:
                                                            @endif
                                                        </th>
                                                        <th class="sort align-middle pe-6  text-end" scope="col"
                                                            data-sort="amount" style="width:15%; min-width:100px">İlan
                                                            Sayısı</th>

                                                    </tr>
                                                </thead>
                                                <tbody class="list" id="lead-details-table-body">
                                                    @foreach ($collections as $item)
                                                        <tr
                                                            class="hover-actions-trigger btn-reveal-trigger position-static">

                                                            <td class="dealName align-middle white-space-nowrap py-2 ps-0">
                                                                <a class="fw-semibold text-primary"
                                                                    href="#!">{{ $item->name }}</a>
                                                            </td>
                                                            <td
                                                                class="amount align-middle white-space-nowrap text-start fw-bold text-body-tertiary py-2 text-end pe-6">
                                                                {{ count($item->links) }}</td>

                                                        </tr>
                                                    @endforeach

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-7 col-xxl-8">
                    <div class="card mb-5">
                        <div class="card-body">
                            <div class="row g-4 g-xl-1 g-xxl-3 justify-content-between">
                                <div class="col-sm-auto">
                                    <div
                                        class="d-sm-block d-inline-flex d-md-flex flex-xl-column flex-xxl-row align-items-center align-items-xl-start align-items-xxl-center ">
                                        <div class="d-flex bg-info-subtle rounded flex-center me-3 mb-sm-3 mb-md-0 mb-xl-3 mb-xxl-0"
                                            style="width:32px; height:32px"><svg xmlns="http://www.w3.org/2000/svg"
                                                width="16px" height="16px" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round" class="feather feather-code text-info-dark"
                                                style="width:24px; height:24px">
                                                <polyline points="16 18 22 12 16 6"></polyline>
                                                <polyline points="8 6 2 12 8 18"></polyline>
                                            </svg></div>
                                        <div>
                                            <p class="fw-bold mb-1" style="color:green">Toplam Kazanç</p>
                                            <h4 class="fw-bolder text-nowrap">
                                                {{ number_format($balanceStatus1, 2, ',', '.') }} ₺
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-auto">
                                    <div
                                        class="d-sm-block d-inline-flex d-md-flex flex-xl-column flex-xxl-row align-items-center align-items-xl-start align-items-xxl-center border-start-sm ps-sm-5 border-translucent">
                                        <div class="d-flex bg-success-subtle rounded flex-center me-3 mb-sm-3 mb-md-0 mb-xl-3 mb-xxl-0"
                                            style="width:32px; height:32px"><svg xmlns="http://www.w3.org/2000/svg"
                                                width="16px" height="16px" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round"
                                                class="feather feather-dollar-sign text-success-dark"
                                                style="width:24px; height:24px">
                                                <line x1="12" y1="1" x2="12" y2="23">
                                                </line>
                                                <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                                            </svg></div>
                                        <div>
                                            <p class="fw-bold mb-1" style="color:orange">Onaydaki Komisyon Tutarı</p>
                                            <h4 class="fw-bolder text-nowrap">
                                                {{ number_format($balanceStatus0, 2, ',', '.') }} ₺

                                            </h4>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-auto">
                                    <div
                                        class="d-sm-block d-inline-flex d-md-flex flex-xl-column flex-xxl-row align-items-center align-items-xl-start align-items-xxl-center border-start-sm ps-sm-5 border-translucent">
                                        <div class="d-flex bg-primary-subtle rounded flex-center me-3 mb-sm-3 mb-md-0 mb-xl-3 mb-xxl-0"
                                            style="width:32px; height:32px"><svg xmlns="http://www.w3.org/2000/svg"
                                                width="16px" height="16px" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round" class="feather feather-layout text-primary-dark"
                                                style="width:24px; height:24px">
                                                <rect x="3" y="3" width="18" height="18" rx="2"
                                                    ry="2"></rect>
                                                <line x1="3" y1="9" x2="21" y2="9">
                                                </line>
                                                <line x1="9" y1="21" x2="9" y2="9">
                                                </line>
                                            </svg></div>
                                        <div>
                                            <p class="fw-bold mb-1" style="color: red">Reddedilen Komisyon Tutarı</p>
                                            <h4 class="fw-bolder text-nowrap">
                                                {{ number_format($balanceStatus2, 2, ',', '.') }} ₺

                                            </h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="px-xl-4 mb-7">
                        <div class="row mx-0 mx-sm-3 mx-lg-0 px-lg-0">
                            <div class="col-sm-12 col-xxl-6 border-bottom border-end-xxl border-translucent py-3">
                                <table class="w-100 table-stats table-stats">
                                    <tbody>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                        <tr>
                                            <td class="py-2">
                                                <div class="d-inline-flex align-items-center">
                                                    <div class="d-flex bg-success-subtle rounded-circle flex-center me-3"
                                                        style="width:24px; height:24px"><svg
                                                            xmlns="http://www.w3.org/2000/svg" width="16px"
                                                            height="16px" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            class="feather feather-bar-chart-2 text-success-dark"
                                                            style="width:16px; height:16px">
                                                            <line x1="18" y1="20" x2="18"
                                                                y2="10"></line>
                                                            <line x1="12" y1="20" x2="12"
                                                                y2="4"></line>
                                                            <line x1="6" y1="20" x2="6"
                                                                y2="14"></line>
                                                        </svg></div>
                                                    <p class="fw-bold mb-0">Başarı Yüzdesi (%)</p>
                                                </div>
                                            </td>
                                            <td class="py-2 d-none d-sm-block pe-sm-2">:</td>
                                            <td class="py-2">
                                                <p class="ps-6 ps-sm-0 fw-semibold mb-0 mb-0 pb-3 pb-sm-0">
                                                    {{ $successPercentage }} %</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="py-2">
                                                <div class="d-flex align-items-center">
                                                    <div class="d-flex bg-info-subtle rounded-circle flex-center me-3"
                                                        style="width:24px; height:24px"><svg
                                                            xmlns="http://www.w3.org/2000/svg" width="16px"
                                                            height="16px" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            class="feather feather-trending-up text-info-dark"
                                                            style="width:16px; height:16px">
                                                            <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline>
                                                            <polyline points="17 6 23 6 23 12"></polyline>
                                                        </svg></div>
                                                    <p class="fw-bold mb-0">Toplam Kazanç</p>
                                                </div>
                                            </td>
                                            <td class="py-2 d-none d-sm-block pe-sm-2">:</td>
                                            <td class="py-2">
                                                <p class="ps-6 ps-sm-0 fw-semibold mb-0">
                                                    {{ number_format($balanceStatus1, 0, ',', '.') }} ₺</p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-sm-12 col-xxl-6 border-bottom border-translucent py-3">
                                <table class="w-100 table-stats">
                                    <tbody>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                        <tr>
                                            <td class="py-2">
                                                <div class="d-inline-flex align-items-center">
                                                    <div class="d-flex bg-primary-subtle rounded-circle flex-center me-3"
                                                        style="width:24px; height:24px"><svg
                                                            xmlns="http://www.w3.org/2000/svg" width="16px"
                                                            height="16px" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            class="feather feather-phone text-primary-dark"
                                                            style="width:16px; height:16px">
                                                            <path
                                                                d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z">
                                                            </path>
                                                        </svg></div>
                                                    <p class="fw-bold mb-0">Telefon</p>
                                                </div>
                                            </td>
                                            <td class="py-2 d-none d-sm-block pe-sm-2">:</td>
                                            <td class="py-2"><a
                                                    class="ps-6 ps-sm-0 fw-semibold mb-0 pb-3 pb-sm-0 text-body"
                                                    href="tel:{{ Auth::user()->phone }}">{{ Auth::user()->phone }}</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="py-2">
                                                <div class="d-flex align-items-center">
                                                    <div class="d-flex bg-warning-subtle rounded-circle flex-center me-3"
                                                        style="width:24px; height:24px"><svg
                                                            xmlns="http://www.w3.org/2000/svg" width="16px"
                                                            height="16px" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            class="feather feather-mail text-warning-dark"
                                                            style="width:16px; height:16px">
                                                            <path
                                                                d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z">
                                                            </path>
                                                            <polyline points="22,6 12,13 2,6"></polyline>
                                                        </svg></div>
                                                    <p class="fw-bold mb-0">Email</p>
                                                </div>
                                            </td>
                                            <td class="py-2 d-none d-sm-block pe-sm-2">:</td>
                                            <td class="py-2"><a class="ps-6 ps-sm-0 fw-semibold mb-0 text-body"
                                                    href="mailto:{{ Auth::user()->email }}">{{ Auth::user()->email }}</a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="row">
                <div class="col-12 col-xl-6 col-xxl-5">
                    <a href="{{ route('institutional.sharer.index') }}">
                        <div class="card border h-100 w-100 overflow-hidden">

                            <div class="card-body position-relative">
                                <img src="{{ asset('popup2.jpeg') }}" alt=""
                                    style="width:100%;height:100%;object-fit:cover">
                            </div>
                        </div>
                    </a>

                </div>
            </div>
        @endif



    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Sayfa yüklendiğinde mevcut sohbet geçmişini çekmek için bir AJAX çağrısı yapabilirsiniz
            fetchChatHistory();
        });

        function fetchChatHistory() {
            $.ajax({
                url: 'chat/history',
                method: 'GET',
                success: function(response) {

                    renderChatHistory(response);
                },
                error: function(error) {
                    console.error('Sohbet geçmişi alınamadı:', error);
                }
            });

        }

        function renderChatHistory(chatHistory) {
            const chatboxMessages = document.querySelector('.chatbox-messages');

            chatHistory.forEach(entry => {
                const messageElement = document.createElement('div');
                const messageType = entry.receiver_id == 4 ? 'user' : 'admin';

                messageElement.className = messageType == 'admin' ? 'msg left-msg' : 'msg right-msg';
                messageElement.innerHTML = `
            <div class="msg-bubble">
                <div class="msg-text">
                    ${entry.content}
                </div>
            </div>
        `;
                chatboxMessages.appendChild(messageElement);
            });
        }


        var isFirstMessage = true;

        function sendMessage() {
            var userMessage = document.getElementById('userMessage').value;
            var chatboxMessages = document.querySelector('.chatbox-messages');

            // Kullanıcının mesajını ekle
            var userMessageElement = document.createElement('div');
            userMessageElement.className = 'msg right-msg';
            userMessageElement.innerHTML = `
            <div class="msg-bubble">
                <div class="msg-text">
                    ${userMessage}
                </div>
            </div>
        `;
            chatboxMessages.appendChild(userMessageElement);

            $.ajax({
                type: 'POST',
                url: "{{ route('messages.store') }}",
                data: {
                    '_token': '{{ csrf_token() }}',
                    'content': userMessage,
                },
                success: function(response) {
                    // Başarıyla mesaj gönderildiğinde yapılacak işlemler
                    console.log(response.message);
                    chatboxMessages.scrollTop = chatboxMessages.scrollHeight;
                },
                error: function(error) {
                    toastr.error('Bir hata oluştu. Lütfen tekrar deneyin.');

                }
            });


            // Kullanıcının girdiği mesaj alanını temizle
            document.getElementById('userMessage').value = '';
        }

        function handleKeyPress(event) {
            if (event.key === 'Enter' && !event.shiftKey) {
                event.preventDefault();
                sendMessage();
            }
        }

        $(".chatbox-open").click(() => {
            $(".chatbox-popup, .chatbox-close").fadeIn();
        });

        $(".chatbox-close").click(() => {
            $(".chatbox-popup, .chatbox-close").fadeOut();
        });

        $(".chatbox-maximize").click(() => {
            $(".chatbox-popup, .chatbox-open, .chatbox-close").fadeOut();
            $(".chatbox-panel").fadeIn();
            $(".chatbox-panel").css({
                display: "flex"
            });
        });

        $(".chatbox-minimize").click(() => {
            $(".chatbox-panel").fadeOut();
            $(".chatbox-popup, .chatbox-open, .chatbox-close").fadeIn();
        });

        $(".chatbox-panel-close").click(() => {
            $(".chatbox-panel").fadeOut();
            $(".chatbox-open").fadeIn();
        });

        var dom = document.getElementById('stat-1');
        var myChart = echarts.init(dom, null, {
            renderer: 'canvas',
            useDirtyRect: false
        });
        var app = {};

        var option;

        option = {
            xAxis: {
                type: 'category',
                data: @json(
                    (function () {
                        $array = [];
                        for ($i = 1; $i <= date('m'); ++$i) {
                            $array[] = strftime('%B', strtotime(date("Y-{$i}-01 00:00:00")));
                        }
                
                        return $array;
                    })()),
            },
            yAxis: {
                type: 'value'
            },
            series: [{
                data: @json($stats1_data),
                type: 'bar',
                showBackground: true,
                backgroundStyle: {
                    color: 'rgba(180, 180, 180, 0.2)'
                }
            }]
        };


        if (option && typeof option === 'object') {
            myChart.setOption(option);
        }

        window.addEventListener('resize', myChart.resize);
    </script>
    <script>
        var dom = document.getElementById('stat-2');
        var myChart = echarts.init(dom, null, {
            renderer: 'canvas',
            useDirtyRect: false
        });
        var app = {};

        var option;

        option = {
            xAxis: {
                type: 'category',
                data: @json(
                    (function () {
                        $array = [];
                        for ($i = 1; $i <= date('m'); ++$i) {
                            $array[] = strftime('%B', strtotime(date("Y-{$i}-01 00:00:00")));
                        }
                
                        return $array;
                    })()),
            },
            yAxis: {
                type: 'value'
            },
            series: [{
                data: @json($stats2_data),
                type: 'bar',
                showBackground: true,
                backgroundStyle: {
                    color: 'rgba(180, 180, 180, 0.2)'
                }
            }]
        };


        if (option && typeof option === 'object') {
            myChart.setOption(option);
        }

        window.addEventListener('resize', myChart.resize);
    </script>
@endsection

@section('css')
@endsection
