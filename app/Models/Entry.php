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
}
