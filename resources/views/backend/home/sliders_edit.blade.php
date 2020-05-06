<?php
if(request('id')){
	$rd = \App\Cm::where('id', request('id'))->first();
	if(!$rd){
		session()->flash('sysmsg', '找不到您要編輯的資料');
		echo '<script>location.href="/backend/home/silders"</script>';
		exit;
	}
}else{
	$rd = \App\Cm::new_obj();
	$rd->position = request('position') ? request('position') : 'home';
}
?>
@extends('backend.main')
@section('content')
@include('backend._top')
<div class="row">
    <div class="col-xs-12">
		<div class="card">
			<div class="card-header">
				<a href="/backend/home/sliders">首頁輪播大圖</a> - 編輯
			</div>
			<div class="card-body">
				<form class="form form-horizontal" id="sliders_edit_form" name="sliders_edit_form" enctype="multipart/form-data" method="post" action="/do/edit/cm">
					<div class="section">
						<div class="section-title">{{session('lang')}}</div>
						<div class="section-body">
							<div class="form-group">
								<label class="col-md-3 control-label">位置</label>
								<div class="col-md-9">
							  		<select name="position" id="position" class="form-control">
							  			<option value="home" {{$rd->position == 'home' ? 'selected':''}}>首頁</option>
							  			<option value="market" {{$rd->position == 'market' ? 'selected':''}}>行銷專區(上)</option>
							  			<option value="market_footer" {{$rd->position == 'market_footer' ? 'selected':''}}>行銷專區(下)</option>
							  		</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">標題</label>
								<div class="col-md-9">
							  		<input type="text" name="name" class="form-control" placeholder="請輸入標題" value="{{$rd->name}}">
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-3">
									<label class="control-label">說明</label>
									<p class="control-label-help">( 請輸入說明，最多100字 )</p>
								</div>
								<div class="col-md-9">
									<textarea id="brief" name="brief" class="form-control">{!!$rd->brief!!}</textarea>
								</div>
							</div>
							<div class="form-group" style="margin-bottom: 20px">
								<label class="col-md-3 control-label">圖片</label>
								<div class="col-md-9">
									<div class="input-group">
								    	<input type="file" name="picfile" class="form-control" aria-label="上傳圖片">
									</div>
									@if(request('id'))
										<div class="image-preview">
											<img src="{{\App\Cm::get_pic($rd->id)}}" />
										</div>
									@endif
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-3">
									<label class="control-label">超連結</label>
									<div class="notes">開頭請加上 http:// </div>
								</div>
								<div class="col-md-9">
									<input type="text" name="link" class="form-control" placeholder="請輸入超連結" value="{{$rd->link}}">
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">下架日期</label>
								<div class="col-md-9">
									<div class="input-group">
								        <input type="text" name="edate" class="form-control datepicker" placeholder="請選擇下架日期" value="{{substr($rd->edate,0,10)}}">
								    </div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">排序</label>
								<div class="col-md-9">
							  		<input type="text" name="psort" class="form-control" placeholder="請輸入排序" value="{{$rd->psort}}"><div class="small-notes">數字越大越前面</div>
								</div>
							</div>
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
					</div>
					<div class="form-footer">
						<div class="form-group">
							<div class="col-md-9 col-md-offset-3">
								<button type="submit" class="btn btn-primary">儲存</button>
								<button type="button" class="btn btn-default">取消</button>
								<input type="hidden" name="_token" value="{{csrf_token()}}">
								<input type="hidden" name="id" value="{{request('id')}}">
								<input type="hidden" name="lang" value="{{$rd->lang ? $rd->lang : session('lang')}}">
								<input type="hidden" name="type" value="slider">
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
	register_form('#sliders_edit_form', function(res){
		load_page('?id='+res.id);
	});
	$('.datepicker').pickadate({format: 'yyyy-mm-dd'});
});

</script>
@endsection