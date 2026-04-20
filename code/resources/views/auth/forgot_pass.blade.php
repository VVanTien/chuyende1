@extends('auth.layouts.master')

@section('title', 'Quên mật khẩu')

@section('content')

{{-- Trạng thái: chờ nhập email --}}
<div id="step-email">

    <div class="auth-card-header">
        <h1>Đặt lại mật khẩu</h1>
        <p>Nhập email tài khoản và chúng tôi sẽ gửi link đặt lại mật khẩu đến hộp thư của bạn.</p>
    </div>

    {{-- Icon minh họa --}}
    <div style="
        width: 64px; height: 64px;
        background: var(--primary-light);
        border-radius: 16px;
        display: flex; align-items: center; justify-content: center;
        margin-bottom: 24px;
    ">
        <i class="fa-solid fa-key" style="font-size:26px;color:var(--primary);"></i>
    </div>

    <form method="POST" action="{{ url('/forgot-password') }}" id="forgot-form" novalidate>
        @csrf

        {{-- Email --}}
        <div class="form-group">
            <label for="forgot-email">Địa chỉ Email</label>
            <div class="input-wrap">
                <i class="fa-solid fa-envelope input-icon"></i>
                <input
                    type="email"
                    id="forgot-email"
                    name="email"
                    placeholder="email@kineticmotors.com"
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

        {{-- Thông báo thành công --}}
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                <i class="fa-solid fa-circle-check"></i>
                <span>{{ session('status') }}</span>
            </div>
        @endif

        {{-- Steps guide --}}
        <div style="
            background: var(--primary-light);
            border-radius: 10px;
            padding: 14px 16px;
            margin-bottom: 20px;
            display: flex;
            flex-direction: column;
            gap: 8px;
        ">
            <div style="font-size:11.5px;font-weight:700;color:var(--primary);letter-spacing:.4px;margin-bottom:2px;">
                QUY TRÌNH ĐẶT LẠI
            </div>
            @foreach([
                ['fa-envelope', 'Nhập email tài khoản của bạn'],
                ['fa-inbox',    'Kiểm tra hộp thư đến (và spam)'],
                ['fa-link',     'Nhấn link đặt lại trong email'],
                ['fa-lock',     'Tạo mật khẩu mới và đăng nhập'],
            ] as $step)
            <div style="display:flex;align-items:center;gap:9px;font-size:12.5px;color:#1e40af;">
                <i class="fa-solid fa-{{ $step[0] }}" style="width:15px;text-align:center;font-size:12px;flex-shrink:0;"></i>
                {{ $step[1] }}
            </div>
            @endforeach
        </div>

        {{-- Submit --}}
        <button type="submit" class="btn-auth" id="btn-forgot">
            <i class="fa-solid fa-paper-plane"></i>
            Gửi link đặt lại mật khẩu
        </button>

    </form>

</div>

{{-- Trạng thái: đã gửi email (demo JS) --}}
<div id="step-sent" style="display:none; text-align:center;">
    <div style="
        width: 72px; height: 72px;
        background: #d1fae5;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 20px;
    ">
        <i class="fa-solid fa-circle-check" style="font-size:32px;color:#059669;"></i>
    </div>

    <h2 style="font-size:20px;font-weight:800;color:var(--text-primary);margin-bottom:10px;">Email đã được gửi!</h2>
    <p style="font-size:13.5px;color:var(--text-secondary);line-height:1.6;margin-bottom:24px;">
        Chúng tôi đã gửi link đặt lại mật khẩu đến<br>
        <strong id="sent-email" style="color:var(--text-primary);"></strong>.<br>
        Vui lòng kiểm tra hộp thư (kể cả thư mục spam).
    </p>

    <button class="btn-auth" onclick="goBack()" style="margin-bottom:14px;">
        <i class="fa-solid fa-rotate-left"></i> Gửi lại email khác
    </button>

    <div style="font-size:12.5px;color:var(--text-muted);margin-top:6px;">
        Không nhận được email? Hãy chờ vài phút và thử lại.
    </div>
</div>

<div class="auth-footer-link" style="margin-top:24px;">
    <a href="{{ url('/login') }}" style="display:inline-flex;align-items:center;gap:6px;">
        <i class="fa-solid fa-arrow-left" style="font-size:12px;"></i>
        Quay lại đăng nhập
    </a>
</div>

@endsection

@section('scripts')
<script>
(function(){
    'use strict';

    const form      = document.getElementById('forgot-form');
    const stepEmail = document.getElementById('step-email');
    const stepSent  = document.getElementById('step-sent');
    const sentEmail = document.getElementById('sent-email');
    const btn       = document.getElementById('btn-forgot');

    form.addEventListener('submit', function(e){
        const emailVal = document.getElementById('forgot-email').value.trim();
        if(!emailVal) return;

        /* Demo: ngăn form submit thật, hiển thị bước 2 */
        /* Khi có backend thật, xóa e.preventDefault() dưới đây */
        e.preventDefault();

        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Đang gửi...';
        btn.disabled  = true;

        setTimeout(() => {
            sentEmail.textContent = emailVal;
            stepEmail.style.display = 'none';
            stepSent.style.display  = 'block';
        }, 1200);
    });

    window.goBack = function(){
        stepSent.style.display  = 'none';
        stepEmail.style.display = 'block';
        btn.innerHTML = '<i class="fa-solid fa-paper-plane"></i> Gửi link đặt lại mật khẩu';
        btn.disabled  = false;
        document.getElementById('forgot-email').value = '';
    };
})();
</script>
@endsection
