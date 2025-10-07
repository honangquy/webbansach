@extends('layouts.app')

@section('content')
@push('styles')
<style>
    /* Liquid Glass Style Background */
    .auth-bg {
        position: fixed;
        inset: 0;
        z-index: 0;
        background-image: url('https://mnismt.com/_next/static/media/background.ae46ac39.png');
        background-position: center center;
        background-repeat: no-repeat;
        background-size: cover;
        /* soft blur + slight tone adjustment to match reset page */
        filter: blur(6px) brightness(0.92) saturate(1.05);
    }

    /* Dark overlay to improve legibility (keeps backdrop blur) */
    .auth-overlay {
        position: fixed;
        inset: 0;
        z-index: 1;
        background: rgba(0,0,0,0.32);
        backdrop-filter: blur(6px) saturate(110%);
        -webkit-backdrop-filter: blur(6px) saturate(110%);
        pointer-events: none;
    }

    @keyframes gradientShift {
        0%, 100% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
    }

    .glass-card {
        position: relative;
        z-index: 2;
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(20px) saturate(180%);
        -webkit-backdrop-filter: blur(20px) saturate(180%);
        border-radius: 24px;
        border: 1px solid rgba(255, 255, 255, 0.3);
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3),
                    inset 0 1px 0 rgba(255, 255, 255, 0.6);
        padding: 40px;
        max-width: 480px;
        margin: 10vh auto;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .glass-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 30px 80px rgba(0, 0, 0, 0.4),
                    inset 0 1px 0 rgba(255, 255, 255, 0.6);
    }

    .glass-title {
        font-size: 2rem;
        font-weight: 800;
        text-align: center;
        background: linear-gradient(135deg, #ffffff 0%, #f0f0f0 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 12px;
        text-shadow: 0 2px 20px rgba(255, 255, 255, 0.3);
    }

    .glass-subtitle {
        text-align: center;
        color: rgba(255, 255, 255, 0.9);
        margin-bottom: 32px;
        font-size: 0.95rem;
        line-height: 1.6;
    }

    .form-group-glass {
        margin-bottom: 24px;
        position: relative;
    }

    .input-glass {
        width: 100%;
        padding: 16px 16px 16px 48px;
        background: rgba(255, 255, 255, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.3);
        border-radius: 16px;
        color: #ffffff;
        font-size: 15px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        backdrop-filter: blur(10px);
    }

    .input-glass::placeholder {
        color: rgba(255, 255, 255, 0.6);
    }

    .input-glass:focus {
        outline: none;
        background: rgba(255, 255, 255, 0.25);
        border-color: rgba(255, 255, 255, 0.5);
        box-shadow: 0 8px 32px rgba(255, 255, 255, 0.1);
    }

    .input-icon {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        width: 20px;
        height: 20px;
        opacity: 0.8;
    }

    .btn-glass {
        width: 100%;
        padding: 16px;
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.3), rgba(255, 255, 255, 0.2));
        border: 1px solid rgba(255, 255, 255, 0.4);
        border-radius: 16px;
        /* dark text to improve contrast on the light glass button */
        color: #1f2937;
        font-weight: 700;
        font-size: 16px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        backdrop-filter: blur(10px);
        cursor: pointer;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .btn-glass:hover {
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.4), rgba(255, 255, 255, 0.3));
        transform: translateY(-2px);
        box-shadow: 0 12px 40px rgba(255, 255, 255, 0.2);
    }

    .alert-glass {
        background: rgba(76, 175, 80, 0.2);
        border: 1px solid rgba(76, 175, 80, 0.4);
        border-radius: 12px;
        padding: 16px;
        color: #ffffff;
        margin-bottom: 24px;
        backdrop-filter: blur(10px);
    }

    .error-text {
        color: rgba(255, 100, 100, 1);
        font-size: 13px;
        margin-top: 8px;
        display: block;
    }

    .link-glass {
        color: rgba(255, 255, 255, 0.9);
        text-decoration: none;
        transition: all 0.3s;
        font-weight: 600;
    }

    .link-glass:hover {
        color: #ffffff;
        text-shadow: 0 0 20px rgba(255, 255, 255, 0.5);
    }

    .brand-logo {
        text-align: center;
        margin-bottom: 24px;
    }

    .brand-name {
        font-size: 1.5rem;
        font-weight: 900;
        background: linear-gradient(135deg, #ffffff 0%, #e0e0e0 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    @media (max-width: 768px) {
        .glass-card {
            margin: 6vh 16px;
            padding: 28px 20px;
        }
        .glass-title { font-size: 1.5rem; }
    }
</style>
@endpush

<div class="auth-bg"></div>
<div class="auth-overlay" aria-hidden="true"></div>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="glass-card">
                <div class="brand-logo">
                    <div class="brand-name">HNQ BookStore</div>
                </div>

                <h3 class="glass-title">Quên mật khẩu?</h3>
                <p class="glass-subtitle">
                    Không sao cả! Nhập email của bạn và chúng tôi sẽ gửi link đặt lại mật khẩu.
                </p>

                @if (session('status'))
                    <div class="alert-glass">
                        <i class="fas fa-check-circle"></i> {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <div class="form-group-glass">
                        <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="5" width="18" height="14" rx="2" />
                            <path d="M3 7l9 6 9-6" />
                        </svg>
                        <input id="email" type="email" 
                               class="input-glass @error('email') is-invalid @enderror" 
                               name="email" 
                               value="{{ old('email') }}" 
                               required 
                               autocomplete="email" 
                               autofocus 
                               placeholder="Email của bạn">
                        @error('email')
                            <span class="error-text">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <button type="submit" class="btn-glass">
                        <i class="fas fa-paper-plane"></i> Gửi link đặt lại mật khẩu
                    </button>

                    <div class="text-center mt-4">
                        <a href="{{ route('login') }}" class="link-glass">
                            <i class="fas fa-arrow-left"></i> Quay lại đăng nhập
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
