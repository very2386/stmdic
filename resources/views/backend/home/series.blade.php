@extends('backend.main')
@section('content')
@include('backend._top')
<div class="row">
    <div class="col-xs-12">
		<div class="card card-banner no-br">
			<div class="card-header">
			  <div class="card-title">
			    <div class="title">首頁系列作品管理</div>
			  </div>
			  <ul class="card-action">
			    <li><a class="btn btn-primary" href="/backend/home/series_edit">新增</a></li>
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
							<th>縮圖</th>
							<th>排序</th>
							<th>編輯</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$wh = ['position'=>'index_series'];
						if(request('type')) $wh['type'] = request('type');
						$rs = \App\Cm::where($wh)->where('lang', session('lang'))->get();
						foreach($rs as $rd):
						?>
							<tr id="item_row{{$rd->id}}">
								<th scope="row">{{++$n}}</th>
								<td><img src="{{\App\Cm::get_pic($rd->id)}}"></td>
								<td>{{$rd->psort}}</td>
								<th>
									<a class="btn btn-primary" href="/backend/home/series_edit?id={{$rd->id}}">編輯</a>
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