<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Media;
use App\Category;
use App\User;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use App\MediaLikes;
use App\MediaFlags;
use App\libraries\Helper;
use App\MediaViews;
use App\Message;
use Validator;
use Carbon\Carbon;

class MediaController extends Controller
{
	public function settings()
	{
		$all_users   = User::all();
		$all_cats    = Category::all();
		$all_media   = DB::table('media')->orderBy('id', 'desc')->paginate(15);
		$data = array (
			'all_users' => $all_users,
			'all_cats'  => $all_cats,
			'all_media' => $all_media
			);
		return view('admin.media')->with($data);
	}


	// Show Media Page
	public function show(Request $request, $url)
	{
		// Check URL
		$media    = Media::where('short_url', $url)->first();
		if ($media) {
			// Media Exists

			// check if media active or not
			if (($media->active !== 1) AND (!Auth::check()) AND (Auth::user()->level !== 1)) {
				return redirect('/');
			}

			// IF new View or already viewed
			$get_ip   = Helper::get_client_ip();
			$check_ip = DB::table('media_views')->where('media_id', $media->id)
												->where('ip_address', $get_ip)
												->first();
			if (!$check_ip) {
				// save new view
				$save_view             = new MediaViews;
				$save_view->ip_address = $get_ip;
				$save_view->media_id   = $media->id;
				$save_view->views      = 1;
				$save_view->save();
			}
			$setting = DB::table('settings')->where('id', 1)->first();
			$ads = DB::table('ads')->where('id', 1)->first();
			// Send as Array
	        $data     = array(
	        'setting'     => $setting,
	        'media'       => $media,
	        'ads'         => $ads
	        );
        	return view('media')->with($data);
		}else{
			// Media Not Exists
			return redirect('/');
		}

	}/* End Show Function */

	public function like(Request $request, $url)
	{
		if (!Auth::guest()) {
			$check_media = DB::table('media')->where('short_url', $url)->first();
			if (!$check_media) {
				return redirect()->back();
			}elseif ($check_media->user_id == Auth::user()->id) {
				return redirect()->back()->with('error', 'You cannot like your media only others can do this.');
			}else{
				$user_id = Auth::user()->id;
				$check_like = MediaLikes::where('user_id', $user_id)
							  ->where('media_id', $check_media->id)
							  ->first();
				if ($check_like) {
					return redirect()->back()->with('error', 'You are already like this media.');
				}else{
					$new_like = new MediaLikes;
					$new_like->user_id = $user_id;
					$new_like->media_id = $check_media->id;
					$new_like->save();
					$send_notice = DB::table('notifications')->insert([
	                'user_id'    => $check_media->user_id, 
	                'media_id'   => $check_media->id, 
	                'type'       => 'like', 
	                'status'     => 0,
	                'created_at' => Carbon::now()->toDateTimeString(),
	                'updated_at' => Carbon::now()->toDateTimeString()
	                ]);
					return redirect()->back()->with('success', 'Media was successfully added to your favorites');

				}
			}
		}else{
			return redirect('/login');
		}
	}

	public function flag(Request $request, $url)
	{
		$check_media = DB::table('media')->where('short_url', $url)->first();
			if (!$check_media) {
				return redirect()->back();
			}elseif ($check_media->user_id == Auth::user()->id) {
				return redirect()->back()->with('error', 'You cannot flag your media.');
			}else{
				$user_id = Auth::user()->id;
				$check_flag = MediaFlags::where('user_id', $user_id)
							  ->where('media_id', $check_media->id)
							  ->first();
				if ($check_flag) {
					return redirect('/media/'.$url)->with('error', 'You are already flag this media.');
				}else{
					$new_flag = new MediaFlags;
					$new_flag->user_id = $user_id;
					$new_flag->media_id = $check_media->id;
					$new_flag->save();
					return redirect('/media/'.$url)->with('success', 'Media was successfully flagged.');

				}
			}
	}


	public function flagged()
	{
		$flagged_media = DB::table('media_flags')->get();
		return view('admin.media_flags')->with('flagged_media', $flagged_media);
	}


	public function markFlag(Request $request, $id)
	{
		$get_settings = DB::table('settings')->where('id', 1)->first();
		$website_email = $get_settings->website_email;

		$check_flag = DB::table('media_flags')->where('id', $id)->first();
		if ($check_flag) {
			$get_user = $check_flag->user_id;
			$check_user = DB::table('users')->where('id', $get_user)->first();
			if ($check_user) {
				$send_tnx = new Message;
				$send_tnx->msg_from    = "Site Team";
				$send_tnx->msg_to      = $check_user->username;
				$send_tnx->email       = $website_email;
				$send_tnx->is_registed = 1;
				$send_tnx->msg_content = "Hi, ".$check_user->username.". we receive your flagged media. Thanks.";
				$send_tnx->status      = 0;
				$send_tnx->type        = "notice";
				$send_tnx->save();
				$delete_flag = DB::table('media_flags')->where('id', $id)->delete();
				if ($delete_flag) {
					return redirect('/dashboard/media/flagged')->with('success', 'Media flag was successfully set as read.');
				}else{
					return redirect('/dashboard/media/flagged')->with('error', 'Oops! something went wrong, please try again.');
				}

			}
		}
	}

