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
    return redirect()->route('movies.index');
});


Route::get('/movies/toplist', [MovieController::class, 'toplist'])->name('movies.toplist');
Route::get('/ratings/destroyAll/{id}',[RatingController::class, 'destroyAll'])->withTrashed()->name('ratings.destroyAll');

Route::get('/movies/show/{id}', [MovieController::class, 'show'])->withTrashed()->name('movies.show');
Route::get('/movies/edit/{id}', [MovieController::class, 'edit'])->withTrashed()->name('movies.edit');
Route::get('/movies/update/{id}', [MovieController::class, 'update'])->withTrashed()->name('movies.update');
Route::get('/movies/restore/{id}', [MovieController::class, 'restore'])->withTrashed()->name('movies.restore');

Route::resource('movies', MovieController::class);
Route::resource('ratings', RatingController::class);


Route::post('store/{slug}/{id}', [RatingController::class, 'store']);
Route::get('edit/{movie_id}/{id}', [RatingController::class, 'edit']);
Route::post('update/{id}', [RatingController::class, 'update']);

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
