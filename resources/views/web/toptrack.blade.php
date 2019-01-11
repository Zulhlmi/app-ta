@extends('layouts.app')

@section('content')
    @if ($songs)
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

                            {{--ms_active_play--}}
                            <div class="ms_weekly_box">
                                <div class="weekly_left">
                                    <span class="w_top_no">
										{{ $key + 1 }}
									</span>
                                    <audio id="myaudio" song-id="{{ $song['id'] }}">
                                        <source src="{{ $song['mp3'] }}" type="audio/mpeg">
                                    </audio>
                                    <div class="w_top_song" song-data='@json($song)' song-path="{{ $song['mp3'] }}">
                                        <div class="w_tp_song_img">
                                            <img src="{{ $song['image'] }}">
                                            <div class="ms_song_overlay">
                                            </div>
                                            <div class="ms_play_icon">
                                                <img src="images/svg/play.svg">
                                            </div>
                                        </div>
                                        <div class="w_tp_song_name">
                                            <h3><a href="#">{{ $song['title'] }}</a></h3>
                                            <p>{{ $song['artist'] }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="weekly_right">
                                    <span id="w_song_time" class="w_song_time" song-id="{{ $song['id'] }}">
                                    </span>
                                    <span class="ms_more_icon" data-other="1">
										<img src="images/svg/more.svg" alt="">
									</span>
                                </div>
                                <ul class="more_option">
                                    <li>
                                        <a href="#" class="addToFavouriteAction" song-id="{{ $song['id'] }}">
                                            <span class="opt_icon">
                                                <span class="icon icon_fav"></span>
                                            </span>
                                            @lang('buttons.addToFavourite')
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="addToQueueAction" song-id="{{ $song['id'] }}" data-json='@json($song)'>
                                            <span class="opt_icon">
                                                <span class="icon icon_queue"></span>
                                            </span>
                                            @lang('buttons.addToQueue')
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="addToPlaylistAction" song-id="{{ $song['id'] }}" data-json='@json($song)'>
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

@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

        });
    </script>
@endpush
