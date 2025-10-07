<?php
// $banners may be passed; use the first banner if present
$banner = isset($banners) && $banners->count() ? $banners->first() : null;

// Determine image source for banner when available
$imgSrc = null;
if ($banner) {
    $imgSrc = $banner->image_url;
    if (!$imgSrc && $banner->image_path) {
        $imgSrc = asset('storage/' . $banner->image_path);
    }
}

?>

<style>
    /* Hide caption by default; reveal on hover/focus */
    .banner-caption { opacity:0; transform: translateY(8px); transition: opacity .28s ease, transform .36s cubic-bezier(.2,.9,.2,1); pointer-events:none; }
    .banner-media { position:relative; }
    .banner-media:hover .banner-caption, .banner-media:focus-within .banner-caption, .carousel-item:hover .banner-caption, .carousel-item:focus-within .banner-caption { opacity:1; transform: translateY(0); pointer-events:auto; }
    @media (max-width:768px) { .banner-caption { opacity:1; transform:none; pointer-events:auto; } }
</style>

<style>
    /* Banner responsive layout */
    .banner-card { background:#fff; border-radius:10px; max-width:1220px; width:100%; overflow:hidden; }
    .banner-media { position:relative; }
    .banner-img { width:100%; display:block; object-fit:contain; }

    /* Preferred heights across breakpoints (use viewport height but keep limits)
       - large: taller hero, medium: slightly shorter, small: natural image height
    */
    .banner-img { height: min(460px, 60vh); }
    @media (max-width:1200px) { .banner-img { height: min(420px, 55vh); } }
    @media (max-width:992px) { .banner-img { height: min(360px, 50vh); } }
    @media (max-width:768px) { .banner-img { height: auto; padding:10px; object-fit:contain; } .banner-card { border-radius:8px; } }

    /* Caption: hidden by default on pointer devices, visible on hover/focus with smooth animation */
    .banner-caption { opacity:0; transform: translateY(8px); transition: opacity .28s ease, transform .36s cubic-bezier(.2,.9,.2,1); pointer-events:none; }
    .banner-media:hover .banner-caption, .banner-media:focus-within .banner-caption, .carousel-item:hover .banner-caption, .carousel-item:focus-within .banner-caption { opacity:1; transform: translateY(0); pointer-events:auto; }

    /* On small screens, make caption flow below image (no overlay) for readability */
    @media (max-width:768px) {
        .banner-caption { position:relative !important; left:auto !important; bottom:auto !important; width:100% !important; max-width:100% !important; padding:12px !important; margin-top:-6px; border-radius:0 0 6px 6px !important; opacity:1 !important; transform:none !important; pointer-events:auto !important; }
        .carousel-indicators { bottom: 6px; }
    }
</style>

<?php if(isset($banners) && $banners->count() > 1): ?>
    <div id="homepageBannersCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000" data-bs-pause="hover">
        <div class="carousel-indicators">
            <?php $__currentLoopData = $banners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $ignored): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <button type="button" data-bs-target="#homepageBannersCarousel" data-bs-slide-to="<?php echo e($i); ?>" class="<?php echo e($i === 0 ? 'active' : ''); ?>" aria-current="<?php echo e($i === 0 ? 'true' : 'false'); ?>" aria-label="Slide <?php echo e($i + 1); ?>"></button>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <div class="carousel-inner">
            <?php $__currentLoopData = $banners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $img = $b->image_url;
                    if (!$img && $b->image_path) {
                        $img = asset('storage/' . $b->image_path);
                    }
                ?>

                <div class="carousel-item <?php echo e($index === 0 ? 'active' : ''); ?>">
                    <section class="hero-section position-relative text-white py-5" style="overflow:visible; background: #0e2a47;">
                        <div class="position-absolute top-0 start-0 w-100 h-100" style="background: rgba(0,0,0,0.08); z-index:1;"></div>
                        <div class="container position-relative d-flex justify-content-center" style="z-index:2;">
                            <div class="card p-0 banner-card">
                                <div class="d-flex align-items-center w-100">
                                    
                                    <?php if($img): ?>
                                        <div class="banner-media" style="position:relative; width:100%;">
                                            <?php if($b->link): ?>
                                                <a href="<?php echo e($b->link); ?>" class="w-100 d-block">
                                                    <img loading="lazy" src="<?php echo e($img); ?>" alt="<?php echo e($b->title ?? 'Banner'); ?>" class="banner-img img-fluid mx-auto d-block" />
                                                </a>
                                            <?php else: ?>
                                                <img loading="lazy" src="<?php echo e($img); ?>" alt="<?php echo e($b->title ?? 'Banner'); ?>" class="banner-img img-fluid mx-auto d-block" />
                                            <?php endif; ?>

                                            
                                            <div class="banner-caption" style="position:absolute; left:0; bottom:0; z-index:3; padding:20px; color:#fff; max-width:60%; width:100%; background: linear-gradient(90deg, rgba(14,42,71,0.72) 0%, rgba(14,42,71,0.32) 60%, rgba(14,42,71,0.08) 100%);">
                                                <?php if($b->title): ?>
                                                    <h3 class="mb-1" style="color:#fff; font-weight:600; font-size:1.5rem;"><?php echo e($b->title); ?></h3>
                                                <?php endif; ?>
                                                <?php if(!empty($b->subtitle)): ?>
                                                    <p class="mb-2" style="color:rgba(255,255,255,0.92);"><?php echo e($b->subtitle); ?></p>
                                                <?php endif; ?>
                                                <?php if($b->link): ?>
                                                    <a href="<?php echo e($b->link); ?>" class="btn btn-primary btn-sm">Xem ngay</a>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <div style="width:100%; height:260px; display:flex; align-items:center; justify-content:center;">
                                            <div class="text-center">
                                                <h3 class="mb-0">HNQ BookStore</h3>
                                                <p class="small mb-0">Khám phá bộ sưu tập sách của chúng tôi</p>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#homepageBannersCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#homepageBannersCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>

        
        <script>
            (function(){
                document.addEventListener('DOMContentLoaded', function(){
                    var carouselEl = document.getElementById('homepageBannersCarousel');
                    if (!carouselEl) return;

                    if (typeof bootstrap === 'undefined' || typeof bootstrap.Carousel === 'undefined'){
                        var items = carouselEl.querySelectorAll('.carousel-item');
                        var idx = 0;
                        items.forEach(function(it, i){ if (i!==0) it.classList.remove('active'); else it.classList.add('active'); });

                        var intervalMs = 5000;
                        var intervalId = setInterval(nextSlide, intervalMs);

                        function nextSlide(){
                            items[idx].classList.remove('active');
                            idx = (idx + 1) % items.length;
                            items[idx].classList.add('active');
                        }

                        // Pause on hover
                        carouselEl.addEventListener('mouseenter', function(){ clearInterval(intervalId); });
                        carouselEl.addEventListener('mouseleave', function(){ intervalId = setInterval(nextSlide, intervalMs); });

                        // Indicators click support for fallback
                        var indicators = carouselEl.querySelectorAll('.carousel-indicators [data-bs-slide-to]');
                        indicators.forEach(function(btn){
                            btn.addEventListener('click', function(e){
                                var to = parseInt(btn.getAttribute('data-bs-slide-to') || '0', 10);
                                items[idx].classList.remove('active');
                                idx = to % items.length;
                                items[idx].classList.add('active');
                                // reset interval
                                clearInterval(intervalId);
                                intervalId = setInterval(nextSlide, intervalMs);
                            });
                        });
                    }
                });
            })();
        </script>
    </div>
