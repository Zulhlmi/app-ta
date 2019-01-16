<?php

namespace App\Http\Controllers;

use App\Helpers\AdHelper;
use App\Helpers\AlbumHelper;
use App\Helpers\ArtistHelper;
use App\Helpers\RecentlyPlayedHelper;
use App\Helpers\GenreHelper;
use App\Helpers\SongHelper;
use Illuminate\Http\Request;
use Pimcore\Model\DataObject\Song;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $isFreeUser = $this->isFree();
        if (!$isFreeUser) {
            $ads = [];
        }

        $topAlbum = AlbumHelper::getAlbum();
        $newRilis = SongHelper::$limit = 15;
        $newRilis = SongHelper::getSong();

        $topArtist = ArtistHelper::getArtist();

        /**
         * Set order by counter
         */
        SongHelper::$order      = 'desc';
        SongHelper::$orderKey   = 'counter';
        $topWeekly = SongHelper::getSong();


        $topGenre = GenreHelper::getGenre();
        $histories = RecentlyPlayedHelper::getRecentlyPlayed();

        return view('home', [
            'topAlbum' => $topAlbum,
            'newRealease' => $newRilis,
            'topArtist' => $topArtist,
            'topWeekly' => $topWeekly,
            'genres' => $topGenre,
            'histories' => $histories
        ]);
    }
}
