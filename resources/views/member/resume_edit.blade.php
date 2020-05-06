<?php
$resume = \App\Cm::where('position', 'resume')->where('up_sn', session('mid'))->first();
if(!$resume){
	$resume = \App\Cm::new_obj();
	$rdata = \App\Cm::new_resume_obj();
}else{
	$rdata = json_decode($resume->cont);
}
if(!$resume->pic) $resume->pic = '/img/member_default.png';
$n=0;
?>
@extends('main')
@section('content')
<section class="register">
	<div class="ttl-bar">
		<h2>會員履歷表 - 編輯</h2>
	</div>
	<div class="breadcrumb">
		<a href="/member/index">會員專區</a> &gt; <a href="">編輯履歷表</a>
	</div>
	<form action="/do/resume_edit" enctype="multipart/form-data" method="post" id="resume_form">
	<div class="content grid-intro form">
		<div class="block">
			<h3 class="ttl">基本資料</h3>
			<ul class="custom-input">
				<li>
					<h4 class="ttl">*中文姓名</h4>
					<input class="" type="text" name="name" value="{{$rdata->name}}">
				</li>
				<li>
					<h4 class="ttl">*英文姓名</h4>
					<input class="" type="text" name="ename" value="{{$rdata->ename}}">
				</li>
				<li>
					<h4 class="ttl">*上傳照片</h4>
					<div class="prop">
						<input type="file" name="picfile">
						<p>* 檔案格式：JPG、PNG</p>
					</div>
				</li>
				<li>
					<h4 class="ttl">性別</h4>
					<ul class="custom-radio sub">
						<li>
							<input name="gender" id="gender-male" value="M" type="radio" {{$rdata->gender=='M'? 'checked':''}} >
							<label for="gender-male" id="gender-male">男性</label>
						</li>
						<li>
							<input name="gender" id="gender-female" value="F" type="radio" {{$rdata->gender=='F'? 'checked':''}} >
							<label for="gender-female" id="gender-female">女性</label>
						</li>
					</ul>
				</li>
				<li>
					<h4 class="ttl">*生日</h4>
					<input class="" type="text" name="birth" value="{{$rdata->birth}}">
					<p>*例如：1986-10-01</p>
				</li>
				<div class="rdesume-pic"><img src="{{$resume->pic}}" alt="履歷照片"></div>
			</ul>
		</div>
		<div class="block">
			<h3 class="ttl">聯絡資料</h3>
			<ul class="custom-input">
				
				<li>
					<h4 class="ttl">聯絡電話</h4>
					<input class="" type="text" name="tel" value="{{$rdata->tel}}">
				</li>
				<li>
					<h4 class="ttl">通訊地址</h4>
					<input class="" type="text" name="address" value="{{$rdata->address}}">
				</li>
				<li>
					<h4 class="ttl">*E-mail</h4>
					<input class="" type="text" name="email" value="{{$rdata->email}}">
					<p>＊請輸入有效E-mail </p>
				</li>
				<li>
					<h4 class="ttl">FACEBOOK</h4>
					<input class="" type="text" name="facebook_id" value="{{$rdata->facebook_id}}">
					<p>*請貼上連結</p>
				</li>
				<li>
					<h4 class="ttl">GOOGLE</h4>
					<input class="" type="text" name="google_id" value="{{$rdata->google_id}}">
					<p>*請貼上連結</p>
				</li>
				<li>
					<h4 class="ttl">LineID</h4>
					<input class="" type="text" name="line_id" value="{{$rdata->line_id}}">
				</li>
			</ul>
		</div>
		<div class="block upload" data-index="{{$n++}}">
			<h3 class="ttl">求職資料</h3>
			<ul class="custom-input">
				<li>
					<div class="title">
						<h4 class="ttl">就業狀態</h4>
					</div>
					<div class="custom-select small bordered w-srt" target="#occupy_status">
						<h5 class="ttl">{{$rdata->occupy_status?$rdata->occupy_status:'請選擇'}}</h5>
						<ul class="opt">
							<li>待業中</li>
							<li>仍在職</li>
						</ul>
					</div>
					<input type="hidden" name="occupy_status" id="occupy_status" value="{{$rdata->occupy_status}}">
				</li>
			</ul>
		</div>
		<div class="block upload" data-index="{{$n++}}">
			<h3 class="ttl">學歷</h3>
			<?php
			$x = 0;
			?>
			@foreach($rdata->schools as $school)
			<div class="item" id="item-schools-{{++$x}}">
				<a class="del" onclick="remove_item('item-schools-{{$x}}')"><i class="fa fa-times-circle" aria-hidden="true"></i></a>
				{{$school->name}}<span>{{$school->department}}</span>	
			</div>
			@endforeach
			<ul class="custom-input">
				<li>
					<div class="title">
						<h4 class="ttl">學校名稱</h4>
					</div>
					<div class="prop">
						<ul class="sub">
							<li>
								<input type="text" name="school_name[]">
								<span class="month">科系<input class="w-srt" type="text" name="school_department[]" /></span>
							</li>
						</ul>
					</div>
				</li>
			</ul>
			<button type="button" class="btn-add-sp">+</button>
		</div>
		<div class="block upload" data-index="{{$n++}}">
			<?php
			$x = 0;
			?>
			@foreach($rdata->languages as $language)
			<div class="item" id="item-languages-{{++$x}}">
				<a class="del" onclick="remove_item('item-languages-{{$x}}')"><i class="fa fa-times-circle" aria-hidden="true"></i></a>
				{{$language}}
				
			</div>
			@endforeach
			<ul class="custom-input">
				<li>
					<div class="title">
						<h4 class="ttl">語言</h4>
						<button type="button" class="btn-add">+</button>
					</div>
					<div class="prop">
						<ul>
							<li>
								<input type="text" name="language[]">
							</li>
						</ul>
					</div>
				</li>
			</ul>
		</div>
		<div class="block upload" data-index="{{$n++}}">
			<?php
			$x = 0;
			?>
			@foreach($rdata->certs as $cert)
			<div class="item" id="item-certs-{{++$x}}">
				<a class="del" onclick="remove_item('item-certs-{{$x}}')"><i class="fa fa-times-circle" aria-hidden="true"></i></a>
				{{$cert}}
			</div>
			@endforeach
			<ul class="custom-input">
				<li>
					<div class="title">
						<h4 class="ttl">證照</h4>
						<button type="button" class="btn-add">+</button>
					</div>
					<div class="prop">
						<ul>
							<li>
								<input type="text" name="cert[]">
							</li>
						</ul>
					</div>
				</li>
			</ul>
		</div>
		<div class="block upload" data-index="{{$n++}}">
			<h3 class="ttl">經歷</h3>
			<?php
			$x = 0;
			?>
			@foreach($rdata->jobs as $job)
			<div class="item job" id="item-jobs-{{++$x}}">
				<a class="del" onclick="remove_item('item-jobs-{{$x}}')"><i class="fa fa-times-circle" aria-hidden="true"></i></a>
				<div class="name">{{$job->name}} &nbsp; {{$job->position}}</div>
				<div class="time">{{$job->start}} ~ {{$job->end}}</div>
				<div class="work">{{$job->work}}</div>
			</div>
			@endforeach
			<ul class="custom-input">
				<li>
					<div class="title">
						<h4 class="ttl">公司名稱</h4>
					</div>
					<div class="prop">
						<input type="text" name="job_name[]">
					</div>
				</li>
				<li>
					<div class="title">
						<h4 class="ttl">時間</h4>
					</div>
					<div class="prop">
						<ul class="sub">
							<li>
								<input class="w-srt" type="text" name="job_start[]"> ~ <input class="w-srt" type="text" name="job_end[]">
							</li>
						</ul>
					</div>
				</li>
				<li>
					<div class="title">
						<h4 class="ttl">職位</h4>
					</div>
					<div class="prop">
						<input type="text" name="job_position[]">
					</div>
				</li>
				<li>
					<div class="title">
						<h4 class="ttl">工作內容</h4>
					</div>
					<div class="prop">
						<input type="text" name="job_work[]">
					</div>
				</li>
				<li class="sep"></li>	
			</ul>
			<button type="button" class="btn-add-sp">+</button>
		</div>
		<div class="block">
			<ul class="custom-input">
				<li>
					<div class="title">
						<h4 class="ttl">自傳</h4>
					</div>
					<div class="prop">
						<textarea name="self_intro" id="self_intro" cols="30" rows="10">{{$rdata->self_intro}}</textarea>
					</div>
				</li>
			</ul>
		</div>
		<div class="btn-confirm">
			<a href="/member/resume_view" class="btn-cancel">取消</a>
			<a onclick="submit_resume();" class="btn-confirm">儲存修改</a>
		</div>
	</div>
	<input type="hidden" name="_token" value="{{csrf_token()}}">
	</form>
</section>
@endsection
@section('javascript')
<script>
function submit_resume(){
	submit_form('#resume_form',function(){
		reload_page();
	});
}
function remove_item(targetid){
	var _token = $('#csrf_token').val();
	var items = targetid.split('-');
	var obj = items[1];
	var n = items[2];
	get_data('/do/remove_resume_item',{obj:obj, n:n, '_token':_token},function(res){
	    $('#' + targetid).remove();
	});
}
</script>
@endsection