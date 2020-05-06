<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Validator;
use App\Cm;
use App\Msg;
use Mail;
use App\Mail\CompanyContact;

class ContactLogs extends Model
{
    protected $table = 'contact_logs';
    protected $fillable = [	'id','lang','category','name','gender','comp_id','title','tel','fax','address','email','subject','content','dstatus'];
    public static function contact(){
    	$data = request()->all();
    	$validator = Validator::make($data, [
            'name'=>'required|max:50',
            'email'=>'required|email',
            'subject'=>'required',
            'content'=>'required',
            'checkword'=>'required',
        ],[
            'required'=>'必填欄位',
            'email'=>'Email格式不正確',
        ]);
        if ($validator->fails()) {
            return ["status"=>"err", "errors"=>$validator->errors()->toArray()];
        }
        if(request('checkword')!=session('check_word')){
            return ["status"=>"err", "msg"=>"驗證碼輸入錯誤！"];
        }

      	Self::create($data);

        $subject = '智慧生醫產業聚落交流平台-詢問通知信 '.date('Y-m-d H:i:s');
        $body = "智慧生醫產業聚落交流平台-詢問通知信<br>"
                ."內容如下：<br>"
                ."詢問人姓名：" . request('name') . '<br>' 
                ."聯絡電話：". request('tel') . '<br>'
                ."聯絡E-MAIL：". request('email') . '<br>'
                ."問題類型：". request('subject') . '<br>'
                .'問題內容：'.request('content');

        $company = Cm::where('id',request('comp_id'))->first(); 
        if($company->email){
            $mailto = $company->email ;
        }else{
            return Msg::write_msg(request('comp_id'),$body) ;
            // return ['status'=>'err','msg'=>'寄送失敗，因為此廠商尚未有EMAIL'];
        }
         
        Mail::to($mailto)->send(new CompanyContact($subject, $body));
    	return ['status'=>'ok','msg'=>'感謝您，您的聯絡資料已送出'];
    }
}
