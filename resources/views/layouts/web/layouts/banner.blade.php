<section id="banner"
    style="background-image: url('{{ asset('assets/web/images/banner-1.jpg') }}');background-repeat: no-repeat;background-size: cover;">
    <div class="container-lg">
        <div class="row">
            <div class="col-lg-6 pt-5 mt-5">
                <h2 class="display-1 ls-1"><span class="fw-bold text-primary">Organic</span> Thực Phẩm Chất <span
                        class="fw-bold">Ngon Ngất Ngây</span></h2>
                <p class="fs-4">Đặt hàng hôm nay để nhận nhiều ưu đãi</p>
                <div class="d-flex gap-3">
                    <a href="{{ route('products.all') }}"
                        class="btn btn-primary text-uppercase fs-6 rounded-pill px-4 py-3 mt-3">Mua ngay</a>
                    <a href="#" class="btn btn-dark text-uppercase fs-6 rounded-pill px-4 py-3 mt-3">Tham quan cửa
                        hàng</a>
                </div>
                <div class="row my-5">
                    <div class="col">
                        <div class="row text-dark">
                            <div class="col-auto">
                                <p class="fs-1 fw-bold lh-sm mb-0">14k+</p>
                            </div>
                            <div class="col">
                                <p class="text-uppercase lh-sm mb-0">Các dòng sản phẩm</p>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="row text-dark">
                            <div class="col-auto">
                                <p class="fs-1 fw-bold lh-sm mb-0">50k+</p>
                            </div>
                            <div class="col">
                                <p class="text-uppercase lh-sm mb-0">Khách hàng hài lòng</p>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="row text-dark">
                            <div class="col-auto">
                                <p class="fs-1 fw-bold lh-sm mb-0">10+</p>
                            </div>
                            <div class="col">
                                <p class="text-uppercase lh-sm mb-0">Ship hàng tận nơi</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row row-cols-1 row-cols-sm-3 row-cols-lg-3 g-0 justify-content-center">
            <div class="col">
                <div class="card border-0 bg-primary rounded-0 p-4 text-light">
                    <div class="row">
                        <div class="col-md-3 text-center">
                            <svg width="60" height="60">
                                <use xlink:href="#fresh"></use>
                            </svg>
                        </div>
                        <div class="col-md-9">
                            <div class="card-body p-0">
                                <h5 class="text-light">Tươi ngon từ nông trại</h5>
                                <p class="card-text">Chúng tôi mang đến thực phẩm sạch, an toàn và tròn vị thiên nhiên.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card border-0 bg-secondary rounded-0 p-4 text-light">
                    <div class="row">
                        <div class="col-md-3 text-center">
                            <svg width="60" height="60">
                                <use xlink:href="#organic"></use>
                            </svg>
                        </div>
                        <div class="col-md-9">
                            <div class="card-body p-0">
                                <h5 class="text-light">100% Hữu Cơ</h5>
                                <p class="card-text">Sản phẩm hữu cơ được chứng nhận, trồng tự nhiên không sử dụng hóa
                                    chất độc hại.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card border-0 bg-danger rounded-0 p-4 text-light">
                    <div class="row">
                        <div class="col-md-3 text-center">
                            <svg width="60" height="60">
                                <use xlink:href="#delivery"></use>
                            </svg>
                        </div>
                        <div class="col-md-9">
                            <div class="card-body p-0">
                                <h5 class="text-light">Giao hàng mọi nơi</h5>
                                <p class="card-text">Giao hàng nhanh chóng, tận nơi mọi trong khu vực.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- slider -->
<div class="carousel">
    <div class="list">
        <div class="item active"
            style="
            --img-src: url('{{asset('assets/web/images/images/item1.png')}}');
            --bg-color: #428372;
            --title: 'Lemon'
            ">
            <div class="content">
                <div class="image"></div>
                <div class="info">
                    <div class="title">
                         Nước Giải Khát Vị Chanh
                    </div>
                    <div class="category">
                        Đồ Uống Trái Cây
                    </div>
                    <div class="des">
                        Thưởng thức hương vị tươi mát tự nhiên của nước giải khát vị chanh, được làm từ nguyên liệu sạch và hữu cơ, giúp bạn giải khát và bổ sung năng lượng cho ngày dài.
                    </div>
                    <a href="">
                        See More
                        <span>&#8594</span>
                    </a>
                </div>
            </div>
        </div>
        <div class="item"
            style="
            --img-src: url('{{asset('assets/web/images/images/item2.png')}}');
            --bg-color: #EEAA19;
            --title: 'Orange'
            ">
            <div class="content">
                <div class="image"></div>
                <div class="info">
                    <div class="title">
                        Nước Giải Khát Vị Cam
                    </div>
                    <div class="category">
                        Đồ Uống Trái Cây
                    </div>
                    <div class="des">
                        Cùng “bung lụa” với vị cam chua ngọt siêu hấp dẫn, đánh thức mọi giác quan và khiến ngày dài thêm sảng khoái, vui nhộn hơn bao giờ hết!
                    </div>
                    <a href="">
                        See More
                        <span>&#8594</span>
                    </a>
                </div>
            </div>
        </div>
        <div class="item"
            style="
            --img-src: url('{{asset('assets/web/images/images/item3.png')}}');
            --bg-color: #e86c3f;
            --title: 'Apple'
            ">
            <div class="content">
                <div class="image"></div>
                <div class="info">
                    <div class="title">
                         Nước Giải Khát Vị Cam
                    </div>
                    <div class="category">
                         Đồ Uống Trái Cây
                    </div>
                    <div class="des">
                        Hương vị cam tươi mát, tự nhiên trong từng ngụm nước giải khát được làm từ nguyên liệu sạch, giúp bạn luôn sảng khoái và tràn đầy năng lượng suốt ngày dài.
                    </div>
                    <a href="">
                        See More
                        <span>&#8594</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="arrows">
        <button id="prev">
            << /button>
                <button id="next">></button>
    </div>
    <ul class="dots">
        <li class="active"></li>
        <li></li>
        <li></li>
    </ul>
</div>
<link rel="stylesheet" href="{{asset('assets/web/css/style_sider.css')}}">
<script src="{{asset('assets/web/js/app.js')}}"></script>
