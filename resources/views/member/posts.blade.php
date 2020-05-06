@extends('main')
@section('content')
<section class="member">
	@include('member.menu')
	<div class="breadcrumb">
		<a href="/member/index">會員專區</a> &gt; <a class="name" href="">論壇文章</a>
	</div>
	<div class="content grid-intro form">
		<div class="">
			<div class="mypost">
				<?php
				$posts = \App\Cm::where('position','posts')->where('up_sn',session('mid'))->get();
				$count = \App\Cm::where('position','posts')->where('up_sn',session('mid'))->count();
				?>
				<h3 class="ttl mb10">我的發文(<span>{{$count}}</span>)</h3>
				<div class="tbl-st1">
					<table>
						<tr>
							<th width="35%">標題</th>
							<th width="12%">瀏覽人次</th>
							<th width="12%">收藏人次</th>
							<th width="12%">留言</th>
							<th width="17%">更新日期</th>
							<th width="12%">編輯</th>
						</tr>
						@foreach($posts as $post)
						<?php
						$mess_num = \App\Cm::where('position','comments')->where('up_sn',$post->id)->count();
						?>
						<tr>
							<td>{{$post->name}}</td>
							<td>{{$post->hits}}</td>
							<td>{{$post->collects}}</td>
							<td>{{$mess_num}}</td>
							<td>{{substr($post->updated_at,0,10)}}</td>
							<td><a class="btn" href="/post/post_edit/{{$post->id}}" >編輯</a></td>
							<!-- <a href="/post/post_edit/{{$post->id}}"><img src="/img/icon/edit.png" alt=""></a> -->
						</tr>
						@endforeach
					</table>
				</div>
			</div>
			<div class="collection">
				<?php
				$rs = \App\MembersCollects::where('mid',session('mid'))->where('type', 'post')->where('action','collects')->get();
				//先檢查會員所收藏的文章是否被刪除，若被刪除則將會員收藏資料刪除
				foreach($rs as $rd){
					$posts = \App\Cm::where('id',$rd->postid)->first();
					if(!$posts){
						\App\MembersCollects::where('postid',$rd->postid)->delete();
					}
				}
				$rs = \App\MembersCollects::where('mid',session('mid'))->where('type', 'post')->where('action','collects')->get();
				?>
				<h3 class="ttl mb10">收藏文章(<span>{{$rs->count()}}</span>)</h3>
				<div class="tbl-st1">
					<table>
						<tr>
							<th width="35%">標題</th>
							<th width="12%">瀏覽人次</th>
							<th width="12%">收藏人次</th>
							<th width="12%">留言</th>
							<th width="17%">更新日期</th>
							<th width="12%">取消收藏</th>
						</tr>
						@if($rs)
						@foreach($rs as $rd)
						<?php
						$posts = \App\Cm::where('id',$rd->postid)->first();
						if($posts){
							$num = \App\Cm::where('position','comments')->where('up_sn',$posts->id)->count();
						?>
						<tr id="item_row{{$rd->id}}">
							<td>{{$posts->name}}</td>
							<td>{{$posts->hits}}</td>
							<td>{{$posts->collects}}</td>
							<td>{{$num}}</td>
							<td>{{substr($posts->updated_at,0,10)}}</td>
							<td><a class="btn" onclick="del_item('members_collects', '{{$rd->id}}')">刪除</a></td>
						</tr>
						<?php } ?> 
						@endforeach
						@endif
					</table>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection
@section('javascript')
@endsection
