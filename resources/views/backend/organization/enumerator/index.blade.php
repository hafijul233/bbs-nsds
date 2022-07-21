@extends('layouts.app')

@section('title', __('menu-sidebar.Enumerators'))

@push('meta')

@endpush

@push('webfont')

@endpush

@push('icon')

@endpush

@push('plugin-style')
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}" type="text/css">
@endpush

@push('page-style')

@endpush



@section('breadcrumbs', \Breadcrumbs::render())

@section('actions')
    {!! \Html::linkButton(__('enumerator.Add Enumerator'), 'backend.organization.enumerators.create', [], 'fas fa-plus', 'success') !!}
    {!! \Html::bulkDropdown('backend.organization.enumerators', 0, ['color' => 'warning']) !!}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header border-transparent pb-0">
                        <h2 class="card-title">Filter Results</h2>
                        <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-warning" id="clearAll">
                                <span>Clear All</span>
                            </button>
                            {{--<button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>--}}
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="GET" action="{{ route('backend.organization.enumerators.index') }}"
                              accept-charset="UTF-8">
                            {!! \Form::hSelect('survey_id', __('survey.Surveys'),$surveys,
old('survey_id', isset($request['survey_id']) ? request('survey_id') : ''), false, 3, ['placeholder' => __('enumerator.Select a Survey Option')]) !!}
                            {!! \Form::hSelect('division_id', __('enumerator.Division'),$divisions,
old('division_id', isset($request['division_id']) ? request('division_id') : null), false, 3, ['placeholder' => __('enumerator.Select a Division Option')]) !!}
                            {!! \Form::hRadio('work_options', __('enumerator.Select the district(s) where you have worked earlier or want to work in future'), [1=>__('enumerator.Worked Earlier'), 2=>__('enumerator.Work in Future')], old('work_options', ($request['work_options'] ?? '')), false, 7) !!}
                            {!! \Form::hSelect('prev_post_state_id', __('enumerator.Worked Earlier'),$states,
old('prev_post_state_id', isset($request['prev_post_state_id']) ? request('prev_post_state_id') : null), false, 3, ['placeholder' => __('enumerator.Select a Worked Earlier Option')]) !!}
                            {!! \Form::hSelect('future_post_state_id', __('enumerator.Work in Future'),$states,
old('future_post_state_id', isset($request['future_post_state_id']) ? request('future_post_state_id') : null), false, 3, ['placeholder' => __('enumerator.Select a Work in Future Option')]) !!}
                            <div class="input-group">
                                <input class="form-control" placeholder="Search Enumerator Name etc." id="search"
                                       data-target-table="enumerator-table" name="search" type="search" value="{{ request('search') }}">
                                <div class="input-group-append">
                                    <input class="btn btn-primary input-group-right-btn" type="submit" value="Search">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card card-default">
                    @if(!empty($enumerators))
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0" id="employee-table">
                                    <thead class="thead-light">
                                    <tr>
                                        <th class="align-middle">
                                            @sortablelink('id', '#')
                                        </th>
                                        <th>@sortablelink('name', __('common.Name'))</th>
                                        <th>@sortablelink('mobile_1', __('common.Mobile'))</th>
                                        <th>@sortablelink('email', __('common.Email'))</th>
                                        <th>@sortablelink('whatsapp', __('enumerator.Whatsapp Number'))</th>
                                        <th class="text-center">@sortablelink('created_at', __('common.Created'))</th>
                                        <th class="text-center">{!! __('common.Actions') !!}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($enumerators as $index => $enumerator)
                                        <tr @if($enumerator->deleted_at != null) class="table-danger" @endif>
                                            <td class="exclude-search align-middle">
                                                {{ $enumerator->id }}
                                            </td>
                                            <td class="text-left">
                                                @can('backend.organization.enumerators.show')
                                                    <a href="{{ route('backend.organization.enumerators.show', $enumerator->id) }}">
                                                        {{ $enumerator->name }}<br>
                                                        {!!  $enumerator->name_bd !!}

                                                    </a>
                                                @else
                                                    {{ $enumerator->name }}<br>
                                                    {!!  $enumerator->name_bd !!}
                                                @endcan
                                            </td>
                                            <td>
                                                {{ $enumerator->mobile_1 }}@if(!empty($enumerator->mobile_2)),
                                                <br>{{ $enumerator->mobile_2 }}@endif
                                            </td>
                                            <td>
                                                {{ $enumerator->email }}
                                            </td>
                                            <td>
                                                {{ $enumerator->whatsapp }}
                                            </td>

                                            <td class="text-center">{{ $enumerator->created_at->format(config('backend.datetime')) ?? '' }}</td>
                                            <td class="exclude-search pr-3 text-center align-middle">
                                                {!! \Html::actionDropdown('backend.organization.enumerators', $enumerator->id, array_merge(['show', 'edit'], ($enumerator->deleted_at == null) ? ['delete'] : ['restore'])) !!}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="exclude-search text-center">No data to display</td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent pb-0">
                            {!! \App\Supports\CHTML::pagination($enumerators) !!}
                        </div>
                    @else
                        <div class="card-body min-vh-100">

                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
    {!! \App\Supports\CHTML::confirmModal('Enumerator', ['export', 'delete', 'restore']) !!}
