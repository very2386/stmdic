<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $table = 'car';
    protected $fillable = ['asn', 'car_date', 'cur_num', 'max_num', 'max_join', 'car_place', 'notes'];
}
