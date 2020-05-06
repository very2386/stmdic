<?php
if(request('id')){
	$rd = \App\Cm::where('id', request('id'))->first();
	if(!$rd){
		session()->flash('sysmsg', '找不到您要編輯的資料');
		echo '<script>location.href="/backend/posts/category"</script>';
		exit;
	}
}else{
	$rd =\App\Cm::new_obj();
}
$master = \App\Members::where('id', $rd->up_sn)->first();
$tags = explode(',', $rd->tags);
$post_type = \App\Cm::get_posts_type();
?>
@extends('backend.main')
@section('content')
@include('backend._top')
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
				<a href="/backend/posts/category">文章看板管理</a> - 編輯
			</div>
			<div class="card-body">
				<form class="form form-horizontal" id="edit_form" name="edit_form" enctype="multipart/form-data" method="post" action="/do/edit/cm">
					<div class="section">
						<div class="section-title">{{session('lang')}}</div>
						<div class="section-body">
							<!-- <div class="form-group pad-btm-20">
								<label class="col-md-3 control-label">分類</label>
								<div class="col-md-9 tags">
							  		<select name="type" id="type" class="form-control">
							  			@foreach($post_type as $type)
							  			<option value="{{$type}}" {{$rd->type == $type ? 'selected' : '' }}>{{$type}}</option>
							  			@endforeach
							  		</select>
								</div>
							</div> -->
							<div class="form-group">
								<label class="col-md-3 control-label">版名</label>
								<div class="col-md-9">
							  		<input type="text" name="name" class="form-control" placeholder="請輸入版名" value="{{$rd->name}}">
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">版主</label>
								<div class="col-md-9">
							  		<input type="text" name="master" id="master" class="form-control" placeholder="請輸入版主" value="{{$master ? $master->name:''}}">
							  		<input type="hidden" name="up_sn" id="up_sn" value="{{$rd->up_sn}}" />
								</div>
							</div>
							<div class="form-group pad-btm-20">
								<label class="col-md-3 control-label">通知Email</label>
								<div class="col-md-9">
							  		<textarea name="specs" class="form-control" placeholder="請輸入Email，分號分隔">{{$rd->specs}}</textarea>
							  		<div>※ 請輸入Email，分號分隔</div>
								</div>
							</div>
							<div class="form-group pad-btm-20">
								<label class="col-md-3 control-label">標籤</label>
								<div class="col-md-9 tags">
							  		<div class="old_tags">
							  		@foreach($tags as $tag)
							  			@if($tag)
							  			<?php $tagrd = \App\Cm::where('position','tag')->where('name', $tag)->first();?>
										<span class="tag" style="background:{{$tagrd->brief}}">{{$tag}}</span>&nbsp;&nbsp;
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
							<div class="form-group">
								<label class="col-md-3 control-label">列表icon圖片</label>
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
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">文章類別大圖</label>
								<div class="col-md-9">
									@if(request('id'))
										<div class="image-preview">
											<img src="{{\App\Cm::get_pic($rd->id)}}" style="max-width:100%; max-height:300px" />
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
								<a class="btn btn-default" href="/backend/posts/category">取消</a>
								<input type="hidden" name="_token" value="{{csrf_token()}}">
								<input type="hidden" name="id" value="{{request('id')}}">
								<input type="hidden" name="lang" value="{{$rd->lang ? $rd->lang : session('lang')}}">
								<input type="hidden" name="position" value="board">
								<input type="hidden" name="type" value="text">
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
	$( "#master" ).autocomplete({
      source: "/get/members",
      minLength: 1,
      select: function( event, ui ) {
        $('#up_sn').val(ui.item.id);
      }
    });
	register_form('#edit_form', function(res){
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
$( "#master" ).autocomplete({
  source: "/get/members",
  minLength: 1,
  select: function( event, ui ) {
    $('#up_sn').val(ui.item.id);
  }
});

</script>
@endsection