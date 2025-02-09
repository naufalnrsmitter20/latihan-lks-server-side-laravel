<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Rules\FormatUsernameRule;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResources;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index(){
        try {
           $user =  User::latest()->paginate(100);
           return new ApiResources(200, "success to load data", $user);
        } catch (\Exception $e) {
            return new ApiResources(500, $e->getMessage(), []);
        }
    }

    public function show($id){
        try {
            $user = User::find($id);
            return new ApiResources(200, "success to load data", $user);
        } catch (\Exception $e) {
            return new ApiResources(500, $e->getMessage(), []);
        }
    }

    public function store(Request $request){
        try {
            $validator = Validator::make($request->all(), [
                "name" => "required|",
                "email" => "required|email|unique:users",
                "username" => "required|unique:users",
                "password" => "required",
            ]);

            $validateformat = $request->validate([
                "username" => ["required", new FormatUsernameRule()],
            ]);
            $cekduplicatemail = User::where("email", $request->email)->exists();
            $cekduplicatusername = User::where("username", $request->username)->exists();
            if($cekduplicatemail){
                return new ApiResources(401, "Duplikat woyy", []);
            }
            if($cekduplicatusername){
                return new ApiResources(401, "Duplikat woyy", []);
            }
            if($validator->fails() && !$validateformat){
                return response()->json($validator->errors(), 400);
            }

            $hash_password = Hash::make($request->password);
            $user = User::create([
                "name" => $request->name,
                "email" => $request->email,
                "username" => $request->username,
                "password" => $hash_password
            ]);
            return new ApiResources(200, "success to insert data", $user);
        } catch (\Exception $e) {
           return new ApiResources(500, $e->getMessage(), []);
        }
    }

    public function update(Request $request, $id){
        try {
            $getuserid = User::find($id);
            if(!$getuserid || $getuserid == null){
                return new ApiResources(401, "User not found", []);
            };

            $validator = Validator::make($request->all(), [
                "name" => "required|",
                "email" => "required|email|unique:users",
                "username" => "required|unique:users",
                "password" => "required",
            ]);

            $cekduplicatemail = User::where("email", $request->email)->where("id", "!=", $id)->exists();
            $cekduplicatusername = User::where("username", $request->username)->where("id", "!=", $id)->exists();
            if($cekduplicatemail){
                return new ApiResources(401, "Duplikat woyy", []);
            }
            if($cekduplicatusername){
                return new ApiResources(401, "Duplikat woyy", []);
            }

            if($validator->fails()){
                return response()->json($validator->errors(), 400);
            };

            $hash_password = Hash::make($request->password);
            $user = User::find($id)->update([
                "name" => $request->name,
                "email" => $request->email,
                "username" => $request->username,
                "password" => $hash_password
            ]);
            return new ApiResources(200, "Success to update data", $user);
        } catch (\Exception $e) {
           return new ApiResources(500, $e->getMessage(), []);
        }
    }  

    public function destroy($id){
        try {
            $finduserbyid = User::find($id);
            if(!$finduserbyid || $finduserbyid == null){
                return new ApiResources(401, "User not found", []);
            }
            $user = User::destroy($id);
            return new ApiResources(200, "Success to delete data", $user ? null : "Apalah");
        } catch (\Exception $e) {
           return new ApiResources(500, $e->getMessage(), []);
        }
    }


    public function testing(){
        try {
            return new ApiResources(200, "Testing Success", ["data" => "testing"]);
        } catch (\Exception $e) {
            return new ApiResources(500, $e->getMessage(), []);
        }
    }
   
}