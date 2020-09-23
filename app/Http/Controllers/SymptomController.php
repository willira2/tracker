<?php 
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Symptom;
use App\Models\Entry;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SymptomController extends Controller {

    /*
    * return current user's entries and associated symptoms for the current week, starting from Sunday
    */
    public function index()
    {
        if (date('D' == 'Sun')) {
        	$start_date = date('Y-m-d');
        } else {
        	$start_date = date('Y-m-d',strtotime('last sunday'));
        }

        $end_date = date('Y-m-d', strtotime($start_date.'+7 days'));

        $user_id = Auth::user()->id;
        $entries = Entry::join('symptoms', 'entrys.id', '=', 'symptoms.entry_id')
            ->select('*')
            ->where('entrys.user_id', '=', $user_id)
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

        return view('reports.reports', ['entries' => $formatted_entries]);
    }

    public function create()
    {
    	if (date('D' == 'Sun')) {
        	$start_date = date('Y-m-d');
        } else {
        	$start_date = date('Y-m-d',strtotime('last sunday'));
        }

        $end_date = date('Y-m-d', strtotime($start_date.'+7 days'));

        $user_id = Auth::user()->id;
        $entries = Entry::join('symptoms', 'entrys.id', '=', 'symptoms.entry_id')
            ->select('*')
            ->where('entrys.user_id', '=', $user_id)
            ->whereBetween('entrys.log_date', [$start_date, $end_date])
            ->groupBy('entrys.log_date', 'symptoms.name')
            ->get();

        return view('tracker', ['entries' => $entries]);
    }

    public function show()
    {
        return view('symptom-form');
    }

    public function store(Request $request)
    {
    	// $data = $request->validate([
     //        'name' => 'required|max:255',
     //        'severity' => 'required'
     //    ]);

       	$input = $request->all();

        $user_id = Auth::user()->id;

        $entry = Entry::create([
		    'log_date' => $request->get('log_date'),
		    'user_id' => $user_id
		]);

		if (isset($input['names'])) {
			foreach ($input['names'] as $symptom) {
				$symptom = new Symptom(['name' => $symptom, 'user_id' => $user_id, 'severity' => 1, 'created_at' => date("Y-m-d H:i:s")]);
				$entry->symptoms()->save($symptom); 
			}
		}

		return redirect('/')->with('status', 'Symptom Data Has Been inserted');
    }

    public function edit($id)
    {
    	$user_id = Auth::user()->id;
    	$symptom = Symptom::where([
		    ['id', $id],
		    ['user_id', $user_id],
		])->first();

        return view('edit-symptom-form',compact(['symptom']));
    }

     public function update(Request $request, $id)
    {
        // $request->validate([
        //  'name' => 'required',
        //  'email' => 'required|email',
        //  'phone' => 'required'
        // ]);

        $user_id = Auth::user()->id;

        Symptom::where('id', $id)->update($request->all());
        // return redirect()->back()->with('success','Update Successfully');
        return view('dashboard');
    }

    public function destroy($id)
    {
        Symptom::where('id', $id)->delete();
        return redirect()->back()->with('success','Delete Successful');
    }


}
?>