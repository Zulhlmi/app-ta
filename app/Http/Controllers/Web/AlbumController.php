<?php

namespace App\Http\Controllers\Web;

use App\Helpers\AlbumHelper;
use App\Helpers\SongHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AlbumController extends Controller
{
    /**
     * mengambil seluruh data album dari class albumhelper
     * pada static function get album dan menyimpannya pada variable featuredalbumlistdata
     * sesudah itu melempar variable tersebut kedalam view
     */
    public function index()
    {
        $featuredAlbumListData = AlbumHelper::getAlbum();

        return view('web.album', [
            'featured_albums'   => $featuredAlbumListData,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $songs = SongHelper::getSongByAlbumId($id);
        $album = AlbumHelper::getById($id);
        return view('web.albumdetail', [
            'songs' => $songs,
            'album' => $album
        ]);
    }

}
