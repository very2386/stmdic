<?php
// if(!session('mid')){
// 	echo "<script>alert('數位影音專區只供會員使用，謝謝');location.href='/'</script>";
// 	exit;
// }

//計算訪客人數
if($id && $id=='數位影音') {
	$hits = \App\Cm::where('position','people')->where('type','video')->value('hits') ; 
	if(!$hits) \App\Cm::where('position','people')->where('type','video')->create(['position'=>'people','type'=>'video','hits'=>1]) ;
	else \App\Cm::where('position','people')->where('type','video')->increment('hits'); 
}


if($id && $id=='數位影音'){
	$bodyid = "page-market";
	$bodyclass = 'page-market' ; 
} 
else $bodyid = "page-event";
$wh = ['position'=>'video', 'mstatus'=>'Y'];
$query = \App\Cm::where($wh) ; 
if($id&& $id!='數位影音'){
	$query = $query->where('type','like','%'.$id.'%');	
}elseif($id&& $id=='數位影音'){
	$query = $query->where('type','like','%'.'行銷專區'.'%');	
}else{
	$query = $query->where('type','!=','行銷專區');	
}

$rd = $query->paginate(20);
if(count($rd)==0){
	session()->flash('sysmsg', '找不到影片資料');
	echo "<script>alert('找不到影片資料');history.back();</script>";
	exit;
}

?>
@extends('main')
@section('content')
<section class="exhibit bg-gray">
	<div class="ttl-bar">
		<h2>{{$id=='數位影音'?$id:'育成專區'}}</h2>
		<?php
		$vtype = \App\Cm::where('position','videotype')->where('mstatus','Y')->where('name','!=','行銷專區')->get() ;
		$cat = 0 ; 
		?>
		@if($id!='數位影音')
		<ul class="tab">
		  	@foreach($vtype as $vt)
		  	<?php
		    $second = \App\Cm::where('position','videotype_2nd')->where('type',$vt->name)->where('mstatus','Y')->get();
    	    foreach($second as $st){
    	    	if($st->name==$id){
    	    		$active[$vt->name] = 'active' ;
    	    		break;
    	    	} 
    	    }
		    ?>
		  	<li class="{{$vt->name==$id||(isset($active[$vt->name])&&$active[$vt->name]=='active')?'active':''}}">
		    	<a href="/video/{{$vt->name}}">{{$vt->name}}</a>
			    <ul class="submenu">
			      	@foreach($second as $st)
			      	<li data-target="cat{{$st->name}}" class="{{$id==$st->name?'active':''}}">
			        	<a href="/video/{{$st->name}}">{{$st->name}}</a>
			      	</li>
			     	@endforeach
			    </ul>
			</li>
			@endforeach
		</ul>
		@endif
	</div>
	<div class="breadcrumb">
		<a href="/">首頁</a> 
		@if($id!='數位影音')&gt; <a href="/video">育成專區</a> @endif
		@if($id) &gt; 
		  	@foreach($vtype as $vt)
			    <?php
			    $second = \App\Cm::where('position','videotype_2nd')->where('type',$vt->name)->where('mstatus','Y')->get();
			    foreach($second as $st){
		      		echo  $st->name==$id ? "<a href='/video/".$vt->name."'>".$vt->name.'</a> &gt;' : '' ;
			    }
			    ?>
			@endforeach
			<a href="/video/{{$id}}">{{$id}}</a>  
		@endif
	</div>
	<div class="content grid-intro">
		<ul class="grid4 wrap no-shrink">
			@foreach($rd as $rs)
			<li>
				<div class="img">
					<!-- <iframe width="100%" height="200" src="https://www.youtube.com/embed/{{$rs->link}}" frameborder="0" allowfullscreen></iframe> -->
					<a href="/video/{{$rs->id}}"><img src="{{\App\Cm::get_pic($rs->id)}}"></a>
				</div>
				<div class="text">
					<h3><a href="/video/{{$rs->id}}">{{$rs->name}}</a></h3>
					<div class="link">
						@if($rs->link_type=='YouTube')
							<a href="/video/{{$rs->id}}">觀看課程</a>
						@else
							<a href="{{$rs->link}}" target="_blank">觀看課程</a>
						@endif
					</div>
				</div>
			</li>
			@endforeach
		</ul>
		<div class="pager">
			{{$rd->appends(['id' => request('id') ])->links()}}
		</div>
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
		var tabLen = $('.submenu-slide .swiper-slide').length;
		if(tabLen<11){
			$('.slide-nav').hide();
		}
	})
</script>
@endsection