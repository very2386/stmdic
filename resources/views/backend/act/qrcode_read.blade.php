<?php
$msize=["S"=>"小型（各邊長）0~20cm","M"=>"中型（各邊長）20~35cm","L"=>"大型（各邊長）36cm以上"];
$mplace = ["0"=>"北區:台北市中正區市民大道三段2號（三創數位生活園區 8樓）","1"=>"南區:高雄市左營區高鐵路115號（高鐵左營站與彩虹市集連通口 3樓）"];
$act = \App\Act::where('id', $jrd->asn)->first();
$act_type = $act->jstatus == 'C' ? '取件' : '報到（收件）';
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>BANDAI HOBBY GBWC {{$jrd->year}} QRCODE {{$act_type}}作業</title>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/3.4.2/css/swiper.min.css">
<script
  src="https://code.jquery.com/jquery-3.2.1.min.js"
  integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
  crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="/js/jquery-migrate-1.2.1.min.js"></script>
<script src="/js/jquery.form.js"></script>
<script src="/js/script.js"></script>
<style>
.btn{
	font-size: 18px;
	padding: 10px;
	margin-bottom: 30px;
}
.note{
	font-size: 12px;
	color: #c30;
}
</style>
</head>
<body style="margin:0; padding:0; font-size: 15px;">
<div style="width:100%; text-align:left;">
<div style="width:100%; margin:auto; border:#eee solid 1px;">
<img style="width:100%" src="{{url('/img/gbwc/checkin_header.png')}}" />
<div style="padding:30px; font-size:1em; line-height:1.6em;">
<p style="margin-bottom:10px">
管理者 {{$ard->name}} 您好：
</p>
<p style="margin-bottom:10px">
本畫面是 GBWC 活動 QRCODE {{$act_type}}專用畫面，請協助確認以下資訊：
<div class="note">*由於本畫面刊載作者個人資訊，請務必小心保密，並且絕對不可洩漏！</div> 
</p>
<h1 style="color:#2157af; padding:15px 0px">{{$jrd->year}} GBWC <br />報到資訊</h1>
<p style="margin:10px 0">作者姓名：{{$mrd->lname.$mrd->fname}}</p>
<p style="margin:10px 0">身份證號末五碼：{{$mrd->idnum}}</p>
<p style="margin:10px 0">性別：{{$mrd->gender == 'M' ? '男':'女'}}</p>
<p style="margin:10px 0">生日：{{$mrd->birth}}</p>
<p style="margin:10px 0">組別：{{ \App\GbwcJoin::get_group($mrd->birth, $jrd->year) }}</p>
<p style="margin:10px 0">筆名：{{$jrd->pen_name}}</p>
<p style="margin:10px 0">作品名稱：{{$jrd->model_title}}</p>
<p style="margin:10px 0">使用模型：{{$jrd->model_type}}</p>
<p style="margin:10px 0">作品尺寸：{{$msize[$jrd->model_size]}}</p>
<p style="margin:10px 0">交(取)件地點：{{$mplace[$jrd->model_place]}}</p>
<p style="margin:10px 0">作品介紹：{{$jrd->model_brief}}</p>
<div style="color:#2157af; padding:15px 0px; text-align:center">
@if($act->jstatus == 'C')
	@if($jrd->mstatus == 'F')
	<span class="btnact">本參加者已於 {{$jrd->checkin_time}} 完成取件！</span>
	<a class="btn btn-warning btn-block btnact" onclick="checkin('{{$jrd->qrcode}}','Y')">取消取件</a>
	@else
	<a class="btn btn-primary btn-block btnact" onclick="checkin('{{$jrd->qrcode}}','F')">設定取件</a>
	@endif
@else
	@if($jrd->mstatus == 'Y')
	<span class="btnact">本參加者已於 {{$jrd->checkin_time}} 報到成功！</span>
	<a class="btn btn-warning btn-block btnact" onclick="checkin('{{$jrd->qrcode}}','N')">取消報到</a>
	@else
	<a class="btn btn-primary btn-block btnact" onclick="checkin('{{$jrd->qrcode}}','Y')">設定報到</a>
	@endif
@endif
	<a class="btn btn-default btn-block" onclick="window.close()">關閉視窗</a>
</div>
<!--<a href="javascript:print()"><img src="{{url('/img/email/btn_print.png')}}"></a>-->
</div>
<input type="hidden" name="csrf_token" id="csrf_token" value="{{csrf_token()}}" />
<script type="text/javascript">
function checkin(qrcode, mstatus){
	get_data('{{url("/do/gbwc_checkin")}}', {qrcode:qrcode, mstatus:mstatus}, function(){
		$('.btnact').remove();
	});
}
</script>
</body>
</html>