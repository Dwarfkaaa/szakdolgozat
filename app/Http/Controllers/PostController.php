<?php

namespace App\Http\Controllers;



use App\Item_model;
use App\User;
use Illuminate\Http\Request;

use App\Like;
use App\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class PostController extends Controller
{
    //kepfeltoltes menupont


    //kepek megjelenitese mindenki szamara
    public function index(Request $request){

;
     $posts =  Post::with('likes', 'dislikes')
            ->get();

        return view('gallery', compact('posts'));
    }

    //kepfeltoltesbol ide iranyit ha sikeres a kepfeltoltes
    public function galleryupload(Request $request){

        $post = new Post();
        $post->name =  $request->input('name');
        $post->description = $request->input('description');
        $post->user_id = Auth::id();
        $rules = array(
            'image' => 'required | mimes:jpeg,jpg,png |max:4000',
        );
        $validator = Validator::make($request->all(), $rules);

        if( $request->input('description') == '' || $rules == ''){
            return view('galleryupload', array('user' => Auth::user()));
        }
        if ($validator->fails()) {
            return Redirect::back()
                ->withErrors($validator)
                ->withInput();
        }
        $post->image = $request->input('image');
        if($request->hasFile('image')){
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            Image::make($file)->save( public_path('/images/galeries/' . $filename));
            $post->image = $filename;
            $post->save();
        }


        return view('galleryupload', array('user' => Auth::user()));
    }

    public function fuggveny(Request $request){
        $valtozo1 = $request['picker1']; // elso picker id-je
        $valtozo2 = $request['picker2']; //a masodik picker id-je
        $date = $valtozo1 . $valtozo2; //date az mar 1 stringlesz
    }


    //like post
    public function postLikePost(Request $request)
    {
        $post_id = $request['postId'];
        $is_like = $request['isLike'] === 'true';
        $update = false;
        $post = Post::find($post_id);
        if (!$post) {
            return null;
        }
        $user = Auth::user();
        $like = $user->likes()->where('post_id', $post_id)->first();
        if ($like) {
            $already_like = $like->like;
            $update = true;
            if ($already_like == $is_like) {
                $like->delete();
                return null;
            }
        } else {
            $like = new Like();
        }
        $like->like = $is_like;
        $like->user_id =  Auth::id();
        $like->post_id = $post->id;
        if ($update) {
            $like->update();
        } else {
            $like->save();
        }
        return null;
    }
}
