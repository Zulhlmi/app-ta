<?php
/**
 * Created by PhpStorm.
 * User: yuliusardian
 * Date: 12/27/18
 * Time: 6:28 PM
 */

namespace App\Helpers;

require_once env('PIMCORE_PATH');

use Pimcore\Model\DataObject\User as UserPimcore;
use Pimcore\Model\DataObject\Song;
use Pimcore\Model\DataObject;

class RecentlyPlayedHelper
{
    public static function checkAndAdd($songId)
    {
        $recentlyPlayedCollections = new DataObject\Fieldcollection();
        $userPimcore = UserPimcore::getById(auth()->id(), 1);
        $songObj = Song::getById($songId, 1);

        /**
         * increment counter listen song.
         */
        $newCounter = $songObj->getCounter() + 1;
        $songObj->setCounter($newCounter);
        $songObj->save();

        $recentlyPlayedCollection = new DataObject\Fieldcollection\Data\RecentlyPlayed();
        $recentlyPlayedCollection->setSong($songObj);

        $recentlyPlayedCollections->add($recentlyPlayedCollection);

        $recentlyPlayedList = $userPimcore->getRecentlyPlayed() ? $userPimcore->getRecentlyPlayed()->getItems() : null;
        if ($recentlyPlayedList) {
            foreach ($recentlyPlayedList as $recentlyPlayed) {
                $recentlyPlayedCollection = new DataObject\Fieldcollection\Data\RecentlyPlayed();
                $recentlyPlayedCollection->setSong($recentlyPlayed->getSong());
                $recentlyPlayedCollections->add($recentlyPlayedCollection);
            }
        }

        $userPimcore->setRecentlyPlayed($recentlyPlayedCollections);
        $userPimcore->save();

        return true;
    }

    public static function remove($index)
    {
        $queueCollections = new DataObject\Fieldcollection();
        $userPimcore = UserPimcore::getById(auth()->id(), 1);
        $queueList = $userPimcore->getQueue() ? $userPimcore->getQueue()->getItems() : null;
        if ($queueList) {
            $iArray = 0;
            foreach ($queueList as $queue) {
                if ($index != $iArray) {
                    $queueCollection = new DataObject\Fieldcollection\Data\Queue();
                    $queueCollection->setSong($queue->getSong());
                    $queueCollections->add($queueCollection);
                }
                $iArray++;
            }
        }
        try {
            $userPimcore->setQueue($queueCollections);
            $userPimcore->save();

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public static function getRecentlyPlayed()
    {
        $recentlyPlayedCollections = [];
        $user = UserPimcore::getById(auth()->id(), 1);
        $recentlyPlayedCollections = $user->getRecentlyPlayed() ? $user->getRecentlyPlayed()->getItems() : [];

        return $recentlyPlayedCollections;
    }
}
