@extends('auth.layouts.master')

@section('title', 'Đăng nhập')

@section('content')

<div class="auth-card-header">
    <h1>Đăng nhập</h1>
    <p>Nhập thông tin tài khoản quản trị để truy cập hệ thống.</p>
</div>

{{-- Thông báo lỗi --}}
{{-- @if ($errors->any())
<div class="alert alert-error">
    <i class="fa-solid fa-circle-exclamation"></i>
    <span>{{ $errors->first() }}</span>
</div>
@endif --}}

{{-- Demo alert --}}
{{-- <div class="alert alert-info">
    <i class="fa-solid fa-circle-info"></i>
    <span>Tài khoản demo: <strong>admin@kinetic.com</strong> / <strong>password</strong></span>
</div> --}}

<form method="POST" action="{{ url('/login') }}" id="login-form" novalidate>
    @csrf

    {{-- Email --}}
    <div class="form-group">
        <label for="login-email">Địa chỉ Email</label>
        <div class="input-wrap">
            <i class="fa-solid fa-envelope input-icon"></i>
            <input
                type="email"
                id="login-email"
                name="email"
                placeholder="admin@kineticmotors.com"
                value="{{ old('email') }}"
                autocomplete="email"
                required
                aria-required="true"
            >
        </div>
        @error('email')
            <span class="field-error"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</span>
        @enderror
    </div>

    {{-- Password --}}
    <div class="form-group">
        <label for="login-password">Mật khẩu</label>
        <div class="input-wrap">
            <i class="fa-solid fa-lock input-icon"></i>
            <input
                type="password"
                id="login-password"
                name="password"
                placeholder="Nhập mật khẩu..."
                autocomplete="current-password"
                required
                aria-required="true"
            >
            <span class="toggle-pass" id="toggle-pass" aria-label="Hiện/ẩn mật khẩu" tabindex="0">
                <i class="fa-solid fa-eye" id="pass-eye-icon"></i>
            </span>
        </div>
        @error('password')
            <span class="field-error"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</span>
        @enderror
    </div>

    {{-- Remember & Forgot --}}
    <div class="form-row-flex">
        <label class="checkbox-label">
            <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
            Ghi nhớ đăng nhập
        </label>
        <a href="{{ url('/forgot-password') }}" class="forgot-link">Quên mật khẩu?</a>
    </div>

    {{-- Submit --}}
    <button type="submit" class="btn-auth" id="btn-login">
        <i class="fa-solid fa-right-to-bracket"></i>
        Đăng nhập
    </button>

</form>

<div class="auth-divider">
    <hr><span>Chưa có tài khoản?</span><hr>
</div>

<div class="auth-footer-link">
    Liên hệ quản trị hệ thống để được cấp tài khoản
    hoặc <a href="{{ url('/register') }}">đăng ký tại đây</a>.
</div>

@endsection

@section('scripts')
<script>
(function(){
    'use strict';

    /* Toggle hiện/ẩn mật khẩu */
    const toggleBtn = document.getElementById('toggle-pass');
    const passInput = document.getElementById('login-password');
    const eyeIcon   = document.getElementById('pass-eye-icon');

    function togglePassword(){
        const isPass = passInput.type === 'password';
        passInput.type = isPass ? 'text' : 'password';
        eyeIcon.className = isPass ? 'fa-solid fa-eye-slash' : 'fa-solid fa-eye';
    }

    toggleBtn.addEventListener('click', togglePassword);
    toggleBtn.addEventListener('keydown', e => { if(e.key==='Enter'||e.key===' ') togglePassword(); });

    /* Loading state khi submit */
    document.getElementById('login-form').addEventListener('submit', function(){
        const btn = document.getElementById('btn-login');
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Đang xử lý...';
        btn.disabled  = true;
    });
})();
</script>
@endsection
