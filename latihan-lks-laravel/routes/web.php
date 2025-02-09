<?php

use App\Http\Controllers\UserController;
use App\Models\Item;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get("/post", function() {
    return view("post", ["post" => Post::all(), "total_post" => count(Post::all()) ]);
});
Route::get("/item", function() {
    return view("item", ["item" => Item::all()]);
});
Route::get("/post/{post:slug}", function(Post $post) {
    return view("detail-post", ["post" => $post]);
});
Route::get("/authors/{user:username}", function(User $user) {
    return view("post", ["post" => $user->posts, "total_post" => count($user->posts)]);
});

Route::get("/testing", function(User $user){
    return $user->email;
});

// API 
// Route::prefix("api")->group(callback: function(){
//     Route::prefix("user")->group(function(){
//         Route::get("/", [UserController::class, "index"]);
//         Route::get("/{id}", [UserController::class, "show"]);
//         Route::post("/", [UserController::class, "store"]);
//         Route::put("/{id}", [UserController::class, "update"]);
//         Route::delete("/", [UserController::class, "destroy"]);
//     });
// });