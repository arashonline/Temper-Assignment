<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Analytic extends Model implements Data
{
//    protected $table = 'analytics';
    public function loadData()
    {
        return Analytic::all()->toArray();
    }
}
