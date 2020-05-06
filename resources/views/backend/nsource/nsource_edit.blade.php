<?php
if(request('id')){
	$rd = \App\Cm::where('id', request('id'))->first();
	if(!$rd){
		session()->flash('sysmsg', '找不到您要編輯的資料');
		echo '<script>location.href="/backend/nsource/index"</script>';
		exit;
	}
}else{
	$rd =\App\Cm::new_obj();
}
$nsites = \App\Cm::where('position', 'nsite')->orderBy('name', 'asc')->get();
$news_type = \App\Cm::get_news_type();
?>
@extends('backend.main')
@section('content')
@include('backend._top')
<script src="//cdn.ckeditor.com/4.6.2/full/ckeditor.js"></script>
<style type="text/css">
.tags label{
	display: inline-block;
	padding:5px;
	color:#fff;
	font-weight: normal;
}
</style>
<div class="row">
    <div class="col-xs-12">
		<div class="card">
			<div class="card-header">
				<a href="/backend/nsource/index">新聞來源</a> - 編輯
			</div>
			<div class="card-body">				
				<div class="section">
					<div class="section-title">{{session('lang')}}</div>
					<div class="section-body">
						<div role="tabpanel" style="position: relative;">
						    <!-- Nav tabs -->
						    <ul class="nav nav-tabs" role="tablist">
						        <li class="{{ $arg ? '':'active' }}"><a href="/backend/nsource/nsource_edit?id={{request('id')}}">基本資料</a></li>
								<li class="{{ $arg == 'news' ? 'active':'' }}"><a href="/backend/nsource/nsource_edit/news?id={{request('id')}}">新聞內容</a></li>
						    </ul>
							@if(request('id'))
							<form action="/do/sync" method="post" id="sync_foem">	
								<input type="submit" class="add-btn btn btn-primary" value="立即同步">
								<input type="hidden" name="id" value="{{request('id')}}">
								<input type="hidden" name="_token" value="{{csrf_token()}}">
							</form>
							@endif
						    <!-- Tab panes -->
						    <div class="tab-content">
						        @if(!$arg)
						        <div role="tabpanel" class="tab-pane active" id="home">
									<form class="form form-horizontal" id="edit_form" name="edit_form" enctype="multipart/form-data" method="post" action="/do/edit/cm">
										<div class="form-group">
											<label class="col-md-3 control-label">來源網站</label>
											<div class="col-md-9">
										  		<select class="form-control" name="up_sn" id="up_sn">
										  			@foreach($nsites as $nsite)
										  			<option value="{{$nsite->id}}" {{$nsite->id == $rd->up_sn ? 'selected':'' }}>{{$nsite->name}}</option>
										  			@endforeach
										  		</select>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-3 control-label">新聞來源名稱</label>
											<div class="col-md-9">
										  		<input type="text" name="name" class="form-control" placeholder="請輸入新聞來源名稱" value="{{$rd->name}}">
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-3 control-label">新聞分類</label>
											<div class="col-md-9 tags">
										  		<select name="type" id="type" class="form-control">
										  			@foreach($news_type as $type)
										  				@if($type!='')
										  					<option value="{{$type}}" {{$rd->type == $type ? 'selected' : '' }}>{{$type}}</option>
										  				@endif
										  			@endforeach
										  		</select>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-3 control-label">排序</label>
											<div class="col-md-9">
										  		<input type="text" name="psort" class="form-control" placeholder="請輸入排序" value="{{$rd->psort}}"><div class="small-notes">數字越大越前面</div>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-3 control-label">來源網址</label>
											<div class="col-md-9">
										  		<input type="text" name="link" class="form-control" placeholder="請輸入RSS來源" value="{{$rd->link}}">
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-3 control-label">來源類型</label>
											<div class="col-md-9">
												<select class="form-control" name="link_type" id="link_type">
													<option value="RSS" {{$rd->link_type == 'RSS' ? 'selected':''}}>RSS</option>
													<option value="WEB" {{$rd->link_type == 'WEB' ? 'selected':''}}>一般</option>
												</select>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-3 control-label">狀態</label>
											<div class="col-md-9">
												<div class="radio radio-inline">
													<input type="radio" name="mstatus" id="mstatusY" value="Y" {{$rd->mstatus == 'Y' ? 'checked':''}}>
													<label for="mstatusY">上線</label>
												</div>
												<div class="radio radio-inline">
													<input type="radio" name="mstatus" id="mstatusN" value="N" {{$rd->mstatus == 'N' ? 'checked':''}}>
													<label for="mstatusN">下線</label>
												</div>
											</div>
										</div>
										<div class="form-footer">
											<div class="form-group">
												<div class="col-md-9 col-md-offset-3">
													<button type="submit" class="btn btn-primary">儲存</button>
													<a class="btn btn-default" href="{{session('BACKPAGE')}}">回上一頁</a>
													<input type="hidden" name="_token" value="{{csrf_token()}}">
													<input type="hidden" name="id" value="{{request('id')}}">
													<input type="hidden" name="lang" value="{{$rd->lang ? $rd->lang : session('lang')}}">
													<input type="hidden" name="position" value="nsource">
													<!-- <input type="hidden" name="type" value="link"> -->
												</div>
											</div>
										</div>
									</form>
								</div>
								@elseif($arg == 'news')
								<?php
								$rs = \App\Cm::where('up_sn', request('id'))->orderBy('id', 'desc')->paginate(env('PERPAGE'));
								?>
								<div role="tabpanel" class="tab-pane active" id="news">
									<table class="table">
										<thead>
											<th>#</th>
											<th>同步時間</th>
											<th>分類</th>
											<th>圖片</th>
											<th>標題</th>
											<th>狀態</th>
											<th>檢視</th>
										</thead>
										<tbody>
											@foreach($rs as $rd)
											<?php
											$rdtype = $rd->type ? explode(',',$rd->type):[] ;
											?>
											<tr>
												<td>{{$rd->id}}</td>
												<td>{{$rd->created_at}}</td>
												<td style="width: 20%">
													@foreach($news_type as $k => $ntype)
														@if($ntype!='數位影音' && $ntype!='')
															<input type="checkbox" id="comptype{{$rd->id}}_{{$k}}" name="type" value="{{$ntype}}" {{in_array($ntype,$rdtype)?'checked':''}} onclick="chg_type('{{$rd->id}}','{{$ntype}}','{{$k}}')">
															<label for="comptype{{$rd->id}}_{{$k}}" id="comptype{{$rd->id}}_{{$k}}">{{$ntype}}</label> &nbsp;
														@endif
													@endforeach
												</td>
												<td style="width: 20%"><img src="{{\App\Cm::get_news_pic($rd->id)}}" style="height:50px;" /></td>	
												<td><a style="max-width: 100%;display: inline-block;word-break: break-all;" href="{{$rd->link}}" target="_blank">{{$rd->name}}<br />{{$rd->link}}</a></td>
												<td style="width:15%">
													<input type="radio" id="mstatus-Y{{$rd->id}}" name="type{{$rd->id}}" value="Y" onclick="chg_mstatus('{{$rd->id}}','Y')" {{$rd->mstatus=="Y"?'checked':''}}>
													<label for="mstatus-Y{{$rd->id}}" id="">上線</label> <br>
													<input type="radio" id="mstatus-N{{$rd->id}}" name="type{{$rd->id}}" value="N" onclick="chg_mstatus('{{$rd->id}}','N')" {{$rd->mstatus=="N"?'checked':''}}>
													<label for="mstatus-N{{$rd->id}}" id="">下線</label>
												</td>	
												<td><a class="btn btn-primary" href="/backend/news/news_edit?id={{$rd->id}}">檢視</a></td>
											</tr>
											@endforeach

										</tbody>
									</table>
									<div>{{$rs->appends(['id' => request('id')])->links()}}</div>
								</div>
								@endif
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
    </div>
</div>
@include('backend._modalMedia')
@endsection
@section('javascripts')
<script>
$(function(){
	register_form('#edit_form', function(res){
		load_page('?id='+res.id);
	});
	register_form('#sync_form', function(res){
		location.reload(true);
	});

});
function sync_now(id){
	msgbox_show('正在同步中，請稍候...', '新聞同步作業', function(){
		loadPage('/backend/nsource/nsource_edit/news?id='+id);
	});
	get_data('/api/sync', {id:id}, function(){
		$('#msgbox_content').html('同步完成！請關閉本作業畫面！');
	});
}
function chg_type(id,type,$num){
	var check = 'N' ; 
	if($("#comptype"+id+"_"+$num).prop("checked")) check = 'Y' ;
	get_data('/do/chg_newstype', {id:id,type:type,check:check});
}
function chg_mstatus(id,status){
	get_data('/do/chg_status', {id:id,status:status,type:'one'});
}
</script>
@endsection