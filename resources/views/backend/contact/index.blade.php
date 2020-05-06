@extends('backend.main')
@section('content')
@include('backend._top')
<div class="row">
    <div class="col-xs-12">
		<div class="card card-banner no-br">
			<div class="card-header">
			  <div class="card-title">
			    <div class="title">連絡資料</div>
			  </div>
			  <ul class="card-action">
			    <li><a class="btn btn-primary" href="/backend/clear_contact">清除過期資料</a></li>
			  </ul>
			</div>
			<div class="card-body">
				<?php
				$n = 0;
				?>
				<table class="table">
					<thead>
						<tr>
							<th>#</th>
							<th>語言</th>
							<th>分類</th>
							<th>主旨</th>
							<th>姓名</th>
							<th>公司</th>
							<th>職稱</th>
							<th>編輯</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$rs = \App\ContactLogs::whereNull('dstatus')->get();
						foreach($rs as $n=>$rd):
						?>
							<tr id="item_row{{$rd->id}}">
								<th scope="row">{{++$n}}</th>
								<td>{{$rd->lang}}</td>
								<td>{{$rd->category}}</td>
								<td>{{$rd->subject}}</td>
								<td>{{$rd->name}}</td>
								<td>{{$rd->company}}</td>
								<td>{{$rd->title}}</td>
								<th>
									<a class="btn btn-primary" href="/backend/contact/contact_edit?id={{$rd->id}}">編輯</a>
									<a class="btn btn-danger" onclick="del_item( 'contact_logs', '{{$rd->id}}');" >刪除</a>
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