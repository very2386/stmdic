<?php
if(!session('mid')){
	session()->flash('sysmsg', '請先登入會員才可以使用發表文章');
	echo "<script>alert('請先登入會員才可以使用發表文章');location.href='/post';</script>";
	exit;
}else{
	if(!isset($id)){
		$posts = \App\Cm::new_obj();
	}else{
		$posts = \App\Cm::where('id',$id)->first();
	}
	$boards = \App\Cm::where('position','board')->groupby('name')->get();
	$tags = explode(',', $posts->tags);
}
?>
@extends('main')
@section('content')	
<style type="text/css">
.w-tags{
	width:100%;
}
.btn-del-sp{
	width: 20px;
    height: 20px;
    background-color: #ffa3a3;
    border: none;
    border-radius: 5px;
    color: #ffffff;
    font-size: 12px;
}
</style>

<section class="hot">
	<div class="ttl-bar">
		<h2>討論版</h2>
	</div>
	<div class="breadcrumb">
		<a href="/">首頁</a> &gt; <a href="/post">討論版</a> &gt; <a href="/post/post_edit/index">編輯發文</a>
	</div>
	<div class="content forum new clearfix">
		<h3 class="fz-sm blue bold mb20">發文編輯</h3>
		<form id="edit_form" action="/do/edit/cm" method="post">
			<ul class="custom-input">
				<li>
					<h4 class="ttl">文章分類</h4>
					<div class="custom-select small bordered w-srt" target="#type">
						<h5 class="ttl">{{$posts->type==''?'問題':$posts->type}}</h5>
						<ul class="opt">
							<li>問題</li>
							<li>討論</li>
						</ul>
					</div>
					<input type="hidden" id="type" name="type" value="{{$posts->type==''?'問題':$posts->type}}">
				</li>
				<li>
					<h4 class="ttl">分類</h4>
					<ul class="custom-radio sub flex wrap">	
						@foreach($boards as $k => $board)
							<?php
							$bname = explode(',',$posts->obj) ; 
							?>
							<li>
								<input name="obj[]" id="posttype{{$k}}" type="checkbox" value="{{$board->name}}" {{in_array($board->name,$bname) ?'checked':''}}>
								<label for="posttype{{$k}}" id="posttype{{$k}}">{{$board->name}}</label>
							</li>				
						@endforeach
					</ul>
				</li>
				<li>
					<h4 class="ttl">＊標題</h4>
					<input class="w-full" type="text" name="name" value="{{$posts->name}}">
				</li>
				<li>
					<h4 class="ttl">標籤</h4>
			  		<select class="w-tags" name="tags[]" id="tags" multiple="multiple">
			  			@foreach($tags as $tag)
			  				@if( strlen($tag) > 0 )
							<option value="{{$tag}}" l="{{strlen($tag)}}" selected="selected">{{$tag}}</option>
							@endif
			  			@endforeach
			  		</select>
			  		<input type="hidden" name="old_tags" value="{{$posts->tags}}">
					<!-- <input id="tags" class="w-full" type="text" name="tags" value="{{$posts->tags}}"> -->
				</li>
				<li>
					<h4 class="ttl">內容</h4>
					<textarea name="cont" id="pcontent" cols="30" rows="10">{!!$posts->cont!!}</textarea>
					<script>CKEDITOR.replace( 'pcontent', { height:500 } );</script>
				</li>
				<li>
					<h4 class="ttl">附件</h4>
					<ul style="margin-top:15px;">
					@if(isset($posts->id))
						<?php
						$files = \App\OtherFiles::where('position','posts')->where('cm_id',$posts->id)->get();
						?>
						@foreach($files as $rs)
						<li id="item_row{{$rs->id}}">
							<a href="/download/{{$rs->id}}">{{$rs->name}}</a> &nbsp;
							<button type="button" class="btn-del-sp" onclick="del_item('otherfiles','{{$rs->id}}')">x</button>
						</li>
						@endforeach
						<li>
							<input type="file" name="other_files[]" class="form-control" aria-label="上傳附件" multiple>(檔案大小不得超過25MB)
						</li>
					@endif
					</ul>
				</li>
			</ul>
			<button class="btn-box" type="button" onclick="edit_form_submit('#edit_form')">送出</button>
			<input type="hidden" name="_token" value="{{csrf_token()}}">
			<input type="hidden" name="id" value="{{$posts->id}}">
			<input type="hidden" name="up_sn" value="{{ $posts->up_sn != '' ? $posts->up_sn : session('mid')}}">
			<input type="hidden" name="lang" value="{{$posts->lang ? $posts->lang : session('lang')}}">
			<input type="hidden" name="position" value="posts">
			<input type="hidden" name="mstatus" value="Y">
		</form>
	</div>
</section>
@endsection
@section('javascript')
<script>
	// $('#tags').tagsInput({})
	register_form('#edit_form', function(res){
		load_page('/post');
	});
	$(".select2").select2({
        dropdownAutoWidth : true
    });
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
    })
</script>
@endsection
	
