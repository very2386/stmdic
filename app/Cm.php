<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Sunra\PhpSimple\HtmlDomParser;
use Validator;
use Lang;
use File;
use App\OtherFiles;
use App\Members;
use DB;
use Feeds;
use Mail;
use App\Mail\BoardMaster;
use App\Statistics;
use App\SysLogs;

class Cm extends Model
{
    //
    protected $fillable = ['lang', 'position', 'name', 'brief', 'cont', 'mstatus', 'psort', 'type', 'obj', 'objsn', 'sdate', 'jdate', 'pic', 'spic', 'link', 'link_type', 'tags', 'up_sn', 'specs', 'online_status','comptel','addr','email','compfax','event_sdate','event_edate','signup_sdate','signup_edate','edate','hits','reveals'];
    public static function get_event_type(){
        return ['聚落活動','展覽','研討會','工作坊','演講','計畫補助'];
    }
    public static function get_expert_first(){
        return ['expert'=>'學界專家','p_expert'=>'產業專家'];
    }
    public static function get_expert_type(){
        return ['expert'=>'學界專家','p_expert'=>'產業專家','doctor'=>'醫療人員','service'=>'服務業者','invest'=>'創投業者'];
    }
    public static function get_news_type(){
        return ['智慧物聯','健康照護','','齒科產業','體外診斷','臨床需求','醫療法規','專利技術','市場營運'];
    }
    public static function get_posts_type(){
        return ['討論','問題'];
    }
    public static function get_members_type(){
        return ['doctor'=>'醫療人員','company'=>'醫材廠商','p_expert'=>'產業專家','expert'=>'學界專家','service'=>'服務業者','invest'=>'創投業者','common'=>'一般'];
    }
    public static function get_companyinfo(){
        return ["廠商專家","核心技術","上市產品","醫療專利","法規認證","相關連結"];
    }
    public static function get_company_type(){
        return ["骨科","牙科","醫學美容","智慧醫療","體外診斷","其他","中草藥","小分子藥物","生技藥品","食品生技"];
    }
    public static function get_prods_type(){
        return ["智慧醫療","牙科","醫學美容","體外診斷","中草藥","小分子藥物","生技藥品","食品生技","骨科","其他"];
    }
    public static function get_company_big_type(){
        return ["醫療器材","製藥產業","新興生技"];
    }
    public static function get_company_second_type($type){
        switch ($type) {
            case '醫療器材':
                return ["骨科","牙科","醫學美容","智慧醫療","體外診斷","其他"];
                break;
            case '製藥產業':
                return ["中草藥","小分子藥物"];
                break;
            case '新興生技':
                return ["生技藥品","食品生技",];
                break;
        }
    }
    public static function get_medical_type(){
        return ["診斷監測","手術治療","輔助彌補","體外診斷","其他"];
    }
    public static function get_problem_type(){
        return ["採訪類型","贈品提供","廣告業務","異業合作","經銷授權","編輯相關","代編需求","其他問題"];
    }
    public static function get_file_class(){
        return ["計畫各階段文件下載","檢測驗證及法規諮詢服務","各項活動相關附件","廠商進駐申請","相關法規"];
    }
    public static function get_link_type(){
        return ["國內","國外","資源"];
    }
    public static function get_pic($id){
        $cm = Self::where('id', $id)->first();
        if($cm && isset($cm->type) && $cm->type == 'link'){
            return $cm->link;
        }elseif($cm && isset($cm->pic) && $cm->pic){ //在pic中有資料
            if($cm->type == 'file'){
                return asset('/download/'.$cm->id); //若是  file 回傳下載的位址
            }else{
                if(is_file(public_path().$cm->pic)) return asset($cm->pic)."?r=".rand(0,1000); //若是 image 回傳直接網址
            }
        }elseif($cm && $cm->type == 'file'){
            return NULL;
        }
        return '/images/no_image.gif'; 
    }
    public static function get_spic($id){
        $cm = Self::where('id', $id)->first();
        if(is_file(public_path().$cm->spic)) return asset($cm->spic);
        return '/images/no_image.gif'; 
    } 
    //20170818新增
    public static function get_news_pic($id){
        $cm = Self::where('id', $id)->first();
        if($cm->pic) return asset($cm->pic);
        return '/images/no_image.gif'; 
    }    
    //
    private static function get_picname($id, $ext, $appendex=""){
        if($appendex) return $id.$appendex.".".$ext;
        return $id.".".$ext;
    }

