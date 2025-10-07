@extends('layouts.frontend')

@section('title', 'Giới thiệu')

@section('content')
<div class="container">
    <!-- Hero Section -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="about-hero p-5 rounded-4 text-white text-center" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); position: relative; overflow: hidden;">
                <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(255,255,255,0.1); backdrop-filter: blur(10px);"></div>
                <div style="position: relative; z-index: 2;">
                    <h1 class="display-3 fw-bold mb-3">HNQ BookStore</h1>
                    <p class="lead fs-4">Nơi tri thức hội tụ, nơi đam mê được thỏa mãn</p>
                </div>
            </div>
        </div>
    </div>

    <!-- About Content -->
    <div class="row mb-5">
        <div class="col-lg-6 mb-4">
            <div class="glass-card h-100 p-4 rounded-4" style="background: rgba(255,255,255,0.7); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.3); box-shadow: 0 8px 32px rgba(0,0,0,0.1);">
                <div class="d-flex align-items-center mb-3">
                    <div class="icon-box me-3" style="width: 60px; height: 60px; background: linear-gradient(135deg, #667eea, #764ba2); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-book-open text-white fs-3"></i>
                    </div>
                    <h3 class="mb-0 fw-bold">Về chúng tôi</h3>
                </div>
                <p class="text-muted" style="line-height: 1.8;">
                    HNQ BookStore là cửa hàng sách trực tuyến hàng đầu Việt Nam, được thành lập với sứ mệnh mang tri thức đến gần hơn với mọi người. 
                    Chúng tôi tự hào cung cấp hàng ngàn đầu sách đa dạng từ văn học, kinh tế, đến công nghệ và thiếu nhi.
                </p>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <div class="glass-card h-100 p-4 rounded-4" style="background: rgba(255,255,255,0.7); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.3); box-shadow: 0 8px 32px rgba(0,0,0,0.1);">
                <div class="d-flex align-items-center mb-3">
                    <div class="icon-box me-3" style="width: 60px; height: 60px; background: linear-gradient(135deg, #667eea, #764ba2); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-bullseye text-white fs-3"></i>
                    </div>
                    <h3 class="mb-0 fw-bold">Sứ mệnh</h3>
                </div>
                <p class="text-muted" style="line-height: 1.8;">
                    Chúng tôi cam kết mang đến trải nghiệm mua sắm sách tốt nhất với giá cả hợp lý, 
                    dịch vụ chuyên nghiệp và giao hàng nhanh chóng. Mỗi cuốn sách là một hành trình, 
                    và chúng tôi muốn đồng hành cùng bạn trong hành trình khám phá tri thức.
                </p>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="row mb-5">
        <div class="col-12 mb-4">
            <h2 class="text-center fw-bold mb-4">Tại sao chọn chúng tôi?</h2>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
            <div class="feature-card text-center p-4 rounded-4 h-100" style="background: rgba(102, 126, 234, 0.1); border: 2px solid rgba(102, 126, 234, 0.2); transition: all 0.3s;">
                <div class="icon-circle mx-auto mb-3" style="width: 80px; height: 80px; background: linear-gradient(135deg, #667eea, #764ba2); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-shipping-fast text-white fs-2"></i>
                </div>
                <h4 class="fw-bold mb-3">Giao hàng nhanh</h4>
                <p class="text-muted">Giao hàng toàn quốc trong 2-5 ngày làm việc</p>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
            <div class="feature-card text-center p-4 rounded-4 h-100" style="background: rgba(118, 75, 162, 0.1); border: 2px solid rgba(118, 75, 162, 0.2); transition: all 0.3s;">
                <div class="icon-circle mx-auto mb-3" style="width: 80px; height: 80px; background: linear-gradient(135deg, #764ba2, #f093fb); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-shield-alt text-white fs-2"></i>
                </div>
                <h4 class="fw-bold mb-3">Bảo hành chất lượng</h4>
                <p class="text-muted">Đổi trả miễn phí trong 7 ngày nếu có lỗi</p>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
            <div class="feature-card text-center p-4 rounded-4 h-100" style="background: rgba(240, 147, 251, 0.1); border: 2px solid rgba(240, 147, 251, 0.2); transition: all 0.3s;">
                <div class="icon-circle mx-auto mb-3" style="width: 80px; height: 80px; background: linear-gradient(135deg, #f093fb, #f5576c); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-tags text-white fs-2"></i>
                </div>
                <h4 class="fw-bold mb-3">Giá tốt nhất</h4>
                <p class="text-muted">Cam kết giá rẻ nhất thị trường</p>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
            <div class="feature-card text-center p-4 rounded-4 h-100" style="background: rgba(102, 126, 234, 0.1); border: 2px solid rgba(102, 126, 234, 0.2); transition: all 0.3s;">
                <div class="icon-circle mx-auto mb-3" style="width: 80px; height: 80px; background: linear-gradient(135deg, #667eea, #764ba2); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-headset text-white fs-2"></i>
                </div>
                <h4 class="fw-bold mb-3">Hỗ trợ 24/7</h4>
                <p class="text-muted">Đội ngũ CSKH luôn sẵn sàng hỗ trợ bạn</p>
            </div>
        </div>
    </div>

    <!-- Stats Section -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="stats-section p-5 rounded-4 text-white text-center" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <div class="stat-item">
                            <h2 class="display-4 fw-bold mb-2">10K+</h2>
                            <p class="mb-0">Đầu sách</p>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="stat-item">
                            <h2 class="display-4 fw-bold mb-2">50K+</h2>
                            <p class="mb-0">Khách hàng</p>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="stat-item">
                            <h2 class="display-4 fw-bold mb-2">100K+</h2>
                            <p class="mb-0">Đơn hàng</p>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="stat-item">
                            <h2 class="display-4 fw-bold mb-2">99%</h2>
                            <p class="mb-0">Hài lòng</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Team Section (Optional) -->
    <div class="row mb-5">
        <div class="col-12 mb-4">
            <h2 class="text-center fw-bold mb-2">Đội ngũ của chúng tôi</h2>
            <p class="text-center text-muted">Những người đam mê sách và tri thức</p>
        </div>

        <div class="col-lg-4 col-md-6 mb-4">
            <div class="team-card text-center p-4 rounded-4" style="background: rgba(255,255,255,0.7); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.3); box-shadow: 0 8px 32px rgba(0,0,0,0.1);">
                <div class="avatar mx-auto mb-3" style="width: 120px; height: 120px; background: linear-gradient(135deg, #667eea, #764ba2); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-user text-white" style="font-size: 3rem;"></i>
                </div>
                <h4 class="fw-bold mb-2">Hồ Quý</h4>
                <p class="text-muted mb-2">Founder & CEO</p>
                <p class="small text-muted">Người sáng lập với đam mê mang sách đến gần mọi người</p>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 mb-4">
            <div class="team-card text-center p-4 rounded-4" style="background: rgba(255,255,255,0.7); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.3); box-shadow: 0 8px 32px rgba(0,0,0,0.1);">
                <div class="avatar mx-auto mb-3" style="width: 120px; height: 120px; background: linear-gradient(135deg, #764ba2, #f093fb); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-user text-white" style="font-size: 3rem;"></i>
                </div>
                <h4 class="fw-bold mb-2">Nguyễn Văn A</h4>
                <p class="text-muted mb-2">Giám đốc vận hành</p>
                <p class="small text-muted">Chuyên gia về logistics và quản lý chuỗi cung ứng</p>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 mb-4">
            <div class="team-card text-center p-4 rounded-4" style="background: rgba(255,255,255,0.7); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.3); box-shadow: 0 8px 32px rgba(0,0,0,0.1);">
                <div class="avatar mx-auto mb-3" style="width: 120px; height: 120px; background: linear-gradient(135deg, #f093fb, #f5576c); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-user text-white" style="font-size: 3rem;"></i>
                </div>
                <h4 class="fw-bold mb-2">Trần Thị B</h4>
                <p class="text-muted mb-2">Trưởng phòng CSKH</p>
                <p class="small text-muted">Luôn lắng nghe và giải quyết mọi thắc mắc của khách hàng</p>
            </div>
        </div>
    </div>
</div>

<style>
    .feature-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 12px 48px rgba(102, 126, 234, 0.3) !important;
    }

    .team-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .team-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 60px rgba(0,0,0,0.2) !important;
    }
</style>
@endsection
