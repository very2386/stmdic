<?php
if($id){
	$rd = \App\Cm::where('id',$id)->first();
	$conts = json_decode($rd->cont) ; 
}else{
	$conts = \App\Cm::new_compresume_obj();
}
?>
@extends('main')
@section('content')
<section class="member-edit">
	@include('member.menu')
	<div class="breadcrumb">
		<a href="/member/company">會員專區</a> &gt; <a href="/member/company_resume_view">徵才資料</a> &gt; <a href="">徵才資料編輯</a>
	</div>
	<div class="content grid-intro form">
		<form action="/do/company_resume_edit" enctype="multipart/form-data" method="post" id="company_resume_form">
			<div class="block">
				<ul class="custom-input">
					<li>
						<h4 class="ttl">*職務類型</h4>
						<ul class="custom-radio sub flex">
							<li>
								<input name="job_type" id="job-full" type="radio" value="job_full" {{$conts->job_type=='job_full'?'checked':''}}>
								<label for="job-full" id="job-full">全職</label>
							</li>
							<li>
								<input name="job_type" id="job-part" type="radio" value="job_part" {{$conts->job_type=='job_part'?'checked':''}}>
								<label for="job-part" id="job-part">兼職</label>
							</li>
						</ul>
					</li>
					<li>
						<h4 class="ttl">*招聘職務名稱</h4>
						<input class="" type="text" name="job_title" value="{{$conts->job_title}}">
					</li>
					<li>
						<h4 class="ttl">*工作內容</h4>
						<textarea name="job_intro" id="" cols="30" rows="10">{{$conts->job_intro}}</textarea>
					</li>
					<li>
						<h4 class="ttl">*必要條件</h4>
						<textarea name="job_necessary" id="" cols="30" rows="10">{{$conts->job_necessary}}</textarea>
					</li>
					<li>
						<h4 class="ttl">*工作地點</h4>
						<input class="" type="text" name="job_location" value="{{$conts->job_location}}">
					</li>
					<li>
						<h4 class="ttl">*工作經驗</h4>
						<input class="" type="text" name="job_exp" value="{{$conts->job_exp}}">
					</li>
					<li>
						<h4 class="ttl">*招聘日期</h4>
						<input class="" type="text" name="job_date" value="{{$conts->job_date}}">
					</li>
					<li>
						<h4 class="ttl">*到職日期</h4>
						<input class="" type="text" name="job_arrivedate" value="{{$conts->job_arrivedate}}">
					</li>
					<li>
						<h4 class="ttl">*工作待遇</h4>
						<textarea name="job_salary" id="" cols="30" rows="10">{{$conts->job_salary}}</textarea>
					</li>
					<li>
						<h4 class="ttl">*員工福利制度</h4>
						<textarea name="job_benefit" id="" cols="30" rows="10">{{$conts->job_benefit}}</textarea>
					</li>
					<li>
						<h4 class="ttl">*關鍵字</h4>
						<input class="" type="text" name="job_keyword" value="{{$conts->job_keyword}}">
					</li>
					<li>
						<h4 class="ttl">*聯絡人姓名</h4>
						<input class="" type="text" name="job_contact" value="{{$conts->job_contact}}">
					</li>
					<li>
						<h4 class="ttl">*聯絡人電話</h4>
						<input class="" type="text" name="job_phone" value="{{$conts->job_phone}}">
					</li>
					<li>
						<h4 class="ttl">*聯絡人E-mail</h4>
						<input class="" type="text" name="job_email" value="{{$conts->job_email}}">
					</li>
					<li>
						<h4 class="ttl">*徵才網址</h4>
						<input class="" type="text" name="job_url" value="{{$conts->job_url}}">
					</li>
				</ul>
			</div>
			<p class="red fz-s">*資料請務必填寫完整，以保障會員權益</p>
			<div class="btn-confirm">
				<a onclick="submit_comapny_resume();" class="btn-confirm">送出</a>
				<input type="hidden" name="_token" value="{{csrf_token()}}">
				<input type="hidden" name="id" value="{{$id}}">
			</div>
		</form>
	</div>
</section>
@endsection
@section('javascript')
<script>
function submit_comapny_resume(){
	submit_form('#company_resume_form',function(){
		load_page('/member/company_resume_view');
	});
}
</script>
@endsection