@endsection


@push('plugin-script')
    <script type="text/javascript" src="{{ asset('plugins/select2/js/select2.min.js') }}"></script>
@endpush

@push('page-script')
    <script>

        var work_options = '{{request('work_options')}}';
        var prev_post_state_id = '{{request('prev_post_state_id')}}';
        var future_post_state_id = '{{request('future_post_state_id')}}';
        $(document).ready(function () {
            if(work_options == 1){
                $("#future_post_state_id").prop("disabled", true);
                $("#prev_post_state_id").prop("disabled", false);
            }else if(work_options == 2){
                $("#prev_post_state_id").prop("disabled", true);
                $("#future_post_state_id").prop("disabled", false);
            }else{
                $("#prev_post_state_id").prop("disabled", true);
                $("#future_post_state_id").prop("disabled", true);
            }

            $('input:radio[name="work_options"]').change(function() {
                if ($(this).val() == '1') {
                    $("#prev_post_state_id").prop("disabled", false);
                    $("#future_post_state_id").val('').trigger('change');
                    $("#future_post_state_id").prop("disabled", true);
                } else {
                    $("#prev_post_state_id").prop("disabled", true);
                    $("#future_post_state_id").prop("disabled", false);
                    $("#prev_post_state_id").val('').trigger('change');
                }
                $("#division_id").val('').trigger('change');
            });

            $("#survey_id").select2({
                width: "100%",
                allowClear: true,
                placeholder: "{{ __('enumerator.Select a Survey Option') }}",
                minimumResultsForSearch: Infinity
            });

            $("#prev_post_state_id").select2({
                width: "100%",
                allowClear: true,
                placeholder: "{{ __('enumerator.Select a Worked Earlier Option') }}",
                minimumResultsForSearch: Infinity
            });
            $("#future_post_state_id").select2({
                width: "100%",
                allowClear: true,
                placeholder: "{{ __('enumerator.Select a Work in Future Option') }}",
                minimumResultsForSearch: Infinity
            });
            $("#division_id").select2({
                width: "100%",
                allowClear: true,
                placeholder: "{{ __('enumerator.Select a Division Option') }}",
                minimumResultsForSearch: Infinity
            });

            $('#clearAll').click(function (){
                $("#survey_id").val('').trigger('change');
                $("#division_id").val('').trigger('change');
                $("#prev_post_state_id").val('').trigger('change');
                $("#future_post_state_id").val('').trigger('change');
                $("#search").val('');
                $('input:radio[name="work_options"]').prop('checked', false);
            });
        });
    </script>
@endpush
