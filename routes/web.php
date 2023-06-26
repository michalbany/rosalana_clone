<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CommentLikeController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\NotificationController;

Route::get('/', function () {
    return view('auth.login');
})->middleware('guest');

Auth::routes(['verify' => true]);



Route::middleware(['auth', 'email_verified'])->group(function () {
    // Další trasy, které vyžadují ověřený e-mail a přihlášení
    Route::get('/home', [HomeController::class, 'index'])->name('home');


    //notifikace
    Route::get('/notifications/json', [NotificationController::class, 'getNotificationsJson'])->name('notifications.json');
    Route::post('/notifications/mark-as-read/{id}', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');



    Route::resource('posts', PostController::class);
    Route::get('/load-more-posts', [HomeController::class, 'loadMorePosts'])->name('load-more-posts');
    Route::get('/user/{id}', [UserProfileController::class, 'show'])->name('profile.show');
    Route::get('/users/{id}/load-more-posts', [UserProfileController::class, 'loadMoreUserPosts'])->name('loadMoreUserPosts');
    Route::post('/users/{id}/update-profile', [UserProfileController::class, 'updateProfile'])->name('updateProfile');
    Route::get('/post/{id}', [PostController::class, 'show'])->name('post.show')->middleware('record.post.view');

    Route::post('/post/{post}/like', [LikeController::class, 'like'])->name('post.like');
    Route::delete('/post/{post}/unlike', [LikeController::class, 'unlike'])->name('post.unlike');

    Route::post('/posts/{id}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::post('/comments/{id}/like', [CommentLikeController::class, 'like'])->name('comment.like');
    Route::delete('/comments/{id}/unlike', [CommentLikeController::class, 'unlike'])->name('comment.unlike');

    Route::get('/search', [SearchController::class, 'search'])->name('search');

    Route::post('/follow/{user}', [FollowController::class, 'follow'])->name('follow');
    Route::delete('/unfollow/{user}', [FollowController::class, 'unfollow'])->name('unfollow');

    Route::post('/closeRankModal', [UserProfileController::class, 'closeRankModal'])->name('user.closeRankModal')->middleware('auth');

    
});

Route::get('/email/verify', function () {
    return view('auth.verify');
})->middleware(['auth'])->name('verification.notice');
