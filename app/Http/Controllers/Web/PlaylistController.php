<?php

namespace App\Http\Controllers\Web;

use App\Helpers\PlaylistHelper;
use Pimcore\Model\DataObject\Playlist;
use AppBundle\Tool\Folder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PlaylistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('web.playlist');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $playlistName = $request->get('playlist_name');

        try {
            $folderPlaylist = Folder::checkAndCreate('Playlist');
            $folderUser     = Folder::checkAndCreate($this->getUser()->getEmail(), $folderPlaylist);

            $playlistObj = new Playlist;
            $playlistObj->setKey(\Pimcore\File::getValidFilename(strtolower($playlistName)));
            $playlistObj->setParentId($folderUser->getId());
            $playlistObj->setUser($this->getUser());
            $playlistObj->setName($playlistName);
            $playlistObj->setPublished(true);
            $playlistObj->save();

            return back()->with([
                'message' => 'berhasil'
            ]);

        } catch (\Exception $e) {
            return back()->with([
                'message' => 'gagal'
            ]);
        }
    }

    public function songStore(Request $request)
    {
        $songId = $request->get('song_id');
        $playlistId = $request->get('playlist_id');

        try {

            $addSong = PlaylistHelper::checkAndAddSong($playlistId, $songId);
            if ($addSong) {
                return back()->with([
                    'message' => 'berhasil'
                ]);
            }

            return back()->with([
                'message' => 'gagal'
            ]);

        } catch (\Exception $e) {
            return back()->with([
                'message' => 'gagal'
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $getSongs = PlaylistHelper::getSongByPlaylistId($id);
        return view('web.playlistdetail', [
            'listplaylists' => $getSongs
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
