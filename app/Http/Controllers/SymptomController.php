<?php 
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Symptom;
use App\Models\Entry;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;

class SymptomController extends Controller {

    /**
     * return current user's saved symptoms paginated by latest entry
     */
    public function index()
    {
        $user_id = Auth::user()->id;
        $entries = Entry::join('symptoms', 'entrys.id', '=', 'symptoms.entry_id')
            ->select(['entrys.log_date', 'symptoms.name', 'symptoms.id'])
            ->where('entrys.user_id', '=', $user_id)
            ->orderBy('entrys.log_date', 'DESC')
            ->paginate(5);

        return view('tracker', ['entries' => $entries]);
    }

    /*
    * return current user's entries and associated symptoms for the requested week, starting from Sunday
    */
    public function reports(Request $request)
    {
        if (!$request->filled('dir') && !$request->filled('start')) { // get current week if not date is specified
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
        $user_id = Auth::user()->id;
        
        $formatted_entries = Entry::weekly_entries($user_id, $start_date, $end_date);

        return view('reports.reports', ['entries' => $formatted_entries]);
    }

    /**
     * create a symptom entry for the current user with forms/symptom-form request data
     * set `symptom.severity` to null (for now)
     @param Request $request
     */
    public function store(Request $request)
    {
       	$input = $request->all();

        $user_id = Auth::user()->id;

        $entry = Entry::create([
		    'log_date' => $request->get('log_date'),
		    'user_id' => $user_id
		]);

		if (isset($input['names'])) {
			foreach ($input['names'] as $symptom) {
				$symptom = new Symptom(['name' => $symptom, 'user_id' => $user_id, 'severity' => null, 'created_at' => date("Y-m-d H:i:s")]);
				$entry->symptoms()->save($symptom); 
			}
		}

		return redirect('/')->with('status', 'Symptom Data Has Been inserted');
    }

    /**
     * delete a symptom given by its id
     */
    public function destroy($id)
    {
        Symptom::where('id', $id)->delete();
        return redirect()->back()->with('success','Delete Successful');
    }

}
?>