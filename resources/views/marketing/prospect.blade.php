<?php
$bodyclass = 'page-market' ; 

//若已過期的未來展會就歸類到目前展會
\App\Prospects::where('position','fprospect')->where('edate','<',date('Y-m-d'))->update(['position'=>'prospect']) ;

//計算訪客人數
$hits = \App\Cm::where('position','people')->where('type',$type)->value('hits') ; 
if(!$hits) \App\Cm::where('position','people')->where('type',$type)->create(['position'=>'people','type'=>$type,'hits'=>1]) ;
else \App\Cm::where('position','people')->where('type',$type)->increment('hits'); 

if($type=='prospect') $year = request('year') ? request('year') : date('Y') ; 
else $year = request('year') ? request('year') : date('Y') ; 
$wh = ['position'=>$type,'status'=>'Y'];
$bodyid="page-market";
?>
@extends('main')
@section('content')		
<section class="hot">
	<div class="ttl-bar">
		<h2>{{$type=='prospect'?'目前展會':'未來展會'}}</h2>
	</div>
	<div class="breadcrumb">
		<a href="/market">首頁</a> &gt; 
		<a href="javascript:;">展會相關</a> &gt; 
		<a href="/marketing/prospect/{{$type}}">{{$type=='prospect'?'目前展會':'未來展會'}}</a> 
	</div>
	<div class="content clearfix prospect">
		<div style="margin-left: 15px;">年份：
			<select class="year-select" name="" id="">
			@if($type=='prospect')
				@for($i=date('Y');$i>=2017;--$i)
					<option value="{{$i}}" {{$year==$i?'selected':''}}>{{$i}}</option>
				@endfor
			@else
				@for($i=date('Y');$i<=(date('Y')+5);++$i)
					<option value="{{$i}}" {{request('year')==$i?'selected':''}}>{{$i}}</option>
				@endfor
			@endif
			</select>
		</div>
		<?php
		$data_year = \App\Prospects::where($wh)->whereYear('date',date($year))->get()->count();
		?>
		@if($data_year>0)
		<ul class="title">
			<li class="domestic">國內展會</li>
			<li class="overseas">國外展會</li>
		</ul>
		<dl class="record">
			@for($m=12;$m>0;--$m)
				<?php
				$data_month = \App\Prospects::where($wh)->whereYear('date',date($year))->whereMonth('date',str_pad($m,2,"0",STR_PAD_LEFT))->get()->count();
				?>
				@if($data_month>0)
					<dt class="month">{{$m}}月</dt>
					@for($d=31;$d>0;--$d)
						<?php
						$rs = \App\Prospects::where($wh)->whereDate('date',date($year.'-'.str_pad($m,2,"0",STR_PAD_LEFT).'-'.str_pad($d,2,"0",STR_PAD_LEFT)))->orderBy('date','DESC')->get();
						$idata = [] ; 
						$odata = [] ;
						foreach($rs as $rd){
							if($rd->type=='國內展會'){
								$idata[] = $rd ; 
							}else{
								$odata[] = $rd ; 
							}
						}
						?>
						@if(!empty($idata)||!empty($odata))
						<dd>
							<h3 class="date">{{$m}}/{{$d}}</h3>
							<ul>
							@if(!empty($idata))
								<li class="domestic">
									<h3>{{$m}}/{{$d}}</h3>
									<ul>
									@foreach($idata as $rd)
										<li><a href="/marketing/prospect/{{$type}}/{{$rd->id}}">{{$rd->name}}</a></li>
									@endforeach
									</ul>
								</li>
							@endif
							@if(!empty($odata))
								<li class="overseas">
									<h3>{{$m}}/{{$d}}</h3>
									<ul>
									@foreach($odata as $rd)
										<li><a href="/marketing/prospect/{{$type}}/{{$rd->id}}">{{$rd->name}}</a></li>
									@endforeach
									</ul>
								</li>
							@endif
							</ul>	
						</dd>
						@endif
					@endfor
				@endif
			@endfor
			<dt class="year">{{$year}}</dt>
		</dl>
		@else
		<p class="t-center">目前無該年份展會相關資料</p>
		@endif	
	</div>
	<input type="hidden" id="ptype" value="{{$type}}">
</section>
@endsection
@section('javascript')
<script>
	$(function(){
		$('.prospect .record dd>ul').each(function(){
			var len = $(this).find('>li').length;
			if(len > 1){
				var dLen = $(this).find('.domestic li').length;
				var oLen = $(this).find('.overseas li').length;
				var $abs = $(this).find('.domestic');
				var pt = 30;
				if(oLen < dLen){
					$abs = $(this).find('.overseas');
				}
				var aHeight = $abs.height();
				var rHeight = $abs.siblings().height();
				var t = (rHeight - aHeight) / 2;
				console.log(rHeight)
				$abs.css({
					'position':'absolute',
					'top':30 + t + 'px'
				});
			}
		});
		$('.year-select').on('change',function(){
			var year = $(this).val();
			var type = $('#ptype').val();
			load_page('/marketing/prospect/'+type+'?year='+year);
		});
	})
</script>
@endsection