<?php
$q = '%'.trim(request('q')).'%';
$query = \App\Cm::where('position', 'news')->where('mstatus','Y');
if( request('c') == '全部'){
	$query->where(function($qry) use($q) {
          $qry->where('name', 'like', $q)
            ->orWhere('cont', 'like', $q);
    });
}else{
	if(request('c') == '標題') $c = 'name';
	if(request('c') == '內文') $c = 'cont';
	$query->where($c, 'like', $q);
}
if(isset($type)) $query->where('type', $type);
$rs = $query->paginate(20);
if($rs->count()==0){
	session()->flash('sysmsg', '找不到新聞資料');
	echo '<script>alert("無此新聞資料");history.back();</script>';
	exit;
}
$comprs = \App\Cm::where('position', 'company')->where('name', 'like', $q)->take(3)->get();
$news_type = \App\Cm::get_news_type();
?>
@extends('main')
@section('content')	
<section class="hot">
	<div class="ttl-bar">
		<h2>聚落新知</h2>
		<!-- <ul class="tab">
			<li class=""><a href="/search?q={{request('q').'&c='.request('c')}}">全部新聞</a></li>
			@foreach($news_type as $ns)
			<li class=""><a href="/search/{{$ns}}?q={{request('q').'&c='.request('c')}}">{{$ns}}</a></li>
			@endforeach
		</ul> -->
		@include('searchbar')
	</div>
	<div class="breadcrumb">
		<a href="/">首頁</a> &gt; <a href="">搜尋</a> &gt; <a href="">{{request('q')}}</a>
	</div>
	<div class="content two-side clearfix">
		<div class="side-left active article">
			<ul class="search-list">
				@foreach($rs as $rd)
				<li>
					<h3 class="ttl small"><a href="/news/{{$rd->id}}">{{$rd->name}}</a></h3>
					<p>
						{{$rd->brief}}
					</p>
					<p class="source"><span class="date">{{substr($rd->created_at,0,10)}}</span> <span class="time">{{substr($rd->created_at,11,5)}}</span> <span class="media">{{$rd->up_sn!=0?\App\Cm::get_sourcename($rd->id):''}}</span></p>
				</li>
				@endforeach
			</ul>
			{{$rs->appends(['c'=>request('c'),'q'=>request('q')])->links()}}
		</div>
		<div class="side-right right-st1">
			<ul>
				<li>
					<h3 class="ttl">相關廠商</h3>
					@foreach($comprs as $comprd)
					<div class="img"><img src="{{\App\Cm::get_spic($comprd->id)}}" alt="{{$comprd->name}}"></div>
					<div class="text">
						<h4>{{$comprd->name}}</h4>
						<p>{{$comprd->brief}}
						</p>
					</div>
					@endforeach
				</li>
				
				<!-- <li>
					<h3 class="ttl">相關期刊</h3>
					<div class="text">
						<h4>膽固醇不一定是「吃」來的破除膽固醇4迷思</h4>
						<p>本網站遵守「個人資料保護法」之規範，保障用戶隱私權益，保證不對外公開。但
							依據有關法律規章規定、應司法機關調查要求
							為維護社會公眾利益、事先獲得用戶明確授權及為維護本網站合法權益之情形，不在此限。
						</p>
					</div>
				</li> -->
			</ul>
		</div>
	</div>
</section>
@endsection
@section('javascript')
@endsection