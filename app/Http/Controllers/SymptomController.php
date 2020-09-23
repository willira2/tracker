<?php 
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Symptom;
use App\Models\Entry;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SymptomController extends Controller {

    /**
     * return current user's saved symptoms
     */
    public function index()
    {
        $user_id = Auth::user()->id;
        $entries = Entry::join('symptoms', 'entrys.id', '=', 'symptoms.entry_id')
            ->select('*')
            ->where('entrys.user_id', '=', $user_id)
            ->groupBy('entrys.log_date', 'symptoms.name')
            ->get();

        return view('tracker', ['entries' => $entries]);
    }

    /*
    * return current user's entries and associated symptoms for the current week, starting from Sunday
    */
    public function reports()
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
     * return symptom record given by id
     @param $id
     */
    public function edit($id)
    {
    	$user_id = Auth::user()->id;
    	$symptom = Symptom::where([
		    ['id', $id],
		    ['user_id', $user_id],
		])->first();

        return view('edit-symptom-form',compact(['symptom']));
    }

    /**
     * update a symptom entry given by id with forms/edit-symptom-form request data
     @param Request $request, $id
     */
     public function update(Request $request, $id)
    {
        $user_id = Auth::user()->id;
        Symptom::where('id', $id)->update($request->all());
        return redirect()->back()->with('success','Update Successfully');
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