<?php
if(request('id')){
	$rd = \App\Cm::where('id', request('id'))->first();
	if(!$rd){
		session()->flash('sysmsg', '找不到您要編輯的資料');
		echo '<script>location.href="/backend/news/index"</script>';
		exit;
	}
	$conts = json_decode($rd->cont) ; 
}else{
	$rd =\App\Cm::new_obj();
	$rd->up_sn = request('up_sn');
	$rd->type = '廠商徵才' ;
	$conts = \App\Cm::new_compresume_obj();
}
$company = \App\Cm::where('id', $rd->up_sn)->first();
?>
@extends('backend.main')
@section('content')
@include('backend._top')
<script src="//cdn.ckeditor.com/4.6.2/full/ckeditor.js"></script>
<div class="row">
    <div class="col-xs-12">
		<div class="card">
			<div class="card-header">
				<a href="/backend/company/index">廠商管理</a> &nbsp; &gt; &nbsp; 
				<a href="/backend/company/company_edit?id={{$rd->up_sn}}">{{$company->name}}</a>&nbsp; &gt; &nbsp;<a href="/backend/company/company_edit/廠商徵才?id={{$rd->up_sn}}">廠商徵才</a> - {{$rd->name}} 編輯
			</div>
			<div class="card-body">
				<form class="form form-horizontal" id="edit_form" name="edit_form" enctype="multipart/form-data" method="post" action="/do/company_resume_edit">
					<div class="section">
						<div class="section-title">{{session('lang')}}</div>
						<div class="form-group">
							<label class="col-md-3 control-label">職務類別</label>
							<div class="col-md-9">
								<div class="radio radio-inline">
									<input type="radio" name="job_type" id="job_full" value="job_full" {{$conts->job_type=='job_full'?'checked':''}}>
									<label for="job_full">全職</label>
								</div>
								<div class="radio radio-inline">
									<input type="radio" name="job_type" id="job_part" value="job_part" {{$conts->job_type=='job_part'?'checked':''}}>
									<label for="job_part">兼職</label>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label">招聘職務名稱</label>
							<div class="col-md-9">
						  		<input type="text" name="job_title" class="form-control" placeholder="請輸入廠商招聘職務名稱" value="{{$conts->job_title}}">
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-3">
								<label class="control-label">工作內容</label>
							</div>
							<div class="col-md-9">
								<textarea id="job_intro" name="job_intro" class="form-control">{{$conts->job_intro}}</textarea>
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-3">
								<label class="control-label">必要條件</label>
							</div>
							<div class="col-md-9">
								<textarea id="job_necessary" name="job_necessary" class="form-control">{{$conts->job_necessary}}</textarea>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label">工作地點</label>
							<div class="col-md-9">
						  		<input type="text" name="job_location" class="form-control" placeholder="請輸入工作地點" value="{{$conts->job_location}}">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label">工作經驗</label>
							<div class="col-md-9">
						  		<input type="text" name="job_exp" class="form-control" placeholder="請輸入工作經驗" value="{{$conts->job_exp}}">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label">招聘日期</label>
							<div class="col-md-9">
						  		<input type="text" name="job_date" class="form-control" placeholder="請輸入招聘日期" value="{{$conts->job_date}}">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label">到職日期</label>
							<div class="col-md-9">
						  		<input type="text" name="job_arrivedate" class="form-control" placeholder="請輸入到職日期" value="{{$conts->job_arrivedate}}">
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-3">
								<label class="control-label">工作待遇</label>
							</div>
							<div class="col-md-9">
								<textarea id="job_salary" name="job_salary" class="form-control">{{$conts->job_salary}}</textarea>
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-3">
								<label class="control-label">員工福利制度</label>
							</div>
							<div class="col-md-9">
								<textarea id="job_benefit" name="job_benefit" class="form-control">{{$conts->job_benefit}}</textarea>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label">關鍵字</label>
							<div class="col-md-9">
						  		<input type="text" name="job_keyword" class="form-control" placeholder="請輸入關鍵字" value="{{$conts->job_keyword}}">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label">聯絡人姓名</label>
							<div class="col-md-9">
						  		<input type="text" name="job_contact" class="form-control" placeholder="請輸入聯絡人姓名" value="{{$conts->job_contact}}">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label">聯絡人電話</label>
							<div class="col-md-9">
						  		<input type="text" name="job_phone" class="form-control" placeholder="請輸入聯絡人電話" value="{{$conts->job_phone}}">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label">聯絡人E-mail</label>
							<div class="col-md-9">
						  		<input type="text" name="job_email" class="form-control" placeholder="請輸入聯絡人E-mail" value="{{$conts->job_email}}">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label">徵才網址</label>
							<div class="col-md-9">
						  		<input type="text" name="job_url" class="form-control" placeholder="請輸入徵才網址" value="{{$conts->job_url}}">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label">排序</label>
							<div class="col-md-9">
						  		<input type="text" name="psort" class="form-control" placeholder="請輸入排序" value="{{$rd->psort}}"><div class="small-notes">數字越大越前面</div>
							</div>
						</div>
						<!-- <div class="form-group">
							<label class="col-md-3 control-label">列表圖片(小)</label>
							<div class="col-md-9">
								@if(request('id'))
									<div class="image-preview">
										<img src="{{\App\Cm::get_spic($rd->id)}}" style="max-width:100%; max-height:300px" />
									</div>
								@endif
								<div class="input-group">
							    	<input type="file" name="spicfile" class="form-control" aria-label="上傳圖片">
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label">圖片</label>
							<div class="col-md-9">
								@if(request('id'))
									<div class="image-preview">
										<img src="{{\App\Cm::get_pic($rd->id)}}" style="max-width:100%; max-height:300px" />
									</div>
								@endif
								<div class="input-group">
							    	<input type="file" name="picfile" class="form-control" aria-label="上傳圖片">
								</div>
							</div>
						</div> -->
						<div class="form-group">
							<label class="col-md-3 control-label">狀態</label>
							<div class="col-md-9">
								<div class="radio radio-inline">
									<input type="radio" name="mstatus" id="mstatusY" value="Y" {{$rd->mstatus == 'Y' ? 'checked':''}}>
									<label for="mstatusY">上線</label>
								</div>
								<div class="radio radio-inline">
									<input type="radio" name="mstatus" id="mstatusN" value="N" {{$rd->mstatus == 'N' ? 'checked':''}}>
									<label for="mstatusN">下線</label>
								</div>
							</div>
						</div>
					</div>
					<div class="form-footer">
						<div class="form-group">
							<div class="col-md-9 col-md-offset-3">
								<button type="button" onclick="edit_form_submit('#edit_form')" class="btn btn-primary">儲存</button>
								<a class="btn btn-default" href="/backend/company/company_edit/廠商徵才?id={{$rd->up_sn}}">回上一頁</a>
								<input type="hidden" name="_token" value="{{csrf_token()}}">
								<input type="hidden" name="up_sn" value="{{$rd->up_sn}}">
								<input type="hidden" name="id" value="{{request('id')}}">
								<input type="hidden" name="lang" value="{{$rd->lang ? $rd->lang : session('lang')}}">
								<input type="hidden" name="position" value="comp_resume">
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
    </div>
</div>
@include('backend._modalMedia')
@endsection
@section('javascripts')
<script>
$(function(){
	register_form('#edit_form', function(res){
		load_page('/backend/company/company_edit/廠商徵才?id='+res.id);
	});
});
</script>
@endsection