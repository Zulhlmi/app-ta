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

class QueueHelper
{

    public static function checkAndAdd($songId)
    {
        $queueCollections = new DataObject\Fieldcollection();
        $userPimcore = UserPimcore::getById(auth()->id(), 1);
        $songObj = Song::getById($songId, 1);
        $queueList = $userPimcore->getQueue() ? $userPimcore->getQueue()->getItems() : null;
        if ($queueList) {
            foreach ($queueList as $queue) {
                $queueCollection = new DataObject\Fieldcollection\Data\Queue();
                $queueCollection->setSong($queue->getSong());
                $queueCollections->add($queueCollection);
            }
        }
        $queueCollection = new DataObject\Fieldcollection\Data\Queue();
        $queueCollection->setSong($songObj);

        $queueCollections->add($queueCollection);

        $userPimcore->setQueue($queueCollections);
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

    public static function getQueues()
    {
        $queueCollections = null;
        if (auth()->id()) {
            $user = UserPimcore::getById(auth()->id(), 1);
            $queueCollections = $user->getQueue() ? $user->getQueue()->getItems() : null;
            $songs = [];
            if (!empty($queueCollections)) {
                foreach ($queueCollections as $queueCollection) {
                    $songObj    = $queueCollection->getSong();

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
        }
        return $songs;
    }
}
