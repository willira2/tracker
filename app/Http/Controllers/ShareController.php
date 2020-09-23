<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Share;
use App\Models\Entry;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class ShareController extends Controller
{
    /**
     * return current user's entries and associated symptoms for the current week, starting from Sunday
     */
    public function index() {
    	$user_id = Auth::user()->id;
    	$user_shares = Share::where('user_id', $user_id)->get();

    	return view('shares.index', ['shares' => $user_shares]);
    }

    public function store() {
		$user_id = Auth::user()->id;
		$access_string = bin2hex(openssl_random_pseudo_bytes(40));

        $entry = Share::create([
		    'access_string' => $access_string,
		    'user_id' => $user_id
		]);

		return redirect('/shares')->with('status', 'New Share Link Has Been Created');
    }

    public function destroy($id)
    {
        Share::where('id', $id)->delete();
        return redirect()->back();
    }

    public function view(Request $request, $token) {
    	$share = Share::where('access_string', $token)->first();

    	// echo $share['user_id']; exit;

    	if (date('D' == 'Sun')) {
        	$start_date = date('Y-m-d');
        } else {
        	$start_date = date('Y-m-d',strtotime('last sunday'));
        }

        $end_date = date('Y-m-d', strtotime($start_date.'+7 days'));

    	$entries = Entry::join('symptoms', 'entrys.id', '=', 'symptoms.entry_id')
            ->select('*')
            ->where('entrys.user_id', '=', $share['user_id'])
            ->whereBetween('entrys.log_date', [$start_date, $end_date])
            ->groupBy('entrys.log_date', 'symptoms.name')
            ->get();

        $current_date = $start_date;
        $last_date = $end_date;
        $formatted_entries = [];

        while($current_date<$last_date) {
        	$formatted_entries[] = ['date'=>$current_date];
        	$current_date = date('Y-m-d', strtotime('+1 day', strtotime($current_date)));
        }

        foreach ($entries as $entry) {
        	$key = array_search($entry->log_date, array_column($formatted_entries, 'date'));
        	if ($key !== false) {
        		$formatted_entries[$key]['symptoms'][] = $entry->name; 
        	}
        }

    	return view('shares.view', ['entries' => $formatted_entries]);
    }
}
