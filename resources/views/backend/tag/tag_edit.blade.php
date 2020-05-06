<?php
if(request('id')){
	$rd = \App\Cm::where('id', request('id'))->first();
	if(!$rd){
		session()->flash('sysmsg', '找不到您要編輯的資料');
		echo '<script>location.href="/backend/tag/index"</script>';
		exit;
	}
}else{
	$rd = \App\Cm::new_obj();
}
?>
@extends('backend.main')
@section('content')
@include('backend._top')
<div class="row">
    <div class="col-xs-12">
		<div class="card">
			<div class="card-header">
				<a href="/backend/tag/index">標籤管理</a> - 編輯
			</div>
			<div class="card-body">
				<form class="form form-horizontal" id="edit_form" name="edit_form" method="post" action="/do/edit/cm">
					<div class="section">
						<div class="section-title">{{session('lang')}}</div>
						<div class="section-body">
							<div class="form-group">
								<label class="col-md-3 control-label">標籤名稱</label>
								<div class="col-md-9">
							  		<input type="text" name="name" class="form-control" placeholder="請輸入名稱" value="{{$rd->name}}">
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-3">
									<label class="control-label">顏色</label>
									<div class="small-notes">例：#ffcc00</div>
								</div>
								<div class="col-md-9">
							  		<input type="text" id="brief" style="background:{{$rd->brief?$rd->brief:'#fff'}}" name="brief" class="form-control" placeholder="請輸入顏色" value="{{$rd->brief}}">
								</div>
							</div>
						</div>
					</div>
					<div class="form-footer">
						<div class="form-group">
							<div class="col-md-9 col-md-offset-3">
								<button type="submit" class="btn btn-primary">儲存</button>
								<a class="btn btn-default" href="/backend/tag/index">取消</a>
								<input type="hidden" name="_token" value="{{csrf_token()}}">
								<input type="hidden" name="id" value="{{request('id')}}">
								<input type="hidden" name="position" value="tag">
								<input type="hidden" name="type" value="text">
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
	// $('#brief').colorpicker();

	$('#brief').colorpicker().on('changeColor', function(e) {
        $('#brief')[0].style.backgroundColor = e.color.toString('hex');
    });
	register_form('#edit_form', function(res){
		load_page('?id='+res.id);
	});
});

</script>
@endsection