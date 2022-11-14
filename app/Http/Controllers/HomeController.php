<?php

namespace App\Http\Controllers;

use App\Http\Requests\MailRequest;
use App\Http\Requests\OrderRequest;
use App\Http\Requests\SearchRequest;
use App\Models\Basket;
use App\Models\Favorite;
use App\Models\MailSubcribes;
use App\Models\Order;
use App\Models\Page;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductCategoryPivot;
use App\Models\Search;
use App\Models\ShopCart;
use App\Models\Slider;
use Carbon\Carbon;
use CyrildeWit\EloquentViewable\Support\Period;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Artesaos\SEOTools\Facades\SEOTools;
use Iyzipay\Model\BasketItem;
use Iyzipay\Model\Buyer;
use Iyzipay\Model\CheckoutFormInitialize;
use Iyzipay\Options;

class HomeController extends Controller
{

    public function index()
    {
        $Slider = Slider::with('getProduct')->where('status', 1)->get();
        $Pivot = \App\Models\ProductCategoryPivot::with('productCategory')->get();

        return view('frontend.index', compact('Slider',  'Pivot'));
    }
    public function urun($url){
        $Detay = Product::with(['getCategory'])
            ->where('sku', \request('urunno'))
            ->firstOrFail();

        foreach ($Detay->getCategory as $item){
            $cat[] = $item->category_id;
        }

        $Category = ProductCategory::select('title', 'slug', 'id','desc', 'parent_id')
            ->whereIn('id',$cat)
            ->get();

        $OtherCategory = ProductCategory::select('title', 'slug', 'id','desc')
            ->where('slug',request()->segment(2))
            ->first();

        SEOTools::setTitle($Detay->title.' | Türkiye’nin ilk ve Tek Berber ve Kuaförlere özel pazaryeridir.');
        SEOTools::setDescription($Detay->seo_desc);
        SEOTools::opengraph()->setUrl(url()->current());
        SEOTools::setCanonical(route('urun', $Detay->slug));
        SEOTools::opengraph()->addProperty('type', 'product');
        SEOTools::jsonLd()->addImage($Detay->getFirstMediaUrl('page','thumb'));

        views($Detay)->cooldown(60)->record();
        $Count = views($Detay)->unique()->period(Period::create(Carbon::today()))->count();

        $Productssss = Product::with('getCategory')->where('status', 1)
                ->whereHas('getCategory', function ($query) use ($Detay, $cat)
                    {
                    $query->whereIn('category_id',$cat)
                        ->whereNotIn('product_id',[$Detay->id]);
                    })
                ->orderBy('rank','ASC')
                ->get();

        $Pivot = ProductCategoryPivot::with('productCategory')->get();

        Cart::instance('lastLook')->add(
            [
                'id' => $Detay->id,
                'name' => $Detay->title,
                'price' => $Detay->price,
                'weight' => 0,
                'qty' => 1,
                'options' => [
                    'image' => (!$Detay->getFirstMediaUrl('page')) ? '/backend/resimyok.jpg' : $Detay->getFirstMediaUrl('page', 'small'),
                    'cargo' => 0,
                    'campagin' => null,
                    'url' => url()->full()
                ]
            ]);

        return view('frontend.product.index', compact('Detay','Count', 'Productssss', 'Pivot', 'Category', 'OtherCategory'));
    }
    public function kategori($url){
        $Detay = ProductCategory::where('id', \request('id'))->select('id','title','slug')->first();
        SEOTools::setTitle($Detay->title.' | Türkiye’nin ilk ve Tek Berber ve Kuaförlere özel pazaryeridir.');
        SEOTools::setDescription($Detay->seo_desc);
        SEOTools::opengraph()->setUrl(url()->current());
        SEOTools::setCanonical(route('urun', $Detay->slug));
        SEOTools::opengraph()->addProperty('type', 'category');
        SEOTools::jsonLd()->addImage($Detay->getFirstMediaUrl('page','thumb'));


        $coksatan = request('coksatan')  ? request('coksatan') : 0;
        $fiyat = request('fiyat')  ? request('fiyat') : 'desc';
        $indirim = request('indirim')  ? request('indirim') : 0;

        if(request()->filled('fiyat')){
            $ProductList = Product::with(['getCategory'])
                ->join('product_category_pivots', 'product_category_pivots.product_id', '=', 'products.id' )
                ->join('product_categories', 'product_categories.id', '=', 'product_category_pivots.category_id')
                ->where('product_category_pivots.category_id',  $Detay->id)
                ->where('products.status', 1)
                ->select('products.id','products.title','products.rank','products.slug','products.price','products.old_price','products.slug')
                ->orderBy("price", $fiyat )
                ->paginate(18);
            return view('frontend.category.index', compact('Detay', 'ProductList'));
        }

        $ProductList = Product::with(['getCategory'])
            ->join('product_category_pivots', 'product_category_pivots.product_id', '=', 'products.id' )
            ->join('product_categories', 'product_categories.id', '=', 'product_category_pivots.category_id')
            ->where('product_category_pivots.category_id',  $Detay->id)
            ->where('products.status', 1)
            ->where(['category_id' => $Detay->id])
            ->select('products.id','products.title','products.rank','products.slug','products.price','products.old_price','products.slug','product_category_pivots.category_id', 'product_categories.parent_id')
            ->paginate(18);
        //dd($ProductList);


        return view('frontend.category.index', compact('Detay', 'ProductList'));
    }

