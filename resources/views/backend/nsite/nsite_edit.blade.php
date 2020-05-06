<?php
if(request('id')){
	$rd = \App\Cm::where('id', request('id'))->first();
	if(!$rd){
		session()->flash('sysmsg', '找不到您要編輯的資料');
		echo '<script>location.href="/backend/nsite/index"</script>';
		exit;
	}
}else{
	$rd =\App\Cm::new_obj();
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
				<a href="/backend/nsite/index">新聞來源網站</a> - 編輯
			</div>
			<div class="card-body">				
				<div class="section">
					<div class="section-title">{{session('lang')}}</div>
					<div class="section-body">
						<form class="form form-horizontal" id="edit_form" name="edit_form" enctype="multipart/form-data" method="post" action="/do/edit/cm">
							<div class="form-group">
								<label class="col-md-3 control-label">來源網站</label>
								<div class="col-md-9">
							  		<input type="text" name="name" class="form-control" placeholder="請輸入來源網站" value="{{$rd->name}}">
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
										<input type="hidden" name="position" value="nsite">
										<input type="hidden" name="type" value="text">
									</div>
								</div>
							</div>
						</form>
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
});
</script>
@endsection