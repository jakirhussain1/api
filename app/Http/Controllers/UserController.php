<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    function users($id=null)
    {
        if($id=="")
        {
            $users = User::get();
            return response()->json(["users"=>$users],200);

        }else{
            $user =User::find($id);
            return response()->json(["users"=>$user],200);
        }


    }
    function create(Request $request)
    {
        if($request->isMethod("post"))
        {
            $data = $request->all();

            $rules = [
                "name"=> "required",
                "email"=> "required|email",
                "password"=> "required",
            ];
            $message = [
                "name.required"=> "Name field required",
                "email.required"=> "Email field required",
                "password.required"=> "Password field required",
                "email.email"=> "Email must be and valid mail",
            ];
            $validate = validator($data,$rules,$message);
            if($validate->fails())
            {
                return response()->json(["error",$validate->errors()],422);
            }
            $user = new User;
            $user->name = $data['name'];
            $user->email = $data['email'];
            $user->password = bcrypt($data['password']);
            $user->save();
            $insertMessage = "User Created Successfully!";
            return response()->json(['success'=>$insertMessage],201);
        }
    }


    function update(Request $request,$id)
    {
        if($request->isMethod("put"))
        {
            $data = $request->all();

            $rules = [
                "name"=> "required",
                "password"=> "required",
            ];
            $message = [
                "name.required"=> "Name field required",
                "password.required"=> "Password field required",
            ];
            $validate = validator($data,$rules,$message);
            if($validate->fails())
            {
                return response()->json($validate->errors(),422);
            }
            $user = User::find($id);
            $user->name = $data['name'];
            $user->password = bcrypt($data['password']);
            $user->update();
            $insertMessage = "User Updated Successfully!";
            return response()->json(['success'=>$insertMessage],202);
        }
    }

}
