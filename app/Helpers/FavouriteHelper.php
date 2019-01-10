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
                $favouriteCollection = new DataObject\Fieldcollection\Data\Favourite();
                $favouriteCollection->setSong($favourite->getSong());
                $favouriteCollections->add($favouriteCollection);
            }
        }

        $userPimcore->setFavourite($favouriteCollections);
        $userPimcore->save();

        return true;
    }

    public static function remove($index)
    {
        $favouriteCollections = new DataObject\Fieldcollection();
        $userPimcore = UserPimcore::getById(auth()->id(), 1);
        $favouriteList = $userPimcore->getFavourite() ? $userPimcore->getFavourite()->getItems() : null;
        if ($favouriteList) {
            $iArray = 0;
            foreach ($favouriteList as $favourite) {
                if ($index != $iArray) {
                    $favouriteCollection = new DataObject\Fieldcollection\Data\Favourite();
                    $favouriteCollection->setSong($favourite->getSong());
                    $favouriteCollections->add($favouriteCollection);
                }
                $iArray++;
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
        return $favouriteCollections;
    }
}
