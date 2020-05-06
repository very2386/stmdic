<?php
$rs = \App\Cm::where('position', 'circles')->where('lang', session('lang'))->orderBy('psort', 'asc')->get();
?>
@extends('backend.main')
@section('content')
@include('backend._top')
<div class="row">
    <div class="col-xs-12">
		<div class="card card-banner no-br">
			<div class="card-header">
			  <div class="card-title">
			    <div class="title">首頁圓球圖片</div>
			  </div>
			</div>
			<div class="card-body">
				<form class="form form-horizontal" id="circles_upload_form" name="circles_upload_form" enctype="multipart/form-data" method="post" action="/do/edit/circles">
					<div class="w80">
						<div class="row">
						<?php for($n=0; $n < 3; $n++):?>
							<div class="col-sm-4">
								<div class="circles-img text-center">
									<img src="{{\App\Cm::get_pic(isset($rs[$n])? $rs[$n]->id:'')}}" />
								</div>
								<div>
									<input type="file" class="form-control" name="circles_pic{{$n}}" />
								</div>
								<div>
									<input type="text" class="form-control" name="link{{$n}}" placeholder="請輸入連結(含http://)" value="{{$rs[$n]->link}}" />
								</div>
							</div>
						<?php endfor;?>
						</div>
						<div class="text-center circles-but">
							<input class="btn btn-primary" type="submit" name="goUploadCircles" value="上傳" />
							<input type="hidden" name="_token" value="{{csrf_token()}}">
							<input type="hidden" name="lang" value="{{session('lang')}}">
							<input type="hidden" name="position" value="circles">
						</div>
					</div>
				</form>
			</div>
		</div>
    </div>
</div>
@endsection
@section('javascripts')
<script>
$(function(){
	register_form('#circles_upload_form', function(res){
		reload_page();
	});
});

</script>
@endsection