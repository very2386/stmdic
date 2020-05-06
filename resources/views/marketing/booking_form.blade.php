<?php
if(!session('mid')){
	echo '<script>alert("本功能僅供會員使用");location.href="/marketing/booking";</script>' ;
	exit();
}
if(request('id')){
	$rs = \App\Cm::where('id',request('id'))->first();
	$cont = json_decode($rs->cont) ; 
}else{
	$rs = \App\Cm::new_obj();
	$cont = (object)["title"=>"","purpose"=>"","group"=>"","num_people"=>""];
} 

?>
@extends('main')
@section('content')
<section class="exhibit bg-gray">
	<div class="ttl-bar">
		<h2>醫材展示室 - 預約使用</h2>
	</div>
	<div class="breadcrumb">
		<a href="/">首頁</a> &gt; 
		<a href="javascript:;">行銷專區</a> &gt;
		<a href="javascript:;">展示平台</a> &gt;
		<a href="javascript:;">醫材展示室</a> &gt;
		<a href="/marketing/booking">預約使用</a>
	</div>
	<div class="content grid-intro booking">
		<form id="booking_form" enctype="multipart/form-data" method="post" action="/do/edit/cm">
			<ul class="custom-input">
				<li>
					<h4 class="ttl">日期</h4>
					<input type="text" name="edate" value="{{request('date')}}" readonly>
				</li>
				<li>
					<h4 class="ttl">時間</h4>
					<div id="type-select" class="custom-select small bordered w-srt" target="#obj">
						<h5 class="ttl">{{$rs->obj?$rs->obj:(request('day')=='am'?'上午':'下午')}}</h5>
						<!-- <ul class="opt">
							<li data-type="上午">上午</li>
							<li data-type="下午">下午</li>
						</ul> -->
						<input type="hidden" id="obj" name="obj" value="{{$rs->obj?$rs->obj:(request('day')=='am'?'上午':'下午')}}">
					</div>
				</li>
				<li>
					<h4 class="ttl">活動名稱</h4>
					<input type="text" name="title" value="{{$cont->title}}">
				</li>
				<li>
					<h4 class="ttl">目的</h4>
					<input type="text" name="purpose" value="{{$cont->purpose}}">
				</li>
				<li>
					<h4 class="ttl">來訪團體</h4>
					<input type="text" name="group" value="{{$cont->group}}">
				</li>
				<li>
					<h4 class="ttl">人數</h4>
					<input type="text" name="num_people" value="{{$cont->num_people}}">
				</li>
				<li>
					<h4 class="ttl">場地</h4>
					<div id="type-select" class="custom-select small bordered w-srt" target="#type">
						<h5 class="ttl">{{$rs->type?$rs->type:'展示室'}}</h5>
						<ul class="opt">
							<li data-type="展示室">展示室</li>
							<li data-type="會議室">會議室</li>
						</ul>
						<input type="hidden" id="type" name="type" value="{{$rs->type?$rs->type:'展示室'}}">
					</div>
				</li>
				<li>
					<h4 class="ttl">聯絡人</h4>
					<input type="text" name="name" value="{{$rs->name}}">
				</li>
				<li>
					<h4 class="ttl">聯絡電話</h4>
					<input type="text" name="comptel" value="{{$rs->comptel}}">
				</li>
				<li>
					<h4 class="ttl">聯絡E-mail</h4>
					<input type="text" name="email" value="{{$rs->email}}">
				</li>
				<li>
					<h4 class="ttl">備註</h4>
					<textarea name="brief" id="" rows="10">{{$rs->brief}}</textarea>
				</li>
			</ul>
			<input type="hidden" name="_token" value="{{csrf_token()}}">
			<input type="hidden" name="lang" value="{{$rs->lang ? $rs->lang : session('lang')}}">
			<input type="hidden" name="id" value="{{$rs->id}}">
			<input type="hidden" name="position" value="booking">
			<input type="hidden" name="up_sn" value="{{session('mid')}}">
			<input type="hidden" name="mstatus" value="Y">
			<input type="submit" class="btn-box" style="width:5em;margin:0 auto;" value="預約">
		</form>
	</div>
</section>
@endsection
@section('javascript')
<script>
	$(function(){
		register_form('#booking_form', function(res){
			if(res['status']=='ok'){
				alert('預約完成') ; 
				load_page('/marketing/booking') ;
			}
		});
	})
</script>
@endsection