	public function deleteMedia(Request $request, $id)
    {
        $check_media = DB::table('media')->where('id', $id)->first();
        if ($check_media) {
            $delete_media = DB::table('media')->where('id', $id)
                        ->delete();
            $deltee_flag = DB::table('media_flags')->where('media_id', $id)->delete();
            $delele_comments = DB::table('comments')->where('media_id', $id)->delete();
            $delete_likes = DB::table('media_likes')->where('media_id', $id)->delete();
            $delete_views = DB::table('media_views')->where('media_id', $id)->delete();
            return redirect()->back()->with('success', 'Media was successfully Deleted.');
        }else{
            return redirect()->back()->with('error', 'Oops! something went wrong. Please try again.');
        }
    }

    public function AdminSendPicture()
    {
    	return view('admin.add_picture');
    }


    public function AdminUploadPicture(Request $request)
    {
    	$validator = Validator::make($request->all(), [
            'img_file'        => 'image',
            'img_title'       => 'required',
            'img_categories'  => 'required',
            'img_description' => 'required'
            ]);
            if ($validator->fails()) {
                return redirect()->back()->with('error', 'Oops! Something went wrong, Remember that all fields required.');
            }else{
            	$title         = $request->get('img_title');
            	$picture_url   = $request->get('picture_url');
	            $img_file      = $request->file('img_file');
	            $categories    = $request->get('img_categories');
	            $description   = $request->get('img_description');

	            if ($img_file !== null) {
	            	$get_mime      = $img_file->getClientMimeType();
		            $check_size    = getimagesize($img_file);
		            $get_size      = $img_file->getClientSize();
		            $get_extension = $img_file->guessExtension();
		            $allowed_extension = array('jpg', 'jpeg', 'png','gif'); 
		            $mime = array('image/jpeg', 'image/gif', 'image/png', 'image/jpg');
		            if (!in_array($get_mime, $mime) OR !in_array($get_extension, $allowed_extension)) {
                		return redirect()->back()->with('error', 'Please upload a valid image.');
		            }elseif ($get_size > 3000000 OR $get_size < 1000) {
		                return redirect()->back()->with('error', 'Image file must be less than 3MB and greater that 10KB.');
		            }elseif (!$check_size) {
		                return redirect()->back()->with('error', 'Image width and height must be greater than 100px.');
		            }else{
		            	$user_id = Auth::user()->id;
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
		                    'is_video'      => 0,
		                    'is_picture'    => 1,
		                    'active'        => 1
		                ));
		                return redirect()->back()->with('success', 'Image was successfully submitted.');
		            }
	            }elseif ($picture_url !== null) {
	            	$short_url = str_random(15);
                    Media::create(array(
                    'user_id'     => Auth::user()->id,
                    'pic_url'     => $picture_url,
                    'title'       => $title,
                    'category_id' => $categories,
                    'description' => $description,
                    'short_url'   => $short_url,
                    'is_video'    => 0,
                    'is_picture'  => 1,
                    'active'      => 1
               	 	));
                    return redirect()->back()->with('success', 'Image was successfully submitted.');
	            }else{
	            	return redirect()->back();
	            }
    	}
	}


	public function AdminSendVideo()
    {
    	return view('admin.add_video');
    }

    public function AdminUploadVideo(Request $request)
    {
    	$validator = Validator::make($request->all(), [
            'vid_title'       => 'required',
            'video_url'       => 'required',
            'vid_categories'  => 'required',
            'vid_description' => 'required',
            ]);
            
            if ($validator->fails()) {
                return redirect()->back()->with('error', 'Oops! Something went wrong, Remember that all fields required.');
            }
            $vid_url      = $request->input('video_url');
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
            	$user_id = Auth::user()->id;
                $vid_title     = $request->input('vid_title');
                $categories = $request->input('vid_categories');
                $description  = $request->input('vid_description');
                $short_url = str_random(15);
                Media::create(array(
                    'user_id'     => $user_id,
                    'title'       => $vid_title,
                    'category_id' => $categories,
                    'is_video'    => 1,
                    'is_picture'  => 0,
                    'vid_url'     => $vid_url,
                    'vid_type'    => $v_t,
                    'vid_img'     => $vid_img,
                    'description' => $description,
                    'short_url'   => $short_url,
                    'active'      => 1
                ));
                return redirect()->back()->with('success', 'Video was successfully submitted.');
    }//END FUNCTION





}
