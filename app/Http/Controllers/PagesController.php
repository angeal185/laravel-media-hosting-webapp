<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Page;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;
use DB;

class PagesController extends Controller
{
	public function new_page()
    {
        return view('admin.new_page');
    }

	public function create(Request $request)
	{
		$validator = Validator::make($request->all(), [
            'page_title'   => 'required',
            'page_url'     => 'required',
            'page_content' => 'required',
            ]);
            
            if ($validator->fails()) {
                return redirect()->back()->with('error', 'Oops! Something went wrong, Remember that all fields required.');
            }else{
                $get_pages = DB::table('pages')->where('page_url', $request->get('page_url'))->first();
                if ($get_pages) {
                        return redirect()->back()->with('error', 'Oops! Page URL already exists.');
                }else{
    				$post           = new Page();
    				$post->title    = $request->get('page_title');
    				$post->page_url = $request->get('page_url');
    				$post->content  = $request->get('page_content');
    				$post->save();
    				return redirect()->back()->with('success', 'Page was successfully added.');
                }
			}
    }


    // Show Requested Page
	public function show($page)
    {
        // check if exists
        $pages   = DB::table('pages')->where('page_url', $page)->first();
        if ($pages) {
            // Page Exists
            $page_content = $pages->content;
            $page_url     = $pages->page_url;
            $page_title   = $pages->title;
            // Get Settings 
            $setting  = DB::table('settings')->where('id', 1)->first();

            // Send as array
            $data   = array(
            'page_content' => $page_content,
            'page_url'     => $page_url,
            'page_title'   => $page_title,
            'setting'      => $setting
            );
            return view('show_pages')->with($data);
        }else{
            return redirect ('/');
        }
    }

    public function pages_list()
    {
        $pages = Page::all();
        return view('admin.pages')->with('pages', $pages);
    }

    public function deletePage(Request $request, $id)
    {
        $check_page = DB::table('pages')->where('id', $id)->first();
        if ($check_page) {
                $delete_page = DB::table('pages')->where('id', $id)->delete();
                return redirect()->back()->with('success', 'Page was successfuly deleted.');
            }else{
                return redirect()->back()->with('error', 'Oops! You do not have more categories to move media.');
            }
    }

    public function editPage(Request $request, $id)
    {
        $check_page = DB::table('pages')->where('id', $id)->first();
        if ($check_page) {
            return view('admin.edit_page')->with('check_page', $check_page);
        }else{
            return redirect()->back();
        }
    }


    public function updatePage(Request $request, $id)
    {
        $check_page   = DB::table('pages')->where('id', $id)->first();
        $page_title   = $request->get('page_title');
        $page_url     = $request->get('page_url');
        $page_content = $request->get('page_content');
        $validator = Validator::make($request->all(), [
            'page_title'   => 'required',
            'page_url'     => 'required',
            'page_content' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->with('error', 'Oops! Something went wrong. Please try again.');
        }else{
            Page::where('id', $id)->update(array(
                  'title'    => $page_title,
                  'page_url' => $page_url,
                  'content'  => $page_content
                    ));
            return redirect()->back()->with('success', 'Page was successfuly updated.');
        }
    }



}
