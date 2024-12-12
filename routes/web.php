<?php
use App\Http\Controllers\BookCategoryController;
use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;
use App\Exports\BooksExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Imports\BooksImport;

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
    return redirect()->route('books.index');
});

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
