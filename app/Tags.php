<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Validator;
class Tags extends Model
{
    protected $table = 'tags';
    protected $fillable = [ 'lang', 'type', 'name', 'color'];
    public $timestamps = false;
    public static function edit($request){
        $id = $request->input('id');
        $data = $request->only(['lang', 'type', 'name', 'color']);
        $validator = Validator::make($data, [
            'type'=>'required',
            'name'=>'required',
            'color'=>'required'
        ],[
            'required'=>'必填欄位，請勿空白'
        ]);
        if ($validator->fails()) {
            return ['status'=>'err', 'errors'=> $validator->errors()->toArray()];
        }
        if($id){
            Self::where('id', $id)->update($data);
            $tag = Self::where('id', $id)->first();
        }else{
            $tag = Self::create($data);
            $id = $tag->id;
        }
        return ['status'=>'ok', 'id'=>$id, 'data'=>$tag];
    }
}
