<?php
if(request('id')){
	$mrd = \App\Members::where('id', request('id'))->first();
	if(!$mrd){
		session()->flash('sysmsg', '找不到您要編輯的資料');
		echo '<script>location.href="/backend/member/index"</script>';
		exit;
	}
}else{
	$mrd = \App\Members::new_object();
}
$members_type = \App\Cm::get_members_type() ; 
?>
@extends('backend.main')
@section('content')
@include('backend._top')
<div class="row">
    <div class="col-xs-12">
		<div class="card">
			<div class="card-header">
				<a href="/backend/member/index">會員資料</a> - 編輯
			</div>
			<div class="card-body">
	            <form class="form form-horizontal" id="edit_form" name="edit_form" enctype="multipart/form-data" method="post" action="/do/backend_member_edit">
	            	<div class="section">
	            		<div class="section-body">
	            			<!-- <div class="form-group pad-btm-20">
	            				<label class="col-md-3 control-label">會員編號</label>
	            				<div class="col-md-9">
	            			  		{{$mrd->id}}
	            			  		<input type="hidden" name="id" value="{{$mrd->id}}">
	            				</div>
	            			</div> -->
	            			<div class="form-group">
								<label class="col-md-3 control-label">會員照片</label>
								<div class="col-md-8">
									@if(request('id'))
										<div class="image-preview">
											<img src="{{\App\Members::get_pic($mrd->id)}}" style="max-width:100%; max-height:300px" />
										</div>
									@endif
									<div class="input-group">
								    	<input type="file" name="pic" class="form-control" aria-label="上傳圖片">
									</div>
								</div>
							</div>
	            			<div class="form-group">
	            				<label class="col-md-3 control-label">會員類別</label>
	            				<div class="col-md-9">
	            					<select name="type" id="type" class="form-control">
	            						@foreach($members_type as $type)
							  				<option value="{{$type}}" {{$mrd->type == $type ? 'selected' : '' }}>{{$type}}</option>
							  			@endforeach	
	            					</select>
	            				</div>
	            			</div>
	            			<div class="form-group">
	            				<label class="col-md-3 control-label">會員帳號</label>
	            				<div class="col-md-9">
	            			  		<input type="text" name="loginid" class="form-control" value="{{$mrd->loginid}}" placeholder="請輸入會員帳號">
	            				</div>
	            			</div>
	            			<div class="form-group">
	            				<label class="col-md-3 control-label">Email</label>
	            				<div class="col-md-9">
	            			  		<input type="text" name="email" class="form-control" value="{{$mrd->email}}" placeholder="請輸入Email">
	            				</div>
	            			</div>
	            			<div class="form-group">
	            				<label class="col-md-3 control-label">密碼</label>
	            				<div class="col-md-9">
	            			  		<input type="password" name="passwd" class="form-control" placeholder="請輸入密碼">
	            				</div>
	            			</div>
	            			<div class="form-group">
	            				<label class="col-md-3 control-label">確認密碼</label>
	            				<div class="col-md-9">
	            			  		<input type="password" name="passwd_chk" class="form-control"  placeholder="請輸入密碼">
	            				</div>
	            			</div>
	            			<div class="form-group">
	            				<label class="col-md-3 control-label">會員姓名</label>
	            				<div class="col-md-9">
	            			  		<input type="text" name="name" class="form-control" value="{{$mrd->name}}" placeholder="請輸入會員姓名">
	            				</div>
	            			</div>
	            			<div class="form-group">
	            				<label class="col-md-3 control-label">暱稱</label>
	            				<div class="col-md-9">
	            			  		<input type="text" name="sname" class="form-control" value="{{$mrd->sname}}" placeholder="請輸入暱稱">
	            				</div>
	            			</div>
	            			<div class="form-group">
	            				<label class="col-md-3 control-label">會員簡介</label>
	            				<div class="col-md-9">
	            			  		<input type="text" name="brief" class="form-control" value="{{$mrd->brief}}" placeholder="請輸入會員簡介">
	            				</div>
	            			</div>
	            			<!-- <div class="form-group">
	            				<label class="col-md-3 control-label">行業類別</label>
	            				<div class="col-md-9">
	            			  		<input type="text" name="industry" class="form-control" value="{{$mrd->industry}}" placeholder="請輸入行業類別">
	            				</div>
	            			</div>
	            			<div class="form-group">
	            				<label class="col-md-3 control-label">職務類別</label>
	            				<div class="col-md-9">
	            			  		<input type="text" name="duties" class="form-control" value="{{$mrd->duties}}" placeholder="請輸入職務類別">
	            				</div>
	            			</div>
	            			<div class="form-group">
	            				<label class="col-md-3 control-label">職務部門</label>
	            				<div class="col-md-9">
	            			  		<input type="text" name="apartment" class="form-control" value="{{$mrd->apartment}}" placeholder="請輸入職務部門">
	            				</div>
	            			</div>
	            			<div class="form-group">
	            				<label class="col-md-3 control-label">生日</label>
	            				<div class="col-md-9">
	            			  		<input type="text" name="birth" class="form-control datepicker" placeholder="請輸入日期" value="{{$mrd->birth}}">
	            				</div>
	            			</div> -->
	            			<div class="form-group">
	            				<label class="col-md-3 control-label">性別</label>
	            				<div class="col-md-9">
	            			  		<select class="form-control" name="gender">
	            			  			<option value="M" {{$mrd->gender == 'M'?'selected':''}}>男</option>
	            			  			<option value="F" {{$mrd->gender == 'F'?'selected':''}}>女</option>
	            			  		</select>
	            				</div>
	            			</div>
	            			<div class="form-group">
								<label class="col-md-3 control-label">狀態</label>
								<div class="col-md-9">
									<div class="radio radio-inline">
										<input type="radio" name="mstatus" id="mstatusY" value="Y" {{$mrd->mstatus == 'Y' ? 'checked':''}}>
										<label for="mstatusY">正常</label>
									</div>
									<div class="radio radio-inline">
										<input type="radio" name="mstatus" id="mstatusN" value="N" {{$mrd->mstatus == 'N' ? 'checked':''}}>
										<label for="mstatusN">停權</label>
									</div>
								</div>
							</div>
							<!-- <div class="form-group">
	            				<label class="col-md-3 control-label">註冊驗證碼</label>
	            				<div class="col-md-9">
	            			  		<input type="text" name="regcode" class="form-control" placeholder="註冊驗證碼" value="{{$mrd->regcode}}">
	            				</div>
	            			</div>
	            			<div class="form-group">
	            				<label class="col-md-3 control-label">訂閱會員專涵</label>
	            				<div class="col-md-9">
	            			  		<select class="form-control" name="epaper">
	            			  			<option value="Y" {{$mrd->epaper == 'Y'?'selected':''}}>訂閱</option>
	            			  			<option value="N" {{$mrd->gender != 'Y'?'selected':''}}>不訂閱</option>
	            			  		</select>
	            				</div>
	            			</div>
	            			<div class="form-group">
	            				<label class="col-md-3 control-label">訂閱商品/活動訊息</label>
	            				<div class="col-md-9">
	            			  		<select class="form-control" name="epaper2">
	            			  			<option value="Y" {{$mrd->epaper == 'Y'?'selected':''}}>訂閱</option>
	            			  			<option value="N" {{$mrd->gender != 'Y'?'selected':''}}>不訂閱</option>
	            			  		</select>
	            				</div>
	            			</div> -->
	            		</div>
	            	</div>
	            	<div class="form-footer">
	            		<div class="form-group">
	            			<div class="col-md-9 col-md-offset-3">
	            				<button type="submit" class="btn btn-primary">儲存</button>
	            				<a class="btn btn-default" href="/backend/member/index">取消</a>
	            				<input type="hidden" name="_token" value="{{csrf_token()}}">
	            				<input type="hidden" name="id" value="{{request('id')}}">
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
	register_form('#edit_form',function(res){
		load_page('?id='+res.id);
	});
	$('.datepicker').pickadate({format: 'yyyy-mm-dd', selectYears:50, max: new Date()});
});
</script>
@endsection