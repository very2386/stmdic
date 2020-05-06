<?php
$news = \App\Cm::where('position', 'member_index')->where('mstatus', 'Y')->where('lang', session('lang'))->orderBy('created_at', 'desc')->get();
$rs = [];
for($i=0; $i < 3; $i++){
	$rd = \App\Cm::where('position', 'member_index')->where('lang', session('lang'))->where('psort', $i)->first();
	if(!$rd) $rd = \App\Cm::create(['position'=>'home','type'=>'member_index','lang'=>session('lang'),'psort'=>$i]);
	$rs[$rd->id] = $rd;
}

?>
@extends('backend.main')
@section('content')
@include('backend._top')
<div class="row">
    <div class="col-xs-12">
		<div class="card card-banner no-br">
			<div class="card-header">
			  <div class="card-title">
			    <div class="title">會員中心首頁新聞選擇</div>
			  </div>
			</div>
			<div class="card-body">
				
					<div class="w80">
						<div class="row">
						<?php foreach($rs as $id=> $rd):
						?>
							<div class="col-sm-4">
								<form class="form form-horizontal edit_form" id="edit_form{{$id}}" name="edit_form{{$id}}" enctype="multipart/form-data" method="post" action="/do/edit/cm">
									<div class="circles-img text-center">
										<img src="{{\App\Cm::get_pic($id)}}" />
									</div>
									<div class="pad-btm-20">
										<input type="file" class="form-control" name="picfile" />
									</div>
									<div class="pad-btm-20">
										<select name="objsn" class="form-control">
											<option {{ !$rd->objsn ? 'selected':'' }}>請選擇</option>
											<?php foreach($news as $new):?>
												<option value="{{$new->id}}" {{ $rd->objsn == $new->id ? 'selected':'' }}>{{$new->name}}</option>
											<?php endforeach;?>
										</select>
									</div>
									<div class="text-center circles-but">
										<input class="btn btn-primary" type="submit" name="goSetHomeNews" value="上傳" />
										<input type="hidden" name="_token" value="{{csrf_token()}}">
										<input type="hidden" name="lang" value="{{session('lang')}}">
										<input type="hidden" name="position" value="member_index">
										<input type="hidden" name="psort" value="{{$rd->psort}}">
										<input type="hidden" name="id" value="{{$id}}">
										<input type="hidden" name="name" value="首頁新聞圖片">
									</div>
								</form>
							</div>
						<?php endforeach;?>
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
	register_form('.edit_form', function(res){
		reload_page();
	});
});

</script>
@endsection