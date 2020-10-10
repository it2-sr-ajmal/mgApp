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


// Admin login route
Route::group(['prefix' => Config::get('app.admin_prefix'), 'namespace' => 'Admin'], function () {
	Route::match(array('GET', 'POST'), '/', 'LoginController@index')->name('admin_login');
	Route::match(array('GET', 'POST'), '/login', 'LoginController@index')->name('admin_login_login');
	Route::match(array('GET', 'POST'), '/create', array('uses' => 'LoginController@create_admin_account'));
});
Route::group(['prefix' => Config::get('app.admin_prefix'), 'namespace' => 'Admin', 'middleware' => ['adminAuth', 'IsAdmin']], function () {

	Route::match(array('GET'), 'resend-verification-link/{userId}', 'UsersController@resendEmailVerification');
	Route::match(array('GET'), 'verify-user/{userId}', 'UsersController@verifyUser');
	/**
	 * COMMON ROUTES
	 */
	Route::get('/', 'UsersController@dashboard')->name('admin_dashboard');
	Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
	Route::get('dashboard', 'UsersController@dashboard')->name('admin_dashboard');
	Route::match(array('GET', 'POST'), 'change_password', 'AdminController@change_password');
	Route::get('/logout', 'LoginController@logout');
	Route::match(array('GET'), '/audit_logs', 'AuditController@index')->name('admin_audit_logs');

	/* Users */
	Route::get('/users', 'UsersController@index')->name('users');
	Route::match(array('GET', 'POST'), '/admin_users/create', 'UsersController@create')->name('admin_user_create');
	Route::match(array('GET', 'POST'), '/users/update/{id}', 'UsersController@update')->name('user_update');
	Route::get('/users/delete/{id}', 'UsersController@delete')->name('user_delete');
	Route::get('/users/changestatus/{id}', 'UsersController@changestatus')->name('user_change_status');
	Route::get('/admin_users', 'UsersController@index')->name('admin_users');
	Route::match(array('GET', 'POST'), '/admin_users/update/{id}', 'UsersController@update')->name('admin_user_edit');
	Route::get('/admin_users/changestatus/{id}', 'UsersController@changestatus')->name('admin_user_change_status');

	/**
	 * POST COLLECTION - GENERAL PAGES
	 */
	Route::match(array('GET', 'POST'), 'post/{slug}', 'PostCollectionController@index')->name('post_index');
	Route::match(array('GET', 'POST'), 'post/{slug}/add', 'PostCollectionController@create')->name('post_create');
	Route::match(array('GET', 'POST'), 'post/{slug}/edit/{id}', 'PostCollectionController@edit')->name('post_edit');
	Route::match(array('GET', 'POST'), 'post/{slug}/changestatus/{id}/{status}', 'PostCollectionController@changestatus')->name('post_change_status');
	Route::match(array('GET', 'POST'), 'post/{slug}/delete/{id}', 'PostCollectionController@delete')->name('post_delete');
	Route::match(array('GET', 'POST'), 'post/{slug}/remove_meta_attachment/{field}/{about_id}', 'PostCollectionController@removeMetaAttachment');

	Route::match(array('GET', 'POST'), 'post_media/save_youtube_video', 'PostMediaController@save_youtube_video')->name('save_youtube_video');
	Route::match(array('GET', 'POST'), 'post_media/update_priority/', 'PostMediaController@update_priority')->name('post_media_update_priority');
	Route::match(array('GET', 'POST'), 'post_media/update_text/', 'PostMediaController@update_text')->name('post_media_update_text');

	Route::match(array('GET', 'POST'), 'post_media/{slug}', 'PostMediaController@index')->name('post_media_index');
	Route::match(array('GET', 'POST'), 'post_media/{slug}/add', 'PostMediaController@create')->name('post_media_create');
	Route::match(array('GET', 'POST'), 'post_media_download/{id}', 'PostMediaController@post_media_download');
	Route::match(array('GET', 'POST'), 'post_media/delete/{id}', 'PostMediaController@delete')->name('post_media_delete');

	
	
	
	/**
	 * ROLES & PERMISSIONS
	 */
	/* User Permissions */
	Route::match(array('GET', 'POST'), 'permissions', 'PermissionsController@index');
	Route::match(array('GET', 'POST'), 'permissions/create', 'PermissionsController@create');
	Route::match(array('GET', 'POST'), 'permissions/edit/{id}', 'PermissionsController@edit');
	Route::match(array('GET', 'POST'), 'permissions/update/{id}', 'PermissionsController@update');
	Route::match(array('GET', 'POST'), 'permissions/delete/{id}', 'PermissionsController@delete');

	/* Roles */
	Route::match(array('GET', 'POST'), 'roles', 'RolesController@index');
	Route::match(array('GET', 'POST'), 'roles/create', 'RolesController@create');
	Route::match(array('GET', 'POST'), 'roles/update/{id}', 'RolesController@update');
	Route::match(array('GET', 'POST'), 'roles/edit/{id}', 'RolesController@edit');
	Route::match(array('GET', 'POST'), 'roles/delete/{id}', 'RolesController@delete');

	


});
Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

Route::fallback(function () {
	return redirect()->to('/page-not-found');
});

