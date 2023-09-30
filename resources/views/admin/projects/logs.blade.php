@extends('admin.layouts.master')

@section('content')
<div class="content">
    <nav class="mb-2 breadcrumb-sticky-top" aria-label="breadcrumb">
      <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="#!">Pages</a></li>
        <li class="breadcrumb-item active">Timeline</li>
      </ol>
    </nav>
    <h2 class="text-bold mb-5 page-title-sticky-top">Timeline</h2>
    <div class="row gx-xl-8 gx-xxl-11">
      <div class="col-xl-5 p-xxl-7">
        <div class="ms-xxl-3 d-none d-xl-block position-sticky" style="top: 30%"><img class="d-dark-none img-fluid" src="../assets/img/spot-illustrations/timeline.png" alt="" /><img class="d-light-none img-fluid" src="../assets/img/spot-illustrations/timeline-dark.png" alt="" /></div>
      </div>
      <div class="col-xl-7 scrollbar">
        <div>
          <h4 class="py-3 border-y border-300 mb-5 ms-8">Today</h4>
          <div class="timeline-basic mb-9">
            <div class="timeline-item">
              <div class="row g-3">
                <div class="col-auto">
                  <div class="timeline-item-bar position-relative">
                    <div class="icon-item icon-item-md rounded-7 border"><span class="fa-solid fa-clipboard text-success fs--1"></span></div><span class="timeline-bar border-end border-dashed border-300"></span>
                  </div>
                </div>
                <div class="col">
                  <div class="d-flex justify-content-between">
                    <div class="d-flex mb-2">
                      <h6 class="lh-sm mb-0 me-2 text-800 timeline-item-title">Assigned to serve as the <br class='d-sm-none'> project's director</h6>
                    </div>
                    <p class="text-500 fs--1 mb-0 text-nowrap timeline-time"><span class="fa-regular fa-clock me-1"></span>4:33pm</p>
                  </div>
                  <h6 class="fs--2 fw-normal mb-3">by <a class="fw-semi-bold" href="#!">John N. Ward</a></h6>
                  <p class="fs--1 text-800 w-sm-60 mb-5">Utilizing best practices to better leverage our assets, we must engage in black sky leadership thinking, not the usual band-aid solution.</p>
                </div>
              </div>
            </div>
            <div class="timeline-item">
              <div class="row g-3">
                <div class="col-auto">
                  <div class="timeline-item-bar position-relative">
                    <div class="icon-item icon-item-md rounded-7 border"><span class="fa-solid fa-envelope text-danger fs--1"></span></div><span class="timeline-bar border-end border-dashed border-300"></span>
                  </div>
                </div>
                <div class="col">
                  <div class="d-flex justify-content-between">
                    <div class="d-flex mb-2">
                      <h6 class="lh-sm mb-0 me-2 text-800 timeline-item-title">Quary about purchased <br class="d-sm-none"> soccer socks</h6>
                    </div>
                    <p class="text-500 fs--1 mb-0 text-nowrap timeline-time"><span class="fa-regular fa-clock me-1"></span>6:30pm</p>
                  </div>
                  <h6 class="fs--2 fw-normal mb-3">by <a class="fw-semi-bold" href="#!">Edward Hopper</a></h6>
                  <p class="fs--1 text-800 w-sm-60 mb-5">I’ve come across your posts and found some favorable deals on your page. I’ve added a load of products to the cart and I don’t know the payment options you avail. Also, can you enlighten me about any discount.</p>
                </div>
              </div>
            </div>
            <div class="timeline-item">
              <div class="row g-3">
                <div class="col-auto">
                  <div class="timeline-item-bar position-relative">
                    <div class="icon-item icon-item-md rounded-7 border"><span class="fa-solid fa-video text-info fs--1"></span></div>
                  </div>
                </div>
                <div class="col">
                  <div class="d-flex justify-content-between">
                    <div class="d-flex mb-2">
                      <h6 class="lh-sm mb-0 me-2 text-800 timeline-item-title">Onboarding Meeting</h6>
                    </div>
                    <p class="text-500 fs--1 mb-0 text-nowrap timeline-time"><span class="fa-regular fa-clock me-1"></span>9:33pm</p>
                  </div>
                  <h6 class="fs--2 fw-normal false">by <a class="fw-semi-bold" href="#!">John N. Ward</a></h6>
                  <p class="fs--1 text-800 w-sm-60 mb-0"></p>
                </div>
              </div>
            </div>
          </div>
          <h4 class="py-3 border-y border-300 mb-5 ms-8">15 October, 2022</h4>
          <div class="timeline-basic mb-9">
            <div class="timeline-item">
              <div class="row g-3">
                <div class="col-auto">
                  <div class="timeline-item-bar position-relative">
                    <div class="icon-item icon-item-md rounded-7 border"><span class="fa-solid fa-swatchbook text-primary fs--1"></span></div><span class="timeline-bar border-end border-dashed border-300"></span>
                  </div>
                </div>
                <div class="col">
                  <div class="d-flex justify-content-between">
                    <div class="d-flex mb-2">
                      <h6 class="lh-sm mb-0 me-2 text-800 timeline-item-title">Designing the dungeon</h6>
                    </div>
                    <p class="text-500 fs--1 mb-0 text-nowrap timeline-time"><span class="fa-regular fa-clock me-1"></span>1:30pm</p>
                  </div>
                  <h6 class="fs--2 fw-normal mb-3">by <a class="fw-semi-bold" href="#!">John N. Ward</a></h6>
                  <p class="fs--1 text-800 w-sm-60 mb-5">To get off the runway and paradigm shift, we should take brass tacks with above-the-board actionable analytics, ramp up with viral partnering, not the usual goat rodeo putting socks on an octopus. </p>
                </div>
              </div>
            </div>
            <div class="timeline-item">
              <div class="row g-3">
                <div class="col-auto">
                  <div class="timeline-item-bar position-relative">
                    <div class="icon-item icon-item-md rounded-7 border"><span class="fa-solid fa-skull-crossbones text-danger fs--1"></span></div><span class="timeline-bar border-end border-dashed border-300"></span>
                  </div>
                </div>
                <div class="col">
                  <div class="d-flex justify-content-between">
                    <div class="d-flex mb-2">
                      <h6 class="lh-sm mb-0 me-2 text-800 timeline-item-title">How to take the headache <br class="d-sm-none"> out of Order</h6>
                    </div>
                    <p class="text-500 fs--1 mb-0 text-nowrap timeline-time"><span class="fa-regular fa-clock me-1"></span>8:32pm</p>
                  </div>
                  <h6 class="fs--2 fw-normal mb-3">by <a class="fw-semi-bold" href="#!">Edward Hopper</a></h6>
                  <p class="fs--1 text-800 w-sm-60 mb-5">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters.</p>
                </div>
              </div>
            </div>
            <div class="timeline-item">
              <div class="row g-3">
                <div class="col-auto">
                  <div class="timeline-item-bar position-relative">
                    <div class="icon-item icon-item-md rounded-7 border"><span class="fa-solid fa-stethoscope text-primary fs--1"></span></div><span class="timeline-bar border-end border-dashed border-300"></span>
                  </div>
                </div>
                <div class="col">
                  <div class="d-flex justify-content-between">
                    <div class="d-flex mb-2">
                      <h6 class="lh-sm mb-0 me-2 text-800 timeline-item-title">Mandatory routine checkup</h6>
                    </div>
                    <p class="text-500 fs--1 mb-0 text-nowrap timeline-time"><span class="fa-regular fa-clock me-1"></span>9:30pm</p>
                  </div>
                  <h6 class="fs--2 fw-normal mb-3">by <a class="fw-semi-bold" href="#!">Eye before Thy Hospital</a></h6>
                  <p class="fs--1 text-800 w-sm-60 mb-5">To get the bitter butter out and take the better butter into the bitter dough to make a bitter bread and broad donut, not the usual yellow butter, but the white butterless butter.</p>
                </div>
              </div>
            </div>
            <div class="timeline-item">
              <div class="row g-3">
                <div class="col-auto">
                  <div class="timeline-item-bar position-relative">
                    <div class="icon-item icon-item-md rounded-7 border"><span class="fa-solid fa-utensils text-success fs--1"></span></div><span class="timeline-bar border-end border-dashed border-300"></span>
                  </div>
                </div>
                <div class="col">
                  <div class="d-flex justify-content-between">
                    <div class="d-flex mb-2">
                      <h6 class="lh-sm mb-0 me-2 text-800 timeline-item-title">Making bad butter better</h6>
                    </div>
                    <p class="text-500 fs--1 mb-0 text-nowrap timeline-time"><span class="fa-regular fa-clock me-1"></span>8:30pm</p>
                  </div>
                  <h6 class="fs--2 fw-normal mb-3">by <a class="fw-semi-bold" href="#!">Edward Hopper</a></h6>
                  <p class="fs--1 text-800 w-sm-60 mb-5">Check how long a fish might live out of water and if you can check the pulse to see if it's alive or not though it's okay to eat fish cause they don't have any feelings.</p>
                </div>
              </div>
            </div>
            <div class="timeline-item">
              <div class="row g-3">
                <div class="col-auto">
                  <div class="timeline-item-bar position-relative">
                    <div class="icon-item icon-item-md rounded-7 border"><span class="fa-solid fa-rocket text-info fs--1"></span></div>
                  </div>
                </div>
                <div class="col">
                  <div class="d-flex justify-content-between">
                    <div class="d-flex mb-2">
                      <h6 class="lh-sm mb-0 me-2 text-800 timeline-item-title">Launching Phoenix</h6>
                    </div>
                    <p class="text-500 fs--1 mb-0 text-nowrap timeline-time"><span class="fa-regular fa-clock me-1"></span>10:33pm</p>
                  </div>
                  <h6 class="fs--2 fw-normal false">by <a class="fw-semi-bold" href="#!">John N. Ward</a></h6>
                  <p class="fs--1 text-800 w-sm-60 mb-0"></p>
                </div>
              </div>
            </div>
          </div>
          <h4 class="py-3 border-y border-300 mb-5 ms-8">20 October, 2022</h4>
          <div class="timeline-basic mb-9">
            <div class="timeline-item">
              <div class="row g-3">
                <div class="col-auto">
                  <div class="timeline-item-bar position-relative">
                    <div class="icon-item icon-item-md rounded-7 border"><span class="fa-solid fa-screwdriver-wrench text-warning fs--1"></span></div><span class="timeline-bar border-end border-dashed border-300"></span>
                  </div>
                </div>
                <div class="col">
                  <div class="d-flex justify-content-between">
                    <div class="d-flex mb-2">
                      <h6 class="lh-sm mb-0 me-2 text-800 timeline-item-title">To take the ants out</h6>
                    </div>
                    <p class="text-500 fs--1 mb-0 text-nowrap timeline-time"><span class="fa-regular fa-clock me-1"></span>8:32pm</p>
                  </div>
                  <h6 class="fs--2 fw-normal mb-3">by <a class="fw-semi-bold" href="#!">Edward Hopper</a></h6>
                  <p class="fs--1 text-800 w-sm-60 mb-5">Many ants are crawling into my PC and now they live in there to get highly skilled in web development and programming language that will make them earn better than the humans so that they’ll be able to buy off all the sugar out of the market.</p>
                </div>
              </div>
            </div>
            <div class="timeline-item">
              <div class="row g-3">
                <div class="col-auto">
                  <div class="timeline-item-bar position-relative">
                    <div class="icon-item icon-item-md rounded-7 border"><span class="fa-solid fa-paperclip text-info fs--1"></span></div>
                  </div>
                </div>
                <div class="col">
                  <div class="d-flex justify-content-between">
                    <div class="d-flex mb-2">
                      <h6 class="lh-sm mb-0 me-2 text-800 timeline-item-title">Added file</h6>
                      <h6 class="mb-0 fs--1"><span class="fa-solid fa-file-pdf me-1 text-700"></span><a href="#!">Readme.pdf</a></h6>
                    </div>
                    <p class="text-500 fs--1 mb-0 text-nowrap timeline-time"><span class="fa-regular fa-clock me-1"></span>10:33pm</p>
                  </div>
                  <h6 class="fs--2 fw-normal false">by <a class="fw-semi-bold" href="#!">John N. Ward</a></h6>
                  <p class="fs--1 text-800 w-sm-60 mb-0"></p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <footer class="footer position-absolute">
      <div class="row g-0 justify-content-between align-items-center h-100">
        <div class="col-12 col-sm-auto text-center">
          <p class="mb-0 mt-2 mt-sm-0 text-900">Thank you for creating with Phoenix<span class="d-none d-sm-inline-block"></span><span class="d-none d-sm-inline-block mx-1">|</span><br class="d-sm-none" />2023 &copy;<a class="mx-1" href="https://themewagon.com/">Themewagon</a></p>
        </div>
        <div class="col-12 col-sm-auto text-center">
          <p class="mb-0 text-600">v1.13.0</p>
        </div>
      </div>
    </footer>
  </div>
@endsection

@section('scripts')
    
@endsection
