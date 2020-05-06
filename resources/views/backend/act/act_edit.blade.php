<?php
$page = request('page') ? request('page'):'info'; 
if(request('id')){
	$rd = \App\Act::where('id', request('id'))->first();
	if(!$rd){
		session()->flash('sysmsg', '找不到您要編輯的資料');
		echo '<script>location.href="/backend/act/index"</script>';
		exit;
	}
	$title = $rd->name;
}else{
	$rd = new \stdClass();
	$rd->name= '';
	$rd->type='';
	$rd->year='';
	$rd->description= '';
	$rd->mstatus= 'Y';
	$rd->agreement = '';
	$rd->adate='';
	$rd->psort='';
	$rd->lang= session('lang');
	$title = '新增活動';
}
$types = ['一般報名', '專車報名', 'GBWC'];
$sdate = $rd->adate ? date('Y-m-d', $rd->adate) : ''; 
$self = '/backend/act/act_edit?id='.request('id');
?>
@extends('backend.main')
@section('content')
@include('backend._top')
<link rel="stylesheet" href="/pickadate/themes/default.css">
<link rel="stylesheet" href="/pickadate/themes/default.date.css"> 
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
				<a href="/backend/act/index">活動管理</a> - {{$title}} - 編輯
			</div>
			<div class="card-body">
				<div role="tabpanel">
				    <!-- Nav tabs -->
				    <ul class="nav nav-tabs" role="tablist">
				        <li role="presentation" class="{{$page == 'info'?'active':''}}"><a href="{{$self.'&page=info'}}" >活動資料</a></li>
				        @if(request('id'))
				        <li role="presentation" class="{{$page == 'agreement'?'active':''}}"><a href="{{$self.'&page=agreement'}}" >同意條款</a></li>
				        @if($rd->type == '一般報名')
				        <li role="presentation" class="{{$page == 'detail'?'active':''}}"><a href="{{$self.'&page=detail'}}" >場次</a></li>
				        @elseif($rd->type == '專車報名')
				        <li role="presentation" class="{{$page == 'car'?'active':''}}"><a href="{{$self.'&page=car'}}" >班車</a></li>
				        @endif
				        <li role="presentation" class="{{$page == 'join'?'active':''}}"><a href="{{$self.'&page=join'}}" >報名記錄</a></li>
				        @endif
				    </ul>
				</div>
				@if($page == 'info')
	            <form class="form form-horizontal" id="edit_form" name="edit_form" enctype="multipart/form-data" method="post" action="/do/edit/act">
	            	<div class="section">
	            		<div class="section-body">
	            			<div class="form-group pad-btm-20">
	            				<label class="col-md-3 control-label">類別</label>
	            				<div class="col-md-9">
	            			  		<select name="type" id="type" class="form-control">
	            			  			<option value="">請選擇</option>
	            			  			@foreach($types as $type)
	            			  			<option value="{{$type}}" {{$rd->type == $type ? 'selected':''}}>{{$type}}</option>
	            			  			@endforeach
	            			  		</select>
	            				</div>
	            			</div>
	            			<div class="form-group">
	            				<label class="col-md-3 control-label">年度</label>
	            				<div class="col-md-9">
	            			  		<input type="text" name="year" class="form-control" placeholder="請輸入年度" value="{{$rd->year}}">
	            				</div>
	            			</div>
	            			<div class="form-group">
	            				<label class="col-md-3 control-label">標題</label>
	            				<div class="col-md-9">
	            			  		<input type="text" name="name" class="form-control" placeholder="請輸入標題" value="{{$rd->name}}">
	            				</div>
	            			</div>
	            			<div class="form-group">
	            				<label class="col-md-3 control-label">日期</label>
	            				<div class="col-md-9">
	            			  		<input type="text" name="sdate" class="form-control" placeholder="請輸入日期" value="{{$sdate}}">
	            				</div>
	            			</div>
	            			<div class="form-group">
	            				<label class="col-md-3 control-label">圖片</label>
	            				<div class="col-md-9">
	            					<div class="input-group">
	            				    	<input type="file" name="picfile" class="form-control" aria-label="上傳圖片">
	            					</div>
	            					@if(request('id'))
	            						<div class="image-preview">
	            							<img src="{{\App\Act::get_pic($rd->id)}}" />
	            						</div>
	            					@endif
	            				</div>
	            			</div>
	            			<div class="form-group">
	            				<label class="col-md-3 control-label">顯示狀態</label>
	            				<div class="col-md-9">
	            					<div class="radio radio-inline">
	            						<input type="radio" name="mstatus" id="mstatusY" value="Y" {{$rd->mstatus == 'Y' ? 'checked':''}}>
	            						<label for="mstatusY">顯示</label>
	            					</div>
	            					<div class="radio radio-inline">
	            						<input type="radio" name="mstatus" id="mstatusN" value="N" {{$rd->mstatus == 'N' ? 'checked':''}}>
	            						<label for="mstatusN">隱藏</label>
	            					</div>
	            				</div>
	            			</div>
	            			<div class="form-group">
	            				<label class="col-md-3 control-label">活動狀態</label>
	            				<div class="col-md-9">
	            					<select name="jstatus" id="jstatus">
	            						<option value="N" {{$rd->jstatus == 'N'?'selected':''}}>未開始</option>
	            						<option value="Y" {{$rd->jstatus == 'Y'?'selected':''}}>報名中</option>
	            						<option value="F" {{$rd->jstatus == 'F'?'selected':''}}>報名截止</option>
	            						<option value="A" {{$rd->jstatus == 'A'?'selected':''}}>收件（報到）中</option>
	            						<option value="B" {{$rd->jstatus == 'B'?'selected':''}}>收件（報到）截止</option>
	            						<option value="C" {{$rd->jstatus == 'C'?'selected':''}}>開放取件</option>
	            					</select>
	            				</div>
	            			</div>
	            			<div class="form-group">
	            				<div class="col-md-3">
	            					<label class="control-label">敘述</label>
	            					<p class="control-label-help">( 請輸入內容，最多500字 )</p>
	            				</div>
	            				<div class="col-md-9">
	            					<textarea id="description" name="description" class="form-control">{!!$rd->description!!}</textarea>
	            				</div>
	            			</div>
	            		</div>
	            	</div>
	            	<div class="form-footer">
	            		<div class="form-group">
	            			<div class="col-md-9 col-md-offset-3">
	            				<button type="submit" class="btn btn-primary">儲存</button>
	            				<button type="button" class="btn btn-default" onclick="load_page('/backend/act/index')">取消</button>
	            				<input type="hidden" name="_token" value="{{csrf_token()}}">
	            				<input type="hidden" name="id" value="{{request('id')}}">
	            				<input type="hidden" name="lang" value="{{$rd->lang ? $rd->lang : session('lang')}}">
	            			</div>
	            		</div>
	            	</div>
	            </form>
	            @elseif($page == 'agreement')
				<form class="form form-horizontal" id="edit_form" name="edit_form" enctype="multipart/form-data" method="post" action="/do/edit/act">
	            	<div class="section">
	            		<div class="section-body">
	            			<div class="form-group">
	            				<div class="col-md-12">
	            					<label class="control-label">同意條款</label>
	            					<p class="control-label-help">( 請輸入內容，最多5000字 )</p>
	            				</div>
	            				<div class="col-md-12">
	            					<textarea id="agreement" name="agreement" class="form-control">{!!$rd->agreement!!}</textarea>
	            					<script>CKEDITOR.replace( 'agreement', { height:800 } );</script>
	            				</div>
	            			</div>
	            		</div>
	            	</div>
	            	<div class="form-footer">
	            		<div class="form-group">
	            			<div class="col-md-12 col-md-offset-3">
	            				<a onclick="edit_form_submit('#edit_form')" class="btn btn-primary">儲存</a>
	            				<button type="button" class="btn btn-default" onclick="load_page('/backend/act/index')">取消</button>
	            				<input type="hidden" name="_token" value="{{csrf_token()}}">
	            				<input type="hidden" name="name" value="{{$rd->name}}">
	            				<input type="hidden" name="year" value="{{$rd->year}}">
	            				<input type="hidden" name="type" value="{{$rd->type}}">
	            				<input type="hidden" name="adate" value="{{$rd->adate}}">
	            				<input type="hidden" name="description" value="{{$rd->description}}">
	            				<input type="hidden" name="id" value="{{request('id')}}">
	            				<input type="hidden" name="lang" value="{{$rd->lang ? $rd->lang : session('lang')}}">
	            			</div>
	            		</div>
	            	</div>
	            </form>
	            @elseif($page== 'detail')
	            <div class="section">
	            	<div class="section-body">

						<table class="table jointable">
			              <thead>
			                <tr>
			                  <th>&nbsp;</th>
			                  <th>名稱(班次)</th>
			                  <th>日期</th>
			                  <th>時間</th>
			                  <th>報名</th>
			                  <th>人數限制</th>
			                  <th>目前報名</th>
			                  <th>Status</th>
			                  <th>&nbsp;</th>
			                </tr>
			              </thead>
			              <tbody>
			              <?php
							$i = 0;
							$adrs = \App\ActDetail::where('asn', request('id'))->orderBy('act_date', 'asc')->orderBy('psort', 'asc')->get();
							foreach($adrs as $rd){
								$i++;
								$join_adult = \App\ActJoin::where('adsn', $rd->id)->sum('adult');
								$join_child = \App\ActJoin::where('adsn', $rd->id)->sum('child');
								$join_total = $join_adult + $join_child;
							?>
			                <tr id="item_row<?=$rd['sn'];?>">
			                  <td><?=$i;?></td>
			                  <td><?=$rd->name.'('.$rd->psort.')';?></td>
			                  <td><?=$rd->act_date;?></td>
			                  <td><?=$rd->act_stime;?></td>
			                  <td><?=date("Y-m-d H:i:s",$rd->adate);?></td>
			                  <td><?=$rd->join_limit;?></td>
			                  <td><?=$join_total;?> (成人<?=$join_adult;?> / 兒童<?=$join_child;?>)</td>
			                  <td><?=$rd->mstatus;?></td>
			                  <td>
			                  <a class="btn btn-primary" href="/backend/act/act_detail_edit.php?id={{$rd->id}}&parent={{request('id')}}">編輯</a>&nbsp;
			                  <a class="btn btn-info" href="/backend/act/act_detail_edit.php?act=dup&id={{$rd->id}}&parent={{request('id')}}">複製</a>&nbsp;
			                  <a class="btn btn-danger" onClick="del_item('act_detail', '{{$rd->id}}');">Del</a></td>
			                </tr>
			              <?php
							}
						  ?>
			              </tbody>
			            </table>
			        </div>
			    </div>
			    @elseif($page == 'car')
			    <div class="section">
	            	<div class="section-body">
	            		<form name="filter-form" class="form-inline back-srch" method="get" action="/backend/act/act_edit">
							篩選條件：
							專車名稱
							<input name="car_place" type="text" value="<?=request('car_place');?>"  class="form-control" >
							日期
							<input name="car_date" type="text" value="<?=request('car_date');?>"  class="form-control" >
							<input name="id" type="hidden" value="<?=request('id');?>" >
							<input name="page" type="hidden" value="car" >
							<input class="btn btn-primary" name="search" type="submit" value="查詢" >
							<a href="/backend/act/car_edit?asn={{request('id')}}" class="pull-right btn btn-primary">新增</a>
						</form>
						<table class="table">
						<thead>
						  <tr>
						    <th>&nbsp;</th>
						    <th>專車名稱</th>
						    <th>日期</th>
						    <th>允許人數</th>
						    <th>報名人數</th>
						    <th>&nbsp;</th>
						  </tr>
						</thead>
						<tbody>
						<?php
						$i = 0;
						$where = ['asn'=>request('id')];
						if(request('car_date')) $where['car_date'] = request('car_date');
						if(request('car_place')) $where['car_place'] = request('car_place');
						$crs = \App\Car::where($where)->get();
						foreach($crs as $crd){
						  $i++;
						?>
						  <tr id="item_row<?=$crd->id;?>">
						    <td><?=$i;?></td>
						    <td><?=$crd->car_place;?></td>
						    <td><?=$crd->car_date;?></td>
						    <td><?=$crd->max_num;?></td>
						    <td><?=$crd->cur_num;?></td>
						    <td><a class="btn btn-primary" href="/backend/act/car_edit?asn={{request('id')}}&id=<?=$rd->id;?>">Edit</a>&nbsp;
						      <a class="btn btn-danger" onclick="del_item('car', '<?=$rd['sn'];?>');">Delete</a>
						    </td>
						  </tr>
						<?php
						}
						?>
						</tbody>
						</table>
			        </div>
			      </div>
			    </div>
	            @elseif($page == 'join')
				<div class="section">
	            	<div class="section-body">
						<form name="filter-form" class="form-inline back-srch" method="get" action="/backend/act/act_edit">
							送件地點：
							<select class="form-control" name="model_place">
							  <option value="" <?php if(!request('model_place')) echo "selected";?> >不分</option>
							  <option value="0" <?php if(request('model_place') == '0') echo "selected";?> >北區</option>
							  <option value="1" <?php if(request('model_place') == '1') echo "selected";?> >南區</option>
							</select>
							<input name="id" type="hidden" value="<?=request('id');?>" >
							<input name="page" type="hidden" value="join" >
							<input class="btn btn-primary" name="search" type="submit" value="查詢" >
							<?php if(request('model_place') || request('pen_name')) { ?>
							<input class="btn btn-warning" name="clear" type="button" value="清除" onClick="location.href='/backend/act/act_edit?id={{request('id')}}&page=join'" >
							<?php } ?>
							<a class="btn btn-info" href='/export/{{request('id')}}?&model_place={{request('model_place')}}' target='_blank'>匯出excel</a>
						</form>
						<table class="table jointable">
						  <thead>
						    <tr>
						      <th>&nbsp;</th>
						      <th>報名時間</th>
						      <th>(會員＃)姓名<br />筆名</th>
						      <th width="25%">作品名稱<br>(使用模型)</th>
						      <th>作品說明</th>
						      <th>地點</th>
						      <th>&nbsp;</th>
						    </tr>
						  </thead>
						  <tbody>
						  <?php
						  $i = 0;
						  $where = ['asn'=>request('id')];
						  if(request('model_place') == '0' || request('model_place') == '1') $where['model_place'] = request('model_place');
						  if(request('pen_name')) $where['pen_name'] = request('pen_name');
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
						      <td><a class="model_brief">檢視<div><?=nl2br($rd->model_brief);?></div></a></td>
						      <td><?=$rd->model_place == '1' ? '南區' : '北區';?></td>
						      <td>
						      <a class="btn btn-primary" href="/backend/act/gbwc_join_edit?id=<?=$rd->id;?>&parent=<?=request('id')?>">編輯</a>&nbsp;
						      <a class="btn btn-danger btn-del-admin" onClick="del_item('gbwc_join', '<?=$rd->id;?>');">刪除</a></td>
						    </tr>
						  <?php
						  }
						  ?>
						  </tbody>
						</table>
					</div>
				</div>
	            @endif
			</div>
		</div>
    </div>
</div>
@endsection
@section('javascripts')
<script>
$(function(){
	@if($page == 'info' || $page == 'agreement')
	register_form('#edit_form',function(res){
		load_page('?id='+res.id);
	});
	@endif
	$('.model_brief').click(function(){
		var brief = $(this).children('div').html();
		msgbox_show(brief, '作品介紹');
	})
	$('.jointable').DataTable();
});

</script>
@endsection