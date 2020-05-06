
@extends('backend.main')
@section('content')
@include('backend._top')
<div class="row">
    <div class="col-xs-12">
		<div class="card card-banner no-br">
			<div class="card-header">
			  <div class="card-title">
			    <div class="title">廠商相關資料統計</div>
			  </div>
			  <ul class="card-action">
			    <!-- <li><a class="btn btn-primary" href="/backend/company/company_edit">新增</a></li> -->
			  </ul>
			</div>
			<div class="card-body">
				<!-- <canvas id="myChart" width="500" height="600" style="padding: 0px 30px 20px 30px;"></canvas> -->
				<?php
				$comp_data = \App\Members::where('type','醫材廠商')->where('name','!=','')->whereNotIn('name',['廠商教學','廠商測試'])->orderBy('id','ASC')->get() ; 
				$n = 1 ; 
				?>
				<table class="table datatable">
					<thead>
						<tr>
							<th>#</th>
							<th>廠商名稱</th>
							<th>總登入次數</th>
							<th>更新內容頻率</th>
						</tr>
					</thead>
					<tbody>
						@foreach($comp_data as $comp)
						<?php
						$times = \App\SysLogs::where('type','company_login')->where('mid',$comp->id)->get()->count();
						$update =  \App\SysLogs::where('type','company_update')->where('mid',$comp->id)->get() ; 
						$startdate = strtotime("2018-01-01");
						$enddate = strtotime(date("Y-m-d"));    
						$days = round(($enddate-$startdate)/3600/24) ;
						?>
						<tr>
							<th scope="row">{{$n++}}</th>
							<td scope="row">{{$comp->name}}</td>
							<td>{{$times}} 次</td>
							<td>{{$times!=0?$days/$times:$times}} 日/次</td>
						</tr>
						@endforeach
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
		"pageLength" : 100,
	});
});
</script>
@endsection