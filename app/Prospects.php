<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Validator;
use Lang;
use File;
use DB;
use App\OtherFiles;
class Prospects extends Model
{
    protected $table = 'prospect';
    protected $fillable = ['position','type','date','edate','name','cont','status'] ;

    public static function new_obj(){
        return (object)['position'=>'','type'=>'','date'=>'','edate'=>'','name'=>'','cont'=>'','status'=>''];
    }
    //展會新增/編輯
    public static function prospect_edit($request){
        $data = $request->only('position','type','date','edate','name','cont','status');
        $id = $request->id;
        $validator = Validator::make($data, [
            'name'=>'required',
            'date'=>'required'
        ],[
            'required'=>'必填欄位，請勿空白'
        ]);
        if ($validator->fails()) {
            return ['status'=>'err', 'errors'=> $validator->errors()->toArray()];
        }

        if($id){
            $edit = Self::where('id',$id)->update($data);
        }else{
            $edit = Self::create($data); 
            $id = $edit->id ; 
        }
       
        //其他多張或文件
        if(request()->hasFile('other_files')){
            $rt = OtherFiles::upload_other_files($id,request()->file('other_files'));
            if($rt['status']=='err') return $rt ; 
        }

        return ['status'=>'ok'];
    }
 }
