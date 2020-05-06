<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Funcs;
use App\Admins;
use App\Cm;
use App\Products;
use App\Members;
use App\MembersCollects;
use App\OtherFiles;
use App\Prospects;
use App\Tags;
use App\Act;
use App\GbwcJoin;
use App\Applications;
use App\ContactLogs;
use App\SysLogs;
use DB;
use View;
use Mail;
use File;
use Feeds;
use App\Msg;
use App\Mail\ResetPassword;

class BackendController extends Controller
{
    public function login(){
    	return view('backend.login');
    }
    public function index(){
    	return view('backend.index');
    }
    public function page($page, $func, $arg=''){
        if(!request('id')) session(['BACKPAGE'=>request()->fullUrl()]);
    	return view('backend.'.$page.'.'.$func, compact('arg'));
    }
    public function logout(){
    	session()->forget('adminid', 'admininfo');
    	return redirect('/backend/login');
    }
    public function do($cmd, $target=""){
    	switch($cmd){
    		case 'login':
    			$rs = Admins::login(request('adminid'), request('password'));
    			return $rs ?  redirect('/backend') : redirect()->back();
    			break;
            case 'del_obj':
                if(request('delobj') == 'cms'){
                    Cm::del_pic(request('delsn'));
                    $data = Cm::where('id',request('delsn'))->first();
                    //廠商資料刪除，連同會員資料、compinfo、job一同刪除
                    if($data->position=='company'){
                        Cm::where('position','compinfo')->where('up_sn',request('delsn'))->delete();
                        Cm::where('position','comp_resume')->where('up_sn',request('delsn'))->delete();
                        Members::where('id',$data->up_sn)->delete();
                    }
                    //若是新聞來源要刪除，連同來源的新聞一同刪除
                    if($data->position=='nsource'){
                        Cm::where('position','news')->where('up_sn',request('delsn'))->delete();
                    }
                    //若是近期活動要刪除，連同活動圖片（多張）一同刪除
                    if($data->position=='event'){
                        OtherFiles::where('position','event')->where('cm_id',request('delsn'))->delete();
                    }
                    //若是專家資料刪除，連同會員資料一同刪除
                    if($data->position=='expert'){
                        Members::where('id',$data->up_sn)->delete();
                    }
                    if($data->position=='compinfo'){
                        $mid = Cm::where('id',$data->up_sn)->value('up_sn') ; 
                        SysLogs::company_log($mid,'company_update') ; 
                    }
                }
                if(request('delobj') == 'news_pic'){
                    Cm::where('id',request('delsn'))->update(['pic'=>Null]);
                }else{
                    DB::table(request('delobj'))->where('id', request('delsn'))->delete();
                }
                
                return Funcs::ret('');
                break;
            case 'edit':
                return Self::edit($target);
                break;
            case 'member_login':
                return Members::do_login(request()->only(['loginid', 'login_password']));
                break;
            case 'member_edit':
                if(!session('mid')) return ['status'=>'err', 'msg'=>'登入後閒置過久，請重新登入再試一次，謝謝。'];
                return Members::do_edit(session('mid'));
                break;
            case 'company_edit':
                if(!session('mid')) return ['status'=>'err', 'msg'=>'登入後閒置過久，請重新登入再試一次，謝謝。'];
                return Members::do_edit_company(session('mid'));
                break;
            case 'backend_member_edit':
                return Members::members_edit();               
                break;
            case 'change_password':
                if(!session('mid')) return ['status'=>'err', 'msg'=>'登入後閒置過久，請重新登入再試一次，謝謝。'];
                return Members::do_change_password();
                break;
            case 'gbwc_join':
                return GbwcJoin::do_join($target);
                break;
            case 'forget_password':
                return Members::do_send_password();
                break;
            case 'get_member_gbwc':
                $m = Members::where('email', request('email'))->first();
                if($m){
                    return ['status'=>'ok', 'msg'=>'這個Email已經註冊為本站會員了！請直接登入，或按「<a href="/member/forget">忘記密碼</a>」重新設定您的密碼。', 'act'=>'clear_email'];
                }
                $member_data = DB::table('member_gbwc')->where('email', request('email'))->orderBy('year', 'desc')->first();
                if($member_data){
                    return ['status'=>'ok', 'member_data'=>$member_data];
                }else{
                    return ['status'=>'ok'];
                }
                break;
            case 'signup':
                return Members::do_signup();
                break;
            case 'get':
                if($target == 'media'){
                    return view('backend.medialist');
                }
                break;
            case 'message': //討論區留言寫入
                return Cm::do_message();
                break;
            case 'reply'://討論區留言回覆寫入
                return Cm::do_reply();
                break;
            case 'edit_msg'://討論區留言、回覆編輯
                return Cm::edit_msg();
                break;
            case 'add_collect':
                return MembersCollects::do_collect();
                break;
            case 'resume_edit':
                return Cm::do_edit_resume();
                break;
            case 'post':
                return Cm::do_post();
                break;
            case 'remove_resume_item':
                return Cm::remove_resume_item(request('obj'), request('n'));
                break;
            case 'chg_status'://更改新聞狀態
                if(request('type')=='one'){
                    Cm::where('id',request('id'))->update(['mstatus'=>request('status')]);
                    return ['status'=>'ok'] ; 
                }else{
                    return Cm::chg_news_status();
                }
                break;
            case 'chg_newstype'://更改新聞分類
                return Cm::chg_newstype();
                break;
            case 'chg_psort'://置頂功能
                return Cm::chg_psort();
                break;
            case 'contact_company':
                return ContactLogs::contact();
                break;
            case 'write_msg'://發送訊息
                return Msg::write_msg(request('to_email'), request('msg'));
                break;
            case 'chg_read'://站內信標示為已讀
                return Msg::chg_msg_status();
                break;
            case 'get_compinfo':
                $compdata = Cm::where('id',request('compid'))->first();
                return ['status'=>'ok','data'=>$compdata] ;
                break;
            case 'company_resume_edit'://廠商徵才資料寫入
                return Cm::do_edit_compresume();
                break;
            case 'get_job'://我要應徵工作
                return Cm::get_job();
                break;
            case 'sort':
                return Cm::do_sort();
                break;
            case 'send_interview'://發送面試通知(站內信及email)
                return Msg::send_interview();
                break;
            case "sync"://後台新聞同步
                return Self::sync();
                break ; 
            case 'after_login':
                session(["after_login"=>request('url')]);
                return ['status'=>'ok'] ; 
                break;
            case 'upload_prods':
                return Cm::upload_prods() ; 
                break;
    	}
    }
    public function sync(){
        return Cm::sync();
    }
    public function edit($target){
        switch($target){
            case 'cm':
                return Cm::edit(request());
                break;
            case 'contact':
                return ContactLogs::admin_edit(request());
                break;
            case 'admin':
                return Admins::edit(request());
                break;
            case 'tags':
                return Tags::edit(request());
                break;
            case 'act':
                return Act::edit(request());
                break;
            case 'prospect'://展會相關
                return Prospects::prospect_edit(request());
                break;
        }
    }

