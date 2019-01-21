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
use Pimcore\Model\DataObject\Playlist;
use Pimcore\Model\DataObject\Song;
use Pimcore\Model\DataObject;

class PlaylistHelper
{

    public static function checkAndAdd($songId)
    {
        $queueCollections = new DataObject\Fieldcollection();
        $playlistD = UserPimcore::getById(auth()->id(), 1);
        $songObj = Song::getById($songId, 1);
        $queueList = $playlistD->getHistory() ? $playlistD->getHistory()->getItems() : null;
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

        $playlistD->setHistory($queueCollections);
        $playlistD->save();

        return true;
    }

    public static function checkAndAddSong($playlistId, $songId)
    {
        $checkPlaylist = Playlist::getById($playlistId, 1);
        if (!$checkPlaylist) {
            return false;
        }
        $playlistCollections = new DataObject\Fieldcollection();
//        $playlistD = UserPimcore::getById(auth()->id(), 1);
        $songObj = Song::getById($songId, 1);

        $playlistCollection = new DataObject\Fieldcollection\Data\Playlist();
        $playlistCollection->setSong($songObj);

        $playlistCollections->add($playlistCollection);

        $PlaylistList = $checkPlaylist->getPlaylist() ? $checkPlaylist->getPlaylist()->getItems() : null;
        if ($PlaylistList) {
            foreach ($PlaylistList as $Playlist) {
                if ($Playlist->getSong()->getId() != $songId) {
                    $playlistCollection = new DataObject\Fieldcollection\Data\Playlist();
                    $playlistCollection->setSong($Playlist->getSong());
                    $playlistCollections->add($playlistCollection);
                }
            }
        }

        $checkPlaylist->setPlaylist($playlistCollections);
        $checkPlaylist->save();

        return true;
    }

    public static function getPlaylist()
    {
        $playlists = new Playlist\Listing();
        $playlists->setCondition('user__id = ?', [auth()->id()]);
        $playlists->load();
        return $playlists;
    }

    public static function getSongByPlaylistId($playlistId)
    {
        $playlistById = Playlist::getById($playlistId, 1);

        $playlistCollections = $playlistById->getPlaylist() ? $playlistById->getPlaylist()->getItems() : null;
        $songs = [];
        if (!empty($playlistCollections)) {
            foreach ($playlistCollections as $playlistCollection) {
                $songObj    = $playlistCollection->getSong();

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

    public static function destroy($playlistId)
    {
        $g = Playlist::getById($playlistId, 1);
        $g->delete();
        return true;
    }

    public static function removeSong($playlistId, $songId)
    {
        $playlistCollections = new DataObject\Fieldcollection();
        $playlistD = Playlist::getById($playlistId, 1);
        $playlistList = $playlistD->getPlaylist() ? $playlistD->getPlaylist()->getItems() : null;
        if ($playlistList) {
            foreach ($playlistList as $playlist) {
                if ($songId != $playlist->getSong()->getId()) {
                    $playlistCollection = new DataObject\Fieldcollection\Data\Playlist();
                    $playlistCollection->setSong($playlist->getSong());
                    $playlistCollections->add($playlistCollection);
                }
            }
        }
        try {
            $playlistD->setPlaylist($playlistCollections);
            $playlistD->save();

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

}
