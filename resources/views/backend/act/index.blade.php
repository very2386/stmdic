@extends('backend.main')
@section('content')
@include('backend._top')
<?php
$types = ['一般報名', '專車報名', 'GBWC'];
$jstaus = \App\Act::get_jstatus();
?>
<div class="row">
    <div class="col-xs-12">
		<div class="card card-banner no-br">
			<div class="card-header">
			  <div class="card-title">
			    <div class="title">活動管理</div>
			  </div>
			  <ul class="card-action">
			    <li><a class="btn btn-primary" href="/backend/act/act_edit">新增</a></li>
			  </ul>
			</div>
			<div class="card-body">
				<div class="back-srch">
					<form name="srchform" action="/backend/act/index" method="get" >
						<div class="form-inline">
							活動類別：
							<select name="type" id="type" class="form-control">
								<option value="">請選擇</option>
								@foreach($types as $type)
								<option value="{{$type}}" {{request('type') == $type ? 'selected':''}}>{{$type}}</option>
								@endforeach
							</select>
							<input class="btn btn-primary" type="submit" name="goSearch" value="篩選" >
						</div>
					</form>
				</div>
				<?php
				$n = 0;
				?>
				<table class="table datatable">
					<thead>
						<tr>
							<th>#</th>
							<th>類別</th>
							<th>名稱</th>
							<th>場次</th>
							<th>日期</th>
							<th>顯示</th>
							<th>狀態</th>
							<th>編輯</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$where = [];
						if(request('type')) $where['type'] = request('type');
						$rs = \App\Act::where($where)->orderBy('id', 'desc')->get();
						foreach($rs as $rd):
						?>
							<tr id="item_row{{$rd->id}}">
								<th scope="row">{{++$n}}</th>
								<td>{{$rd->type}}</td>
								<td>{{$rd->name}}</td>
								<td>{{$rd->type == 'GBWC'?'-':\App\ActDetail::where('asn', $rd->id)->count() }}</td>
								<td>{{date('Y-m-d', $rd->adate)}}</td>
								<td>{{$rd->mstatus == 'Y' ? '顯示':'隱藏'}}</td>
								<td>{{$rd->astatus && isset($jstaus[$rd->astatus])?$jstaus[$rd->astatus]:''}}</td>
								<th>
									<a class="btn btn-primary" href="/backend/act/act_edit?id={{$rd->id}}">編輯</a>
									<a class="btn btn-danger" onclick="del_item( 'act', '{{$rd->id}}');" >刪除</a>
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
<script type="text/javascript">
$(function(){
	$('.datatable').datatable();
});
</script>
@endsection