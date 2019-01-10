@extends('layouts.app')

@section('content')

    <div class="ms_featured_slider padder_top20">
        <div class="ms_heading">
            <h1>@lang('texts.featuredArtist')</h1>
        </div>
        <div class="ms_relative_inner">
            <div class="ms_feature_slider swiper-container">

                <div class="swiper-wrapper">

                    @if(!empty($featured_artists))
                        @foreach ($featured_artists as $featured_artist)

                            <div class="swiper-slide">
                                <div class="ms_rcnt_box">
                                    <div class="ms_rcnt_box_img">
                                        <img src="{{ $featured_artist['img'] }}" alt="">
                                        <div class="ms_main_overlay">
                                            <div class="ms_box_overlay"></div>
                                        </div>
                                    </div>
                                    <div class="ms_rcnt_box_text">
                                        <h3><a href="{{ route('artist.detail', ['id' => $featured_artist['id']]) }}">{{ $featured_artist['name'] }}</a></h3>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif

                </div>
            </div>
            <!-- Add Arrows -->
            <div class="swiper-button-next1 slider_nav_next"></div>
            <div class="swiper-button-prev1 slider_nav_prev"></div>
        </div>
    </div>

@endsection
