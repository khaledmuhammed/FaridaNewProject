@extends('frontend.layouts.app')
@section('content')
    <div class="container">
        <div class="product">
            {{--<transition name="slide-fade">
                <sticky-bar v-if="displayBar" :product="{{$product}}"></sticky-bar>
            </transition>--}}
            <div class="row">
                {{ Breadcrumbs::render('product', $product) }}
            </div>
            {{-- <div class="row">

                 <div id="labels" class=" col-xs-12">
                     @foreach($product->labels as $label)
                         <span class="product-label"
                               style="background-color: {{$label->color}}">{{$label->name}}</span>
                     @endforeach
                 </div>

             </div>--}}
            <div class="row">
                <div class="col-sm-7 col-xs-12 pull-right">
                    <media :imgs="{{$product->getMedia('images')}}"></media>
                </div>
                <div class="col-sm-5 col-xs-12 pull-right">
                    <actions :product="{{$product}}" id="actions" :auth="@auth true @else false @endauth"></actions>
                </div>
            </div>
            
            @if (!empty($product->description))
            <div class="row">
                <div class="col-xs-12">
                    <div>
                        <div class="collapse-header">
                            <a href="#description" class="collapsed" data-toggle="collapse" role="button">وصف المنتج</a>
                        </div>
                        <div class="collapse" id="description">
                            <div class="description">{!!$product->description!!}</div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            
            @if(count($packages))
                <div class="row">
                    <div class="col-xs-12">
                        <packages :product="{{$product}}"
                                  :packages="{{$packages}}"
                                  :auth="@auth true @else false @endauth"></packages>
                    </div>
                </div>
            @endif
            
            <div class="row">
                <div class="col-xs-12">
                    <attributes :attributes="{{$product->productAttributes}}"></attributes>
                </div>
            </div>
           
            @if( count($relatedProducts)  )
                <div class="row">
                    <div class="col-xs-12">
                        <related
                                :related_products="{{ $relatedProducts  }}"
                                :auth="@auth true @else false @endauth">
                        </related>
                    </div>
                </div>
            @endif
            
            <div class="row">
                <div class="col-xs-12">
                    <rating :ratings="{{$product->ratings}}" :rate_avg="{{$product->rating}}"
                            :product_id="{{$product->id}}"></rating>
                </div>
            </div>
        </div>
    </div>
@endsection
