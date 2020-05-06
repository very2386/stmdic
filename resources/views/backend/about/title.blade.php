<?php
$rd = \App\Cm::where('position', 'title')->where('type', 'about')->where('lang', session('lang'))->first();
$id = $rd ? $rd->id : '';
?>
@extends('backend.main')
@section('content')
@include('backend._top')
<div class="row">
    <div class="col-xs-12">
		<div class="card card-banner no-br">
			<div class="card-header">
			  <div class="card-title">
			    <div class="title">關於我們標題圖片</div>
			  </div>
			</div>
			<div class="card-body">
				<form class="form form-horizontal" id="about_title_upload" name="about_title_upload" enctype="multipart/form-data" method="post" action="/do/edit/title">
					<div class="w80">
						<div class="circles-img text-center">
							<img src="{{\App\Cm::get_pic($id)}}" />
						</div>
						<div>
							<input type="file" class="form-control" name="title_pic" />
						</div>
						<div class="text-center circles-but">
							<input class="btn btn-primary" type="submit" name="goUploadCircles" value="上傳" />
							<input type="hidden" name="_token" value="{{csrf_token()}}">
							<input type="hidden" name="lang" value="{{session('lang')}}">
							<input type="hidden" name="position" value="title">
							<input type="hidden" name="type" value="about">
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
	register_form('#about_title_upload', function(res){
		reload_page();
	});
});

</script>
@endsection