<?php
$rd = \App\Cm::where('position', 'about')->where('type', 'organization')->where('lang', session('lang'))->first();
if(!$rd) $rd = \App\Cm::create(['position'=>'about', 'type'=>'organization', 'lang'=>session('lang')]);
$pics = \App\Cm::where('obj', 'organization')->where('objsn', $rd->id)->get();
if(!$pics) $pics = [];
?>
@extends('backend.main')
@section('content')
@include('backend._top')
<script src="//cdn.ckeditor.com/4.6.2/full/ckeditor.js"></script>
<div class="row">
    <div class="col-xs-12">
		<div class="card">
			<div class="card-header">
				<a href="/backend/about/organization">關於我們 - 公司組織</a>
			</div>
			<div class="card-body">
				<form class="form form-horizontal" id="edit_form" name="edit_form" enctype="multipart/form-data" method="post" action="/do/edit/cm">
					<div class="section">
						<div class="section-title">{{session('lang')}}</div>
						<div class="form-group pad-btm-20" >
							<label class="col-md-3 control-label">內容圖片</label>
							<div class="col-md-9">
								<div id="rel_files">
								@foreach($pics as $pic)
									<div id="item_row{{$pic->id}}" class="editor-img-list">
										<img src="{{\App\Cm::get_pic($pic->id)}}" />
										<a class="del" onclick="del_item('cmd', '{{$pic->id}}')"><i class="fa fa-times" aria-hidden="true"></i></a>
									</div>
								@endforeach	
								</div>
								<div>
							    	<a class="btn btn-primary" data-toggle="modal" data-target="#modalAddFile">新增檔案</a>
								</div>
							</div>
						</div>
						<div class="section-body">
							<div class="form-group">
								<div class="col-md-12">
									<label class="control-label">內容</label>
									<p class="control-label-help">( 請輸入內容，最多2000字 )</p>
								</div>
								<div class="col-md-12">
									<textarea id="scont" name="cont">{!!$rd->cont!!}</textarea>
									<script>CKEDITOR.replace( 'scont', { height:600, contentsCss:'/css/style.css' } );</script>
								</div>
							</div>
						</div>
					</div>
					<div class="form-footer">
						<div class="form-group">
							<div class="col-md-12">
								<button type="button" onclick="edit_form_submit('#edit_form')" class="btn btn-primary">儲存</button>
								<button type="reset" class="btn btn-default">取消</button>
								<input type="hidden" name="_token" value="{{csrf_token()}}">
								<input type="hidden" name="id" value="{{$rd->id}}">
								<input type="hidden" name="lang" value="{{$rd->lang ? $rd->lang : session('lang')}}">
								<input type="hidden" name="position" value="about">
								<input type="hidden" name="type" value="organization">
								<input type="hidden" name="name" value="公司組織">
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
    </div>
</div>
<div class="modal fade" id="modalAddFile" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <form name="addfile_form" id="addfile_form" method="post" enctype="multipart/form-data" action="/do/edit/cm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 id="addfilebox_title" class="modal-title">
        	<div class="modal-title-icon">
            	<i class="fa fa-cubes" aria-hidden="true"></i>
          </div>新增圖片</h4>
      </div>
      <div id="addfilebox_content" class="modal-body">
      		<div>
				<label for="addfile_name">圖片名稱</label>
				<input type="text" class="form-control" name="name" id="addfile_name" placeholder="請輸入圖片名稱" />
			</div>
			<div>
				<input type="file" class="form-control" name="picfile" id="addfile_name" placeholder="請選擇圖片檔" />
			</div>
			<div>
				<input type="hidden" name="_token" value="{{csrf_token()}}">
				<input type="hidden" name="lang" value="{{$rd->lang ? $rd->lang : session('lang')}}">
				<input type="hidden" name="position" value="org_attached">
				<input type="hidden" name="type" value="image">
				<input type="hidden" name="obj" value="organization">
				<input type="hidden" name="objsn" value="{{$rd->id}}">
			</div>
      </div>
      <div class="modal-footer">
      	<button type="submit" class="btn btn-primary">上傳</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
      </div>
    </div><!-- /.modal-content -->
    </form>
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@endsection
@section('javascripts')
<script>
$(function(){
	register_form('#edit_form', function(res){
		reload_page();
	});
	register_form('#addfile_form', function(res){
		var id = res.id;
		var html = '<div id="item_row'+id+'" class="editor-img-list">';
		html+= '<img src="'+res.data.pic+'" />';
		html+= '<a class="del" onclick="del_item(\'cms\', \''+id+'\')"><i class="fa fa-times" aria-hidden="true"></i></a></div>';
		$('#rel_files').append(html);
		$('#modalAddFile').modal('hide');
	});
});
</script>
@endsection