    //匯出會員資料excel
    public static function do_excel($type){
        switch ($type) {
            case 'member':
                $title = '會員資料' ; 
                $member_data = Members::get();
                $cellData = [
                    ['帳號','會員類別','姓名','Email','狀態','註冊時間']
                ];
                foreach ($member_data as $rd) {
                    if($rd->name!=''){
                        $status = $rd->mstatus=='Y'?'正常':'停權' ;
                        $cellData[] = [$rd->loginid,$rd->type,$rd->name,$rd->email,$status,$rd->created_at] ; 
                    }
                }
                break;
        }
        

        \Excel::create($title,function ($excel) use ($cellData){
            $excel->sheet('data', function ($sheet) use ($cellData){
                $sheet->rows($cellData);
            });
        })->export('xls');
    }
    
    public function show_session(){
    	return session()->all();
    }
    public function export($id){
        $ard = Act::where('id', $id)->first();
        $fn = $ard->year.'GBWC報名';
        $view = View::make('export', ['id' => $id]);
        $contents = $view->render();
        return response($contents, 200)
                ->header('Content-Type', 'application/vnd.ms-excel')
                ->header('Content-Disposition', 'attachment;filename='.$fn.'.xls');
    }
    public function test($cmd){
        if($cmd == 'show_session'){
            return session()->all();
        }elseif($cmd == 'findstr'){ //根據關鍵字分類範例
            $main = "未分類";
            $main_count = 0;
            $t = [];
            $main_type = [] ; 
            $s = "The cooperation ";
            $main = Cm::where('position','keywords')->groupBy('type')->pluck('type');
            $keywords = [] ; 
            foreach ($main as $type) {
                $value = Cm::where('position','keywords')->where('type',$type)->pluck('name');
                foreach ($value as $name) {
                    $keywords[$type][]= $name ;  
                }
            }
            foreach ($keywords as $key => $value) {
                $c = 0 ; 
                foreach ($value as $word) {
                    $c += substr_count( $s , $word ) ;
                }
                if($c > 0){
                    $main_type[] = $key ; 
                }
            }
            $res = implode(',' , $main_type) ; 

            echo $res ; 

            
            // foreach($keywords as $k=>$v){
            //     $c = 0;
            //     foreach($v as $w){
            //         $c += substr_count($s , $w);
            //     }
            //     if($c > $main_count){
            //         $main_count = $c;
            //         $main = $k;
            //     }
            //     if($c >= 5){
            //         $t[] = $k;
            //     }
            // }
            // echo "主分類：".$main."<br />其他分類：".join("、",$t)."<br />";
        }elseif($cmd == 'link'){
            $contents = File::get( public_path('link.txt') );
            $link = explode(';', $contents) ; 
            if($link!=''){
                foreach($link as $rd){
                    $data = explode(',',$rd) ; 
                    // print_r(['position'=>'link','name'=>$data[0],'link'=>$data[1],'mstatus'=>'Y']);
                    \App\Cm::create(['position'=>'link','name'=>$data[0],'link'=>$data[1],'mstatus'=>'Y']);
                }
            }
            
        }
    }

