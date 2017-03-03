<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use App\Comment;
use Validator;
use App\CommentFlags;
use App\Settings;
use App\Message;
use Carbon\Carbon;

class CommentController extends Controller
{
	public function addComment(Request $request, $url)
	{
		$validator = Validator::make($request->all(), [
            'comment_text'      => 'required',
            ]);
            
            if ($validator->fails()) {
                return redirect()->back()->with('error', 'Comment box cannot be empty.');
            }
        $check_settings = Settings::where('id', 1)->first();
        if ($check_settings->auto_approve_comments == 0) {
        	$status = 1;
        }elseif (Auth::user()->level === 1) {
        	$status = 1;
        }else{
        	$status = 0;
        }
		$get_comment = $request->get('comment_text');
		$user_id     = Auth::user()->id;
		$check_url   = DB::table('media')->where('short_url', $url)->first();
		if ($check_url AND !Auth::guest()) {
			$save_comment = new Comment;
			$save_comment->user_id  = $user_id;
			$save_comment->media_id = $check_url->id;
			$save_comment->comment  = $get_comment;
			$save_comment->status   = $status;
			$save_comment->save();

			// Send notice
			if ($user_id !== $check_url->user_id) {
			$send_notice = DB::table('notifications')->insert([
	                'user_id'    => $check_url->user_id, 
	                'media_id'   => $check_url->id, 
	                'type'       => 'comment', 
	                'status'     => 0,
	                'created_at' => Carbon::now()->toDateTimeString(),
	                'updated_at' => Carbon::now()->toDateTimeString()
	                ]);
			}
			return redirect()->back()->with('success', 'Comment was successfully added.');
		}else{
			return redirect()->back();
		}
		
	}

	public function flag(Request $request, $url)
	{
		$check_comment = DB::table('comments')->where('id', $url)->first();
			if (!$check_comment) {
				return redirect()->back();
			}elseif ($check_comment->user_id == Auth::user()->id) {
				return redirect()->back()->with('error', 'You cannot flag your comments.');
			}else{
				$user_id = Auth::user()->id;
				$check_flag = CommentFlags::where('user_id', $user_id)
							  ->where('comment_id', $check_comment->id)
							  ->first();
				if ($check_flag) {
					return redirect()->back()->with('error', 'You are already flag this comment.');
				}else{
					$new_flag = new CommentFlags;
					$new_flag->user_id = $user_id;
					$new_flag->comment_id = $check_comment->id;
					$new_flag->save();
					return redirect()->back()->with('success', 'Comment was successfully flagged.');

				}
			}
	}

	public function admin()
	{
		$all_comments = Comment::orderBy('id', 'desc')->get();
		return view('admin.comments')->with('all_comments', $all_comments);
	}

	public function flagged()
	{
		$flagged_comment = DB::table('comments_flags')->get();
		return view('admin.comments_flags')->with('flagged_comment', $flagged_comment);
	}

	public function markFlag(Request $request, $id)
	{
		$get_settings = DB::table('settings')->where('id', 1)->first();
		$website_email = $get_settings->website_email;

		$check_flag = DB::table('comments_flags')->where('id', $id)->first();
		if ($check_flag) {
			$get_user = $check_flag->user_id;
			$check_user = DB::table('users')->where('id', $get_user)->first();
			if ($check_user) {
				$send_tnx = new Message;
				$send_tnx->msg_from    = "Site Team";
				$send_tnx->msg_to      = $check_user->username;
				$send_tnx->email       = $website_email;
				$send_tnx->is_registed = 1;
				$send_tnx->msg_content = "Hi, ".$check_user->username.". we receive your flagged comment. Thanks.";
				$send_tnx->status      = 0;
				$send_tnx->type        = "notice";
				$send_tnx->save();
				$delete_flag = DB::table('comments_flags')->where('id', $id)->delete();
				if ($delete_flag) {
					return redirect('/dashboard/comments/flagged')->with('success', 'Comment flag was successfully set as read.');
				}else{
					return redirect('/dashboard/comments/flagged')->with('error', 'Oops! something went wrong, please try again.');
				}

			}
		}
	}

	public function deleteComment(Request $request, $id)
    {
        $check_comment = DB::table('comments')->where('id', $id)->first();
        if ($check_comment) {
            $delete_comment = DB::table('comments')->where('id', $id)
                        ->delete();
            $deltee_flag = DB::table('comments_flags')->where('comment_id', $id)->delete();
            return redirect()->back()->with('success', 'Comment was successfully Deleted.');
        }else{
            return redirect()->back()->with('error', 'Oops! something went wrong. Please try again.');
        }
    }





}