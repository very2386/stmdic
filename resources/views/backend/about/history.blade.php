<?php
$rs = \App\Cm::where('position', 'history')->where('up_sn', 0)->where('lang', session('lang'))->orderBy('name','asc')->get();
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
					<a href="/backend/about/history">關於我們 - 公司沿革</a>
				</div>
				<ul class="card-action">
					<li><a class="btn btn-primary" href="/backend/about/history_edit">新增</a></li>
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
							<th>年份</th>
							<th>事件</th>
							<th>編輯</th>
						</tr>
					</thead>
					<tbody>
						<?php
						foreach($rs as $rd):
							$ers = \App\Cm::where('up_sn', $rd->id)->get();
							$events = [];
							if($ers){
								foreach($ers as $erd){
									$events[] = trans('message.'.$erd->name)."－".$erd->cont;
								}	
							}
						?>
							<tr id="item_row{{$rd->id}}">
								<th scope="row">{{++$n}}</th>
								<td><div class="text-center list-img"><img src="{{\App\Cm::get_pic($rd->id)}}"/></div></td>
								<td>{{$rd->name}}</td>
								<td>{!! implode("<br />", $events) !!}</td>
								<td>
									<a class="btn btn-primary" href="/backend/about/history_edit?id={{$rd->id}}">編輯</a>
									<a class="btn btn-danger" onclick="del_item( 'cms', '{{$rd->id}}');" >刪除</a>
								</td>
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

});
</script>
@endsection