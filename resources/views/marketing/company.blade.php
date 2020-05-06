<?php
$bodyid = "page-market";
$comptype_big = \App\Cm::get_company_big_type();
$company_type = \App\Cm::get_company_type();
$wh = ['mstatus'=>'Y','online_status'=>'Y'];
// if($type) $wh['type'] = $type;
if(!isset($type)){
	echo '<script>location.href="/market"</script>';
	exit;
}

$wh['position'] = 'company' ; 
$query = \App\Cm::where($wh);
if($type=='醫療器材'||$type=='製藥產業'||$type=='新興生技'){
	$c_2nd = \App\Cm::get_company_second_type($type);
	$rd = $query->orderby('pic','desc')->paginate(20);
}else{
	$c_2nd = [$type] ; 
	$rd = $query->where('type', 'like', '%'.trim($type).'%')->orderby('pic','desc')->paginate(20);
}

// if($rd->count()==0){
// 	session()->flash('sysmsg', '找不到廠商資料');
// 	echo '<script>alert("查無資料");history.back();</script>';
// 	exit;
// }
?>
@extends('main')
@section('content')	
<section class="manufacturers bg-gray">
	<div class="ttl-bar">
		<h2>通路索引</h2>
		<ul class="tab">
            @foreach($comptype_big as $cb_type)
            <?php
            $comptype_2nd = \App\Cm::get_company_second_type($cb_type); 
            ?>
            <li data-target="cat{{$cb_type}}" class="{{$type==$cb_type||in_array($type,$comptype_2nd)?'active':''}}">
                <a href="/marketing/company/{{$cb_type}}">{{$cb_type}}</a>
                <ul class="submenu" style="background-color:#F6EEBA;">
                    @foreach($comptype_2nd as $st)
                    <li data-target="cat{{$st}}" class="{{$st==$type?'active':''}}">
                        <a href="/marketing/company/{{$st}}">{{$st}}</a>
                    </li>
                    @endforeach
                </ul>
            </li>
            @endforeach
    	</ul>
	</div>
	<div class="breadcrumb">
		<a href="/">首頁</a> &gt; 
		<a href="">行銷專區</a> &gt; 
		<!-- <a href="">合作平台</a> &gt;  -->
		<a href="">通路索引</a>  
		&gt; <a href="/marketing/company/{{$type}}">{{$type}}</a>
	</div>
	<div class="content grid-intro">
		<div class="cat active">
			<ul class="grid4 wrap no-shrink">
				@foreach($rd as $c)
					<?php
					$ctype = explode(',', $c->type) ; 
					?>
					@if(array_intersect($c_2nd,$ctype))
					<li class="swiper-slide">
						<div class="img">
							<a href="/company/{{$c->id}}?bodyid=page-market"><img src="{{\App\Cm::get_pic($c->id)}}" alt=""></a>
						</div>
						<div class="text">
							<h3 class="comp_name">
								<a href="/company/{{$c->id}}?bodyid=page-market" data-compname="{{$c->name}}">[ {{$c->name}} ]</a>
							</h3>
							<p>{{$c->brief}}</p>
							<div class="link">
								<a class="cooperation" data-compid="{{$c->id}}">合作</a>
								<a class="ask" data-compid="{{$c->id}}">詢問</a>
								<a href="/company_hire_list/{{$c->id}}">徵才</a>
							</div>
						</div>	
					</li>
					@endif
				@endforeach
			</ul>
			<div class="pager">
				{{$rd->appends(['id' => request('id'),'q'=>request('q'),'c'=>request('c')])->links()}}
			</div>
		</div>
	</div>
</section>
@endsection
@section('javascript')
@include('popup')
@endsection