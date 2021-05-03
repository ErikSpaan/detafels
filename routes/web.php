<?php

use App\Http\Controllers\PagesController;
use App\Http\Controllers\SumController;
use App\Http\Controllers\EventController;

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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/play/{event_id}', [App\Http\Controllers\PagesController::class, 'play'])->middleware('auth');
Route::get('/pauze/{sum_id}', [PagesController::class, 'pauze'])->middleware('auth');

Route::post('/nieuweopdracht/{event_id}', [App\Http\Controllers\PagesController::class, 'nieuweopdracht'])->middleware('auth');
Route::get('/finished', [App\Http\Controllers\PagesController::class, 'finished'])->middleware('auth');
Route::get('/showresults/{event_id}', [App\Http\Controllers\PagesController::class, 'showresults'])->middleware('auth');
Route::get('/', [App\Http\Controllers\PagesController::class, 'index'])->middleware('auth');
Route::get('/detafels', [App\Http\Controllers\PagesController::class, 'index'])->middleware('auth');
Route::resource('/events', EventController::class)->middleware('auth'); 
Route::resource('/sums', SumController::class)->middleware('auth'); 

Route::get('/test', [PagesController::class, 'test'])->middleware('auth');
Route::get('/logout', [PagesController::class, 'logout']);


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
