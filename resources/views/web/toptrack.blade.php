@extends('layouts.app')

@section('content')
    @if (!empty($songs))
        <div class="ms_weekly_wrapper">
            <div class="ms_weekly_inner">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ms_heading">
                            <h1>@lang('texts.top', ['number' =>count($songs)])</h1>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12 padding_right40">
                        @foreach($songs as $key => $song)

                            <div class="ms_weekly_box">
                                <div class="weekly_left">
                                    <span class="w_top_no">
										{{ $key + 1 }}
									</span>
                                    <div class="w_top_song">
                                        <div class="w_tp_song_img" song-id="{{ $song['id'] }}" song-json='@json($song)'>
                                            <img src="{{ $song['image'] }}">
                                            <div class="ms_song_overlay">
                                            </div>
                                            <div class="ms_play_icon">
                                                <img src="{{ url('images/svg/play.svg') }}">
                                            </div>
                                        </div>
                                        <div class="w_tp_song_name">
                                            <h3><a href="#">{{ $song['title'] }}</a></h3>
                                            <p>{{ $song['artist'] }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="weekly_right">
                                    <span class="w_song_time">{{ $song['duration'] }}</span>
                                    <span class="ms_more_icon" data-other="1">
										<img src="{{ url('images/svg/more.svg') }}" alt="">
									</span>
                                </div>
                                <ul class="more_option">
                                    <li>
                                        <a class="addToFavouriteAction" song-id="{{ $song['id'] }}">
                                            <span class="opt_icon">
                                                <span class="icon icon_fav"></span>
                                            </span>
                                            @lang('buttons.addToFavourite')
                                        </a>
                                    </li>
                                    <li>
                                        <a class="addToQueueAction" song-id="{{ $song['id'] }}" song-json='@json($song)'>
                                            <span class="opt_icon">
                                                <span class="icon icon_queue"></span>
                                            </span>
                                            @lang('buttons.addToQueue')
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <span class="opt_icon">
                                                <span class="icon icon_playlst"></span>
                                            </span>
                                            @lang('buttons.addToPlaylist')
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="ms_divider"></div>

                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    @endif

    @if(!empty($newest))
    <div class="ms_releases_wrapper">
        <div class="ms_heading">
            <h1>@lang('texts.newReleases')</h1>
            {{--<span class="veiw_all"><a href="#">view more</a></span>--}}
        </div>
        <div class="ms_release_slider swiper-container">
            <div class="ms_divider"></div>
            <div class="swiper-wrapper">
                @foreach($newest as $key => $new)
                    <div class="swiper-slide">
                        <div class="ms_release_box">
                            <div class="w_top_song">
                                <span class="slider_dot"></span>
                                <div class="w_tp_song_img" song-json='@json($new)'>
                                    <img src="{{ $new['image'] }}">
                                    <div class="ms_song_overlay">
                                    </div>
                                    <div class="ms_play_icon">
                                        <img src="{{ url('images/svg/play.svg') }}">
                                    </div>
                                </div>
                                <div class="w_tp_song_name">
                                    <h3><a href="#">{{ $new['title'] }}</a></h3>
                                    <p>{{ $new['artist'] }}</p>
                                </div>
                            </div>
                            <div class="weekly_right">
                                <span class="w_song_time">{{ $new['duration'] }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <!-- Add Arrows -->
        <div class="swiper-button-next2 slider_nav_next"></div>
        <div class="swiper-button-prev2 slider_nav_prev"></div>
    </div>
    @endif

@endsection
