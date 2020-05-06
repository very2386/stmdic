<?php
if($_GET['type']=='domestic') $title = '國內媒體' ; 
else $title = '國外媒體' ; 
?>
@extends('backend.main')
@section('content')
@include('backend._top')
<div class="row">
    <div class="col-xs-12">
		<div class="card card-banner no-br">
			<div class="card-header">
			  <div class="card-title">
			    <div class="title">{{$title}}管理</div>
			  </div>
			  <ul class="card-action">
			    <li><a class="btn btn-primary" href="/backend/information/{{$_GET['type']}}_information_edit">新增</a></li>
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
							<th>新聞發生日期</th>
							<th>標題</th>
							<th>編輯</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$rs = \App\Cm::where('position', 'information')->where('type',$_GET['type'])->orderBy('sdate','DESC')->get();
						foreach($rs as $rd):
						?>
							<tr id="item_row{{$rd->id}}">
								<td scope="row">{{++$n}}</td>
								<td>{{$rd->sdate}}</td>
								<td>{{$rd->name}}</td>
								<td>
									<a class="btn btn-primary" href="/backend/information/{{$_GET['type']}}_information_edit?id={{$rd->id}}">編輯</a>
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
	$('.datatable').DataTable({
		"pageLength" : 25,
	});
});
</script>
@endsection