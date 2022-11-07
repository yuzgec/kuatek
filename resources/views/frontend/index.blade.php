@extends('frontend.layout.app')
@section('content')
    @include('backend.layout.alert')
    <div class="intro-slider-container">
        <div class="owl-carousel owl-simple owl-light owl-nav-inside" data-toggle="owl" data-owl-options='{"nav": true,"height":400px}'>
            <div class="intro-slide"
                 style="background-image: url(https://www.malzemeadasi.com/images/sliderImage/1920/sliderImage_618e66b12a0eb.jpg);">
            </div>

        </div>
        <span class="slider-loader text-white"></span>
    </div>

    <div class="icon-boxes-container icon-boxes-separator bg-transparent">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-lg-3">
                    <div class="icon-box icon-box-side">
                        <span class="icon-box-icon text-primary">
                            <i class="icon-rocket"></i>
                        </span>
                        <div class="icon-box-content">
                            <h3 class="icon-box-title">Ücretsiz Kargo</h3>
                            <p>{{ CARGO_LIMIT }}₺ ve üzeri</p>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-3">
                    <div class="icon-box icon-box-side">
                        <span class="icon-box-icon text-primary">
                            <i class="icon-rotate-left"></i>
                        </span>
                        <div class="icon-box-content">
                            <h3 class="icon-box-title">İade Garantisi</h3>
                            <p>14 gün içinde iade imkanı</p>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-3">
                    <div class="icon-box icon-box-side">
                        <span class="icon-box-icon text-primary">
                            <i class="icon-info-circle"></i>
                        </span>
                        <div class="icon-box-content">
                            <h3 class="icon-box-title">İndirimli Ürünler</h3>
                            <p>%30 varan indirimler</p>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-3">
                    <div class="icon-box icon-box-side">
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
    </div>



    <div class="deal-container pt-5">
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

