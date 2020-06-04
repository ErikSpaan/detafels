<?php

use Illuminate\Support\Facades\Route;

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
//     return view('welcome');
// });

//Route::get('/' , 'PagesController@index');




Auth::routes();
Route::get('/play/{event_id}', 'PagesController@play')->middleware('auth');
Route::get('/pauze/{sum_id}', 'PagesController@pauze')->middleware('auth');
Route::post('/nieuweopdracht/{event_id}', 'PagesController@nieuweopdracht')->middleware('auth');
Route::get('/finished', 'PagesController@finished')->middleware('auth');
Route::get('/showresults/{event_id}', 'PagesController@showresults')->middleware('auth');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/', 'PagesController@index')->middleware('auth');
Route::get('/detafels', 'PagesController@index')->middleware('auth');
Route::resource('/events','EventController')->middleware('auth'); 
Route::resource('/sums','SumController')->middleware('auth'); 
Route::get('/test', 'PagesController@test')->middleware('auth');
Route::get('/logout', 'PagesController@logout');


//Route cache:
Route::get('/route-cache', function() {
	$exitCode = Artisan::call('route:cache');
	return 'Routes cache';
});

//clear Route cache:
Route::get('/route-clear', function() {
	$exitCode = Artisan::call('route:clear');
	return 'Routes cache cleared';
});

//Config cache:first  ***************
Route::get('/config-cache', function() {
	$exitCode = Artisan::call('config:cache');
	return 'Config cache';
}); 

// Clear config/application cache:
Route::get('/cache-clear', function() {
	$exitCode = Artisan::call('cache:clear');
	return 'Config / Application cache cleared';
});

// Clear view cache:
Route::get('/view-clear', function() {
	$exitCode = Artisan::call('view:clear');
	return 'View cache cleared';
});

//view cache: second ********************
Route::get('/view-cache', function() {
	$exitCode = Artisan::call('view:cache');
	return 'View cache';
});

// Clear optimize clear all:
Route::get('/optimize', function() {
	$exitCode = Artisan::call('optimize:clear');
	return 'all cleared';
});
