<?php
namespace App\libraries;
use App\libraries\Helper as Helper;
class Helper {


	public static function get_vine_img($url){

		$vineURL = 'https://vine.co/v/';
		$pos = stripos($url, $vineURL);

		if ($pos === 0) {
		    return TRUE;
		}
		else {
		    return FALSE;
		}
	}

	public static function check_vid_url( $url )
    {
        switch( $url )
        {
            // check if the url begins with John
            case ( preg_match('/http:\/\/www\.metacafe\.com\/watch\/(.*?)\/(.*?)\//', $url) ? true : false ):
            $video_type = "metacafe";
            break;
    
            // check if the url begins with Per
            case ( preg_match('/http:\/\/www\.dailymotion\.com\/video\/+/', $url)  ? true : false ):
            $video_type = "dailymotion";
            break;

            case ( preg_match('/youtube\.com\/watch\?v=([^\&\?\/]+)/', $url)  ? true : false ):
            $video_type = "youtube";
            break;

            case ( preg_match('/^(http\:\/\/|https\:\/\/)?(www\.)?(vimeo\.com\/)([0-9]+)$/', $url)  ? true : false ):
            $video_type = "vimeo";
            break;

            case ( preg_match('/vine\.co/i', $url)  ? true : false ):
            $video_type = "vine";
            break;

            // if there is no match, throw exception with error message
            default: 
            $video_type = "unknown";
        }

        // return the value
        return $video_type;
    }

