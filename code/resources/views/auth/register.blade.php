@extends('auth.layouts.master')

@section('title', 'Đăng ký tài khoản')

@section('styles')
<style>
    /* Password strength indicator */
    .strength-bar-wrap {
        height: 4px;
        background: var(--border);
        border-radius: 4px;
        margin-top: 6px;
        overflow: hidden;
    }
    .strength-bar {
        height: 100%;
        border-radius: 4px;
        width: 0%;
        transition: width .3s ease, background .3s ease;
    }
    .strength-text {
        font-size: 11px;
        margin-top: 4px;
        font-weight: 500;
        color: var(--text-muted);
    }
</style>
@endsection

@section('content')

<div class="auth-card-header">
    <h1>Tạo tài khoản</h1>
    <p>Điền thông tin để đăng ký tài khoản quản trị viên mới.</p>
</div>

<form method="POST" action="{{ url('/register') }}" id="register-form" novalidate>
    @csrf

    {{-- Họ & Tên --}}
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
        <div class="form-group" style="margin-bottom:0;">
            <label for="reg-firstname">Họ</label>
            <div class="input-wrap">
                <i class="fa-solid fa-user input-icon"></i>
                <input
                    type="text"
                    id="reg-firstname"
                    name="first_name"
                    placeholder="Nguyễn"
                    value="{{ old('first_name') }}"
                    autocomplete="given-name"
                    required
                >
            </div>
            @error('first_name')
                <span class="field-error"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</span>
            @enderror
        </div>
        <div class="form-group" style="margin-bottom:0;">
            <label for="reg-lastname">Tên</label>
            <div class="input-wrap">
                <i class="fa-solid fa-user input-icon"></i>
                <input
                    type="text"
                    id="reg-lastname"
                    name="last_name"
                    placeholder="Văn A"
                    value="{{ old('last_name') }}"
                    autocomplete="family-name"
                    required
                >
            </div>
            @error('last_name')
                <span class="field-error"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</span>
            @enderror
        </div>
    </div>

    <div style="margin-bottom:16px;"></div>

    {{-- Email --}}
    <div class="form-group">
        <label for="reg-email">Địa chỉ Email</label>
        <div class="input-wrap">
            <i class="fa-solid fa-envelope input-icon"></i>
            <input
                type="email"
                id="reg-email"
                name="email"
                placeholder="email@kineticmotors.com"
                value="{{ old('email') }}"
                autocomplete="email"
                required
            >
        </div>
        @error('email')
            <span class="field-error"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</span>
        @enderror
    </div>

    {{-- Vai trò --}}
    <div class="form-group">
        <label for="reg-role">Vai trò</label>
        <div class="input-wrap">
            <i class="fa-solid fa-user-tag input-icon"></i>
            <input
                type="text"
                id="reg-role"
                name="role"
                placeholder="VD: Quản lý bán hàng"
                value="{{ old('role') }}"
                style="padding-left:40px;"
            >
        </div>
    </div>

    {{-- Mật khẩu --}}
    <div class="form-group">
        <label for="reg-password">Mật khẩu</label>
        <div class="input-wrap">
            <i class="fa-solid fa-lock input-icon"></i>
            <input
                type="password"
                id="reg-password"
                name="password"
                placeholder="Tối thiểu 8 ký tự"
                autocomplete="new-password"
                required
            >
            <span class="toggle-pass" id="toggle-reg-pass" aria-label="Hiện/ẩn mật khẩu" tabindex="0">
                <i class="fa-solid fa-eye" id="reg-eye-icon"></i>
            </span>
        </div>
        {{-- Password strength --}}
        <div class="strength-bar-wrap"><div class="strength-bar" id="strength-bar"></div></div>
        <div class="strength-text" id="strength-text">Nhập mật khẩu để kiểm tra độ mạnh</div>
        @error('password')
            <span class="field-error"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</span>
        @enderror
    </div>

    {{-- Xác nhận mật khẩu --}}
    <div class="form-group" style="margin-bottom:20px;">
        <label for="reg-password-confirm">Xác nhận mật khẩu</label>
        <div class="input-wrap">
            <i class="fa-solid fa-lock input-icon"></i>
            <input
                type="password"
                id="reg-password-confirm"
                name="password_confirmation"
                placeholder="Nhập lại mật khẩu"
                autocomplete="new-password"
                required
            >
            <span class="toggle-pass" id="toggle-confirm-pass" tabindex="0" aria-label="Hiện/ẩn">
                <i class="fa-solid fa-eye" id="confirm-eye-icon"></i>
            </span>
        </div>
        <div class="field-error" id="confirm-error" style="display:none;">
            <i class="fa-solid fa-circle-exclamation"></i> Mật khẩu xác nhận không khớp.
        </div>
    </div>

    {{-- Terms --}}
    <div style="margin-bottom:20px;">
        <label class="checkbox-label">
            <input type="checkbox" name="terms" id="reg-terms" required>
            Tôi đồng ý với
            <a href="#" style="color:var(--primary);font-weight:600;">Điều khoản dịch vụ</a>
            và
            <a href="#" style="color:var(--primary);font-weight:600;">Chính sách bảo mật</a>
        </label>
    </div>

    {{-- Submit --}}
    <button type="submit" class="btn-auth" id="btn-register">
        <i class="fa-solid fa-user-plus"></i>
        Tạo tài khoản
    </button>

