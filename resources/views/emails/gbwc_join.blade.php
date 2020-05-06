<?php
$msize=["S"=>"小型（各邊長）0~20cm","M"=>"中型（各邊長）20~35cm","L"=>"大型（各邊長）36cm以上"];
$mplace = ["0"=>"北區:台北市中正區市民大道三段2號（三創數位生活園區 8樓）","1"=>"南區:高雄市左營區高鐵路115號（高鐵左營站與彩虹市集連通口 3樓）"];
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>BANDAI HOBBY GBWC 2017</title>
</head>
<body style="margin:0; padding:0">
<div style="width:100%; text-align:left;">
<div style="width:600px; margin:auto; border:#eee solid 1px;">
<img src="{{url('/img/email/mail_header.png')}}" />
<div style="padding:30px; font-size:1em; line-height:1.6em;">
<p style="margin-bottom:10px">
親愛的 {{$mrd->lname.$mrd->fname}} 會員您好：
</p>
<p style="margin-bottom:10px">
感謝您報名參加「GBWC 鋼彈模型製作家全球盃 2017」，以下是您的報名資訊與報到專屬 QR Code，請您妥善保存這封郵件，並於報到時以手機出示 QR Code 或是將郵件列印出來提供現場人員掃描完成報到手續。
</p>
<h1 style="color:#2157af; padding:15px 0px">2017 GBWC 報名資訊</h1>
<p style="margin:10px 0">筆名：{{$jrd->pen_name}}</p>
<p style="margin:10px 0">作品名稱：{{$jrd->model_title}}</p>
<p style="margin:10px 0">使用模型：{{$jrd->model_type}}</p>
<p style="margin:10px 0">作品尺寸：{{$msize[$jrd->model_size]}}</p>
<p style="margin:10px 0">交件地點：{{$mplace[$jrd->model_place]}}</p>
<p style="margin:10px 0">作品介紹：{{$jrd->model_brief}}</p>
<div>
	<div style="width:185px; margin:auto; padding:10px 0 15px 0; border:#ccc solid 1px">
		<div style="text-align:center">個人報到專屬QRcode</div>
		<div style="text-align:center"><img style="max-width:100%" src="{{url('/qr.php?code='.$jrd->qrcode)}}"></div>
	</div>
</div>
<div style="color:#2157af; padding:15px 0px; text-align:center">
請注意：QR Code 為我們唯一認證的報到機制，請勿外流，若是因此影響您的參賽權益，主辦單位將不負任何責任。
</div>
<!--<a href="javascript:print()"><img src="{{url('/img/email/btn_print.png')}}"></a>-->
</div>
<img src="{{url('/img/email/mail_footer.png')}}">
</div>
</div>
</body>
</html>