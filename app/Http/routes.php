<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/



/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

// These Routes For Installation we recommended you to delete them after install.
$newInstall = public_path().'/darky.sql';
$newUpdate  = public_path().'/update.sql';
if (file_exists($newInstall)) {
    Route::get('/install', 'InstallController@StartInstallation');
}
// Update Darky
if (file_exists($newUpdate)) {
    Route::get('/update', 'InstallController@StartUpdate');
}

// These Routes Only For Admin.
Route::group(['prefix' => 'dashboard', 'middleware' => ['web', 'admin']], function () {
    Route::get('/','AdminController@index');
    Route::get('/clear/stats','StatsController@Clear');
    Route::get('/comments','CommentController@admin');
    Route::get('/comments/flagged','CommentController@flagged');
    Route::get('/pages','PagesController@pages_list');
    Route::get('/pages/new','PagesController@new_page');
    Route::post('/pages/new','PagesController@create');
    Route::get('/categories/new','AdminController@NewCat');
    Route::post('/categories/new','CategoriesController@create');
    Route::get('/categories','CategoriesController@categories_list');
    Route::get('/edit/category/{id}','CategoriesController@editCategory');
    Route::post('/edit/category/{id}','CategoriesController@updateCategory');
    Route::post('/delete/category/{id}','CategoriesController@deleteCategory');
    Route::get('/edit/page/{id}','PagesController@editPage');
    Route::post('/edit/page/{id}','PagesController@updatePage');
    Route::post('/delete/page/{id}','PagesController@deletePage');
    Route::get('/ads','AdsController@index');
    Route::post('/ads','AdsController@update');
    Route::get('/users','UserController@users_list');
    Route::get('/stats','StatsController@index');
    Route::get('/settings','AdminController@Settings');
    Route::post('/settings','AdminController@updateSettings');
    Route::get('/profile','AdminController@profile');
    Route::get('/media','MediaController@settings');
    Route::get('/media/picture','MediaController@AdminSendPicture');
    Route::post('/media/picture','MediaController@AdminUploadPicture');
    Route::get('/media/video','MediaController@AdminSendVideo');
    Route::post('/media/video','MediaController@AdminUploadVideo');
    Route::get('/media/flagged','MediaController@flagged');
    Route::post('/approve/media/{id}','AdminController@approveMedia');
    Route::post('/delete/media/{id}','AdminController@deleteMedia');
    Route::post('/edit/media/{id}','AdminController@editMedia');
    Route::post('/update/media/{id}','AdminController@updateMedia');
    Route::post('/delete/user/{id}','AdminController@deleteUser');
    Route::post('/approve/comment/{id}','AdminController@approveComment');
    Route::post('/delete/comment/{id}','AdminController@deleteComment');
    Route::post('/edit/comment/{id}','AdminController@editComment');
    Route::post('/update/comment/{id}','AdminController@updateComment');
    Route::post('/mark/flag/{id}','CommentController@markFlag');
    Route::post('/deletebyflag/comment/{id}','CommentController@deleteComment');
    Route::post('/markbyflag/media/{id}','MediaController@markFlag');
    Route::post('/deletebyflag/media/{id}','MediaController@deleteMedia');
    Route::post('/profile/info','AdminController@adminInfo');
    Route::post('/profile/avatar','AdminController@adminAvatar');
    Route::post('/profile/password','AdminController@adminPassword');
    Route::get('/logout',function(){
    Auth::logout();
    return redirect('/');
    });
});




// These Routes will be able for all visitors.
Route::group(['middleware' => 'web'], function () {
    Route::auth();
    Route::get('/', 'HomeController@index');
    Route::get('/user/{name}', 'UserController@show');
    Route::get('/user/{username}/likes', 'UserController@likes');
    Route::get('/page/{page}', 'PagesController@show');
    Route::get('/category/{name}', 'CategoriesController@show_category');
    Route::get('/random', 'HomeController@random');
    Route::get('/search', 'SearchController@show_result');
    Route::get('/media/{url}', 'MediaController@show');
    Route::get('/upload', 'UploadController@index');
    Route::post('/upload', 'UploadController@upload');
});



// These Routes will be able only for actice users.
Route::group(['middleware' => ['web', 'user']], function () {
    Route::post('/comment/add/{url}', 'CommentController@addComment');
    Route::post('/like/{url}', 'MediaController@like');
    Route::get('/flag/media/{url}', 'MediaController@flag');
    Route::get('/flag/comment/{url}', 'CommentController@flag');
    Route::get('/notification', 'HomeController@Notification');
    Route::post('/mark/notification/{id}', 'HomeController@markNotification');
    Route::get('/user/{name}/edit', 'UserController@edit');
    Route::post('/user/{name}/edit', 'UserController@updateAccount');
});



// These Routes For Social Login
Route::group(['middleware' => 'web'], function () {
Route::get('/auth/facebook', 'Auth\SocialController@redirectToProvider');
Route::get('/auth/facebook/callback', 'Auth\SocialController@handleProviderCallback');

Route::get('/auth/twitter', 'Auth\twitterController@redirectToProvider');
Route::get('/auth/twitter/callback', 'Auth\twitterController@handleProviderCallback');

Route::get('/auth/google', 'Auth\googleController@redirectToProvider');
Route::get('/auth/google/callback', 'Auth\googleController@handleProviderCallback');

});


// These very important to check if javascript enabled.
Route::get('/js', function () {
    return view('plugins.js');
});


