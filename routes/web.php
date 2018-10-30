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

// Route::get('/post', function () {
//     return view('posts');
// });

// Auth
Auth::routes();
// Common
Route::get('/', 'HomeController@index')->name('home'); 

Route::get('post','PostController@index')->name('post.index');

Route::get('post/{slug}.html','PostController@details')->name('post.details');

Route::get('category/{slug}','PostController@postByCategory')->name('category.posts');

Route::get('tag/{slug}','PostController@postByTag')->name('tag.posts');

Route::post('subsriber', 'SubscriberController@store')->name('subsriber.store');

Route::get('profile/{username}', 'AuthorPostController@profile')->name('author.profile'); 

Route::get('search','SearchController@search')->name('search');

Route::group(['middleware' => 'auth'], function () {

    Route::post('favorite/add/{id}','FavoriteController@add')->name('post.favorite.add');

    Route::post('comment/{id}','CommentController@store')->name('comment.store');

});

// admin
Route::group([ 'as'=>'admin.','prefix' => 'admin','namespace'=>'Admin','middleware'=>['auth','admin']], function () {

    Route::get('dashboard','DashboardController@index')->name('dashboard');
       
    Route::resource('tag','TagController');

    Route::resource('category','CategoryController');


    Route::get('settings','SettingsController@index')->name('settings.index');
    Route::PUT('settings/profile/{id}','SettingsController@updateprofile')->name('profile.update');
    Route::PUT('settings/password/{id}','SettingsController@updatepassword')->name('password.update');

    Route::resource('post','PostController');
    Route::get('pending/post','PostController@pending')->name('post.pending');

    Route::put('pending/{id}/pendding','PostController@penddingPost')->name('post.penddingpost');

    Route::put('pending/{id}/approve','PostController@approve')->name('post.approve');
    
    Route::resource('subsriber','SubscribersController');    

    Route::resource('favorite','FovoriteController');

    Route::resource('comments','CommentController');

    Route::resource('author','AuthorController');

});


// author
Route::group([ 'as'=>'author.','prefix' => 'author','namespace'=>'Author','middleware'=>['auth','author']], function () {
    Route::get('dashboard','DashboardController@index')->name('dashboard');
   
    Route::resource('post','PostController');

    Route::get('settings','SettingsController@index')->name('settings.index');
    Route::PUT('settings/profile/{id}','SettingsController@updateprofile')->name('profile.update');
    Route::PUT('settings/password/{id}','SettingsController@updatepassword')->name('password.update');


    Route::resource('favorite','FovoriteController');

    Route::resource('comments','CommentController');

});


// view composer footer
view()->composer('layouts.frontend.partial.footer', function ($view) {

    $categories = \App\Category::all();
    $view->with('categories',$categories);
});
