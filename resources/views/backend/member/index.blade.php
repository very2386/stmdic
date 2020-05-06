@extends('backend.main')
@section('content')
@include('backend._top')
<div class="row">
    <div class="col-xs-12">
		<div class="card card-banner no-br">
			<div class="card-header">
			  <div class="card-title">
			    <div class="title">會員管理</div>
			  </div>
			  <ul class="card-action">
			    <li>
			    	<a class="btn btn-primary" href="/backend/member/member_edit">新增</a>
			    	<a class="btn btn-info" href="/do/excel/member">匯出會員資料</a>
			    </li>
			  </ul>
			</div>
			<div class="card-body" >
				<?php
				$n = 0;
				?>
				<table class="table datatable">
					<thead>
						<tr>
							<th style="width:5%">#</th>
							<th style="width:10%">帳號</th>
							<th style="width:15%">會員類別</th>
							<th style="width:15%">Email</th>
							<th style="width:15%">姓名</th>
							<th style="width:10%">狀態</th>
							<th style="width:30%">編輯</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$rs = \App\Members::get();
						foreach($rs as $rd):
							$tags = $rd->tags ? explode(',', $rd->tags):[];
						?>
							<tr id="item_row{{$rd->id}}">
								<th scope="row">{{++$n}}</th>
								<td>{{$rd->loginid}}</td>
								<td>{{$rd->type}}</td>
								<td>{{$rd->email}}</td>
								<td>{{$rd->name}}</td>	
								<td>{{$rd->mstatus == 'Y' ? '正常':'停權'}}</td>
								<th>
									<a class="btn btn-primary" href="/backend/member/member_edit?id={{$rd->id}}">編輯</a>
									<a class="btn btn-danger" onclick="del_item( 'members', '{{$rd->id}}');" >刪除</a>
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