    public function sepet(){
        SEOTools::setTitle("Sepetim | ". config('app.name'));
        SEOTools::setDescription('Türkiye’nin ilk ve Tek Berber ve Kuaförlere özel pazaryeridir. |  Sepetim Sayfası');

        if (Cart::instance('shopping')->content()->count() === 0){
            return redirect()->route('home');
        }
        //dd(Cart::content());

        $Products = Product::select('id', 'title', 'price', 'old_price', 'slug', 'campagin_price')->orderBy('rank')->get();
        return view('frontend.shop.sepet',compact('Products'));
    }
    public function siparis(){
        if (Cart::instance('shopping')->content()->count() === 0){
            return redirect()->route('home');
        }
        return view('frontend.shop.siparis');
    }
    public function odeme(OrderRequest $gelen)
    {

        SEOTools::setTitle("Ödeme | ". config('app.name'));
        SEOTools::setDescription('Türkiye’nin ilk ve Tek Berber ve Kuaförlere özel pazaryeridir.');

        if (request()->isMethod('get')) {
            return redirect()->route('home');
        }

        session($gelen->all());
        $sepetId    = time();

        $options = new Options;
        $options->setApiKey(env('SET_API_KEY_IZYICO'));
        $options->setSecretKey(env('SET_SECRET_KEY_IZYICO'));
        $options->setBaseUrl(env('SET_IYZICO_URL'));

        $request = new \Iyzipay\Request\CreateCheckoutFormInitializeRequest();
        $request->setLocale(\Iyzipay\Model\Locale::TR);
        $request->setConversationId($sepetId);
        $request->setPrice(Cart::instance('shopping')->total());
        $request->setPaidPrice(1);
        $request->setCurrency(\Iyzipay\Model\Currency::TL);
        $request->setBasketId($sepetId);
        $request->setPaymentGroup(\Iyzipay\Model\PaymentGroup::PRODUCT);
        $request->setCallbackUrl(route('cekim',['sepetId'=> $sepetId]));
        $request->setEnabledInstallments(array(2, 3, 6, 9));

        $buyer = new Buyer;
        $buyer->setId(rand(1,9));
        $buyer->setName($gelen->input('name'));
        $buyer->setSurname($gelen->input('surname'));
        $buyer->setGsmNumber($gelen->input('phone'));
        $buyer->setEmail($gelen->input('email'));
        $buyer->setIdentityNumber("74300864791");
        $buyer->setLastLoginDate("2015-10-05 12:43:35");
        $buyer->setRegistrationDate("2013-04-21 15:12:09");
        $buyer->setRegistrationAddress($gelen->input('address'));
        $buyer->setIp($_SERVER["REMOTE_ADDR"]);
        $buyer->setCity('İstanbul');
        $buyer->setCountry("Türkiye");
        $buyer->setZipCode("34000");

        $request->setBuyer($buyer);

        $shippingAddress = new \Iyzipay\Model\Address();
        $shippingAddress->setContactName($gelen->input('name').' '.$gelen->input('surname'));
        $shippingAddress->setCity('İstanbul');
        $shippingAddress->setCountry("Türkiye");
        $shippingAddress->setAddress($gelen->input('address'));
        $shippingAddress->setZipCode("34000");
        $request->setShippingAddress($shippingAddress);

        $billingAddress = new \Iyzipay\Model\Address();
        $billingAddress->setContactName($gelen->input('name').' '.$gelen->input('name'));
        $billingAddress->setCity('İstanbul');
        $billingAddress->setCountry("Türkiye");
        $billingAddress->setAddress($gelen->input('address'));
        $billingAddress->setZipCode('34000');
        $request->setBillingAddress($billingAddress);

        $cartcount = 0;
        $basketItems = [];

        foreach(Cart::instance('shopping')->content() as $cart){
            $BasketItem = new BasketItem;
            $BasketItem->setId($cart->id);
            $BasketItem->setName($cart->name);
            $BasketItem->setCategory1('Kategori');
            $BasketItem->setCategory2("Kategori");
            $BasketItem->setItemType(\Iyzipay\Model\BasketItemType::PHYSICAL);
            $BasketItem->setPrice( money($cart->price * $cart->qty));
            $basketItems[$cartcount] = $BasketItem;
            $cartcount++;
        }

        $request->setBasketItems($basketItems);

        $form = CheckoutFormInitialize::create($request, $options);

        return view('frontend.shop.odeme', compact('form', 'gelen'));
    }
    public function cekim(Request $gelen){

        if (request()->isMethod('get')) {
            return redirect()->to('/');
        }

        $token = $gelen->input('token');

        $options = new Options;
        $options->setApiKey(env('SET_API_KEY_IZYICO'));
        $options->setSecretKey(env('SET_SECRET_KEY_IZYICO'));
        $options->setBaseUrl(env('SET_IYZICO_URL'));

        $request = new \Iyzipay\Request\RetrieveCheckoutFormRequest();
        $request->setLocale(\Iyzipay\Model\Locale::TR);
        $request->setConversationId(request('sepetId'));
        $request->setToken($token);

        $payment = \Iyzipay\Model\CheckoutForm::retrieve($request, $options);

        if($payment->getPaymentStatus() == "SUCCESS"){
            if (request()->isMethod('post')) {

                DB::transaction(function () use($payment){
                    $ShopCart = new ShopCart;
                    $ShopCart->cart_id          = $payment->getBasketId();
                    $ShopCart->user_id          = (auth::check()) ? auth()->user()->id : $payment->getBasketId();
                    $ShopCart->basket_total	    = cargoToplam(Cart::instance('shopping')->total());
                    $ShopCart->order_cargo	    = cargo(Cart::instance('shopping')->total());
                    $ShopCart->name             = session()->get('name');
                    $ShopCart->surname          = session()->get('surname');
                    $ShopCart->email            = session()->get('email');
                    $ShopCart->phone            = session()->get('phone');
                    $ShopCart->address          = session()->get('address');
                    $ShopCart->province         = session()->get('province');
                    $ShopCart->city             = session()->get('city');
                    $ShopCart->note             = session()->get('note');
                    $ShopCart->save();

                    foreach (Cart::instance('shopping')->content() as $c) {
                        $Order                  = new Order;
                        $Order->cart_id         = $payment->getBasketId();
                        $Order->product_id      = $c->id;
                        $Order->name            = $c->name;
                        $Order->qty             = $c->qty;
                        $Order->price           = $c->price;
                        $Order->save();
                    }

                    Cart::instance('shopping')->destroy();
                    session()->flush();


                    $Summary  = Order::where('cart_id',request('sepetId') )->get();
                    $Customer = ShopCart::where('cart_id',request('sepetId'))->firstOrFail();

                    return view('frontend.shop.sonuc', compact('Summary', 'Customer'));

                });
            }
        }
    }

