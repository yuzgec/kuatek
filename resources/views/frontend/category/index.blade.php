@extends('frontend.layout.app')
@section('content')
    @include('backend.layout.alert')

    <div class="page-header text-center" style="background-image: url('/frontend/assets/images/page-header-bg.jpg')">
        <div class="container">
            <h1 class="page-title">
                {{ $Detay->title }}
            </h1>
        </div>
    </div>

    <div class="page-content">
        <div class="container">
            <div class="row mt-3">
                <div class="col-lg-9" >
                    <div class="toolbox" >
                        <div class="toolbox-left">
                            <div class="toolbox-info">
                                ({{$ProductList->count()}}) adet ürün listelenmiştir.
                            </div>
                        </div>

                        <div class="toolbox-right">
                            <div class="toolbox-sort">
                                <label for="sortby">Sıralama:</label>
                                <div class="select-custom">
                                    <select name="sortby" id="sortby" class="form-control">
                                        <option value="popularity" selected="selected">Yeni Eklenenler</option>
                                        <option value="rating">Düşük Fiyat</option>
                                        <option value="date">Yüksek Fiyat</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="products mb-3">
                        <div class="row">
                            @foreach($ProductList as $item)
                            <div class="col-6 col-md-4">
                                <x-shop.product-item :item="$item"/>
                            </div>
                            @endforeach
                        </div>

                        <div class="row ">
                            <div class="col-12 d-flex align-items-center justify-content-center">
                                {{ $ProductList->appends(['siralama' => 'urunler' ]) }}
                            </div>
                        </div>
                    </div>
                </div>

                <aside class="col-lg-3 col-xl-5col order-lg-first p-3"
                     >
                    <div class="sidebar sidebar-shop">
                        <div class="widget widget-categories">

                            <div class="widget-body">
                                <div class="accordion mt-2" id="widget-cat-acc">
                                    @foreach($Product_Categories->where('parent_id' , 0) as $item)
                                    <div class="acc-item">
                                        <h5>
                                            <a role="button"  href="{{route('kategori', [$item->slug,  'id' => $item->id])}}" >
                                                {{ $item->title }}
                                            </a>
                                        </h5>
                                        @if($Product_Categories->where('parent_id' , 0)->count() > 0)
                                        <div id="{{$item->slug}}" class="collapse {{ (request()->segment(2) == $item->slug) ? 'show' : null  }}" data-parent="#widget-cat-acc">
                                            <div class="collapse-wrap">
                                                <ul>
                                                    @foreach($Product_Categories->where('parent_id' , $item->id) as $itemm)

                                                       <li>
                                                           <a href="{{ route('kategori',  [$item->slug, $itemm->slug,'id' => $itemm->id]) }}">
                                                               {{ $itemm->title }}
                                                           </a>
                                                       </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                    </div>
                </aside>
            </div>
        </div>
    </div>
@endsection
@section('customCSS')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="/frontend/assets/css/select2.css" rel="stylesheet" />
@endsection
@section('customJS')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.single').select2({
                theme: "bootstrap"
            });
        });
    </script>
@endsection


