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
                if ($recentlyPlayed->getSong()->getId() != $songId) {
                    $recentlyPlayedCollection = new DataObject\Fieldcollection\Data\RecentlyPlayed();
                    $recentlyPlayedCollection->setSong($recentlyPlayed->getSong());
                    $recentlyPlayedCollections->add($recentlyPlayedCollection);
                }
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
        $recentlyPlayedCollections = $user->getRecentlyPlayed() ? $user->getRecentlyPlayed()->getItems() : null;
        $songs = [];
        if (!empty($recentlyPlayedCollections)) {
            foreach ($recentlyPlayedCollections as $recentlyPlayedCollection) {
                $songObj    = $recentlyPlayedCollection->getSong();

                $id3            = ID3Helper::analyze($songObj->getFile()->getFullPath());
                $songId         = $songObj->getId() ? $songObj->getId() : null;
                $songImage      = $songObj->getImg() ? $songObj->getImg()->getFullPath() : 'http://via.placeholder.com/100';
                $songName       = $songObj->getName() ? $songObj->getName() : null;
                $songArtist     = $songObj->getArtist() ? $songObj->getArtist()->getName() : null;
                $songAlbum      = $songObj->getAlbum() ? $songObj->getAlbum()->getName() : null;
                $songFile       = $songObj->getFile() ? $songObj->getFile()->getFullPath() : 'http://www.jplayer.org/audio/mp3/TSP-01-Cro_magnon_man.mp3';

                $songDuration   = $id3['playtime_string'];

                $songs[] = [
                    'id' => $songId,
                    'image' => $songImage,
                    'title' => $songName,
                    'artist' => $songArtist,
                    'album' => $songAlbum,
                    'mp3' => $songFile,
                    'option' => '',
                    'duration' => $songDuration
                ];
            }
        }

        return $songs;
    }
}
