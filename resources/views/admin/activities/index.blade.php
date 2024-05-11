@extends('admin.layouts.master')

@section('content')
    <div class="content">
        <div class="row g-4">
            <div class="col-12 col-xl-12  order-1 order-xl-0">
                <div class="mb-9">
                    <div class="card shadow-none border border-300 my-4 p-5">
                        <div class="row align-items-end justify-content-between pb-5 g-3">
                            <div class="col-auto">
                                <h3>İşlem Kayıtları</h3>
                            </div>
                        </div>
                        <div class="table-responsive mx-n1 px-1 scrollbar">
                            <table class="table fs--1 mb-0 border-top border-200">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Log Name</th>
                                        <th>Description</th>
                                        <th>Event</th>
                                        <th>Subject Type</th>
                                        <th>Subject ID</th>
                                        <th>Causer Type</th>
                                        <th>Causer ID</th>
                                        <th>Properties</th>
                                        <th>Created At</th>
                                        <th>Updated At</th>
                                    </tr>
                                </thead>
                                <tbody class="list" id="table-latest-review-body">
                                    @foreach ($activities as $activity)
                                        <tr class="hover-actions-trigger btn-reveal-trigger position-static">
                                            <td>{{ $activity->id }}</td>
                                            <td>{{ $activity->log_name }}</td>
                                            <td>{{ $activity->description }}</td>
                                            <td>{{ $activity->event }}</td>
                                            <td>{{ $activity->subject_type }}</td>
                                            <td>{{ $activity->subject_id }}</td>
                                            <td>{{ $activity->causer_type }}</td>
                                            <td>{{ $activity->causer_id }}</td>
                                            <td>
                                                <details>
                                                    <summary>View Details</summary>
                                                    <pre>{{ json_encode($activity->properties, JSON_PRETTY_PRINT) }}</pre>
                                                </details>
                                            </td>
                                            <td>{{ $activity->created_at }}</td>
                                            <td>{{ $activity->updated_at }}</td>
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
@endsection
