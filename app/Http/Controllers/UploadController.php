<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Category;
use Illuminate\Http\Request;
use DB;
use Auth;
use App\libraries\Helper;
use Validator;
use App\Media;
use App\Settings;

class UploadController extends Controller
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

    // Upload Page
    public function index()
    {
        // Get Site Settings
        $setting  = DB::table('settings')->where('id', 1)->first();

        // Check if Visitors Alloed to submit media
        if (($setting->anonymous == 0) AND (!Auth::check())) {
            return redirect('/login');
        }
        // Get All Categories
        $categories   = Category::all();
        // Send as Array
        $data     = array(
        'setting'    => $setting,
        'categories' => $categories
        );
        return view('upload')->with($data);
    }


    // Upload Image or Video
    public function upload(Request $request)
    {
        // Get Settings
        $check_settings = Settings::where('id', 1)->first();

        // IF Visitor not allowed
        if (($check_settings->anonymous == 0) AND (!Auth::check())) {
            return redirect('/login');
        }

        if (Auth::check()) {
            $user_id = Auth::user()->id;
        }else{
            $user_id = 0;
        }
        // Get Max Image & Video size
        $max_vid_size = Helper::bytes2MB($check_settings->max_vid_mb);
        $max_img_size = Helper::bytes2MB($check_settings->max_img_mb);
        // Check if Admin or User
        if ((Auth::check()) AND (Auth::user()->level === 1)) {
            $media_active = 1;
        }
        elseif ($check_settings->auto_approve_posts == 0) {
            $media_active = 1;
        }else{
            $media_active = 0;
        }

        // Validate reCaptcha
        if ($check_settings->recaptcha == 0) {
            $recaptcha = Validator::make($request->all(),[
            'g-recaptcha-response' => 'required|captcha'
            ]);
            if ($recaptcha->fails()) {
                    return redirect()->back()->with('error', 'Oops! reCaptcha Required.');
            }
        }
        

        /* Submit Image To Upload */
        if (isset($_POST['submit_image'])) {
            $title       = $request->get('titleofimg');
            $img_file    = $request->file('img_file');
            $categories  = $request->get('img_categories');
            $description = $request->get('img_description');
            $img_url     = $request->input('img_url');

            $validator = Validator::make($request->all(), [
            'img_file'        => 'image',
            'titleofimg'      => 'required',
            'img_categories'  => 'required',
            'img_description' => 'required',
            
            ]);
            if ($validator->fails()) {
                return redirect()->back()->with('error', 'Oops! Something went wrong, Remember that all fields required.');
            }else{
                // If submit image from PC
                if ($img_file !== null) {
                    $get_mime = $img_file->getClientMimeType();
                    $check_size = getimagesize($img_file);
                    $get_size = $img_file->getClientSize();
                    $get_extension = $img_file->guessExtension();
                    $allowed_extension = array('jpg', 'jpeg', 'png','gif'); 
                    $mime = array('image/jpeg', 'image/gif', 'image/png', 'image/jpg');

                    if (!in_array($get_mime, $mime) OR !in_array($get_extension, $allowed_extension)) {
                        return redirect()->back()->with('error', 'Please upload a valid image.');
                    }elseif (($get_size > $max_img_size) OR ($get_size < 1000)) {
                        return redirect()->back()->with('error', 'Image file too large. Please try again.');
                    }elseif (!$check_size) {
                        return redirect()->back()->with('error', 'Image width and height must be greater than 100px.');
                    }else{
                        $short_url = str_random(15);
                        $destination_path = public_path().'/../../uploads/images/';
                        $filename = str_random(20).'_'.$img_file->getClientOriginalName();
                        $img_file->move($destination_path, $filename);
                        $img_full_url = url('/').'/uploads/images/'.$filename;
                        Media::create(array(
                            'user_id'       => $user_id,
                            'pic_url'       => $img_full_url,
                            'title'         => $title,
                            'category_id'   => $categories,
                            'description'   => $description,
                            'short_url'     => $short_url,
                            'user_id'       => $user_id,
                            'is_video'      => 0,
                            'is_picture'    => 1,
                            'active'        => $media_active
                        ));
                        if (($check_settings->anonymous == 1) AND (!Auth::check())) {
                            $access_url = url('/media').'/'.$short_url;
                            return redirect()->back()->with('anonymous_img', $access_url);
                        }else{
                            return redirect()->back()->with('success', 'Image was successfully submitted.');
                        }
                    }
                
                }elseif($img_url !== null){
                    $short_url = str_random(15);
                    Media::create(array(
                    'pic_url'     => $img_url,
                    'title'       => $title,
                    'category_id' => $categories,
                    'description' => $description,
                    'short_url'   => $short_url,
                    'user_id'     => $user_id,
                    'is_video'    => 0,
                    'is_picture'  => 1,
                    'active'      => $media_active
                ));
                    if (($check_settings->anonymous == 1) AND (!Auth::check())) {
                        $access_url = url('/media').'/'.$short_url;
                        return redirect()->back()->with('anonymous_img', $access_url);
                    }else{
                        return redirect()->back()->with('success', 'Image was successfully submitted.');
                    }
                    
                }
             }

         // IF Submit Video
         }elseif (isset($_POST['submit_video'])) {

            // if not allow to upload pictures
            if ($check_settings->allow_vid_up !== 0) {
                return redirect('/');
            }
            $validator = Validator::make($request->all(), [
            'vid_title'       => 'required',
            'vid_categories'  => 'required',
            'vid_description' => 'required'
            ]);
            
            if ($validator->fails()) {
                return redirect()->back()->with('error', 'Oops! Something went wrong, Remember that all fields required.');
            }

            $vid_url      = $request->input('vid_url');
            // IF Submit a Video URL
            if ($vid_url) {

            $v_t = Helper::check_vid_url($vid_url);
            if ($v_t == "unknown") {
                return redirect()->back()->with('error', 'Oops! you must add a valid video url from Youtube, Vimeo, Dailymotion, Ok.ru, or Metacafe.');
            }
            switch ($v_t) {
                case 'youtube':
                    $url = $vid_url;
                    parse_str( parse_url( $url, PHP_URL_QUERY ) );
                    $vid_img = "http://img.youtube.com/vi/".$v."/0.jpg";
                    break;

                case 'vimeo':
                $vimeo_id = Helper::parse_vimeo($vid_url);
                $vimeo_vid = Helper::video_info($vid_url, $vimeo_id);
                $vid_img = $vimeo_vid['thumb_large'];
                    break;

                case 'dailymotion':
                $dailymotion_url = $vid_url;
                $dailymotion_id = strtok(basename($dailymotion_url), '_');
                $dailymotion_thumbnail = json_decode(file_get_contents("https://api.dailymotion.com/video/$dailymotion_id?fields=thumbnail_large_url"));
                $vid_img = $dailymotion_thumbnail->thumbnail_large_url;
                    break;

                case 'metacafe':
                $metacafe_url = $vid_url;
                $metacafe_path = parse_url($metacafe_url, PHP_URL_PATH);
                $pieces = explode('/', $metacafe_path);
                $videoId = $pieces[2];
                $limit = substr($videoId,0,5)."000";
                $videoTitle = $pieces[3];
                $vid_img = "http://cdn.metacafe.com/contents/videos_screenshots/$limit/$videoId/preview.jpg";
                    break;

                case 'vine':
                $vine_url = $vid_url;
                $vine_id = basename($vine_url); 
                $vine_thumbnial = Helper::get_vine_thumbnail($vine_id);
                $vid_img = $vine_thumbnial;
                    break;

                default:
                    $vid_img = "http://www.outdoorfitnessisrael.co.il/wp-content/themes/envision-v1/lib/images/default-placeholder-960x540.png";
                    break;
            }
                $vid_title     = $request->input('vid_title');
                $categories    = $request->input('vid_categories');
                $description   = $request->input('vid_description');
                $short_url     = str_random(15);
                Media::create(array(
                    'title'       => $vid_title,
                    'category_id' => $categories,
                    'is_video'    => 1,
                    'is_picture'  => 0,
                    'vid_url'     => $vid_url,
                    'vid_type'    => $v_t,
                    'vid_img'     => $vid_img,
                    'description' => $description,
                    'user_id'     => $user_id,
                    'short_url'   => $short_url,
                    'active'      => $media_active
                ));
                if (($check_settings->anonymous == 1) AND (!Auth::check())) {
                    $access_url = url('/media').'/'.$short_url;
                    return redirect()->back()->with('anonymous_vid', $access_url);
                }else{
                    return redirect()->back()->with('success', 'Video was successfully submitted.');
                }

            // IF Upload Video From PC
            }elseif ($request->file('uploaded_video')){
                $validator = Validator::make($request->all(), [
                'uploaded_video_img'  => 'required|image'
                ]);
                
                if ($validator->fails()) {
                    return redirect()->back()->with('error', 'Oops! Video Image Required.');
                }else{
                    $uploaded_video_img = $request->file('uploaded_video_img');
                    $uploaded_video = $request->file('uploaded_video');
                    $video_mime = $uploaded_video->getClientMimeType();
                    $video_size = $uploaded_video->getClientSize();
                    $get_vid_extension = $uploaded_video->guessExtension();
                    $allowed_vid_extension = array('mpeg', 'mp4', 'avi','flv'); 
                    $allowed_mime = array('video/mpeg', 'video/mp4', 'video/x-msvideo', 'video/x-flv');

                    if (!in_array($video_mime, $allowed_mime) OR !in_array($get_vid_extension, $allowed_vid_extension)) {
                        return redirect()->back()->with('error', 'Please upload a valid Video.');
                    }elseif (($video_size > $max_vid_size) OR ($video_size < 1000)) {
                        return redirect()->back()->with('error', 'Video file too large. Please try again.');
                    }else{
                        $vid_title     = $request->input('vid_title');
                        $categories    = $request->input('vid_categories');
                        $description   = $request->input('vid_description');
                        $short_url = str_random(15);
                        $videos_path = public_path().'/../../uploads/videos/';
                        $videoName = rand(111111111, 999999999) . '.' . $get_vid_extension; 
                        $uploaded_video->move($videos_path, $videoName);
                        $video_full_url = url('/').'/uploads/videos/'.$videoName;
                        // Preview Image
                        $get_prev_extension = $uploaded_video_img->guessExtension();
                        $preview_path = public_path().'/../../uploads/videos/previews/';
                        $preview_video = rand(111111111, 999999999) . '.' . $get_prev_extension;
                        $uploaded_video_img->move($preview_path, $preview_video);
                        $preview_full_url = url('/').'/uploads/videos/previews/'.$preview_video;

                        Media::create(array(
                        'title'       => $vid_title,
                        'category_id' => $categories,
                        'is_video'    => 1,
                        'is_picture'  => 0,
                        'vid_url'     => $video_full_url,
                        'vid_type'    => 'upload',
                        'vid_img'     => $preview_full_url,
                        'description' => $description,
                        'short_url'   => $short_url,
                        'user_id'     => $user_id,
                        'active'      => $media_active
                    ));

                    if (($check_settings->anonymous == 1) AND (!Auth::check())) {
                        $access_url = url('/media').'/'.$short_url;
                        return redirect()->back()->with('anonymous_vid', $access_url);
                    }else{
                        return redirect()->back()->with('success', 'Video was successfully submitted.');
                    }

                    }
                }// END ELSE
            }
        }
        
    }

}
