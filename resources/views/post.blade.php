<?php 
$wh=['position'=>'posts','mstatus'=>'Y'];
$query = \App\Cm::where($wh);
if($id) $wh['obj'] = $id ; 

if($id) $query = $query->where('obj','like','%'.trim($id).'%') ; 

if(request('sort')&&request('sort')=='hot') $query = $query->orderby('hits','desc');
else $query = $query->orderby('updated_at','desc');

$posts = $query->paginate(10);
// if($posts->count() == 0){
// 	echo '<script>alert("此分類無資料");history.back();</script>';
// 	exit;
// }
$sort_class = "post_sort" ;
$sort_array = ['new'=>'最新','hot'=>'熱門'];
$cur_sort = '請選擇';
if(request('sort') == 'new' || request('sort') == 'hot' ) $cur_sort = $sort_array[request('sort')];
?>
@extends('main')
@section('content')	
<section class="hot">
	<div class="ttl-bar">
		<h2>討論版</h2>
		<!-- <div class="searchbar">
			<input type="search" placeholder="文章搜尋">
			<button class="btn-search">Search</button>
		</div> -->
	</div>
	<div class="breadcrumb">
		<a href="/">首頁</a> &gt;
		<a href="/post">討論版</a>  
		@if($id)
		&gt;
		<a href="/post/{{$id}}">{{$id}}</a>
		@endif
	</div>
	<div class="content forum two-side clearfix">
		<div class="side-left active article bg-gray">
			@include('sort')
			<a class="btn" href="/post/post_edit/index">+發表文章</a>
			<ul class="articles">
				@if($posts->count()>0)
					@foreach($posts as $post)
					<li class="flex between v-start" id="item_row{{$post->id}}">
						<div class="img">
							<?php
							$account = \App\Members::where('id',$post->up_sn)->first(); 
							if(!$account){
								\App\Cm::where('id',$post->id)->delete();
								continue;
							} 
							$counts = 0 ; 
							$comments = \App\Cm::where('position','comments')->where('up_sn',$post->id)->get();
							$counts += $comments->count();
							foreach($comments as $c){
								$counts += \App\Cm::where('position','reply')->where('up_sn',$c->id)->count();
							}
							$tags = explode(',', $post->tags);
							?>
							<span class="type-discuss flex center v-center">
								<img src="/img/icon/post/type-{{$post->type=='討論'?'dis':'qa'}}.png" alt="">{{$post->type}}
							</span>
							<a href="/member_info/{{$account->id}}"><img src="{{\App\Members::get_pic($account->id)}}" alt=""></a>
							<p>{{$account->name}}</p>
							<!-- <div class="badge flex between">
								<img src="/img/icon/id-normal.png" alt="">
								<img src="/img/icon/badge-bestans.png" alt="">
								<img src="/img/icon/badge-recommend.png" alt="">
								<img src="/img/icon/badge-weeklychampion.png" alt="">
							</div> -->
						</div>
						<div class="text fg1">
							<h3 class="ttl"><a href="/post/{{$post->id}}">{{$post->name}}</a></h3>
							<p class="source"><span class="date">{{$post->updated_at}}</span></p>
							<p>{{mb_substr(strip_tags($post->cont),0,100)}}</p>
							@if($post->tags)
							<p class="tag">
								@foreach($tags as $tag)
								@if($tag)
								<?php $tagrd = \App\Cm::where('position','tag')->where('name', $tag)->first();?>
								<span class="tag"><a href="javascript:;">#{{$tag}}</a></span>&nbsp;&nbsp;
								@endif
								@endforeach
							</p>
							@endif
						</div>
						<div class="btns abs">
							<!-- <a class="like" href="javascript:;"><span class="icon"><img src="/img/icon/post/like.png" alt=""></span>999+</a> -->
							<div class="fb-like" data-href="/post/{{$post->id}}" data-layout="button_count" data-action="like" data-size="large" data-show-faces="false" data-share="false"></div>
							<a class="btn-reply" href="javascript:;">回覆 {{$counts}}</a>
							
						</div>
						<div class="edit">
							@if($post->up_sn==session('mid'))
							<a class="btn-edit" href="/post/post_edit/{{$post->id}}"><span class="icon"><img src="/img/icon/post/edit.png" alt=""></span>編輯</a>
							<a class="btn-del" style="background-color:#ffa3a3" href="javascript:;" onclick="del_item('cms','{{$post->id}}');"><span class="icon"><img src="/img/icon/post/delete.png" alt=""></span>刪除</a>
							@endif
						</div>
					</li>
					@endforeach
				@else
					<h2 style="width: 100%;text-align: center;margin-top: 50px;font-size: 20px;">目前無相關文章</h2>
				@endif
			</ul>
			<div class="pager">
				{{$posts->appends(['id'=>request('id'),'sort'=>request('sort')])->links()}}
			</div>
		</div>
		<div class="side-right">
			<ul>
				@include('posts_boards')
				@include('posts_hot')
			</ul>
		</div>
	</div>
</section>
@endsection
@section('javascript')
<script type="text/javascript">
	$(function(){
		$('.custom-select .opt li').click(function(){
			var sortby = $(this).data('sort');
			location.href=$('#current_url').val() +'?sort=' +sortby ;
		});

		(function(d, s, id) {
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) return;
			js = d.createElement(s); js.id = id;
			js.src = 'https://connect.facebook.net/zh_TW/sdk.js#xfbml=1&version=v2.11&appId=110989952909732';
			fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));
	})
</script>
@endsection