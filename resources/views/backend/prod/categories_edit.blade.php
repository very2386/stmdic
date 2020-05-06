<?php
if(!$arg) $arg = 'series';
$title = ['series'=>'品牌系列', 'works'=>'作品角色'];
if(request('id')){
	$rd = \App\Cm::where('id', request('id'))->first();
	if(!$rd){
		session()->flash('sysmsg', '找不到您要編輯的資料');
		echo '<script>location.href="/backend/prod/categories/'.$arg.'"</script>';
		exit;
	}
}else{
	$rd =\App\Cm::new_obj($arg);
}
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
				<a href="/backend/prod/categories/{{$arg}}">{{$title[$arg]}}</a> - 編輯
			</div>
			<div class="card-body">
				<form class="form form-horizontal" id="edit_form" name="edit_form" enctype="multipart/form-data" method="post" action="/do/edit/cm">
					<div class="section">
						<div class="section-title">{{session('lang')}}</div>
						<div class="section-body">
							@if(request('id'))
							<div class="form-group">
								<label class="col-md-3 control-label">變更位置</label>
								<div class="col-md-9">
							  		<select name="position" class="form-control">
							  			<option value="series" {{$rd->position == 'series'?'selected':''}}>品牌/系列</option>
							  			<option value="works" {{$rd->position == 'works'?'selected':''}}>作品/角色</option>
							  		</select>
								</div>
							</div>
							@else
							<input type="hidden" name="position" value="{{$arg}}">
							@endif
							<div class="form-group">
								<label class="col-md-3 control-label">名稱</label>
								<div class="col-md-9">
							  		<input type="text" name="name" class="form-control" placeholder="請輸入名稱" value="{{$rd->name}}">
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">類別</label>
								<div class="col-md-9">
							  		<select name="type" id="type" class="form-control">
							  			<option value="gunpla" {{$rd->type == 'gunpla'?'selected':''}}>GUNPLA</option>
							  			<option value="products" {{$rd->type == 'products'?'selected':''}}>商品</option>
							  		</select>
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
								<label class="col-md-3 control-label">超連結</label>
								<div class="col-md-9">
									<input type="text" name="link" class="form-control" placeholder="請輸入超連結" value="{{$rd->link}}"><div class="small-notes">外站連結請加上 http://</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">連結型態</label>
								<div class="col-md-9">
									<select class="form-control" name="link_type">
										<option value="" >直接開啟</option>
										<option value="_blank" {{$rd->link_type == '_blank' ? 'selected':''}} >另開頁籤</option>
									</select>
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
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
    </div>
</div>
@endsection
@section('javascripts')
<script>
$(function(){
	register_form('#edit_form', function(res){
		load_page('/backend/prod/categories_edit/'+res.data.position+'?id='+res.id);
	});
});

</script>
@endsection