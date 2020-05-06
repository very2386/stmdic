<?php
$msg_counts = \App\Msg::where('to_mid', session('mid'))->where('mstatus','N')->count();
$get_company_type = \App\Cm::get_company_type();
$prods = \App\Cm::get_prods_type();

$comptype_big = \App\Cm::get_company_big_type();
$company_type = \App\Cm::get_company_type();

if(session('mid')){
	$mrd = \App\Members::where('id', session('mid'))->first();
}
?>
@if(isset($bodyid) && $bodyid == 'page-market')
<header>
	<div class="width-limiter flex between">
		<h1 class="logo"><a href="/""><img src="/img/logo.png" alt=""></a></h1>
		<nav class="">
			<ul class="flex">
				<li>
					<a href="/market">行銷專區</a>
					<ul class="submenu">
						<li>
							<a href="javascript:;">通路索引</a>
						    <ul class="submenu">
						    	@foreach($comptype_big as $cb_type)
						        <li data-target="cat" >
						            <a href="/marketing/company/{{$cb_type}}">{{$cb_type}}</a>
						            <!-- <?php
						            $comptype_2nd = \App\Cm::get_company_second_type($cb_type); 
						            ?>
						            <ul class="submenu">
						            	@foreach($comptype_2nd as $st)
						            	<li data-target="cat{{$st}}">
						            	    <a href="/marketing/company/{{$st}}">{{$st}}</a>
						            	</li>
						            	@endforeach
									</ul> -->
						        </li>
						        @endforeach
						    </ul>
							
						</li>
						<li class="s2">
							<a href="javascript:;">媒體曝光</a>
							<ul class="submenu">
								<li><a href="/information/domestic?type=marketing">國內媒體</a></li>
								<li><a href="/information/foreign?type=marketing">國外媒體</a></li>
							</ul>
						</li>
						<li class="s2">
							<a href="/files?type=marketing">文宣下載</a>
						</li>
					</ul>
				</li>
				<li>
					<a href="javascript:;">聚落產品</a>
					<ul class="submenu">
						@foreach($prods as $rs)
						<li><a href="/marketing/marketing/{{$rs}}">{{$rs}}</a></li>
						@endforeach
					</ul>
				</li>
				<li>
					<a href="javascript:;">展示平台</a>
					<ul class="submenu">
						<li>
							<a href="/marketing/space">醫材展示室</a>
						</li>
						<li><a href="/marketing/product_experience">產品體驗</a></li>
						<!-- @if(isset($mrd)&&$mrd->type=='醫材廠商') -->
						<!-- @endif -->
						<li><a href="/video/數位影音">數位影音</a></li>
					</ul>
				</li>
				<li>
					<a href="javascript:;">展會相關</a>
					<ul class="submenu">
						<li><a href="/marketing/prospect/prospect">目前展會</a></li>
						<li><a href="/marketing/prospect/fprospect">未來展會</a></li>
					</ul>
				</li>
				<li><a href="/member/index">廠商資料</a></li>
			</ul>
		</nav>
	</div>
</header>
@else
<header>
	<div class="width-limiter flex between">
		<h1 class="logo"><a href="/""><img src="/img/logo.png" alt=""></a></h1>
		<nav class="">
			<ul class="flex">
				<li class="news">
					<a href="javascript:;">最新消息</a>
					<ul class="submenu">
						<li><a href="/event">近期活動</a></li>
						<li><a href="/news">聚落新知</a></li>
						<li class="s2">
							<a href="javascript:;">媒體曝光</a>
							<ul class="submenu">
								<li><a href="/information/domestic">國內媒體</a></li>
								<li><a href="/information/foreign">國外媒體</a></li>
							</ul>
						</li>
					</ul>
				</li>
				<li>
					<a href="javascript:;">聚落專區</a>
					<ul class="submenu">
						<li><a href="/job">企業徵才</a></li>
						<li><a href="/about">聚落介紹</a></li>
						<li><a href="/company">聚落廠商</a></li>
						<li><a href="/expert">領域專家</a></li>
					</ul>
				</li>
				<li>
					<a href="javascript:;">計畫專區</a>
					<ul class="submenu">
						<li><a href="/about/plan_announce">計畫公告</a></li>
						<li><a href="/about/plan_intro">計畫介紹</a></li>
						<li><a href="http://plan.ssbmic.org.tw/WebPage/LoginWeb.aspx" target="_blank">計畫管考</a></li>
						<li><a href="/video">育成專區</a></li>
						<li><a href="/files">文件下載</a></li>
					</ul>
				</li>
				<li>
					<a href="/market">行銷專區</a>
					<!-- <ul class="submenu">
						<li>
							<a href="javascript:;">聚落產品</a>
							<ul class="submenu">
								@foreach($get_company_type as $rs)
								<li><a href="/marketing/marketing/{{$rs}}">{{$rs}}</a></li>
								@endforeach
							</ul>
						</li>
						<li>
							<a href="javascript:;">展會相關</a>
							<ul class="submenu">
								<li><a href="/marketing/prospect/fprospect">未來展會</a></li>
								<li><a href="/marketing/prospect/prospect">目前展會</a></li>
							</ul>
						</li>
						<li>
							<a href="javascript:;">合作平台</a>
							<ul class="submenu">
								<li><a href="/marketing/cooperation">產醫合作</a></li>
								<li><a href="javascript:;">合作聯繫</a></li>
								<li>
									<a href="javascript:;">通路索引</a>
									<ul class="submenu">
										@foreach($get_company_type as $rs)
										<li><a href="/marketing/company/{{$rs}}">{{$rs}}</a></li>
										@endforeach
									</ul>
								</li>
							</ul>
						</li>
						<li>
							<a href="javascript:;">展示平台</a>
							<ul class="submenu">
								<li>
									<a href="javascript:;">醫材展示室</a>
									<ul class="submenu">
										<li><a href="/marketing/space">空間介紹</a></li>
										@if(isset($mrd)&&$mrd->type=='醫材廠商')
										<li><a href="/marketing/booking">預約使用</a></li>
										@endif
										<li><a href="/marketing/showroom/展示室活動">展示室活動</a></li>
									</ul>
								</li>
								<li><a href="/marketing/product_experience">產品體驗</a></li>
								<li><a href="/video">數位影音</a></li>
							</ul>
						</li>
						<li>
							@if(isset($mrd))
							@if($mrd->type=='醫材廠商')
							<li><a href="/member/edit">廠商資料</a></li>
							@else
							<li><a href="/member/index">廠商資料</a></li>
							@endif
							@else
							<a href="/member/index">廠商資料</a>
							@endif
						</li>
					</ul> -->
				</li>
				<li class="smember">
					@if(session('mid'))
					<a class="avatar">
						<span class="img">
							<img src="{{\App\Members::get_pic(session('mid'))}}" alt="">
							@if($msg_counts!=0)
							<span class="mess_counts">
								{{$msg_counts}}
							</span>
							@endif
						</span>	
					</a>
					<ul class="submenu">
						@if($mrd->type=='醫材廠商')
						<li><a href="/member/edit">會員中心</a></li>
						@else
						<li><a href="/member/index">會員中心</a></li>
						@endif
						<li><a href="/member/logout">登　　出</a></li>
					</ul>
					<!--<a href="/member/logout">登出</a>-->
					@else
					<a href="javascript:;" onclick="after_login()">登入</a>
					@endif
				</li>
			</ul>
		</nav>
	</div>
</header>
@endif
<script type="text/javascript">
	function after_login(){
		var url = location.pathname ;
		get_data('/do/after_login',{url:url},function(){
			load_page('/member/index') ;
		});

	}
</script>