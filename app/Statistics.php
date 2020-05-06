<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Cm;
use Validator;
use Lang;

class Statistics extends Model
{
    protected $table = 'statistics';
    protected $fillable = ['compid','position','hits'];
}
