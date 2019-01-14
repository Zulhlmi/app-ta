@extends('layouts.app')

@section('content')
    <div class="ms_free_download ms_purchase_wrapper">
        <div class="ms_heading">
            <h1>@lang('texts.yourFavourite')</h1>
        </div>
        <div class="album_inner_list">
            <div class="album_list_wrapper">
                <ul class="album_list_name">
                    <li>#</li>
                    <li class="text-center">Judul lagu</li>
                    <li class="text-center">Album</li>
                    <li class="text-center">Artis</li>
                    <li class="text-center">Durasi</li>
                    <li class="text-center">Lainnya</li>
                    <li class="text-center">Hapus</li>
                </ul>
                @if($favourites)
                    @foreach($favourites as $key => $favourite)
                        <ul favourite-id="{{ $favourite['id'] }}"> {{-- if active add class play_active_song --}}
                            <li class="w_tp_song_img" song-json='@json($favourite)'>
                                <a href="#">
                                    <span class="play_no">{{ $key + 1 }}</span>
                                    <span class="play_hover"></span>
                                </a>
                            </li>
                            <li class="text-center">
                                <a href="#">{{ $favourite['title'] }}</a>
                            </li>
                            <li class="text-center">
                                <a href="#">{{ $favourite['album']  }}</a>
                            </li>
                            <li class="text-center">
                                <a href="#">{{ $favourite['artist']  }}</a>
                            </li>
                            <li class="text-center">
                                <a href="#">{{ $favourite['duration'] }}</a>
                            </li>
                            <li class="text-center ms_more_icon">
                                <a href="javascript:;"><span class="ms_icon1 ms_active_icon"></span></a>
                                <ul class="more_option">
                                    <li>
                                        <a href="#" class="addToQueueAction" song-id="{{ $favourite['id'] }}" song-json='@json($favourite)'>
                                            <span class="opt_icon">
                                                <span class="icon icon_queue"></span>
                                            </span>
                                            @lang('buttons.addToQueue')
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="addToPlaylistAction" song-id="{{ $favourite['id'] }}" song-json='@json($favourite)'>
                                            <span class="opt_icon">
                                                <span class="icon icon_playlst"></span>
                                            </span>
                                            @lang('buttons.addToPlaylist')
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="text-center">
                                <a onclick="removeFavourite({{ $favourite['id'] }});">
                                    <span class="ms_close"><img src=" {{ asset('images/svg/close.svg') }}" alt=""></span>
                                </a>
                            </li>
                        </ul>
                    @endforeach
                @endif

                {{--<div class="ms_view_more">--}}
                    {{--<a href="#" class="ms_btn">view more</a>--}}
                {{--</div>--}}

            </div>
        </div>
    </div>

    @if($rencents)
    <div class="ms_radio_wrapper padder_top30">
            <div class="ms_heading">
                <h1>@lang('texts.recentlyPlayed')</h1>
            </div>
            <div class="ms_radio_slider swiper-container">
                <div class="swiper-wrapper">
                    @foreach($rencents as $key => $rencent)
                        <div class="swiper-slide">
                            <div class="ms_rcnt_box">
                                <div class="ms_rcnt_box_img" song-json='@json($rencent)' song-id="{{ $song['id'] }}">
                                    <img src="{{ $rencent['image'] }}">
                                    <div class="ms_main_overlay">
                                        <div class="ms_box_overlay"></div>
                                        <div class="ms_more_icon">
                                            <img src="{{ url('images/svg/more.svg') }}">
                                        </div>
                                        <ul class="more_option">
                                            <li><a href="#"><span class="opt_icon"><span class="icon icon_fav"></span></span>Add To Favourites</a></li>
                                            <li><a href="#"><span class="opt_icon"><span class="icon icon_queue"></span></span>Add To Queue</a></li>
                                            <li><a href="#"><span class="opt_icon"><span class="icon icon_playlst"></span></span>Add To Playlist</a></li>
                                            <li><a href="#"><span class="opt_icon"><span class="icon icon_share"></span></span>Share</a></li>
                                        </ul>
                                        <div class="ms_play_icon">
                                            <img src="{{ url('images/svg/play.svg') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="ms_rcnt_box_text">
                                    <h3><a href="#">{{ $rencent['title'] }}</a></h3>
                                    <p>{{ $rencent['artist'] }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <!-- Add Arrows -->
            <div class="swiper-button-next4 slider_nav_next"></div>
            <div class="swiper-button-prev4 slider_nav_prev"></div>
        </div>
    @endif
@endsection

@push('scripts')
    <script>

        $(document).ready(function() {

            $('.ms_rcnt_box_img').click(function () {
                var songJson = JSON.parse($(this).attr('song-json'));
                myPlaylist.add(songJson, true);
            });

        });

        function removeFavourite(id) {
            $.ajax({
                type: "POST",
                url: baseUrl + "/interaction/favourite/remove/" + id,
                data: {_token: csrfToken},
                dataType: 'JSON',
                success: function(result) {
                    $("ul[favourite-id="+id+"]").remove();
                    callToast(result.message);
                }
            });
        }
    </script>
@endpush
