<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Symptom extends Model
{
    use HasFactory;

    protected $table = 'symptoms';
    protected $fillable = [
	    'user_id',
	    'name',
	    'severity'
	];

    /**
     * Get the symptom that belongs to the entry
     */
    public function symptom()
    {
        return $this->belongsTo('App\Models\Entry');
    }
}
