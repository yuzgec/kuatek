<div class="notification text-center" style="background-image: url(/frontend/assets/images/notification-back.jpg)">
    <div class="notify-content">
        <h3>{{CARGO_LIMIT}}₺ ve üzeri tüm siparişlerinizde Türkiye'nin her yerine ücretsiz kargo!</h3>
    </div>
    <div class="notify-action">
        <a href="#"><i class="icon-close  d-none d-lg-block"></i></a>
    </div>
</div>
<header class="header header-2 header-intro-clearance">

    <div class="header-middle">
        <div class="container">
            <div class="header-left">
                <button class="mobile-menu-toggler">
                    <span class="sr-only">Toggle mobile menu</span>
                    <i class="icon-bars"></i>
                </button>

                <a href="{{ route('home') }}" class="logo">
                    <img src="{{asset('/frontend/assets/images/logo.jpg')}}" width="200px">
                </a>
            </div>

            <div class="header-center">
                <div class="header-search header-search-extended header-search-visible d-none d-lg-block">
                    <a href="#" class="search-toggle" role="button"><i class="icon-search"></i></a>
                    <form action="{{ route('search') }}" method="get">
                        <div class="header-search-wrapper search-wrapper-wide">
                            <label for="q" class="sr-only">Arama</label>
                            <input type="search" class="form-control" name="q" asd placeholder="Ürün Ara ..." required>
                            <button class="btn btn-primary" type="submit"><i class="icon-search"></i></button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="header-right">
                @guest
                <div class="account">
                    <a href="{{ route('register') }}" title="Hesabım">
                        <div class="icon">
                            <i class="icon-user"></i>
                        </div>
                        <p>Üye&nbsp;Ol</p>
                    </a>
                    <div class="wishlist">
                        <a href="{{ route('login') }}" title="Kayıt Ol">
                            <div class="icon">
                                <i class="icon-user"></i>
                            </div>
                            <p>Giriş&nbsp;Yap</p>
                        </a>
                    </div>
                </div>
                @endguest
                @auth
                    <div class="account">
                        <a href="{{ route('profilim') }}" title="Hesabım">
                            <img src="https://ui-avatars.com/api/?background=1a62b4&color=fff&size=48&rounded=true&name={{auth()->user()->name}}" class="rounded">
                        </a>
                    </div>
                @endauth
               <div class="wishlist d-none d-sm-block">
                    <a href="{{ route('favori') }}" title="Wishlist" >
                        <div class="icon ">
                            <i class="icon-heart-o"></i>
                            @guest
                                <span class="wishlist-count badge">0</span>
                            @endguest
                            @auth
                                <span class="wishlist-count badge">{{ \App\Models\Favorite::where('user_id', auth()->user()->id)->count()  }}</span>
                            @endauth
                        </div>
                        <p>Favori</p>
                    </a>
                </div>

                <div class="dropdown cart-dropdown">
                    <a href="#" class="dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
                        <div class="icon">
                            <i class="icon-shopping-cart"></i>
                            <span class="cart-count">{{ Cart::instance('shopping')->content()->count() }}</span>
                        </div>
                        <p>Sepetim</p>
                    </a>

                    @if (Cart::content()->count() > 0)
                        <div class="dropdown-menu dropdown-menu-right">
                            <div class="dropdown-cart-products">
                                @foreach(Cart::content() as $c)

                                    <div class="product">
                                        <div class="product-cart-details">
                                            <h4 class="product-title">
                                                <a href="{{ route('urun', $c->options->url) }}">{{$c->name}}</a>
                                            </h4>

                                            <span class="cart-product-info">
                                            <span class="cart-product-qty">{{$c->qty}}</span>
                                            x {{money($c->price)}}₺
                                        </span>
                                        </div>
                                        <figure class="product-image-container">
                                            <a href="{{ route('urun', $c->options->url) }}" class="product-image">
                                                <img src="{{ $c->options->image }}" alt="{{$c->name}}">
                                            </a>
                                        </figure>
                                        <form id="form" method="post" action="{{route('sepetcikar',$c->rowId )}}">
                                            @csrf
                                            <a  href="javascript:{}" onclick="document.getElementById('form').submit()" class="btn-remove" title="Ürünü Çıkar">
                                                <i class="icon-close"></i>
                                            </a>
                                        </form>
                                    </div>
                                @endforeach
                            </div>
                            <div class="dropdown-cart-total">
                                <span>Toplam</span>
                                <span class="cart-total-price">{{ Cart::total() }}₺</span>
                            </div>
                            <div class="dropdown-cart-action">
                                <a href="{{route('sepet')}}" class="btn btn-primary text-white">Sepetim</a>
                                <a href="{{route('siparis')}}" class="btn btn-outline-primary-2">
                                    <span>Ödeme</span><i class="icon-long-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>


    <div class="header-bottom sticky-header">
        <div class="container">
            <div class="header-left">
                <div class="dropdown category-dropdown">
                    <a href="#" class="dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static" title="Browse Categories">
                        Browse Categories
                    </a>

                    <div class="dropdown-menu">
                        <nav class="side-nav">
                            <ul class="menu-vertical sf-arrows">

                                    @foreach($Product_Categories->where('parent_id' , 0) as $item)
                                    <li class="megamenu-container">
                                        <a class="sf-with-ul" href="{{ route('kategori', [$item->slug, 'id' => $item->id]) }}">{{ $item->title }}</a>
                                        @if($Product_Categories->where('parent_id' , $item->id)->count() > 0)
                                        <div class="megamenu">
                                            <div class="row no-gutters">
                                                <div class="col-md-8">
                                                    <div class="menu-col">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="menu-title">{{ $item->title }}</div><!-- End .menu-title -->
                                                                <ul>
                                                                    @foreach($Product_Categories->where('parent_id' , $item->id) as $itemm)
                                                                        <li><a href="{{ route('kategori', [$item->slug, $itemm->slug,'id' => $itemm->id]) }}">{{ $itemm->title }}</a></li>
                                                                    @endforeach
                                                                </ul>
                                                            </div><!-- End .col-md-6 -->
                                                        </div><!-- End .row -->
                                                    </div><!-- End .menu-col -->
                                                </div><!-- End .col-md-8 -->

                                                <div class="col-md-4">
                                                    <div class="banner banner-overlay">
                                                        <a href="category.html" class="banner banner-menu">
                                                            <img src="http://malzemeadasi.test/banner-4.jpg" alt="Banner">
                                                        </a>
                                                    </div><!-- End .banner banner-overlay -->
                                                </div><!-- End .col-md-4 -->
                                            </div><!-- End .row -->
                                        </div>
                                        @endif
                                    </li>
                                    @endforeach
                            </ul><!-- End .menu-vertical -->
                        </nav><!-- End .side-nav -->
                    </div><!-- End .dropdown-menu -->
                </div><!-- End .category-dropdown -->
            </div><!-- End .header-left -->

            <div class="header-center">
                <nav class="main-nav">
                    <ul class="menu sf-arrows">
                        <li class="megamenu-container active">
                            <a href="index.html" class="sf-with-ul">Home</a>

                            <div class="megamenu demo">
                                <div class="menu-col">
                                    <div class="menu-title">Choose your demo</div><!-- End .menu-title -->

                                    <div class="demo-list">
                                        <div class="demo-item">
                                            <a href="index-1.html">
                                                <span class="demo-bg" style="background-image: url(assets/images/menu/demos/1.jpg);"></span>
                                                <span class="demo-title">01 - furniture store</span>
                                            </a>
                                        </div><!-- End .demo-item -->

                                        <div class="demo-item">
                                            <a href="index-2.html">
                                                <span class="demo-bg" style="background-image: url(assets/images/menu/demos/2.jpg);"></span>
                                                <span class="demo-title">02 - furniture store</span>
                                            </a>
                                        </div><!-- End .demo-item -->

                                        <div class="demo-item">
                                            <a href="index-3.html">
                                                <span class="demo-bg" style="background-image: url(assets/images/menu/demos/3.jpg);"></span>
                                                <span class="demo-title">03 - electronic store</span>
                                            </a>
                                        </div><!-- End .demo-item -->

                                        <div class="demo-item">
                                            <a href="index-4.html">
                                                <span class="demo-bg" style="background-image: url(assets/images/menu/demos/4.jpg);"></span>
                                                <span class="demo-title">04 - electronic store</span>
                                            </a>
                                        </div><!-- End .demo-item -->

                                        <div class="demo-item">
                                            <a href="index-5.html">
                                                <span class="demo-bg" style="background-image: url(assets/images/menu/demos/5.jpg);"></span>
                                                <span class="demo-title">05 - fashion store</span>
                                            </a>
                                        </div><!-- End .demo-item -->

                                        <div class="demo-item">
                                            <a href="index-6.html">
                                                <span class="demo-bg" style="background-image: url(assets/images/menu/demos/6.jpg);"></span>
                                                <span class="demo-title">06 - fashion store</span>
                                            </a>
                                        </div><!-- End .demo-item -->

                                        <div class="demo-item">
                                            <a href="index-7.html">
                                                <span class="demo-bg" style="background-image: url(assets/images/menu/demos/7.jpg);"></span>
                                                <span class="demo-title">07 - fashion store</span>
                                            </a>
                                        </div><!-- End .demo-item -->

                                        <div class="demo-item">
                                            <a href="index-8.html">
                                                <span class="demo-bg" style="background-image: url(assets/images/menu/demos/8.jpg);"></span>
                                                <span class="demo-title">08 - fashion store</span>
                                            </a>
                                        </div><!-- End .demo-item -->

                                        <div class="demo-item">
                                            <a href="index-9.html">
                                                <span class="demo-bg" style="background-image: url(assets/images/menu/demos/9.jpg);"></span>
                                                <span class="demo-title">09 - fashion store</span>
                                            </a>
                                        </div><!-- End .demo-item -->

                                        <div class="demo-item">
                                            <a href="index-10.html">
                                                <span class="demo-bg" style="background-image: url(assets/images/menu/demos/10.jpg);"></span>
                                                <span class="demo-title">10 - shoes store</span>
                                            </a>
                                        </div><!-- End .demo-item -->

                                        <div class="demo-item hidden">
                                            <a href="index-11.html">
                                                <span class="demo-bg" style="background-image: url(assets/images/menu/demos/11.jpg);"></span>
                                                <span class="demo-title">11 - furniture simple store</span>
                                            </a>
                                        </div><!-- End .demo-item -->

                                        <div class="demo-item hidden">
                                            <a href="index-12.html">
                                                <span class="demo-bg" style="background-image: url(assets/images/menu/demos/12.jpg);"></span>
                                                <span class="demo-title">12 - fashion simple store</span>
                                            </a>
                                        </div><!-- End .demo-item -->

                                        <div class="demo-item hidden">
                                            <a href="index-13.html">
                                                <span class="demo-bg" style="background-image: url(assets/images/menu/demos/13.jpg);"></span>
                                                <span class="demo-title">13 - market</span>
                                            </a>
                                        </div><!-- End .demo-item -->

                                        <div class="demo-item hidden">
                                            <a href="index-14.html">
                                                <span class="demo-bg" style="background-image: url(assets/images/menu/demos/14.jpg);"></span>
                                                <span class="demo-title">14 - market fullwidth</span>
                                            </a>
                                        </div><!-- End .demo-item -->

                                        <div class="demo-item hidden">
                                            <a href="index-15.html">
                                                <span class="demo-bg" style="background-image: url(assets/images/menu/demos/15.jpg);"></span>
                                                <span class="demo-title">15 - lookbook 1</span>
                                            </a>
                                        </div><!-- End .demo-item -->

                                        <div class="demo-item hidden">
                                            <a href="index-16.html">
                                                <span class="demo-bg" style="background-image: url(assets/images/menu/demos/16.jpg);"></span>
                                                <span class="demo-title">16 - lookbook 2</span>
                                            </a>
                                        </div><!-- End .demo-item -->

                                        <div class="demo-item hidden">
                                            <a href="index-17.html">
                                                <span class="demo-bg" style="background-image: url(assets/images/menu/demos/17.jpg);"></span>
                                                <span class="demo-title">17 - fashion store</span>
                                            </a>
                                        </div><!-- End .demo-item -->

                                        <div class="demo-item hidden">
                                            <a href="index-18.html">
                                                <span class="demo-bg" style="background-image: url(assets/images/menu/demos/18.jpg);"></span>
                                                <span class="demo-title">18 - fashion store (with sidebar)</span>
                                            </a>
                                        </div><!-- End .demo-item -->

                                        <div class="demo-item hidden">
                                            <a href="index-19.html">
                                                <span class="demo-bg" style="background-image: url(assets/images/menu/demos/19.jpg);"></span>
                                                <span class="demo-title">19 - games store</span>
                                            </a>
                                        </div><!-- End .demo-item -->

                                        <div class="demo-item hidden">
                                            <a href="index-20.html">
                                                <span class="demo-bg" style="background-image: url(assets/images/menu/demos/20.jpg);"></span>
                                                <span class="demo-title">20 - book store</span>
                                            </a>
                                        </div><!-- End .demo-item -->

                                        <div class="demo-item hidden">
                                            <a href="index-21.html">
                                                <span class="demo-bg" style="background-image: url(assets/images/menu/demos/21.jpg);"></span>
                                                <span class="demo-title">21 - sport store</span>
                                            </a>
                                        </div><!-- End .demo-item -->

                                        <div class="demo-item hidden">
                                            <a href="index-22.html">
                                                <span class="demo-bg" style="background-image: url(assets/images/menu/demos/22.jpg);"></span>
                                                <span class="demo-title">22 - tools store</span>
                                            </a>
                                        </div><!-- End .demo-item -->

                                        <div class="demo-item hidden">
                                            <a href="index-23.html">
                                                <span class="demo-bg" style="background-image: url(assets/images/menu/demos/23.jpg);"></span>
                                                <span class="demo-title">23 - fashion left navigation store</span>
                                            </a>
                                        </div><!-- End .demo-item -->

                                        <div class="demo-item hidden">
                                            <a href="index-24.html">
                                                <span class="demo-bg" style="background-image: url(assets/images/menu/demos/24.jpg);"></span>
                                                <span class="demo-title">24 - extreme sport store</span>
                                            </a>
                                        </div><!-- End .demo-item -->

                                        <div class="demo-item hidden">
                                            <a href="index-25.html">
                                                <span class="demo-bg" style="background-image: url(assets/images/menu/demos/25.jpg);"></span>
                                                <span class="demo-title">25 - jewelry store</span>
                                            </a>
                                        </div><!-- End .demo-item -->

                                        <div class="demo-item hidden">
                                            <a href="index-26.html">
                                                <span class="demo-bg" style="background-image: url(assets/images/menu/demos/26.jpg);"></span>
                                                <span class="demo-title">26 - market store</span>
                                            </a>
                                        </div><!-- End .demo-item -->

                                        <div class="demo-item hidden">
                                            <a href="index-27.html">
                                                <span class="demo-bg" style="background-image: url(assets/images/menu/demos/27.jpg);"></span>
                                                <span class="demo-title">27 - fashion store</span>
                                            </a>
                                        </div><!-- End .demo-item -->

                                        <div class="demo-item hidden">
                                            <a href="index-28.html">
                                                <span class="demo-bg" style="background-image: url(assets/images/menu/demos/28.jpg);"></span>
                                                <span class="demo-title">28 - food market store</span>
                                            </a>
                                        </div><!-- End .demo-item -->

                                        <div class="demo-item hidden">
                                            <a href="index-29.html">
                                                <span class="demo-bg" style="background-image: url(assets/images/menu/demos/29.jpg);"></span>
                                                <span class="demo-title">29 - t-shirts store</span>
                                            </a>
                                        </div><!-- End .demo-item -->

                                        <div class="demo-item hidden">
                                            <a href="index-30.html">
                                                <span class="demo-bg" style="background-image: url(assets/images/menu/demos/30.jpg);"></span>
                                                <span class="demo-title">30 - headphones store</span>
                                            </a>
                                        </div><!-- End .demo-item -->

                                        <div class="demo-item hidden">
                                            <a href="index-31.html">
                                                <span class="demo-bg" style="background-image: url(assets/images/menu/demos/31.jpg);"></span>
                                                <span class="demo-title">31 - yoga store</span>
                                            </a>
                                        </div><!-- End .demo-item -->
                                    </div><!-- End .demo-list -->

                                    <div class="megamenu-action text-center">
                                        <a href="#" class="btn btn-outline-primary-2 view-all-demos"><span>View All Demos</span><i class="icon-long-arrow-right"></i></a>
                                    </div><!-- End .text-center -->
                                </div><!-- End .menu-col -->
                            </div><!-- End .megamenu -->
                        </li>
                        <li>
                            <a href="category.html" class="sf-with-ul">Shop</a>

                            <div class="megamenu megamenu-md">
                                <div class="row no-gutters">
                                    <div class="col-md-8">
                                        <div class="menu-col">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="menu-title">Shop with sidebar</div><!-- End .menu-title -->
                                                    <ul>
                                                        <li><a href="category-list.html">Shop List</a></li>
                                                        <li><a href="category-2cols.html">Shop Grid 2 Columns</a></li>
                                                        <li><a href="category.html">Shop Grid 3 Columns</a></li>
                                                        <li><a href="category-4cols.html">Shop Grid 4 Columns</a></li>
                                                        <li><a href="category-market.html"><span>Shop Market<span class="tip tip-new">New</span></span></a></li>
                                                    </ul>

                                                    <div class="menu-title">Shop no sidebar</div><!-- End .menu-title -->
                                                    <ul>
                                                        <li><a href="category-boxed.html"><span>Shop Boxed No Sidebar<span class="tip tip-hot">Hot</span></span></a></li>
                                                        <li><a href="category-fullwidth.html">Shop Fullwidth No Sidebar</a></li>
                                                    </ul>
                                                </div><!-- End .col-md-6 -->

                                                <div class="col-md-6">
                                                    <div class="menu-title">Product Category</div><!-- End .menu-title -->
                                                    <ul>
                                                        <li><a href="product-category-boxed.html">Product Category Boxed</a></li>
                                                        <li><a href="product-category-fullwidth.html"><span>Product Category Fullwidth<span class="tip tip-new">New</span></span></a></li>
                                                    </ul>
                                                    <div class="menu-title">Shop Pages</div><!-- End .menu-title -->
                                                    <ul>
                                                        <li><a href="cart.html">Cart</a></li>
                                                        <li><a href="checkout.html">Checkout</a></li>
                                                        <li><a href="wishlist.html">Wishlist</a></li>
                                                        <li><a href="dashboard.html">My Account</a></li>
                                                        <li><a href="#">Lookbook</a></li>
                                                    </ul>
                                                </div><!-- End .col-md-6 -->
                                            </div><!-- End .row -->
                                        </div><!-- End .menu-col -->
                                    </div><!-- End .col-md-8 -->

                                    <div class="col-md-4">
                                        <div class="banner banner-overlay">
                                            <a href="category.html" class="banner banner-menu">
                                                <img src="assets/images/menu/banner-1.jpg" alt="Banner">

                                                <div class="banner-content banner-content-top">
                                                    <div class="banner-title text-white">Last <br>Chance<br><span><strong>Sale</strong></span></div><!-- End .banner-title -->
                                                </div><!-- End .banner-content -->
                                            </a>
                                        </div><!-- End .banner banner-overlay -->
                                    </div><!-- End .col-md-4 -->
                                </div><!-- End .row -->
                            </div><!-- End .megamenu megamenu-md -->
                        </li>
                        <li>
                            <a href="product.html" class="sf-with-ul">Product</a>

                            <div class="megamenu megamenu-sm">
                                <div class="row no-gutters">
                                    <div class="col-md-6">
                                        <div class="menu-col">
                                            <div class="menu-title">Product Details</div><!-- End .menu-title -->
                                            <ul>
                                                <li><a href="product.html">Default</a></li>
                                                <li><a href="product-centered.html">Centered</a></li>
                                                <li><a href="product-extended.html"><span>Extended Info<span class="tip tip-new">New</span></span></a></li>
                                                <li><a href="product-gallery.html">Gallery</a></li>
                                                <li><a href="product-sticky.html">Sticky Info</a></li>
                                                <li><a href="product-sidebar.html">Boxed With Sidebar</a></li>
                                                <li><a href="product-fullwidth.html">Full Width</a></li>
                                                <li><a href="product-masonry.html">Masonry Sticky Info</a></li>
                                            </ul>
                                        </div><!-- End .menu-col -->
                                    </div><!-- End .col-md-6 -->

                                    <div class="col-md-6">
                                        <div class="banner banner-overlay">
                                            <a href="category.html">
                                                <img src="assets/images/menu/banner-2.jpg" alt="Banner">

                                                <div class="banner-content banner-content-bottom">
                                                    <div class="banner-title text-white">New Trends<br><span><strong>spring 2019</strong></span></div><!-- End .banner-title -->
                                                </div><!-- End .banner-content -->
                                            </a>
                                        </div><!-- End .banner -->
                                    </div><!-- End .col-md-6 -->
                                </div><!-- End .row -->
                            </div><!-- End .megamenu megamenu-sm -->
                        </li>
                        <li>
                            <a href="#" class="sf-with-ul">Pages</a>

                            <ul>
                                <li>
                                    <a href="about.html" class="sf-with-ul">About</a>

                                    <ul>
                                        <li><a href="about.html">About 01</a></li>
                                        <li><a href="about-2.html">About 02</a></li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="contact.html" class="sf-with-ul">Contact</a>

                                    <ul>
                                        <li><a href="contact.html">Contact 01</a></li>
                                        <li><a href="contact-2.html">Contact 02</a></li>
                                    </ul>
                                </li>
                                <li><a href="login.html">Login</a></li>
                                <li><a href="faq.html">FAQs</a></li>
                                <li><a href="404.html">Error 404</a></li>
                                <li><a href="coming-soon.html">Coming Soon</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="blog.html" class="sf-with-ul">Blog</a>

                            <ul>
                                <li><a href="blog.html">Classic</a></li>
                                <li><a href="blog-listing.html">Listing</a></li>
                                <li>
                                    <a href="#">Grid</a>
                                    <ul>
                                        <li><a href="blog-grid-2cols.html">Grid 2 columns</a></li>
                                        <li><a href="blog-grid-3cols.html">Grid 3 columns</a></li>
                                        <li><a href="blog-grid-4cols.html">Grid 4 columns</a></li>
                                        <li><a href="blog-grid-sidebar.html">Grid sidebar</a></li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="#">Masonry</a>
                                    <ul>
                                        <li><a href="blog-masonry-2cols.html">Masonry 2 columns</a></li>
                                        <li><a href="blog-masonry-3cols.html">Masonry 3 columns</a></li>
                                        <li><a href="blog-masonry-4cols.html">Masonry 4 columns</a></li>
                                        <li><a href="blog-masonry-sidebar.html">Masonry sidebar</a></li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="#">Mask</a>
                                    <ul>
                                        <li><a href="blog-mask-grid.html">Blog mask grid</a></li>
                                        <li><a href="blog-mask-masonry.html">Blog mask masonry</a></li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="#">Single Post</a>
                                    <ul>
                                        <li><a href="single.html">Default with sidebar</a></li>
                                        <li><a href="single-fullwidth.html">Fullwidth no sidebar</a></li>
                                        <li><a href="single-fullwidth-sidebar.html">Fullwidth with sidebar</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="elements-list.html" class="sf-with-ul">Elements</a>

                            <ul>
                                <li><a href="elements-products.html">Products</a></li>
                                <li><a href="elements-typography.html">Typography</a></li>
                                <li><a href="elements-titles.html">Titles</a></li>
                                <li><a href="elements-banners.html">Banners</a></li>
                                <li><a href="elements-product-category.html">Product Category</a></li>
                                <li><a href="elements-video-banners.html">Video Banners</a></li>
                                <li><a href="elements-buttons.html">Buttons</a></li>
                                <li><a href="elements-accordions.html">Accordions</a></li>
                                <li><a href="elements-tabs.html">Tabs</a></li>
                                <li><a href="elements-testimonials.html">Testimonials</a></li>
                                <li><a href="elements-blog-posts.html">Blog Posts</a></li>
                                <li><a href="elements-portfolio.html">Portfolio</a></li>
                                <li><a href="elements-cta.html">Call to Action</a></li>
                                <li><a href="elements-icon-boxes.html">Icon Boxes</a></li>
                            </ul>
                        </li>
                    </ul><!-- End .menu -->
                </nav><!-- End .main-nav -->
            </div><!-- End .header-center -->

            <div class="header-right">
                <i class="la la-lightbulb-o"></i><p>Clearance<span class="highlight">&nbsp;Up to 30% Off</span></p>
            </div>
        </div><!-- End .container -->
    </div><!-- End .header-bottom -->

</header>
