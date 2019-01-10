@extends('layouts.app')

@section('content')

    @if($genres)
        <div class="ms_featured_slider">
            <div class="ms_heading">
                <h1>@lang('texts.genre')</h1>
            </div>
            <div class="ms_feature_slider swiper-container">
                <div class="swiper-wrapper">

                    @foreach($genres as $genre)
                        <div class="swiper-slide">
                            <div class="ms_rcnt_box">
                                <div class="ms_rcnt_box_img">
                                    <img src="{{ $genre['img'] }}" alt="">
                                    <div class="ms_main_overlay">
                                        <div class="ms_box_overlay"></div>
                                    </div>
                                </div>
                                <div class="ms_rcnt_box_text">
                                    <h3><a href="{{ route('genre.detail', ['id' => $genre['id']]) }}">{{ $genre['name'] }}</a></h3>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
            <!-- Add Arrows -->
            <div class="swiper-button-next1 slider_nav_next"></div>
            <div class="swiper-button-prev1 slider_nav_prev"></div>
        </div>
    @endif

@endsection
