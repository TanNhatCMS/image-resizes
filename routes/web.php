<?php
use Illuminate\Support\Facades\Route;
use Tannhatcms\ImageResizes\Controllers\ImageController;
// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
    ),
], function () {
    Route::get('resize/{size}/{imagePath}',  [ImageController::class, 'flyResize'])->where('imagePath', '(.*)');
    Route::get('resizes/{size}/{imagePath}',  [ImageController::class, 'flyResize'])->where('imagePath', '(.*)');
    Route::get('webp/{size}/{imagePath}',  [ImageController::class, 'webpflyResize'])->where('imagePath', '(.*)');
    Route::get('/storage/thumbnail/{size}/{id}',  [ImageController::class, 'thumbnails']);
   // Route::get('/storage/thumbnail/{id}-{size}.{ext}',  [ImageController::class, 'thumbnail']);
});

