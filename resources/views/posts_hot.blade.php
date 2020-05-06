<?php
$posts = \App\Cm::where('position','posts')->orderby('hits','DESC')->limit(2)->get();
?>
<li class="hot-post">
	<h3 class="ttl">熱門討論文章</h3>
	<div class="text">
		<ul>
			@foreach($posts as $post)
			<?php
			$reply = \App\Cm::where('position','comments')->where('up_sn',$post->id)->count();
			?>
			<li>
				<span class="type-discuss"><img src="/img/icon/post/type-{{$post->type=='討論'?'dis':'qa'}}.png" alt="">{{$post->type}}</span>
				<h4 class="ttl nb"><a href="/post/{{$post->id}}">{{$post->name}}</a></h4>
				<p class="source"><span class="date">{{$post->updated_at}}</span></p>
				<p>{{mb_substr(strip_tags($post->cont),0,100)}}</p>
				<div class="btns">
					<!-- <a class="like" href="javascript:;"><span class="icon"><img src="/img/icon/post/like.png" alt=""></span>999+</a> -->
					<div class="fb-like" data-href="/post/{{$post->id}}" data-layout="button_count" data-action="like" data-size="large" data-show-faces="false" data-share="false"></div>
					<a href="javascript:;">回覆 {{$reply}}</a>
				</div>
			</li>
			@endforeach
		</ul>
	</div>	
</li>