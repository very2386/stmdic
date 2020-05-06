@extends('backend.main')
@section('content')
@include('backend._top')
<style type="text/css">
.simg img{
	max-width:60px;
	max-height:60px;
	margin:5px;
}
</style>
<div class="row">
    <div class="col-xs-12">
		<div class="card card-banner no-br">
			<div class="card-header">
			  <div class="card-title">
			    <div class="title">缺件申請管理</div>
			  </div>
			</div>
			<div class="card-body">
				<?php
				$n = 0;
				?>
				<table class="table">
					<thead>
						<tr>
							<th>#</th>
							<th>日期</th>
							<th>申請者</th>
							<th>商品</th>
							<th>缺件</th>
							<th>照片</th>
							<th>編輯</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$rs = \App\Applications::orderBy('id', 'desc')->paginate(10);
						foreach($rs as $rd):
						?>
							<tr id="item_row{{$rd->id}}">
								<td scope="row">{{++$n}}</td>
								<td>{{$rd->created_at}}</td>
								<td>{{$rd->name}}({{$rd->gender == 'M' ? '男':'女'}})<br />{{$rd->address}}</td>
								<td>{{$rd->product_name}}<br />{{$rd->product_sno}}</td>
								<td>{{$rd->parts_name}}<br />{{$rd->parts_sno}}</td>
								<td class="simg">
									@for($i=1; $i<=3; $i++)
									<?php $p = 'pic'.$i; ?>
									@if( $rd->{$p} )
										<img src="{{ $rd->{$p} }}" />
									@endif
									@endfor
								</td>
								<th>
									<a class="btn btn-primary" href="/backend/application/application_edit?id={{$rd->id}}">編輯</a>
									<a class="btn btn-danger" onclick="del_item( 'applications', '{{$rd->id}}');" >刪除</a>
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
				{{ $rs->links() }}
			</div>
		</div>
    </div>
</div>
@endsection