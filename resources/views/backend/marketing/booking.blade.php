<?php
$rs = \App\Cm::where('position','booking')->orderBy('edate','DESC')->get();
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
					<a href="/backend/marketing/booking">醫材展示室-預約使用</a>
				</div>
				<ul class="card-action">
					<li><a class="btn btn-primary" href="/backend/marketing/booking_edit">新增</a></li>
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
							<th>活動名稱</th>
							<th>來訪團體</th>
							<th>日期</th>
							<th>狀態</th>
							<th>編輯</th>
						</tr>
					</thead>
					<tbody>
						@foreach($rs as $rd)
							<?php
							$cont = json_decode($rd->cont) ; 
							?>
							<tr id="item_row{{$rd->id}}">
								<th scope="row">{{++$n}}</th>
								<td>{{$cont->title}}</td>
								<td>{{$cont->group}}</td>
								<td>{{substr($rd->edate,0,10)}} {{$rd->obj}}</td>
								<td>{{$rd->mstatus=='Y'?'預約':'取消'}}</td>
								<td>
									<a class="btn btn-primary" href="/backend/marketing/booking_edit?id={{$rd->id}}">編輯</a>
									<a class="btn btn-danger" onclick="del_item( 'cms', '{{$rd->id}}');" >刪除</a>
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