<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entry extends Model
{
    use HasFactory;

    protected $table = 'entrys';
    protected $fillable = [
	    'user_id',
	    'log_date',
	];

    /**
     * Get the symptoms for the entry
     */
    public function symptoms()
    {
        return $this->hasMany('App\Models\Symptom');
    }

    /**
     * return user's entries and associated symptoms for date range reorganized by entry.log_date
     */
    public static function weekly_entries($user_id, $start_date, $end_date)
    {
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

        return $formatted_entries;
    }
}