</form>

<div class="auth-footer-link" style="margin-top:20px;">
    Đã có tài khoản? <a href="{{ url('/login') }}">Đăng nhập ngay</a>
</div>

@endsection

@section('scripts')
<script>
(function(){
    'use strict';

    /* Toggle mật khẩu */
    function makeToggle(btnId, inputId, iconId){
        const btn = document.getElementById(btnId);
        const input = document.getElementById(inputId);
        const icon  = document.getElementById(iconId);
        if(!btn) return;
        function toggle(){
            const isPass = input.type === 'password';
            input.type = isPass ? 'text' : 'password';
            icon.className = isPass ? 'fa-solid fa-eye-slash' : 'fa-solid fa-eye';
        }
        btn.addEventListener('click', toggle);
        btn.addEventListener('keydown', e => { if(e.key==='Enter'||e.key===' ') toggle(); });
    }

    makeToggle('toggle-reg-pass',     'reg-password',         'reg-eye-icon');
    makeToggle('toggle-confirm-pass', 'reg-password-confirm', 'confirm-eye-icon');

    /* Password strength */
    const pwInput  = document.getElementById('reg-password');
    const strengthBar  = document.getElementById('strength-bar');
    const strengthText = document.getElementById('strength-text');

    pwInput.addEventListener('input', function(){
        const val = this.value;
        let score = 0;
        if(val.length >= 8)           score++;
        if(/[A-Z]/.test(val))         score++;
        if(/[0-9]/.test(val))         score++;
        if(/[^A-Za-z0-9]/.test(val))  score++;

        const configs = [
            { w:'0%',  color:'#ef4444', label:'Chưa nhập' },
            { w:'25%', color:'#ef4444', label:'Yếu' },
            { w:'50%', color:'#f59e0b', label:'Trung bình' },
            { w:'75%', color:'#0ea5e9', label:'Mạnh' },
            { w:'100%',color:'#10b981', label:'Rất mạnh ✓' },
        ];

        const cfg = configs[val.length===0?0:Math.min(score,4)];
        strengthBar.style.width    = cfg.w;
        strengthBar.style.background = cfg.color;
        strengthText.textContent   = val.length===0 ? 'Nhập mật khẩu để kiểm tra độ mạnh' : cfg.label;
        strengthText.style.color   = cfg.color;
    });

    /* Confirm match check */
    const confirmInput = document.getElementById('reg-password-confirm');
    const confirmErr   = document.getElementById('confirm-error');

    confirmInput.addEventListener('input', function(){
        const match = this.value === pwInput.value;
        confirmErr.style.display = (this.value && !match) ? 'flex' : 'none';
    });

    /* Loading state */
    document.getElementById('register-form').addEventListener('submit', function(e){
        const pw  = pwInput.value;
        const cpw = confirmInput.value;
        if(pw !== cpw){ e.preventDefault(); confirmErr.style.display='flex'; return; }
        const btn = document.getElementById('btn-register');
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Đang tạo tài khoản...';
        btn.disabled  = true;
    });
})();
</script>
@endsection
