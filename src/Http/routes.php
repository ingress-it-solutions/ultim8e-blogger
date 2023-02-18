<?php

use Illuminate\Support\Facades\Route;
use IngressITSolutions\Ultim8eBlogger\Http\Controllers\PostController;

Route::name('ultim8e-blogger.')->group(function (): void {
    Route::get(config('ultim8e-blogger.url'), [
        PostController::class,
        'index',
    ])->name('index');
    Route::get(config('ultim8e-blogger.url') . '/{post}', [
        PostController::class,
        'show',
    ])->name('show');
});
