<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\libraries\Helper;
use DB;
use App\Media;
use App\User;
use App\Settings;
use Validator;
use Auth;
use Hash;
use Carbon\Carbon;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
   public function index()
    {
        $version     = "1.2.1";// Only for check new updates
        $check       = Helper::Check_Script_Version($version);
        $total_pic   = Media::where('is_picture', 1)->count();
        $total_vid   = Media::where('is_video', 1)->count();
        $total_user  = User::count();
        $fb_users    = User::whereNotNull('facebook_id')->count();
        $tw_users    = User::whereNotNull('twitter_id')->count();
        $go_users    = User::whereNotNull('google_id')->count();
        $data        = array(
            'check'       => $check,
            'total_pic'   => $total_pic,
            'total_vid'   => $total_vid,
            'total_user'  => $total_user,
            'fb_users'    => $fb_users,
            'tw_users'    => $tw_users,
            'go_users'    => $go_users
            );
        return view('admin.index')->with($data);
    }

    public function Settings()
    {
        return view('admin.settings');
    }


    // Update Site Sttings
    public function updateSettings(Request $request)
    {
        $site_title        = $request->get('site_title');
        $short_description = $request->get('short_description');
        $seo_description   = $request->get('seo_description');
        $site_keyword      = $request->get('site_keyword');
        $site_email        = $request->get('site_email');
        $logo              = $request->file('site_logo');
        $favicon           = $request->file('site_favicon');
        $site_fb           = $request->get('site_fb');
        $site_tw           = $request->get('site_tw');
        $site_go           = $request->get('site_go');
        $active_adblock    = $request->get('active_adblock');
        $approve_comments  = $request->get('approve_comments');
        $approve_uploads   = $request->get('approve_uploads');
        $allow_vid_up      = $request->get('allow_vid_up');
        $max_vid_up        = $request->get('max_vid_up');
        $max_img_up        = $request->get('max_img_up');
        $paginate          = $request->get('paginate');
        $theme             = $request->get('theme');
        $anonymous         = $request->get('anonymous');
        $adfly             = $request->get('adfly');

        $validator = Validator::make($request->all(), [
            'site_title'        => 'required',
            'short_description' => 'required',
            'site_logo'         => 'image',
            'site_favicon'      => 'image',
            ]);
            
            if ($validator->fails()) {
                return redirect()->back()->with('error', 'Oops! some fields are required.');
            }else{
                
                $update_settings = Settings::where('id', 1)
                ->update([
                    'website_name'          => $site_title,
                    'website_description'   => $seo_description,
                    'title_description'     => $short_description,
                    'website_keywords'      => $site_keyword,
                    'website_email'         => $site_email,
                    'facebook_page_id'      => $site_fb,
                    'google_page_id'        => $site_go,
                    'twitter_page_id'       => $site_tw,
                    'adblock_detecting'     => $active_adblock,
                    'auto_approve_posts'    => $approve_uploads,
                    'auto_approve_comments' => $approve_comments,
                    'allow_vid_up'          => $allow_vid_up,
                    'max_vid_mb'            => $max_vid_up,
                    'max_img_mb'            => $max_img_up,
                    'paginate'              => $paginate,
                    'anonymous'             => $anonymous,
                    'adfly'                 => $adfly
                    ]);

                // IF Submit Logo
                if (isset($logo)) {
                    $destination_path = public_path().'/../uploads/settings/';
                    $filename = str_random(20).'_'.$logo->getClientOriginalName();
                    $logo->move($destination_path, $filename);
                    $img_full_url = url('/').'/uploads/settings/'.$filename;
                    $update_logo = Settings::where('id', 1)
                ->update([
                    'logo'        => $img_full_url,
                    ]);
                }

                // Upload Favicon
                if (isset($favicon)) {
                    $favicon_destination_path = public_path().'/../uploads/settings/';
                    $favicon_filename = str_random(20).'_'.$favicon->getClientOriginalName();
                    $favicon->move($favicon_destination_path, $favicon_filename);
                    $favicon_full_url = url('/').'/uploads/settings/'.$favicon_filename;
                    $update_favicon = Settings::where('id', 1)
                ->update([
                    'favicon' => $favicon_full_url,
                    ]);
                }

                // Change Theme
                if (isset($theme)) {
                    $update_logo = Settings::where('id', 1)
                                ->update([
                                'theme' => $theme,
                                ]);
                }

                return redirect()->back()->with('success', 'Settings are successfully updated.');
            }
    }

    public function approveMedia(Request $request, $id)
    {
        $check_id = DB::table('media')->where('id', $id)->first();
        if ($check_id AND $check_id->active !== 1) {
            $approve_it = DB::table('media')->where('id', $id)
                        ->update(['active' => 1]);
            $send_notice = DB::table('notifications')->insert([
                'user_id'    => $check_id->user_id, 
                'media_id'   => $check_id->id, 
                'type'       => 'approve_media', 
                'status'     => 0,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString()
                ]);
            return redirect()->back()->with('success', 'Media was successfully approved.');
        }else{
            return redirect()->back();
        }
    }

    public function deleteMedia(Request $request, $id)
    {
        $check_id = DB::table('media')->where('id', $id)->first();
        if ($check_id) {
            $approve_it = DB::table('media')->where('id', $id)
                        ->delete();
            return redirect()->back()->with('success', 'Media was successfully Deleted.');
        }else{
            return redirect()->back();
        }
    }


    public function editMedia($id)
    {
        $check_id = DB::table('media')->where('id', $id)->first();
        if ($check_id) {
            return view('admin.edit_media')->with('check_id', $check_id);
        }else{
            return redirect()->back();
        }
    }

    public function updateMedia(Request $request, $id)
    {
        $check_id = DB::table('media')->where('id', $id)->first();
        if ($check_id) {
            $media_title       = $request->get('media_title');
            $media_description = $request->get('media_description');
            $media_pic_url     = $request->get('media_pic_url');
            $media_vid_url     = $request->get('media_vid_url');
            $media_active      = $request->get('media_active');
            $media_category    = $request->get('media_category');

            if (isset($media_pic_url)) {
                $update_media = DB::table('media')->where('id', $id)
                        ->update([
                            'category_id' => $media_category,
                            'title' => $media_title,
                            'description' => $media_description,
                            'active' => $media_active,
                            'is_video' => 0,
                            'is_picture' => 1,
                            'pic_url' => $media_pic_url
                            ]);
            }elseif (isset($media_vid_url)) {
                $update_media = DB::table('media')->where('id', $id)
                        ->update([
                            'category_id' => $media_category,
                            'title' => $media_title,
                            'description' => $media_description,
                            'active' => $media_active,
                            'is_video' => 1,
                            'is_picture' => 0,
                            'vid_url' => $media_vid_url
                            ]);
            }
            return redirect('/dashboard/media')->with('success', 'Media was successfully updated.');
        }else{
            return redirect('/dashboard/media');
        }
    }


    public function deleteUser(Request $request, $id)
    {
        $check_user = DB::table('users')->where('id', $id)->first();
        if ($check_user AND $check_user->id !== 1) {
            $delete_user = DB::table('users')->where('id', $id)->delete();
            return redirect()->back()->with('success', 'User was successfully Deleted.');
        }else{
            return redirect()->back()->with('error', 'Oops! something went wrong. Please try again.');
        }
    }

    public function approveComment(Request $request, $id)
    {
        $check_comment = DB::table('comments')->where('id', $id)->first();
        if ($check_comment) {
            $update_comment = DB::table('comments')->where('id', $id)
                        ->update([
                            'status' => 1
                            ]);
            $send_notice = DB::table('notifications')->insert([
                'user_id'    => $check_comment->user_id, 
                'media_id'   => $check_comment->media_id, 
                'comment_id' => $check_comment->id,
                'type'       => 'approve_comment', 
                'status'     => 0,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString()
                ]);
            return redirect()->back()->with('success', 'Comment was successfully approved.');
        }else{
            return redirect()->back()->with('error', 'Oops! something went wrong. Please try again.');
        }
    }

    public function deleteComment(Request $request, $id)
    {
        $check_comment = DB::table('comments')->where('id', $id)->first();
        if ($check_comment) {
            $delete_comment = DB::table('comments')->where('id', $id)
                        ->delete();
            return redirect()->back()->with('success', 'Comment was successfully Deleted.');
        }else{
            return redirect()->back()->with('error', 'Oops! something went wrong. Please try again.');
        }
    }

    public function editComment($id)
    {
        $check_id = DB::table('comments')->where('id', $id)->first();
        if ($check_id) {
            return view('admin.edit_comment')->with('check_id', $check_id);
        }else{
            return redirect()->back();
        }
    }


    public function updateComment(Request $request, $id)
    {
        $check_id = DB::table('media')->where('id', $id)->first();
        if ($check_id) {
            $comment_content = $request->get('comment_content');
            $comment_active  = $request->get('comment_active');
            $update_comment = DB::table('comments')->where('id', $id)
                        ->update([
                            'comment' => $comment_content,
                            'status'  => $comment_active
                            ]);
            return redirect('/dashboard/comments')->with('success', 'Comment was successfully updated.');

        }else{
            return redirect('/dashboard/comments');
        }
    }




    public function profile()
    {
        $get_user_info = DB::table('users')->where('id', Auth::user()->id)
                        ->where('level', 1)->first();
            if ($get_user_info) {
                return view('admin.profile')->with('get_user_info', $get_user_info);
            }else{
                return redirect('/');
            }
        
    }

    public function adminInfo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'admin_username' => 'required',
            'admin_email'    => 'required',
            ]);
            
            if ($validator->fails()) {
                return redirect()->back()->with('error', 'Oops! some fields are required.');
            }else{
                $id               = Auth::user()->id;
                $get_username     = $request->get('admin_username');
                $get_email        = $request->get('admin_email');
                $facebook_profile = $request->get('admin_facebook');
                $twitter_profile  = $request->get('admin_twitter');
                $check_user = DB::table('users')
                            ->where('id', '!=' , $id)
                            ->first();
                if ($check_user) {
                    if (($check_user->username == $get_username) OR ($check_user->email == $get_email)) {
                        return redirect()->back()->with('error', 'Oops! Username or Email Already exists.');
                    }
                }else{
                    User::where('id', $id)->update(array(
                        'username'         => $get_username,
                        'email'            => $get_email,
                        'facebook_profile' => $facebook_profile,
                        'twitter_profile'  => $twitter_profile
                    ));
                    return redirect()->back()->with('success', 'Your personal info was successfully updated.');
                }
            }
    }


    public function adminAvatar(Request $request)
    {
        if ($request->file('admin_avatar')) {
            $admin_avatar = $request->file('admin_avatar');
            list($img_width, $img_height) = getimagesize($admin_avatar);
            $get_mime = $admin_avatar->getClientMimeType();
            $get_size = $admin_avatar->getClientSize();
            $get_extension = $admin_avatar->guessExtension();
            $allowed_extension = array('jpg', 'jpeg', 'png'); 
            $mime = array('image/jpeg', 'image/png', 'image/jpg');

            if (!in_array($get_mime, $mime) OR !in_array($get_extension, $allowed_extension)) {
                return redirect()->back()->with('error', 'Please upload a valid image.');
            }elseif ($get_size > 3000000 OR $get_size < 1000) {
                return redirect()->back()->with('error', 'Image file must be less than 3MB and greater that 10KB.');
            }elseif ($img_width < 30 AND $img_height < 30) {
                return redirect()->back()->with('error', 'Image width and height must be greater than 30px.');
            }else{
                $destination_path = public_path().'/../../uploads/avatars/';
                $filename = str_random(20).'_'.$admin_avatar->getClientOriginalName();
                $admin_avatar->move($destination_path, $filename);
                $img_full_url = url('/').'/uploads/avatars/'.$filename;
                $update_avatar = DB::table('users')->where('id', Auth::user()->id)->update(['avatar' =>$img_full_url]);
                return redirect()->back()->with('success', 'Avatar was successfully updated.');
                }

        }elseif ($request->file('admin_cover')) {
            $admin_cover = $request->file('admin_cover');
            list($img_width, $img_height) = getimagesize($admin_cover);
            $get_mime = $admin_cover->getClientMimeType();
            $get_size = $admin_cover->getClientSize();
            $get_extension = $admin_cover->guessExtension();
            $allowed_extension = array('jpg', 'jpeg', 'png'); 
            $mime = array('image/jpeg', 'image/png', 'image/jpg');

            if (!in_array($get_mime, $mime) OR !in_array($get_extension, $allowed_extension)) {
                return redirect()->back()->with('error', 'Please upload a valid image.');
            }elseif ($get_size > 3000000 OR $get_size < 1000) {
                return redirect()->back()->with('error', 'Image file must be less than 3MB and greater that 10KB.');
            }elseif ($img_width < 100 AND $img_height < 100) {
                return redirect()->back()->with('error', 'Image width and height must be greater than 100px.');
            }else{
                $destination_path = public_path().'/../../uploads/covers/';
                $filename = str_random(20).'_'.$admin_cover->getClientOriginalName();
                $admin_cover->move($destination_path, $filename);
                $img_full_url = url('/').'/uploads/covers/'.$filename;
                $update_avatar = DB::table('users')->where('id', Auth::user()->id)->update(['cover' =>$img_full_url]);
                return redirect()->back()->with('success', 'Cover was successfully updated.');
                }
        }else{
            return redirect()->back();
        }
        
    }

    public function adminPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'password'     => 'required|confirmed'
            ]);
            
            if ($validator->fails()) {
                return redirect()->back()->with('error', 'Oops! some fields are required or password does not confirmed.');
            }else{
                $password = $request->get('old_password');
                if (Hash::check($password, Auth::user()->password)){ 
                    $update_password = DB::table('users')->where('id', Auth::user()->id)->update([
                        'password' => Hash::make($request->get('password'))
                        ]);
                    return redirect()->back()->with('success', 'Password has been successfully changed.');
                }else{
                    return redirect()->back()->with('error', 'Oops! Wrong password.');
                }
                
            }
    }
    
    public function NewCat()
    {
        return view('admin.newcat');
    }


    public function categories()
    {
        return view('admin.categories');
    }


    public function Ads()
    {
        return view('admin.ads');
    }


    public function StatsVisitors()
    {
        return view('admin.stats_visitors');
    }

    
}
