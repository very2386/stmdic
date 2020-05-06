@extends('backend.main')
@section('content')
@include('backend._top')
<div class="row">
    <div class="col-xs-12">
		<div class="card card-banner no-br">
			<div class="card-header">
			  <div class="card-title">
			    <div class="title">活動管理</div>
			  </div>
			  <ul class="card-action">
			    <li><a class="btn btn-primary" href="/backend/event/event_edit">新增</a></li>
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
							<th style="min-width:110px">置頂</th>
							<th style="width:15%">分類</th>
							<th style="width:15%">活動日期</th>
							<th style="width:20%">標題</th>
							<th style="width:15%">圖片</th>
							<th style="width:10%">狀態</th>
							<th style="width:25%">編輯</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$rs = \App\Cm::where('position', 'event')->where('lang', session('lang'))->orderBy('psort', 'desc')->orderBy('id', 'desc')->get();
						foreach($rs as $rd):
							$tags = $rd->tags ? explode(',', $rd->tags):[];
						?>
							<tr id="item_row{{$rd->id}}">
								<th scope="row">{{++$n}}</th>
								<td >
									<input name="psort" id="psort{{$rd->id}}" type="checkbox" value="999" {{$rd->psort=='999'?'checked':''}} onclick="chg_psort('{{$rd->id}}')">
									<label for="psort{{$rd->id}}">置頂</label> &nbsp;
								</td>
								<td>{{$rd->type}}</td>
								<td>{{substr($rd->event_sdate,0,10)}}</td>
								<td>{{$rd->name}}</td>
								<td><img src="{{\App\Cm::get_pic($rd->id)}}" style="height:50px;" /></td>
								<td>{{$rd->mstatus == 'Y' ? '上線':'下線'}}</td>
								<th>
									<a class="btn btn-primary" href="/backend/event/event_edit?id={{$rd->id}}">編輯</a>
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
@section('javascripts')
<script>
$(function(){
	$('.datatable').DataTable({
		"pageLength" : 25,
	});
});
function chg_psort(id){
	get_data('/do/chg_psort', {id:id});
}
</script>
@endsection