<?php
if(request('id')){
	$rd = \App\Applications::where('id', request('id'))->first();
	if(!$rd){
		session()->flash('sysmsg', '找不到您要編輯的資料');
		echo '<script>location.href="/backend/application/index"</script>';
		exit;
	}
}else{
	session()->flash('sysmsg', '找不到您要編輯的資料');
	echo '<script>location.href="/backend/application/index"</script>';
	exit;
}
?>
@extends('backend.main')
@section('content')
@include('backend._top')
<div class="row">
    <div class="col-xs-12">
		<div class="card">
			<div class="card-header">
				<a href="/backend/application/index">缺件申請</a> - 編輯
			</div>
			<div class="card-body">
				<form class="form form-horizontal" id="edit_form" name="edit_form" enctype="multipart/form-data" method="post" action="/do/edit/cm">
					<div class="section">
						<div class="section-title">{{session('lang')}}</div>
						<div class="section-body">
							<div class="form-group">
								<label class="col-md-3 control-label">申請日期</label>
								<div class="col-md-9">
							  		<input class="form-control" type="text" readonly="readonly" value="{{$rd->created_at}}" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">姓名</label>
								<div class="col-md-9">
							  		<input class="form-control" type="text" readonly="readonly" value="{{$rd->name}}" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">性別</label>
								<div class="col-md-9">
							  		<input class="form-control" type="text" readonly="readonly" value="{{$rd->gender == 'M' ? '男':'女'}}" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">電子信箱</label>
								<div class="col-md-9">
							  		<input class="form-control" type="text" readonly="readonly" value="{{$rd->email}}" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">行動電話</label>
								<div class="col-md-9">
							  		<input class="form-control" type="text" readonly="readonly" value="{{$rd->mobile}}" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">地址</label>
								<div class="col-md-9">
							  		<input class="form-control" type="text" readonly="readonly" value="{{$rd->address}}" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">商品名稱</label>
								<div class="col-md-9">
							  		<input class="form-control" type="text" readonly="readonly" value="{{$rd->product_name}}" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">商品編耗</label>
								<div class="col-md-9">
							  		<input class="form-control" type="text" readonly="readonly" value="{{$rd->product_sno}}" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">缺件名稱</label>
								<div class="col-md-9">
							  		<input class="form-control" type="text" readonly="readonly" value="{{$rd->parts_name}}" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">缺件編耗</label>
								<div class="col-md-9">
							  		<input class="form-control" type="text" readonly="readonly" value="{{$rd->parts_sno}}" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">圖片</label>
								<div class="col-md-9">
									@for($i=1; $i<=3; $i++)
									<?php $p = 'pic'.$i; ?>
									@if( $rd->{$p} )
										<img src="{{ $rd->{$p} }}" />
									@endif
									@endfor
								</div>
							</div>
						</div>
					</div>
					<div class="form-footer">
						<div class="form-group">
							<div class="col-md-9 col-md-offset-3">
								<a class="btn btn-default" href="{{session('BACKPAGE')}}">回上一頁</a>
								<input type="hidden" name="_token" value="{{csrf_token()}}">
								<input type="hidden" name="id" value="{{request('id')}}">
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