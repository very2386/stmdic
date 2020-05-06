@extends('backend.main')
@section('content')
@include('backend._top')
<div class="row">
    <div class="col-xs-12">
		<div class="card card-banner no-br">
			<div class="card-header">
			  <div class="card-title">
			    <div class="title">文件下載管理</div>
			  </div>
			  <ul class="card-action">
			    <li><a class="btn btn-primary" href="/backend/files/files_edit">新增</a></li>
			  </ul>
			</div>
			<?php
				$n = 1 ;
				$page = !request('page') ? '0' : request('page')-1  ;
			?>
			<div class="card-body">
				<table class="table datatable">
					<thead>
						<tr>
							<th>#</th>
							<th>類別</th>
							<th>標題</th>
							<th>檔案種類</th>
							<th style="width:10%">狀態</th>
							<th style="width:25%">編輯</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$rs = \App\Cm::where('position','files')->orderBy('id', 'desc')->paginate(env('PERPAGE'));
						if($rs){
						foreach($rs as $rd):
							$files = \App\OtherFiles::where('cm_id',$rd->id)->get() ;
						?>
							<tr id="item_row{{$rd->id}}">
								<th scope="row">{{env('PERPAGE')*$page+$n++}}</th>
								<td>{{$rd->type}}
								</td>
								<td>{{$rd->name}}</td>
								<td>
									@foreach($files as $k => $f)
										{{count($files)-1!=$k?$f->filetype.' | ':$f->filetype}}
									@endforeach
								</td>
								<td>{{$rd->mstatus=='Y'?'上線':'下線'}}</td>
								<th>
									<a class="btn btn-primary" href="/backend/files/files_edit?id={{$rd->id}}">編輯</a>
									<a class="btn btn-danger" onclick="del_item( 'cms', '{{$rd->id}}');" >刪除</a>
								</th>
							</tr>
						<?php 
						endforeach;
						
						}else{
						?>
							<tr>
								<td colspan="5">
									<div class="empty_data"></div>
								</td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
				
				<div> 
				<?php echo $rs->links(); ?>
				</div>
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