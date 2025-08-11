<?php

use Illuminate\Support\Facades\Route;
use Modules\Notes\Http\Controllers\NotesController;

Route::middleware(['auth'])->group(function () {
    Route::resource('notes', NotesController::class)->names('notes');
    Route::post('notes/storePrivateBoard', [NotesController::class, 'storePrivateBoard'])->name('notes.storePrivateBoard');
    Route::post('notes/storePrivateTask', [NotesController::class, 'storePrivateTask'])->name('notes.storePrivateTask');
    Route::post('notes/updatePosition', [NotesController::class, 'updatePosition'])->name('notes.updatePosition');
    Route::put('notes/{id}/updatePrivateBoard', [NotesController::class, 'updatePrivateBoard'])->name('notes.updatePrivateBoard');
    Route::delete('notes/delete-board/{id}', [NotesController::class, 'deleteBoard'])->name('notes.deleteBoard');
    Route::put('notes/update-note/{id}', [NotesController::class, 'updateNote'])->name('notes.updateNote');
    Route::delete('notes/delete-note/{id}', [NotesController::class, 'deleteNote'])->name('notes.deleteNote');
});
