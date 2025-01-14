<?php

namespace App\Models;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\File;

class Post
{
    public static function all(){
        $files = File::files(resource_path() . "/posts/");
        return array_map(function ($file){
            return $file->getContents();
        }, $files);
    }

    public static function find($slug)
    {
        // $path = base_path() . "/resources/posts/{$slug}.html";
        $path = resource_path() . "/posts/{$slug}.html";

        if(! file_exists($path)){
            throw new ModelNotFoundException();
            // abort(404);
        }

        $post = cache()->remember("posts.{$slug}", 5, function () use ($path){
            var_dump('mise en cache');
            return file_get_contents($path);
        });

        return view('post', [
            'post' => $post    
        ]);
    }
}