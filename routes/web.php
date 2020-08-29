<?php
use App\Helpers\helper;
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

// Route::get('/', function () {
//     return view('index');
// });

Route::get('/', "AdsController@index");


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('ads', 'AdsController');

Route::get('test',function(){
    return helper::slug('موقع إعلانات مبوبة');
});
Route::get('userAds', 'AdsController@getUserAds');
Route::get('category/{id}/{slug}', 'AdsController@getByCategory');
Route::get('ad/{id}/{slug}','AdsController@show');
Route::post('search','AdsController@search');
Route::post('ads/{id}/favorite','FavoriteController@store');
Route::post('ads/{id}/unfavorite','FavoriteController@destroy');
Route::get('userFav','FavoriteController@index')->middleware('auth');
Route::post('comments/store','CommentController@store')->name('comments.store');
Route::post('comment/reply', 'CommentController@reply');
Route::post('sendMail','SendMailController@sendMail');

