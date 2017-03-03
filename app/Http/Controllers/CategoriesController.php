<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use DB;
use App\Media;
use App\Http\Requests;
use App\Http\Requests\CreateCategoryFormRequest;
use App\Http\Controllers\Controller;
use Validator;

class CategoriesController extends Controller
{
	public function create(CreateCategoryFormRequest $request)
	{
        //Double Cats 
        $double_cat = $request->get('cat_name');
		$get_cat = DB::table('categories')->where('name', $double_cat)->first();
        // Check if has categories
        if ($get_cat) {
    		return redirect()->back()->with('error', 'Oops! Category Already exists.');
    	}else{
    		$post = new Category();
    		$post->name = $request->get('cat_name');
    		$post->save();
    		return redirect()->back()->with('success', 'Category was successfully added.');
    	}
	}


    // Show All Media In Category
	public function show_category($name)
	{
        // Check if exists
		$category_name = DB::table('categories')->where('name', $name)->first();
		if ($category_name) {
            // Get Settings 
            $setting  = DB::table('settings')->where('id', 1)->first();
            // Get Ads
            $ads = DB::table('ads')->where('id', 1)->first();

			$category_id = $category_name->id;
			$media       = Media::where('category_id', $category_id)
                                ->where('user_id', '!=', 0)
                                ->paginate($setting->paginate);

            // Send as Array
			$data = array (
				'media'   => $media,
				'name'    => $name,
                'setting' => $setting,
                'ads'     => $ads,
				);
			return view('show_category')->with($data);
		}else{
			return redirect('/');
		}
	}

	public function categories_list()
    {
    	$categories     = Category::all();
        return view('admin.categories')->with('categories', $categories);
    }

    public function editCategory(Request $request, $id)
    {
    	$check_cat = DB::table('categories')->where('id', $id)->first();
    	if ($check_cat) {
    		return view('admin.edit_category')->with('check_cat', $check_cat);
    	}else{
    		return redirect()->back();
    	}
    }

    public function updateCategory(Request $request, $id)
    {
    	$check_cat = DB::table('categories')->where('id', $id)->first();
    	$get_cat = $request->get('category_name');
    	$validator = Validator::make($request->all(), [
            'category_name' => 'required'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->with('error', 'Oops! Something went wrong. Please try again.');
        }elseif ($check_cat->name == $get_cat) {
    		return redirect()->back()->with('error', 'Oops! Category Already exists.');
    	}else{
    		Category::where('id', $id)->update(array(
                  'name'       => $get_cat
                    ));
    		return redirect()->back()->with('success', 'Category was successfully updated.');
    	}
    }


    public function deleteCategory(Request $request, $id)
    {
    	$check_cat = DB::table('categories')->where('id', $id)->first();
    	if ($check_cat) {
    		$rand_cat = DB::table('categories')->where('id', '!=' , $id)->first();

    		if ($rand_cat) {
    			$update_media = DB::table('media')->where('category_id', $id)
    							->update(['category_id' => $rand_cat->id]);
    			$delete_cat = DB::table('categories')->where('id', $id)->delete();
    			return redirect()->back()->with('success', 'Category was successfully deleted.');
    		}else{
    			return redirect()->back()->with('error', 'Oops! You do not have more categories to move media.');
    		}
    	}else{
    		return redirect()->back()->with('error', 'Oops! Something went wrong. Please try again.');
    	}
    }


}
