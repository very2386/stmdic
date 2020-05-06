@extends('backend.main')
@section('content')
@include('backend._top')
<?php
$position = request('position');
if(!$position) $position = 'home';
?>
<div class="row">
    <div class="col-xs-12">
		<div class="card card-banner no-br">
			<div class="card-header">
			  <ul class="card-action">
			    <li><a class="btn btn-primary" href="/backend/member/advertismenet_edit">新增</a></li>
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
							<th>排序</th>
							<th>標題</th>
							<th style="width:20%">圖片</th>
							<th>狀態</th>
							<th>編輯</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$rs = \App\Cm::where('position','advertismenet')->orderBy('psort','DESC')->get();
						foreach($rs as $rd):
						?>
							<tr id="item_row{{$rd->id}}">
								<th scope="row">{{++$n}}</th>
								<td>{{$rd->name}}</td>
								<td>{{$rd->psort}}</td>
								<td><img src="{{\App\Cm::get_pic($rd->id)}}" style="height:50px;" /></td>
								<td>{{$rd->mstatus == 'Y' ? '上線':'下線'}}</td>
								<th>
									<a class="btn btn-primary" href="/backend/member/advertismenet_edit?id={{$rd->id}}">編輯</a>
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