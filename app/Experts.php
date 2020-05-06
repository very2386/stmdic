<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Experts extends Model
{
    protected $fillable = ['type', 'email','idnum','passwd','lname','fname','gender','birth','tel','mobile','zip','county','district','address','mstatus',];
    public static function get_types(){
    	return ['專家','醫師','服務','創業','其他'];
    } 
    public static function do_edit($mid=""){
        $err = array();
        $req = request()->all();
        if(!$req['lname']){
            $err['lname'] = '請輸入專家姓氏';
        }
        if(!$req['fname']){
            $err['fname'] = '請輸入專家名字';
        }
        if(!$req['birth']){
            $err['birth'] = '請選擇專家生日';
        }
        if(!$req['tel_zone']){
            $err['tel_zone'] = '請輸入市話區碼';
        }else{
            if(!is_numeric($req['tel_zone'])){
                $err['tel_zone'] = '市話區碼請輸入半型數字';
            }elseif(strlen($req['tel_zone']) > 3){
                $err['tel_zone'] = '市話區碼長度有誤';
            }
        }
        if(!$req['tel']){
            $err['tel'] = '請輸入市話號碼';
        }else{
            if(strlen($req['tel']) < 6){
                $err['tel'] = '市話長度有誤';
            }
        }
        if(!$req['mobile']){
            $err['mobile'] = '請輸入手機號碼';
        }else{
            if(strlen($req['mobile']) < 10 || strlen($req['mobile']) > 15){
                $err['mobile'] = '手機號碼長度有誤';
            }
        }
        if(!$req['county']){
            $err['county'] = '請選擇所在縣市';
        }
        if(!$req['district']){
            $err['district'] = '請選擇鄉鎮市區';
        }
        if(!$req['zip'] || !$req['address']){
            $err['address'] = '請輸入地址資料';
        }


        if(count($err)){
            return ['status'=>'err', 'errors'=>$err, 'msg'=>'請檢查錯誤'];
        }else{
            $req['tel'] = $req['tel_zone']."-".$req['tel'];
            if($req['guardian_tel_zone'] && $req['guardian_tel']){
                $req['guardian_tel'] = $req['guardian_tel_zone']."-".$req['guardian_tel'];
            }
        }
        if(!$mid){
            $ret = Self::do_signup(request()->all());
            if($ret['status'] == 'err') return $ret;
            $mid = $ret['id'];
        }
        $cols = \Schema::getColumnListing('members');
        $req = array_only($req, $cols);
        unset($req['passwd']);
        Self::where('id', $mid)->update($req);
        $minfo = Self::where('id', $mid)->first();
        session(['minfo'=>$minfo]);
        return ['status'=>'ok', 'msg'=>'資料已更新'];;
    }
    public static function new_object(){
        return (object)['id'=>'', 'type'=>'',  'email'=>'','idnum'=>'','passwd'=>'','lname'=>'','fname'=>'','gender'=>'','birth'=>'','tel'=>'','mobile'=>'','zip'=>'','county'=>'','district'=>'','address'=>'','mstatus'=>''];
    }
    public static function admin_edit(){
        $data = request()->only([ 'type', 'email', 'lname', 'fname', 'birth', 'gender', 'idnum', 'tel', 'mobile','zip', 'county', 'district', 'address',]);
        if(request('passwd')) $data['passwd'] = md5(request('passwd'));
        Members::where('id', request('id'))->update($data);
        $msg = '已修改專家資料';
        return ['status'=>'ok', 'msg'=>$msg];
    }
}
