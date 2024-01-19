@extends('admin.layouts.master')

@section('content')
    <div class="content">
        <h2 class="mb-2 lh-sm">Proje İlanları</h2>

        <div class="card shadow-none border border-300 my-4">
            <ul class="nav nav-tabs px-4 mt-3 mb-3" id="projectTabs">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="activeProjects-tab" data-bs-toggle="tab"
                        data-bs-target="#activeProjects" type="button" role="tab" aria-controls="activeProjects"
                        aria-selected="true">Yayında Olanlar</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="inactiveProjects-tab" data-bs-toggle="tab"
                        data-bs-target="#inactiveProjects" type="button" role="tab" aria-controls="inactiveProjects"
                        aria-selected="false">Yayında Olmayanlar</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="deletedProjects-tab" data-bs-toggle="tab"
                        data-bs-target="#deletedProjects" type="button" role="tab" aria-controls="deletedProjects"
                        aria-selected="false">Silinen İlanlar</button>
                </li>
            </ul>

            <div class="tab-content px-4 pb-4">
                <div class="tab-pane fade show active" id="activeProjects" role="tabpanel"
                    aria-labelledby="activeProjects-tab">
                    @include('admin.projects.tab-content', ['projects' => $activeProjects])
                </div>
                <div class="tab-pane fade" id="inactiveProjects" role="tabpanel" aria-labelledby="inactiveProjects-tab">
                    @include('admin.projects.tab-content', ['projects' => $inactiveProjects])
                </div>
                <div class="tab-pane fade" id="deletedProjects" role="tabpanel" aria-labelledby="deletedProjects-tab">
                    @include('admin.projects.tab-content-delete', ['projects' => $deletedProjects])
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.css"
        integrity="sha512-8D+M+7Y6jVsEa7RD6Kv/Z7EImSpNpQllgaEIQAtqHcI0H6F4iZknRj0Nx1DCdB+TwBaS+702BGWYC0Ze2hpExQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
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
        .nav-tabs .nav-link{
            color:black !important;
        }
        .nav-tabs .nav-link.active, .nav-tabs .nav-item.show .nav-link{
            color:red !important;
        }
        .ml-2 {
            margin-left: 20px;
        }

        .mr-2 {
            margin-right: 20px;
        }
    </style>
@endsection