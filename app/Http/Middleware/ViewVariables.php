<?php

namespace App\Http\Middleware;

use App\Helpers\QueueHelper;
use App\Helpers\AdHelper;
use App\Helpers\SongHelper;
use Closure;
use Illuminate\Contracts\Auth\Guard;

class ViewVariables
{
    protected $auth;

    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $queueCollection = QueueHelper::getQueues();
        $ads = AdHelper::getAds();
        $userPlaylist = [];

        $oneTop = SongHelper::$limit = 1;
        $oneTop = SongHelper::getSong();

        view()->share('userPlaylist', $userPlaylist);
        view()->share('ads', $ads);
        view()->share('oneTop', $oneTop);

        return $next($request);
    }
}
