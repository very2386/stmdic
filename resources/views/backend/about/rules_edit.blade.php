<?php
if(request('id')){
	$rd = \App\Cm::where('id', request('id'))->first();
	if(!$rd){
		session()->flash('sysmsg', '找不到您要編輯的資料');
		echo '<script>location.href="/backend/about/rules"</script>';
		exit;
	}
}else{
	$rd = new \stdClass();
	$rd->name= '';
	$rd->brief= '';
	$rd->cont= '';
	$rd->link= '';
	$rd->mstatus= 'Y';
	$rd->lang= session('lang');
}
?>
@extends('backend.main')
@section('content')
@include('backend._top')
<script src="//cdn.ckeditor.com/4.6.2/basic/ckeditor.js"></script>
<div class="row">
    <div class="col-xs-12">
		<div class="card">
			<div class="card-header">
				<a href="/backend/about/rules">公司內規</a> - 編輯
			</div>
			<div class="card-body">
				<form class="form form-horizontal" id="edit_form" name="edit_form" enctype="multipart/form-data" method="post" action="/do/edit/cm">
					<div class="section">
						<div class="section-title">{{session('lang')}}</div>
						<div class="section-body">
							<div class="form-group">
								<label class="col-md-3 control-label">標題</label>
								<div class="col-md-9">
							  		<input type="text" name="brief" class="form-control" placeholder="請輸入標題" value="{{$rd->brief}}">
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-3">
									<label class="control-label">檔案名稱</label>
									<p class="control-label-help">( 檔案下載時的名稱，最多100字 )</p>
								</div>
								<div class="col-md-9">
									<input type="text" id="name" name="name" class="form-control" value="{{$rd->name}}" placeholder="請輸入檔案名稱" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">檔案</label>
								<div class="col-md-9">
									@if(request('id'))
										<div class="file-preview">
											<a href="{{\App\Cm::get_pic($rd->id)}}" target="_blank">檢視/下載</a>
										</div>
									@endif
									<div class="input-group">
								    	<input type="file" name="picfile" class="form-control" aria-label="上傳檔案">
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-3">
									<label class="control-label">說明文字</label>
									<p class="control-label-help">( 請輸入內容，最多2000字 )</p>
								</div>
								<div class="col-md-9">
									<textarea id="newscontent" name="cont">{!!$rd->cont!!}</textarea>
									<script>CKEDITOR.replace( 'newscontent', { height:500 } );</script>
								</div>
							</div>
						</div>
					</div>
					<div class="form-footer">
						<div class="form-group">
							<div class="col-md-9 col-md-offset-3">
								<button type="button" onclick="edit_form_submit('#edit_form')" class="btn btn-primary">儲存</button>
								<button type="button" class="btn btn-default">取消</button>
								<input type="hidden" name="_token" value="{{csrf_token()}}">
								<input type="hidden" name="id" value="{{request('id')}}">
								<input type="hidden" name="lang" value="{{$rd->lang ? $rd->lang : session('lang')}}">
								<input type="hidden" name="position" value="rules">
								<input type="hidden" name="type" value="file">
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
		load_page('?id='+res.id);
	});
});

</script>
@endsection