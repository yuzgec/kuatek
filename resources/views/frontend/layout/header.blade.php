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
                    <img src="{{asset('/frontend/assets/images/logo.jpg')}}" width="170px">
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
                    <a href="#" class="dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static" title="KATEGORİLERİMİZ">
                       KATEGORİLERİMİZ
                    </a>

                    <div class="dropdown-menu">
                        <nav class="side-nav">
                            <ul class="menu-vertical sf-arrows">
                                @foreach($Product_Categories->where('parent_id' , 0) as $item)
                                <li class="megamenu-container">
                                    <a class="@if($Product_Categories->where('parent_id' , $item->id)->count() > 0) ? sf-with-ul :  null @endif" href="{{ route('kategori', [$item->slug, 'id' => $item->id]) }}">{{ $item->title }}</a>
                                    @if($Product_Categories->where('parent_id' , $item->id)->count() > 0)
                                    <div class="megamenu">
                                        <div class="row no-gutters">
                                            <div class="col-md-12">
                                                <div class="menu-col">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="menu-title">{{ $item->title }}</div>
                                                            <ul>
                                                                @foreach($Product_Categories->where('parent_id' , $item->id) as $itemm)
                                                                    <li><a href="{{ route('kategori', [$item->slug, $itemm->slug,'id' => $itemm->id]) }}">{{ $itemm->title }}</a></li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="banner banner-overlay">
                                                                <a href="https://www.kuatek.com/kategori/penuar/1cape-penuar?id=11" class="banner banner-menu">
                                                                    <img src="http://malzemeadasi.test/banner-4.jpg" alt="Banner">
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    </div>
                                                </div>
                                            </div>


                                    </div>
                                    @endif
                                </li>
                                @endforeach
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>

            <div class="header-center">
                <nav class="main-nav">
                    <ul class="menu">

                        <li><a href="{{ route('home') }}">ANASAYFA</a></li>
                        <li><a href="{{ route('home') }}">HAKKIMIZDA</a></li>
                        <li><a href="{{ route('home') }}">KAMPANYALARIMIZ</a></li>
                        <li><a href="{{ route('home') }}">OUTLET</a></li>
                        <li><a href="{{ route('home') }}">İLETİŞİM</a></li>
                    </ul><!-- End .menu -->
                </nav><!-- End .main-nav -->
            </div><!-- End .header-center -->

            <div class="header-right">
                <i class="la la-thumbs-o-up" style="font-size: 20px"></i><img src="/frontend/assets/images/slogan.svg" width="170px">
            </div>
        </div><!-- End .container -->
    </div><!-- End .header-bottom -->

</header>
