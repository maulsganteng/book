<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookCategoryController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\SendEmailController;
use App\Http\Controllers\PublisherController;


use App\Exports\BooksExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Imports\BooksImport;

use Illuminate\Support\Facades\Mail;
use App\Mail\SendEmail;
// use App\Http\Controllers\Auth\SocialateController;

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

require __DIR__ . '/auth.php';

//CRUD category
// Route::resource('book-categories', BookCategoryController::class);
// Route::resource('books', BookController::class);

Route::prefix('books')->group(function () {
    Route::get('/', [BookController::class, 'index'])->name('books.index');
    Route::get('/create', [BookController::class, 'create'])->name('books.create');
    Route::post('/', [BookController::class, 'store'])->name('books.store');
    Route::get('/{book}/edit', [BookController::class, 'edit'])->name('books.edit');
    Route::put('/{book}', [BookController::class, 'update'])->name('books.update');
    Route::delete('/{book}', [BookController::class, 'destroy'])->name('books.destroy');
});

Route::prefix('category')->group(function () {
    Route::get('/', [BookCategoryController::class, 'index'])->name('book-categories.index');
    Route::get('/create', [BookCategoryController::class, 'create'])->name('book-categories.create');
    Route::post('/', [BookCategoryController::class, 'store'])->name('book-categories.store');
    Route::get('/{category}/edit', [BookCategoryController::class, 'edit'])->name('book-categories.edit');
    Route::put('/{category}', [BookCategoryController::class, 'update'])->name('book-categories.update');
    Route::delete('/{category}', [BookCategoryController::class, 'destroy'])->name('book-categories.destroy');
});

Route::resource('authors', AuthorController::class);


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

// Route::get('/auth/redirect', [SocialateController::class,'redirect']);
Route::get('oauth/google', [\App\Http\Controllers\OauthController::class, 'redirectToProvider'])->name('oauth.google');
Route::get('oauth/google/callback', [\App\Http\Controllers\OauthController::class, 'handleProviderCallback'])->name('oauth.google.callback');
// Route::get('/auth/google/callback',[SocialateController::class,'callback']);

//send email
Route::get('/send-email', [SendEmailController::class, 'index'])->name('kirim-email');

Route::post('/post-email', [SendEmailController::class, 'store'])->name('post-email');

Route::get('/send',function(){
    $data = [
        'name' => 'Liljkt48',
        'body' => 'Testing Kirim Email di Santri Koding'
    ];
    
    Mail::to('muhammadfikri6910@smk.belajar.id')->send(new SendEmail($data));
    
    dd("Email Berhasil dikirim.");
});

Route::get('/publisher', [PublisherController::class, 'index'])->name('publisher.index');
Route::post('/publisher', [PublisherController::class, 'store'])->name('publisher.store');
Route::get('/publisher/create', [PublisherController::class, 'create'])->name('publisher.create');
Route::get('/publisher/{id}/edit', [PublisherController::class, 'edit'])->name('publisher.edit');
Route::put('/publisher/{id}', [PublisherController::class, 'update'])->name('publisher.update');
Route::get('/publisher/{id}/delete', [PublisherController::class, 'delete'])->name('publisher.delete');
Route::get('/send-email-test', [SendEmailController::class, 'SendEmail']);
