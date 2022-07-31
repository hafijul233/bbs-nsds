@push('plugin-style')
    <link rel="stylesheet" href="{{ asset('plugins/flag-icon-css/css/flag-icon.min.css') }}">
@endpush
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Menu sidebar toggle button -->
    <a class="nav-link text-decoration-none text-dark" data-widget="pushmenu" href="#" role="button"><i
                class="fas fa-bars"></i></a>

    <!-- Left navbar links -->
{{--@include('layouts.partials.navbar.navbar-shortcut')--}}

<!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Full screen -->
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
                <i class="flag-icon @if(session()->get('locale') == 'bd') flag-icon-bd @else flag-icon-us @endif"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right p-0" style="left: inherit; right: 0;">
                <a href="{{ route('translate-locale') }}?language=en"
                   class="dropdown-item @if(session()->get('locale') == 'en') active @endif">
                    <i class="flag-icon flag-icon-us mr-2"></i> English
                </a>
                <a href="{{ route('translate-locale') }}?language=bd"
                   class="dropdown-item @if(session()->get('locale') == 'bd') active @endif">
                    <i class="flag-icon flag-icon-bd mr-2"></i> Bangla
                </a>
            </div>
        </li>
        <!-- Navbar Search -->
    {{--@include('layouts.partials.navbar.navbar-search')--}}
    <!-- Messages Dropdown Menu -->
    {{--@include('layouts.partials.navbar.navbar-message')--}}
    <!-- Notifications Dropdown Menu -->
    {{--@include('layouts.partials.navbar.navbar-notification')--}}
    <!-- User Profile Dropdown menu -->
        @include('layouts.partials.navbar.navbar-user')
        {{--<li class="nav-item">
            <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                <i class="fas fa-th-large"></i>
            </a>
        </li>--}}
    </ul>
</nav>
<!-- /.navbar -->

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{ __('auth.logout.message') }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('common.Cancel') }}</button>
                {!! \Form::open(['route' => 'auth.logout']) !!}
                <button type="submit" class="btn btn-primary">{{ __('common.Sign out') }}</button>
                {!! \Form::close() !!}
            </div>
        </div>
    </div>
</div>
