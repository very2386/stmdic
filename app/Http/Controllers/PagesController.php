<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Cm;
use App\Members;
use App\OtherFiles;
use App\Act;
use \Facebook\Facebook;
use \Gregwar\Captcha\CaptchaBuilder;

class PagesController extends Controller
{
    //
    public static $fbinfo =[
            'app_id' => '110989952909732',
            'app_secret' => 'f28159521cacbe5785cf557e6b17729d',
            'default_graph_version' => 'v2.10',
    ];
    public function index(){
        return view('index');
    }
    public function member_info($id){
        return view('member_info',compact('id'));
    }
    public function company($id=""){
        if(is_numeric($id)) return view('company_content', compact('id'));
        else return view('company',compact('id'));
    }
    public function company_hire_list($id){
        return view('company_hire_list',compact('id'));
    }
    public function company_hire($id){
        return view('company_hire',compact('id'));
    }
    public function job(){
        return view('job_list');
    }
    public function information($type,$id=''){
        if($id) return view('information_content',compact('type','id'));
        else return view('information',compact('type'));
    }
    public function event($id=""){
        if(is_numeric($id)) return view('event_content', compact('id'));
        return view('event',compact('id'));
    }
    public function video($id=""){
        $page = 'video' ; 
        if(is_numeric($id)) return view('video_content', compact('id','page'));
        return view('video',compact('id','page'));
    }
    public function marketing($page,$type="",$id=""){
        if($type){
            if($page == 'prod') $page = 'marketing';
            if(is_numeric($type)){
                $id = $type ; 
                return view('marketing.'.$page.'_content',compact('id','page'));
            } 
            if($id) return view('marketing.'.$page.'_content',compact('id','type','page'));
            else return view('marketing.'.$page,compact('type','page'));
        }else{
            return view('marketing.'.$page) ; 
        }
    }
    public function calendar(){
        return view('calendar');
    }
    public function statistics(){
        return view('statistics');
    }
    public function expert($id=""){
        if(is_numeric($id)) return view('expert_content', compact('id'));
        return view('expert',compact('id'));
    }
    public function post($id=""){
        if(is_numeric($id)) return view('post_content', compact('id'));
        return view('post',compact('id'));
    }
    public function post_cat($id=""){
        return view('post_cat',compact('id'));
    }
    public function post_edit($id=""){
        if($id!='index') return view('post_edit', compact('id'));
        return view('post_edit');
    }
    public function about($page="",$id=""){
        if($page=='') $page = 'about' ;
        if($id) return view($page.'_content',compact('id'));
        return view($page,compact($id));
    }
    public function contact(){
        return view('contact');
    }
    public function search(){
        return view('search');
    }
    public function link(){
        return view('link');
    }
    public function market(){
        $bodyid = 'page-market';
        return view('market', compact('bodyid'));
    }
    public function member($page="index",$id=""){
        $no_login = ['forget','signup'];
        if(!session('mid') && !in_array($page, $no_login)) return view('member.'.$page,compact('page','id'));//return redirect('/');
        if($page == 'logout'){
            $admininfo = session('admininfo') ;
            session()->flush();
            session(['admininfo'=>$admininfo,'adminid'=>$admininfo['id']]);
            return redirect('/');
        }
        return view('member.'.$page,compact('page','id'));
    }
    public function resume($id){
        return view('resume',compact('id'));
    }
    public function files($ftype='',$type=''){
        return view('files',compact('ftype','type'));
    }
    public function news($id=""){
        if(!$id) return view('news');
        if(is_numeric($id)){
            $rd = \App\Cm::where('id', $id)->first();
            if(!$rd || !isset($rd->mstatus) || $rd->mstatus !='Y'){
                return redirect('/news');
            }
            return view('news_content', compact('id','rd'));
        }else{
            $rd = \App\Cm::where('position','news')->where('type', $id)->where('mstatus','Y')->get();
            return view('news', compact('id','rd'));
        }
    }

