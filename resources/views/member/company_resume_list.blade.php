<?php
$job_info = \App\Cm::where('id',$id)->first() ; 
$conts = json_decode($job_info->cont) ; 
$mid = explode(',',$job_info->tags) ;
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
.msgs>li{
	position: relative;
	background-color: #fff;
	margin-bottom: 20px;
	padding:20px;
}
.msgs a{
	color: #02b6c1;
}
.msgs .text{
	padding: 20px;
}
.btn-mstatus{
	text-align:right;
	display: inline-block;
}
.btns{
	height: 36px;
	position: absolute;
	right: 10px;
	top: 10px;
}
.btns a{
	margin-left: 10px;
}
</style>
<section class="member">
	@include('member.menu')
	<div class="breadcrumb">
		<a href="/member/company">會員專區</a> &gt; <a class="name" href="/member/company_resume_view">徵才資訊</a> &gt; <a class="name" href="">{{$conts->job_title}} 職缺</a>
	</div>
	<div class="msg-content bg-gray">
		<ul class="msgs">
		
		@foreach($mid as $rd)
			@if($rd)
				<?php
				$rs = explode('+',$rd) ;
				$member = \App\Members::where('id', $rd)->first();
				$resume = \App\Cm::where('position', 'resume')->where('up_sn',$member->id)->first();
				$rdata = json_decode($resume->cont);
				?>
				<li class="flex">
					<div class="smember">
						<div class="avatar">
							<div class="img"><a href="/resume/{{$resume->id}}"><img src="{{\App\Members::get_pic($rs[0])}}" alt=""></a></div>
							<!-- <h4>{{$member->sname? $member->sname : $member->name}}</h4> -->
						</div>
					</div>
					<div class="text">
						<ul>
							<li>姓名:<a href="/resume/{{$resume->id}}">{{$member->name}}</a></li>
							<li>投遞時間：{{$rs[1]}}</li>
							<li>學歷：
								@if(\App\Funcs::chk_ary($rdata->schools))
								@foreach($rdata->schools as $k => $school)
								{{$school->name}} {{$school->department}} {{$k==sizeof($rdata->schools)-1?'':'、'}}
								@endforeach
								@endif
							</li>
							<li>居住地：{{$rdata->address}}</li>
							<li>聯絡電話：{{$rdata->tel}}</li>
						</ul>
					</div>
					<div class="btns flex">
						<a class="btn-box s r btn-interview" onclick="interview('{{$member->id}}','{{$job_info->id}}')">面試通知</a>
					</div>
				</li>
				@else
				目前尚無人應徵
				@endif
			@endforeach
			
		</ul>
	</div>
	<!-- 面試通知區塊 -->
	<div class="popup popup-add-msg" style="display: none">
		<div class="masklayer"></div>
		<div class="popup_window">
		    <div class="popup_title">
		      <h3>面試通知</h3>
		    </div>
		    <div class="popup_content">
		      	<form action="/do/send_interview" id="send_interview" method="post">
		        	<div class="block">
		          		<h3 class="note">請輸入您要聯絡的內容：</h3>
		          		<ul class="custom-input">
				            <li>
				              <h4 class="ttl">*內容</h4>
				              <textarea name="msg" cols="20" rows="10"></textarea>
				            </li>
		            		<li>
		              			<div class="popup_pad_left"></div>
		              			<input type="hidden" name="_token" value="{{csrf_token()}}">
		              			<input type="hidden" id="mid" name="id" value="">
		              			<input type="hidden" id="jobid" name="jobid" value="">
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
function interview(mid,jobid){
	$('#mid').val(mid);
	$('#jobid').val(jobid) ;
	$('.popup-add-msg').fadeIn();
}
$(function(){
	register_form('#send_interview', function(){
      	$('.popup-add-msg').fadeOut();
    });
    $('.masklayer').click(function(){
      	$(this).parent().fadeOut();
    })
})
</script>
@endsection