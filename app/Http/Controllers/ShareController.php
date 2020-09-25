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
     * return current user's shares
     */
    public function index() 
    {
    	$user_id = Auth::user()->id;
    	$user_shares = Share::where('user_id', $user_id)->get();

    	return view('shares.index', ['shares' => $user_shares]);
    }

    /**
     * create a share entry for the current user with a cryptographically secure random value as the access_string
     */
    public function store() 
    {
		$user_id = Auth::user()->id;
		$access_string = bin2hex(openssl_random_pseudo_bytes(40));

        $entry = Share::create([
		    'access_string' => $access_string,
		    'user_id' => $user_id
		]);

		return redirect('/shares')->with('status', 'New Share Link Has Been Created');
    }

    /**
     * delete a share given by its id
     */
    public function destroy($id)
    {
        Share::where('id', $id)->delete();
        return redirect()->back();
    }

    /**
     * find and return a user's formatted array of symptoms by using the given $token to identify the user.
     * no user data is to be passed to the view which should not contain any personally identifiable information.
     @param $token
     */
    public function view(Request $request, $token) 
    {
    	$share = Share::where('access_string', $token)->first();

    	if (!$request->has('dir') && !$request->has('start')) { // get current week if not date is specified
            if (date('D') == 'Sun') {
                $start_date = date('Y-m-d');
            } else {
                $start_date = date('Y-m-d', strtotime('last sunday'));
            }
        } else { // otherwise calculate starting date for requested date and direction
            $request_day_of_week = date("w", strtotime($request->query('start')));
            if ($request_day_of_week == 0) {
                $start_date = $request->query('start');
            } else {
                $start_date = date('Y-m-d', strtotime('last sunday', strtotime($request->query('start'))));
            }

            if (strtolower($request->query('dir')) == 'prev') {
                $start_date = date('Y-m-d', strtotime('last sunday', strtotime($start_date)));
            } else {
                $start_date = date('Y-m-d', strtotime('next sunday', strtotime($start_date)));
            }
        }
  
        $end_date = date('Y-m-d', strtotime($start_date.'+7 days'));

        $formatted_entries = Entry::weekly_entries($share['user_id'], $start_date, $end_date);

    	return view('shares.view', ['entries' => $formatted_entries, 'access_string' => $token]);
    }
}