    public function cartdelete($rowId){
        Cart::instance('shopping')->remove($rowId);
        toast(SWEETALERT_MESSAGE_DELETE,'success');
        return redirect()->route('sepet');
    }
    public function cartdestroy(){
        Cart::instance('shopping')->destroy();

        toast(SWEETALERT_MESSAGE_DELETE,'success');
        return redirect()->route('home');
    }
    public function search(SearchRequest $request){

        SEOTools::setTitle($request->q." ile ilgili arama sonuçları | Kuatek Berber ve Kuaför Ürünleri");
        SEOTools::setDescription('Türkiye’nin ilk ve Tek Berber ve Kuaförlere özel pazaryeridir.');

        $search = $request->q;

        $Result  = Product::where('title','like','%'.$search.'%')
            ->orWhere('slug','like','%'.$search.'%')
            ->select('id', 'title', 'price', 'old_price', 'slug','bestselling','status')
            ->paginate(12);

        Search::create(['key' => $search]);

        return view('frontend.shop.search', compact('Result'));

    }


    public function addtocart(Request $request){

        if(auth()->check()){
            Favorite::where('user_id', auth()->user()->id)->where('product_id',$request->id)->delete();
        }

        $p = Product::find($request->id);
        Basket::create(['product_id' => $p->id, 'basket_name' => 'Sepet']);
        Cart::instance('shopping')->add(
            [
                'id' => $p->id,
                'name' => $p->title,
                'price' => $p->price,
                'weight' => 0,
                'qty' => 1,
                'options' => [
                    'image' => (!$p->getFirstMediaUrl('page')) ? '/backend/resimyok.jpg' : $p->getFirstMediaUrl('page', 'small'),
                    'cargo' => 0,
                    'campagin' => null,
                    'url' => $p->slug
                ]
            ]);

        toast(SWEETALERT_MESSAGE_CREATE,'success');
        return redirect()->route('sepet');
    }
    public function hizlisatinal(Request $request){

        Cart::instance('shopping')->destroy();

        $p = Product::find($request->id);
        Basket::create(['product_id' => $p->id, 'basket_name' => 'Hizli Satın Al']);
        Cart::instance('shopping')->add(
            [
                'id' => $p->id,
                'name' => $p->title,
                'price' => $p->price,
                'weight' => 0,
                'qty' => 1,
                'options' => [
                    'image' => (!$p->getFirstMediaUrl('page')) ? '/backend/resimyok.jpg' : $p->getFirstMediaUrl('page', 'small'),
                    'cargo' => 0,
                    'campagin' => null,
                    'url' => $p->slug
                ]
            ]);

        toast(SWEETALERT_MESSAGE_CREATE,'success');
        return redirect()->route('siparis');

    }
    public function favoriekle(Request $request){
        $p = Product::find($request->id);
        $New = Favorite::updateOrCreate(['user_id' => auth()->user()->id, 'product_id' => $p->id]);
        toast(SWEETALERT_MESSAGE_CREATE,'success');
        return redirect()->route('favori');
    }
    public function favori(){
        SEOTools::setTitle('Favori Listem | '. config('app.name'));
        SEOTools::setDescription('Türkiye’nin ilk ve Tek Berber ve Kuaförlere özel pazaryeridir.');

        $Favorite = Favorite::select('product_id')->where('user_id', auth()->user()->id)->get()->toArray();
        $FavoriteBooks = Product::select('id', 'title', 'price', 'old_price', 'slug','bestselling','status')
        ->whereIn('id', $Favorite)->get();
        return view('frontend.shop.favori', compact('Favorite', 'FavoriteBooks'));
    }
    public function favoricikar($id){
        $Delete = Favorite::where('product_id',$id)->where('user_id', auth()->user()->id)->delete();
        toast(SWEETALERT_MESSAGE_DELETE,'success');
        return redirect()->route('favori');

    }

