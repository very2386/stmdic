<?php
if(request('id')){
	$rd = \App\Cm::where('id', request('id'))->first();
	if(!$rd){
		session()->flash('sysmsg', '找不到您要編輯的資料');
		echo '<script>location.href="/backend/funto/index"</script>';
		exit;
	}
}else{
	$rd = \App\Cm::new_obj('funto');
}
$specs  = (object)['age'=>'','place'=>'', 'date'=>'', 'class'=>'', 'tool'=>'', 'price'=>''];
if($rd->specs) $specs = json_decode($rd->specs);
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
				<a href="/backend/funto/index">模型教室</a> - 編輯
			</div>
			<div class="card-body">
				<form class="form form-horizontal" id="news_edit_form" name="news_edit_form" enctype="multipart/form-data" method="post" action="/do/edit/cm">
					<div class="section">
						<div class="section-title">{{session('lang')}}</div>
						<div class="section-body">
							<div class="form-group">
								<label class="col-md-3 control-label">日期</label>
								<div class="col-md-9">
							  		<input type="text" name="sdate" class="form-control" placeholder="請輸入標題" value="{{$rd->sdate}}">
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">標題</label>
								<div class="col-md-9">
							  		<input type="text" name="name" class="form-control" placeholder="請輸入標題" value="{{$rd->name}}">
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-3">
									<label class="control-label">說明</label>
									<p class="control-label-help">( 請輸入說明，最多100字 )</p>
								</div>
								<div class="col-md-9">
									<textarea id="brief" name="brief" class="form-control">{!!$rd->brief!!}</textarea>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">排序</label>
								<div class="col-md-9">
							  		<input type="text" name="psort" class="form-control" placeholder="請輸入排序" value="{{$rd->psort}}"><div class="small-notes">數字越大越前面</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">列表圖片(小)</label>
								<div class="col-md-9">
									@if(request('id'))
										<div class="image-preview">
											<img src="{{\App\Cm::get_spic($rd->id)}}" style="max-width:100%; max-height:300px" />
										</div>
									@endif
									<div class="input-group">
								    	<input type="file" name="spicfile" class="form-control" aria-label="上傳圖片">
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">圖片</label>
								<div class="col-md-9">
									@if(request('id'))
										<div class="image-preview">
											<img src="{{\App\Cm::get_pic($rd->id)}}" style="max-width:100%; max-height:300px" />
										</div>
									@endif
									<div class="input-group">
								    	<input type="file" name="picfile" class="form-control" aria-label="上傳圖片">
									</div>
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
							<div class="form-group">
								<label class="col-md-3 control-label">適合年齡</label>
								<div class="col-md-9">
							  		<input type="text" name="specs[age]" class="form-control" placeholder="請輸入年齡" value="{{$specs->age}}">
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">課程地點</label>
								<div class="col-md-9">
							  		<input type="text" name="specs[place]" class="form-control" placeholder="請輸入地點" value="{{$specs->place}}">
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">課程日期</label>
								<div class="col-md-9">
							  		<input type="text" name="specs[date]" class="form-control" placeholder="請輸入日期" value="{{$specs->date}}">
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">課程場次</label>
								<div class="col-md-9">
							  		<textarea id="specs[class]" name="specs[class]" class="form-control" placeholder="請輸入課程場次">{!!$specs->class!!}</textarea>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">使用工具及耗材</label>
								<div class="col-md-9">
							  		<textarea id="specs[tool]" name="specs[tool]" class="form-control" placeholder="請輸入使用工具及耗材">{!!$specs->tool!!}</textarea>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">課程費用</label>
								<div class="col-md-9">
							  		<textarea id="specs[price]" name="specs[price]" class="form-control" placeholder="請輸入課程費用">{!!$specs->price!!}</textarea>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-3">
									<label class="control-label">內容</label>
									<p class="control-label-help">( 請輸入內容，最多2000字 )</p>
									<button type="button" class="btn btn-success" onclick="load_media('{{request('id')}}', 'funto')">媒體庫</button>
								</div>
								<div class="col-md-9">
									<textarea id="pcontent" name="cont">{!!$rd->cont!!}</textarea>
									<script>CKEDITOR.replace( 'pcontent', { height:500 } );</script>
								</div>
							</div>
						</div>
					</div>
					<div class="form-footer">
						<div class="form-group">
							<div class="col-md-9 col-md-offset-3">
								<button type="button" onclick="edit_form_submit('#news_edit_form')" class="btn btn-primary">儲存</button>
								<a class="btn btn-default" href="{{session('BACKPAGE')}}">回上一頁</a>
								<input type="hidden" name="_token" value="{{csrf_token()}}">
								<input type="hidden" name="id" value="{{request('id')}}">
								<input type="hidden" name="lang" value="{{$rd->lang ? $rd->lang : session('lang')}}">
								<input type="hidden" name="position" value="funto">
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
    </div>
</div>
@include('backend._modalMedia')
@endsection
@section('javascripts')
<script>
$(function(){
	register_form('#news_edit_form', function(res){
		load_page('?id='+res.id);
	});
});

</script>
@endsection