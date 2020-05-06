@extends('backend.main')
@section('content')
@include('backend._top')
<?php
$types = ['hobby'=>'HOBBY','gunpla'=>'GUNPLA','prod'=>'商品介紹','shop'=>'賣場情報','funto'=>'模型教室', 'rnews'=>'右側新聞'];
?>
<div class="row">
    <div class="col-xs-12">
		<div class="card card-banner no-br">
			<div class="card-header">
			  <div class="card-title">
			    <div class="title">首頁內容管理</div>
			  </div>
			  <ul class="card-action">
			    <li><a class="btn btn-primary" href="/backend/home/news_edit">新增</a></li>
			  </ul>
			</div>
			<div class="card-body">
				<div class="back-srch">
					<form name="srchform" action="/backend/home/news" method="get" >
						<div class="form-inline">
							區塊：
							<select name="type" id="type" class="form-control">
								<option value="">請選擇</option>
								@foreach($types as $type=>$typename)
								<option value="{{$type}}" {{request('type') == $type ? 'selected':''}}>{{$typename}}</option>
								@endforeach
							</select>
							<input class="btn btn-primary" type="submit" name="goSearch" value="篩選" >
						</div>
					</form>
				</div>
				<?php
				$n = 0;
				?>
				<table class="table">
					<thead>
						<tr>
							<th>#</th>
							<th>區塊</th>
							<th>標題</th>
							<th>標籤</th>
							<th>日期</th>
							<th>排序</th>
							<th>編輯</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$wh = ['position'=>'index'];
						if(request('type')) $wh['type'] = request('type');
						$rs = \App\Cm::where($wh)->where('lang', session('lang'))->get();
						foreach($rs as $rd):
							$_tags = '';
							$atags = $rd->tags?explode(',', $rd->tags) : [];
							foreach($atags  as $t){
								if(!$t) continue;
								$tag = \App\Cm::where('position','tag')->where('name', $t)->first();
								if($tag){
									$_tags .= '<span class="tag" style="background:'.$tag->color.'">'.$t.'</span>&nbsp;';
								}
								
							}
						?>
							<tr id="item_row{{$rd->id}}">
								<th scope="row">{{++$n}}</th>
								<td>{{$rd->type}}</td>
								<td>{{$rd->name}}</td>
								<td>{!!$_tags!!}</td>
								<td>{{$rd->sdate}}</td>
								<td>{{$rd->psort}}</td>
								<th>
									<a class="btn btn-primary" href="/backend/home/news_edit?id={{$rd->id}}">編輯</a>
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