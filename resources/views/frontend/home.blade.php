@extends('frontend.layouts.app')
@section('content')
    <div id="home">
        {{-- <div class="row">
            @if ($blocks && $blocks->first())
            <div class="block block-1 wave text-center" @if($blocks->first()->getFirstMedia('image')) style="background-image: url({{$blocks->first()->getFirstMedia('image')->getUrl()}});" @endif>
                <p class="xxl">{{$blocks->first()->title}}</p>
                @if ($blocks->first()->description)
                    <span class="block-description">{{$blocks->first()->description}}</span>
                @endif
                <br>
                <br>
                <a href="{{$blocks->first()->link_button}}" class="btn btn-primary padding btn-lg">{{$blocks->first()->text_button}}</a>
            </div>
            @endif
        </div>
        <br> --}}
        <div class="row">
            <div class="position ">
                <position name="home.under.menu"></position>
            </div>
        </div>
        <div class="row">
            <browser :categories="{{\App\Models\Category::where('is_featured',true)->where('is_active',true)->take(6)->get()}}"></browser>
        </div>
        
        <div class="row">
            <div class="position ">
                <position name="home.under.categories"></position>
            </div>
        </div>
        <div class="row">
            <br>
            <h2 class="text-center text-primary">آراء العملاء</h2>
            <carousel :autoplay="true" dir="ltr"
                  :responsive="{0:{items:1,nav:false},600:{items:3,nav:true},800:{items:4,nav:true}}"
                  :loop="false"
                  :dots="false"
                  :stagePadding="0">
                @foreach ($testimonials as $testimonial)
                    <img src="{{$testimonial->getFirstMedia('thumbnail')->getUrl()}}" width="200" />
                @endforeach
            </carousel>
        </div>
        {{-- <div class="row">
            <div class="position ">
                <position name="home.under.testimonials"></position>
            </div>
        </div> --}}
    </div>
@endsection
