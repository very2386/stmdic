<?php
$ers = [];
$takenyears = [];
$takenmonths = [];
if(request('id')){
	$rd = \App\Prospects::where('id', request('id'))->first();
	if(!$rd){
		session()->flash('sysmsg', '找不到您要編輯的資料');
		echo '<script>location.href="/backend/marketing/fprospect"</script>';
		exit;
	}
}else{
	$rd = \App\Prospects::new_obj();
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
				<a href="/backend/marketing/fprospect">未來展會</a> - 編輯
			</div>
			<div class="card-body">
				<form class="form form-horizontal" id="edit_form" name="edit_form" enctype="multipart/form-data" method="post" action="/do/edit/prospect">
					<div class="section">
						<div class="section-body">
							<div class="form-group">
	            				<label class="col-md-3 control-label">展會類別</label>
	            				<div class="col-md-9">
	            					<select name="type" id="type" class="form-control">
							  			<option value="國內展會" {{$rd->type == "國內展會" ? 'selected' : '' }}>國內展會</option>
							  			<option value="國外展會" {{$rd->type == "國外展會" ? 'selected' : '' }}>國外展會</option>
	            					</select>
	            				</div>
	            			</div>
							<div class="form-group">
								<label class="col-md-3 control-label">起始時間</label>
								<div class="col-md-9">
									<div class="input-group">
								        <input type="text" name="date" class="form-control datepicker" placeholder="請選擇日期" value="{{$rd->date}}">
								    </div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">結束時間（可空白）</label>
								<div class="col-md-9">
									<div class="input-group">
								        <input type="text" name="edate" class="form-control datepicker" value="{{$rd->edate}}">
								    </div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">事件名稱</label>
								<div class="col-md-9">
							  		<input type="text" name="name" class="form-control" placeholder="請輸入事件名稱" value="{{$rd->name}}">
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">圖片（多張）</label>
								<div class="col-md-9">
									@if(request('id'))
										<?php
										$files = \App\OtherFiles::where('position','fprospect')->where('cm_id',request('id'))->get();
										?>
										@foreach($files as $rs)
										<div class="image-preview col-md-3" style="padding: 5px;" id="item_row{{$rs->id}}">
											<img src="{{$rs->fname}}" style="max-width:100%; max-height:300px" />
											<a class="btn btn-danger del_file" onclick="del_item('otherfiles','{{$rs->id}}')">X</a>
										</div>
										@endforeach
									@endif
									<div class="input-group">
								    	<input type="file" name="other_files[]" class="form-control" aria-label="上傳圖片" multiple>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">狀態</label>
								<div class="col-md-9">
									<div class="radio radio-inline">
										<input type="radio" name="status" id="statusY" value="Y" {{$rd->status == 'Y' ? 'checked':''}}>
										<label for="statusY">上線</label>
									</div>
									<div class="radio radio-inline">
										<input type="radio" name="status" id="statusN" value="N" {{$rd->status == 'N' ? 'checked':''}}>
										<label for="statusN">下線</label>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-3">
									<label class="control-label">詳細內容</label>
									<p class="control-label-help">( 最多2000字 )</p>
								</div>
								<div class="col-md-9">
									<textarea id="pcontent" name="cont">{!!$rd->cont!!}</textarea>
									<script>CKEDITOR.replace( 'pcontent', { height:500 } );</script>
								</div>
							</div>					
						</div>
					</div>
					<div class="form-footer">
						<div class="form-group">
							<hr class="col-md-12"/>
							<div class="col-md-9 col-md-offset-3">
								<button type="button" onclick="edit_form_submit('#edit_form')" class="btn btn-primary">儲存</button>
								<button type="button" class="btn btn-default" onclick="history.back()">取消</button>
								<input type="hidden" name="_token" value="{{csrf_token()}}">
								<input type="hidden" name="id" value="{{request('id')}}">
								<input type="hidden" name="position" value="fprospect">
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
	$('.datepicker').pickadate({format: 'yyyy-mm-dd'});
});
</script>
@endsection