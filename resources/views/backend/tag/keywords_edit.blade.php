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
$main_type = \App\Cm::get_news_type();
?>
@extends('backend.main')
@section('content')
@include('backend._top')
<div class="row">
    <div class="col-xs-12">
		<div class="card">
			<div class="card-header">
				<a href="/backend/tag/keywords">爬文關鍵字管理</a> - 編輯
			</div>
			<div class="card-body">
				<form class="form form-horizontal" id="edit_form" name="edit_form" method="post" action="/do/edit/cm">
					<div class="section">
						<div class="section-title">{{session('lang')}}</div>
						<div class="section-body">
							<div class="form-group">
								<label class="col-md-3 control-label">類別</label>
								<div class="col-md-9">
	            			  		<select name="type" id="type" class="form-control">
	            			  			<option value="">請選擇</option>
	            			  			@foreach($main_type as $key => $type)
	            			  				@if($type!=='')
	            			  				<option data-type="{{$key}}" value="{{$type}}" {{$rd->type == $type ? 'selected':''}}>{{$type}}</option>
	            			  				@endif
	            			  			@endforeach
	            			  		</select>
	            				</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">關鍵字名稱</label>
								<div class="col-md-9">
							  		<input type="text" name="name" class="form-control" placeholder="請輸入關鍵字名稱" value="{{$rd->name}}">
								</div>
							</div>
						</div>
					</div>
					<div class="form-footer">
						<div class="form-group">
							<div class="col-md-9 col-md-offset-3">
								<button type="submit" class="btn btn-primary">儲存</button>
								<a class="btn btn-default" href="/backend/tag/keywords">取消</a>
								<input type="hidden" name="_token" value="{{csrf_token()}}">
								<input type="hidden" name="id" value="{{request('id')}}">
								<input type="hidden" name="position" value="keywords">
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
		load_page('?id='+res.id);
	});
});

</script>
@endsection