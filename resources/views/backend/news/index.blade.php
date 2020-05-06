<?php
$n = 1 ;
$page = !request('page') ? '0' : request('page')-1  ; 
$nsites = \App\Cm::where('position', 'nsite')->orderBy('name', 'asc')->get();
$nsource = \App\Cm::where('position','nsource')->orderBy('name', 'desc')->get();
$newstype = \App\Cm::get_news_type() ;
?>
@extends('backend.main')
@section('content')
@include('backend._top')
<style type="text/css">
.chgbtnY{
	margin: 5px;
    padding: 5px 10px;
    position: absolute;
    top:-45px;
}
.chgbtnN{
	margin: 5px;
    padding: 5px 10px;
    position: absolute;
    top:-45px;
    left:85px;
}
.search{
	margin: 5px;
    padding: 5px 10px;
}

</style>
<div class="row">
    <div class="col-xs-12">
		<div class="card card-banner no-br">
			<div class="card-header">
			  <div class="card-title">
			    <div class="title">新聞管理</div>
			  </div>
			  <ul class="card-action">
			    <li><a class="btn btn-primary" href="/backend/news/news_edit">新增</a></li>
			  </ul>
			</div>
			<div role="tabpanel" style="position: relative;" id="news">
				<form id="search_form" action="/backend/news/index" method="get">
					<ul class="nav nav-tabs" role="tablist">
				        <li class="news_position" style="margin: 10px;">新聞來源：			
			        		<select name="nsource" id="nsource">
			        			<option value="">請選擇新聞來源</option>
			        			@foreach( $nsites as $nsite )
								<option value="{{$nsite->id}}" {{$nsite->id == request('nsource') ? 'selected':'' }}>{{$nsite->name}}</option>
								@endforeach
							</select>
				        </li>
						<li class="news_position" style="margin: 10px;">上線狀態：
							<select name="ostatus" id="ostatus">
								<option value="">請選擇審核狀態</option>
								<option value="Y" {{request('ostatus')=='Y'?'selected':''}}>上線</option>
								<option value="N" {{request('ostatus')=='N'?'selected':''}}>下線</option>
							</select>	
						</li>
						<li class="news_position" style="margin: 10px;">分類篩選：
							<select name="news_type" id="news_type">
								<option value="">請選擇新聞分類</option>
								@foreach($newstype as $type)
									@if($type!='')
										<option value="{{$type}}" {{$type==request('news_type')?'selected':''}}>{{$type}}</option>
									@endif
								@endforeach
							</select>	
						</li>
						<li class="news_position" style="margin: 10px;">標題搜尋：
							<input type="text" name="news_name" value="{{request('news_name')}}">
						</li>
						<button class="btn btn-primary search">查詢</button>
						<a href="/backend/news/index" class="btn btn-danger search">清除查詢</a>
						<input type="hidden" name="search" value="news">
						<a class="btn btn-primary chgbtnY" onclick="chg_status('Y','{{request('page')}}')">更改上線</a>
						<a class="btn btn-primary chgbtnN" onclick="chg_status('N','{{request('page')}}')">更改下線</a>		
				    </ul>
			    </form>

				<table class="table">
					<thead>
						<tr>
							<th width="3%">
								<input name="news-all" id="news-all" type="checkbox" onchange="news_all()">
							</th>
							<th width="3%">#</th>
							<th style="min-width:110px">置頂</th>
							<th style="min-width:300px">分類</th>
							<th>日期</th>
							<th width="25%">標題</th>
							<th width="25%">圖片</th>
							<th width="10%">上線狀態</th>
							<th>編輯</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$wh = ['position'=>'news','lang'=>session('lang')] ; 
						if(request('search')){
							if(request('nsource')){
								$rd = \App\Cm::where('position', 'nsource')->where('up_sn',request('nsource'))->get();
								$ids=[];
								if($rd){
									foreach($rd as $rs){
										$ids[]=$rs->id;
									}
									$query = \App\Cm::wherein('up_sn',$ids);
								}
							}else{
								$query = \App\Cm::where($wh) ; 
							}
							if(request('ostatus')){
								$whs['mstatus'] = request('ostatus') ;
							}
							if(request('news_type')){
								// $whs['type'] = request('news_type') ;
								$query = $query->where('type','like','%'.trim(request('news_type')).'%');
							}
							if(request('news_name')){
								$query = $query->where('name','like','%'.trim(request('news_name')).'%');
							}
							if(isset($whs)) $query = $query->where($whs);
						}else{
							$query = \App\Cm::where($wh) ;
						}
						$rs = $query->orderBy('psort', 'DESC')->orderBy('id', 'DESC')->paginate(25);
						$t = 0 ;
						if(isset($rs)){
							foreach($rs as $rd):
								$tags = $rd->tags ? explode(',', $rd->tags):[];
								$rdtype = $rd->type ? explode(',',$rd->type):[] ;
						?>
							<tr id="item_row{{$rd->id}}">
								<td>
									<input name="news[]" type="checkbox" value="{{$rd->id}}">
								</td>
								<th scope="row">{{env('PERPAGE')*$page+$n++}}</th>
								<td>
									<input name="psort" id="psort{{$rd->id}}" type="checkbox" value="999" {{$rd->psort=='999'?'checked':''}} onclick="chg_psort('{{$rd->id}}')">
									<label for="psort{{$rd->id}}">置頂</label> &nbsp;
								</td>
								<td>	
								@foreach($newstype as $k => $ntype)
									@if($ntype!='數位影音'&&$ntype!=='')
									<div class="col-xs-6">
										<input type="checkbox" id="comptype{{$rd->id}}_{{$k}}" name="type" value="{{$ntype}}" {{in_array($ntype,$rdtype)?'checked':''}} onclick="chg_type('{{$rd->id}}','{{$ntype}}','{{$k}}')">
										<label for="comptype{{$rd->id}}_{{$k}}" id="comptype{{$rd->id}}_{{$k}}">{{$ntype}}</label> &nbsp;
									</div>
									@endif
								@endforeach
								</td>
								<td>{{substr($rd->sdate,0,10)}}</td>
								<td>{{$rd->name}}</td>
								<td><img src="{{\App\cm::get_news_pic($rd->id)}}" style="height:50px;" /></td>
								<td>{{$rd->mstatus == 'Y' ? '上線':'下線'}}</td>
								<th>
									<a class="btn btn-primary" href="/backend/news/news_edit?id={{$rd->id}}">編輯</a>
									<a class="btn btn-danger" onclick="del_item( 'cms', '{{$rd->id}}');" >刪除</a>
								</th>
							</tr>
						<?php 
						endforeach;
						
						if($rs->count() <= 0):
						?>
							<tr>
								<td colspan="7">
									<div class="empty_data"></div>
								</td>
							</tr>
						<?php endif;?>
					</tbody>
				</table>
				<input type="hidden" name="_token" value="{{csrf_token()}}">
				<div> 
				<?php
					echo $rs->appends(['id'=>request('id'),'nsource'=>request('nsource'),'ostatus'=>request('ostatus'),'news_type'=>request('news_type'),'search'=>request('search')])->links(); 
				?>
				</div>
				<?php } ?>
			</div>
		</div>
    </div>
</div>
@endsection
@section('javascripts')
<script>
$(function(){
	$('.datatable').DataTable({
		"pageLength" : 25,
	});
});
function news_all(){
	var chk = $('#news-all').prop('checked');
	$('input[name="news[]"]').prop('checked', chk);
}
function chg_status(type,page=''){
	var id = "" ;
	var token =  $('#csrf_token').val();
	$('input[name="news[]"]').each(function() {
		if($(this).prop('checked')){
			id += $(this).val()+',';
		}
	})
	get_data('/do/chg_status', {id:id,_token:token,mstatus:type}, function(){
		load_page('/backend/news/index'+(page==''?'':'?page='+page));
	});
}
function chg_type(id,type,$num){
	var check = 'N' ; 
	if($("#comptype"+id+"_"+$num).prop("checked")) check = 'Y' ;
	get_data('/do/chg_newstype', {id:id,type:type,check:check});
}

</script>
@endsection