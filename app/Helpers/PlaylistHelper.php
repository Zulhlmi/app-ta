<?php
/**
 * Created by PhpStorm.
 * User: yuliusardian
 * Date: 12/26/18
 * Time: 7:40 PM
 */

namespace App\Helpers;

require_once env('PIMCORE_PATH');

use Pimcore\Model\DataObject\User as UserPimcore;
use Pimcore\Model\DataObject\Song;
use Pimcore\Model\DataObject;

class PlaylistHelper
{

    public static function checkAndAdd($songId)
    {
        $queueCollections = new DataObject\Fieldcollection();
        $userPimcore = UserPimcore::getById(auth()->id(), 1);
        $songObj = Song::getById($songId, 1);
        $queueList = $userPimcore->getHistory() ? $userPimcore->getHistory()->getItems() : null;
        if ($queueList) {
            foreach ($queueList as $queue) {
                $queueCollection = new DataObject\Fieldcollection\Data\History();
                $queueCollection->setSong($queue->getSong());
                $queueCollections->add($queueCollection);
            }
        }
        $queueCollection = new DataObject\Fieldcollection\Data\History();
        $queueCollection->setSong($songObj);

        $queueCollections->add($queueCollection);

        $userPimcore->setHistory($queueCollections);
        $userPimcore->save();

        return true;
    }

    public static function getPlaylist()
    {
        $queueCollections = null;
        if (auth()->id()) {
            $user = UserPimcore::getById(auth()->id(), 1);
            $queueCollections = $user->getHistory() ? $user->getHistory()->getItems() : null;
        }
        return $queueCollections;
    }

}