    public static function edit($request){
        $new = false ; 
        $tags = null;
        $data = $request->only(['name','brief','mstatus','online_status','lang','position','type','cont','obj','objsn','sdate','jdate','link','link_type','tags','psort','specs','up_sn','addr','comptel','email','edate']);
        $id = $request->input('id');

        // $validator = Validator::make($data, [
        //     'name'=>'required',
        //     'lang'=>'required'
        // ],[
        //     'required'=>'必填欄位，請勿空白'
        // ]);
        // if ($validator->fails()) {
        //     return ['status'=>'err', 'errors'=> $validator->errors()->toArray()];
        // }

        if($data['position']=='roles'){
            foreach (request('funcs') as $key => $value) {
                if($value=='Y') $data['brief'] .= $key.',' ;
            }
        }
        //活動相關資料整理
        if($data['position']=='event'){
            $data['online_status'] = 'N' ; 
            // $data['mstatus'] = 'Y' ;
            $data['event_sdate'] = request('event_sdate')?request('event_sdate'):request('event_edate');
            $data['event_edate'] = substr((request('event_edate')?request('event_edate'):request('event_sdate')),0,10).date(' 23:59:59');
            $data['signup_sdate'] = request('signup_sdate')?request('signup_sdate'):request('signup_edate') ;
            $data['signup_edate'] = substr((request('signup_edate')?request('signup_edate'):request('signup_sdate')),0,10).date(' 23:59:59');
            $brief = ['event_cont'=>request('event_cont'),
                      'event_fee'=>request('event_fee'),
                      'event_organizer'=>request('event_organizer'),
                      'event_co_organizer'=>request('event_co_organizer'),
                      'event_vip'=>request('event_vip'),
                      'event_fee'=>request('event_fee'),
                      'event_contact'=>request('event_contact'),
                      'event_contact_tel'=>request('event_contact_tel'),
                      'event_sponsors'=>request('event_sponsors')]; 
            $data['brief'] = json_encode($brief,JSON_UNESCAPED_UNICODE) ;
            if(request('event_step')){
                $tmp = [] ;
                for($i=0;$i<sizeof(request('event_step')['time']);++$i){
                    if(request('event_step')['time'][$i]==''&&request('event_step')['agenda'][$i]==''&&request('event_step')['vip'][$i]=='') continue ;
                    else{
                        $tmp[] = ['time'=>request('event_step')['time'][$i],
                                  'agenda'=>request('event_step')['agenda'][$i],
                                  'vip'=>request('event_step')['vip'][$i],] ;
                    }
                }
                $data['cont'] = json_encode($tmp,JSON_UNESCAPED_UNICODE) ;
            }
        }
       
        if(!isset($data['objsn']) || !$data['objsn']) $data['objsn'] = 0;
        

        if(is_array($data['tags'])){
            $tags = $data['tags'];
            if(request('type')=='上市產品'){
                $data['specs'] = implode(',', $tags);
            }else{
                $data['tags'] = implode(',', $tags);
            }
        }
        
        if(!isset($data['psort']) || !$data['psort']) $data['psort'] = 0;
        
        if(is_array($data['specs'])){
            $data['specs'] = json_encode($data['specs'],JSON_UNESCAPED_UNICODE);
        }
        
        if(!isset($data['up_sn']) || !$data['up_sn']) $data['up_sn'] = 0;
        
        //新聞來源所有新聞上下線處理、分類
        if($data['position']=='nsource'&&$id){
            $news = Self::where('position','news')->where('up_sn',$id)->update(['mstatus'=>$data['mstatus'],'type'=>request('type')]) ;
        }
        
        //領域專家新增/編輯資料
        if($data['position']=='expert'){
            $data['cont'] = Members::do_edit_expert($id,'docm');
        }
        
        //新知要聞分類
        if($data['position']=='news'){
            $data['type'] = implode(',', request('type'));
        }
        
        //討論問題專用的處理
        if($data['position'] == 'posts' || $data['position'] == 'comments' || $data['position'] == 'reply' ){
            if(request('name')=='') return ['status'=>'err', 'msg'=>'請輸入標題'];
            $board = [] ; 
            $objsn = [] ; 
            $i = 0 ; 
            //從 obj 取回 objsn
            if($data['position'] == 'posts'){//發問題
                // $board = Self::where('position','board')->where('name', $data['obj'])->first();
                // $data['objsn'] = $board->id; 
                foreach($data['obj'] as $obj){ //處理問題分類
                    $pdata = Self::where('position','board')->where('name', $obj)->first();
                    $board[$i]['name'] = $pdata->name ; 
                    $board[$i]['specs'] = $pdata->specs ; 
                    $board[$i]['up_sn'] = $pdata->up_sn ; 
                    $objsn[$i] = $pdata->id ;
                    $i++;
                }
                $data['obj'] = implode(',',$data['obj']);
                $data['objsn'] = implode(',', $objsn) ; 
            }else{//留言/回覆
                $original_post = Self::where('id', $data['objsn'])->first();
                if($original_post){
                    $board = Self::where('position','board')->where('name', $original_post->obj)->first();
                }
            }
            if(!$board) return ['status'=>'err', 'msg'=>'文章的版資料不正確'];
            
            //通知的對象
            if(request('url') != 'backend'){//不是後台新增才寄信
                foreach ($board as $bdata) {
                    $emails = $bdata['specs'] ? explode(';', $bdata['specs']):[];
                    $master = Members::where('id', $bdata['up_sn'])->first();
                    if($master){
                        $poster = '未登入使用者';
                        if(session('minfo')){
                            $poster = session('minfo')['sname'] ? session('minfo')['sname'] : session('minfo')['name'];
                        }
                        $action = '';
                        if($data['position'] == 'posts'){
                            $action = '發表了一篇問題/討論，文章標題：「'.$data['name'].'」';
                        }elseif($data['position'] == 'comments'){
                            $action = '回覆了一篇問題/討論';
                        }else{
                            $action = '回覆了一則留言/答案';
                        }
                        $msg = '您好，'.$poster.'於'.date('Y-m-d H:i').'在您管理的版面「'.$bdata['name'].'」'.$action;
                        \App\Msg::write_msg($master->id, $msg);
                        foreach($emails as $mailto){
                            if(!$mailto) continue;
                            Mail::to($mailto)->send(new BoardMaster($msg));
                        }
                    }
                }
            }
        }
        
        //育成專區影音管理
        if(request('position')=='video'){
            $data['type'] = request('ctype').(request('vtype')[request('ctype')]?'-'.request('vtype')[request('ctype')]:'') ;
        }

        //預約展示室
        if(request('position')=='booking'){
            $booking = Self::where('position','booking')->where('obj',request('obj'))->whereDate('edate',request('edate'))->first();
            if(!$id && $booking) return ['status'=>'err','msg'=>'此時段已被預約！'];
            elseif($id){
                $booking_self = Self::where('id',$id)->first();
                if(substr($booking_self->edate,0,10)!=request('edate') || $booking_self->obj!=request('obj')){
                    if($booking) return ['status'=>'err','msg'=>'此時段已被預約！'];
                }
            }
            $cont = ["title"=>request("title"),"purpose"=>request("purpose"),"group"=>request("group"),"num_people"=>request("num_people")];
            $data['cont'] = json_encode($cont,JSON_UNESCAPED_UNICODE) ;
        }

        //後台廠商上傳上市產品處理
        if(request('type')=='上市產品'){
            $data['tags'] = request('prods') ? implode(',',request('prods')) : null ; 
        }
        
        if($id){//編輯
            if($data['position']=='company'){
                $ret = Members::do_edit_company($id,'docm');
                if($ret['status']!='ok') return $ret ; 
            }else{
                Self::where('id', $id)->update($data);
            }
            $cm = Self::where('id', $id)->first();
        }else{//新增
            $cm = Self::create($data);
            $id = $cm->id;
            if($data['position']=='company'){
                $ret = Members::do_edit_company($id,'docm');
                if($ret['status']!='ok') return $ret ; 
            }
            $new = true ; 
        }

        //後台廠商新增帳號密碼
        if($data['position']=='company'&&request('site')=='backend'){//建立帳號/密碼
            $rt = Self::backend_edit_company($id,$data) ; 
            if($rt["status"]!='ok') return $rt ; 
        }
        //後台領域專家新增帳號密碼
        if($data['position']=='expert'&&request('site')=='backend'){//建立帳號/密碼
            $rt = Self::backend_edit_expert($id,$data) ; 
            if($rt['status']!='ok') return $rt ; 
        }
        if($data['position']!='company'){
            //處理上傳檔案部分
            if($request->hasFile('picfile')){
                $pic = Self::upload_pic($id, 'picfile');
                if($pic['status']!='ok'){
                    if($new) Self::where('id',$id)->delete();
                    return $pic;
                } 
                $cm->pic = $pic['path'];
                Self::where('id', $id)->update(['pic'=>$pic['path']]);
            }
            if($request->hasFile('spicfile')){
                $pic = Self::upload_pic($id, 'spicfile', 's');
                if($pic['status']!='ok'){
                    if($new) Self::where('id',$id)->delete();
                    return $pic;
                } 
                $cm->spic = $pic['path'];
                Self::where('id', $id)->update(['spic'=>$pic['path']]);
            }
        }
        //其他多張或文件
        if(request()->hasFile('other_files')){
            $tt = OtherFiles::upload_other_files($id,request()->file('other_files'));
            if($tt['status']=='err') return $tt ; 
        }
        //文件下載處理pdf/doc/ppt
        $msg = '' ;
        if(request()->hasFile('file-pdf')){
            $ftype_pdf = request()->file('file-pdf')->getClientOriginalExtension();
            if($ftype_pdf!='pdf') $msg .= 'PDF檔案上傳格式錯誤<br>' ; 
        }
        if(request()->hasFile('file-doc')){
            $ftype_doc = request()->file('file-doc')->getClientOriginalExtension();
            if($ftype_doc!='doc'&&$ftype_doc!='docx') $msg .= 'DOC/DOCX檔案上傳格式錯誤<br>';
        }
        if(request()->hasFile('file-ppt')){
            $ftype_ppt = request()->file('file-ppt')->getClientOriginalExtension();
            if($ftype_ppt!='ppt'&&$ftype_ppt!='pptx') $msg .= 'PPT/PPTX檔案上傳格式錯誤<br>';
        }
        if($msg!='') return ['status'=>'err','msg'=>$msg] ; 
        else{
            if(request()->hasFile('file-pdf')){
                $tt = OtherFiles::upload_files($id,$ftype_pdf,request()->file('file-pdf'));
                if($tt['status']=='err') return $tt ;
            }
            if(request()->hasFile('file-doc')){
                $tt = OtherFiles::upload_files($id,$ftype_doc,request()->file('file-doc'));
                if($tt['status']=='err') return $tt ; 
            }
            if(request()->hasFile('file-ppt')){
                $tt = OtherFiles::upload_files($id,$ftype_ppt,request()->file('file-ppt'));
                if($tt['status']=='err') return $tt ; 
            }
        }



        //媒體庫
        if($data['position'] != 'media') {
            Self::where('position', 'media')->where('objsn', 0)->where('obj', request('_token'))->update(['obj'=>$data['position'], 'objsn'=>$id]);
        }
        
        //處理tags關聯的部份
        if(request('old_tags') != $data['tags']){
            Self::where('position', 'relations')->where('obj','tag')->where('up_sn',$id)->delete();
            if(is_array($tags)){
                foreach($tags as $tag){
                    //取出這個關鍵字的id
                    $tagid = Self::where('position', 'tag')->where('name', $tag)->value('id');
                    if(!$tagid){
                        $addtag = ['position'=>'tag', 'name'=>$tag, 'type'=>'text', 'brief'=>'#333'];
                        $newtag = Self::create($addtag);
                        $tagid = $newtag->id;
                    }
                    $add = ['position'=>'relations','type'=>$data['position'],'obj'=>'tag', 'objsn'=>$tagid, 'up_sn'=>$id, 'name'=>$tag];
                    Self::create($add);
                }
            }
        }
        
        /*
         * 新上傳的相關檔案會在input fields中新增一個attahced[] 的隱藏輸入欄位，以陣列的型式將相關檔案的id上傳
         * 這裡的目的就是把這些id的資料的objsn改成現在這個cm物件的id
         */
        if($request->input('attached') && is_array($request->input('attached'))){
            $ids = [];
            foreach($request->input('attached') as $attached_id){
                if(is_numeric($attached_id)) $ids[] = $attached_id;
            }
            if(count($ids)>0){
                Self::whereIn('id', $ids)->update(['objsn'=>$id]);
            }
        }
        return ['status'=>'ok', 'id'=>$id, 'data'=>$cm];
    }

