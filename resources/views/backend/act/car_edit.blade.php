<?php
$asn = request('asn');
if(request('id')){
	$rd = \App\Car::where('id', request('id'))->first();
	if(!$rd){
		session()->flash('sysmsg', '找不到您要編輯的資料');
		echo '<script>location.href="/backend/act/act_edit?id='.$asn.'"</script>';
		exit;
	}
}else{
	$rd = (object)['asn'=>$asn, 'car_date'=>'', 'cur_num'=>0, 'max_num'=>0, 'max_join'=>0, 'car_place'=>'', 'notes'=>''];
}
?>
@extends('backend.main')
@section('content')
@include('backend._top')
<style type="text/css">
.model_brief>div{
	display:none;
}
</style>
<div class="row">
    <div class="col-xs-12">
		<div class="card">
			<div class="card-header">
				<a href="/backend/act/act_edit?id={{$asn}}&page=car">專車管理</a> - 編輯
			</div>
			<div class="card-body">
	            <form class="form form-horizontal" id="edit_form" name="edit_form" enctype="multipart/form-data" method="post" action="/do/edit/car">
	            	<div class="section">
	            		<div class="section-body">
	            			<div class="form-group pad-btm-20">
	            				<label class="col-md-3 control-label">專車活動</label>
	            				<div class="col-md-9">
	            			  		{{ \App\Act::where('id', request('asn'))->value('name') }}
	            			  		<input type="hidden" name="asn" value="{{$rd->asn}}">
	            				</div>
	            			</div>
	            			<div class="form-group">
	            				<label class="col-md-3 control-label">專車名稱</label>
	            				<div class="col-md-9">
	            			  		<input type="text" name="car_place" class="form-control" placeholder="請輸入專車名稱" value="{{$rd->car_place}}">
	            				</div>
	            			</div>
	            			<div class="form-group">
	            				<label class="col-md-3 control-label">發車日期</label>
	            				<div class="col-md-9">
	            			  		<input type="text" name="car_date" class="form-control" placeholder="請輸入日期" value="{{$car_date}}">
	            				</div>
	            			</div>
	            			<div class="form-group">
	            				<label class="col-md-3 control-label">專車人數</label>
	            				<div class="col-md-9">
	            			  		<input type="text" name="max_num" class="form-control" placeholder="人數上限" value="{{$rd->max_num}}">
	            				</div>
	            			</div>
	            			<div class="form-group">
	            				<label class="col-md-3 control-label">目前報名</label>
	            				<div class="col-md-9">
	            			  		<input type="text" name="cur_num" class="form-control" placeholder="目前人數" value="{{$rd->cur_num}}">
	            				</div>
	            			</div>
	            			<div class="form-group">
	            				<label class="col-md-3 control-label">每人限報人數</label>
	            				<div class="col-md-9">
	            			  		<input class="form-control" name="max_join" value="{{$rd->max_join}}" type="text" />
                      				設定為1代表限會員本人(但未成年會自動強制跟隨一位成年人)
	            				</div>
	            			</div>
	            			<div class="form-group">
	            				<div class="col-md-3">
	            					<label class="control-label">報名提醒內容</label>
	            					<p class="control-label-help">( 請輸入內容，最多500字 )</p>
	            				</div>
	            				<div class="col-md-9">
	            					<textarea id="notes" name="notes" class="form-control">{!!$rd->notes!!}</textarea>
	            				</div>
	            			</div>
	            		</div>
	            	</div>
	            	<div class="form-footer">
	            		<div class="form-group">
	            			<div class="col-md-9 col-md-offset-3">
	            				<button type="submit" class="btn btn-primary">儲存</button>
	            				<button type="button" class="btn btn-default">取消</button>
	            				<input type="hidden" name="_token" value="{{csrf_token()}}">
	            				<input type="hidden" name="id" value="{{request('id')}}">
	            				<input type="hidden" name="lang" value="{{$rd->lang ? $rd->lang : session('lang')}}">
	            			</div>
	            		</div>
	            	</div>
	            </form>
	            @if(request('id'))
	            <div class="section">
	            	<div class="section-body">
	            		<h3>專車報名記錄</h3>
						<table class="table datatable">
							<thead>
								<tr>
									<th>&nbsp;</th>
									<th>會員編號</th>
									<th>報名日期</th>
									<th>會員姓名</th>
									<th>監護人</th>
									<th>大人人數</th>
									<th>小孩人數</th>
									<th>&nbsp;</th>
								</tr>
							</thead>
							<tbody>
							<?php
							$i = 0;
							$adrs = \App\ActJoin::where('carsn', request('id'))->orderBy('id', 'asc')->get();
							if(!$adrs) $adrs = [];
							foreach($adrs as $ard){
								$jrd=\App\ActJoinDetail::where('jsn', $ard->id)->where('type', 'member')->first();
								$mrd = \App\Members::where('id', $ard->msn)->first();
						    	if(!$mrd) $mrd = \App\Members::new_object();
								$i++;
							?>
								<tr id="item_row<?=$ard->id;?>">
									<td><?=$i;?></td>
									<td><?=$ard->msn;?></td>
									<td><?=date('Y-m-d H:i:s', $ard->adate);?></td>
									<td><?=$jrd->name;?></td>
									<td><?=$mrd->guardian_lname.$mrd->guardian_fname;?></td>
									<td><?=$ard->adult;?></td>
									<td><?=$ard->child;?></td>
									<td>&nbsp;
									<a class="btn btn-primary" onClick="show_detail('<?=$ard->id;?>')">檢視</a>
									</td>
								</tr>
								<tr id="detail_row<?=$ard->id;?>" style="display:none">
									<td colspan="8">
										<table class="table">
											<tr>
												<th>序</th>
												<th>資料別</th>
												<th>姓名</th>
												<!--<th>性別</th>-->
												<th>身份證號</th>
												<th>出生日</th>
												<th>Email</th>
												<th>手機</th>
												<th>地址</th>
											</tr>
											<?php
											$u = 0;
											$data_type = array("member"=>"會員本人", "guardian"=>"監護人", "guest"=>"乘客" );
											$genders = array("M"=>"男生","F"=>"女生");
											$drs = \App\ActJoinDetail::where('jsn', $ard->id)->orderBy('id', 'asc')->get();
											if(!$drs) $drs = [];
											foreach($drs as $drd){
											?>
											<tr>
												<td><?=++$u;?></td>
												<td><?=$data_type[$drd->type];?>
												<?=$drd->psort ? $drd->psort:'';?></td>
												<td><?=$drd->name;?></td>
												<!--<td><?=$drd->gender ? $genders[$drd->gender]:'';?></td>-->
												<td><?=$drd->idnum;?></td>
												<td><?=$drd->birth;?></td>
												<td><?=$drd->email;?></td>
												<td><?=$drd->mobile;?></td>
												<td><?=$drd->address;?></td>
											</tr>
											<?php }?>
										</table>
									</td>
								</tr>
							<?php } ?>
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
	$('.datatable').DataTable();
});

</script>
@endsection