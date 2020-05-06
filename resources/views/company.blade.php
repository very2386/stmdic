<?php
$type = isset($id) ? $id : '' ;
$comptype_big = \App\Cm::get_company_big_type();
$wh = ['mstatus'=>'Y'];
$query = \App\Cm::where($wh);
if(request('q')){
	$q = '%'.trim(request('q')).'%';
	if( request('c') == '全部' ){		
		$query->where(function($qry) use($q) {
	          $qry
	          	->where('name', 'like', $q)
	            ->orWhere('brief', 'like', $q);
	    });
	    $res = $query->whereIn('position',['company','compinfo'])->get();
	    $compid = [] ;
	    foreach ($res as $rs) {
	    	if($rs->position == 'compinfo'){
	    		if(!in_array($rs->up_sn, $compid) ) $compid[] = $rs->up_sn ;
	    	}else{
	    		if(!in_array($rs->id, $compid) ) $compid[] = $rs->id ;
	    	}
	    }
	    $rd = \App\Cm::whereIn('id',$compid)->paginate(20);
	}else{
		if(request('c') == '廠商名稱'||request('c') == '內文內容'){
			$wh['position'] = 'company' ; 
			if(request('c') == '廠商名稱') $c = 'name';
			if(request('c') == '內文內容') $c = 'brief';
			$rd = $query->where($wh)->where($c, 'like', $q)->paginate(20);
		}else if(request('c') == '核心技術'||request('c') == '產品名稱'){
			$wh['type'] = request('c')=='產品名稱'?'上市產品':request('c');
			$wh['position'] = 'compinfo' ;
			$query->where($wh) ; 
			$c = 'name';
			$rs = $query->where($c, 'like', $q)->get();
			$ids = [] ;
			foreach ($rs as $r) {
				$ids[] = $r->up_sn ;
			}
			$rd = \App\Cm::where('position','company')->whereIn('id',$ids)->paginate(20);
		} 
	}
}else{
	if(in_array($type,$comptype_big)){
		$second = \App\Cm::get_company_second_type($type);
		$query->where('position','company') ;
		$t = 0 ;  
		foreach($second as $rs){
			if($t==0) $query->where('type', 'like', '%'.$rs.'%') ;
			else if($rs=='體外診斷') $query->where('type', 'like', '%'.$rs.'%')->where('position','company') ;
			else $query->orwhere('type', 'like', '%'.$rs.'%') ;
			++$t;
		} 
		$rd = $query->orderby('pic','desc')->paginate(20);	
	}else{
		$rd = $query->where($wh)->where('position','company')->where('type','like','%'.$type.'%')->orderby('pic','desc')->paginate(20);
	}
}
if($rd->count()==0){
	session()->flash('sysmsg', '找不到廠商資料');
	echo '<script>alert("查無資料");history.back();</script>';
	exit;
}
?>
@extends('main')
@section('content')	
<section class="manufacturers bg-gray">
	<div class="ttl-bar">
		<h2>聚落廠商</h2>
		<ul class="tab">
            @foreach($comptype_big as $cb_type)
            <?php
            $comptype_2nd = \App\Cm::get_company_second_type($cb_type); 
            ?>
            <li data-target="cat{{$cb_type}}" class="{{$type==$cb_type||in_array($type,$comptype_2nd)?'active':''}}">
                <a href="/company/{{$cb_type}}">{{$cb_type}}</a>
                <ul class="submenu">
                    
                    @foreach($comptype_2nd as $st)
                    <li data-target="cat{{$st}}" class="{{$st==$type?'active':''}}">
                        <a href="/company/{{$st}}">{{$st}}</a>
                    </li>
                    @endforeach
                </ul>
            </li>
            @endforeach
    	</ul>
    	<form id="searchform" action="/company" method="get">
    		<div class="searchbar">
				<input type="search" name="q" value="{{request('q')}}" placeholder="廠商搜尋">
				<div class="custom-select" target="#search-type">
				  <h5 class="ttl">{{request('c')?request('c'):'全部'}}</h5>
				  <ul class="opt">
				    <li>全部</li>
				    <li>廠商名稱</li>
				    <li>內文內容</li>
				    <li>核心技術</li>
				    <li>產品名稱</li>
				  </ul>
				   <input type="hidden" name="c" id="search-type" value="全部">
				</div>
				<button type="submit" class="btn-search">Search</button>
			</div>
		</form>
	</div>
	<div class="breadcrumb">
		<a href="/">首頁</a> &gt; 
		<a href="/company">聚落廠商</a> {{$type!=''||request('q')?'&gt;':'' }} 
		@if(!in_array($type,$comptype_big))
			@foreach($comptype_big as $cb_type)
	            <?php
	            $comptype_2nd = \App\Cm::get_company_second_type($cb_type);
	            echo in_array($type,$comptype_2nd) ? "<a class='name' href='/company/{{$type}}'>".$cb_type.'</a> &gt;':'' ;
	            ?>    
	        @endforeach
        @endif
		<a class='name' href="/company/{{$type}}">{{$type!=''?$type:request('q')}}</a>
	</div>
	<div class="content grid-intro">
		<div class="cat active">
			<ul class="grid4 wrap no-shrink">
				@foreach($rd as $c)
				<li class="swiper-slide">
					<div class="img">
						<a href="/company/{{$c->id}}"><img src="{{\App\Cm::get_pic($c->id)}}" alt=""></a>
					</div>
					<div class="text">
						<h3 class="comp_name">
							<a href="/company/{{$c->id}}" data-compname="{{$c->name}}">[ {{$c->name}} ]</a>
						</h3>
						<p>{{$c->brief}}</p>
						<div class="link">
							<a class="cooperation" data-compid="{{$c->id}}">合作</a>
							<a class="ask" data-compid="{{$c->id}}">詢問</a>
							<a href="/company_hire_list/{{$c->id}}">徵才</a>
						</div>
					</div>	
				</li>
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