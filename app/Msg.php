<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Members;
use App\Cm;
use Mail;
use App\Mail\CompanyContact;

class Msg extends Model
{
    public $table = 'msg';
    protected $fillable = [
        'mid', 'to_mid', 'msg', 'mstatus'
    ];
    public static function write_msg($to_mid, $msg){
        if(is_numeric($to_mid)){
            $to_mrd = \App\Members::where('id', $to_mid)->first();
        }else{
            $to_mrd = \App\Members::where('email', $to_mid)->first();
            $to_mid = $to_mrd? $to_mrd->id : 0;
        }
        if(!$to_mrd) return ['status'=>'err', 'msg'=>'找不到這個Email信箱對應的會員資料'];
        $to_name = $to_mrd->sname ? $to_mrd->sname : $to_mrd->name;
    	$ins = ['to_mid'=>$to_mid, 'msg'=>$msg, 'mid'=>session('mid'), 'mstatus'=>'N'];
    	Self::create($ins);
        return ['status'=>'ok', 'msg'=>'訊息已發送給'.$to_name];
    }
    public static function get_msg($mstatus=''){
    	$where = ['mid'=>session('mid')];
    	if($mstatus) $where['mstaus'] = $mstatus;
    	$rs = Self::where($where)->orderBy('id', 'desc')->get();
    	return $rs;
    }
    //標示為已讀
    public static function chg_msg_status(){
        Self::where('sn',request('id'))->update(['mstatus'=>'Y']);
        return ['status'=>'ok'];
    }
    //發送面試通知(站內信及email)
    public static function send_interview(){
        $member = Members::where('id',request('id'))->first();//應徵者會員資料
        $job = Cm::where('id',request('jobid'))->first();
        $comp = Members::where('id',session('mid'))->first();//職缺所屬公司
        $job_cont = json_decode($job->cont) ;
        $msg = '親愛的會員 '.$member->name.' 您好：<br>您投遞的 '.$job_cont->job_title.' 職缺，' .$comp->name.' 回覆訊息如下：<br>'.request('msg') ;
        //站內信
        $ins = ['to_mid'=>$member->id, 'msg'=>$msg, 'mid'=>session('mid'), 'mstatus'=>'N'];
        Self::create($ins);
        //發email
        \App\Msg::write_msg($member->id, $msg);
        $subject = '智慧生醫產業聚落交流平台-面試回覆通知信 '.date('Y-m-d H:i:s');
        Mail::to($member->email)->send(new CompanyContact($subject,$msg));
        return ['status'=>'ok', 'msg'=>'訊息已發送給'.$member->name];
    }
}
