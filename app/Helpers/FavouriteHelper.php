<?php
/**
 * Created by PhpStorm.
 * User: yuliusardian
 * Date: 12/26/18
 * Time: 6:13 PM
 */

namespace App\Helpers;

use Pimcore\Model\DataObject\User as UserPimcore;
use Pimcore\Model\DataObject\Song;
use Pimcore\Model\DataObject;

class FavouriteHelper
{
    public static function checkAndAdd($songId)
    {
        $favouriteCollections = new DataObject\Fieldcollection();
        $userPimcore = UserPimcore::getById(auth()->id(), 1);
        $songObj = Song::getById($songId, 1);

        $favouriteCollection = new DataObject\Fieldcollection\Data\Favourite();
        $favouriteCollection->setSong($songObj);

        $favouriteCollections->add($favouriteCollection);

        $favouriteList = $userPimcore->getFavourite() ? $userPimcore->getFavourite()->getItems() : null;
        if ($favouriteList) {
            foreach ($favouriteList as $favourite) {
                if ($favourite->getSong()->getId() != $songId) {
                    $favouriteCollection = new DataObject\Fieldcollection\Data\Favourite();
                    $favouriteCollection->setSong($favourite->getSong());
                    $favouriteCollections->add($favouriteCollection);
                }
            }
        }

        $userPimcore->setFavourite($favouriteCollections);
        $userPimcore->save();

        return true;
    }

    public static function remove($songId)
    {
        $favouriteCollections = new DataObject\Fieldcollection();
        $userPimcore = UserPimcore::getById(auth()->id(), 1);
        $favouriteList = $userPimcore->getFavourite() ? $userPimcore->getFavourite()->getItems() : null;
        if ($favouriteList) {
            foreach ($favouriteList as $favourite) {
                if ($songId != $favourite->getSong()->getId()) {
                    $favouriteCollection = new DataObject\Fieldcollection\Data\Favourite();
                    $favouriteCollection->setSong($favourite->getSong());
                    $favouriteCollections->add($favouriteCollection);
                }
            }
        }
        try {
            $userPimcore->setFavourite($favouriteCollections);
            $userPimcore->save();

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public static function getFavourites()
    {
        $user = UserPimcore::getById(auth()->id(), 1);
        $favouriteCollections = $user->getFavourite() ? $user->getFavourite()->getItems() : null;
        $songs = [];
        if (!empty($favouriteCollections)) {
            foreach ($favouriteCollections as $favouriteCollection) {
                $songObj    = $favouriteCollection->getSong();

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
