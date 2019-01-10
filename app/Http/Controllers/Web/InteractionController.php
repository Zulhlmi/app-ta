<?php

namespace App\Http\Controllers\Web;

use App\Helpers\FavouriteHelper;
use App\Helpers\RecentlyPlayedHelper;
use App\Helpers\PlaylistHelper;
use App\Helpers\QueueHelper;
use Pimcore\Model\DataObject\Song;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class InteractionController extends Controller
{
    public function play($song_id)
    {
        $validator = Validator::make(['song_id' => $song_id], [
            'song_id' => 'required'
        ]);
        if ($validator->fails()) {
            return response($validator->errors(), 200);
        }
        $historyCollections = RecentlyPlayedHelper::checkAndAdd($song_id);
        return response($song_id, 200);
    }

    public function favourite($song_id)
    {
        $validator = Validator::make(['song_id' => $song_id], [
            'song_id' => 'required'
        ]);
        if ($validator->fails()) {
            return response($validator->errors(), 200);
        }
        $addToFavouriteFieldCollection = FavouriteHelper::checkAndAdd($song_id);
        if ($addToFavouriteFieldCollection) {
            return response([
                'message' => __('texts.addToFavouriteSuccess')
            ]);
        }
        return response($song_id, 200);
    }

    public function removeFavourite($i)
    {
        $remove = FavouriteHelper::remove($i);
        if ($remove) {
            return response([
                'message' => 'Berhasil menghapus'
            ], 200);
        }
        return response($i, 200);
    }

    public function queue($song_id)
    {
        $validator = Validator::make(['song_id' => $song_id], [
            'song_id' => 'required'
        ]);
        if ($validator->fails()) {
            return response($validator->errors(), 200);
        }
        $addToQueueCollections = QueueHelper::checkAndAdd($song_id);
        if ($addToQueueCollections) {
            return response([
                'message' => __('texts.addToQueueSuccess')
            ], 200);
        }
        return response($song_id, 200);
    }

    public function removeQueue($i)
    {
        $remove = QueueHelper::remove($i);
        if ($remove) {
            return response([
                'message' => 'Berhasil menghapus'
            ], 200);
        }
        return response($i, 200);
    }

    public function playlist($song_id)
    {
        $validator = Validator::make(['song_id' => $song_id], [
            'song_id' => 'required'
        ]);
        if ($validator->fails()) {
            return response($validator->errors(), 200);
        }
        $addToQueueCollections = PlaylistHelper::checkAndAdd($song_id);
        if ($addToQueueCollections) {
            return response([
                'message' => __('texts.addToQueueSuccess')
            ], 200);
        }
        return response($song_id, 200);
    }


    public function search(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'keyword' => 'required'
        ]);
        if ($validator->fails()) {
            return view('web.searchresult')->withErrors($validator->errors());
        }
        $result = [];
        $songLists = new Song\Listing();
        $songLists->setCondition('name like ?', ["%".$request->keyword."%"]);
        $songLists->load();
        if (!empty($songLists->getObjects())) {
            foreach ($songLists->getObjects() as $object) {
                $result[] = [
                    'id' => $object->getId(),
                    'title' => $object->getName(),
                    'artist' => $object->getArtist()->getName(),
                    'image' => $object->getImg() ? \Pimcore\Tool::getHostUrl('https').$object->getImg()->getThumbnail() : '',
                    'mp3' => $object->getFile() ? $object->getFile()->getFullPath() : null
                ];
            }
        }

        $datas = [
            'keyword' => $request->keyword,
            'result' => $result
        ];
        return view('web.searchresult')->with($datas);
    }
}
