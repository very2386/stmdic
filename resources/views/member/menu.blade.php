<?php
$mrd = \App\Members::where('id', session('mid'))->first();
$msg_counts = \App\Msg::where('to_mid', session('mid'))->where('mstatus','N')->count();
?>
<div class="ttl-bar member_menu">
	<h2>會員專區</h2>
	<ul class="tab"> 
		@if($mrd->type!='醫材廠商')
			<li class="{{ $page == 'index' || $page == 'edit' ? 'active' : '' }}"><a href="/member/index">基本資料</a></li>
		@endif
		@if($mrd->type=='醫材廠商')
			<li class="{{ $page == 'edit' ? 'active' : '' }}"><a href="/member/edit">廠商資料</a></li>
			<li class="{{ $page == 'prods' || $page == 'prods_edit'? 'active' : '' }}"><a href="/member/prods">上市產品</a></li>
		@endif
			<li class="{{ $page == 'posts' ? 'active' : '' }}"><a href="/member/posts">論壇文章</a></li>
			<li class="{{ $page == 'event' ? 'active' : '' }}"><a href="/member/event">活動行事曆</a></li>
			
		@if($mrd->type!='醫材廠商')
			<!-- <li class="{{ $page == 'resume_view' ? 'active' : '' }}"><a href="/member/resume_view">求職資訊</a></li> -->
		@else
			<li class="{{ $page == 'company_resume_view' || $page == 'company_hire_edit' || $page == 'company_resume_list' ? 'active' : '' }}"><a href="/member/company_resume_view">徵才資訊</a></li>
			<li class="{{ $page == 'company' ? 'active' : '' }}"><a href="javascript:;">行銷分享</a></li>
			<li class="{{ $page == 'statistics' ? 'active' : '' }}"><a href="/member/statistics">訪客分析</a></li>
		@endif
		<li class="{{ $page == 'msg' ? 'active' : '' }}">
			<a href="/member/msg">站內通知
				<div class="msg_count">{{$msg_counts}}</div>
			</a>
		</li>
	</ul>
	<!-- <a class="btn btn-logout" href="/member/logout">登出</a> -->
</div>