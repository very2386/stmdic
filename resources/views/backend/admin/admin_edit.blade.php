<?php
if(request('id')){
	$rd = \App\Admins::where('id', request('id'))->first();
	if(!$rd){
		session()->flash('sysmsg', '找不到您要編輯的資料');
		echo '<script>location.href="/backend/admin/index"</script>';
		exit;
	}
}else{
	$rd = new \stdClass();
	$rd->name= '';
	$rd->pic= '';
	$rd->brief= '';
	$rd->email= '';
	$rd->adminid= '';
	$rd->roleid= '';
	$rd->mstatus= 'Y';
	$rd->lang= 'CH';
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
				<a href="/backend/admin/index">人員管理</a> - 編輯
			</div>
			<div class="card-body">
				<form class="form form-horizontal" id="edit_form" name="edit_form" enctype="multipart/form-data" method="post" action="/do/edit/admin">
					<div class="section">
						<div class="section-body">
							<div class="form-group">
								<label class="col-md-3 control-label">群組</label>
								<div class="col-md-9">
							  		<select name="roleid" id="roleid" class="form-control">
							  			<?php 
							  			$rolers = \App\Cm::where('position', 'roles')->orderBy('psort','asc')->get();
							  			?>
							  			@foreach($rolers as $rolerd)
										<option value="{{$rolerd->id}}" {{$rd->roleid == $rolerd->id ? 'selected':''}}>{{$rolerd->name}}</option>
							  			@endforeach
							  		</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">帳號</label>
								<div class="col-md-9">
							  		<input type="text" name="adminid" class="form-control" placeholder="請輸入帳號" value="{{$rd->adminid}}">
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">姓名</label>
								<div class="col-md-9">
							  		<input type="text" name="name" class="form-control" placeholder="請輸入姓名" value="{{$rd->name}}">
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">電子郵件</label>
								<div class="col-md-9">
							  		<input type="text" name="email" class="form-control" placeholder="請輸入Email" value="{{$rd->email}}">
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
								<div class="col-md-3">
									<label class="control-label">密碼</label>
								</div>
								<div class="col-md-9">
							  		<input id="passwd" type="password" name="passwd" class="form-control" placeholder="請輸入密碼" value="">
							  		@if(request('id'))<p class="control-label-help">( 不想修改密碼請留白 )</p>@endif
							  		<div id="length-help-text"></div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-3">
									<label class="control-label">確認密碼</label>
								</div>
								<div class="col-md-9">
							  		<input type="password" name="passwd_chk" class="form-control" placeholder="請輸入密碼" value="">
							  		<p class="control-label-help">( 請再次輸入密碼@if(request('id'))，不想修改密碼請留白@endif )</p>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">圖片</label>
								<div class="col-md-9">
									@if(request('id'))
										<div class="image-preview">
											<img src="{{\App\Admins::get_pic($rd->id)}}" />
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
								<a class="btn btn-default" href="/backend/admin/index">取消</a>
								<input type="hidden" name="_token" value="{{csrf_token()}}">
								<input type="hidden" name="id" value="{{request('id')}}">
								<input type="hidden" name="lang" value="{{$rd->lang ? $rd->lang : session('lang')}}">
								<input type="hidden" name="position" value="news">
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