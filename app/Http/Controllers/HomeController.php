<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\libraries\Helper;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use App\Stats;
use App\Media;
use Auth;

class HomeController extends Controller
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
    public function index(Request $request)
    {
        // Visitors stats 
        $client     = getenv('HTTP_CLIENT_IP');
        $get_cookie = $request->cookie('stats');
        if ($get_cookie !== $client) {
        $user_agent = getenv('HTTP_USER_AGENT');
        $forward = getenv('HTTP_X_FORWARDED_FOR');
        $remote  = getenv('REMOTE_ADDR');
        if(filter_var($client, FILTER_VALIDATE_IP)){
            $ip_address = $client;
        }elseif(filter_var($forward, FILTER_VALIDATE_IP)){
            $ip_address = $forward;
        }else{
            $ip_address = $remote;
        }

        // Get OS, Browser and Device
        $user_os                 = Helper::getOS($user_agent);
        $user_browser            = Helper::getBrowser($user_agent);
        $check_device            = Helper::check_device($user_agent);
        if ($check_device == TRUE) {
            $device_is = "Phone";
        }else{
            $device_is = "Computer";
        }
        $get_ip                  = Helper::get_ip_info($ip_address);
        $countryCode             = $get_ip[0];
        $countryName             = $get_ip[1];

        // Save Stat 
        $new_stats               = new Stats;
        $new_stats->ip_address   = $ip_address;
        $new_stats->country_code = $countryCode;
        $new_stats->country_name = $countryName;
        $new_stats->platform     = $user_os;
        $new_stats->browser      = $user_browser;
        $new_stats->device       = $device_is;
        $new_stats->save();
    }   

    // Get Settings        
    $setting  = DB::table('settings')->where('id', 1)->first();
    // Get Media 
    $media    = Media::where('active', 1)->orderBy('id', 'desc')->paginate($setting->paginate);
    // Get Ads
    $ads = DB::table('ads')->where('id', 1)->first();

        // Send as Array
        $data     = array(
        'setting'     => $setting,
        'media'       => $media,
        'ads'         => $ads
        );

        // Return Response
        $response = new \Illuminate\Http\Response(view('home')->with($data));
        $response->withCookie(cookie('stats', $client, 60));
        return $response;

    } /* END Home Function */


    // Get a Random Media
    public function random(){
        // Random media
        $random_media = Media::orderByRaw("RAND()")->first();
        if ($random_media) {
            $short_url = $random_media->short_url;
            return redirect('/media/'.$short_url);
        }else{
            return redirect('/');
        }
        
    }

    // Get User Notifications
    public function Notification()
    {
        // Get Notifications
        $get_notification = DB::table('notifications')
                            ->where('user_id', Auth::user()->id)
                            ->orderBy('id', 'desc')
                            ->paginate(25);
        // Get Site Settings 
        $get_settings = DB::table('settings')->where('id', 1)->first();

        // Get User Info
        $get_user = DB::table('users')->where('id', Auth::user()->id)->first();

        // Send as Array
        $data     = array(
        'get_settings'     => $get_settings,
        'get_notification' => $get_notification,
        'get_user'         => $get_user,
        );

        // Return view
        return view('notification')->with($data);
    }


    // Mark Notification as Read
    public function markNotification(Request $request, $id)
    {
        // Check if exists
        $check_notice = DB::table('notifications')
                        ->where('id', $id)
                        ->where('user_id', Auth::user()->id)
                        ->update(['status' => 1]);
        if ($check_notice) {
            return redirect()->back()->with('success', 'Notification was successfully updated.');
        }else{
            return redirect()->back()->with('error', 'Oops! Already marked as view.');
        }
    }

}
