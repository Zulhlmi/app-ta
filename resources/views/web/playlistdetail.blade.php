@extends('layouts.app')

@section('content')

    <div class="ms_free_download ms_purchase_wrapper">
        <div class="ms_heading">
            <h1>Daftar Lagu</h1>
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
                @if($listplaylists)
                    @foreach($listplaylists as $key => $listplaylist)
                        <ul favourite-id="{{ $listplaylist['id'] }}"> {{-- if active add class play_active_song --}}
                            <li class="w_tp_song_img" song-json='@json($listplaylist)'>
                                <a href="#">
                                    <span class="play_no">{{ $key + 1 }}</span>
                                    <span class="play_hover"></span>
                                </a>
                            </li>
                            <li class="text-center">
                                <a href="#">{{ $listplaylist['title'] }}</a>
                            </li>
                            <li class="text-center">
                                <a href="#">{{ $listplaylist['album']  }}</a>
                            </li>
                            <li class="text-center">
                                <a href="#">{{ $listplaylist['artist']  }}</a>
                            </li>
                            <li class="text-center">
                                <a href="#">{{ $listplaylist['duration'] }}</a>
                            </li>
                            <li class="text-center ms_more_icon">
                                <a href="javascript:;"><span class="ms_icon1 ms_active_icon"></span></a>
                                <ul class="more_option">
                                    <li>
                                        <a href="#" class="addToQueueAction" song-id="{{ $listplaylist['id'] }}" song-json='@json($listplaylist)'>
                                            <span class="opt_icon">
                                                <span class="icon icon_queue"></span>
                                            </span>
                                            @lang('buttons.addToQueue')
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="text-center">
                                <a song-id="{{ $listplaylist['id'] }}">
                                    <span class="ms_close"><img src=" {{ asset('images/svg/close.svg') }}" alt=""></span>
                                </a>
                            </li>
                        </ul>
                    @endforeach
                @endif

            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>

        $(document).ready(function() {

            $('.ms_rcnt_box_img').click(function () {
                var songJson = JSON.parse($(this).attr('song-json'));
                myPlaylist.add(songJson, true);
            });

        });
    </script>
@endpush
