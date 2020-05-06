<?php
$rd = \App\Cm::where('position','market_video')->first();
if(!$rd) $rd = \App\Cm::new_obj();
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
				<a href="">行銷專區-首頁影片管理</a> - 編輯
			</div>
			<div class="card-body">
				<form class="form form-horizontal" id="edit_form" name="edit_form" enctype="multipart/form-data" method="post" action="/do/edit/cm">
					<div class="section">
						<div class="section-title">{{session('lang')}}</div>
						<div class="form-group">
							<label class="col-md-2 control-label">YouTube連結</label>
							<div class="col-md-10">
						  		<input type="text" name="link" class="form-control" placeholder="請輸入連結" value="{{$rd->link}}"><br>
						  		輸入說明:連結輸入部分只取右方範例連結中紅色部分即可，https://www.youtube.com/watch?v=<span style="color: red">_HQHXem-TzY</span>&t=18s 
							</div>

						</div>
					</div>
					<div class="form-footer">
						<div class="form-group">
							<div class="col-md-9 col-md-offset-3">
								<button type="button" onclick="edit_form_submit('#edit_form')" class="btn btn-primary">儲存</button>
								<!-- <a class="btn btn-default" href="{{session('BACKPAGE')}}">回上一頁</a> -->
								<input type="hidden" name="_token" value="{{csrf_token()}}">
								<input type="hidden" name="id" value="{{$id}}">
								<input type="hidden" name="lang" value="{{$rd->lang ? $rd->lang : session('lang')}}">
								<input type="hidden" name="position" value="market_video">
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