    public function fix_news_pic(){

        
        //重新取新聞圖
        // $news_data = Cm::where('position','news')->where('pic','')->orderBy('up_sn','ASC')->get();
        // foreach($news_data as $rd){
        //     $pic = Cm::get_link_pic($rd->link) ; 
        //     if($pic) Cm::where('id',$rd->id)->update(['pic'=>$pic]);

        // }
        echo date('Y-m-d') . ' 完成' ;
    }

    public static function do_fix($type,$up_sn){
        switch($type){
            case 'news':
                // 修正新聞重複
                $news = Cm::where('position','news')->where('up_sn',$up_sn)->groupBy('name')->get();
                $t = 0 ; 
                foreach($news as $ns){
                    $ids = [] ; 
                    if($ns->name!=''){
                        $data = Cm::where('position','news')->where('name',$ns->name)->get();
                        if($data->count()>1) {
                            foreach($data as $rd){
                                $ids[$ns->id][] = $rd->id ;  
                            }
                        }
                        if(!empty($ids)){
                            foreach($ids as $key => $id){
                                // echo 'key = ' . $key . ' id = ' ; 
                                foreach ($id as $rd) {
                                    if( $key != $rd ){
                                        // echo $rd. ' ' ; 
                                        Cm::where('id',$rd)->delete();
                                    }
                                }
                                // echo '<br>' ;
                            }
                            
                        } 
                    }
                }
                break;
            case 'test' :
                $feed = simplexml_load_file('http://www.healthnews.com.tw/rss.php');
                foreach ($feed->channel->item as $item) {
                    print_r($item) ;
                    // echo $item->link.'<br>';
                    // echo $item->title.'<br>';
                    // echo $item->enclosure['url'].'<br><br>';
                    // if (isset($item->enclosure)) {
                    //     echo $item->enclosure['url'].'<br>';
                    // }
                }
               
                break;
        }
        // return ['status'=>'ok'] ; 
    }

    

}