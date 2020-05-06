<?php
if(request('id')){
	$rd = \App\Cm::where('id', request('id'))->first();
}
if(!isset($rd) || !$rd){
	session()->flash('sysmsg', '找不到您要編輯的資料');
	echo '<script>location.href="/backend/prod/pstatus"</script>';
	exit;
}
?>
@extends('backend.main')
@section('content')
@include('backend._top')
<script src="//cdn.ckeditor.com/4.6.2/full/ckeditor.js"></script>
<div class="row">
    <div class="col-xs-12">
		<div class="card">
			<div class="card-header">
				<a href="/backend/prod/pstatus">研發進程</a> - 編輯
			</div>
			<div class="card-body">
				<form class="form form-horizontal" id="edit_form" name="edit_form" enctype="multipart/form-data" method="post" action="/do/edit/pstatus">
					<div class="section">
						<div class="section-title">{{session('lang')}}</div>
						<div class="section-body">
							<div class="form-group">
								<label class="col-md-3 control-label">進程</label>
								<div class="col-md-9">
							  		{{$rd->psort + 1}}
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">進程名稱</label>
								<div class="col-md-9">
							  		<input type="text" name="name" class="form-control" placeholder="請輸入名稱" value="{{$rd->name}}">
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
								<label class="col-md-3 control-label">圖片</label>
								<div class="col-md-9">
									<div class="col-sm-3 text-center">
										<h4>未完成樣式</h4>
										<div class="image-preview">
											<img src="{{\App\Cm::get_pic($rd->id)}}" />
										</div>
										<div class="input-group">
									    	<input type="file" name="pstatus_pic[normal]" class="form-control" aria-label="上傳圖片">
										</div>
									</div>
									<div class="col-sm-3 text-center">
										<h4>已完成樣式</h4>
										<div class="image-preview">
											<img src="{{\App\Cm::get_pic($rd->id, 'finish')}}" />
										</div>
										<div class="input-group">
									    	<input type="file" name="pstatus_pic[finish]" class="form-control" aria-label="上傳圖片">
										</div>
									</div>
									<div class="col-sm-3 text-center">
										<h4>目前階段</h4>
										<div class="image-preview">
											<img src="{{\App\Cm::get_pic($rd->id, 'current')}}" />
										</div>
										<div class="input-group">
									    	<input type="file" name="pstatus_pic[current]" class="form-control" aria-label="上傳圖片">
										</div>
									</div>
									<div class="col-sm-3 text-center">
										<h4>手機標題</h4>
										<div class="image-preview">
											<img src="{{\App\Cm::get_pic($rd->id, 'mobile')}}" />
										</div>
										<div class="input-group">
									    	<input type="file" name="pstatus_pic[mobile]" class="form-control" aria-label="上傳圖片">
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="form-footer">
						<div class="form-group">
							<div class="col-md-9 col-md-offset-3">
								<button type="submit" class="btn btn-primary">儲存</button>
								<button type="button" class="btn btn-default">取消</button>
								<input type="hidden" name="_token" value="{{csrf_token()}}">
								<input type="hidden" name="id" value="{{request('id')}}">
								<input type="hidden" name="lang" value="{{$rd->lang ? $rd->lang : session('lang')}}">
								<input type="hidden" name="position" value="product">
								<input type="hidden" name="type" value="pstatus">
								<input type="hidden" name="psort" value="{{$rd->psort}}">
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