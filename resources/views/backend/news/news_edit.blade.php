<?php
if(request('id')){
	$rd = \App\Cm::where('id', request('id'))->first();
	if(!$rd){
		session()->flash('sysmsg', '找不到您要編輯的資料');
		echo '<script>location.href="/backend/news/index"</script>';
		exit;
	}
}else{
	$rd = \App\Cm::new_obj();
}
$tags = explode(',', $rd->tags);
$news_type = \App\Cm::get_news_type();
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
</style>
<div class="row">
    <div class="col-xs-12">
		<div class="card">
			<div class="card-header">
				<a href="/backend/news/index">新聞資料</a> - 編輯
			</div>
			<div class="card-body">
				<form class="form form-horizontal" id="news_edit_form" name="news_edit_form" enctype="multipart/form-data" method="post" action="/do/edit/cm">
					<div class="section">
						<div class="section-title">{{session('lang')}}</div>
						<div class="section-body">
							<div class="form-group pad-btm-20">
								<label class="col-md-3 control-label">分類</label>
								<div class="col-md-9">
							  		@foreach($news_type as $k => $type)
							  			<?php
							  			$rdtype = explode(',', $rd->type)
							  			?>
							  			@if($type!='數位影音' && $type!='')
							  			<input type="checkbox" id="comptype_{{$k}}" name="type[]" value="{{$type}}" {{in_array($type,$rdtype)?'checked':''}}>
										<label for="comptype_{{$k}}" id="comptype_{{$k}}">{{$type}}</label> &nbsp;
							  			@endif
							  		@endforeach
								</div>
							</div>
							<div class="form-group pad-btm-20">
								<label class="col-md-3 control-label">標籤</label>
								<div class="col-md-9 tags">
							  		<div class="old_tags">
							  		@foreach($tags as $tag)
							  			@if($tag)
							  			<?php $tagrd = \App\Cm::where('position','tag')->where('name', $tag)->first();?>
										<span class="tag" style="background:{{isset($tagrd)?$tagrd->brief:''}}">{{$tag}}</span>&nbsp;&nbsp;
										@endif
									@endforeach
									<a class="btn btn-small btn-primary" onclick="edit_tags();">管理標籤</a>
									</div>
							  		<select class="form-control hideme" name="tags[]" id="tags" multiple="multiple">
							  			@foreach($tags as $tag)
							  				@if( strlen($tag) > 0 )
											<option value="{{$tag}}" l="{{strlen($tag)}}" selected="selected">{{$tag}}</option>
											@endif
							  			@endforeach
							  		</select>
							  		<input type="hidden" name="old_tags" value="{{$rd->tags}}">
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">日期</label>
								<div class="col-md-9">
							  		<input type="text" name="sdate" class="form-control" placeholder="請輸入日期" value="{{$rd->sdate}}">
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">標題</label>
								<div class="col-md-9">
							  		<input type="text" name="name" class="form-control" placeholder="請輸入標題" value="{{$rd->name}}">
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
								<label class="col-md-3 control-label">連結</label>
								<div class="col-md-9">
							  		<input type="text" name="link" class="form-control" placeholder="請輸入連結" value="{{$rd->link}}">
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">排序</label>
								<div class="col-md-9">
							  		<input type="text" name="psort" class="form-control" placeholder="請輸入排序" value="{{$rd->psort}}"><div class="small-notes">數字越大越前面</div>
								</div>
							</div>
							<!-- <div class="form-group">
								<label class="col-md-3 control-label">列表圖片(小)</label>
								<div class="col-md-9">
									@if(request('id'))
										<div class="image-preview">
											<img src="{{\App\Cm::get_spic($rd->id)}}" style="max-width:100%; max-height:300px" />
										</div>
									@endif
									<div class="input-group">
								    	<input type="file" name="spicfile" class="form-control" aria-label="上傳圖片">
									</div>
								</div>
							</div> -->
							<div class="form-group">
								<label class="col-md-3 control-label">圖片</label>
								<div class="col-md-9">
									@if(request('id')&&$rd->pic != '')
										<!-- <div class="image-preview">
											<img src="{{\App\Cm::get_news_pic($rd->id)}}" style="max-width:100%; max-height:300px" />
										</div> -->
										<div class="image-preview col-md-3" style="padding: 5px;" id="item_row{{$rd->id}}">
											<img src="{{\App\Cm::get_news_pic($rd->id)}}" style="max-width:100%; max-height:300px" />
											<a class="btn btn-danger del_file" onclick="del_item('news_pic','{{$rd->id}}')">X</a>
										</div>
									@endif
									<div class="input-group">
								    	<input type="file" name="picfile" class="form-control" aria-label="上傳圖片">
									</div>
								</div>
							</div>
							<!-- <div class="form-group">
								<label class="col-md-3 control-label">審核狀態</label>
								<div class="col-md-9">
									<div class="radio radio-inline">
										<input type="radio" name="online_status" id="online_statusY" value="Y" {{$rd->online_status == 'Y' ? 'checked':''}}>
										<label for="online_statusY">通過</label>
									</div>
									<div class="radio radio-inline">
										<input type="radio" name="online_status" id="online_statusN" value="N" {{$rd->online_status == 'N' ? 'checked':''}}>
										<label for="online_statusN">未通過</label>
									</div>
								</div>
							</div> -->
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
							<div class="form-group">
								<div class="col-md-3">
									<label class="control-label">內容</label>
									<p class="control-label-help">( 請輸入內容，最多2000字 )</p>
									<button type="button" class="btn btn-success" onclick="load_media('{{request('id')}}', 'news')">媒體庫</button>
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
							<div class="col-md-9 col-md-offset-3">
								<button type="button" onclick="edit_form_submit('#news_edit_form')" class="btn btn-primary">儲存</button>
								<a class="btn btn-default" href="{{session('BACKPAGE')}}">回上一頁</a>
								<input type="hidden" name="_token" value="{{csrf_token()}}">
								<input type="hidden" name="id" value="{{request('id')}}">
								<input type="hidden" name="lang" value="{{$rd->lang ? $rd->lang : session('lang')}}">
								<input type="hidden" name="position" value="news">
								<input type="hidden" name="up_sn" value="{{$rd->up_sn}}">
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
	register_form('#news_edit_form', function(res){
		load_page('?id='+res.id);
	});
});
function edit_tags(){
	$('.old_tags').hide();
	$('#tags').select2({
        placeholder: 'Select an item',
        tags: true,
        ajax: {
          url: '/get/tags',
          dataType: 'json',
          delay: 250,
          processResults: function (data) {
            return {
              results: data
            };
          },
          cache: true
        },
        minimumInputLength: 1
    }).show();
}

</script>
@endsection