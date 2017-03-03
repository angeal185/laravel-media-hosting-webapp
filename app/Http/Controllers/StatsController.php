<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use DB;
use Illuminate\Http\Request;
use App\Stats;

class StatsController extends Controller
{
	public function index()
	{
		$all_stats   = DB::table('stats')->orderBy('id', 'desc')->paginate(25);
		return view('admin.stats')->with('all_stats', $all_stats);
	}

	// Clear stats

	public function Clear()
	{
		$check_stats = Stats::all();
		if (count($check_stats) > 0) {
			$clear = Stats::truncate();
			return redirect()->back()->with('success', 'All Logs has been successfully cleared');
		}else{
			return redirect()->back()->with('error', 'No Logs to delete');
		}
		
	}
}