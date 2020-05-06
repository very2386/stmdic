<?php
$boards = \App\Cm::where('position','board')->orderby('psort','DESC')->groupby('name')->get();
?>
<li class="ca">
	<h3 class="ttl">文章分類</h3>
	<div class="text">
		<ul>
			@foreach($boards as $k => $board)
			<?php $number = \App\Cm::where('position','posts')->where('obj',$board->name)->count() ?>
			@if(isset($number))
			<li>
				<span class="name">
					<img src="{{$board->spic!=''?$board->spic:'/img/icon/post/00.png'}}" alt="">
					<a href="/post/{{$board->name}}">{{$board->name}}</a>
				</span>
				<!-- <span class="num">{{$number}}</span> -->
			</li>
			@endif
			@endforeach
		</ul>
	</div>
</li>