    public static function chk_passwd($passwd,$chk_passwd){
        if(!$chk_passwd) return ["status"=>"err","msg"=>"請輸入確認密碼"] ;
        if($passwd!=$chk_passwd) return ["status"=>"err","msg"=>"密碼比對不相符"];
        return ["status"=>"ok"] ;
    }


    public static function upload_pic($id, $f, $appendex=""){
        try{
            $subname = request()->file($f)->extension();
        }catch(Exception $e){

        }
        
        $type = request()->input('type');
        $types = ['jpg', 'jpeg', 'png', 'gif'];
        if($type == 'file'){
            $types = ['pdf', 'jpg', 'jpeg', 'png', 'gif' ]; 
        }
        $fsize = request()->file($f)->getClientSize(); 
        if($fsize>=8*1024*1024){
            $ret = ['status'=>'err','msg'=>'檔案/圖片 大小不可超過8MB'] ;
            return $ret; 
        } 
        if(!in_array($subname, $types )){
            // session()->flash('errmsg', '檔案格式'.$subname.'不允許上傳。');
            // return false;
            return ['status'=>'err','msg'=>'檔案格式'.$subname.'不允許上傳。'] ; 
            
        }
        $fname = Self::get_picname($id, $subname, $appendex);
        $save_pic = request()->file($f)->move(public_path().'/upload/cm', $fname);
        $path = "/upload/cm/".$fname;
        return ['status'=>'ok','path'=>$path];
    }
    
