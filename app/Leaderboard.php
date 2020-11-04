<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Leaderboard extends Model
{
	public $timestamps = false;
	protected $table = 'leaderboards';
    protected $fillable = ['name', 'age', 'address', 'points'];
}
