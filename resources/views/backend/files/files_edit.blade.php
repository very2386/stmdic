<?php
if(request('id')){
	$rd = \App\Cm::where('id', request('id'))->first();
	if(!$rd){
		session()->flash('sysmsg', '找不到您要編輯的資料');
		echo '<script>location.href="/backend/plan/index"</script>';
		exit;
	}
}else{
	$rd =\App\Cm::new_obj();
}
$file_class = \App\Cm::get_file_class();
?>
@extends('backend.main')
@section('content')
@include('backend._top')
<script src="//cdn.ckeditor.com/4.6.2/full/ckeditor.js"></script>
<style type="text/css">
.tags label{
	display: inline-block;
	padding:5px;
	color:#fff;
	font-weight: normal;
}
.del_file{
	padding: 3px;
    position: absolute;
    top: 0px;
    right: 0px;
}
</style>
<div class="row">
    <div class="col-xs-12">
		<div class="card">
			<div class="card-header">
				<a href="/backend/files/index">文件下載管理</a> - 編輯
			</div>
			<div class="card-body">
				<form class="form form-horizontal" id="edit_form" name="edit_form" enctype="multipart/form-data" method="post" action="/do/edit/cm">
					<div class="section">
						<div class="section-title">{{session('lang')}}</div>
						<div class="section-body">
							<div class="form-group">
	            				<label class="col-md-3 control-label">類別</label>
	            				<div class="col-md-9">
	            					<select name="type" id="type" class="form-control">
	            						<option value="">請選擇</option>
	            						@foreach($file_class as $fc)
							  			<option value="{{$fc}}" {{$rd->type==$fc?'selected':''}}>{{$fc}}</option>
							  			@endforeach
							  			<option value="文宣下載專區" {{$rd->type=='文宣下載專區'?'selected':''}}>文宣下載專區</option>
	            					</select>
	            				</div>
	            			</div>
	            			<div class="form-group {{$rd->type=='計畫各階段文件下載'?'':'hidden'}} brief">
	            				<label class="col-md-3 control-label">次分類</label>
	            				<div class="col-md-9">
	            					<select name="brief" id="brief" class="form-control">
	            						<option value="">請選擇</option>
							  			<option value="計畫申請階段" {{$rd->brief=="計畫申請階段"?'selected':''}}>計畫申請階段</option>
							  			<option value="計畫執行階段" {{$rd->brief=="計畫執行階段"?'selected':''}}>計畫執行階段</option>
							  			<option value="計畫經費核銷" {{$rd->brief=="計畫經費核銷"?'selected':''}}>計畫經費核銷</option>
	            					</select>
	            				</div>
	            			</div>
							<div class="form-group">
								<label class="col-md-3 control-label">標題</label>
								<div class="col-md-9">
							  		<input type="text" name="name" class="form-control" placeholder="請輸入標題" value="{{$rd->name}}">
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">連結</label>
								<div class="col-md-9">
							  		<input type="text" name="link" class="form-control" placeholder="請輸入檔案連結（可空白）" value="{{$rd->link}}">
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-3">
									<label class="control-label">PDF檔案</label>
									<p class="control-label-help">( 若無可空白不上傳 )</p>
								</div>
								<div class="col-md-9">
									@if(request('id'))
										<?php
										$files = \App\OtherFiles::where('position','files')->where('cm_id',request('id'))->where('filetype','pdf')->get();
										?>
										@foreach($files as $rs)
										<div class="col-md-3" style="padding: 5px;" id="item_row{{$rs->id}}">
											<a href="/download/{{$rs->id}}">{{$rs->name}}</a>
											<a class="btn btn-danger del_file" onclick="del_item('otherfiles','{{$rs->id}}')">X</a>
										</div>
										@endforeach
									@endif
									<div class="input-group">
								    	<input type="file" name="file-pdf" class="form-control" aria-label="上傳附件">
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-3">
									<label class="control-label">DOC/DOCX檔案</label>
									<p class="control-label-help">( 若無可空白不上傳 )</p>
								</div>
								<div class="col-md-9">
									@if(request('id'))
										<?php
										$files = \App\OtherFiles::where('position','files')->where('cm_id',request('id'))->where('filetype','like','doc%')->get();
										?>
										@foreach($files as $rs)
										<div class="col-md-3" style="padding: 5px;" id="item_row{{$rs->id}}">
											<a href="/download/{{$rs->id}}">{{$rs->name}}</a>
											<a class="btn btn-danger del_file" onclick="del_item('otherfiles','{{$rs->id}}')">X</a>
										</div>
										@endforeach
									@endif
									<div class="input-group">
								    	<input type="file" name="file-doc" class="form-control" aria-label="上傳附件">
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-3">
									<label class="control-label">PPT/PPTX檔案</label>
									<p class="control-label-help">( 若無可空白不上傳 )</p>
								</div>
								<div class="col-md-9">
									@if(request('id'))
										<?php
										$files = \App\OtherFiles::where('position','files')->where('cm_id',request('id'))->where('filetype','like','ppt%')->get();
										?>
										@foreach($files as $rs)
										<div class="col-md-3" style="padding: 5px;" id="item_row{{$rs->id}}">
											<a href="/download/{{$rs->id}}">{{$rs->name}}</a>
											<a class="btn btn-danger del_file" onclick="del_item('otherfiles','{{$rs->id}}')">X</a>
										</div>
										@endforeach
									@endif
									<div class="input-group">
								    	<input type="file" name="file-ppt" class="form-control" aria-label="上傳附件">
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-3">
									<label class="control-label">說明</label>
									<p class="control-label-help">( 請輸入說明，最多100字 )</p>
								</div>
								<div class="col-md-9">
									<textarea id="brief" name="cont" class="form-control">{!!$rd->cont!!}</textarea>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">上線狀態</label>
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
								<a class="btn btn-default" href="{{session('BACKPAGE')}}">回上一頁</a>
								<input type="hidden" name="_token" value="{{csrf_token()}}">
								<input type="hidden" name="id" value="{{request('id')}}">
								<input type="hidden" name="lang" value="{{$rd->lang ? $rd->lang : session('lang')}}">
								<input type="hidden" name="position" value="files">
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
    </div>
</div>
@include('backend._modalMedia')
@endsection
@section('javascripts')
<script>
$(function(){
	register_form('#edit_form', function(res){
		load_page('?id='+res.id);
	});
	$('#type').on('change',function(){
		var type = $('#type').val();
		if(type=='計畫各階段文件下載'){
			$('.brief').removeClass('hidden');
		}else{
			$('.brief').addClass('hidden');
		}
	});
});
</script>
@endsection