    //檔案下載
    public function download($id){
        $files = OtherFiles::where('id',$id)->first();
        if($files && $files->fname){
            $fpath = public_path($files->fname);
            return response()->download($fpath, $files->name);
        }
    }
    public function data($item, $arg=""){
        $ret = [];
        switch($item){
            case 'hotarticles':
                $ret = Cm::get_hotarticles();
                break;
            case 'members':
                $ret = Members::search(request('term'));
                break;
            case 'tags':
                $ret = [];
                $rs = Cm::where('position', 'tag')->where('name', 'like', request('term')."%")->get();
                foreach($rs as $rd){
                   $ret[] = ['id'=>$rd->name, 'text'=>$rd->name];
                }
                break;
        }
        return $ret;
    }
    public static function callback(){
        if(!session_id()) {
            session_start();
        }
        $fb = new Facebook([
            'app_id' => Self::$fbinfo['app_id'], // Replace {app-id} with your app id
            'app_secret' => Self::$fbinfo['app_secret'],
            'default_graph_version' => Self::$fbinfo['default_graph_version'],
        ]);
        $helper = $fb->getRedirectLoginHelper();
        try {
          $accessToken = $helper->getAccessToken();
        } catch(exception $e) {
            Session::flash('sysmsg', 'Graph returned an error: ' . $e->getMessage());
            return false;
        }
        if (! isset($accessToken)) {
            Session::flash('sysmsg', 'Access token error!');
            return false;
        }
        session(['facebook_token'=>(string) $accessToken]);
        try {
          // Returns a `Facebook\FacebookResponse` object
          $response = $fb->get('/me?fields=id,name,email', $accessToken->getValue());
        } catch(Facebook\Exceptions\FacebookResponseException $e) {
            Session::flash('sysmsg', 'getFBResponseError');
            return false;
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
            Session::flash('sysmsg', 'getFBSDKError'); 
            return false;
        }
        $fbuser = $response->getGraphUser();
        $user = new \stdClass();
        $user->id = $fbuser->getId();
        $user->name = $fbuser->getName();
        $user->email = $fbuser->getEmail();
        $user->avatar = 'https://graph.facebook.com/'.$user->id.'/picture?width=100&height=100';
        return Members::social_login('facebook', $user);     
    }
    
    public static function google_callback(Request $request){
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
        $client = new \PulkitJalan\Google\Client($config);
        $googleClient = $client->getClient();
        // $client = \Google::getClient();
        $token = $googleClient->fetchAccessTokenWithAuthCode($request->code);
        $googleClient->setAccessToken($token['access_token']);
        session(['google_token'=>$token]);
        if ($googleClient->getAccessToken()) {
            $data = $client->verifyIdToken($token['id_token']);
            $user = new \stdClass();
            $user->id = $data['sub'];
            $user->name = $data['name'];
            $user->email = $data['email'];
            $user->avatar = $data['picture'];
        }
        return $res = Members::social_login('google', $user);
    }

    //生成驗證碼
    public static function captcha(){
        //設置定義為圖片
        header("Content-type: image/PNG");
        //設置產生驗證碼圖示的參數
        $nums = 5 ;//生成驗證碼個數
        $width = 120 ; //圖片寬
        $high = 30 ; //圖片高
        
        //去除了數字0和1 字母小寫O和L，為了避免辨識不清楚
        $str = "23456789abcdefghijkmnpqrstuvwxyzABCDEFGHIJKLMOPQRSTUBWXYZ";
        $code = '';
        for ($i = 0; $i < $nums; $i++) {
            $code .= $str[mt_rand(0, strlen($str)-1)];
        }

        session(['check_word'=> $code]) ;

        //建立圖示，設置寬度及高度與顏色等等條件
        $image = imagecreate($width, $high);
        $black = imagecolorallocate($image, mt_rand(0, 200), mt_rand(0, 200), mt_rand(0, 200));
        $border_color = imagecolorallocate($image, 21, 106, 235);
        $background_color = imagecolorallocate($image, 235, 236, 237);

        //建立圖示背景
        imagefilledrectangle($image, 0, 0, $width, $high, $background_color);

        //建立圖示邊框
        imagerectangle($image, 0, 0, $width-1, $high-1, $border_color);

        //在圖示布上隨機產生大量躁點
        for ($i = 0; $i < 80; $i++) {
            imagesetpixel($image, rand(0, $width), rand(0, $high), $black);
        }
       
        $strx = rand(3, 8);
        for ($i = 0; $i < $nums; $i++) {
            $strpos = rand(1, 6);
            imagestring($image, 5, $strx, $strpos, substr($code, $i, 1), $black);
            $strx += rand(10, 30);
        }

        imagepng($image);
        imagedestroy($image);
    }

    
}
