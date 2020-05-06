<?php
$mrd = \App\Members::where('id', session('mid'))->first();
$where = ['to_mid'=>session('mid')];
if(request('mstatus')) $where['mstatus'] =request('mstatus');
$msgs = \App\Msg::where($where)->get();
if(!$msgs) $msgs = [];
?>
@extends('main')
@section('content')
<style>
.product{
    margin-right: 20px;
    margin-bottom: 10px;
}
.product li{
	width: 100px;
}
.msg-content{
	position: relative;
}
.msg-mstatus{
	display: inline-block;
	width: 300px;
	padding:10px;
}
.msg-mstatus > div{
	float:left;
}
.btn-add-msg{
	position:absolute;
	right:10px;
	top:0px;
}
.msgs{
	padding:25px 10px;
}
.msgs li{
	position: relative;
    background-color: #fff;
    margin-bottom: 50px;
    padding:20px;
}
.msgs .text{
	padding: 20px;
}
.btn-mstatus{
	text-align:right;
	display: inline-block;
}
</style>
<section class="member">
	@include('member.menu')
	<div class="breadcrumb">
		<a href="">會員專區</a> &gt; <a class="name" href="">站內信通知</a>
	</div>
	<div class="msg-content bg-gray">
		<div class="msg-mstatus flex v-center">
			<div id="mstatus-select" class="custom-select small bordered" target="#mstatus">
				<h5 class="ttl">{{request('mstatus') ? '未讀': '請選擇'}}</h5>
				<ul class="opt">
					<li data-mstatus="">全部</li>
					<li data-mstatus="N">未讀</li>
				</ul>
				<input type="hidden" id="mstatus" value="">
				<input type="hidden" id="current_url" value="{{request()->url()}}">
			</div>
		</div>
		<a class="btn btn-add-msg">+發表站內信</a>
		<ul class="msgs">
		@foreach($msgs as $rd)
			<?php
			$from_mrd = \App\Members::where('id', $rd->mid)->first();
			?>
			<li class="flex">
				<div class="smember">
					<div class="avatar">
						<div class="img"><img src="{{\App\Members::get_pic(session('mid'))}}" alt=""></div>
						<h4>{{$from_mrd->sname? $from_mrd->sname : $from_mrd->name}}</h4>
						<p>於 {{$rd->created_at}}</p>
					</div>
					
				</div>
				<div class="text">
					<p>{!!$rd->msg!!}</p>
					@if($rd->mstatus=='N')
					<div class="reply-btns">
						<a onclick="chg_read('{{$rd->sn}}')" class="btn">標示為已讀取</a>
					</div>
					@endif
				</div>
			</li>
		@endforeach
		</ul>
	</div>
	<div class="popup popup-add-msg" style="display: none">
		<div class="masklayer"></div>
	  	<div class="popup_window">
	    	<div class="popup_title">
	      		<h3>新增站內信</h3>
	    	</div>
	    	<div class="popup_content">
	      		<form action="/do/write_msg" id="write_msg_form" method="post">
	        		<div class="block">
		          		<h3 class="note">請輸入您要聯絡的內容：</h3>
				        <ul class="custom-input">
				            <li>
				              	<h4 class="ttl">*對方Email</h4>
				              	<input class="" type="text" name="to_email" value="">
				            </li>
				            <li>
				              	<h4 class="ttl">*內容</h4>
				              	<textarea name="msg" cols="20" rows="10"></textarea>
				            </li>
				            <li>
				              	<div class="popup_pad_left"></div>
				              	<input type="hidden" name="_token" value="{{csrf_token()}}">
				              	<input type="submit" name="goAddMsg" class="btn-box" value="送出" />
				            </li>
				        </ul>
	        		</div>
	      		</form>
	    	</div>
	  	</div>
	</div>
</section>
@endsection
@section('javascript')
<script type="text/javascript">
$(function(){
	$('#mstatus-select .opt li').click(function(){
		var url = $('#current_url').val();
		location.href=url+'?mstatus='+$(this).data('mstatus');
	});
	register_form('#write_msg_form', function(){
      $('.popup-add-msg').fadeOut();
    });
    $('.btn-add-msg').click(function() {
      $('.popup-add-msg').fadeIn();
    }) 
    $('.masklayer').click(function(){
      $(this).parent().fadeOut();
    })
});
function chg_read(id){
	get_data('/do/chg_read',{id:id},function(){
		load_page('/member/msg');
	})
}
</script>
@endsection