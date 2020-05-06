<?php
$rs = \App\Prospects::where('position', 'fprospect')->orderBy('date','DESC')->get();
$bodyid="page-market";
?>
@extends('backend.main')
@section('content')
@include('backend._top')
<script src="//cdn.ckeditor.com/4.6.2/full/ckeditor.js"></script>
<div class="row">
    <div class="col-xs-12">
		<div class="card">
			<div class="card-header">
				<div class="card-title">
					<a href="/backend/marketing/fprospect">未來展會</a>
				</div>
				<ul class="card-action">
					<li><a class="btn btn-primary" href="/backend/marketing/fprospect_edit">新增</a></li>
				</ul>
			</div>
			<div class="card-body">
				<?php
				$n = 0;
				?>
				<table class="table datatable">
					<thead>
						<tr>
							<th style="width:5%">#</th>
							<th style="width:15%">展會類別</th>
							<th style="width:15%">起始日期</th>
							<th style="width:15%">結束日期</th>
							<th style="width:25%">事件名稱</th>
							<th style="width:25%">編輯</th>
						</tr>
					</thead>
					<tbody>
						@foreach($rs as $rd)
							<tr id="item_row{{$rd->id}}">
								<th scope="row">{{++$n}}</th>
								<td>{{$rd->type}}</td>
								<td>{{$rd->date}}</td>
								<td>{{$rd->edate}}</td>
								<td>{{$rd->name}}</td>
								<td>
									<a class="btn btn-primary" href="/backend/marketing/fprospect_edit?id={{$rd->id}}">編輯</a>
									<a class="btn btn-danger" onclick="del_item( 'prospect', '{{$rd->id}}');" >刪除</a>
								</td>
							</tr>
						@endforeach
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