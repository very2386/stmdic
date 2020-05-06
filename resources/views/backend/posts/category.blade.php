@extends('backend.main')
@section('content')
@include('backend._top')
<div class="row">
    <div class="col-xs-12">
		<div class="card card-banner no-br">
			<div class="card-header">
			  <div class="card-title">
			    <div class="title">文章分類管理</div>
			  </div>
			  <ul class="card-action">
			    <li><a class="btn btn-primary" href="/backend/posts/category_edit">新增</a></li>
			  </ul>
			</div>
			<div class="card-body">
				<?php
				$n = 0;
				?>
				<table class="table datatable">
					<thead>
						<tr>
							<th>#</th>
							<th>排序</th>
							<th>板主</th>
							<th>版名</th>
							<th>標籤</th>	
							<th>編輯</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$rs = \App\Cm::where('position', 'board')->where('lang', session('lang'))->orderBy('psort', 'desc')->orderBy('id', 'desc')->get();
						foreach($rs as $rd):
							$tags = $rd->tags ? explode(',', $rd->tags):[];
						?>
							<tr id="item_row{{$rd->id}}">
								<th scope="row">{{++$n}}</th>
								<td>{{$rd->psort}}</td>
								<td>{{\App\Members::where('id', $rd->up_sn)->value('name') }}</td>
								<td>{{$rd->name}}</td>
								<td>
									@foreach($tags as $tagname)
									<?php $tagrd = \App\Cm::where('position', 'tag')->where('name', $tagname)->first();?>
									<span class="tag" style="background:{{$tagrd->brief}};">{{$tagname}}</span>
									@endforeach
								</td>		
								<th>
									<a class="btn btn-primary" href="/backend/posts/category_edit?id={{$rd->id}}">編輯</a>
									<a class="btn btn-danger" onclick="del_item( 'cms', '{{$rd->id}}');" >刪除</a>
								</th>
							</tr>
						<?php 
						endforeach;
						if($rs->count() <= 0):
						?>
							<tr>
								<td colspan="7">
									<div class="empty_data"></div>
								</td>
							</tr>
						<?php endif;?>
					</tbody>
					</table>
			</div>
		</div>
    </div>
</div>
@endsection
@section('javascripts')
<script>
$(function(){
	$('.datatable').DataTable({
		"pageLength" : 25,
	});
});
</script>
@endsection