    public static function del_pic($id){
        $cm = Self::where('id', $id)->first();
        if($cm){
            Self::where('id', $id)->update(['pic'=>NULL, 'spic'=>NULL]);
            if($cm->pic) File::delete(public_path().$cm->pic);
            if($cm->spic) File::delete(public_path().$cm->spic);
            return true;
        }
        return false;
    }
    public static function new_obj($position=''){
        $spec = '';
        if($position=='funto') $spec = json_encode((object)['age'=>'','place'=>'', 'date'=>'', 'class'=>'', 'tool'=>'', 'price'=>''],JSON_UNESCAPED_UNICODE);
        if($position=='shop') $spec = json_encode((object)['tel'=>'','address'=>'', 'fax'=>'', 'email'=>'', 'business_hours'=>'', 'services'=>''],JSON_UNESCAPED_UNICODE);
        return (object)['id'=>'', 'lang'=>session('lang'), 'position'=>$position, 'name'=>'', 'brief'=>'', 'cont'=>'', 'mstatus'=>'', 'psort'=>'', 'type'=>'', 'obj'=>'', 'objsn'=>'', 'sdate'=>'', 'link'=>'', 'link_type'=>'', 'tags'=>'', 'up_sn'=>0, 'pic'=>'', 'spic'=>'', 'specs'=>$spec, 'jdate'=>'','online_status'=>'','addr'=>'','email'=>'','comptel'=>'','signup_sdate'=>'','signup_edate'=>'','event_sdate'=>'','event_edate'=>'','compfax'=>'','edate'=>'','tel'=>''];
    }
    //新聞同步
    public static function sync(){
        $nsource = Self::where('id', request('id'))->first();
        $news_from = Self::where('id',$nsource->up_sn)->first();
        $t = 0;

        if($nsource->link_type == 'RSS'){
            $feed = Feeds::make($nsource->link);
            $news = $feed->get_items();
            foreach($news as $n){
                $link = trim($n->get_link()) ; 
                $exists = Self::where('link', $link )->first();
                if(!$exists){
                    //若資料庫沒有就新增
                    $a = ['position'=>'news', 'up_sn'=>request('id'), 'lang'=>'CH', 'online_status'=>'N' ,'mstatus'=>'N'];
                    $a['name'] = mb_substr($n->get_title(),0,500);
                    $a['brief'] = mb_substr(strip_tags($n->get_description()),0, 100);
                    $a['cont'] = $n->get_description();
                    $main_type = Self::get_news_main_type($a['cont']) ; 
                    $a['type'] = $main_type==''?$nsource->type:$main_type; //新聞分類
                    $a['mstatus'] = $nsource->mstatus ; //是否上線
                    $a['link'] = $link;
                    if($link) $a['pic'] = Self::get_link_pic($link);
                    // $a['cont'] = Self::get_rss_content($news_from->name,$a['link']);             
                    Self::create($a);
                    $t++;
                }else{
                    $a = [] ; 
                    if($link){
                        $a['pic'] = Self::get_link_pic($link);
                        Self::where('id',$exists->id)->update($a);
                    } 
                }
            }
            //利用enclosure更新圖片
            try {
                $context = [
                "ssl"=>[
                        "verify_peer"=>false,
                        "verify_peer_name"=>false,
                    ]
                ];
                libxml_set_streams_context(stream_context_create($context));
                $feed = simplexml_load_file($nsource->link);
                foreach ($feed->channel->item as $item) {
                    $ndata = ['position'=>'news', 'up_sn'=>request('id'), 'lang'=>'CH', 'online_status'=>'N' ,'mstatus'=>'N'];
                    $ndata['name'] = $item->title;
                    $ndata['brief'] = mb_substr(strip_tags($item->description),0, 100);
                    $ndata['cont'] = $item->description ; 
                    $main_type = Self::get_news_main_type($ndata['cont']) ; 
                    $ndata['type'] = $main_type==''?$nsource->type:$main_type; //新聞分類
                    $ndata['mstatus'] = $nsource->mstatus ; //是否上線
                    $ndata['link'] = $item->link;
                    if (isset($item->enclosure)) {
                        $ndata['pic'] = $item->enclosure['url'] ; 
                        // Cm::where('position','news')->where('up_sn',request('id'))->where('link',trim($item->link))->update(['pic'=>$item->enclosure['url']]) ; 
                    }
                    $exists = Self::where('link', $ndata['link'] )->first();
                    if(!$exists){
                        Self::create($ndata);
                    }else{
                        Cm::where('position','news')->where('up_sn',request('id'))->where('link',trim($item->link))->update($ndata) ;
                    }
                }
            } catch (\Exception $e) {
                
            }

            \App\Http\Controllers\BackendController::do_fix('news',request('id')) ; 
            
        }

        return "<script>location.href='/backend/nsource/nsource_edit/news?id=".request('id')."'</script>";//['status'=>'OK','msg'=>'同步完成'];
    }
    //20170815新增
    public static function get_link_pic($url){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $data = curl_exec($ch);
        curl_close($ch);

        //parsing begins here:
        $doc = new \DOMDocument();
        @$doc->loadHTML($data);
        $nodes = $doc->getElementsByTagName('title');

        //get and display what you need:
        // $title = $nodes->item(0)->nodeValue;

        $metas = $doc->getElementsByTagName('meta');
        $img_link = '' ; 
        for ($i = 0; $i < $metas->length; $i++){
            $meta = $metas->item($i);
            if($meta->getAttribute('property') == 'og:image')
                $img_link = $meta->getAttribute('content') ? $meta->getAttribute('content') : '' ;
        }
        return $img_link ;
    }
    public static function get_rss_content($source,$url){
        switch ($source) {
            case '元氣網':
                // $url = "https://health.udn.com/health/story/7282/369948";
                $html = HtmlDomParser::file_get_html( $url ); 
                $html = $html->find('#story_body_content',0);  //Output: THESE
                $share =  $html->find('#shareBar',0);
                $share = $share->setAttribute('style','display: none !important;');

                $time = $html->find('.shareBar__info--author',0)->plaintext;
                
                foreach($html->find('a') as $element) {
                    if (isset($element->href)) {
                        $element->href = null;
                    }
                }
                foreach($html->find('dt') as $element) {
                    if (isset($element)) {
                        $element->innertext = '';
                    }
                }
                $html->find('.area',0)->prev_sibling()->innertext = ''; 
                $html = $time.$html;
                break;
        }
        return $html ; 
    }
    //依關鍵字分類
    public static function get_news_main_type($str){
        $main_type = [] ; 
        $keywords = [] ; 
        $main = Cm::where('position','keywords')->groupBy('type')->pluck('type');
        foreach ($main as $type) {
            $value = Cm::where('position','keywords')->where('type',$type)->pluck('name');
            foreach ($value as $name) {
                $keywords[$type][]= $name ;  
            }
        }
        foreach ($keywords as $key => $value) {
            $c = 0 ; 
            foreach ($value as $word) {
                $c += substr_count( $str , $word ) ;
            }
            if($c > 0){
                $main_type[] = $key ; 
            }
        }
        $res = implode(',',$main_type) ; 
        return $res ; 
    }
    //
    public static function get_related($id, $type){
        $ret = [];
        $obj = Self::where('id', $id)->first();
        if($obj && $obj->tags){
            $rs = DB::select( DB::raw(" SELECT up_sn, COUNT(up_sn) AS tag_count FROM `cms` WHERE `position` = 'relations' AND `type` = '".$type."' and `objsn` IN ( SELECT `objsn` FROM `cms` WHERE `position` = 'relations' AND `up_sn` = '".$id."' ) GROUP BY `up_sn` ORDER BY tag_count DESC LIMIT 1 ") );
            if($rs){
                foreach($rs as $rd){
                    $ret[] = $rd->up_sn;
                } 
            }
            
        }
        return $ret;
    }
    public static function upload_info_pic($id,$f,$t=""){
        $subname = $f->extension();
        $types = ['pdf', 'jpg', 'jpeg', 'png', 'gif' ]; 
        if(!in_array($subname, $types )){
            session()->flash('errmsg', '檔案格式'.$subname.'不允許上傳。');
            return false;
        }
        if($t!='') $fname = time().".".$subname;
        else $fname = $id.".".$subname;

        $save_pic = $f->move(public_path().'/upload/cm', $fname);
        $path = "/upload/cm/".$fname;
        return $path;
    }
    public static function get_sourcename($id){
        $source_id = Self::where('id', $id)->value('up_sn');
        $site_id = Self::where('id', $source_id)->value('up_sn');
        $site_name = Self::where('id', $site_id)->value('name');
        return $site_name;
    }
    //討論區留言寫入
    public static function do_message(){
        $add = ['position'=>'comments','type'=>'text','objsn'=>session('mid'), 'up_sn'=>request()->input('up_sn') ,'cont'=>request()->cont,'lang'=>session('lang')];
        if(request('cont')=='') return ['status'=>'err','msg'=>'留言內容不可以空白'];
        $ret = Self::create($add);
        Self::where('id',request('up_sn'))->increment('reveals');
        return ['status'=>'ok', 'id'=>$ret->id, 'data'=>$add];
    }
    //討論區留言回覆寫入
    public static function do_reply(){
        $add = ['position'=>'reply','type'=>'text','objsn'=>session('mid'), 'up_sn'=>request('id') ,'cont'=>request('cont'),'lang'=>session('lang')];
        $ret = Self::create($add);
        $postid = Self::where('id',request('id'))->value('up_sn') ; 
        Self::where('id',$postid)->increment('reveals');
        return ['status'=>'ok', 'id'=>$ret->id, 'data'=>$add];
    }
    //討論區留言、回覆編輯
    public static function edit_msg(){
        $msg = \App\Cm::where('id',request('id'))->first() ; 
        if($msg){
            \App\Cm::where('id',request('id'))->update(['cont'=>request('cont')]) ;
            if($msg->position=='comments'){
                Self::where('id',$msg->up_sn)->increment('reveals');
            }elseif($msg->position=='reply'){
                $postid = Self::where('id',$msg->up_sn)->value('up_sn') ; 
                Self::where('id',$postid)->increment('reveals');
            }
            return ['status'=>'ok'] ;
        }
    }
    public static function get_resume_cols(){
        return ['name','ename', 'gender','birth','tel','address','email','facebook_id','google_id','line_id','occupy_status', 'self_intro'];
    }
    public static function new_resume_obj(){
        $mrd = Members::where('id', session('mid'))->first();
        $obj = [];
        $cols = Self::get_resume_cols();
        foreach($cols as $col){
            $obj[$col] = isset($mrd->{$col}) ? $mrd->{$col} : '';
        }
        $obj['pic'] = '/img/member_default.png';
        $obj['schools'] = [];
        $obj['languages'] = [];
        $obj['certs'] = [];
        $obj['jobs']=[];
        return (object)$obj;
    }
    public static function do_edit_resume(){
        $resume = Self::where('position', 'resume')->where('up_sn', session('mid'))->first();
        $cols = Self::get_resume_cols();
        $rdata = request()->only($cols);
        if($resume && $resume->cont){
            $old_data = json_decode($resume->cont);
            $rdata['schools'] = $old_data->schools;
            $rdata['languages'] = $old_data->languages;
            $rdata['certs'] = $old_data->certs;
            $rdata['jobs'] = $old_data->jobs;
        }
        if(request('school_name') && is_array(request('school_name'))){
            $n = 0;
            foreach(request('school_name') as $schoolname){
                if(!$schoolname){
                    $n++;
                    continue;
                }
                $department = request('school_department') && isset(request('school_department')[$n]) ? request('school_department')[$n] : '';
                $rdata['schools'][] = ['name'=>$schoolname, 'department'=>$department];
                $n++;
            }
        }
        if(request('job_name') && is_array(request('job_name'))){
            $n = 0;
            foreach(request('job_name') as $jobname){
                if(!$jobname){
                    $n++;
                    continue;
                }
                $ins = ['name'=>$jobname];
                $ins['position']= request('job_position') && isset(request('job_position')[$n]) ? request('job_position')[$n] : '';
                $ins['work']= request('job_work') && isset(request('job_work')[$n]) ? request('job_work')[$n] : '';
                $ins['start']= request('job_start') && isset(request('job_start')[$n]) ? request('job_start')[$n] : '';
                $ins['end']= request('job_end') && isset(request('job_end')[$n]) ? request('job_end')[$n] : '';
                $rdata['jobs'][] =$ins;
                $n++;
            }
        }
        if(request('language') && is_array(request('language'))){
            $n = 0;
            foreach(request('language') as $language){
                if(!$language){
                    $n++;
                    continue;
                }
                $rdata['languages'][] =$language;
                $n++;
            }
        }
        if(request('cert') && is_array(request('cert'))){
            $n = 0;
            foreach(request('cert') as $cert){
                if(!$cert){
                    $n++;
                    continue;
                }
                $rdata['certs'][] =$cert;
                $n++;
            }
        }
        $upd = ['position'=>'resume','up_sn'=>session('mid'), 'name'=>request('name'), 'lang'=>session('lang'), 'cont'=>json_encode($rdata,JSON_UNESCAPED_UNICODE)];
        
        if($resume){
            Self::where('id', $resume->id)->update($upd);
        }else{
            $resume = Self::create($upd);
        }
        $id = $resume->id;
        if(request()->hasFile('picfile')){
            $pic = Self::upload_pic($id, 'picfile');
            if(!$pic) return ['status'=>'err', 'msg'=>session('errmsg')];
            Self::where('id', $id)->update(['pic'=>$pic]);
        }
        return ['status'=>'ok'];
    }
    public static function remove_resume_item($obj, $n){
        $resume = Self::where('position', 'resume')->where('up_sn', session('mid'))->first();
        $rdata = json_decode($resume->cont);
        if(isset($rdata->{$obj}) && is_array($rdata->{$obj})){

            $items = [];
            $x = 1;
            foreach($rdata->{$obj} as $o){
                if($x != $n) $items[] = $o;
                $x++;
            }
            $rdata->{$obj} = $items;
            Self::where('id', $resume->id)->update(['cont'=>json_encode($rdata,JSON_UNESCAPED_UNICODE)]);
        }
        return ['status'=>'ok'];
    }
    //廠商徵才資料寫入
    public static function do_edit_compresume(){
        $errors = [] ;
        $rdata = [] ;
        $data = request()->all() ;
        $validator = Validator::make($data, [
            'job_type'=>'required',
            'job_title'=>'required',
            'job_intro'=>'required',
            'job_location'=>'required',
            'job_exp'=>'required',
            'job_arrivedate'=>'required',
            'job_salary'=>'required',
            'job_necessary'=>'required',
            'job_benefit'=>'required',
            'job_keyword'=>'required',
            'job_contact'=>'required',
            'job_phone'=>'required',
            'job_email'=>'required',
            'job_url'=>'required'
        ],[
            'required'=>'必填欄位',
        ]);
        if ($validator->fails()) {
            return ["status"=>"err", "errors"=>$validator->errors()->toArray()];
        }

        $comp = Self::where('position','company')->where('up_sn',session('mid'))->first();
        $rdata['name'] = $data['job_title'] ;
        $rdata['up_sn'] = session('mid') ? $comp->id : $data['up_sn'] ;
        $rdata['position'] = 'comp_resume' ;
        $rdata['type'] = 'text' ;
        $rdata['lang'] = session('lang') ;
        $rdata['cont'] = json_encode($data,JSON_UNESCAPED_UNICODE) ;
        $rdata['mstatus'] = request('mstatus')?request('mstatus'):'Y' ; 
        // $rdata['psort'] = $data['psort'] ; 
        if(request('id')){
            Self::where('id',request('id'))->update($rdata);
        }else{
            Self::create($rdata) ; 
        } 
        return ['status'=>'ok','msg'=>'資料新增/修改完畢','id'=>request('id')];
    }
    public static function new_compresume_obj(){
        return (object)['job_type'=>'', 'job_title'=>'', 'job_intro'=>'', 'job_location'=>'', 'job_exp'=>'', 'job_arrivedate'=>'', 'job_benefit'=>'', 'job_keyword'=>'', 'job_contact'=>'', 'job_phone'=>'', 'job_email'=>'', 'job_url'=>'','job_date'=>'','job_necessary'=>'','job_salary'=>''];
    }
    //更改新聞狀態
    public static function chg_news_status(){
        $ids = explode(',',request('id')) ; 
        foreach ($ids as $id) {
            if($id!=''){
                \App\Cm::where('id',$id)->update(['mstatus'=>request('mstatus')]);
            }
        }
        return ['status'=>'ok'];
    }
    //更改新聞分類
    public static function chg_newstype(){
        $newstype = '' ;
        $news = Self::where('id',request('id'))->first();
        if(request('check')=='Y'){
            $newstype = $news->type ? $news->type .','.request('type'):request('type');
        }else{
            $types = explode(',',$news->type) ;
            foreach ($types as $k => $v) {
                if($v&&$v!=request('type')){
                    if($k!=sizeof($types)-1) $newstype .= $v.',' ; 
                    else $newstype .= $v ;
                }
            }
        }   
        Self::where('id',request('id'))->update(['type'=>$newstype]);
        return ['status'=>'ok','data'=>$newstype];
    }
    //置頂功能
    public static function chg_psort(){
        $post = Self::where('id',request('id'))->first();
        if($post->psort!=999) Self::where('id',request('id'))->update(['psort'=>999]) ;
        else Self::where('id',request('id'))->update(['psort'=>0]) ;
        return ['status'=>'ok'];
    }
    //我要應徵工作
    public static function get_job(){
        if(session('mid')){
            $id = request('id') ; 
            $job = Self::where('id',$id)->first();
            //判斷此工作是否已投遞過
            if($job->tags){
                $m = explode(',',$job->tags) ;
                if(in_array(session('mid'), $m)) return ['status'=>'err','msg'=>'您已應徵過此工作'];
            }
            if(session('minfo')['type']=='醫材廠商') return ['status'=>'err','msg'=>'您無應徵權限'];
            $resume = Self::where('position','resume')->where('up_sn',session('mid'))->first();
            $comp = Self::where('position','company')->where('id',$job->up_sn)->first() ;
            if($resume){
                Self::where('id',$id)->increment('reveals');//應徵人數加1
                $tags = $job->tags!='' ? $job->tags.','.session('mid').'+'.date('Y-m-d') : session('mid').'+'.date('Y-m-d') ; 
                Self::where('id',$id)->update(['tags'=>$tags]);
                //當日應徵人數統計
                $hits = \App\Statistics::where('compid',$comp->id)->where('position','get_job')->whereDate('updated_at',date('Y-m-d'))->first();
                if($hits){//表示今日已經點擊過
                    Statistics::where('id',$hits->id)->increment('hits');
                }else{
                    Statistics::create(['compid'=>$comp->id,'position'=>'get_job','hits'=>1]);
                }
                return ['status'=>'ok','msg'=>'親愛的會員 '.session('minfo')['name'] .' 您好，'. $comp->name.' 已收到您的應徵資料'];
            }else{
                return ['status'=>'err','msg'=>'您尚未建立履歷，請先建立履歷'];
            } 
        }else{
            return ['status'=>'err','msg'=>'此功能只提供會員使用'];
        }
    }

