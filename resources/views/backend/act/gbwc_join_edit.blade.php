<?php
$back = '/backend/act/join';

if(request('id')){
	$rd = \App\GbwcJoin::where('id', request('id'))->first();
	if(!$rd){
		session()->flash('sysmsg', '找不到您要編輯的資料');
		echo '<script>location.href="/backend/act/join"</script>';
		exit;
	}
	$back = '/backend/act/join?id='.$rd->asn;
	if(request('parent')) $back = '/backend/act/act_edit?id='.request('parent').'&page=join';
	$mrd = \App\Members::where('id', $rd->msn)->first();
}
?>
@extends('backend.main')
@section('content')
@include('backend._top')
<script src="//cdn.ckeditor.com/4.6.2/full/ckeditor.js"></script>
<style type="text/css">
.model_brief>div{
	display:none;
}
</style>
<div class="row">
    <div class="col-xs-12">
		<div class="card">
			<div class="card-header">
				<a href="{{$back}}">GBWC報名資料</a> - 編輯
			</div>
			<div class="card-body">
	            <form class="form form-horizontal" id="edit_form" name="edit_form" enctype="multipart/form-data" method="post" action="/do/edit/gbwc_join">
	            	<div class="section">
	            		<div class="section-body">
	            			<div class="form-group pad-btm-20">
	            				<label class="col-md-3 control-label">活動名稱</label>
	            				<div class="col-md-9">
	            			  		{{ \App\Act::where('id', $rd->asn)->value('name') }}
	            			  		<input type="hidden" name="asn" value="{{$rd->asn}}">
	            				</div>
	            			</div>
	            			<div class="form-group pad-btm-20">
	            				<label class="col-md-3 control-label">會員編號</label>
	            				<div class="col-md-9">
	            			  		{{ $rd->msn }}
	            			  		<input type="hidden" name="msn" value="{{$rd->msn}}">
	            				</div>
	            			</div>
	            			<div class="form-group">
	            				<label class="col-md-3 control-label">會員姓名</label>
	            				<div class="col-md-9 form-inline">
	            			  		姓：<input type="text" name="lname" class="form-control" value="{{$mrd->lname}}">
	            			  		名：<input type="text" name="fname" class="form-control" value="{{$mrd->fname}}">
	            				</div>
	            			</div>
	            			<div class="form-group">
	            				<label class="col-md-3 control-label">生日</label>
	            				<div class="col-md-9">
	            			  		<input type="text" name="birth" class="form-control" placeholder="請輸入日期" value="{{$mrd->birth}}">
	            				</div>
	            			</div>
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
	            				<label class="col-md-3 control-label">身份證五碼</label>
	            				<div class="col-md-9">
	            			  		<input type="text" name="idnum" class="form-control" value="{{$mrd->idnum}}">
	            				</div>
	            			</div>
	            			<div class="form-group">
	            				<label class="col-md-3 control-label">市話</label>
	            				<div class="col-md-9">
	            			  		<input type="text" name="tel" class="form-control" value="{{$mrd->tel}}">
	            				</div>
	            			</div>
	            			<div class="form-group">
	            				<label class="col-md-3 control-label">手機</label>
	            				<div class="col-md-9">
	            			  		<input type="text" name="mobile" class="form-control" value="{{$mrd->mobile}}">
	            				</div>
	            			</div>
	            			<div class="form-group">
	            				<label class="col-md-3 control-label">居住縣市</label>
	            				<div class="col-md-9">
	            			  		<input type="text" name="county" class="form-control" value="{{$mrd->county}}">
	            				</div>
	            			</div>
	            			<div class="form-group">
	            				<label class="col-md-3 control-label">鄉鎮區</label>
	            				<div class="col-md-9">
	            			  		<input type="text" name="district" class="form-control" value="{{$mrd->district}}">
	            				</div>
	            			</div>
	            			<div class="form-group">
	            				<label class="col-md-3 control-label">地址</label>
	            				<div class="col-md-9">
	            			  		<input type="text" name="address" class="form-control" value="{{$mrd->address}}">
	            				</div>
	            			</div>
	            			<div class="form-group">
	            				<label class="col-md-3 control-label">筆名</label>
	            				<div class="col-md-9">
	            			  		<input type="text" name="pen_name" class="form-control" value="{{$rd->pen_name}}">
	            				</div>
	            			</div>
	            			<div class="form-group">
	            				<label class="col-md-3 control-label">作品名稱</label>
	            				<div class="col-md-9">
	            			  		<input type="text" name="model_title" class="form-control" value="{{$rd->model_title}}">
	            				</div>
	            			</div>
	            			<div class="form-group">
	            				<label class="col-md-3 control-label">使用模型</label>
	            				<div class="col-md-9">
	            			  		<input type="text" name="model_type" class="form-control" value="{{$rd->model_type}}">
	            				</div>
	            			</div>
	            			<div class="form-group">
	            				<label class="col-md-3 control-label">作品尺寸</label>
	            				<div class="col-md-9">
	            			  		<select name="model_size" class="form-control">
	            			  			<option value="S" {{$rd->model_size=='S'?'selected':''}}>小</option>
	            			  			<option value="M" {{$rd->model_size=='M'?'selected':''}}>中</option>
	            			  			<option value="L" {{$rd->model_size=='L'?'selected':''}}>大</option>
	            			  		</select>
	            				</div>
	            			</div>
	            			<div class="form-group">
	            				<label class="col-md-3 control-label">作品介紹</label>
	            				<div class="col-md-9">
	            			  		<textarea id="model_brief" name="notes" class="form-control">{!!$rd->model_brief!!}</textarea>
	            				</div>
	            			</div>
	            			<div class="form-group">
	            				<label class="col-md-3 control-label">交件地點</label>
	            				<div class="col-md-9">
	            			  		<select name="model_place" id="model_place" class="form-control">
										<option value="0" <?php if('0' == $rd->model_place) echo "selected";?> >北區</option>
										<option value="1" <?php if('1' == $rd->model_place) echo "selected";?> >南區</option>
									</select>
	            				</div>
	            			</div>
	            			<div class="form-group">
	            				<label class="col-md-3 control-label">報到</label>
	            				<div class="col-md-9">
	            			  		<select class="form-control" name="mstatus">
	            			  			<option value="Y" {{$rd->mstatus == 'Y'?'selected':''}}>已報到</option>
	            			  			<option value="N" {{$rd->mstatus != 'Y'?'selected':''}}>未報到</option>
	            			  		</select>
	            				</div>
	            			</div>
	            			<div class="form-group">
	            				<label class="col-md-3 control-label">報到時間</label>
	            				<div class="col-md-9">
	            			  		<input type="text" name="checkin_time" class="form-control" value="{{$rd->checkin_time}}">
	            				</div>
	            			</div>
	            			<div class="form-group">
	            				<label class="col-md-3 control-label">設定人員</label>
	            				<div class="col-md-9">
	            			  		<input type="text" class="form-control" value="{{\App\Admins::where('id',$rd->adminid)->value('name')}}">
	            				</div>
	            			</div>
	            		</div>
	            	</div>
	            	<div class="form-footer">
	            		<div class="form-group">
	            			<div class="col-md-9 col-md-offset-3">
	            				<button type="submit" class="btn btn-primary">儲存</button>
	            				<button type="button" class="btn btn-default" onclick="history.back();">取消</button>
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
	register_form('#edit_form');
});

</script>
@endsection