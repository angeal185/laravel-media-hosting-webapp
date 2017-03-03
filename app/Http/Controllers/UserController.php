<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\User;
use Auth;
use Validator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;
use App\Message;

class UserController extends Controller
{

/**
* Create a new controller instance.
*
* @return void
*/

/**
* Show the application dashboard.
*
* @return \Illuminate\Http\Response
*/
    
    // Show User Profile
    public function show($name)
    {
        // Check if exists
        $user     = DB::table('users')->where('username', $name)->first();
        // Get site Settings
        $setting = DB::table('settings')->where('id', 1)->first();
        if ($user) {
            // User Exists
            $avatar   = $user->avatar;
            $cover    = $user->cover;
            $facebook = $user->facebook_profile;
            $twitter  = $user->twitter_profile;
            $time   = Carbon::createFromFormat('Y-m-d H:i:s', $user->created_at)->diffForHumans();
            // Send as array
            $data   = array(
                'name'     => $name,
                'avatar'   => $avatar,
                'cover'    => $cover,
                'time'     => $time,
                'facebook' => $facebook,
                'twitter'  => $twitter,
                'setting'  => $setting
            );
            return view('user')->with($data);
        }else{
            return redirect ('/');
        }
    }


    // Edit Profile Page
    public function edit($name)
    {
        // Check if exists
        $user   = DB::table('users')->where('username', $name)->first();
        // Get site Settings
        $setting = DB::table('settings')->where('id', 1)->first();

        if ($user AND (Auth::check()) AND (Auth::user()->username === $name)) {

            // User Exists, logged in and edit his profile
            $avatar   = $user->avatar;
            $cover    = $user->cover;
            $email    = $user->email;
            $facebook = $user->facebook_profile;
            $twitter  = $user->twitter_profile;

            // Send as array
            $data     = array(
                'name'     => $name,
                'avatar'   => $avatar,
                'cover'    => $cover,
                'email'    => $email,
                'facebook' => $facebook,
                'twitter'  => $twitter,
                'setting'  => $setting
            );
            return view('user_edit')->with($data);
        }else{
            // User Not exists or not logged in or not his profile
            return redirect ('/');
        }
    }


    // Update User Info

    public function updateAccount(Request $request)
    {
        // Make Validation
        $validator = Validator::make($request->all(), [
        'username' => 'required',
        'email'    => 'required|email'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', 'Oops! Something went wrong. Please try again.');
        }else{
            $id       = Auth::user()->id;
            $username = $request->input('username');
            $password = $request->input('password');
            $email    = $request->input('email');
            $facebook = $request->input('facebook');
            $twitter  = $request->input('twitter');
            $avatar   = $request->file('avatar');
            $cover    = $request->file('cover');

            // Check Double username or email
            $check_user = DB::table('users')->where('id', '!=' , $id)->first();
            if ($check_user) {
                if (($check_user->username == $username) OR ($check_user->email == $email)){
                    return redirect()->back()->with('error', 'Oops! Username or Email Already exists.');
                }
            }

            // If Upload Avatar
            if ($avatar){

                // Make Validation on image
                $validator = Validator::make($request->all(), [
                'avatar'   => 'image'
                ]);

                if ($validator->fails()) {
                    return redirect()->back()->with('error', 'Oops! Something went wrong. Please try again.');
                }else{
                    $avatarsPath = public_path().'/../../uploads/avatars/';
                    $avatarExt  = $avatar->getClientOriginalExtension();
                    $avatarName = rand(111111111, 999999999) . '.' . $avatarExt; 
                    $moveAvatar = $avatar->move($avatarsPath, $avatarName);
                    $avatar_url = url('/').'/uploads/avatars/'.$avatarName;

                    // Update Avatar
                    DB::table('users')
                    ->where('id', $id)
                    ->update([
                    'avatar'         => $avatar_url
                    ]);
                }
            }

            // If Upload Cover
            if ($cover) {

                // Make Validation on image
                $validator = Validator::make($request->all(), [
                'cover'   => 'image'
                ]);

                if ($validator->fails()) {
                    return redirect()->back()->with('error', 'Oops! Something went wrong. Please try again.');
                }else{
                    $destinationPath = public_path().'/../../uploads/covers/';
                    $extension = $cover->getClientOriginalExtension();
                    $fileName = rand(111111111, 999999999) . '.' . $extension; 
                    $upload_success = $cover->move($destinationPath, $fileName);
                    $cover_url = url('/').'/uploads/covers/'.$fileName;

                    // Update Cover
                    DB::table('users')
                    ->where('id', $id)
                    ->update([
                    'cover'         => $cover_url
                    ]);
                }
            }

            // If Change Password
            if ($password) {
                DB::table('users')
                ->where('id', $id)
                ->update([
                'password' => bcrypt($password)
                ]);
            }

            // Update Username, Email, Facebook and twitter
            DB::table('users')
            ->where('id', $id)
            ->update([
            'username'         => $username,
            'email'            => $email,
            'facebook_profile' => $facebook,
            'twitter_profile'  => $twitter
            ]);

            return redirect('/user/'.$username.'/edit')->with('success', 'Your profile was successfuly updated');
        }
    }//END FUNCTION


    // Show Users List to Admin
    public function users_list()
    {
        // Get All Users
        $users_list = User::all();
            return view('admin.users')->with('users_list', $users_list);
    }


    // User Favorites Media Page
    public function likes(Request $request, $username)
    {
        // Check if user exists or not
        $check_user = DB::table('users')->where('username', $username)->first();
        // Get site Settings
        $setting = DB::table('settings')->where('id', 1)->first();

        if ($check_user) {
            // User Exists, Check if has Favorites media
            $get_likes = DB::table('media_likes')
                        ->where('user_id', $check_user->id)->paginate(9);

            if ($get_likes) {
                // User have favorites
                $time   = Carbon::createFromFormat('Y-m-d H:i:s', $check_user->created_at)->diffForHumans();

                $data = array(
                'username'   => $username,
                'get_likes'  => $get_likes,
                'check_user' => $check_user,
                'setting'    => $setting,
                'time'       => $time
                );
                return view('user_likes')->with($data);
            }else{
                // User Does not have favorites media
                return redirect('/user/'.$username)->with('no_media', 'Oops! User does not have favorites media right now. Please try again later.');
            }
        }else{
            // User Does not exists
            return redirect('/');
        }
    }

}
