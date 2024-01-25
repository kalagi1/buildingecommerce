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
        @endif

        @if (Auth::check() && Auth::user()->type == '2')
            <div class="d-flex mb-5 " id="scrollspyStats">
                <div class="col">
                    <h3 class="mb-0 text-primary position-relative fw-bold" style="margin-bottom: 10px !important">
                        <span class="bg-soft pe-2">
                            Sayın {{ $userLog->name }}, Emlak Sepette'ye Hoş Geldiniz.
                        </span><span
                            class="border border-primary-200 position-absolute top-50 translate-middle-y w-100 start-0 z-index--1"></span>
                    </h3>
                    <span style="color:black" class="mt-5">Emlak Sepette, ücretsiz, sınırsız ve süresiz ilan paylaşımı
                        imkanı sunarak ilanlarınızın satışına aracılık eder. Değerli kurumsal üyelerimizden aylık sabit
                        ücret talep
                        etmeyiz. İlanlarınızın daha hızlı satılmasına ve kiralanmasına aracılık ederiz.

                        Emlak ilanlarınızın, emlak sepette ile satılması durumunda %0.5 hizmet bedeli alınır.
                        .</span>


                </div>
            </div>
            @else
            <div class="d-flex mb-5 " id="scrollspyStats">
                <div class="col">
                    <h3 class="mb-0 text-primary position-relative fw-bold" style="margin-bottom: 10px !important">
                        <span class="bg-soft pe-2">
                            Sayın {{ $userLog->name }}, Emlak Sepette'ye Hoş Geldiniz.
                        </span><span
                            class="border border-primary-200 position-absolute top-50 translate-middle-y w-100 start-0 z-index--1"></span>
                    </h3>
                    <span style="color:black" class="mt-5">Emlak Sepette'ye üye olduğunuz için teşekkür ederiz. Sitemizde keyifli alışverişler dileriz.</span>


                </div>
            </div>
        @endif


        @if (Auth::check() && Auth::user()->type != '3')
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
        @endif

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
                                                            style="width:15%; min-width:200px">Koleksiyon Adı</th>
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
                                                {{ $balanceStatus1 }} ₺
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
                                                {{ $balanceStatus0 }} ₺
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
                                                {{ $balanceStatus2 }} ₺
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
