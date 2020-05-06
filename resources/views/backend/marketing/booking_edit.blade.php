<?php
if(request('id')){
	$rd = \App\Cm::where('id', request('id'))->first();
	if(!$rd){
		session()->flash('sysmsg', '找不到您要編輯的資料');
		echo '<script>location.href="/backend/marketing/prospect"</script>';
		exit;
	}
	$cont = json_decode($rd->cont) ; 
}else{
	$rd = \App\Cm::new_obj();
	$cont = (object)["title"=>"","purpose"=>"","group"=>"","num_people"=>""];
}
?>
@extends('backend.main')
@section('content')
@include('backend._top')
<script src="//cdn.ckeditor.com/4.6.2/full/ckeditor.js"></script>
<div class="row">
    <div class="col-xs-12">
		<div class="card">
			<div class="card-header">
				<a href="/backend/marketing/booking">醫材展示室-預約使用</a> - 編輯
			</div>
			<div class="card-body">
				<form class="form form-horizontal" id="edit_form" name="edit_form" enctype="multipart/form-data" method="post" action="/do/edit/cm">
					<div class="section">
						<div class="section-body">
							<div class="form-group">
								<label class="col-md-3 control-label">日期</label>
								<div class="col-md-9">
									<div class="input-group">
								        <input type="text" name="edate" class="form-control datepicker" placeholder="請選擇日期" value="{{substr($rd->edate,0,10)}}">
								    </div>
								</div>
							</div>
							<div class="form-group">
	            				<label class="col-md-3 control-label">時間</label>
	            				<div class="col-md-9">
	            					<select name="obj" id="obj" class="form-control">
							  			<option value="上午" {{$rd->obj == "上午" ? 'selected' : '' }}>上午</option>
							  			<option value="下午" {{$rd->obj == "下午" ? 'selected' : '' }}>下午</option>
	            					</select>
	            				</div>
	            			</div>
							<div class="form-group">
								<label class="col-md-3 control-label">活動名稱</label>
								<div class="col-md-9">
							  		<input type="text" name="title" class="form-control" placeholder="請輸入活動名稱" value="{{$cont->title}}">
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">目的</label>
								<div class="col-md-9">
							  		<input type="text" name="purpose" class="form-control" placeholder="請輸入目的" value="{{$cont->purpose}}">
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">來訪團體</label>
								<div class="col-md-9">
							  		<input type="text" name="group" class="form-control" placeholder="請輸入來訪團體" value="{{$cont->group}}">
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">人數</label>
								<div class="col-md-9">
							  		<input type="text" name="num_people" class="form-control" placeholder="請輸入人數" value="{{$cont->num_people}}">
								</div>
							</div>
							<div class="form-group">
	            				<label class="col-md-3 control-label">場地</label>
	            				<div class="col-md-9">
	            					<select name="type" id="type" class="form-control">
							  			<option value="展示室" {{$rd->type == "展示室" ? 'selected' : '' }}>展示室</option>
							  			<option value="會議室" {{$rd->type == "會議室" ? 'selected' : '' }}>會議室</option>
	            					</select>
	            				</div>
	            			</div>
							<div class="form-group">
								<label class="col-md-3 control-label">聯絡人</label>
								<div class="col-md-9">
							  		<input type="text" name="name" class="form-control" placeholder="請輸入聯絡人" value="{{$rd->name}}">
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">聯絡電話</label>
								<div class="col-md-9">
							  		<input type="text" name="comptel" class="form-control" placeholder="請輸入聯絡電話" value="{{$rd->comptel}}">
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">聯絡E-mail</label>
								<div class="col-md-9">
							  		<input type="text" name="email" class="form-control" placeholder="請輸入聯絡E-mail" value="{{$rd->email}}">
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-3">
									<label class="control-label">備註</label>
									<p class="control-label-help">( 請輸入說明，最多100字 )</p>
								</div>
								<div class="col-md-9">
									<textarea id="brief" name="brief" class="form-control">{!!$rd->brief!!}</textarea>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">狀態</label>
								<div class="col-md-9">
									<div class="radio radio-inline">
										<input type="radio" name="mstatus" id="statusY" value="Y" {{$rd->mstatus == 'Y' ? 'checked':''}}>
										<label for="statusY">預約</label>
									</div>
									<div class="radio radio-inline">
										<input type="radio" name="mstatus" id="statusN" value="N" {{$rd->mstatus == 'N' ? 'checked':''}}>
										<label for="statusN">取消預約</label>
									</div>
								</div>
							</div>				
						</div>
					</div>
					<div class="form-footer">
						<div class="form-group">
							<hr class="col-md-12"/>
							<div class="col-md-9 col-md-offset-3">
								<button type="submit" class="btn btn-primary">儲存</button>
								<button type="button" class="btn btn-default" onclick="history.back()">取消</button>
								<input type="hidden" name="_token" value="{{csrf_token()}}">
								<input type="hidden" name="id" value="{{request('id')}}">
								<input type="hidden" name="up_sn" value="{{$rd->up_sn}}">
								<input type="hidden" name="lang" value="{{$rd->lang ? $rd->lang : session('lang')}}">
								<input type="hidden" name="position" value="booking">
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
		load_page('?id='+res.id);
	});
	$('.datepicker').pickadate({format: 'yyyy-mm-dd'});
});
</script>
@endsection