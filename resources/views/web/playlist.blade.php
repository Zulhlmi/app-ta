@extends('layouts.app')

@section('content')
    <div class="ms_top_artist">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ms_heading">
                        <h1>Daftar Putar Anda.</h1>
                        <span class="veiw_all" data-toggle="modal" data-target="#save_modal">
                            <a href="#" style="font-size: 40px">
                                +
                            </a>
                        </span>
                    </div>
                </div>
                @if (!empty($playlists))
                    @foreach($playlists as $playlist)
                        <div class="col-lg-2 col-md-6">
                            <div class="ms_rcnt_box">
                                <div class="ms_rcnt_box_img">
                                    <img src="http://via.placeholder.com/240" class="img-fluid">
                                    <div class="ms_main_overlay">
                                        <div class="ms_box_overlay"></div>
                                        <div class="ms_play_icon">
                                            <img src="<?= \Pimcore\Tool::getHostUrl() ?>/images/svg/play.svg" alt="">
                                        </div>
                                    </div>
                                </div>
                                <div class="ms_rcnt_box_text">
                                    <h3><a href="{{ route('playlist.detail', ['id' => $playlist->getId() ]) }}">{{ $playlist->getName() }}</a></h3>
                                    <p>
                                        @php
                                            $p = $playlist->getPlaylist() ? $playlist->getPlaylist()->getItems() : [];
                                        @endphp
                                        Jumlah lagu : {{ count($p) }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>


@endsection
