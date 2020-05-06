<?php
$type = isset($id) ? $id : '' ;
$news_type = \App\Cm::get_news_type();
// if($type!='智慧物聯'&&!in_array($type,$news_type)){
// 	session()->flash('sysmsg', '找不到新聞資料');
// 	echo '<script>location.href="/"</script>';
// 	exit;
// }
// else{
// 	$wh = ['position'=>'news', 'mstatus'=>'Y','type'=>$type];
// 	$query = \App\Cm::where($wh);
// 	if(request('sort')&&request('sort')=='hot') $query->orderby('hits','desc');
// 	else $query->orderby('id','desc');
// 	$news = $query->paginate(env('NEWS_PERPAGE'));
// 	if(!$news){
// 		session()->flash('sysmsg', '找不到新聞資料');
// 		echo '<script>location.href="/"</script>';
// 		exit;
// 	}
// }
$bodyid = 'page-news';
$sort_class="sort";
$sort_array = ['new'=>'最新','hot'=>'熱門'];
$cur_sort = '請選擇';
if(request('sort') == 'new' || request('sort') == 'hot' ) $cur_sort = $sort_array[request('sort')];
?>
@extends('main')
@section('content')		
<section class="news-index">
	<div class="ttl-bar">
		<h2>聚落新知</h2>
		<ul class="tab">
			@foreach($news_type as $ns)
			@if($ns!='')
			<li class="{{$type==$ns?'active':''}}"><a href="/news/{{$ns}}">{{$ns}}</a></li>
			@endif
			@endforeach
		</ul>
		@include('searchbar')
		<!-- <div class="searchbar">
			<input type="search" placeholder="新聞搜尋">
			<button class="btn-search">Search</button>
		</div> -->
	</div>
	<div class="breadcrumb">
		<a href="/">首頁</a> &gt; 
		<a href="/news">聚落新知</a>
		@if($type!='')
		&gt; 
		<a class="name" href="/news/{{$type}}">{{$type}}</a>
		@endif
		@include('sort')
	</div>
	<div class="content clearfix">
		@if($type=='')
		<div class="home cat active all">
			<ul>
				@foreach($news_type as $ntype)
				@if($ntype=='') @continue @endif
				<?php
				$wh = ['position'=>'news','mstatus'=>'Y'];
				$two_news = \App\Cm::where($wh)->where('type','like','%'.$ntype.'%')->where('pic','!=','')->orderBy('created_at','DESC')->limit(2)->get(); 
				$no_pic_news = \App\Cm::where($wh)->where('type','like','%'.$ntype.'%')->where('pic','')->orderBy('created_at','DESC')->limit(9)->get();
				if($no_pic_news->count()<9){
					$other_news = \App\Cm::where($wh)->where('type','like','%'.$ntype.'%')->orderBy('created_at','DESC')->limit(9-$no_pic_news->count())->get();
				} 
				?>
				<li>
					<h3>{{$ntype}}</h3>
					<div class="news-wrap">
						<div class="left">
							<ul class="tp flex grid2">
								@foreach($two_news as $news)
								<li>
									<div class="img" style="height: 231.177px;"><a href="/news/{{$news->id}}"><img src="{{\App\Cm::get_news_pic($news->id)}}" class="ok ow346.766 wider" style="margin-top: 21.5027px;"></a></div>
									<div class="text">
										<a href="/news/{{$news->id}}">{{$news->name}}</a>
										<p class="source"><span class="date">{{$news->created_at}}</span> <span class="from">{{$news->up_sn!=0?\App\Cm::get_sourcename($news->id):''}}</span></p>
									</div>
								</li>
								@endforeach
							</ul>
						</div>
						<div class="right">
							<ul class="text">
								@foreach($no_pic_news as $news)
								<li>
									<span class="name">
										<a href="/news/{{$news->id}}">{{$news->name}}</a>
									</span>
								</li>
								@endforeach
								@foreach($other_news as $news)
								<li>
									<span class="name">
										<a href="/news/{{$news->id}}">{{$news->name}}</a>
									</span>
								</li>
								@endforeach
							</ul>
							<a href="/news/{{$ntype}}" class="btn-more">More...</a>
						</div>
					</div>
				</li>
				@endforeach
			</ul>
		</div>

		@else
		<?php
		$wh = ['position'=>'news', 'mstatus'=>'Y'];
		$query = \App\Cm::where($wh)->where('type','like','%'.$type.'%');
		if(request('sort')&&request('sort')=='hot') $query->orderby('hits','desc');
		else {
			$news = $query->orderby('pic','desc')->orderby('created_at','DESC')->paginate(6);
			$no_pic = $query->orderby('pic','ASC')->orderby('created_at','DESC')->paginate(10);
		}
		$hot_news = \App\Cm::where($wh)->orderby('hits','desc')->orderBy('pic','DESC')->limit(2)->get();
		?>
		<div class="cat active hot-articles">
			<div class="content two-side news-wrap news-inner">
				<div class="side-left">
					<ul class="grid2 spacing15 no-padding wrap">
						@foreach($news as $n)
						<li>
							<a href="/news_content/{{$n->id}}">
								<span class="img"><img src="{{\App\Cm::get_news_pic($n->id)}}"></span>	
								<span class="text">{{$n->name}}</span>
							</a>
							<p class="source"><span class="date">2018-03-20 09:27:24</span> <span class="from">Omed</span></p>
						</li>
						@endforeach
					</ul>
				</div>
				<div class="side-right">
					<ul>
						<li class="ca">
							<div class="text">
								<ul>
									@foreach($no_pic as $rd)
									<li><a href="/news_content/{{$rd->id}}">{{$rd->name}}</a></li>
									@endforeach
								</ul>
							</div>
						</li>				
						<li class="hot-post">
							<h3 class="ttl">熱門討論文章</h3>
							<div class="posts">
								<ul>
									@foreach($hot_news as $rd)
									<li>
										<a href="/news_content/{{$rd->id}}">
											<span class="img" style="height: 285px;">
												<img src="{{\App\Cm::get_news_pic($rd->id)}}" style="max-width: none; height: 352.109px; width: 100%; margin-top: -33.547px;">
											</span>	
											<span class="text">{{$rd->name}}</span>
										</a>
									</li>
									@endforeach
									
								</ul>
							</div>	
						</li>			
					</ul>
				</div>
			</div>
			<div class="pager" style="text-align: center;">
				{{$news->appends(['id' => request('id') ])->links()}}
			</div>
		</div>
		@endif
	</div>
</section>
@endsection
@section('javascript')
<script type="text/javascript">
	$(function(){
		$('.custom-select .opt li').click(function(){
			var sortby = $(this).data('sort');
			location.href=$('#current_url').val() +'?sort=' +sortby ;
		});
	})
</script>
@endsection