    public function mailsubcribes(MailRequest $request){
        MailSubcribes::create(['email_address' => $request->email, 'ip_address' => $request->ip()]);
        toast('Email Adresiz Bülten Listesine Eklendi','success');
        return redirect()->route('home');
    }
    public function kurumsal($url){

        $Detay = Page::where('slug', $url)->firstOrFail();

        SEOTools::setTitle($Detay->title);
        SEOTools::setDescription($Detay->seo_desc);
        SEOTools::opengraph()->setUrl(url()->current());
        SEOTools::setCanonical(route('urun', $Detay->slug));
        SEOTools::opengraph()->addProperty('type', 'page');
        SEOTools::jsonLd()->addImage($Detay->getFirstMediaUrl('page','thumb'));

        return view('frontend.page.index', compact('Detay'));
    }
    public function iletisim(){

        SEOTools::setTitle("İletişim | ". config('app.name'));
        SEOTools::setDescription('Kuatek İletişim Sayfası');

        return view('frontend.page.contactus');
    }
    public function kargosorgulama(){
        return view('frontend.page.cargo');
    }
    public function profilim(){

        if (auth()->user()->is_admin == 1){
            return redirect()->route('go');
        }
        $Favorite = Favorite::select('product_id')->where('user_id', auth()->user()->id)->get()->toArray();
        $FavoriteBooks = Product::select('id', 'title', 'price', 'old_price', 'slug','bestselling','status')
            ->whereIn('id', $Favorite)->get();

        return view('frontend.dashboard.index', compact('FavoriteBooks'));
    }
}
