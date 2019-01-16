<?php

namespace App\Http\Controllers\Web;

use App\Helpers\SongHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TopTrackController extends Controller
{
    public function index()
    {
        $songs = SongHelper::$limit = 15;
        $songs = SongHelper::$orderKey   = 'counter';
        $songs = SongHelper::$order      = 'desc';
        $songs = SongHelper::getSong();

        $newest = SongHelper::$limit = 15;
        $newest = SongHelper::$orderKey   = 'o_id';
        $newest = SongHelper::$order      = 'desc';
        $newest = SongHelper::getSong();

        return view('web.toptrack', [
            'songs' => $songs,
            'newest' => $newest,
        ]);
    }
}
