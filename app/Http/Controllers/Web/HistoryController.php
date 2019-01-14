<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\RecentlyPlayedHelper;

class HistoryController extends Controller
{
    public function index()
    {
        $histories = RecentlyPlayedHelper::getRecentlyPlayed();
        return view('web.history', [
            'songs' => $histories
        ]);
    }
}
