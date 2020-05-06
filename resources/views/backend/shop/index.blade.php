@extends('backend.main')
@section('content')
@include('backend._top')
<div class="row">
    <div class="col-xs-12">
		<div class="card card-banner no-br">
			<div class="card-header">
			  <div class="card-title">
			    <div class="title">賣場情報</div>
			  </div>
			  <ul class="card-action">
			    <li><a class="btn btn-primary" href="/backend/shop/shop_edit">新增</a></li>
			  </ul>
			</div>
			<div class="card-body">
				<?php
				$n = 0;
				$areas = \App\Cm::get_areas();
				?>
				<table class="table">
					<thead>
						<tr>
							<th>#</th>
							<th>區域</th>
							<th width="25%">名稱</th>
							<th>地址</th>
							<th>電話</th>
							<th>Email</th>
							<th>狀態</th>
							<th>編輯</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$rs = \App\Cm::where('position', 'shop')->where('lang', session('lang'))->orderBy('psort', 'desc')->orderBy('id', 'desc')->paginate(10);
						foreach($rs as $rd):
							$specs = json_decode($rd->specs);
						?>
							<tr id="item_row{{$rd->id}}">
								<th scope="row">{{++$n}}</th>
								<td>{{isset($areas[$rd->type])?$areas[$rd->type]:$rd->type}}</td>
								<td>{{$rd->name}}</td>
								<td>{{$specs->address}}</td>
								<td>{{$specs->tel}}</td>
								<td>{{$specs->email}}</td>
								<td>{{$rd->mstatus == 'Y' ? '上線':'下線'}}</td>
								<th>
									<a class="btn btn-primary" href="/backend/shop/shop_edit?id={{$rd->id}}">編輯</a>
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
				{{$rs->links()}}
			</div>
		</div>
    </div>
</div>
@endsection