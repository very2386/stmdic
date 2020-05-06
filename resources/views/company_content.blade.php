<?php
if(is_numeric($id)){

	if(isset($_GET['bodyid'])){
		$bodyid = "page-market";
	} 
	\App\Cm::where('id',$id)->increment('hits');
	//點擊率
	$hits = \App\Statistics::where('compid',$id)->where('position','company')->whereDate('updated_at',date('Y-m-d'))->first();
	if($hits){//表示今日已經點擊過
		\App\Statistics::where('id',$hits->id)->increment('hits');
	}else{
		\App\Statistics::create(['compid'=>$id,'position'=>'company','hits'=>1]);
	}


	$rd = \App\Cm::where('id',$id)->first();
	if(!isset($rd->name)){
		session()->flash('sysmsg', '找不到廠商資料');
		echo '<script>location.href="/company"</script>';
		exit;
	}
	$com_expert = \App\Cm::where('up_sn',$id)->where('type','廠商專家')->where('position','compinfo')->where('mstatus','Y')->orderby('id')->get() ; 
	$com_tech = \App\Cm::where('up_sn',$id)->where('type','核心技術')->where('position','compinfo')->where('mstatus','Y')->orderby('id')->get() ;
	$com_prod = \App\Cm::where('up_sn',$id)->where('type','上市產品')->where('position','compinfo')->where('mstatus','Y')->orderby('id')->get() ;
	$com_link = \App\Cm::where('up_sn',$id)->where('type','相關連結')->where('position','compinfo')->where('mstatus','Y')->orderby('id')->get() ;
	$com_law = \App\Cm::where('up_sn',$id)->where('type','法規認證')->where('position','compinfo')->where('mstatus','Y')->orderby('id')->get() ;
	$com_medical = \App\Cm::where('up_sn',$id)->where('type','醫療專利')->where('position','compinfo')->where('mstatus','Y')->orderby('id')->get() ;
	$relation = \App\Cm::get_related($id,'news');
	$t = 0 ; 
}else{
	session()->flash('sysmsg', '找不到廠商資料');
	echo '<script>location.href="/company"</script>';
	exit;
}
?>
@extends('main')
@section('content')	
<section class="manufact">
	<div class="ttl-bar">
		<h2>聚落廠商</h2>
		<!-- <div class="searchbar">
			<input type="search" placeholder="文章搜尋">
			<button class="btn-search">Search</button>
		</div> -->
		
	</div>
	<div class="breadcrumb">
		<a href="/">首頁</a> &gt; <a href="/company">聚落廠商</a> &gt; <a href="/company/{{$id}}">{{$rd->name}}</a>
	</div>
	<div class="content two-side clearfix">
		<div class="side-left active article">
			<h3 class="ttl">{{$rd->name}}</h3>
			<!-- <p class="source">
				<span class="date">2017/8/4</span>
				<span class="time">上午10:00</span>
				<span class="media">聯合</span>
			</p> -->
			<div class="img mb20"><img src="{{\App\Cm::get_pic($rd->id)}}" alt="{{$rd->name}}"></div>
			@if($rd->comptel||$rd->compfax||$rd->email||$rd->addr||$rd->link)
			<section>
				<h4 class="ttl-underline colored">聯絡資料</h4>
				<ul>
					<li>電話：{{$rd->comptel}}</li>
					<li>傳真：{{$rd->compfax}}</li>
					<li>Email：{{$rd->email}}</li>
					<li>公司地址：{{$rd->addr}}</li>
					<li>官網：<a href="http://{{$rd->link}}">{{$rd->link}}</a></li>
				</ul>
			</section>
			@endif
			@if($rd->brief)
			<section>
				<h4 class="ttl-underline colored">廠商簡介</h4>
				<p>{{$rd->brief}}</p>
			</section>
			@endif
			@if(sizeof($com_expert)!=0)
			<section class="profession">
				<h4 class="ttl-underline colored">廠商專家</h4>
				<div class="slider">
					<div class="swiper-container">
						<ul class="swiper-wrapper grid4 no-shrink">
							@foreach($com_expert as $i)
							<li class="swiper-slide">
								<div class="img">
									<a href="expert/{{$i->id}}"><img src="{{\App\Cm::get_pic($i->id)}}" alt=""></a>
								</div>
								<div class="text">
									<h3><a href="javascript:;">{{$i->name}}</a></h3>
									<p>{{$i->brief}}</p>
									<a href="" class="btn-more-box">More</a>
								</div>	
							</li>
							@endforeach
						</ul>
					</div>
					<div class="swiper-button-next black"></div>
					<div class="swiper-button-prev black"></div>
				</div>		
			</section>
			@endif
			@if(count($com_prod)>0)
			<section class="prod">
				<h4 class="ttl-underline colored">上市產品</h4>
				<div class="swiper-container">
					<ul class="swiper-wrapper">
						@foreach($com_prod as $p)
						<li class="swiper-slide flex">
							<div class="img"><img src="{{\App\Cm::get_pic($p->id)}}" alt="{{$p->name}}"></div>
							<div class="text">
								<h5 class="ttl small">{{$p->name}}</h5>
								<p>{{$p->brief}}</p>
							</div>
						</li>
						@endforeach
					</ul>
				</div>
				<div class="swiper-button-next black"></div>
				<div class="swiper-button-prev black"></div>
			</section>
			@endif
			@if(sizeof($com_tech)!=0)
			<section class="core">
				<h4 class="ttl-underline colored">核心技術</h4>
				<div class="slider">
					<div class="swiper-container">
						<ul class="swiper-wrapper grid4 no-shrink">
							@foreach($com_tech as $i)
							<li class="swiper-slide">
								<div class="img">
									<a href=""><img src="{{\App\Cm::get_pic($i->id)}}" alt="{{$i->name}}"></a>
								</div>
								<div class="text">{{$i->name}}</div>
							</li>
							@endforeach
						</ul>
					</div>
					<div class="swiper-button-next black"></div>
					<div class="swiper-button-prev black"></div>
				</div>
			</section>
			@endif
			@if(count($com_medical)>0)
			<section class="link">
				<h4 class="ttl-underline colored">醫療專利</h4>
				<div class="slider">
					<div class="swiper-container">
						<ul class="swiper-wrapper grid4 no-shrink">
							@foreach($com_medical as $medical)
							<li class="swiper-slide">
								<div class="img">
									<a href=""><img src="{{\App\Cm::get_pic($medical->id)}}" alt="{{$medical->name}}"></a>
								</div>
								<div class="text">{{$medical->name}}</div>
							</li>
							@endforeach
						</ul>
					</div>
					<div class="swiper-button-next black"></div>
					<div class="swiper-button-prev black"></div>
				</div>
			</section>
			@endif 
			@if(count($com_law)>0)
			<section >
				<h4 class="ttl-underline colored">法規認證</h4>
				<div class="slider">
					<div class="swiper-container">
						<ul class="swiper-wrapper grid4 no-shrink">
							@foreach($com_law as $law)
							<li class="swiper-slide">
								<div class="img">
									<a href=""><img src="{{\App\Cm::get_pic($law->id)}}" alt="{{$law->name}}"></a>
								</div>
								<div class="text">{{$law->name}}</div>
							</li>
							@endforeach
						</ul>
					</div>
					<div class="swiper-button-next black"></div>
					<div class="swiper-button-prev black"></div>
				</div>
			</section>
			@endif 
			@if(count($com_link)>0)
			<section class="link">
				<h4 class="ttl-underline colored">相關連結</h4>
				<div class="slider">
					<div class="swiper-container">
						<ul class="swiper-wrapper grid4 no-shrink">
							@foreach($com_link as $link)
							<li class="swiper-slide">
								<div class="img">
									<a href=""><img src="{{\App\Cm::get_pic($link->id)}}" alt="{{$link->name}}"></a>
								</div>
								<div class="text">{{$link->name}}</div>
							</li>
							@endforeach
						</ul>
					</div>
					<div class="swiper-button-next black"></div>
					<div class="swiper-button-prev black"></div>
				</div>
			</section>
			@endif
		</div>
		<?php
		$jobs = \App\Cm::where('position','comp_resume')->where('up_sn',$id)->inRandomOrder()->limit(3)->get();
		?>
		<div class="side-right right-st1">
			<ul class="job">
				<li>
					<h3 class="ttl">徵才訊息</h3>
					@if($jobs->count()!=0)
						@foreach($jobs as $job)
						<?php
						$comp = \App\Cm::where('id',$job->up_sn)->first();
						$conts = json_decode($job->cont) ;
						?>
						<div class="block">
							<h4>
								{{$conts->job_title}}
							</h4>
							<p>{{$comp->name}}</p>
							<p>工作地點：{{$conts->job_location}}</p>
							<p>工作待遇：{{$conts->job_salary}}</p>
							<p>工作經驗：{{$conts->job_exp}}</p>
							<a onclick="get_job('{{$job->id}}')">我要應徵</a>
						</div>
						@endforeach
					@else
						<div class="block">
							<h4>
								廠商尚未有徵才職缺
							</h4>
						</div>
					@endif
				</li>
			</ul>
		</div>
	</div>
</section>
@endsection
@section('javascript')
@endsection