    //後台廠商新增帳號密碼
    public static function backend_edit_company($id,$data){
        $comp_data = request()->only(['loginid','passwd','passwd_chk']);
        $errors = [];
        $req = ['loginid'=>'required|unique:members'] ; 
        if(request('loginid')&&$data['up_sn']==0){//代表要建立廠商帳號密碼(包含新增廠商並一同創建帳號密碼)
            $req['passwd'] = 'required|max:50' ;
            $validator = Validator::make($comp_data, $req,[
                'required'=>'必填欄位',
                'unique'=>'這個資料已有人使用',
            ]);
            if ($validator->fails()) {
                return ["status"=>"err", "errors"=>$validator->errors()->toArray()];
            }
            $chk = Self::chk_passwd(request('passwd'),request('passwd_chk')) ;
            if($chk['status']=='err') return $chk ;
            $comp_data['type'] = '醫材廠商' ; 
            $comp_data['name'] = request('compname');
            $comp_data['email'] = request('email');
            $comp_data['passwd'] = md5($comp_data['passwd']);
            $comp_data['lastlogin_time'] = date("Y-m-d H:i:s");
            $comp_data['lastlogin_addr'] = request()->ip();
            $comp_data['mstatus'] = 'Y';
            $comp = Members::create($comp_data) ;
            Self::where('id',$id)->update(['up_sn'=>$comp->id]) ; 
        }elseif(request('loginid')!=request('oldid')&&$data['up_sn']!=0){//代表廠商已有帳號密碼要編輯修改
            $validator = Validator::make($comp_data, $req,[
                'required'=>'必填欄位',
                'unique'=>'這個資料已有人使用',
            ]);
            if ($validator->fails()) {
                return ["status"=>"err", "errors"=>$validator->errors()->toArray()];
            }
            if(request('passwd')){//帳號密碼都修改
                $chk = Self::chk_passwd(request('passwd'),request('passwd_chk')) ;
                if($chk['status']=='err') return $chk ; 
                Members::where('id',$data['up_sn'])->update(['name'=>request('compname'),'email'=>request('compemail'),'loginid'=>$comp_data['loginid'],'passwd'=>md5($comp_data['passwd'])]) ;
            }else{//只修改帳號
                Members::where('id',$data['up_sn'])->update(['name'=>request('compname'),'email'=>request('compemail'),'loginid'=>$comp_data['loginid']]) ;
            }            
        }elseif(request('passwd')&&request('loginid')==request('oldid')&&$data['up_sn']!=0){//只修改密碼
            $chk = Self::chk_passwd(request('passwd'),request('passwd_chk')) ;
            if($chk['status']=='err') return $chk ; 
            Members::where('id',$data['up_sn'])->update(['name'=>request('compname'),'email'=>request('compemail'),'passwd'=>md5($comp_data['passwd'])]) ;
        }
        return ["status"=>"ok"];
    }
    //後台領域專家新增帳號密碼
    public static function backend_edit_expert($id,$data){
        $expert = Self::where('id',$id)->first() ; 
        $expert_data = request()->only(['loginid','passwd','passwd_chk']);
        $errors = [];
        $req = ['loginid'=>'required|unique:members'] ; 
        if(request('loginid')&&$data['up_sn']==0){//代表要建立廠商帳號密碼(包含新增廠商並一同創建帳號密碼)
            $req['passwd'] = 'required|max:50' ;
            $validator = Validator::make($expert_data, $req,[
                'required'=>'必填欄位',
                'unique'=>'這個資料已有人使用',
            ]);
            if ($validator->fails()) {
                return ["status"=>"err", "errors"=>$validator->errors()->toArray()];
            }
            $chk = Self::chk_passwd(request('passwd'),request('passwd_chk')) ;
            if($chk['status']=='err') return $chk ;
            $expert_data['type'] = request('type') ; 
            $expert_data['name'] = request('name');
            $expert_data['email'] = request('email');
            $expert_data['passwd'] = md5($expert_data['passwd']);
            $expert_data['lastlogin_time'] = date("Y-m-d H:i:s");
            $expert_data['lastlogin_addr'] = request()->ip();
            $expert_data['mstatus'] = request('mstatus');
            $expert_data['pic'] = $expert->pic ; 
            $expert = Members::create($expert_data) ;
            Self::where('id',$id)->update(['up_sn'=>$expert->id]) ; 
        }elseif(request('loginid')!=request('oldid')&&$data['up_sn']!=0){//代表廠商已有帳號密碼要編輯修改
            $validator = Validator::make($expert_data, $req,[
                'required'=>'必填欄位',
                'unique'=>'這個資料已有人使用',
            ]);
            if ($validator->fails()) {
                return ["status"=>"err", "errors"=>$validator->errors()->toArray()];
            }
            if(request('passwd')){//帳號、密碼、圖片都修改
                $chk = Self::chk_passwd(request('passwd'),request('passwd_chk')) ;
                if($chk['status']=='err') return $chk ; 
                Members::where('id',$data['up_sn'])->update(['name'=>request('name'),'email'=>request('email'),'loginid'=>$expert_data['loginid'],'passwd'=>md5($expert_data['passwd']),'pic'=>$expert->pic]) ;
            }else{//只修改帳號
                Members::where('id',$data['up_sn'])->update(['name'=>request('name'),'email'=>request('email'),'loginid'=>$expert_data['loginid'],'pic'=>$expert->pic]) ;
            }            
        }elseif(request('passwd')&&request('loginid')==request('oldid')&&$data['up_sn']!=0){//只修改密碼、圖片
            $chk = Self::chk_passwd(request('passwd'),request('passwd_chk')) ;
            if($chk['status']=='err') return $chk ; 
            Members::where('id',$data['up_sn'])->update(['name'=>request('name'),'email'=>request('email'),'passwd'=>md5($expert_data['passwd']),'pic'=>$expert->pic]) ;
        }else{
            Members::where('id',$expert->up_sn)->update(['pic'=>$expert->pic]) ; 
        }

        return ["status"=>"ok"];
    }

