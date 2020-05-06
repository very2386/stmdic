<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Cm;
/**
 * 專管會員收藏和訂閱的
 * 收藏：action=favorite
 * 訂閱：action=subscribe
 */

class MembersCollects extends Model
{
    public $table = 'members_collects';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'mid', 'action', 'type', 'expertid', 'postid', 'created_at', 'updated_at',
    ];

    public static function get_collect_status($type, $action, $targetid){
    	$ret=['favorites'=>'', 'subscribes'=>'','likes'=>'', 'dislikes'=>''];
    	$targetcol = $type == 'experts' ? 'expertid' : 'postid';
    	//收藏和訂閱按鈕
		if(session('mid')){
			$collects = Self::where(['mid'=>session('mid'), 'type'=>$type, 'action'=>$action, $targetcol=>$targetid, 'canceled'=>'N'])->first();
			if($collects) return true;
		}
		return false;
    }

    public static function do_collect(){
        $msg = '';
        $data = request()->only(['type', 'action', 'targetid', 'move']);
        $mid = session('mid');
        if(!$mid){
            $msg = '請先登入會員，才可以使用本功能';
            return ["status"=>"err", "msg"=>$msg];
        }
        $targetcol = $data['type'] == 'experts' ? "expertid" : "postid";
        $o = MembersCollects::where(['mid'=> $mid, 'type'=>$data['type'], $targetcol=>$data['targetid'], 'action'=>$data['action'] ])->first();
        $move = $data['move'] == 'cancel' ? 'cancel' : 'add';
        $d = Cm::where('id', $data['targetid']);
        $obj = $d->first();

        if($move == 'cancel' && $o && $o->canceled != 'Y' ){
            Cm::where('id', $data['targetid'])->decrement($data['action']);
            MembersCollects::where(['mid'=> $mid, 'type'=>$data['type'], $targetcol=>$data['targetid'], 'action'=>$data['action']])->update(['canceled'=>'Y']);
        }elseif( !$o || $o->canceled == 'Y'){
            Cm::where('id', $data['targetid'])->increment($data['action']);
            MembersCollects::create(['mid'=> $mid, 'type'=>$data['type'], $targetcol=>$data['targetid'], 'action'=>$data['action']]);
        }

        return ["status"=>"ok", "msg"=>$msg];
    }
}
