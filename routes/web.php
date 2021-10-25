<?php

use App\Http\Controllers\MovieController;
use App\Http\Controllers\RatingController;
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

Route::get('/', function () {
    //return view('welcome');
    return redirect()->route('movies.index');
});

Route::resource('movies', MovieController::class);
Route::resource('ratings', RatingController::class);
/*
    2. felvonáshoz

Route::get('/movies/create', function () {
    return view('movies.create');
})->name('movies.create');

Route::post('/movies/store', function ($Request request) {
    $validated = request->validate([
        'title' => 'required | min:2',
        ... ... ...
    ], [

    ]);
})->name('movies.store');

*/

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
