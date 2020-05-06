<?php
$boards = \App\Cm::where('position','board')->orderby('psort','DESC')->get();
?>
@extends('main')
@section('content')	
<section class="post2">
	<div class="ttl-bar">
		<h2>聚落交流</h2>
	</div>
	<div class="content two-side forum">
		<div class="side-left cat active mr20">
			<ul>
				@foreach($boards as $rd)
				<li class="flex" style="width: 930px;padding-bottom: 10px">
					<div class="img fig">
						<a href="/post/{{$rd->name}}">
							<img src="{{\App\Cm::get_pic($rd->id)}}">
						</a>
						<!-- <a class="img-title" href="/post/{{$rd->name}}">{{$rd->name}}</a> -->
					</div>
					<div class="text">
						<div class="title">
							<h3>
								<a href="/post/{{$rd->name}}">{{$rd->name}}</a>
							</h3>
							<p>
								{{$rd->brief}}
							</p>
						</div>
						<ul class="lists">
							<?php
							$post_data = \App\Cm::where('position','posts')->where('obj','like','%'.$rd->name.'%')->where('mstatus','Y')->orderBy('updated_at','DESC')->limit(3)->get();
							?>
							@foreach($post_data as $rd)
							<li><a href="/post/{{$rd->id}}">{{$rd->name}}</a></li>
							@endforeach
						</ul>
						
					</div>
				</li>
				<hr>
				@endforeach
			</ul>
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
@endsection