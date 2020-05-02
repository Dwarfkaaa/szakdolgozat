<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, Redirect, Validator};
use Intervention\Image\Facades\Image;

class UserController extends Controller
{

//profil page
    public function index(){
        return view('profile', array('user' => Auth::user()));
    }

//avatar kepfeltoltes megvalositas
    public function update_avatar(Request $request){

        $rules = array(
            'avatar' => 'required | mimes:jpeg,jpg,png | max:3000',
        );

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return Redirect::back()
                ->withErrors($validator)
                ->withInput();
        }

            if($request->hasFile('avatar')){
                $avatar = $request->file('avatar');
                $filename = time() . '.' . $avatar->getClientOriginalExtension();
                Image::make($avatar)->resize(300,300)->save( public_path('/images/avatars/' . $filename));
                $user = Auth::user();
                $user->avatar = $filename;
                $user->save();
            }
            return view('profile', array('user'=> Auth::user()) );
    }


}
