<?php 
namespace App;
use DB;
use Session;
use App\Cm;
/*
use Mail;
use View;
use Imagine\Image\Box;
use Imagine\Image\ImageInterface;
use Orchestra\Imagine\Facade as Imagine;
use App\MailLog;
use Lang;
*/

class Funcs {
	public static function log_visitors(){
		DB::table('visit_logs')->insert(['fromip'=>request()->ip(), 'sessid'=>Session::getId(), 'target_url'=>request()->path(), 'adate'=>time(), 'sdate'=>date('Y-m-d')]);
	}
	public static function get_visitors($show_visitor){
		if(!$show_visitor) $show_visitor = '15d';
		$data = ['labels'=>[], 'values'=>[]];
		if($show_visitor == '15d'){
			for($i=15; $i >= 0; $i--){
				$stime = strtotime('- '.$i.' days');
				$etime = $stime + 86400;
				if($i == 0){
					$data['labels'][] = '';
					$data['values'][] = '';
				}else{
					$data['labels'][] = date('m-d', $stime);
					$data['values'][] = DB::table('visit_logs')->whereBetween('adate', [$stime, $etime] )->count();
				}
			}
		}
		$ret = ['labels'=>json_encode($data['labels'],JSON_UNESCAPED_UNICODE), 'values'=>json_encode($data['values'],JSON_UNESCAPED_UNICODE)];
		return $ret;
	}
	public static function get_counts(){
		$ret['visits'] = DB::table('visit_logs')->count();
		$ret['downloads'] = DB::table('download_logs')->count();
		$ret['contacts'] = DB::table('contact_logs')->count();
		return $ret;
	}
	public static function ret($ret, $status='ok'){
		if(!is_array($ret)) $ret = array("msg"=>$ret);
		if(!isset($ret['status'])) $ret['status'] = $status;
		return $ret;
	}
	public static function load_page($url){
		echo "<script>location.href='".$url."'</script>";
	}
	public static function chk_ip(){
		$ip = request()->ip();
		$ips = explode('.',$ip);
		$rs = Cm::where('position', 'ip')->where('type', 'allow')->get();
		if(!$rs) return true;
		foreach($rs as $rd){
			$pass = true;
			$allow_ip = $rd->name;
			$segs = explode('.',$allow_ip);
			if(!is_array($segs) || count($segs) != 4){
				continue;
			}
			for($i=0; $i<4; $i++){
				if($segs[$i] != '*' && $segs[$i] != $ips[$i] ) $pass = false;
			}
			if($pass === true) return true;
		}
		exit;
	}
	public static function GetAge($birth, $chkdate){
		list($byear,$bmonth,$bday) = explode("-",$birth); // 把年月日分開.
		list($cyear,$cmonth,$cday) = explode("-",$chkdate);
		$current_age = $cyear - $byear; // 現在年份減生日年份
		
		// 比較日期, 年份必須要一致.
		$xdate = sprintf("%04d-%02d-%02d",$cyear,$bmonth,$bday);
		if ($chkdate < $xdate) { // 如果還沒有過生日, 年齡要減1.
			$current_age = $current_age-1;
		}
		return $current_age;
	}
	public static function MakePass($length, $type = ''){
		if($type == 'upper'){
			$possible = "ABCDEFGHIJKLMNPQRSTUVWXYZ";
		}elseif($type == 'lower'){
			$possible = "abcdefghijkmnprstuvwxyz";
		}elseif($type == 'num'){
			$possible = "0123456789";
		}else{
			$possible = "0123456789". 
			"abcdefghijkmnprstuvwxyz". 
			"ABCDEFGHIJKLMNPQRSTUVWXYZ"; 
		}
		$str = ""; 
		while(strlen($str) < $length) { 
			$str .= substr($possible, (rand() % strlen($possible)), 1); 
		} 
		return($str); 
	} 
	public static function chk_ary($a){
		if($a && is_array($a) && count($a) > 0) return true;
		return false;
	}
	public static function get_report(){
		$data = ['labels'=>[], 'values'=>[]];
		$post = 0 ; 
		$news = 0 ; 
		$data['labels'] = ["首頁", "聚落新知", "行銷專區", "討論區"] ; 
		$index = Cm::where('position','people')->where('type','index')->value('hits');
		$marketing = Cm::where('position','people')->where('type','marketing')->value('hits');
		$post_data = Cm::where('position','posts')->where('mstatus','Y')->get();
		foreach($post_data as $rd){
			$post += $rd->hits ; 
		}
		$news_data = Cm::where('position','news')->where('mstatus','Y')->get();
		foreach($news_data as $rd){
			$news += $rd->hits ; 
		}
		$data['values'] = [$index,$news,$marketing,$post] ;
		$ret = ['labels'=>json_encode($data['labels'],JSON_UNESCAPED_UNICODE), 'values'=>json_encode($data['values'],JSON_UNESCAPED_UNICODE)];
		return $ret ; 
	}
}