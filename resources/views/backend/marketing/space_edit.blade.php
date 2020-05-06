<?php

$rd = \App\Cm::where('position','space')->first();
if(!$rd) $rd =\App\Cm::new_obj();
$id = request('id') ? request('id') : $rd->id ;
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
.del_file{
	padding: 5px;
    position: absolute;
    top: 0px;
    right: 0px;
}
</style>
<div class="row">
    <div class="col-xs-12">
		<div class="card">
			<div class="card-header">
				<a href="">醫材展示室-空間介紹</a> - 編輯
			</div>
			<div class="card-body">
				<form class="form form-horizontal" id="edit_form" name="edit_form" enctype="multipart/form-data" method="post" action="/do/edit/cm">
					<div class="section">
						<div class="section-title">{{session('lang')}}</div>
						<div class="form-group">
							<label class="col-md-2 control-label">標題</label>
							<div class="col-md-10">
						  		<input type="text" name="name" class="form-control" placeholder="請輸入標題" value="{{$rd->name}}">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label">圖片(多張)</label>
							<div class="col-md-10">
								@if($id)
									<?php
									$files = \App\OtherFiles::where('position','space')->where('cm_id',$id)->get();
									?>
									@foreach($files as $rs)
									<div class="image-preview col-md-3" style="padding: 5px;" id="item_row{{$rs->id}}">
										<img src="{{$rs->fname}}" style="max-width:100%; max-height:300px" />
										<a class="btn btn-danger del_file" onclick="del_item('otherfiles','{{$rs->id}}')">X</a>
									</div>
									@endforeach
								@endif
								<div class="input-group">
							    	<input type="file" name="other_files[]" class="form-control" aria-label="上傳圖片" multiple>
								</div>
							</div>
						</div>
						<div class="section-body">
							<div class="form-group">
								<div class="col-md-2">
									<label class="control-label">內容</label>
									<p class="control-label-help">( 請輸入內容，最多2000字 )</p>
									<!-- <button type="button" class="btn btn-success" onclick="load_media('{{request('id')}}', 'about')">媒體庫</button> -->
								</div>
								<div class="col-md-10">
									<textarea id="pcontent" name="cont">{!!$rd->cont!!}</textarea>
									<script>CKEDITOR.replace( 'pcontent', { height:500 } );</script>
								</div>
							</div>
						</div>
					</div>
					<div class="form-footer">
						<div class="form-group">
							<div class="col-md-9 col-md-offset-3">
								<button type="button" onclick="edit_form_submit('#edit_form')" class="btn btn-primary">儲存</button>
								<a class="btn btn-default" href="{{session('BACKPAGE')}}">回上一頁</a>
								<input type="hidden" name="_token" value="{{csrf_token()}}">
								<input type="hidden" name="id" value="{{$id}}">
								<input type="hidden" name="lang" value="{{$rd->lang ? $rd->lang : session('lang')}}">
								<input type="hidden" name="position" value="space">
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
	register_form('#edit_form', function(res){
		load_page('?id='+res.id);
	});
});
</script>
@endsection