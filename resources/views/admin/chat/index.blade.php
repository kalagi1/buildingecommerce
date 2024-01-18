@extends('admin.layouts.master')

@section('content')
    <div class="content">
        <div class="chat d-flex phoenix-offcanvas-container pt-1 mt-n1 mb-9">
            <div class="card p-3 p-xl-1 mt-xl-n1 chat-sidebar me-3 phoenix-offcanvas phoenix-offcanvas-start"
                id="chat-sidebar"><button class="btn d-none d-sm-block d-xl-none mb-2" data-bs-toggle="modal"
                    data-bs-target="#chatSearchBoxModal"><svg class="svg-inline--fa fa-magnifying-glass text-600 fs-1"
                        aria-hidden="true" focusable="false" data-prefix="fas" data-icon="magnifying-glass" role="img"
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                        <path fill="currentColor"
                            d="M500.3 443.7l-119.7-119.7c27.22-40.41 40.65-90.9 33.46-144.7C401.8 87.79 326.8 13.32 235.2 1.723C99.01-15.51-15.51 99.01 1.724 235.2c11.6 91.64 86.08 166.7 177.6 178.9c53.8 7.189 104.3-6.236 144.7-33.46l119.7 119.7c15.62 15.62 40.95 15.62 56.57 0C515.9 484.7 515.9 459.3 500.3 443.7zM79.1 208c0-70.58 57.42-128 128-128s128 57.42 128 128c0 70.58-57.42 128-128 128S79.1 278.6 79.1 208z">
                        </path>
                    </svg></button>

                <div class="form-icon-container mb-4 d-sm-none d-xl-block">
                    <input class="form-control form-icon-input userSearchInput" type="text" 
                        placeholder="Kullanıcı Ara">
                    <svg class="svg-inline--fa fa-user text-900 fs--1 form-icon" aria-hidden="true" focusable="false"
                        data-prefix="fas" data-icon="user" role="img" xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 448 512" data-fa-i2svg="">
                        <path fill="currentColor"
                            d="M224 256c70.7 0 128-57.31 128-128s-57.3-128-128-128C153.3 0 96 57.31 96 128S153.3 256 224 256zM274.7 304H173.3C77.61 304 0 381.6 0 477.3c0 19.14 15.52 34.67 34.66 34.67h378.7C432.5 512 448 496.5 448 477.3C448 381.6 370.4 304 274.7 304z">
                        </path>
                    </svg>
                </div>
                <ul class="nav nav-phoenix-pills mb-5 d-sm-none d-xl-flex" id="contactListTab"
                    data-chat-thread-tab="data-chat-thread-tab" role="tablist">
                    <li class="nav-item" role="presentation"><a class="nav-link cursor-pointer active" data-bs-toggle="tab"
                            data-chat-thread-list="all" role="tab" aria-selected="false" tabindex="-1">Hepsi</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link cursor-pointer  " data-bs-toggle="tab"
                            role="tab" data-chat-thread-list="read" aria-selected="true">Güncel</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link cursor-pointer" data-bs-toggle="tab"
                            role="tab" data-chat-thread-list="unread" aria-selected="false" tabindex="-1">Pasif</a>
                    </li>
                </ul>

                <div class="scrollbar">
                    <div class="tab-content" id="contactListTabContent">
                        <div data-chat-thread-tab-content="data-chat-thread-tab-content">
                            <ul class="nav chat-thread-tab flex-column list" role="tablist">

                                @foreach ($chats as $key => $chat)
                                    @php
                                        $unreadClass = count($chat->messages) > 0 ? 'read' : 'unread';
                                    @endphp
                                    <li class="nav-item {{ $unreadClass }}" role="presentation"><a
                                            class="nav-link d-flex align-items-center justify-content-center p-2  @if ($key == 0) active show @endif "
                                            data-bs-toggle="tab" data-chat-thread="data-chat-thread"
                                            href="#tab-thread-{{ $key }}" role="tab" aria-selected="true">
                                            <div
                                                class="avatar avatar-xl status-online position-relative me-2 me-sm-0 me-xl-2">
                                                <img class="rounded-circle border border-2 border-white"
                                                src="{{ asset('storage/profile_images/' . ($chat->user->profile_image ?? 'default.jpg')) }}"
                                                    alt="">
                                            </div>
                                            <div class="flex-1 d-sm-none d-xl-block">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <h5 class="text-900 fw-normal name text-nowrap">{{ $chat->user->name }}
                                                    </h5>
                                                    <p class="fs--2 text-600 mb-0 text-nowrap">Just now</p>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <p class="fs--1 mb-0 line-clamp-1 text-600 message">Emlak Sepette Canlı
                                                        Destek</p>
                                                </div>
                                            </div>
                                        </a></li>
                                @endforeach


                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="chat-content tab-content flex-1">
                @foreach ($chats as $key => $chat)
                    <div class="tab-pane h-100 fade @if ($key == 0) active show @endif "
                        id="tab-thread-{{ $key }}" role="tabpanel" aria-labelledby="tab-thread-1">
                        <div class="card flex-1 h-100 phoenix-offcanvas-container">
                            <div class="card-header p-3 p-md-4 d-flex flex-between-center">
                                <div class="d-flex align-items-center"><button class="btn ps-0 pe-2 text-700 d-sm-none"
                                        data-phoenix-toggle="offcanvas" data-phoenix-target="#chat-sidebar"><svg
                                            class="svg-inline--fa fa-chevron-left" aria-hidden="true" focusable="false"
                                            data-prefix="fas" data-icon="chevron-left" role="img"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg="">
                                            <path fill="currentColor"
                                                d="M224 480c-8.188 0-16.38-3.125-22.62-9.375l-192-192c-12.5-12.5-12.5-32.75 0-45.25l192-192c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25L77.25 256l169.4 169.4c12.5 12.5 12.5 32.75 0 45.25C240.4 476.9 232.2 480 224 480z">
                                            </path>
                                        </svg><!-- <span class="fa-solid fa-chevron-left"></span> Font Awesome fontawesome.com --></button>
                                    <div class="d-flex flex-column flex-md-row align-items-md-center"><button
                                            class="btn fs-1 fw-semi-bold text-1100 d-flex align-items-center p-0 me-3 text-start"
                                            data-phoenix-toggle="offcanvas" data-phoenix-target="#thread-details-0"><span
                                                class="line-clamp-1">{{ $chat->user->name }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-3 p-sm-4 scrollbar">
                                @foreach ($chat->messages as $message)
                                    <div class="d-flex chat-message">
                                        @if ($message->sender_id == Auth::id())
                                            <div class="d-flex mb-2 justify-content-end flex-1">
                                                <div class="w-100 w-xxl-75">
                                                    <div class="d-flex flex-end-center hover-actions-trigger">
                                                        <div class="chat-message-content me-2">
                                                            <div
                                                                class="mb-1 sent-message-content light bg-primary rounded-2 p-3 text-white">
                                                                <p class="mb-0">{{ $message->content }}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="text-end">
                                                        <p class="mb-0 fs--2 text-600 fw-semi-bold">
                                                            {{ $message->created_at->diffForHumans() }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <div class="d-flex mb-2 flex-1">
                                                <div class="w-100 w-xxl-75">
                                                    <div class="d-flex hover-actions-trigger">
                                                        <div class="avatar avatar-m me-3 flex-shrink-0">
                                                            <img class="rounded-circle"
                                                            src="{{ asset('storage/profile_images/' . ($chat->user->profile_image ?? 'default.jpg')) }}"
                                                                alt="">
                                                        </div>
                                                        <div class="chat-message-content received me-2">
                                                            <div
                                                                class="mb-1 received-message-content border rounded-2 p-3">
                                                                <p class="mb-0">{{ $message->content }}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <p class="mb-0 fs--2 text-600 fw-semi-bold ms-7">
                                                        {{ $message->created_at->diffForHumans() }}</p>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                            <div class="card-footer">
                                <div class="d-flex justify-content-between align-items-end">
                                    <textarea class="chat-textarea outline-none scrollbar mb-1" id="userMessage-{{ $key }}"
                                        contenteditable="true" autofocus placeholder="Mesajınızı Yazın ..."></textarea>
                                    <div>
                                        <button class="btn btn-primary fs--2 userButton" type="button"
                                            data-user-id="{{ $chat->user->id }}" data-key={{ $key }}>Gönder
                                            <svg class="svg-inline--fa fa-paper-plane ms-1" aria-hidden="true"
                                                focusable="false" data-prefix="fas" data-icon="paper-plane"
                                                role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                                                data-fa-i2svg="">
                                                <path fill="currentColor"
                                                    d="M511.6 36.86l-64 415.1c-1.5 9.734-7.375 18.22-15.97 23.05c-4.844 2.719-10.27 4.097-15.68 4.097c-4.188 0-8.319-.8154-12.29-2.472l-122.6-51.1l-50.86 76.29C226.3 508.5 219.8 512 212.8 512C201.3 512 192 502.7 192 491.2v-96.18c0-7.115 2.372-14.03 6.742-19.64L416 96l-293.7 264.3L19.69 317.5C8.438 312.8 .8125 302.2 .0625 289.1s5.469-23.72 16.06-29.77l448-255.1c10.69-6.109 23.88-5.547 34 1.406S513.5 24.72 511.6 36.86z">
                                                </path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="phoenix-offcanvas-backdrop d-lg-none" data-phoenix-backdrop="data-phoenix-backdrop"
                style="top: 0;"></div>
            <div class="modal fade" id="chatSearchBoxModal" tabindex="-1" data-bs-backdrop="true"
                data-phoenix-modal="data-phoenix-modal" style="--phoenix-backdrop-opacity: 1; display: none;"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content mt-15">
                        <div class="modal-body p-0">
                            <div class="chat-search-box">
                                <div class="form-icon-container">
                                    <input class="form-control py-3 form-icon-input rounded-1 userSearchInput" type="text" 
                                        placeholder="Kullanıcı Ara"><svg
                                        class="svg-inline--fa fa-magnifying-glass fs--1 form-icon" aria-hidden="true"
                                        focusable="false" data-prefix="fas" data-icon="magnifying-glass" role="img"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                        <path fill="currentColor"
                                            d="M500.3 443.7l-119.7-119.7c27.22-40.41 40.65-90.9 33.46-144.7C401.8 87.79 326.8 13.32 235.2 1.723C99.01-15.51-15.51 99.01 1.724 235.2c11.6 91.64 86.08 166.7 177.6 178.9c53.8 7.189 104.3-6.236 144.7-33.46l119.7 119.7c15.62 15.62 40.95 15.62 56.57 0C515.9 484.7 515.9 459.3 500.3 443.7zM79.1 208c0-70.58 57.42-128 128-128s128 57.42 128 128c0 70.58-57.42 128-128 128S79.1 278.6 79.1 208z">
                                        </path>
                                    </svg><!-- <span class="fa-solid fa-magnifying-glass fs--1 form-icon"></span> Font Awesome fontawesome.com -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"
        integrity="sha256-oP6HI/t1glT3lL3MRXPee5tPC2T5tiRzMBfO/z7l5Fw=" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"
        integrity="sha256-oP6HI/t1glT3lL3MRXPee5tPC2T5tiRzMBfO/z7l5Fw=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.userSearchInput').on('input', function() {
                var searchText = $(this).val().toLowerCase();
                console.log(searchText);
                $('.chat-thread-tab .nav-item').each(function() {
                    var userName = $(this).find('.name').text().toLowerCase();
                    if (userName.includes(searchText)) {
                        console.log(userName);
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });
        });
        $(document).ready(function() {
            var chatboxMessages = $('.phoenix-offcanvas-container .card-body');
            chatboxMessages.scrollTop(chatboxMessages.prop('scrollHeight'));

            $('.userButton').on('click', function() {
                var receiverId = $(this).data("user-id");
                var threadIndex = $(this).data("key");
                var lastMessage = $(`#tab-thread-${threadIndex} .card-body .chat-message`);
                var chatboxMessages = $(`#tab-thread-${threadIndex} .card-body`);

                var userMessage = $(`#tab-thread-${threadIndex} .chat-textarea`).val();

                var message = `
                    <div class="d-flex chat-message">
                        <div class="d-flex mb-2 justify-content-end flex-1">
                            <div class="w-100 w-xxl-75">
                                <div class="d-flex flex-end-center hover-actions-trigger">
                                    <div class="chat-message-content me-2">
                                        <div class="mb-1 sent-message-content light bg-primary rounded-2 p-3 text-white">
                                            <p class="mb-0"> ${userMessage}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <p class="mb-0 fs--2 text-600 fw-semi-bold">
                                        18 saat önce</p>
                                </div>
                            </div>
                        </div>
                    </div>
                `;

                chatboxMessages.append(message);

                if (userMessage !== '') {
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('admin.messages.store') }}",
                        data: {
                            '_token': '{{ csrf_token() }}',
                            'content': userMessage,
                            'receiver_id': receiverId,
                        },
                        success: function(response) {
                            $(`#tab-thread-${threadIndex} .chat-textarea`).val('');

                            // Ekranı en altına kaydır
                            var chatboxMessages = $(`#tab-thread-${threadIndex} .card-body`);
                            chatboxMessages.scrollTop(chatboxMessages.prop('scrollHeight'));

                        },
                        error: function(error) {
                            // Hata durumunda yapılacak işlemler
                            console.log('Hata:', error);

                            // Hata durumunda kullanıcıya bilgi vermek istiyorsanız, 
                            // örneğin toastr kullanabilirsiniz.
                            toastr.error('Mesaj gönderilirken bir hata oluştu.');
                        }
                    });
                } else {
                    // Kullanıcı boş bir mesaj göndermeye çalıştığında yapılacak işlemler
                    // Örneğin toastr kullanabilirsiniz.
                    toastr.warning('Boş bir mesaj gönderemezsiniz.');
                }
            });

            function handleKeyPress(receiverId, threadIndex) {
                sendMessage(receiverId, threadIndex);
            }
        });
    </script>
@endsection
