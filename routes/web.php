<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('posts');
});

Route::get('/cache', function () {
    $cache = cache()->remember("user", 0.5, function() {
        echo "dans le cache \n";
        return "!! \n";
    });
    echo $cache;
});

Route::get('/posts/{post}', function ($slug) {
    $path = __DIR__ . "/../resources/posts/{$slug}.html";

    if(! file_exists($path)){
        return redirect('/');
        // abort(404);
    }

    $post = cache()->remember("posts.{$slug}", 5, function () use ($path){
        var_dump('mise en cache');
        return file_get_contents($path);
    });

    return view('post', [
        'post' => $post
    ]);
})->where('post', '[A-z_/-]+');
// })->whereAlpha('post');
