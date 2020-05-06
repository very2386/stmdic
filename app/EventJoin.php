<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventJoin extends Model
{
    protected $table = 'event_join';
    protected $fillable = ['eventid', 'mid', 'content','mstatus','qrcode','adminid','checkintime'];
}
