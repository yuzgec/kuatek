
<footer class="footer footer-2">


    <div class="footer-newsletter bg-image" style="background-image: url(/frontend/assets/images/backgrounds/bg-2.jpg)" id="abone">
        <div class="container">
            <div class="heading text-center">
                <h3 class="title">Haber Bülteminize Katılın</h3>
                <p class="title-desc">Sitemizdeki ürün ve kampanyalardan ilk siz haberdar olun</p>
            </div>

            <div class="row">
                <div class="col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-6 offset-lg-3">
                    <form action="{{ route('mailsubcribes') }}" method="POST">
                        @csrf
                        <div class="input-group">
                            <input value="{{old('email_address')}}"
                                   name="email_address"
                                   class="form-control"
                                   placeholder="Email Adresinizi Giriniz">

                            <div class="input-group-append">
                                <button class="btn btn-primary"
                                        type="submit"
                                        id="newsletter-btn">
                                    <span>Abone Ol</span><i class="icon-long-arrow-right"></i>
                                </button>
                            </div>
                        </div>

                        @if($errors->has('email_address'))
                            <div class="invalid-feedback"
                                 style="display: block;color:white">
                                {{$errors->first('email_address')}}
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-middle">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-lg-6">
                    <div class="widget widget-about">
                        <p>KuateK Kuaför Tekstili 1989 Yılından Beri Sektöre Hizmet vermektedir. Başta Penuar, Önlük, ve Havlu, olmak üzere daha birçok alanda üretim yapmaktadır. Yıllık 3.000.000 Üretim Kapasitesine Sahiptir.
                        </p>
                        <div class="widget-about-info">
                            <div class="row">
                                <div class="col-sm-12 col-12 d-flex">
                                    <div>
                                        <span class="widget-about-title">Müşteri Hizmetleri</span>
                                        <a href="tel:0212 212 12 12">0538 096 44 55</a>
                                    </div>

                                </div>
                                <div class="col-sm-12 col-12 mt-3">
                                    <figure class="footer-payments">
                                        <img src="/frontend/assets/images/iyzico.png" alt="İyzico" >
                                    </figure>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4 col-lg-2">
                    <div class="widget">
                        <h4 class="widget-title">Bilgi Sayfaları</h4>
                        <ul class="widget-list">
                            <li><a href="#">Hakkımızda</a></li>
                            <li><a href="#">S.S.S</a></li>
                            <li><a href="{{ route('iletisim') }}">İletişim</a></li>
                            <li><a href="{{ route('login') }}">Giriş Yap</a></li>
                            <li><a href="{{ route('register') }}">Kayıt Ol</a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-sm-4 col-lg-2">
                    <div class="widget">
                        <h4 class="widget-title">Müşteri Hizmetleri</h4>
                        <ul class="widget-list">
                            @foreach($Pages->where('category', 2) as $item)
                            <li><a href="{{ route('kurumsal', $item->slug) }}">{{ $item->title }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <div class="col-sm-4 col-lg-2">
                    <div class="widget">
                        <h4 class="widget-title">Hesabım</h4>
                        <ul class="widget-list">
                            <li><a href="{{ route('login') }}">Giriş Yap</a></li>
                            <li><a href="{{ route('sepet') }}">Sepetim</a></li>
                            <li><a href="#">Favorilerim</a></li>
                            <li><a href="" target="_blank">Kargo Takip</a></li>
                            <li><a href="#">Yardım</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <div class="container">
            <p class="footer-copyright">Copyright © 2022 Kuatek. Tüm Hakları Saklıdır.</p>
            <ul class="footer-menu">
                <li><a href="https://www.kuatek.com/kurumsal/kisisel-verilern-korunmasi-kanunu">Kvkk Bilgilendirme Metni</a></li>
                <li><a href="https://www.kuatek.com/kurumsal/gizlilik-politikasi">Gizlilik Politası</a></li>
            </ul>

            <div class="social-icons social-icons-color">
                <span class="social-label">Sosyal Medya</span>
                <a href="https://www.facebook.com/kuatek" class="social-icon social-facebook" title="Facebook" target="_blank">
                    <i class="icon-facebook-f"></i></a>
                <a href="https://www.twitter.com/kuatek" class="social-icon social-twitter" title="Twitter" target="_blank">
                    <i class="icon-twitter"></i></a>
                <a href="https://www.instagram.com/kuatek_" class="social-icon social-instagram" title="Instagram" target="_blank">
                    <i class="icon-instagram"></i></a>
            </div>
        </div>
    </div>
</footer>
