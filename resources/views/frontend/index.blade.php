@extends('frontend.layout.app')
@section('content')
    @include('backend.layout.alert')
    <div class="intro-slider-container d-none d-sm-block">
        <div class="owl-carousel owl-simple owl-light owl-nav-inside" data-toggle="owl" data-owl-options='{"nav": true,"height":400px}'>
            <div class="intro-slide">
                 <img src="https://www.malzemeadasi.com/images/sliderImage/1920/sliderImage_618e66b12a0eb.jpg">
            </div>
            <div class="intro-slide">
                <img src="https://www.malzemeadasi.com/images/sliderImage/1920/sliderImage_618e64fcf20af.jpg">
            </div>
        </div>
        <span class="slider-loader text-white"></span>
    </div>


    <div class="container icon-boxes-section">
        <div class="icon-boxes-container py-4 bg-transparent mb-2 mt-2">
            <div class="owl-carousel carousel-simple owl-theme carousel-equal-height shadow-carousel row cols-1 cols-md-2 cols-lg-3 cols-xl-4"
                 data-toggle="owl" data-owl-options='{
                        "dots": true,
                        "nav": false,
                        "loop": false,
                        "margin": 13,
                        "responsive": {
                            "0": {
                                "items": 1
                            },
                            "575": {
                                "items": 2
                            },
                            "992": {
                                "items": 3
                            },
                            "1200": {
                                "items": 4
                            }
                        }
                    }'>

                <div class="icon-box mb-0 d-md-flex align-items-center text-center  mx-md-0 mx-auto">
                        <span class="icon-box-icon text-primary">
                            <i class="icon-rocket"></i>
                        </span>
                    <div class="icon-box-content">
                        <h3 class="icon-box-title">Ücretsiz Kargo</h3>
                        <p>{{ CARGO_LIMIT }}₺ ve üzeri</p>
                    </div>
                </div>
                <div class="icon-box mb-0 d-md-flex align-items-center text-center  mx-md-0 mx-auto">
                        <span class="icon-box-icon text-primary">
                            <i class="icon-rotate-left"></i>
                        </span>
                    <div class="icon-box-content">
                        <h3 class="icon-box-title">İade Garantisi</h3>
                        <p>14 gün içinde iade imkanı</p>
                    </div>
                </div>
                <div class="icon-box mb-0 d-md-flex align-items-center text-center  mx-md-0 mx-auto">
                        <span class="icon-box-icon text-primary">
                            <i class="icon-info-circle"></i>
                        </span>
                    <div class="icon-box-content">
                        <h3 class="icon-box-title">İndirimli Ürünler</h3>
                        <p>%30 varan indirimler</p>
                    </div>
                </div>
                <div class="icon-box mb-0 d-md-flex align-items-center text-center  mx-md-0 mx-auto">
                        <span class="icon-box-icon text-primary">
                            <i class="icon-life-ring"></i>
                        </span>
                    <div class="icon-box-content">
                        <h3 class="icon-box-title">Müşteri Hizmetleri</h3>
                        <p>Online Hızlı Müşteri Desteği</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">

        <div class="row cat-banner-row electronics">
            <div class="col-12 col-md-2">
                <div class="cat-banner row no-gutters">
                    <div class="cat-banner-list col-sm-12 d-xl-none d-xxl-flex" style="background-image: url(/frontend/assets/images/banner-bg-1.jpg);">
                        <div class="banner-list-content p-5">
                            <h3><a href="#">Penuar</a></h3>
                            <ul>
                                @foreach($Product_Categories->where('parent_id' , 1) as $itemm)
                                    <li><a href="{{ route('kategori', ['penuar', $itemm->slug,'id' => $itemm->id]) }}">{{ $itemm->title }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-10">
                <div class="owl-carousel owl-full carousel-equal-height carousel-with-shadow" data-toggle="owl"
                     data-owl-options='{
                                        "nav": true,
                                        "dots": false,
                                        "margin": 20,
                                        "loop": false,
                                        "responsive": {
                                            "0": {
                                                "items":2
                                            },
                                            "480": {
                                                "items":2
                                            },
                                            "768": {
                                                "items":3
                                            },
                                            "992": {
                                                "items":3
                                            },
                                            "1200": {
                                                "items":4
                                            },
                                            "1600": {
                                                "items":4
                                            }
                                        }
                                    }'>
                        @foreach($Product->take(6) as $item)
                            <x-shop.product-item :item="$item"/>
                        @endforeach
                </div><!-- End .owl-carousel -->
            </div><!-- End .col-xl-9 -->
        </div><!-- End .row cat-banner-row -->
    </div>

    <div class="deal-container">
        <div class="container">
            <div class="row">
                @foreach($Product->take(2) as $item)
                <div class="col-lg-6">
                    <div class="deal">
                        <div class="deal-content">
                            <h4>Kampanyalı Ürün</h4>
                            <h3 class="product-title">
                                <a href="{{ route('urun' , $item->slug)}}" title="{{ $item->title }}">
                                {{ $item->title }}
                            </h3>

                            <div class="product-price">
                                {{ money($item->price) }}₺
                            </div>

                            <a href="{{ route('urun' , $item->slug)}}" class="btn btn-primary">
                                <span>Ürünü İncele</span><i class="icon-long-arrow-right"></i>
                            </a>
                        </div>
                        <div class="deal-image">
                            <a href="{{ route('urun' , $item->slug)}}" title="{{ $item->title }}">
                                <img class="img-fluid" src="{{ (!$item->getFirstMediaUrl('page')) ? '/resimyok.jpg' : $item->getFirstMediaUrl('page', 'img')}}" alt="{{ $item->title }}">
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="banner-group">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="banner banner-overlay">
                                <a href="https://www.kuatek.com/kategori/penuar/cocuk-penuar?id=13" title="Çocuk Penuarı">
                                    <img src="{{'/banner-1.jpg'}}" alt="{{config('app.name')}}">
                                </a>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="banner banner-overlay banner-overlay-light">
                                <a href="https://www.kuatek.com/kategori/penuar/baskisiz-penuar?id=8" title="Baskısız Penuar">
                                    <img src="{{'/banner-2.jpg'}}" alt="{{config('app.name')}}">
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="banner banner-large banner-overlay d-none d-sm-block">
                        <a href="https://www.kuatek.com/kategori/penuar/dijital-baski-penuar?id=10" title="Dijital Bakılı Penuar">
                            <img src="{{'/banner-3.jpg'}}" alt="{{config('app.name')}}">
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 d-sm-none d-lg-block">
                    <div class="banner banner-middle banner-overlay">
                        <a href="https://www.kuatek.com/kategori/penuar/1cape-penuar?id=11" title="1Cape">
                            <img src="{{'/banner-4.jpg'}}" alt="{{config('app.name')}}">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="mb-6"></div>
    <div class="container" id="urunler">
        <div class="row">
            @foreach($Product as $item)
                <div class="col-6 col-md-3">
                    <x-shop.product-item :item="$item"/>
                </div>
            @endforeach
        </div>
        <div class="row ">
            <div class="col-12 d-flex align-items-center justify-content-center">
                {{ $Product->appends(['siralama' => 'urunler' ]) }}
            </div>
        </div>

    </div>
    <div class="container">
        <hr class="mt-1 mb-6">
    </div>

    @if(Cart::instance('lastLook')->content()->count()) > 0)
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="title title-border">En Son Baktıklarınız</h2>
            </div>
            <div class="owl-carousel owl-simple carousel-equal-height carousel-with-shadow" data-toggle="owl"
                 data-owl-options='{
                        "nav": false,
                        "dots": true,
                        "margin": 20,
                        "loop": false,
                        "responsive": {
                            "0": {
                                "items":1
                            },
                            "480": {
                                "items":2
                            },
                            "768": {
                                "items":3
                            },
                            "992": {
                                "items":4
                            },
                            "1200": {
                                "items":4,
                                "nav": true,
                                "dots": false
                            }
                        }
                    }'>
                @foreach(Cart::instance('lastLook')->content() as $item)
                    <div class="product product-4 text-center">
                        <figure class="product-media">
                            <a href="{{ $item->options->slug }}" title="{{ $item->name }}">
                                <img class="img-fluid" src="{{ $item->options->image }}" alt="{{ $item->name }}">
                            </a>

                            <div class="product-action-vertical">
                                <a href="{{ route('favoriekle', ['id' => $item->id]) }}" class="btn-product-icon btn-wishlist"><span>Favorilere Ekle</span></a>
                            </div>
                        </figure>

                        <div class="product-body">

                            <h3 class="product-title birsatir">
                                <a href="{{ $item->options->slug }}" title="{{ $item->name }}">
                                {{ $item->name }}
                            </h3>
                            <div class="product-price">
                                {{ money($item->price) }}₺
                            </div>
                        </div>
                        <div class="product-action">
                            <a href="{{ $item->options->slug}}"
                               title="{{ $item->name }}"
                               class="btn-product btn-cart">
                                <span>İncele</span>
                            </a>

                        </div>
                    </div>

                @endforeach
            </div>
        </div>
    </div>
    @endif
@endsection

