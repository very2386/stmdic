@extends('backend.main')
@section('content')
@include('backend._top')
<div class="row">
    <div class="col-xs-12">
		<div class="card card-banner no-br">
			<div class="card-header">
			  <div class="card-title">
			    <div class="title">商品管理</div>
			  </div>
			  <ul class="card-action">
			    <li><a class="btn btn-primary" href="/backend/prod/prod_edit">新增</a></li>
			  </ul>
			</div>
			<form name="filter_form" action="/backend/prod/index" method="get">
				<div class="form-inline filter">
					系列：
					<?php
					$selrs = \App\Cm::where('position', 'series')->where('type', 'products')->where('mstatus','Y')->orderBy('psort', 'desc')->get();
					?>
					<select name="series" id="series" class="form-control">
						<option value="">請選擇</option>
						@foreach($selrs as $selrd)
						<option value="{{$selrd->id}}" {{request('series') == $selrd->id?'selected':''}}>{{$selrd->name}}</option>
						@endforeach
					</select>
					作品：
					<?php
					$selrs = \App\Cm::where('position', 'works')->where('type', 'products')->where('mstatus','Y')->orderBy('psort', 'desc')->get();
					?>
					<select name="works" id="works" class="form-control">
						<option value="">請選擇</option>
						@foreach($selrs as $selrd)
						<option value="{{$selrd->id}}" {{request('works') == $selrd->id?'selected':''}}>{{$selrd->name}}</option>
						@endforeach
					</select>
					<input type="submit" class="btn btn-primary" value="送出" />
				</div>
			</form>
			<div class="card-body">
				<?php
				$n = 0;
				?>
				<table class="table">
					<thead>
						<tr>
							<th>#</th>
							<th>語言</th>
							<th>縮圖</th>
							<th>系列</th>
							<th>作品</th>
							<th>名稱</th>
							<th>狀態</th>
							<th>編輯</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$wh = ['type'=>'products'];
						if(request('series')) $wh['series'] = request('series');
						if(request('works')) $wh['works'] = request('works');
						$prs = \App\Products::where($wh)->get();
						foreach($prs as $prd):
							$rd = \App\Cm::where('id', $prd->pid)->first();
						?>
							<tr id="item_row{{$prd->id}}">
								<th scope="row">{{++$n}}</th>
								<td>{{session('lang')}}</td>
								<td><img class="list-img" src="{{\App\Cm::get_spic($rd->id)}}" alt=""></td>
								<td>{{\App\Cm::where('id',$prd->series)->value('name')}}</td>
								<td>{{\App\Cm::where('id',$prd->works)->value('name')}}</td>
								<td>{{$rd->name}}</td>
								<td>{{$rd->mstatus == 'Y' ? '上線':'下線'}}</td>
								<th>
									<a class="btn btn-primary" href="/backend/prod/prod_edit?id={{$rd->id}}">編輯</a>
									<a class="btn btn-danger" onclick="del_item( 'products', '{{$rd->id}}');" >刪除</a>
								</th>
							</tr>
						<?php 
						endforeach;
						if($prs->count() <= 0):
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