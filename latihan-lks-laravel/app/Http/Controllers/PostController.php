<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Helpers\CreateSlug;
use Illuminate\Http\Request;
use App\Http\Resources\ApiResources;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    
    public function index(){
        try {
            $post = Post::latest()->paginate();
            return new ApiResources(200, "payload post", $post);
        } catch (\Exception $e) {
            return new ApiResources(500, $e->getMessage(), []);
        }
    }
    public function show($id){
        try {
            $post = Post::find($id);
            if(!$post || $post == null){
                return new ApiResources(400, "data not found", []);
            }
            return new ApiResources(200, "payload detail post", $post);
        } catch (\Exception $e) {
            return new ApiResources(500, $e->getMessage(), []);
        }
    }
    public function store(Request $request){
        try {
             function postSlugCreation(String $text){
                $text = strtolower($text);
                $text = preg_replace('/[^a-z0-9\s]/','', $text);
                $text = preg_replace('/\s+/','-',$text);
                $text = trim($text, "-");
                return $text;
            };
            $validation = Validator::make($request->all(), [
                "title" => "required",
                "body" => "required",
                "author_id" => "required|exists:users,id",
                "category_id" => "required|exists:categories,id",
            ]);
            if($validation->fails()){
                return new ApiResources(401, $validation->errors(), []);
            }
            $getAuthorId = User::find($request->author_id);
            if(!$getAuthorId){
                return new ApiResources(400, "Author not found", []);
            }
            $post_slug = postSlugCreation($request->title);
            $cekduplikatslug = Post::where("slug", $post_slug)->exists();
            if($cekduplikatslug){
                return new ApiResources(403, "Duplikat coyyyyy", []);
            }
            $post = Post::with("users")->with("categories")->create([
                "title" => $request->title,
                "slug" => $post_slug,
                "body" => $request->body,
                "category_id" => $request->category_id,
                "author_id" => $request->author_id
            ]);
            if(!$post){
                return new ApiResources(422, "Failed to add", []);
            }
            return new ApiResources(200, "success to add post", $post);
        } catch (\Exception $e) {
            return new ApiResources(500, $e->getMessage(), []);
        }
    }
    public function update(Request $request, $id){
        try {
            function postSlugCreations(String $text){
                $text = strtolower($text);
                $text = preg_replace('/[^a-z0-9\s]/','', $text);
                $text = preg_replace('/\s+/','-',$text);
                $text = trim($text, "-");
                return $text;
            };
            if(!$id){
                return new ApiResources(400, "Id User must not be null", null);
            }
            $validator = Validator::make($request->all(), [
                "title" => "required",
                "body" => "required",
                "category_id" => "required|exists:categories,id",
                "author_id" => "required|exists:users,id",
            ]);
            if($validator->fails()){
                return new ApiResources(400, $validator->errors(), []);
            }
            $post_slug = postSlugCreations($request->title);
            $cekduplikatslug = Post::where("slug", $post_slug)->where("id", "!=", $id)->exists();
            if($cekduplikatslug){
                return new ApiResources(401, "Duplikat slug", []);
            }

            $post = Post::find($id)->update([
                "title" => $request->title,
                "body" => $request->body,
                "slug" => $post_slug,
                "category_id" => $request->category_id,
                "author_id" => $request->author_id,
            ]);
            if(!$post){
                return new ApiResources(400, "failed to update post", []);
            }
            return new ApiResources(200, "success to update post", $post);
        } catch (\Exception $e) {
            return new ApiResources(500, $e->getMessage(), []);
        }
    }
    public function destroy($id){
        try {
            $checkpost = Post::find($id);
            if(!$checkpost){
                return new ApiResources(401, "post not found", null);
            }
            $post = Post::destroy($id);
            if(!$post){
                return new ApiResources(400, "failed to delete post", null);
            }
            return new ApiResources(200, "success to delete post", $post);
        } catch (\Exception $e) {
            return new ApiResources(500, $e->getMessage(), []);
        }
    }
}