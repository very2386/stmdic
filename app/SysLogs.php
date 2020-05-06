<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SysLogs extends Model
{
    protected $fillable = ['type','adminid','mid','oid','email','vendorid','action','fromip','mstatus','detail'];
    public static function login($adminid){
    	Self::create(['type'=>'login', 'adminid'=>$adminid, 'fromip'=>request()->ip(), 'mstatus'=>'Y']);
    }
    public static function company_log($mid,$type){
    	Self::create(['type'=>$type, 'mid'=>$mid, 'fromip'=>request()->ip(), 'mstatus'=>'Y']);
    }
    public static function login_error($adminid, $password){
    	$detail = json_encode(['loginid'=>$adminid, 'password'=>$password]);
    	Self::create(['type'=>'login', 'fromip'=>request()->ip(), 'mstatus'=>'N', 'detail'=>$detail]);
    }
}
