<?php
$ars = \App\Act::where('type', 'GBWC')->orderBy('id', 'desc')->get();
if(!$ars) $ars = [];
?>
@extends('backend.main')
@section('content')
@include('backend._top')
<script src="//cdn.ckeditor.com/4.6.2/full/ckeditor.js"></script>
<style type="text/css">
.model_brief>div{
	display:none;
}
</style>
<div class="row">
    <div class="col-xs-12">
		<div class="card">
			<div class="card-header">
				GBWC報名管理
			</div>
			<div class="card-body">
	            <div class="section">
	            	<div class="section-body">
						<form name="filter-form" class="form-inline back-srch" method="get" action="/backend/act/join">
							篩選條件：
							活動：
							<select name="id" class="form-control">
								@foreach($ars as $ard)
									<option value="{{$ard->id}}" {{request('id') == $ard->id?'selected':''}}>{{$ard->name}}</option>
								@endforeach
							</select>&nbsp;&nbsp;
							區域：
							<select class="form-control" name="model_place">
							  <option value="" <?php if(!request('model_place')) echo "selected";?> >不分</option>
							  <option value="0" <?php if(request('model_place') == '0') echo "selected";?> >北區</option>
							  <option value="1" <?php if(request('model_place') == '1') echo "selected";?> >南區</option>
							</select>
							<input name="page" type="hidden" value="join" >
							<input class="btn btn-primary" name="search" type="submit" value="查詢" >
							<?php if(request('model_place') || request('pen_name')) { ?>
							<input class="btn btn-warning" name="clear" type="button" value="清除" onClick="location.href='/backend/act/act_edit?id={{request('id')}}&page=join'" >
							<?php } ?>
							<a class="btn btn-info" href='/export/{{request('id')}}?&model_place={{request('model_place')}}' target='_blank'>匯出excel</a>
						</form>
						@if(!request('id'))
						<div style="padding:50px;" class="text-center">請先選擇活動</div>
						@else
						<table class="table jointable">
						  <thead>
						    <tr>
						      <th>&nbsp;</th>
						      <th>報名時間</th>
						      <th>(會員＃)姓名<br />筆名</th>
						      <th width="25%">作品名稱<br>(使用模型)</th>
						      <th>尺寸</th>
						      <th>說明</th>
						      <th>地點</th>
						      <th>報到</th>
						      <th>&nbsp;</th>
						    </tr>
						  </thead>
						  <tbody>
						  <?php
						  $i = 0;
						  $where = ['asn'=>request('id')];
						  if(request('model_place') == '0' || request('model_place') == '1') $where['model_place'] = request('model_place');
						  $gjrs = \App\GbwcJoin::where($where)->get();
						  foreach($gjrs as $rd){
						    $i++;
						    $mrd = \App\Members::where('id', $rd->msn)->first();
						    if(!$mrd) $mrd = \App\Members::new_object();
						  ?>
						    <tr id="item_row<?=$rd['sn'];?>">
						      <td><?=$i;?></td>
						      <th><?=date("Y-m-d H:i",$rd->adate);?></th>
						      <td><?=$mrd->lname.$mrd->fname;?>(<?=$mrd->id;?>)<br /><?=$rd->pen_name;?></td>
						      <td><?=$rd->model_title;?><br />(<?=$rd->model_type;?>)</td>
						      <td><?=$rd->model_size;?></td>
						      <td><a class="model_brief">檢視<div><?=nl2br($rd->model_brief);?></div></a></td>
						      <td><?=$rd->model_place == '1' ? '南區' : '北區';?></td>
						      <th><?=$rd->mstatus == 'Y'?'已報到':'';?></th>
						      <td>
						      <a class="btn btn-primary" href="/backend/act/gbwc_join_edit?id=<?=$rd->id;?>">編輯</a>&nbsp;
						      <a class="btn btn-danger" onClick="del_item('gbwc_join', '<?=$rd->id;?>');">刪除</a></td>
						    </tr>
						  <?php
						  }
						  ?>
						  </tbody>
						</table>
						@endif
					</div>
				</div>
			</div>
		</div>
    </div>
</div>
@endsection
@section('javascripts')
<script>
$(function(){
	$('.jointable').DataTable();
});

</script>
@endsection