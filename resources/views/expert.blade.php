<?php
$type = ($id!='') ? $id : '' ;
$wh = ['position'=>'expert','mstatus'=>'Y'];
$query = \App\Cm::where($wh);
if($type!=''){
	if($type!='產學專家') $wh['type'] = $type ; 
}elseif(request('c')||request('t')){
	$q = '%'.trim(request('q')).'%';
	if(request('c')!='全部'&&request('c')){
		$wh['type'] = request('c');
		$query->where('name', 'like', $q);
	}else{
		if(request('t') == '全部'){
			$query->where(function($qry) use($q) {
		          $qry->where('name', 'like', $q)
		            ->orWhere('cont', 'like', $q);
		    });
		}else{
			if(request('t') == '標題') $t = 'name';
			if(request('t') == '內文') $t = 'cont';
			$query->where($t, 'like', $q);
		}
	} 
}
$choose_type = \App\Cm::get_expert_type();
if($type=='產學專家') $rd = $query->whereIn('type',['學界專家','產業專家'])->where($wh)->paginate(18);
else $rd = $query->where($wh)->paginate(18);
if($rd->count()==0){
	session()->flash('sysmsg', '找不到專家資料');
	echo '<script>alert("無此專家資料");history.back();</script>';
	exit;
}
?>
@extends('main')
@section('content')		
<section class="yellow-pages bg-gray">
	<div class="ttl-bar">
		<h2>領域專家</h2>
		<ul class="tab">
			<?php
      		$etype = \App\Cm::get_expert_first();
      		?>
      		<li class="{{$id=='產業專家'||$id=='學界專家'||$id=='產學專家'?'active':''}}">
		        <a href="/expert/產學專家">產學專家</a>
		        <ul class="submenu">
			        @foreach($etype as $et)
			        	<li><a href="/expert/{{$et}}">{{$et}}</a></li>
			        @endforeach
		        </ul>
		    </li>
			@foreach($choose_type as $k => $t) 
				@if( $k!='expert' && $k!='p_expert' )
					<li class="{{$t==$id?'active':''}}"><a href="/expert/{{$t}}">{{$t}}</a></li>
				@endif
			@endforeach
		</ul>
		<form id="searchform" action="/expert" method="get">
    		<div class="searchbar">
				<input type="search" name="q" value="{{request('q')}}" placeholder="專家搜尋">
				<div class="custom-select" target="#search-type">
    				<h5 class="ttl">全部</h5>
    				<ul class="opt">
    					<li>全部</li>
    					<li>標題</li>
    					<li>內文</li>
    				</ul>
    			</div>
    			<input type="hidden" name="t" id="search-type" value="{{request('t')?request('t'):'全部'}}">
				<button type="submit" class="btn-search">Search</button>
			</div>
		</form>
	</div>
	<div class="breadcrumb">
		<a href="/">首頁</a> &gt; <a href="/expert">領域專家</a> 
		@if($type||$type=='') 
			{{$type==''?'':'&gt;'}}
			@if($type=='學界專家'||$type=='產業專家') <a class="name" href="">產學專家</a> &gt; @endif
			<a class="name" href="">{{$id}}</a>
		@else
			&gt; <a class="name" href="">{{request('q')}}</a>
		@endif
	</div>
	<div class="content clearfix">
		<ul class="grid6 wrap no-padding">
			@foreach($rd as $e)
			<li>
				<div class="img">
					<?php
					  $pic_src = \App\Cm::get_pic($e->id);
					  $src = $pic_src=='/images/no_image.gif'?'/img/member_default.png':$pic_src;
					?>
					<a href="/expert/{{$e->id}}"><img src="{{$src}}" alt=""></a>
				</div>
				<div class="text">
					<h3><a href="/expert/{{$e->id}}">{{$e->name}}</a></h3>
					@if($e->type!='服務業者')
		              	@if($e->cont)
		                	<?php
		                	$conts = json_decode($e->cont) ;
		                	?>
		                	@if(isset($conts->unit))
		                  		@foreach($conts->unit as $unit)
		                  		<p>{{$unit}}</p>
		                  		@endforeach
		                	@endif
		                	@if(isset($conts->job_title))
		                  		@foreach($conts->job_title as $job_title)
		                  		<p>{{$job_title}}</p>
		                  		@endforeach
		                	@endif
		              	@endif
		            @else
		              	<p>{{$e->brief}}</p>
		            @endif
					<a href="/expert/{{$e->id}}" class="btn-more-box">More</a>
				</div>
			</li>
			@endforeach
		</ul>
		<div class="pager">
			{{$rd->appends(['id' => request('id'),'c'=>request('c'),'q'=>request('q'),'t'=>request('t')])->links()}}
		</div>
	</div>
</section>
@endsection
@section('javascript')
@endsection