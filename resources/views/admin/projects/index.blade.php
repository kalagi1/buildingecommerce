@extends('admin.layouts.master')

@section('content')
    <div class="content">
        <h3 class="mb-2 lh-sm">Proje İlanları</h3>

        <div class="card shadow-none border border-300 my-4">
            <ul class="nav nav-tabs px-4 mt-3 mb-3" id="projectTabs">
                <li class="nav-item" role="presentation">
                    <button class="nav-link @if (!session()->has('success')) active @endif" id="pendingProjects-tab"
                        data-bs-toggle="tab" data-bs-target="#pendingProjects" type="button" role="tab"
                        aria-controls="pendingProjects" aria-selected="false">Onay Bekleyen İlanlar</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link @if (session()->has('success')) active @endif " id="activeProjects-tab"
                        data-bs-toggle="tab" data-bs-target="#activeProjects" type="button" role="tab"
                        aria-controls="activeProjects" aria-selected="true">Yayında Olanlar</button>
                </li>

                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="inactiveProjects-tab" data-bs-toggle="tab"
                        data-bs-target="#inactiveProjects" type="button" role="tab" aria-controls="inactiveProjects"
                        aria-selected="false">Yayında Olmayanlar</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="disabledProjects-tab" data-bs-toggle="tab"
                        data-bs-target="#disabledProjects" type="button" role="tab" aria-controls="disabledProjects"
                        aria-selected="false">Reddedilen İlanlar</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="deletedProjects-tab" data-bs-toggle="tab" data-bs-target="#deletedProjects"
                        type="button" role="tab" aria-controls="deletedProjects" aria-selected="false">Silinen
                        İlanlar</button>
                </li>
            </ul>

            <div class="tab-content px-4 pb-4">
                <div class="tab-pane fade @if (session()->has('success')) show  active @endif  " id="activeProjects"
                    role="tabpanel" aria-labelledby="activeProjects-tab">
                    @include('admin.projects.tab-content', ['projects' => $activeProjects])
                </div>
                <div class="tab-pane fade @if (!session()->has('success')) show  active @endif " id="pendingProjects"
                    role="tabpanel" aria-labelledby="inactiveProjects-tab">
                    @include('admin.projects.tab-content', ['projects' => $pendingProjects])
                </div>
                <div class="tab-pane fade" id="inactiveProjects" role="tabpanel" aria-labelledby="inactiveProjects-tab">
                    @include('admin.projects.tab-content', ['projects' => $inactiveProjects])
                </div>
                <div class="tab-pane fade" id="disabledProjects" role="tabpanel" aria-labelledby="disabledProjects-tab">
                    @include('admin.projects.tab-content', ['projects' => $disabledProjects])
                </div>
                <div class="tab-pane fade" id="deletedProjects" role="tabpanel" aria-labelledby="deletedProjects-tab">
                    @include('admin.projects.tab-content-delete', ['projects' => $deletedProjects])
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    document.querySelectorAll('form').forEach(function(form) {
        form.addEventListener('submit', function(event) {
            // Form submit edildiğinde yükleme işlemi başlayacak
            var button = this.querySelector('.update-button');
            button.innerHTML = '<div class="spinner-border spinner-border-sm mt-1" role="status"><span class="visually-hidden">Loading...</span></div>';
        });
    });
</script>

@endsection

@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.css"
        integrity="sha512-8D+M+7Y6jVsEa7RD6Kv/Z7EImSpNpQllgaEIQAtqHcI0H6F4iZknRj0Nx1DCdB+TwBaS+702BGWYC0Ze2hpExQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        /* Sayfayı kaplayacak modal */
        .modal {
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1050;
            width: 100%;
            height: 100%;
            overflow: hidden;
            background: rgba(0, 0, 0, 0.5);
        }

        /* Orta konumlandırma için modal içeriği */
        .modal-dialog {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        /* Spinner'ı modal içinde ortala */
        .spinner-border {
            margin-top: 50px;
        }

        .ml-3 {
            margin-left: 20px
        }

        .badge-success {
            background-color: green
        }

        .badge-danger {
            background-color: red
        }

        .badge-info {
            background-color: #e54242
        }

        .nav-tabs .nav-link {
            color: black !important;
        }

        .nav-tabs .nav-link.active,
        .nav-tabs .nav-item.show .nav-link {
            color: red !important;
        }

        .ml-2 {
            margin-left: 20px;
        }

        .mr-2 {
            margin-right: 20px;
        }
    </style>
@endsection
