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
    Route::post('notes/storePublicBoard', [NotesController::class, 'storePublicBoard'])->name('notes.storePublicBoard');
    Route::put('notes/update-public-board/{id}', [NotesController::class, 'updatePublicBoard'])->name('notes.updatePublicBoard');
    Route::delete('notes/delete-public-board/{id}', [NotesController::class, 'deletePublicBoard'])->name('notes.deletePublicBoard');
    Route::post('notes/storePublicTask', [NotesController::class, 'storePublicTask'])->name('notes.storePublicTask');
    Route::delete('notes/delete-public-note/{id}', [NotesController::class, 'deletePublicNote'])->name('notes.deletePublicNote');
    Route::get('notes/note-details/{uuid}', [NotesController::class, 'noteDetails'])->name('notes.noteDetails');
    Route::post('notes/store-comment', [NotesController::class, 'storeComment'])->name('notes.storeComment');
    Route::delete('notes/delete-comment/{id}', [NotesController::class, 'deleteComment'])->name('notes.deleteComment');
    Route::put('notes/update-comment/{id}', [NotesController::class, 'updateComment'])->name('notes.updateComment');

    // Attachments
    Route::post('notes/store-attachment', [NotesController::class, 'storeAttachment'])->name('notes.storeAttachment');
    Route::delete('notes/delete-attachment/{id}', [NotesController::class, 'deleteAttachment'])->name('notes.deleteAttachment');
    Route::get('notes/download-attachment/{id}', [NotesController::class, 'downloadAttachment'])->name('notes.downloadAttachment');


});
