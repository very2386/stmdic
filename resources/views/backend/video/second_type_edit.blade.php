<?php
if(request('id')){
	$rd = \App\Cm::where('id', request('id'))->first();
	if(!$rd){
		session()->flash('sysmsg', '找不到您要編輯的資料');
		echo '<script>location.href="/backend/member/index"</script>';
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
<div class="row">
    <div class="col-xs-12">
		<div class="card">
			<div class="card-header">
				<a href="/backend/video/video_second_type">數位影音次分類管理</a> - 編輯
			</div>
			<div class="card-body">
	            <form class="form form-horizontal" id="edit_form" name="edit_form" enctype="multipart/form-data" method="post" action="/do/edit/cm">
	            	<div class="section">
	            		<div class="section-body">
	            			<!-- <div class="form-group">
	            				<label class="col-md-3 control-label">所屬類別</label>
	            				<div class="col-md-9">
	            			  		<div class="radio radio-inline">
										<input type="radio" name="type" id="vtype1" value="育成時績" {{$rd->type == '育成時績' ? 'checked':''}}>
										<label for="vtype1">育成時績</label>
									</div>
									<div class="radio radio-inline">
										<input type="radio" name="type" id="vtype2" value="數位教材" {{$rd->type == '數位教材' ? 'checked':''}}>
										<label for="vtype2">數位教材</label>
									</div>
	            				</div>
	            			</div> -->
	            			<div class="form-group">
	            				<label class="col-md-3 control-label">所屬類別</label>
	            				<div class="col-md-9">
	            					<?php
	            					$ctype = \App\Cm::where('position','videotype')->get();
	            					?>
	            					<select name="type" id="type" class="form-control">
	            						<option value="">請選擇</option>
	            						@foreach($ctype as $ct)
	            						<option value="{{$ct->name}}" {{$ct->name==$rd->type?'selected':''}}>{{$ct->name}}</option>
	            						@endforeach
							  		</select>
	            				</div>
	            			</div>
	            			<div class="form-group">
	            				<label class="col-md-3 control-label">次分類名稱</label>
	            				<div class="col-md-9">
	            			  		<input type="text" name="name" class="form-control" value="{{$rd->name}}" placeholder="請輸入分類名稱">
	            				</div>
	            			</div>
	            			<div class="form-group">
	            				<label class="col-md-3 control-label">排序</label>
	            				<div class="col-md-9">
	            			  		<input type="text" name="psort" class="form-control" value="{{$rd->psort}}" placeholder="數字越大越前面">
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
	            				<button type="button" onclick="edit_form_submit('#edit_form')" class="btn btn-primary">儲存</button>
	            				<a class="btn btn-default" href="/backend/video/index">取消</a>
	            				<input type="hidden" name="_token" value="{{csrf_token()}}">
								<input type="hidden" name="id" value="{{request('id')}}">
								<input type="hidden" name="lang" value="{{$rd->lang ? $rd->lang : session('lang')}}">
								<input type="hidden" name="position" value="videotype_2nd">
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
	register_form('#edit_form',function(res){
		load_page('?id='+res.id);
	});
});
</script>
@endsection