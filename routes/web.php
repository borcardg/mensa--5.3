<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

//Route::get('logout', [ 'uses' => 'Auth\AuthController@getLogout', 'as' => 'logout' ]);

//Route::controllers([
//    'auth' => 'Auth\AuthController',
//    'password' => 'Auth\PasswordController',
//]);
echo 'Test';

/*$this->get('login', 'Auth\LoginController@showLoginForm')->name('login');
$this->post('login', 'Auth\LoginController@login');
$this->post('logout', 'Auth\LoginController@logout')->name('logout');*/

/*// Login
Route::group(['middleware' => ['web']], function() {
    Route::get('login-new-address', ['as' => 'login', 'uses' => 'Auth\LoginController@showLoginForm']);
    Route::post('login-new-address', ['as' => 'login.post', 'uses' => 'Auth\LoginController@login']);
    Route::post('logout-new-address', ['as' => 'logout', 'uses' => 'Auth\LoginController@logout']);
});
// Registration Routes...
Route::get('register', ['as' => 'register', 'uses' => 'Auth\RegisterController@showRegistrationForm']);
Route::post('register', ['as' => 'register.post', 'uses' => 'Auth\RegisterController@register']);

// Password Reset Routes...
Route::get('password/reset', ['as' => 'password.reset', 'uses' => 'Auth\ForgotPasswordController@showLinkRequestForm']);
Route::post('password/email', ['as' => 'password.email', 'uses' => 'Auth\ForgotPasswordController@sendResetLinkEmail']);
Route::get('password/reset/{token}', ['as' => 'password.reset.token', 'uses' => 'Auth\ResetPasswordController@showResetForm']);
Route::post('password/reset', ['as' => 'password.reset.post', 'uses' => 'Auth\ResetPasswordController@reset']);
*/

Route::get('auth/logout', 'Auth\LoginController@getLogout');

Route::group(['middleware' => 'web'], function () {
    Route::get('/', 'HomeController@index');
    Route::get('/home', 'HomeController@index');
    Route::resource('labels', 'LabelController');
    Route::resource('menus', 'MenuController');
    Route::resource('notices', 'NoticeController');
    Route::resource('openHours', 'OpenHourController');
    Route::resource('openPeriods', 'OpenPeriodController');
    Route::resource('sites', 'SiteController');

    Route::get('/label/form/{action}/{id}', 'LabelController@form');
    Route::get('/sites/form/{action}/{id}', 'SiteController@form');
    Route::get('/menu/form/{action}/{id}', 'MenuController@form');
    Route::get('/notice/form/{action}/{id}', 'NoticeController@form');

    Route::get('generate-word/{id}/{date}', 'SiteController@generateWord');

    Route::get('generate-pdf/{id}/{date}', 'SiteController@generatePdf');

    Route::any('sites/{id}/{date}', [
        'as' => 'sites.weekly', 'uses' => 'SiteController@weekly',
    ]);

    Route::any('sites/{sites}/week', [
        'as' => 'sites.week', 'uses' => 'SiteController@week',
    ]);
});

Route::group(['prefix' => 'api/v1'], function () {

    // Get weekly menus for a site based on today date
    Route::get('weekly-menus', [
        'as' => 'api.weekly.menus', 'uses' => 'Api\v1\SiteController@weeklyMenus',
    ]);

    // Get today main menu for each site
    Route::get('menus', [
        'as' => 'api.today.menus', 'uses' => 'Api\v1\SiteController@todayMenus',
    ]);

    // Get all sites
    Route::get('sites', [
        'as' => 'api.sites.index', 'uses' => 'Api\v1\SiteController@index',
    ]);

    // Get a site
    Route::get('today/{id}', [
        'as' => 'api.sites.todayMenus', 'uses' => 'Api\v1\SiteController@todayMenus',
    ]);
    // Get a site
    Route::get('sites/{id}', [
        'as' => 'api.sites.show', 'uses' => 'Api\v1\SiteController@show',
    ]);

    Route::get('labels', [
        'as' => 'api.labels.index', 'uses' => 'Api\v1\LabelController@index',
    ]);

    Route::get('generate-pdf/{id}/{date}', [
        'as' => 'generate.pdf', 'uses' => 'SiteController@generatePdf',
    ]);
});
