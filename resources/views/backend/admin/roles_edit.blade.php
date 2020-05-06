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
				<a href="/backend/admin/roles">群組管理</a> - 編輯
			</div>
			<div class="card-body">
				<form class="form form-horizontal" id="edit_form" name="edit_form" method="post" action="/do/edit/cm">
					<div class="section">
						<div class="section-title">{{session('lang')}}</div>
						<div class="section-body">
							<div class="form-group">
								<label class="col-md-3 control-label">名稱</label>
								<div class="col-md-9">
							  		<input type="text" name="name" class="form-control" placeholder="請輸入名稱" value="{{$rd->name}}">
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">關聯功能</label>
								<div class="col-md-9">
							  		<div class="row">
										<div class="col-md-3"><b>功能名稱</b></div>
										<div class="col-md-9"><b>操作權限</b></div>
							  		</div>
							  		<?php
							  		$rrs = \App\Cm::where('position', 'funcs')->orderBy('psort', 'asc')->get();
							  		$cur_funcs = explode(',' , $rd->brief);
							  		?>
							  		@foreach($rrs as $rrd)
							  		<?php
							  		
							  		?>
									<div class="row">
										<div class="col-md-3">{{$rrd->name}}</div>
										<div class="col-md-9 ">
											<div class="radio pull-left" style="padding:0 30px 0 0">
											<input type="radio" name="funcs[{{$rrd->id}}]" id="funcs[{{$rrd->id}}]Y" value="Y" {{in_array($rrd->id, $cur_funcs) ? 'checked':''}}>
											<label for="funcs[{{$rrd->id}}]Y" >是</label>
											</div>
											<div class="radio pull-left">
											<input type="radio" name="funcs[{{$rrd->id}}]" id="funcs[{{$rrd->id}}]N" value="N" {{in_array($rrd->id, $cur_funcs) ? '':'checked'}}>
											<label for="funcs[{{$rrd->id}}]N" >否</label>
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
								<input type="hidden" name="position" value="roles">
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