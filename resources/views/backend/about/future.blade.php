<?php
$rd = \App\Cm::where('position', 'about')->where('type', 'future')->where('lang', session('lang'))->first();
if(!$rd) $rd = \App\Cm::create(['position'=>'about', 'type'=>'future', 'lang'=>session('lang')]);
?>
@extends('backend.main')
@section('content')
@include('backend._top')
<script src="//cdn.ckeditor.com/4.6.2/full/ckeditor.js"></script>
<div class="row">
    <div class="col-xs-12">
		<div class="card">
			<div class="card-header">
				<a href="/backend/about/future">關於我們 - 未來願景</a>
			</div>
			<div class="card-body">
				<form class="form form-horizontal" id="edit_form" name="edit_form" enctype="multipart/form-data" method="post" action="/do/edit/cm">
					<div class="section">
						<div class="section-title">{{session('lang')}}</div>
						<div class="section-body">
							<div class="form-group">
								<div class="col-md-12">
									<label class="control-label">內容</label>
									<p class="control-label-help">( 請輸入內容，最多2000字 )</p>
								</div>
								<div class="col-md-12">
									<textarea id="scont" name="cont">{!!$rd->cont!!}</textarea>
									<script>CKEDITOR.replace( 'scont', { height:600 } );</script>
								</div>
							</div>
						</div>
					</div>
					<div class="form-footer">
						<div class="form-group">
							<div class="col-md-12">
								<button type="button" onclick="edit_form_submit('#edit_form')" class="btn btn-primary">儲存</button>
								<button type="reset" class="btn btn-default">取消</button>
								<input type="hidden" name="_token" value="{{csrf_token()}}">
								<input type="hidden" name="id" value="{{$rd->id}}">
								<input type="hidden" name="lang" value="{{$rd->lang ? $rd->lang : session('lang')}}">
								<input type="hidden" name="position" value="about">
								<input type="hidden" name="type" value="future">
								<input type="hidden" name="name" value="未來願景">
							</div>
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
	register_form('#edit_form', function(res){
		reload_page();
	});
});
</script>
@endsection