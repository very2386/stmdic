@extends('backend.main')
@section('content')
@include('backend._top')
<div class="row">
    <div class="col-xs-12">
		<div class="card card-banner no-br">
			<div class="card-header">
			  <div class="card-title">
			    <div class="title">登入記錄</div>
			  </div>
			</div>
			<div class="card-body">
				<?php
				$n = 0;
				?>
				<table class="table">
					<thead>
						<tr>
							<th>#</th>
							<th>帳號</th>
							<th>姓名</th>
							<th>登入時間</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$admins = [];
						if(request('id')){
							$rs = \App\SysLogs::where('adminid', request('id'))->get();
						}else{
							$rs = \App\SysLogs::get();
						}
						foreach($rs as $rd):
							if(!isset($admins[$rd->adminid])) $admins[$rd->adminid] = \App\Admins::where('id', $rd->adminid)->first();
						?>
							<tr id="item_row{{$rd->id}}">
								<th scope="row">{{++$n}}</th>
								<td>{{$admins[$rd->adminid]->adminid}}</td>
								<td>{{$admins[$rd->adminid]->name}}</td>
								<td>{{$rd->created_at}}</td>
							</tr>
						<?php 
						endforeach;
						if($rs->count() <= 0):
						?>
							<tr>
								<td colspan="4">
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