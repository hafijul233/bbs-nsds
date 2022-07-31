@push('plugin-style')
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}" type="text/css">
@endpush

{!! \Form::open(['route' => ['backend.settings.users.setting', $user->id], 'id' => 'user-form', 'method' => 'patch']) !!}

{!! \Form::hidden('id', $user->id) !!}

<div class="row">
    <div class="col-md-6">
        {!! \Form::nSelect('locale', 'Locale', \App\Supports\Constant::LOCALES,
        old('locale', ($user->locale ?? \App\Supports\Constant::LOCALE)), true) !!}
    </div>
    <div class="col-md-6">
        @switch(config('auth.credential_field'))
            @case(\App\Supports\Constant::LOGIN_USERNAME)
            {!! \Form::nText('username', 'Username', old('username', $user->username ?? null),
                (config('auth.credential_field') == \App\Supports\Constant::LOGIN_USERNAME)) !!}
            @break


            @case(\App\Supports\Constant::LOGIN_MOBILE)
            {!! \Form::nTel('mobile', __('common.Mobile'), old('mobile', $user->mobile ?? null),
            (config('auth.credential_field') == \App\Supports\Constant::LOGIN_MOBILE
            || (config('auth.credential_field') == \App\Supports\Constant::LOGIN_OTP
                && config('auth.credential_otp_field') == \App\Supports\Constant::OTP_MOBILE))) !!}
            @break

            @default
            {!! \Form::nEmail('email', 'Email Address', old('email', $user->email ?? null),
            (config('auth.credential_field') == \App\Supports\Constant::LOGIN_EMAIL
            || (config('auth.credential_field') == \App\Supports\Constant::LOGIN_OTP
                && config('auth.credential_otp_field') == \App\Supports\Constant::OTP_EMAIL))) !!}
            @break
        @endswitch
    </div>
    @if(config('auth.credential_field') != \App\Supports\Constant::LOGIN_OTP)
        <div class="col-md-6">
            {!! \Form::nPassword('password', 'Password', empty($user->password), ['placeholder' => 'Enter Password']) !!}
        </div>
        <div class="col-md-6">
            {!! \Form::nPassword('password_confirmation', 'Retype Password', empty($user->password), ['placeholder' => 'Retype Password']) !!}
        </div>
    @endif
    <div class="col-md-6">
        {!! \Form::nSelectMulti('role_id', 'Role', $roles,
        old('role_id.*', ($user_roles ?? [\App\Supports\Constant::GUEST_ROLE_ID])), true,
        ['class' => 'form-control custom-select select2', 'disabled' => ($user->id == auth()->user()->id)]) !!}

    </div>
    <div class="col-md-6">
        {!! \Form::nSelect('enabled', __('common.Enabled'), \App\Supports\Constant::ENABLED_OPTIONS,
        old('enabled', ($user->enabled ?? \App\Supports\Constant::ENABLED_OPTION))) !!}
    </div>
</div>
<div class="row mt-3">
    <div class="col-12 justify-content-between d-flex">
        {!! \Form::nCancel(__('common.Cancel')) !!}
        {!! \Form::nSubmit('submit', __('common.Save')) !!}
    </div>
</div>

@push('page-script')
    <script type="text/javascript" src="{{ asset('plugins/select2/js/select2.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            //trigger select2
            $("#role_id").select2({
                placeholder: 'Select Role(s)',
                minimumResultsForSearch: Infinity,
                maximumSelectionLength: 3,
                allowClear: true,
                multiple: true,
                width: "100%"
            });

            $("#user-form").validate({
                rules: {
                    name: {
                        required: true,
                        minlength: 3,
                        maxlength: 255
                    },
                    username: {},
                    email: {
                        required: true,
                        email: true,
                        minlength: 2,
                        maxlength: 255
                    },
                    mobile: {
                        required: true,
                        digits: true,
                        minlength: 11,
                        maxlength: 11
                    },
                    password: {
                        required: {{ isset($user) ? 'false' : 'true' }},
                        minlength: '{{ config('auth.minimum_password_length') }}',
                        maxlength: 255,
                        equalTo: "#password_confirmation"
                    },
                    password_confirmation: {
                        required: {{ isset($user) ? 'false' : 'true' }},
                        minlength: '{{ config('auth.minimum_password_length') }}',
                        maxlength: 255,
                        equalTo: "#password"
                    }
                }
            });
        });
    </script>
@endpush

{!! \Form::close() !!}