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
        @if ($userLog->type != 21)
            <div class="d-flex mb-5 " id="scrollspyStats">
                <div class="col">
                    <h3 class="mb-0 text-primary position-relative fw-bold"
                    style="margin-bottom: 10px !important">
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
            <h2 class="mb-2 text-body-emphasis">EMLAK KULÜP</h2>
        @endif
        {{-- @if ($userLog->type != 21)
            <div class="row">
                <div class="col-md-6">
                    <div class="bg-white p-3 border rounded-md">
                        <strong>Firmanızın Konut İstatistiği</strong>
                        <div id="stat-1" style="height: 350px;"></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="bg-white p-3 border rounded-md">
                        <strong>Firmanızın Proje İstatistiği</strong>
                        <div id="stat-2" style="height: 350px;"></div>
                    </div>
                </div>
            </div>
        @endif --}}

    </div>

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
