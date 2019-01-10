<?php

namespace App\Http\Controllers\Web;

use App\Helpers\SongHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TopTrackController extends Controller
{
    public function index()
    {
        SongHelper::$orderKey   = 'counter';
        SongHelper::$order      = 'desc';
        $songs = SongHelper::getSong();
        return view('web.toptrack', [
            'songs' => $songs
        ]);
    }
}
