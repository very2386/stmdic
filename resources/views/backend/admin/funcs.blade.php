@extends('backend.main')
@section('content')
@include('backend._top')
<div class="row">
    <div class="col-xs-12">
		<div class="card card-banner no-br">
			<div class="card-header">
			  <div class="card-title">
			    <div class="title">功能管理</div>
			  </div>
			  <ul class="card-action">
			    <li><a class="btn btn-primary" href="/backend/admin/funcs_edit">新增</a></li>
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
							<th>功能群組</th>
							<th>功能名稱</th>
							<th>ID</th>
							<th>路徑</th>
							<th>授權</th>
							<th>編輯</th>
						</tr>
					</thead>
					<tbody id="items">
						<?php
						$rs = \App\Cm::where('position', 'funcs')->orderBy('psort','asc')->get();
						foreach($rs as $rd):
							$name = \App\Cm::where('id',$rd->up_sn)->value('name');
						?>
							<tr id="item_row{{$rd->id}}">
								<td scope="row">{{++$n}}</td>
								<td>{{$rd->up_sn==0?'':$name}}</td>
								<td>{{$rd->name}}</td>
								<td>{{$rd->brief}}</td>
								<td>{{$rd->link}}</td>
								<td><?php
									$rrs = \App\Cm::where('position', 'roles')->where('brief', 'like', '%'.$rd->id.'%')->get();
									?>
									@foreach($rrs as $rrd)
									<span class="tag" >{{$rrd->name}}</span>
									@endforeach
								</td>
								<td>
									<a class="btn btn-primary" href="/backend/admin/funcs_edit?id={{$rd->id}}">編輯</a>
									<a class="btn btn-danger" onclick="del_item( 'cms', '{{$rd->id}}');" >刪除</a>
								</td>
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
	$("#items").sortable({stop: function(event, ui) {
		var ids = $(this).sortable("toArray");
		get_data('/do/sort', {ids:ids});
	}});
	$('.datatable').DataTable({
		"pageLength" : 25,
	});
});

</script>
@endsection