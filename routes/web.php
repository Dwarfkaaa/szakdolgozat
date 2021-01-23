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
Auth::routes(['verify' => true]);

//like-dislike
Route::post('/like', 'GalleryController@update_gallery')->name('like');



//autocomplete
Route::get('/autocomplete', 'PositionQueryController@autocomplete')->name('autocomplete');
/////////////////////////////////


//login
Route::get('/emailverify', function(){
    return view('emailverify');
});

Route::get('/forgetpw', function(){
    return view('forgetpw');
});
///////////////////////////////////////////////////////////////////////////////////////////////////


//kezdolap
Route::get('/','PositionQueryController@index');
Route::post('/', 'LocationController@location');

// jelenlegi idojaras pozicio alapjan
//jelenlegi idojaras kereses alapjan
Route::match(array('GET', 'POST'), '/current', 'CurrentController@current');

//3 orankenti elorejelzes
Route::get('/threehours', function (){
    return view('threehours');
});
Route::match(array('GET', 'POST'), '/threehoursForecast', 'ThreehoursController@threehours');

//5 napos elorejelzes
Route::get('/fivedays', function (){
    return view('fivedays');
});
Route::post('/fivedaysForecast', 'FivedaysController@fivedays');

Route::get('/map', 'TerkepController@index')->name('map');

///////////////////////////////////////////////////////////////////////////////////////////////////

//profil
Route::get('/profile','UserController@index');
Route::post('/profile','UserController@update_avatar');

//galeria
Route::get('/gallery', 'PostController@index'); //galeria-mindenki szamara lathato
Route::post('/like','PostController@postLikePost')->name('like'); //like post
Route::match(array('GET', 'POST'), '/galleryupload', 'PostController@galleryupload');


//fobb varosok
Route::get('/budapest','BudapestController@index');
Route::get('/debrecen','DebrecenController@index');
Route::get('/pecs','PecsController@index');
Route::get('/sopron','SopronController@index');
Route::get('/szeged','SzegedController@index');

///////////////////////////////////////////////////////////////////////////////////////////////////

//providers
Route::get('auth/{provider}','Auth\RegisterController@redirectToProvider');
Route::get('auth/{provider}/callback','Auth\RegisterController@handleProviderCallback');

Route::get('/{any}','PositionQueryController@index'); //this will redirect to the index page if any unknown routing url is given by mistake or by purpose.