    //前台廠商增加上市產品
    public static function upload_prods(){
        $prods_count = count(request('name')) ; 
        $new = false ; 
        for($i=0;$i<$prods_count;++$i){
            $id = request('id') ; 
            $data = request()->only(['position','up_sn','type']);
            $data['name'] = request('name')[$i] ; 
            $data['brief'] = request('brief')[$i] ; 
            $data['link'] = request('link')[$i] ; 
            $data['specs'] = isset(request('tags')[$i])&&is_array(request('tags')[$i]) ? implode(',', request('tags')[$i]) : null ;   //tags
            $data['tags'] = isset(request('prods')[$i])&&is_array(request('prods')[$i]) ? implode(',', request('prods')[$i]) : null ; //分類

            if($id) {
                Self::where('id',$id)->update($data) ; 
            }else{
                $res = Self::create($data) ; 
                $id = $res->id ; 
                $new = true ; 
            }

            $pic = isset(request('pic')[$i]) ? request('pic')[$i] : null;
            //處理上傳圖片
            if($pic){
                $picpath = Self::upload_info_pic($id, $pic);
                Self::where('id', $id)->update(['pic'=>$picpath]);
            }

        }
        $mid = Self::where('id',request('up_sn'))->value('up_sn') ; 
        SysLogs::company_log($mid,'company_update');
        return ['status'=>'ok','msg'=>'產品更新/新增完畢'] ;
    }
    //聚落新知取得相關廠商
    public static function relation_company($type){
        $ntype = explode(',', $type) ; 
        //相關廠商
        $comp = [] ; 
        foreach ($ntype as $rd) {
            //先將屬於該分類的關鍵詞找出來
            $keywords = Self::where('position','keywords')->where('type',$rd)->get();
            //再去尋找有對應到關鍵詞的廠商
            foreach ($keywords as $words) {
                $comp_data =  Self::where('position','company')->where('tags','like','%'.$words->name.'%')->where('mstatus','Y')->inRandomOrder()->limit(3)->get();
                foreach ($comp_data as $data) {
                    if(!in_array($data->id,$comp)) $comp[] = $data->id ; 
                }
            }
        }
        return $comp ; 
    }
}
