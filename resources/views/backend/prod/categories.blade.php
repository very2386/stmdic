<?php
if(!$arg) $arg = 'series';
$wh = ['position'=>$arg];
if(request('type')) $wh['type'] = request('type');
$rs = \App\Cm::where($wh)->where('lang', session('lang'))->orderBy('psort', 'desc')->paginate(10);
$title = ['series'=>'品牌系列', 'works'=>'作品角色'];
if(request('type'))$rs->appends(['type'=>request('type')]);
?>
@extends('backend.main')
@section('content')
@include('backend._top')
<div class="row">
    <div class="col-xs-12">
		<div class="card card-banner no-br">
			<div class="card-header">
			  <div class="card-title">
			    <div class="title">{{$title[$arg]}}</div>
			  </div>
			  <ul class="card-action">
			    <li><a class="btn btn-primary" href="/backend/prod/categories_edit/{{$arg}}">新增</a></li>
			  </ul>
			</div>
			<form name="filter_form" action="/backend/prod/categories/{{$arg}}" method="get">
				<div class="form-inline filter">
					類別：
					<select name="type" id="type" class="form-control">
						<option value="">請選擇</option>
						<option value="gunpla" {{request('type') == 'gunpla'?'selected':''}}>GUNPLA</option>
						<option value="products" {{request('type') == 'products'?'selected':''}}>商品</option>
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
							<th>類別</th>
							<th>名稱</th>
							<th>圖片</th>
							<th>編輯</th>
						</tr>
					</thead>
					<tbody>
						<?php
						
						foreach($rs as $rd):
						?>
							<tr id="item_row{{$rd->id}}">
								<th scope="row">{{++$n}}</th>
								<td>{{$rd->lang}}</td>
								<td>{{$rd->type =='gunpla'?'GUNPLA':'商品' }}</td>
								<td>{{$rd->name}}</td>
								<td><div class="list-img"><img src="{{\App\Cm::get_spic($rd->id)}}" /></div></td>
								<th>
									<a class="btn btn-primary" href="/backend/prod/categories_edit/{{$arg}}?id={{$rd->id}}">編輯</a>
									&nbsp;
									<a class="btn btn-danger" onclick="del_item('cms','{{$rd->id}}')">刪除</a>
								</th>
							</tr>
						<?php 
						endforeach;
						?>
					</tbody>
				</table>
				<div class="text-center pad-btm-20">{{$rs->links()}}</div>
			</div>
		</div>
    </div>
</div>
@endsection