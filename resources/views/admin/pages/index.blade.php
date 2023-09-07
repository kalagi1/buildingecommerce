@extends('admin.layouts.master')

@section('content')
    <div class="content">
        <div class="row">
            <div class="mb-9">
                <div id="projectSummary"
                    data-list='{"valueNames":["projectName","assigness","start","deadline","task","projectprogress","status","action"],"page":6,"pagination":true}'>
                    <div class="row justify-content-between mb-4 gx-6 gy-3 align-items-center">
                        <div class="col-auto">
                            <h2 class="mb-0">Pages<span class="fw-normal text-700 ms-3">({{ count($pages) }})</span>
                            </h2>
                        </div>
                        <div class="col-auto">
                            <div class="col-auto"><a class="btn btn-primary px-5"
                                    href="{{ route('admin.pages.create') }}"><i class="fa-solid fa-plus me-2"></i>Add
                                    New
                                    Page</a></div>

                        </div>
                    </div>
                    @if (session('success'))
                        <div class="alert alert-success text-white">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger text-white">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="table-responsive scrollbar">
                        <table class="table fs--1 mb-0 border-top border-200">
                            <thead>
                                <tr>
                                <tr>
                                    <th style="width:15%;">ID</th>
                                    <th class="sort white-space-nowrap align-middle ps-0" scope="col"
                                        data-sort="projectName" style="width:60%;">PAGE TITLE</th>
                                    <th style="width:15%;">Action</th>
                                </tr>

                            </thead>
                            <tbody class="list" id="project-list-table-body">
                                @foreach ($pages as $key => $page)
                                    <tr class="position-static">
                                        <td>{{ $key + 1 }}</td>
                                        <td>
                                            {{ $page->title }}
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.pages.edit', $page->id) }}"
                                                class="btn btn-sm btn-primary">Edit</a>
                                            <form action="{{ route('admin.pages.destroy', $page->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Are you sure you want to delete this page?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                    <div
                        class="d-flex flex-wrap align-items-center justify-content-between py-3 pe-0 fs--1 border-bottom border-200">
                        <div class="d-flex">
                            <p class="mb-0 d-none d-sm-block me-3 fw-semi-bold text-900" data-list-info="data-list-info">
                            </p>
                        </div>
                        <div class="d-flex"><button class="page-link" data-list-pagination="prev"><span
                                    class="fas fa-chevron-left"></span></button>
                            <ul class="mb-0 pagination"></ul><button class="page-link pe-0"
                                data-list-pagination="next"><span class="fas fa-chevron-right"></span></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @push('scripts')
    @endpush
