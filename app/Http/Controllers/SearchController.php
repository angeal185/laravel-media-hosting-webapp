<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use DB;
use App\Media;
use App\Http\Requests;
use App\Http\Requests\CreateCategoryFormRequest;
use App\Http\Controllers\Controller;

class SearchController extends Controller
{

	// Show results of search
	public function show_result(Request $request)
	{
		$input = $request->get('q');

		// if search empty
		if ($input == '') {
			return redirect('/');
		}

		// Get Settings 
		$setting  = DB::table('settings')->where('id', 1)->first();
		// Searched Media
		$searched_media = DB::table('media')->orderBy('id', 'desc')
						->where('title', 'LIKE', '%' . $input . '%')
						->orWhere('description', 'LIKE', '%' . $input . '%')
						->paginate($setting->paginate);
		// Get Ads
    	$ads = DB::table('ads')->where('id', 1)->first();

		// Send as Array
		$data = array (
			'searched_media' => $searched_media,
			'input'          => $input,
			'setting'        => $setting,
			'ads'            => $ads,
			);
		return view('search_page')->with($data);
	}
}
