<?php

use Illuminate\Support\Facades\Route;
use App\Models\Post;

Route::get('/', function () {
    return view('posts', [
        'posts' => Post::all()
    ]);
});

Route::get('/cache', function () {
    $cache = cache()->remember("user", 5, function() {
        dump('Mise en cache');
        return "Dans le cache \n";
    });
    echo $cache;
});

Route::get('/posts/{post}', function ($slug) {
    return Post::find($slug);
    
})->where('post', '[A-z_/-]+');
// })->whereAlpha('post');