    public static function parse_vimeo($link){
		
		$regexstr = '~
			# Match Vimeo link and embed code
			(?:&lt;iframe [^&gt;]*src=")?		# If iframe match up to first quote of src
			(?:							# Group vimeo url
				https?:\/\/				# Either http or https
				(?:[\w]+\.)*			# Optional subdomains
				vimeo\.com				# Match vimeo.com
				(?:[\/\w]*\/videos?)?	# Optional video sub directory this handles groups links also
				\/						# Slash before Id
				([0-9]+)				# $1: VIDEO_ID is numeric
				[^\s]*					# Not a space
			)							# End group
			"?							# Match end quote if part of src
			(?:[^&gt;]*&gt;&lt;/iframe&gt;)?		# Match the end of the iframe
			(?:&lt;p&gt;.*&lt;/p&gt;)?		        # Match any title information stuff
			~ix';
		
		preg_match($regexstr, $link, $matches);
		
		return $matches[1];
		
	}


	public static function video_info($url, $v_id) {
    $video_id=$v_id;
    $data['video_type'] = 'vimeo';
    $data['video_id'] = $video_id;
    $xml = simplexml_load_file("http://vimeo.com/api/v2/video/$video_id.xml");
        
    foreach ($xml->video as $video) {
        $data['id']=$video->id;
        $data['title']=$video->title;
        $data['info']=$video->description;
        $data['url']=$video->url;
        $data['upload_date']=$video->upload_date;
        $data['mobile_url']=$video->mobile_url;
        $data['thumb_small']=$video->thumbnail_small;
        $data['thumb_medium']=$video->thumbnail_medium;
        $data['thumb_large']=$video->thumbnail_large;
        $data['user_name']=$video->user_name;
        $data['urer_url']=$video->urer_url;
        $data['user_thumb_small']=$video->user_portrait_small;
        $data['user_thumb_medium']=$video->user_portrait_medium;
        $data['user_thumb_large']=$video->user_portrait_large;
        $data['user_thumb_huge']=$video->user_portrait_huge;
        $data['likes']=$video->stats_number_of_likes;
        $data['views']=$video->stats_number_of_plays;
        $data['comments']=$video->stats_number_of_comments;
        $data['duration']=$video->duration;
        $data['width']=$video->width;
        $data['height']=$video->height;
        $data['tags']=$video->tags;
    } // End foreach
	return $data;
	} // End Vimeo

	public static function get_vine_thumbnail( $id )
	{
	  $vine = file_get_contents("http://vine.co/v/{$id}");
	    preg_match('/property="og:image" content="(.*?)"/', $vine, $matches);

	    return ($matches[1]) ? $matches[1] : false;
	}


	public static function Check_Script_Version($version){ //update 
		//$checker_file = 'http://tyta.net/version.txt';// This Only For Check Version
		//define('REMOTE_VERSION', $checker_file);
		//$remoteVersion = trim(file_get_contents(REMOTE_VERSION));
		//if ($version < $remoteVersion) {
	    	return TRUE;
	    //}else{
	    //	return TRUE;
	    //}
	}

	public static function getYouTubeIdFromURL($url)
	{
	  $url_string = parse_url($url, PHP_URL_QUERY);
	  parse_str($url_string, $args);
	  return isset($args['v']) ? $args['v'] : false;
	}

	public static function shortAdfly($ToConvert) {
		$APIKey = env('ADFLY_API_KEY');
		$UserID = env('ADFLY_USER_ID');
		$ShortType = 'int';
		$short_url = file_get_contents('http://adf.ly/api.php?key=' . $APIKey . '&uid=' . $UserID . '&advert_type=' . $ShortType . '&url=' . $ToConvert);
		return 	'<a href="'.$short_url.'">'.$short_url.'</a>';
	}

	public static function active_links($text)
	{
		$settings = \DB::table('settings')->where('id', 1)->first();
		$adfly = $settings->adfly;

		if ($adfly == 1) {

			$pieces = explode(" ", $text);
			foreach ($pieces as $piece) {
			    if (preg_match("/(^|[\n ])([\w]*?)((ht|f)tp(s)?:\/\/[\w]+[^ \,\"\n\r\t<]*)/is", $piece)) {
			        $newsmallurl = Helper::shortAdfly($piece);
			        $text = str_replace($piece, $newsmallurl, $text);
			    }
			}
			return $text;
		}else{
			return preg_replace('!(((f|ht)tp(s)?://)[-a-zA-Zа-яА-Я()0-9@:%_+.~#?&;//=]+)!i', '<a target="_blank" class="active_links" href="$1">$1</a>', $text);
		}
	}


	public static function get_ip_info($ip)
	{
		$ip_data = json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=".$ip));    

	    if($ip_data && $ip_data->geoplugin_countryName != null){
	    	$country_code =  strtolower($ip_data->geoplugin_countryCode);
			$country_name =  $ip_data->geoplugin_countryName;
	    }else{
	    	$country_code =  "unknown";
			$country_name =  "unknown";
	    }
	    return array($country_code, $country_name);
    }


    public static function getOS($user_agent) {

	$os_platform    =   "Unknown OS Platform";

	$os_array       =   array(
	                        '/windows nt 6.2/i'     =>  'Windows 8',
	                        '/windows nt 6.1/i'     =>  'Windows 7',
	                        '/windows nt 6.0/i'     =>  'Windows Vista',
	                        '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
	                        '/windows nt 5.1/i'     =>  'Windows XP',
	                        '/windows xp/i'         =>  'Windows XP',
	                        '/windows nt 5.0/i'     =>  'Windows 2000',
	                        '/windows me/i'         =>  'Windows ME',
	                        '/win98/i'              =>  'Windows 98',
	                        '/win95/i'              =>  'Windows 95',
	                        '/win16/i'              =>  'Windows 3.11',
	                        '/macintosh|mac os x/i' =>  'Mac OS X',
	                        '/mac_powerpc/i'        =>  'Mac OS 9',
	                        '/linux/i'              =>  'Linux',
	                        '/ubuntu/i'             =>  'Ubuntu',
	                        '/iphone/i'             =>  'iPhone',
	                        '/ipod/i'               =>  'iPod',
	                        '/ipad/i'               =>  'iPad',
	                        '/android/i'            =>  'Android',
	                        '/blackberry/i'         =>  'BlackBerry',
	                        '/webos/i'              =>  'Mobile'
	                     );

	foreach ($os_array as $regex => $value) {

	 if (preg_match($regex, $user_agent)) {
	    $os_platform    =   $value;
	 }

	}

	return $os_platform;

	}

	public static function getBrowser($user_agent) {

	$browser        =   "Unknown Browser";

	$browser_array  =   array(
	                         '/msie/i'       =>  'Internet Explorer',
	                         '/firefox/i'    =>  'Firefox',
	                         '/safari/i'     =>  'Safari',
	                         '/chrome/i'     =>  'Chrome',
	                         '/opera/i'      =>  'Opera',
	                         '/netscape/i'   =>  'Netscape',
	                         '/maxthon/i'    =>  'Maxthon',
	                         '/konqueror/i'  =>  'Konqueror',
	                         '/mobile/i'     =>  'Handheld Browser'
	                   );

	foreach ($browser_array as $regex => $value) {

	  if (preg_match($regex, $user_agent)) {
	     $browser    =   $value;
	  }

	}

	return $browser;

	}


	public static function check_device($container){
		$aMobileUA = array ( 
		'/iphone/i' => 'iPhone', 
        '/ipod/i' => 'iPod', 
        '/ipad/i' => 'iPad', 
        '/android/i' => 'Android', 
        '/blackberry/i' => 'BlackBerry', 
        '/webos/i' => 'Mobile'
		); 
		foreach($aMobileUA as $sMobileKey => $sMobileOS){
        	if(preg_match($sMobileKey, $container)){
            return true;
        	}
    	}
    	return false;
	}


	public static function thousandsNumberFormat($num) {
	  $x = round($num);
	  $x_number_format = number_format($x);
	  $x_array = explode(',', $x_number_format);
	  $x_parts = array('k', 'm', 'b', 't');
	  $x_count_parts = count($x_array) - 1;
	  $x_display = $x;
	  $x_display = $x_array[0] . ((int) $x_array[1][0] !== 0 ? '.' . $x_array[1][0] : '');
	  $x_display .= $x_parts[$x_count_parts - 1];
	  return $x_display;
	}


	public static function get_client_ip() {
    	$ipaddress = '';
	    if (getenv('HTTP_CLIENT_IP'))
	        $ipaddress = getenv('HTTP_CLIENT_IP');
	    else if(getenv('HTTP_X_FORWARDED_FOR'))
	        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
	    else if(getenv('HTTP_X_FORWARDED'))
	        $ipaddress = getenv('HTTP_X_FORWARDED');
	    else if(getenv('HTTP_FORWARDED_FOR'))
	        $ipaddress = getenv('HTTP_FORWARDED_FOR');
	    else if(getenv('HTTP_FORWARDED'))
	       $ipaddress = getenv('HTTP_FORWARDED');
	    else if(getenv('REMOTE_ADDR'))
	        $ipaddress = getenv('REMOTE_ADDR');
	    else
	        $ipaddress = 'UNKNOWN';
	    return $ipaddress;
	}

	// Convert from Bytes to MB Function 

	public static function bytes2MB($bytes)
	{
		// 1 MB = 1000000 Bytes
		$mb = 1000000;
		// Star converting
		$converted = $bytes * $mb;
		// Return Value
		return $converted;
	}

    



}