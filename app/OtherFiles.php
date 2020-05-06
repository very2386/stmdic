<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Validator;
use Lang;
use File;
use DB;
class OtherFiles extends Model
{
    protected $table = 'otherfiles';
    protected $fillable = ['id','cm_id','name','fname','position','filetype'] ;

    //上傳多個文件/圖片
    public static function upload_other_files($id, $request){
        $filefrom = $request;
        $subtype = ['pdf','ppt','pptx','doc','docx'] ;
        $saved_pics = [];
        $path = '/public/upload/cm/'.$id;
        if(!is_dir(base_path().$path)) mkdir(base_path().$path);
        $oname = [];
        foreach($filefrom as $file) {
            $fn = $file->getClientOriginalName();
            $fsize = $file->getClientSize();
            $ftype = $file->getClientOriginalExtension();
            if($fsize>=25*1024*1024) return ['status'=>'err','msg'=>'檔案大小不可超過25MB!'];
            $fdata = explode('.',$fn) ;
            $subname = $fdata[1] ;
            if(in_array($fn, $oname)) continue;
            $oname[] = $fn;
            $fname = '/'.uniqid().".".$subname ;
            copy($file, base_path().$path.$fname);
            $fdata = ['cm_id'=>$id,'name'=>$fn,'fname'=>'/upload/cm/'.$id.$fname,'position'=>request('position'),'filetype'=>$ftype];
            Self::create($fdata) ; 
        }
        return ['status'=>'ok'];
    }
    //文件下載專用
    public static function upload_files($id,$ftype,$file){
        $file_data = Self::where('cm_id',$id)->where('filetype',$ftype)->delete();
        $fn = $file->getClientOriginalName();
        $path = '/public/upload/cm/'.$id;
        if(!is_dir(base_path().$path)) mkdir(base_path().$path);
        $fsize = $file->getClientSize();
        if($fsize>=25*1024*1024) return ['status'=>'err','msg'=>'檔案大小不可超過25MB!'];
        $fdata = explode('.',$fn) ;
        $subname = $fdata[1] ;
        $fname = '/'.uniqid().".".$subname ;
        copy($file, base_path().$path.$fname);
        $fdata = ['cm_id'=>$id,'name'=>$fn,'fname'=>'/upload/cm/'.$id.$fname,'position'=>request('position'),'filetype'=>$ftype];
        Self::create($fdata) ; 
        return ['status'=>'ok'];
    }
 }
