<?php
$expert_type = \App\Cm::get_expert_type();
?>
@extends('backend.main')
@section('content')
@include('backend._top')
<div class="row">
    <div class="col-xs-12">
		<div class="card card-banner no-br">
			<div class="card-header">
			  <div class="card-title">
			    <div class="title">專家管理</div>
			  </div>
			  <ul class="card-action">
			    <li><a class="btn btn-primary" href="/backend/experts/expert_edit">新增</a></li>
			  </ul>
			</div>
			<div class="card-body" style="padding:10px 15px">
				<form id="search_form" action="/backend/experts/index" method="get">
					<ul class="nav nav-tabs" role="tablist">
						<li class="news_position" style="margin: 10px;">分類篩選：
							<select name="experts_type" id="experts_type">
								<option value="">請選擇專家類別</option>
								@foreach($expert_type as $type)
								<option value="{{$type}}" {{$type==request('experts_type')?'selected':''}}>{{$type}}</option>
								@endforeach
							</select>	
						</li>
						<li class="news_position" style="margin: 10px;">姓名搜尋：
							<input type="text" name="experts_name" value="{{request('experts_name')}}">
						</li>
						<button class="btn btn-primary search">查詢</button> &nbsp;
						<a href="/backend/experts/index" class="btn btn-danger">清除查詢</a>
						<input type="hidden" name="search" value="news">	
				    </ul>
			    </form>
				<?php
				$n = !request('page') ? '0' : (request('page')-1)*10 ; 
				?>
				<table class="table">
					<thead>
						<tr>
							<th>#</th>
							<th>類別</th>
							<th>姓名</th>
							<th>縮圖</th>
							<th>狀態</th>
							<th>編輯</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$query = \App\Cm::where('position','expert') ;
						if(request('experts_type')){
							$query->where('type',request('experts_type'));
						}
						if(request('experts_name')) $query->where('name','like','%'.trim(request('experts_name')).'%');
						$rs = $query->orderBy('updated_at','DESC')->paginate(env('PERPAGE'));
						foreach($rs as $rd):
							$tags = $rd->tags ? explode(',', $rd->tags):[];
						?>
							<tr id="item_row{{$rd->id}}">
								<th scope="row">{{++$n}}</th>
								<td>{{$rd->type}}</td>
								<td>{{$rd->name}}</td>
								<td><img class="list-img" src="{{\App\Cm::get_pic($rd->id)}}" alt="{{$rd->name}}"></td>
								<td>{{$rd->mstatus == 'Y' ? '上線':'下線'}}</td>
								<th>
									<a class="btn btn-primary" href="/backend/experts/expert_edit?id={{$rd->id}}">編輯</a>
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
				<div>
				{{$rs->appends(['id'=>request('id'),'experts_type'=>request('experts_type'),'experts_name'=>request('experts_name') ])->links()}}
				</div>
			</div>
		</div>
    </div>
</div>
@endsection
@section('javascripts')
<script>
$(function(){
	$('.datatable').DataTable();
});

</script>
@endsection