<?php else: ?>
    
    <div class="container d-flex justify-content-center">
    <div class="card p-0 banner-card">
                <?php if($imgSrc): ?>
                    <div class="banner-media" style="position:relative; width:100%;">
                                <?php if($banner && $banner->link): ?>
                            <a href="<?php echo e($banner->link); ?>">
                                <img loading="lazy" src="<?php echo e($imgSrc); ?>" alt="<?php echo e($banner->title ?? 'Banner'); ?>" class="banner-img img-fluid mx-auto d-block" style="border-radius:6px;" />
                            </a>
                        <?php else: ?>
                            <img loading="lazy" src="<?php echo e($imgSrc); ?>" alt="<?php echo e($banner->title ?? 'Banner'); ?>" class="banner-img img-fluid mx-auto d-block" style="border-radius:6px;" />
                        <?php endif; ?>

                        
                        <div class="banner-caption" style="position:absolute; left:0; bottom:0; z-index:3; padding:18px; color:#fff; max-width:60%; width:100%; background: linear-gradient(90deg, rgba(14,42,71,0.72) 0%, rgba(14,42,71,0.32) 60%, rgba(14,42,71,0.08) 100%); border-bottom-left-radius:6px;">
                            <?php if($banner && $banner->title): ?>
                                <h3 class="mb-1" style="color:#fff; font-weight:600; font-size:1.25rem;"><?php echo e($banner->title); ?></h3>
                            <?php endif; ?>
                            <?php if($banner && !empty($banner->subtitle)): ?>
                                <p class="mb-2" style="color:rgba(255,255,255,0.9);"><?php echo e($banner->subtitle); ?></p>
                            <?php endif; ?>
                            <?php if($banner && $banner->link): ?>
                                <a href="<?php echo e($banner->link); ?>" class="btn btn-primary btn-sm">Xem ngay</a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php else: ?>
                <div style="width:100%; height:260px; display:flex; align-items:center; justify-content:center;">
                    <div class="text-center">
                        <h3 class="mb-0">HNQ BookStore</h3>
                        <p class="small mb-0">Khám phá bộ sưu tập sách của chúng tôi</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\webbansach\laravel-app\resources\views/frontend/partials/banner.blade.php ENDPATH**/ ?>