<?php
$rd = \App\Cm::where('position', 'about')->where('type', 'address')->where('lang', session('lang'))->first();
$lab = \App\Cm::where('position', 'about')->where('type', 'lab')->where('lang', session('lang'))->first();
if(!$rd) $rd = \App\Cm::create(['position'=>'about', 'type'=>'address', 'lang'=>session('lang'), 'cont'=>'' ]);
if(!$lab) $lab = \App\Cm::create(['position'=>'about', 'type'=>'lab', 'lang'=>session('lang'), 'cont'=>'' ]);
?>
@extends('backend.main')
@section('content')
@include('backend._top')
<div class="row">
    <div class="col-xs-12">
		<div class="card card-banner no-br">
			<div class="card-header">
			  <div class="card-title">
			    <div class="title">關於我們 - 公司地址</div>
			  </div>
			</div>
			<div class="card-body">
					<div class="container">
						<div class="row">
							<div class="col-sm-6">
								<form class="form form-horizontal edit_form" id="edit_form" name="edit_form" enctype="multipart/form-data" method="post" action="/do/edit/cm">
									<div>
										<label for="scont"><h3>公司地址</h3></label>
										<textarea id="scont" name="cont" style="width:100%; height:400px">{!!$rd->cont!!}</textarea>
									</div>
									<div class="text-center pad-top-20 pad-btm-20">
										<button type="submit" class="btn btn-primary">儲存</button>
										<input type="hidden" name="_token" value="{{csrf_token()}}">
										<input type="hidden" name="lang" value="{{session('lang')}}">
										<input type="hidden" name="position" value="about">
										<input type="hidden" name="type" value="address">
										<input type="hidden" name="id" value="{{$rd->id}}">
										<input type="hidden" name="name" value="公司地址">
									</div>
								</form>
							</div>
							<div class="col-sm-6">
								<form class="form form-horizontal edit_form" id="lab_form" name="lab_form" enctype="multipart/form-data" method="post" action="/do/edit/cm">
									<div>
										<label for="lcont"><h3>實驗室地址</h3></label>
										<textarea id="lcont" name="cont"  style="width:100%;  height:400px">{!!$lab->cont!!}</textarea>
									</div>
									<div class="text-center pad-top-20 pad-btm-20">
										<button type="submit" class="btn btn-primary">儲存</button>
										<input type="hidden" name="_token" value="{{csrf_token()}}">
										<input type="hidden" name="lang" value="{{session('lang')}}">
										<input type="hidden" name="position" value="about">
										<input type="hidden" name="type" value="lab">
										<input type="hidden" name="id" value="{{$lab->id}}">
										<input type="hidden" name="name" value="實驗室地址">
									</div>
								</form>
							</div>
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