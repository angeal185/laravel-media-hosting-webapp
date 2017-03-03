<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Ads;
use DB;
use Illuminate\Http\Request;

class AdsController extends Controller
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
    public function index()
    {
        $ads  = DB::table('ads')->first();
        return view('admin.ads')->with('ads', $ads);
    }

    public function update(Request $request)
    {
        $home_top_ad_code     = $request->get('home_top_ad_code');
        $home_top_ad_img      = $request->get('home_top_ad_img');

        $home_side_ad_code    = $request->get('home_side_ad_code');
        $home_side_ad_img     = $request->get('home_side_ad_img');

        $media_top_ad_code    =  $request->get('media_top_ad_code');
        $media_top_ad_img     =  $request->get('media_top_ad_img');

        $media_bottom_ad_code =  $request->get('media_bottom_ad_code');
        $media_bottom_ad_img  =  $request->get('media_bottom_ad_img');
        Ads::where('id', 1)->update(array(
            'home_top_ad_code'             => $home_top_ad_code,
            'home_top_ad_img'              => $home_top_ad_img,
            'home_side_ad_code'            => $home_side_ad_code,
            'home_side_ad_img'             => $home_side_ad_img,
            'media_top_ad_code'            => $media_top_ad_code,
            'media_top_ad_img'             => $media_top_ad_img,
            'media_bottom_ad_code'         => $media_bottom_ad_code,
            'media_bottom_ad_img'          => $media_bottom_ad_img
            ));
        return redirect()->back()->with('message', 'Ads was successfully updated.');
    }

}
