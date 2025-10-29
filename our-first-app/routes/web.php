<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Models\Post;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // $posts = Post::all();
    // $posts = Post::where('user_id', auth()->guard()->id())->get();
    $posts = [];
    if (auth()->guard()->check()) {
        // $posts = auth()->guard()->user()->usersCoolPosts()->latest()->get();

        /** @var \App\Models\User $user */
        $user = auth()->guard()->user();
        $posts = $user->usersCoolPosts()->latest()->get();
    }

    // view to home.blade.php
    // 'posts' = is name that you choose can be use in home blade templete
    return view('home', ['posts' => $posts]);
});

// a = url, b = [1=controller class, 2=method of that class]
Route::post('/register', [UserController::class, 'register']);
Route::post('/logout', [UserController::class, 'logout']);
Route::post('/login', [UserController::class, 'login']);

// blogpost routes
Route::post('/create-post', [PostController::class, 'createPost']);
Route::get('/edit-post/{post}', [PostController::class, 'showEditScreen']);
Route::put('/edit-post/{post}', [PostController::class, 'actuallyUpdatePost']);
Route::delete('/delete-post/{post}', [PostController::class, 'deletePost']);
