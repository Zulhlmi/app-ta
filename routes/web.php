<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return response()->redirectTo('login');
});

//Auth::routes();

$this->get('login', 'Auth\LoginController@showLoginForm')->name('login');
$this->post('login', 'Auth\LoginController@login');
$this->post('logout', 'Auth\LoginController@logout')->name('logout');

$this->get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
// comment the default and changed to RegisterCustomController;
//$this->post('register', 'Auth\RegisterController@register');
$this->post('register', 'Auth\RegisterCustomController@register');

$this->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
$this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
$this->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
$this->post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

Route::get('/home', 'HomeController@index')->name('home');

/**
 * need auth
 */
Route::group(['middleware' => ['auth', 'view.variable']], function () {
    Route::get('profile', 'Web\ProfileController@index')->name('profile');
    Route::post('profile', 'Web\ProfileController@update');

    Route::get('artist', 'Web\ArtistController@index')->name('artist');
    Route::get('artist/{id}', 'Web\ArtistController@show')->name('artist.detail');

    Route::get('genre', 'Web\GenreController@index')->name('genre');
    Route::get('genre/{id}', 'Web\GenreController@show')->name('genre.detail');

    Route::get('album', 'Web\AlbumController@index')->name('album');
    Route::get('album/{id}', 'Web\AlbumController@show')->name('album.detail');

    Route::get('toptrack', 'Web\TopTrackController@index')->name('toptrack');

    Route::get('favourite', 'Web\FavouriteController@index')->name('favourite');

    Route::get('history', 'Web\HistoryController@index')->name('history');

    Route::get('playlist', 'Web\PlaylistController@index')->name('playlist');
    Route::post('playlist', 'Web\PlaylistController@store')->name('playlist.add');
    Route::post('playlist/song/add', 'Web\PlaylistController@songStore')->name('playlist.song.add');
    Route::get('playlist/detail/{id?}', 'Web\PlaylistController@show')->name('playlist.detail');

    Route::group(['prefix' => 'interaction'], function () {
        Route::get('/', function () {
            return Response('Test', 201);
        });

        Route::post('favourite/{song_id?}', 'Web\InteractionController@favourite')->name('web.interaction.favourite');
        Route::post('favourite/remove/{i?}', 'Web\InteractionController@removeFavourite')->name('web.interaction.remove.favourite');

        Route::post('queue/{song_id?}', 'Web\InteractionController@queue')->name('web.interaction.queue');
        Route::post('queue/remove/{i?}', 'Web\InteractionController@removeQueue')->name('web.interaction.remove.queue');

        Route::post('playlist/{song_id?}', 'Web\InteractionController@playlist')->name('web.interaction.playlist');

        Route::post('play/{song_id?}', 'Web\InteractionController@play')->name('web.interaction.play');

        Route::post('search', 'Web\InteractionController@search')->name('web.interaction.search');
    });
});
