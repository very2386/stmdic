<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Cm;
use Validator;
use Lang;

class Products extends Model
{
    protected $fillable = ['pid', 'type', 'sdate', 'age', 'price', 'attachments', 'contents', 'series', 'works' ];
    public static function edit($request){
    	$id = $request->input('id');
    	$data = $request->only(['type', 'sdate', 'age', 'price', 'attachments', 'contents', 'series', 'works']);
    	$validator = Validator::make($data, [
            'sdate'=>'required',
            'price'=>'required',
            'age'=>'required',
        ],[
            'required'=>'必填欄位，請勿空白'
        ]);
        if ($validator->fails()) {
            return ['status'=>'err', 'errors'=> $validator->errors()->toArray()];
        }
        $cm = Cm::edit($request);
        if(isset($cm['status'])){
            if($cm['status'] == 'err') return $cm;
            $id = $cm['id'];
        }else{
            return ['status'=>'err', 'errors'=> '發生不明錯誤請聯絡程式人員'];
        }
        $prd = Self::where('pid', $id)->first();
        if($prd){
    		Self::where('pid', $id)->update($data);
    	}else{
    		$data['pid'] = $id;
            Self::create($data);
    	}
    	return ['status'=>'ok', 'id'=>$id];
    }
}
