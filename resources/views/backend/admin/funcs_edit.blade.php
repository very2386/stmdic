<?php
if(request('id')){
	$rd = \App\Cm::where('id', request('id'))->first();
	if(!$rd){
		session()->flash('sysmsg', '找不到您要編輯的資料');
		echo '<script>location.href="/backend/admin/funcs"</script>';
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
				<a href="/backend/admin/funcs">功能管理</a> - 編輯
			</div>
			<div class="card-body">
				<form class="form form-horizontal" id="edit_form" name="edit_form" method="post" action="/do/edit/cm">
					<div class="section">
						<div class="section-title">{{session('lang')}}</div>
						<div class="section-body">
							<div class="form-group">
								<label class="col-md-3 control-label">功能群組</label>
								<div class="col-md-9">
									<select name="up_sn" id="up_sn" class="form-control" onchange="chg_up_sn()">
										<option value="0" {{ !$rd->up_sn ? 'selected':''}}>無</option>
										<?php
										$rrs = \App\Cm::where('position', 'funcs')->get();
										?>
										@foreach($rrs as $rrd)
										<option value="{{$rrd->id}}" {{$rd->up_sn == $rrd->id ? 'selected':''}}>{{$rrd->name}}</option>
										@endforeach
									</select>
									<input type="hidden" name="type" id="type" value="{{ $rd->type }}">
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">功能名稱</label>
								<div class="col-md-9">
							  		<input type="text" name="name" class="form-control" placeholder="請輸入名稱" value="{{$rd->name}}">
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-3">
									<label class="control-label">功能ID</label>
								</div>
								<div class="col-md-9">
							  		<input type="text" name="brief" class="form-control" placeholder="請輸入ID" value="{{$rd->brief}}">
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">路徑</label>
								<div class="col-md-9">
							  		<input type="text" name="link" class="form-control" placeholder="請輸入路徑" value="{{$rd->link}}">
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">關聯群組</label>
								<div class="col-md-9">
							  		<div class="row">
										<div class="col-md-3"><b>群組名稱</b></div>
										<div class="col-md-9"><b>操作權限</b></div>
							  		</div>
							  		<?php
							  		$rrs = \App\Cm::where('position', 'roles')->orderBy('psort', 'asc')->get();
							  		?>
							  		@foreach($rrs as $rrd)
							  		<?php
							  		$cur_funcs = explode(',' , $rrd->brief);
							  		?>
									<div class="row">
										<div class="col-md-3">{{$rrd->name}}</div>
										<div class="col-md-9 radio">
											<div class="radio pull-left" style="padding:0 30px 0 0">
											<input type="radio" name="roles[{{$rrd->id}}]" id="roles[{{$rrd->id}}]Y" value="Y" {{in_array($rd->id, $cur_funcs) ? 'checked':''}}>
											<label for="roles[{{$rrd->id}}]Y" >是</label>
											</div>
											<div class="radio pull-left">
											<input type="radio" name="roles[{{$rrd->id}}]" id="roles[{{$rrd->id}}]N" value="N" {{in_array($rd->id, $cur_funcs) ? '':'checked'}}>
											<label for="roles[{{$rrd->id}}]N" >否</label>
											</div>
										</div>
							  		</div>
							  		@endforeach
								</div>
							</div>
						</div>
					</div>
					<div class="form-footer">
						<div class="form-group">
							<div class="col-md-9 col-md-offset-3">
								<button type="submit" class="btn btn-primary">儲存</button>
								<button type="button" class="btn btn-default" onclick="load_page('{{session('BACKPAGE')}}')">回上一頁</button>
								<input type="hidden" name="_token" value="{{csrf_token()}}">
								<input type="hidden" name="id" value="{{request('id')}}">
								<input type="hidden" name="position" value="funcs">
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
function chg_up_sn(){
	var type = $('#up_sn option:selected').text();
	if(type == '無') type='';
	$('#type').val(type);
}
</script>
@endsection