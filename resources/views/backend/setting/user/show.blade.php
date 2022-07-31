@extends('layouts.app')

@section('title', $user->name ?? '')

@push('meta')

@endpush

@push('webfont')

@endpush

@push('icon')

@endpush

@push('plugin-style')
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
@endpush

@push('page-style')

@endpush

@section('breadcrumbs', Breadcrumbs::render(Route::getCurrentRoute()->getName(), $user))


@section('actions')
    {!! \Html::backButton('backend.settings.users.index') !!}
    {{--    @can('backend.settings.roles.user')
            <a href="#!" data-toggle="modal" data-target="#bd-example-modal-lg"
               class="btn btn-primary m-1 m-md-0">
                <i class="mdi mdi-account-convert-outline"></i>
                <span class="d-none d-md-inline-flex">Add / Remove Roles</span>
            </a>
        @endcan--}}
    {!! \Html::modelDropdown('backend.settings.users', $user->id, ['color' => 'success',
    'actions' => array_merge(['edit'], ($user->deleted_at == null) ? ['delete'] : ['restore'])]) !!}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-default">
                    <div class="card-header p-3">
                        <ul class="nav nav-pills nav-justified" id="pills-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="pills-home-tab"
                                   data-toggle="pill" href="#pills-home" role="tab"
                                   aria-controls="pills-home" aria-selected="true"><strong>Details</strong></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-permission-tab"
                                   data-toggle="pill" href="#pills-permission"
                                   role="tab" aria-controls="pills-permission"
                                   aria-selected="false"><strong>Permissions</strong></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="setting-tab"
                                   data-toggle="pill" href="#setting"
                                   role="tab" aria-controls="setting"
                                   aria-selected="false"><strong>Settings</strong></a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                                 aria-labelledby="pills-home-tab">
                                @include('backend.setting.user.tabs.detail')
                            </div>
                            <div class="tab-pane fade" id="pills-permission" role="tabpanel"
                                 aria-labelledby="pills-permission-tab">
                                @include('backend.setting.user.tabs.permission')
                            </div>
                            <div class="tab-pane fade" id="setting" role="tabpanel"
                                 aria-labelledby="setting-tab">
                                @include('backend.setting.user.tabs.setting')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {!! \App\Supports\CHTML::confirmModal('User', ['export', 'delete', 'restore']) !!}
@endsection

@push('plugin-script')

@endpush


@push('page-script')
    <script>
        $(function () {
            $.ajax({
                url: '{{ route('backend.settings.roles.ajax') }}',
                data: {paginate: false},
                contentType: 'application/json',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                dataType: 'json',
                success: function (response) {

                },
                error: function (response) {

                }
            });

            $("#role_all").click(function () {
                if ($(this).prop("checked")) {
                    $(".role-checkbox").each(function () {
                        $(this).prop("checked", true);
                    });
                } else {
                    $(".role-checkbox").each(function () {
                        $(this).prop("checked", false);
                    });
                }
            });

            $("#role-user-form").submit(function (event) {
                event.preventDefault();
                var formData = new FormData(this);
                var formUrl = $(this).attr('action');

                $.ajax({
                    url: formUrl,
                    data: formData,
                    processData: false,
                    contentType: false,
                    type: "POST",
                    dateType: "JSON",
                    success: function (response) {
                        if (response.status === true) {
                            notify(response.message, response.level, response.title);
                            setTimeout(function () {
                                window.location.reload();
                            }, 5000);

                        } else {
                            notify(response.message, response.level, response.title);
                        }
                    },
                    error: function (error) {
                        var responseObject = error.responseJSON;

                        var message = responseObject.message;

                        for (var field in responseObject.errors) {
                            message += "<br><ul>";
                            for (var errorText of responseObject.errors[field]) {
                                message += ("<li>" + errorText + "</li>");
                            }
                            message += "</ul>";
                        }

                        notify(message, 'error', 'Error!');
                    }
                });
            });
        });
    </script>
@endpush
