<?php

namespace App\Http\Controllers\Web;

use App\Helpers\FavouriteHelper;
use App\Helpers\RecentlyPlayedHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FavouriteController extends Controller
{
    public function index()
    {

        $favouriteCollections       = FavouriteHelper::getFavourites();

        $rencentlyPlayedCollections = RecentlyPlayedHelper::getRecentlyPlayed();

        return view('web.favourite', [
            'favourites'    => $favouriteCollections,
            'rencents'      => $rencentlyPlayedCollections,
        ]);
    }
}
