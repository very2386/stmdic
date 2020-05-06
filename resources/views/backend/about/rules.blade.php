@extends('backend.main')
@section('content')
@include('backend._top')
<div class="row">
    <div class="col-xs-12">
		<div class="card card-banner no-br">
			<div class="card-header">
			  <div class="card-title">
			    <div class="title">公司內規</div>
			  </div>
			  <ul class="card-action">
			    <li><a class="btn btn-primary" href="/backend/about/rules_edit">新增</a></li>
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
							<th>標題</th>
							<th>檔案名稱</th>
							<th>檔案下載</th>
							<th>編輯</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$rs = \App\Cm::where('position', 'rules')->where('lang', session('lang'))->get();
						foreach($rs as $rd):
						?>
							<tr id="item_row{{$rd->id}}">
								<th scope="row">{{++$n}}</th>
								<td>{{$rd->lang}}</td>
								<td>{{$rd->brief}}</td>
								<td>{{$rd->name}}</td>
								<td>{{$rd->brief}}</td>
								<td><a href="{{\App\Cm::get_pic($rd->id)}}" target="_blank">下載</a></td>
								<th>
									<a class="btn btn-primary" href="/backend/about/rules_edit?id={{$rd->id}}">編輯</a>
									<a class="btn btn-danger" onclick="del_item( 'cms', '{{$rd->id}}');" >刪除</a>
								</th>
							</tr>
						<?php 
						endforeach;
						if($rs->count() <= 0):
						?>
							<tr>
								<td colspan="6">
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