<?php
$rd = \App\Cm::where('position', 'title')->where('type', 'news')->where('lang', session('lang'))->first();
$rs = \App\Cm::where('position', 'news')->where('mstatus', 'Y')->where('lang', session('lang'))->get();
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
			    <div class="title">置頂消息標題圖片</div>
			  </div>
			</div>
			<div class="card-body">
				<form class="form form-horizontal" id="title_upload" name="title_upload" enctype="multipart/form-data" method="post" action="/do/edit/cm">
					<div class="w80">
						<div class="circles-img text-center">
							<img src="{{\App\Cm::get_pic($id)}}" />
						</div>
						<div>
							<input type="file" class="form-control" name="picfile" />
						</div>
						<div class="row">
							<div class="col-sm-3"><label>選擇新聞</label></div>
							<div class="col-sm-9">
								<select class="form-control" name="objsn">
									@foreach($rs as $nd)
										<option value="{{$nd->id}}" {{$rd->objsn == $nd->id ? 'selected':''}}>{{$nd->name}}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="text-center circles-but">
							<input class="btn btn-primary" type="submit" name="goUploadCircles" value="上傳" />
							<input type="hidden" name="_token" value="{{csrf_token()}}">
							<input type="hidden" name="lang" value="{{session('lang')}}">
							<input type="hidden" name="position" value="title">
							<input type="hidden" name="name" value="HOBBY NEWS置頂新聞">
							<input type="hidden" name="type" value="news">
							<input type="hidden" name="id" value="{{$id}}">
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
	register_form('#title_upload', function(res){
		reload_page();
	});
});

</script>
@endsection