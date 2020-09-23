<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Share extends Model
{
    use HasFactory;

    protected $table = 'shares';
    protected $fillable = [
	    'user_id',
	    'access_string'
	];

    /**
     * Get the share that belongs to the user
     */
    public function symptom()
    {
        return $this->belongsTo('App\Models\User');
    }
}
