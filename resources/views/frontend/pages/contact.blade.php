@extends('layouts.frontend')

@section('title', 'Liên hệ')

@section('content')
<div class="container">
    <!-- Hero Section -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="contact-hero p-5 rounded-4 text-white text-center" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); position: relative; overflow: hidden;">
                <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(255,255,255,0.1); backdrop-filter: blur(10px);"></div>
                <div style="position: relative; z-index: 2;">
                    <h1 class="display-3 fw-bold mb-3">Liên hệ với chúng tôi</h1>
                    <p class="lead fs-4">Chúng tôi luôn sẵn sàng lắng nghe và hỗ trợ bạn</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Contact Form -->
        <div class="col-lg-7 mb-4">
            <div class="glass-card p-4 rounded-4" style="background: rgba(255,255,255,0.7); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.3); box-shadow: 0 8px 32px rgba(0,0,0,0.1);">
                <h3 class="fw-bold mb-4">Gửi tin nhắn cho chúng tôi</h3>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form action="{{ route('contact.send') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold">Họ và tên <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="subject" class="form-label fw-semibold">Tiêu đề <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('subject') is-invalid @enderror" id="subject" name="subject" value="{{ old('subject') }}" required>
                        @error('subject')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="message" class="form-label fw-semibold">Nội dung <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('message') is-invalid @enderror" id="message" name="message" rows="5" required>{{ old('message') }}</textarea>
                        @error('message')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg w-100" style="background: linear-gradient(135deg, #667eea, #764ba2); border: none; border-radius: 12px;">
                        <i class="fas fa-paper-plane me-2"></i>Gửi tin nhắn
                    </button>
                </form>
            </div>
        </div>

        <!-- Contact Info -->
        <div class="col-lg-5 mb-4">
            <div class="glass-card p-4 rounded-4 mb-4" style="background: rgba(255,255,255,0.7); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.3); box-shadow: 0 8px 32px rgba(0,0,0,0.1);">
                <h3 class="fw-bold mb-4">Thông tin liên hệ</h3>

                <div class="contact-item d-flex align-items-start mb-4">
                    <div class="icon-box me-3" style="min-width: 50px; height: 50px; background: linear-gradient(135deg, #667eea, #764ba2); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-map-marker-alt text-white fs-5"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-1">Địa chỉ</h5>
                        <p class="text-muted mb-0">Tân Bình, Thành phố Hồ Chí Minh</p>
                    </div>
                </div>

                <div class="contact-item d-flex align-items-start mb-4">
                    <div class="icon-box me-3" style="min-width: 50px; height: 50px; background: linear-gradient(135deg, #764ba2, #f093fb); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-phone text-white fs-5"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-1">Điện thoại</h5>
                        <p class="text-muted mb-0">
                            <a href="tel:0343935487" class="text-decoration-none text-muted">0343935487</a>
                        </p>
                    </div>
                </div>

                <div class="contact-item d-flex align-items-start mb-4">
                    <div class="icon-box me-3" style="min-width: 50px; height: 50px; background: linear-gradient(135deg, #f093fb, #f5576c); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-envelope text-white fs-5"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-1">Email</h5>
                        <p class="text-muted mb-0">
                            <a href="mailto:hoquy902@gmail.com" class="text-decoration-none text-muted">hoquy902@gmail.com</a>
                        </p>
                    </div>
                </div>

                <div class="contact-item d-flex align-items-start">
                    <div class="icon-box me-3" style="min-width: 50px; height: 50px; background: linear-gradient(135deg, #667eea, #764ba2); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-clock text-white fs-5"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-1">Giờ làm việc</h5>
                        <p class="text-muted mb-0">Thứ 2 - Thứ 7: 8:00 - 20:00</p>
                        <p class="text-muted mb-0">Chủ nhật: 9:00 - 18:00</p>
                    </div>
                </div>
            </div>

            <!-- Social Media -->
            <div class="glass-card p-4 rounded-4" style="background: rgba(255,255,255,0.7); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.3); box-shadow: 0 8px 32px rgba(0,0,0,0.1);">
                <h5 class="fw-bold mb-3">Kết nối với chúng tôi</h5>
                <div class="d-flex gap-2">
                    <a href="#" class="social-btn" style="width: 50px; height: 50px; background: #3b5998; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; text-decoration: none; transition: transform 0.3s;">
                        <i class="fab fa-facebook-f fs-5"></i>
                    </a>
                    <a href="#" class="social-btn" style="width: 50px; height: 50px; background: #E4405F; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; text-decoration: none; transition: transform 0.3s;">
                        <i class="fab fa-instagram fs-5"></i>
                    </a>
                    <a href="#" class="social-btn" style="width: 50px; height: 50px; background: #1DA1F2; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; text-decoration: none; transition: transform 0.3s;">
                        <i class="fab fa-twitter fs-5"></i>
                    </a>
                    <a href="#" class="social-btn" style="width: 50px; height: 50px; background: #0077b5; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; text-decoration: none; transition: transform 0.3s;">
                        <i class="fab fa-linkedin-in fs-5"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Map Section (Optional) -->
    <div class="row mt-4 mb-5">
        <div class="col-12">
            <div class="glass-card p-4 rounded-4" style="background: rgba(255,255,255,0.7); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.3); box-shadow: 0 8px 32px rgba(0,0,0,0.1);">
                <h3 class="fw-bold mb-4">Vị trí của chúng tôi</h3>
                <div class="ratio ratio-21x9">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15677.858932721707!2d106.62525494999998!3d10.802032249999998!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x317529111aa89f9d%3A0xd8f09cc0aa1b27f3!2zVMOibiBCw6xuaCwgVGjDoG5oIHBo4buRIEjhu5MgQ2jDrSBNaW5oLCBWaeG7h3QgTmFt!5e0!3m2!1svi!2s!4v1234567890123!5m2!1svi!2s" 
                            style="border:0; border-radius: 12px;" 
                            allowfullscreen="" 
                            loading="lazy" 
                            referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .social-btn:hover {
        transform: translateY(-5px);
    }
</style>
@endsection
