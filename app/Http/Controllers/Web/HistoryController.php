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
        $historydata = [];
        if (!empty($histories)) {
            foreach ($histories as $history) {
                $songObj = $history->getSong();
                $historydata[] = [
                    'id' => $songObj->getId(),
                    'title' => $songObj->getName(),
                    'image' => $songObj->getImg() ? $songObj->getImg()->getFullPath() : null,
                    'mp3' => $songObj->getFile() ? $songObj->getFile()->getFullPath() : null,
                    'artist' => $songObj->getArtist() ? $songObj->getArtist()->getName() : null
                ];
            }
        }
        return view('web.history', [
            'songs' => $historydata
        ]);
    }
}
