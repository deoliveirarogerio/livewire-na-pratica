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
use App\Http\Livewire\Expense\{
    ExpenseCreate,
    ExpenseEdit,
    ExpenseList
};
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

// EXPENSES
Route::middleware(['auth:sanctum', 'verified'])->group(function(){
    Route::prefix('expenses')->name('expenses.')->group(function(){

        Route::get('/', ExpenseList::class)->name('index');
        Route::get('/create', ExpenseCreate::class)->name('create');
        Route::get('/edit/{expense}', ExpenseEdit::class)->name('edit');

        Route::get('/{expense}/photo', function($expense) {
            $expense = auth()->user()->expenses()->findOrFail($expense);

            //Pegar a imagem
            if(!Storage::disk('public')->exists($expense->photo))
                return abort(404, 'Image Not Found');

            $image = Storage::disk('public')->get($expense->photo);
            $mimeType = File::mimeType(storage_path('app/public/' . $expense->photo));

            return response($image)->header('Content-Type', $mimeType);
            //Retornar ela como imagem

        })->name('photo');

    });
});
