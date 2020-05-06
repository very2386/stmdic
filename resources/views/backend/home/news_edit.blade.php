<?php
$cur_tags = [];
if(request('id')){
	$rd = \App\Cm::where('id', request('id'))->first();
	if(!$rd){
		session()->flash('sysmsg', '找不到您要編輯的資料');
		echo '<script>location.href="/backend/home/news"</script>';
		exit;
	}
}else{
	$rd = new \stdClass();
	$rd->name= '';
	$rd->type='';
	$rd->objsn='';
	$rd->brief= '';
	$rd->mstatus= 'Y';
	$rd->tags = '';
	$rd->sdate='';
	$rd->psort='';
	$rd->link='';
	$rd->lang= session('lang');
}
$cur_tags = explode(',', $rd->tags);
$tags = \App\Cm::where('position','tag')->where('type','text')->get();
$types = ['hobby'=>'HOBBY','gunpla'=>'GUNPLA','prod'=>'商品介紹','shop'=>'賣場情報','funto'=>'模型教室',  'rnews'=>'右側新聞'];
?>
@extends('backend.main')
@section('content')
@include('backend._top')
<div class="row">
    <div class="col-xs-12">
		<div class="card">
			<div class="card-header">
				<a href="/backend/home/news">首頁內容設定</a> - 編輯
			</div>
			<div class="card-body">
				<form class="form form-horizontal" id="edit_form" name="edit_form" enctype="multipart/form-data" method="post" action="/do/edit/cm">
					<div class="section">
						<div class="section-title">{{session('lang')}}</div>
						<div class="section-body">
							<div class="form-group pad-btm-20">
								<label class="col-md-3 control-label">區塊</label>
								<div class="col-md-9">
							  		<select name="type" id="type" class="form-control">
							  			<option value="">請選擇</option>
							  			@foreach($types as $type=>$typename)
							  			<option value="{{$type}}" {{$rd->type == $type ? 'selected':''}}>{{$typename}}</option>
							  			@endforeach
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
									<label class="control-label">標籤</label>
									<p class="control-label-help">( 請勾選標籤 )</p>
								</div>
								<div class="col-md-9">
									@foreach($tags as $tag)
									<input type="checkbox" id="tag{{$tag->id}}" name="tags[]" value="{{$tag->name}}" {{ in_array($tag->name, $cur_tags) ? 'checked':'' }} >
									<label for="tag{{$tag->id}}">{{$tag->name}}</label>
									@endforeach
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">日期</label>
								<div class="col-md-9">
							  		<input type="text" name="sdate" class="form-control" placeholder="請輸入日期" value="{{$rd->sdate}}">
								</div>
							</div>
							<div class="form-group">
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
								<label class="col-md-3 control-label">排序</label>
								<div class="col-md-9">
							  		<input type="text" name="psort" class="form-control" placeholder="請輸入排序" value="{{$rd->psort}}">
								</div>
							</div>
						</div>
					</div>
					<div class="form-footer">
						<div class="form-group">
							<div class="col-md-9 col-md-offset-3">
								<button type="submit" class="btn btn-primary">儲存</button>
								<a class="btn btn-default" href="{{session('BACKPAGE')}}">回上一頁</a>
								<input type="hidden" name="_token" value="{{csrf_token()}}">
								<input type="hidden" name="id" value="{{request('id')}}">
								<input type="hidden" name="lang" value="{{$rd->lang ? $rd->lang : session('lang')}}">
								<input type="hidden" name="position" value="index">
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