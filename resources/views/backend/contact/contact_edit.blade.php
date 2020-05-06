<?php
$awards = [];
if(request('id')){
	$rd = \App\ContactLogs::where('id', request('id'))->first();
	if(!$rd){
		session()->flash('sysmsg', '找不到您要編輯的資料');
		echo '<script>location.href="/backend/contact/index"</script>';
		exit;
	}
}else{
	$rd = new \stdClass();
	$rd->category= '其他';
	$rd->name= '';
	$rd->title= '';
	$rd->gender= '';
	$rd->company= '';
	$rd->address= '';
	$rd->email= '';
	$rd->tel= '';
	$rd->fax= '';
	$rd->subject= '';
	$rd->content= '';
	$rd->lang= session('lang');
}
?>
@extends('backend.main')
@section('content')
@include('backend._top')
<script src="//cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>
<div class="row">
    <div class="col-xs-12">
		<div class="card">
			<div class="card-header">
				<a href="/backend/contact/index">聯絡我們</a> - 編輯
			</div>
			<div class="card-body">
				<form class="form form-horizontal" id="edit_form" name="edit_form" enctype="multipart/form-data" method="post" action="/do/edit/contact">
					<div class="section">
						<div class="section-title">{{$rd->lang}}</div>
						<div class="section-body">
							<div class="form-group pad-btm-20">
								<label class="col-md-3 control-label">分類</label>
								<div class="col-md-9">
							  		<select class="form-control" name="category">
	                                    <option value="技術授權" {{$rd->category == '技術授權' ? 'selected':''}}>技術授權</option>
	                                    <option value="委託服務" {{$rd->category == '委託服務' ? 'selected':''}}>委託服務</option>
	                                    <option value="合作開發" {{$rd->category == '合作開發' ? 'selected':''}}>合作開發</option>
	                                    <option value="其他" {{$rd->category == '其他' ? 'selected':''}}>其他</option>
	                                </select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">姓名</label>
								<div class="col-md-9">
							  		<input type="text" name="name" class="form-control" placeholder="請輸入姓名" value="{{$rd->name}}">
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">性別</label>
								<div class="col-md-9">
									<div class="radio radio-inline">
										<input type="radio" name="gender" id="genderM" value="M" {{$rd->gender == 'M' ? 'checked':''}}>
										<label for="genderM">男</label>
									</div>
									<div class="radio radio-inline">
										<input type="radio" name="gender" id="genderF" value="N" {{$rd->gender == 'F' ? 'checked':''}}>
										<label for="genderF">女</label>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">公司</label>
								<div class="col-md-9">
							  		<input type="text" name="company" class="form-control" placeholder="請輸入公司" value="{{$rd->company}}">
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">職稱</label>
								<div class="col-md-9">
							  		<input type="text" name="title" class="form-control" placeholder="請輸入職稱" value="{{$rd->title}}">
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">地址</label>
								<div class="col-md-9">
							  		<input type="text" name="address" class="form-control" placeholder="請輸入地址" value="{{$rd->address}}">
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">電話</label>
								<div class="col-md-9">
							  		<input type="text" name="tel" class="form-control" placeholder="請輸入電話" value="{{$rd->tel}}">
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">傳真</label>
								<div class="col-md-9">
							  		<input type="text" name="fax" class="form-control" placeholder="請輸入傳真" value="{{$rd->fax}}">
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">Email</label>
								<div class="col-md-9">
							  		<input type="text" name="email" class="form-control" placeholder="請輸入Email" value="{{$rd->email}}">
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">主旨</label>
								<div class="col-md-9">
							  		<input type="text" name="subject" class="form-control" placeholder="請輸入主旨" value="{{$rd->subject}}">
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-3">
									<label class="control-label">內容</label>
									<p class="control-label-help">( 請輸入內容，最多2000字 )</p>
								</div>
								<div class="col-md-9">
									<textarea id="scontent" name="content">{!!$rd->content!!}</textarea>
									<script>CKEDITOR.replace( 'scontent', { height:300 } );</script>
								</div>
							</div>
						</div>
					</div>
					<div class="form-footer">
						<div class="form-group">
							<div class="col-md-9 col-md-offset-3">
								<button type="button" onclick="edit_form_submit('#edit_form')" class="btn btn-primary">儲存</button>
								<button type="button" class="btn btn-default">取消</button>
								<input type="hidden" name="id" value="{{request('id')}}">
								<input type="hidden" name="_token" value="{{csrf_token()}}">
								<input type="hidden" name="lang" value="{{$rd->lang ? $rd->lang : session('lang')}}">
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
});

</script>
@endsection