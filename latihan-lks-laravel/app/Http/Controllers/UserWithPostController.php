<?php

namespace App\Http\Controllers;

use App\Http\Resources\ApiResources;
use App\Models\User;
use Illuminate\Http\Request;

class UserWithPostController extends Controller
{
    public function index(){
        try {
            $user = User::with( "posts")->get();
            return new ApiResources(200, "Payload user with post", $user);
        } catch (\Exception $e) {
            return new ApiResources(500, $e->getMessage(), []);
        }
    }

    public function show($id){
        try {
            $user = User::with("posts")->find($id);
            if(!$user || $id == null){
                return new ApiResources(400, "User not found", []);
            };
            return new ApiResources(200, "Payload detail user with post", $user);
        } catch (\Exception $e) {
            return new ApiResources(500, $e->getMessage(), []);
        }
    }
    
}