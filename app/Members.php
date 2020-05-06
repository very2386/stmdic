<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Validator;
use Session;
use App\Funcs;
use App\Mail\ResetPassword;
use Mail;
use \Facebook\Facebook;
use App\Cm;
use App\SysLogs;
class Members extends Model
{
    protected $fillable = ['email','type','passwd','name','sname','industry','duties','gender','birth','tel','mobile','zip','county','district','address','epaper','lastlogin_addr','lastlogin_time','lastforget','forgetcount','mstatus','chg_pwd','loginid','apartment','epaper2','regcode','brief','tags','show','pic'];
    public static $fbinfo =[
            'app_id' => '110989952909732',
            'app_secret' => 'f28159521cacbe5785cf557e6b17729d',
            'default_graph_version' => 'v2.10',
    ];
    public static function do_signup(){

        //google recaptcha
        $secret = '6LcACjcUAAAAAAn1nGowPE-zIBLajCcW3HuLESn4';
        if (request('g-recaptcha-response')) {
            $recaptcha = new \ReCaptcha\ReCaptcha($secret);
            // 確認驗證碼與 IP
            $resp = $recaptcha->verify(request('g-recaptcha-response'));
            // 確認正確
            if(!$resp->isSuccess()){
                return ["status"=>"err","msg"=>"驗證失敗"];
            } 
        }else{
            return ["status"=>"err","msg"=>"請點選我不是機器人"];
        }
        $data = request()->only(['type','loginid','passwd','name','sname','email','gender','tel','address','brief','tags','facebook_id','google_id','comptype','show_email','show_compemail']);
		$errors = [];
        
        $req = ['passwd'=>'required|max:50',
                'loginid'=>'required|unique:members'];
        if($data['type']!='醫材廠商'){
            $req['email']='required|email|unique:members';
            $req['name']='required';
        }
        $validator = Validator::make($data, $req,[
            'required'=>'必填欄位',
            'email'=>'Email格式不正確',
            'unique'=>'這個資料已有人使用',
        ]);

        if ($validator->fails()) {
            return ["status"=>"err", "errors"=>$validator->errors()->toArray()];
        }
        if(!request('passwd_chk') ){
            $errors['passwd_chk'] = ['請輸入確認密碼'];
        }
        if(count($errors)){
            return ["status"=>"err", "errors"=>$errors];
        }
        if($data['passwd']!=request('passwd_chk') ){
            return ["status"=>"err", "errors"=>['passwd_chk'=>['密碼比對不相符']]];
        }
        if($data['type']=='醫材廠商'){
            $data['name'] = request('compname') ;
            $data['show_email'] = $data['show_compemail'] ? request('show_compemail') : 'N' ;
        }else{
            $data['show_email'] = $data['show_email'] ? request('show_email') : 'N' ;
        }
       
        $data['mstatus'] = 'Y';
        $data['passwd'] = md5($data['passwd']);
        $data['tags'] = request('interest') && is_array(request('interest')) ? implode(',', request('interest')):'';
        $data['lastlogin_time'] = date("Y-m-d H:i:s");
        $data['lastlogin_addr'] = request()->ip();
        $member = Self::create($data);
        //處理照片
        if(request()->hasFile('pic')){
            $member_pic['pic'] = Self::do_upload_pic($member->id);
            Self::where('id',$member->id)->update($member_pic);
        }
    
        //處理廠商
        if($data['type'] == '醫材廠商'){
            Self::do_edit_company($member->id);
        }elseif($data['type'] != '一般'){
            Self::do_edit_expert($member->id);
        }

        Self::do_login(['loginid'=>$data['loginid'], 'login_password'=>request('passwd_chk')]);
        return ['status'=>'ok', 'msg'=>'註冊成功'];
    }
    public static function do_login($data){
        // $validator = Validator::make($data, [
        //     'login_password'=>'required',
        //     'login_email'=>'required|email'
        // ],[
        //     'required'=>'必填欄位',
        //     'email'=>'Email格式不正確'
        // ]);
        // if ($validator->fails()) {
        //     return ["status"=>"err", "errors"=>$validator->errors()->toArray()];
        // }
        $loginid = $data['loginid'];
        $password = $data['login_password'];
        $member = Self::where('loginid', $loginid)->first();
        if(!$member){
			return ["status"=>"err", "errors"=>['loginid'=>['帳號錯誤']]];
        }elseif(md5($password) != strtolower($member->passwd)){
            return ["status"=>"err", "errors"=>['login_password'=>['密碼錯誤']]];
        }
        session(['minfo'=>$member, 'mid'=>$member->id]);
        Self::where('id', $member->id)->update(['lastlogin_addr'=>request()->ip(), 'lastlogin_time'=>date("Y-m-d H:i:s")]);
        $ret = ["status"=>"ok", "id"=>$member->id, "data"=>$member];
        if($member->type=='醫材廠商'){
            if(session('after_login')=='/') $ret['after_login'] = '/member/edit' ; 
            else $ret['after_login'] = session('after_login') ; 
            SysLogs::company_log($member->id,'company_login') ; 
        }else{
            if(session('after_login')=='/') $ret['after_login'] = '/member/index' ; 
            else $ret['after_login'] = session('after_login') ; 
        }
        return $ret ; 
    }
    public static function social_login($provider, $user, $token=''){

        $col = $provider."_id";
        $member = Self::where($col, $user->id)->first();
        
        if(!$member && $user->email) $member = Self::where('email', $user->email)->first();
        if(!$member){ 
            $password = uniqid();
            session(['data' => ['email'=>$user->email, 'passwd'=>$password, 'name'=>$user->name, $col=>$user->id ] ]);
            return view('member.signup');
            
            // $ret = Self::do_signup(['email'=>$user->email, 'passwd'=>$password, 'name'=>$user->name, $col=>$user->id, 'source'=>$provider ]);
            // $member = Self::where($col, $user->id)->first();
        }
        $mid = $member->id;
        $upd = [];
        if(empty($member->email) && $user->email ) $upd = ['email'=>$user->email];
		if(empty($member->$col) && $user->id ) $upd = [$col=>$user->id];
        if(count($upd)) Self::where('id', $mid)->update($upd);
        session(array('mid'=>$mid, 'minfo'=>$member));
        return true;
    }
    public static function do_logout(){
        session()->flush();
        return true;
    }
    public static function do_edit($mid=""){
        $old_type = Self::where('id',$mid)->value('type') ; 
        $err = array();
        $request = request()->all();
        if($request['type']=='醫材廠商'){
            if(!$request['compname']){
                $err['compname'] = '請輸入廠商名稱';
            }
            if(!$request['compemail']){
                $err['compemail'] = '請輸入廠商Email信箱';
            }
        }else{
            if(!$request['name']){
                $err['name'] = '請輸入您的姓名';
            }
        }
        if(count($err)){
            return ['status'=>'err', 'errors'=>$err, 'msg'=>'請檢查錯誤'];
        }
        if($request['type']!='醫材廠商'){
            $req = request()->only(['type','name','sname','email','gender','tel','address','brief','tags','facebook_id','google_id']);//一般專用
            $req['tags'] = request('interest') && is_array(request('interest')) ? implode(',', request('interest')):'';
            //更新圖片
            if(request()->hasFile('pic')){
                $req['pic'] = Self::do_upload_pic($mid);
            }
            $req['show_email'] = request('show_email') ? request('show_email') : 'N' ;
            Self::where('id', $mid)->update($req);
            //若是廠商換其他身分，則將廠商資料刪除
            if($old_type=='醫材廠商'){
                Cm::where('position','company')->where('up_sn',$mid)->delete();
                Cm::where('position','compinfo')->where('up_sn',$mid)->delete();
                Cm::where('position','comp_resume')->where('up_sn',$mid)->delete();
            } 
            if(request('type')!='一般') Self::do_edit_expert($mid);

        }else{
            $show_email = request('show_compemail') ? request('show_compemail') : 'N' ;
            Self::where('id', $mid)->update(['type'=>$request['type'],'name'=>$request['compname'],'email'=>$request['compemail'],'pic'=>'','show_email'=>$show_email]);
            //若是學者專家身分換成醫材廠商，則將原本專家資料刪除
            if($request['type']!='醫材廠商'&&$request['type']!='一般') 
                Cm::where('position','expert')->where('type',$old_type)->where('up_sn',$mid)->delete();
            Self::do_edit_company($mid) ;
            SysLogs::company_log($mid,'company_update');
        }
        
        $minfo = Self::where('id', $mid)->first();
        session(['minfo'=>$minfo]);
        return ['status'=>'ok', 'msg'=>'資料已更新','type'=>$minfo->type];
    }
    public static function do_upload_pic($mid, $f="pic"){
        $subname = request()->file($f)->extension();
        $types = ['jpg', 'jpeg', 'png', 'gif'];
        if(!in_array($subname, $types )){
            session()->flash('errmsg', '檔案格式'.$subname.'不允許上傳。');
            return false;
        }
        $path = "/upload/members";
        $fname = $mid.".".$subname;
        $save_pic = request()->file($f)->move(public_path().$path, $fname);
        return $path."/".$fname;
    }
    public static function do_change_password(){
        $err = array();
        $req = request()->only(['passwd_old', 'passwd', 'passwd_chk']);
        if(!$req['passwd_old']){
            $err['passwd_old'] = '請輸入舊密碼';
        }else{
            $chk = Self::where('id', session('mid'))->first();
            if(!$chk || strtolower($chk->passwd) != md5($req['passwd_old'])){
                $err['passwd_old'] = '您輸入的密碼有誤';
            }
        }
        if(!$req['passwd']){
            $err['passwd'] = '請輸入新密碼';
        }elseif(strlen($req['passwd']) < 8){
            $err['passwd'] = '新密碼至少需8個字元';
        }elseif(strlen($req['passwd']) > 20){
            $err['passwd'] = '新密碼最多20個字元';
        }
        if(!$req['passwd_chk']){
            $err['passwd_chk'] = '請再次輸入密碼';
        }elseif($req['passwd'] != $req['passwd_chk']){
            $err['passwd_chk'] = '請確認您輸入的密碼是否一致';
        }

        if(count($err)){
            return ['status'=>'err', 'errors'=>$err, 'msg'=>'請檢查錯誤'];
        }else{
            Self::where('id', session('mid'))->update(['passwd'=>md5($req['passwd'])]);
            return ['status'=>'ok', 'msg'=>'密碼已更新，未來請使用新密碼登入'];
        }
    }
    public static function do_send_password(){
        $err = array();
        $col = array();
        if(!request('email')){
            $err['email'] = '請輸入電子信箱';
        }else{
            $chk = Self::where('email', request('email'))->first();
            if(!$chk){
                $err['email'] = '您輸入的電子信箱不存在';
            }
        }
        if(count($err)){
            return ['status'=>'err', 'errors'=>$err, 'col'=>$col, 'msg'=>'請檢查錯誤'];
        }else{
            if(time()-$chk->lastforget > 180){
                $mailto = request('email');
                $passwd = Funcs::MakePass(8);
                $subject = '會員密碼重置通知信 '.date('Y-m-d H:i:s');
                $body = "
                *此信為系統通知信，請勿直接回覆，感謝您的配合。謝謝！<br><br>
                親愛的 南部科學工業園區 會員您好：<br><br>
                您的密碼於 ".date("Y-m-d H:i:s")." 被重新置換如下<br><br>
                ".$passwd."<br><br>
                請使用新密碼登入 南部科學工業園區 會員中心，謝謝!<br><br>
                如果您有任何問題，請您來信給我們。<br>";
                Self::where('id', $chk->id)->update(['passwd'=>md5($passwd), 'chg_pwd'=>'Y', 'lastforget'=>time(), 'forgetcount'=>$chk->forgetcount+1]);
                Mail::to($mailto)->send(new ResetPassword($subject, $body));
                return ['status'=>'ok', 'msg'=>'您的密碼已經重設並寄送至您的電子信箱中'];
            }else{
                return ['status'=>'err', 'msg'=>'您在不久前才重新設定密碼，請先嘗試等候我們寄發前封密碼通知，如果超過十分鐘都未收到，請再重新回到本畫面再試一次，謝謝！'];
            } 
        }
    }
    public static function new_object(){
        return (object)['id'=>'', 'email'=>'','type'=>'','passwd'=>'','name'=>'','sname'=>'','industry'=>'','duties'=>'','gender'=>'','birth'=>'','tel'=>'','mobile'=>'','zip'=>'','county'=>'','district'=>'','address'=>'','mstatus'=>'','epaper'=>'Y','loginid'=>'','apartment'=>'','epaper2'=>'','regcode'=>'','brief'=>'','tags'=>''];
    }
    public static function members_edit(){
        $data = request()->only(['type','email','passwd','name','sname','industry','duties','birth','gender','tel','mobile','zip','county', 'district','address','epaper','loginid','apartment','epaper2','regcode','brief','tags','pic']);
        if(request('passwd')) $data['passwd'] = md5(request('passwd'));
        else unset($data['passwd']) ;

        if(request('id')){
            $id = request('id');
            Members::where('id', request('id'))->update($data);
            $msg = '已修改會員資料';
        }else{
            $m = Members::create($data);
            $id = $m->id;
            $msg = '已新增會員資料';
        }
        if(request()->hasFile('pic')){
            $data['pic'] = Self::do_upload_pic($id);
            Self::where('id',$id)->update(['pic'=>$data['pic']]);
        }
        // Members::where('id', request('id'))->update($data);
        // $msg = '已修改會員資料';
        return ['status'=>'ok', 'msg'=>$msg ,'id'=>$id];
    }
    public static function search($term){
        $ret = [];
        $term = '%'.trim($term).'%';
        $rs = Self::where('name', 'like', $term)->orWhere('email', 'like', $term)->get();
        if(!$rs) $rs = [];
        foreach($rs as $rd){
            $ret[] = ['id'=>$rd->id, 'value'=>$rd->name];
        }
        return $ret;
    }
    public static function get_pic($id){
        $pic = Self::where('id', $id)->value('pic');
        if(is_file(public_path().$pic)) return asset($pic)."?r=".rand(0,1000);
        return '/img/member_default.png';
    }
    public static function get_fb_login_url(){
        if(!session_id()) {
            session_start();
        }
        $fb = new Facebook([
                    'app_id' => Self::$fbinfo['app_id'], // Replace {app-id} with your app id
                    'app_secret' => Self::$fbinfo['app_secret'],
                    'default_graph_version' => Self::$fbinfo['default_graph_version'],
                ]);
        $helper = $fb->getRedirectLoginHelper();
        $permissions = ['email']; // Optional permissions
        $loginUrl = $helper->getLoginUrl(url('social/login'), $permissions);
        return htmlspecialchars($loginUrl);
    }
    //Google登入連結
    public static function get_googleplus_login_url(){
        $config = [
            'application_name' => env('GOOGLE_APPLICATION_NAME', ''),
            'client_id'       => env('GOOGLE_CLIENT_ID', ''),
            'client_secret'   => env('GOOGLE_CLIENT_SECRET', ''),
            'redirect_uri'    => env('GOOGLE_REDIRECT', ''),
            'scopes'          => [],
            'access_type'     => 'online',
            'approval_prompt' => 'auto',
            'developer_key' => env('GOOGLE_DEVELOPER_KEY', ''),
            'service' => [
                'enable' => true,
                'file' => base_path('config/').env('GOOGLE_SERVICE_ACCOUNT_JSON_LOCATION', ''),
            ],
        ];
        $request = request();
        $client = new \PulkitJalan\Google\Client($config);
        $googleClient = $client->getClient();
        $client->setAuthConfig(base_path('config/').'client_secret_702915995975-gukp0mf2o3hc6uqsb27gvuojm0m1qebh.apps.googleusercontent.com.json');
        $client->addScope('https://www.googleapis.com/auth/plus.login');
        $client->addScope('https://www.googleapis.com/auth/plus.me');
        $client->addScope('https://www.googleapis.com/auth/userinfo.email');
        $client->addScope('https://www.googleapis.com/auth/userinfo.profile');
        $redirect_uri = $request->path();
        $client->setRedirectUri(url('callback/google'));
        $authUrl = $client->createAuthUrl();
        return $authUrl;
    }
    public static function do_edit_company($mid,$t=""){
        if($t!=''){ //後台修改廠商資料
            $comp = Cm::where('id', $mid)->first();
            $up_sn = $comp->up_sn ; 
        }else{
            $up_sn = $mid ;
        } 
        //基本資料
        $comptype = request('comptype') && is_array(request('comptype')) ? implode(',', request('comptype')):'';
        $ins = ['name'=>request('compname'), 'brief'=>request('compbrief'), 'lang'=>session('lang'), 'position'=>'company', 'up_sn'=>$up_sn,'email'=>request('compemail'),'comptel'=>request('comptel'),'addr'=>request('compaddr'),'type'=>$comptype,'compfax'=>request('compfax'),'link'=>request('link')];
        if(is_array(request('tags'))){
            $ins['tags'] = implode(',',request('tags'));
        }else{
            $ins['tags'] = '' ; 
        }
        if($t!=''){
            $ins['mstatus'] = request('mstatus') ; 
            $ins['online_status'] =request('online_status') ; 
        }
        
        if($t!='') $company = Cm::where('id', $mid)->first();
        else $company = Cm::where('up_sn', $up_sn)->where('position', 'company')->first();

        if($company){
            Cm::where('id', $company->id)->update($ins);
        }else{
            $company = Cm::create($ins);
        }
        //處理照片
        $id = $company->id;
        if(request()->hasFile('picfile')){
            $pic = Cm::upload_pic($id, 'picfile');
            if($pic['status']!='ok') return ['status'=>'err', 'msg'=>session('errmsg')];
            Cm::where('id', $id)->update(['pic'=>$pic['path']]);
        }
        if(request()->hasFile('spicfile')){
            $pic = Cm::upload_pic($id, 'spicfile', 's');
            if($pic['status']!='ok') return ['status'=>'err', 'msg'=>session('errmsg')];
            Cm::where('id', $id)->update(['spic'=>$pic['path']]);
            Self::where('id', $mid)->update(['pic'=>$pic['path']]);
        }
        //處理 compinfo
        $compinfo = Cm::get_companyinfo();
        foreach($compinfo as $type){
            if(request('compinfo_name') && isset(request('compinfo_name')[$type]) && is_array(request('compinfo_name')[$type])){
                $i = 0;
                foreach(request('compinfo_name')[$type] as $name){
                    if(!$name){
                        $i++;
                        continue;
                    }
                    $info = ['position'=>'compinfo', 'type'=>$type, 'up_sn'=>$id, 'lang'=>session('lang'), 'name'=>$name];
                    $info['brief'] = isset(request('compinfo_brief')[$type][$i]) ? request('compinfo_brief')[$type][$i] : '';
                    if($type=="上市產品"){
                        $info['link'] = isset(request('compinfo_youtube')[$type][$i]) ? request('compinfo_youtube')[$type][$i] : '';
                        $info['tags'] = request('compinfo_type')[$type]&&is_array(request('compinfo_type')[$type]) ?implode( ',' , request('compinfo_type')[$type] ) :'';
                    }  
                    $pic = isset(request('compinfo_pics')[$type][$i]) ? request('compinfo_pics')[$type][$i] : null;
                    $inford = Cm::create($info);
                    if($pic){
                        $picpath = Cm::upload_info_pic($inford->id, $pic);
                        Cm::where('id', $inford->id)->update(['pic'=>$picpath]);
                    }
                    $i++;
                }
            }
        }

        //處理tags關聯的部份
        if(request('old_tags') != $ins['tags'] ){
            Cm::where('position', 'relations')->where('obj','tag')->where('up_sn',$company->id)->delete();
            if(is_array(request('tags'))){
                foreach(request('tags') as $tag){
                    //取出這個關鍵字的id
                    $tagid = Cm::where('position', 'tag')->where('name', $tag)->value('id');
                    if(!$tagid){
                        $addtag = ['position'=>'tag', 'name'=>$tag, 'type'=>'text', 'brief'=>'#333'];
                        $newtag = Cm::create($addtag);
                        $tagid = $newtag->id;
                    }
                    $add = ['position'=>'relations','type'=>'company','obj'=>'tag', 'objsn'=>$tagid, 'up_sn'=>$company->id, 'name'=>$tag];
                    Cm::create($add);
                }
            }
        }



        // if($t!='') return $comptype;
        // else 
            return ['status'=>'ok', 'msg'=>'已更新廠商資料'];
    }
    public static function do_edit_expert($mid,$t=""){
        $rdata = [] ;
        //專家其他資料(寫成json格式)
        if(request('job_title')) $rdata['job_title'][] = request('job_title') ;
        if(request('sname')) $rdata['sname'][] = request('sname') ;
        if(request('unit')) $rdata['unit'][] = request('unit') ;
        if(request('email')) $rdata['email'][] = request('email') ;
        if(request('tel')) $rdata['tel'][] = request('tel') ;
        if(request('department')) $rdata['department'][] = request('department') ;
        if(request('blog')) $rdata['blog'][] = request('blog') ;
        if(request('facebook_id')) $rdata['facebook_id'][] = request('facebook_id') ;
        if(request('website')) $rdata['website'][] = request('website') ;
        if(request('address')) $rdata['address'][] = request('address') ;
        if(request('technology')) $rdata['technology'][] = request('technology') ;
        if(request('weblink')) $rdata['weblink'][] = request('weblink') ;
        
        if(request('school') && is_array(request('school'))){
            $n = 0 ; 
            foreach (request('school') as $school) {
                if(!$school){
                    $n++ ;
                    continue ;
                }
                $rdata['school'][] = request('school') && isset(request('school')[$n]) ? request('school')[$n] : '' ;
                $n++ ; 
            }
        }
        if(request('exp') && is_array(request('exp'))){
            $n = 0;
            foreach(request('exp') as $exps){
                if(!$exps){
                    $n++;
                    continue;
                }
                $rdata['exp'][] = request('exp') && isset(request('exp')[$n]) ? request('exp')[$n] : '';
                $n++;
            }
        }
        if(request('patent') && is_array(request('patent'))){
            $n = 0;
            foreach(request('patent') as $patents){
                if(!$patents){
                    $n++;
                    continue;
                }
                $rdata['patent'][] = request('patent') && isset(request('patent')[$n]) ? request('patent')[$n] : '';
                $n++;
            }
        }
        if(request('research') && is_array(request('research'))){
            $n = 0;
            foreach(request('research') as $res){
                if(!$res){
                    $n++;
                    continue;
                }
                $rdata['research'][] = request('research') && isset(request('research')[$n]) ? request('research')[$n] : '';
                $n++;
            }
        }
        if(request('test_exp') && is_array(request('test_exp'))){
            $n = 0;
            foreach(request('test_exp') as $test_exps){
                if(!$test_exps){
                    $n++;
                    continue;
                }
                $rdata['test_exp'][] = request('test_exp') && isset(request('test_exp')[$n]) ? request('test_exp')[$n] : '';
                $n++;
            }
        }
        if(request('case') && is_array(request('case'))){
            $n = 0;
            foreach(request('case') as $cases){
                if(!$cases){
                    $n++;
                    continue;
                }
                $rdata['case'][] = request('case') && isset(request('case')[$n]) ? request('case')[$n] : '';
                $n++;
            }
        }
        if(request('invest') && is_array(request('invest'))){
            $n = 0;
            foreach(request('invest') as $invest){
                if(!$invest){
                    $n++;
                    continue;
                }
                $rdata['invest'][] = request('invest') && isset(request('invest')[$n]) ? request('invest')[$n] : '';
                $n++;
            }
        }
        if(request('expertise') && is_array(request('expertise'))){
            $n = 0;
            foreach(request('expertise') as $expertise){
                if(!$expertise){
                    $n++;
                    continue;
                }
                $rdata['expertise'][] = request('expertise') && isset(request('expertise')[$n]) ? request('expertise')[$n] : '';
                $n++;
            }
        }
        if(request('oldprod')&&is_array(request('oldprod'))){
            $n = 0;
            foreach(request('oldprod') as $prods){
                if(!$prods){
                    $n++;
                    continue;
                }
                $prod_name = request('oldprod') && isset(request('oldprod')[$n]) ? request('oldprod')[$n] : '';
                $pic = isset(request('oldprod_pic')[$n]) ? request('oldprod_pic')[$n] : null;
                $rdata['product'][] = ['name'=>$prod_name, 'pic'=>$pic];
                $n++;
            }
        }
        if(request('product') && is_array(request('product'))){
            $n = 0;
            foreach(request('product') as $products){
                if(!$products){
                    $n++;
                    continue;
                }
                $prod_name = request('product') && isset(request('product')[$n]) ? request('product')[$n] : '';
                $pic = isset(request('product_pic')[$n]) ? request('product_pic')[$n] : null;
                if($pic){
                    $picpath = Cm::upload_info_pic($mid,$pic,'prod');   
                }
                $rdata['product'][] = ['name'=>$prod_name, 'pic'=>$picpath];
                $n++;
            }
        }
        $cont = json_encode($rdata,JSON_UNESCAPED_UNICODE);
        if($t=='docm') return $cont;

        //基本資料
        $member = Members::where('id',$mid)->first() ; 
        $ins = ['name'=>request('name'), 'brief'=>request('brief'), 'lang'=>session('lang'), 'position'=>'expert', 'type'=>request('type') ,'up_sn'=>$mid,'cont'=>$cont,'pic'=>$member->pic];

        $expert = Cm::where('up_sn', $mid)->where('position', 'expert')->first();
        if($expert){
            Cm::where('id', $expert->id)->update($ins);
        }else{
            $rd = Cm::create($ins);
        }
        return ['status'=>'ok', 'msg'=>'已更新專家資料'];
    }

}
