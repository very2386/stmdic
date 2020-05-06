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
			  <div class="card-title">
			    <div class="title">
			    	首頁輪播大圖
				    <div style="display:inline-block" class="form-inline">
						<select class="form-control" name="position" id="position" onchange="load_page('/backend/home/sliders?position='+this.options[this.selectedIndex].value)">
							<option value="home" {{request('position') == 'home' ? 'selected':''}}>首頁</option>
							<option value="market" {{request('position') == 'market' ? 'selected':''}}>行銷專區(上)</option>
							<option value="market_footer" {{request('position') == 'market_footer' ? 'selected':''}}>行銷專區(下)</option>
						</select>
				    </div>
			    </div>
			  </div>
			  <ul class="card-action">
			    <li><a class="btn btn-primary" href="/backend/home/sliders_edit?position={{$position}}">新增</a></li>
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
							<th>排序</th>
							<th style="width:20%">圖片</th>
							<th>說明</th>
							<th>狀態</th>
							<th>編輯</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$rs = \App\Cm::where('position', $position)->where('type', 'slider')->where('lang', session('lang'))->orderBy('psort','DESC')->get();
						foreach($rs as $rd):
						?>
							<tr id="item_row{{$rd->id}}">
								<th scope="row">{{++$n}}</th>
								<td>{{$rd->lang}}</td>
								<td>{{$rd->name}}</td>
								<td>{{$rd->psort}}</td>
								<td><img src="{{\App\Cm::get_pic($rd->id)}}" style="height:50px;" /></td>
								<td>{{$rd->brief}}</td>
								<td>{{$rd->mstatus == 'Y' ? '上線':'下線'}}</td>
								<th>
									<a class="btn btn-primary" href="/backend/home/sliders_edit?id={{$rd->id}}">編輯</a>
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