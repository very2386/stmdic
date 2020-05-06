<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\SysLogs;
use Validator;
use Lang;
class Admins extends Model
{
    public $timestamps = true;
    protected $fillable = ['roleid', 'adminid', 'password', 'email', 'name', 'mstatus', 'country', 'vendorid', 'pic'];
    public static function get_pic($id){
        $cm = Self::where('id', $id)->first();
        if($cm && isset($cm->pic) && $cm->pic){ //在pic中有資料
            return asset($cm->pic);
        }else{
           return '/img/admin_default.png'; 
        }
    }
    public static function login($adminid, $password){
        if(!$adminid || !$password){
            session()->flash('sysmsg', '請輸入帳號及密碼!');
            return false;
        }else{
            $admin = Self::where('adminid', $adminid)->where('password', md5($password))->first();
            if($admin){
                session(['adminid'=>$admin->id, 'admininfo'=>$admin]);
                SysLogs::login($admin->id);
                return true;
            }else{
                session()->flash('sysmsg', '帳號或密碼錯誤!');
                SysLogs::login_error($adminid,$password);
                return false;
            }
        }
    }

    public static function edit($request){
        $id = $request->input('id');
        $data = $request->all();
        $chk = [
            'adminid'=>'required|max:50',
            'email'=>'required|email',
            'name'=>'required',
        ];
        if(!$id) $chk = [
            'adminid'=>'required|max:50',
            'passwd'=>'required|max:50',
            'passwd_chk'=>'required|max:50',
            'email'=>'required|email|unique:admins',
            'name'=>'required',
        ];
        $validator = Validator::make($data, $chk,[
            'required'=>'必填欄位',
            'email'=>'Email格式不正確',
            'unique'=>'這個Email已有人使用',
        ]);
        if ($validator->fails()) {
            $msg = '發生錯誤，無法新增人員。請檢查問題再試一次，謝謝！';
            return ["status"=>"err",
                "errors"=>$validator->errors()->toArray(), "msg"=>$msg];
        }
        if(!isset($data['mstatus'])) $data['mstatus'] = 'Y';
        $upd = [];
        $cols = ['roleid', 'name', 'adminid', 'email', 'mstatus', 'brief' ];
        foreach($cols as $col){
            $upd[$col] = $data[$col];
        }
        if($data['passwd'] && $data['passwd_chk']){
            if($data['passwd'] != $data['passwd_chk']){
                return ["status"=>"err", "msg"=>'確認密碼不符'];
            }
            $upd['password'] = md5($data['passwd']);
        }
        if(!$id){
            $admin = Self::create($upd);
            $id = $admin->id;
        }else{
            $admin = Self::where('id', $request->input('id'))->first();
            $admin->update($upd);
        }
        
        if($request->hasFile('picfile')){
            $pic = Self::upload_pic($id, $request);
            if(!$pic) return ['status'=>'err', 'msg'=>session('errmsg')];
            $admin->pic = $pic;
            Self::where('id', $id)->update(['pic'=>$pic]);
        }
        if($admin) return ["status"=>"ok", "admininfofo"=>$admin];
        return ["status"=>"err", "msg"=>"無法寫入資料庫"];
    }
    public static function upload_pic($id, $request){
        $subname = $request->picfile->extension();
        $types = ['jpg', 'jpeg', 'png', 'gif'];
        if(!in_array($subname, $types )){
            session()->flash('errmsg', '檔案格式'.$subname.'不允許上傳。');
            return false;
        }
        $fname = $id.'.'.$subname;
        $save_pic = $request->picfile->move(public_path().'/upload/admin', $fname);
        $path = "/upload/admin/".$fname;
        return $path;
    }
}
