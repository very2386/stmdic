<?php
$nsites = \App\Cm::where('position', 'nsite')->orderBy('name', 'asc')->get();
?>
@extends('backend.main')
@section('content')
@include('backend._top')
<div class="row">
    <div class="col-xs-12">
		<div class="card card-banner no-br">
			<div class="card-header">
			  <div class="card-title">
			    <div class="title">新聞來源管理</div>
			  </div>
			  <ul class="card-action">
			    <li><a class="btn btn-primary" href="/backend/nsource/nsource_edit">新增</a></li>
			  </ul>
			</div>
			<div class="back-srch form-inline">
				<form action="" method="get">
					來源網站：
					<select class="form-control" name="up_sn" id="up_sn" style="margin-top: 11px;">
						@foreach($nsites as $nsite)
						<option value="{{$nsite->id}}" {{$nsite->id == request('up_sn') ? 'selected':'' }}>{{$nsite->name}}</option>
						@endforeach
					</select>
					<input type="submit" class="btn btn-primary" value="送出" />
				</form>
			</div>
			<div class="card-body">
				<?php
				$n = 0;
				?>
				<table class="table datatable">
					<thead>
						<tr>
							<th>#</th>
							<th>來源網站</th>
							<th>來源名稱</th>
							<th>排序</th>
							<th>類別</th>
							<th>狀態</th>
							<th>編輯</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$wh = ['position'=>'nsource','lang'=>session('lang')];
						if(request('up_sn')) $wh['up_sn'] = request('up_sn');
						$rs = \App\Cm::where($wh)->orderBy('psort', 'desc')->orderBy('id', 'desc')->get();
						foreach($rs as $rd):
						?>
							<tr id="item_row{{$rd->id}}">
								<th scope="row">{{++$n}}</th>
								<td>{{\App\Cm::where('id',$rd->up_sn)->value('name')}}</td>
								<td>{{$rd->name}}</td>
								<td>{{$rd->psort}}</td>
								<td>{{$rd->link_type}}</td>
								<td>{{$rd->mstatus == 'Y' ? '上線':'下線'}}</td>
								<th>
									<a class="btn btn-primary" href="/backend/nsource/nsource_edit?id={{$rd->id}}">編輯</a>
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