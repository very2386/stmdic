<?php
if(request('id')){
	$rd = \App\Cm::where('id', request('id'))->first();
	if(!$rd){
		session()->flash('sysmsg', '找不到您要編輯的資料');
		echo '<script>location.href="/backend/news/index"</script>';
		exit;
	}
}else{
	$rd =\App\Cm::new_obj();
}
$author = \App\Members::where('id', $rd->up_sn)->first();
$tags = explode(',', $rd->tags);
$post_type = \App\Cm::where('position','board')->groupby('name')->get();
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
				<a href="/backend/posts/index">文章管理</a> - 編輯
			</div>
			<div class="card-body">
				<div class="section">
					<div class="section-title">{{session('lang')}}</div>
					<div class="section-body">
						<!-- Nav tabs -->
					    <ul class="nav nav-tabs" role="tablist">
					        <li class="{{ $arg ? '':'active' }}"><a href="/backend/posts/posts_edit?id={{request('id')}}">基本資料</a></li>
							<li class="{{ $arg == 'message' ? 'active':'' }}"><a href="/backend/posts/posts_edit/message?id={{request('id')}}">留言內容</a></li>
					    </ul>
					    @if(!$arg)
						<form class="form form-horizontal" id="edit_form" name="edit_form" enctype="multipart/form-data" method="post" action="/do/edit/cm">
							<div class="form-group pad-btm-20">
								<label class="col-md-3 control-label">文章型態</label>
								<div class="col-md-9 tags">
							  		<select name="type" id="type" class="form-control">
							  			<option value="討論" {{$rd->type == '討論' ? 'selected' : '' }}>討論</option>
							  			<option value="問題" {{$rd->type == '問題' ? 'selected' : '' }}>問題</option>
							  		</select>
								</div>
							</div>
							<div class="form-group pad-btm-20">
								<label class="col-md-3 control-label">文章類別</label>
								<div class="col-md-9">
									<?php
									$bname = explode(',',$rd->obj) ; 
									?>
									@foreach($post_type as $k => $type)
									<div class="col-md-3">
									  	<input type="checkbox" id="post_type{{$rd->id}}_{{$k}}" name="obj[]" value="{{$type->name}}" {{in_array($type->name,$bname) ? 'checked' : '' }}>
										<label for="post_type{{$rd->id}}_{{$k}}" id="post_type{{$rd->id}}_{{$k}}">{{$type->name}}</label>
									</div>
									@endforeach
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">作者</label>
								<div class="col-md-9">
							  		<input type="text" name="author" id="author" class="form-control" placeholder="請輸入作者" value="{{$author ? $author->name:''}}">
							  		<input type="hidden" name="up_sn" id="up_sn" value="{{$rd->up_sn}}" />
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
									<label class="control-label">簡介</label>
									<p class="control-label-help">( 請輸入簡介，最多100字 )</p>
								</div>
								<div class="col-md-9">
									<textarea id="brief" name="brief" class="form-control">{!!$rd->brief!!}</textarea>
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
								<label class="col-md-3 control-label">日期</label>
								<div class="col-md-9">
							  		<input type="text" name="sdate" class="form-control" placeholder="請輸入日期" value="{{$rd->sdate}}">
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
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">圖片</label>
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
							</div> -->
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
							<div class="form-footer">
								<div class="form-group">
									<div class="col-md-9 col-md-offset-3">
										<button type="button" onclick="edit_form_submit('#edit_form')" class="btn btn-primary">儲存</button>
										<a class="btn btn-default" href="/backend/posts/index">取消</a>
										<input type="hidden" name="_token" value="{{csrf_token()}}">
										<input type="hidden" name="id" value="{{request('id')}}">
										<input type="hidden" name="lang" value="{{$rd->lang ? $rd->lang : session('lang')}}">
										<input type="hidden" name="position" value="posts">
										<input type="hidden" name="url" value="backend">
									</div>
								</div>
							</div>
						</form>
						@elseif($arg == 'message')
						<?php
						$rs = \App\Cm::where('position','comments')->where('up_sn', request('id'))->orderBy('id', 'ASC')->paginate(9);
						$n = request('page')?(request('page')-1)*10:0 ; 
						?>
						<div role="tabpanel" class="tab-pane active" id="news">
							<table class="table">
								<thead>
									<th>#</th>
									<th style="width: 15%">留言/回覆</th>
									<th style="width: 10%">會員</th>	
									<th style="width: 40%">內容</th>
									<th>時間</th>
									<th>編輯</th>
								</thead>
								<tbody>
									@foreach($rs as $rd)
									<?php
									$member = \App\Members::where('id',$rd->objsn)->first();
									?>
									<tr>
										<td>{{++$n}}</td>
										<td>留言</td>
										<td>{{$member->name}}</td>
										<td>{{$rd->cont}}</td>
										<td>{{substr($rd->updated_at,0,10)}}</td>
										<td><a class="btn btn-danger" onclick="del_msg( 'cms', '{{$rd->id}}');" >刪除</a></td>
									</tr>
									<?php
									$reply = \App\Cm::where('position','reply')->where('up_sn',$rd->id)->orderBy('id','ASC')->get();
									$reply_member = \App\Members::where('id',$rd->objsn)->first();
									?>
										@foreach($reply as $re)
										<tr id="item_row{{$re->id}}">
											<td></td>
											<td>回覆</td>
											<td>{{$reply_member->name}}</td>
											<td>{{$re->cont}}</td>
											<td>{{substr($re->updated_at,0,10)}}</td>
											<td><a class="btn btn-danger" onclick="del_item( 'cms', '{{$re->id}}');" >刪除</a></td>
										</tr>
										@endforeach
									@endforeach
								</tbody>
							</table>
							<div>{{$rs->appends(['id' => request('id')])->links()}}</div>
						</div>
						@endif
					</div>
				</div>
			</div>
		</div>
    </div>
</div>
@include('backend._modalMedia')
@endsection
@section('javascripts')
<script>
$(function(){
	$( "#author" ).autocomplete({
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
function del_msg(delobj, delsn, delid){
    var _token = $('#csrf_token').val();
    var id = "{{request('id')}}";
    if(!confirm("確定要刪除嗎？若要刪除，則此則留言底下的回覆會一併刪除")){
        return false;
    }else{
        get_data('/do/del_obj',{delobj:delobj, delsn:delsn, '_token':_token},function(res){
            load_page('/backend/posts/posts_edit/message?id='+id) ;
        });
    }
}
</script>
@endsection