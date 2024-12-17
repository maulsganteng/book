<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookCategoryController;
use App\Http\Controllers\BookController;

use App\Exports\BooksExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Imports\BooksImport;
use App\Http\Controllers\Auth\SocialateController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

//CRUD category
Route::resource('book-categories', BookCategoryController::class);
Route::resource('books', BookController::class);


Route::get('/export-books', function () {
    return Excel::download(new BooksExport, 'books.xlsx');
})->name('books.export');


Route::post('/import-books', function (Request $request) {
    $request->validate([
        'file' => 'required|mimes:xlsx,csv',
    ]);

    Excel::import(new BooksImport, $request->file('file'));

    return redirect()->back()->with('success', 'Books imported successfully.');
});

Route::get('/auth/redirect', [SocialateController::class,'redirect']);

Route::get('/auth/google/callback',[SocialateController::class,'callback']);