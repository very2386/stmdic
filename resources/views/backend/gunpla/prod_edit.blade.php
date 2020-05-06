<?php
if(request('id')){
	$rd = \App\Cm::where('id', request('id'))->first();
	$spec = \App\Products::where('pid', request('id'))->first();
}else{
	$rd = (object)['tags'=>'', 'sdate'=>'', 'mstatus'=>'Y', 'name'=>'', 'brief'=>'', 'cont'=>'', 'psort'=>''];
	$spec = (object)['price'=>'', 'saledate'=>'', 'age'=>'', 'attachments'=>'', 'contents'=>'', 'series'=>'', 'works'=>''];
}
$tags = explode(',', $rd->tags);
$tags_rs = \App\Tags::where('type', 'prod')->orderby('name', 'asc')->get();
$series_rs = \App\Cm::where('position', 'series')->where('type', 'gunpla')->where('mstatus', 'Y')->get();
$works_rs = \App\Cm::where('position', 'works')->where('type', 'gunpla')->where('mstatus', 'Y')->get();
?>
@extends('backend.main')
@section('content')
@include('backend._top')
<script src="//cdn.ckeditor.com/4.6.2/full/ckeditor.js"></script>
<div class="row">
    <div class="col-xs-12">
		<div class="card">
			<div class="card-header">
				<a href="/backend/gunpla/index">GUNPLA商品</a> - 編輯
			</div>
			<div class="card-body">
				<form class="form form-horizontal" id="edit_form" name="edit_form" enctype="multipart/form-data" method="post" action="/do/edit/product">
					<div class="section">
						<div class="section-title">{{session('lang')}}</div>
						<div class="section-body">
							<div class="form-group pad-btm-20">
								<label class="col-md-3 control-label">商品標籤</label>
								<div class="col-md-9 tags">
							  		@foreach($tags_rs as $tag)
										<span class="tag" for="tag{{$tag->id}}" style="background:{{$tag->color}}"><input id="tag{{$tag->id}}" type="checkbox" name="tags[]" value="{{$tag->name}}" {{in_array($tag->name, $tags) ? 'checked':''}} >{{$tag->name}}</span>&nbsp;&nbsp;
									@endforeach
								</div>
							</div>
							<div class="form-group pad-btm-20">
								<label class="col-md-3 control-label">品牌 / 系列</label>
								<div class="col-md-9">
							  		<select name="series" id="series" class="form-control">
					  			  		@foreach($series_rs as $srd)
					  			  			<option value="{{$srd->id}}" {{$spec->series == $srd->id ? 'selected':''}}>{{$srd->name}}</option>
					  					@endforeach
							  		</select>
							  		
								</div>
							</div>
							<div class="form-group pad-btm-20">
								<label class="col-md-3 control-label">作品 / 角色</label>
								<div class="col-md-9">
							  		<select name="works" id="works" class="form-control">
					  			  		@foreach($works_rs as $srd)
					  			  			<option value="{{$srd->id}}" {{$spec->works == $srd->id ? 'selected':''}}>{{$srd->name}}</option>
					  					@endforeach
							  		</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">商品日期</label>
								<div class="col-md-9">
							  		<input type="text" name="sdate" class="form-control" placeholder="請輸入日期" value="{{$rd->sdate}}">
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
							<div class="form-group">
								<label class="col-md-3 control-label">產品名稱</label>
								<div class="col-md-9">
							  		<input type="text" name="name" class="form-control" placeholder="請輸入名稱" value="{{$rd->name}}">
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-3">
									<label class="control-label">商品簡述</label>
									<p class="control-label-help">( 請輸入說明，最多500字 )</p>
								</div>
								<div class="col-md-9">
									<textarea id="brief" name="brief" class="form-control">{!!$rd->brief!!}</textarea>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-3">
									<label class="control-label">商品規格</label>
								</div>
								<div class="col-md-9">
									<table>
										<tr>
											<th>商品價格：</th>
											<td><input class="form-control" type="text" name="price" id="price" value="{{$spec->price}}" /></td>
										</tr>
										<tr>
											<th>發賣日:</th>
											<td><input class="form-control" type="text" name="saledate" id="saledate" value="{{$spec->saledate}}" /></td>
										</tr>
										<tr>
											<th>對象年齡：</th>
											<td><input class="form-control" type="text" name="age" id="age" value="{{$spec->age}}" /></td>
										</tr>
									</table>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-3">
									<label class="control-label">付屬品</label>
								</div>
								<div class="col-md-9">
									<textarea name="attachments" id="attachments" class="form-control" style="height:200px">{{$spec->attachments}}</textarea>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-3">
									<label class="control-label">商品內容</label>
								</div>
								<div class="col-md-9">
									<textarea name="contents" id="contents" class="form-control" style="height:200px">{{$spec->contents}}</textarea>
								</div>
							</div>
							<div class="form-group">
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
							</div>
							<div class="form-group">
								<div class="col-md-3">
									<label class="control-label">內容</label>
									<p class="control-label-help">( 請輸入內容，最多10000字 )</p>
									<div><button type="button" class="btn btn-success" onclick="load_media('{{request('id')}}', 'gunpla')">媒體庫</button></div>
								</div>
								<div class="col-md-9">
									<textarea id="pcontent" name="cont">{!!$rd->cont!!}</textarea>
									<script>CKEDITOR.replace( 'pcontent', { height:500 } );</script>
								</div>
							</div>
						</div>
					</div>
					<div class="form-footer">
						<div class="form-group">
							<div class="col-md-9 col-md-offset-3">
								<button type="button" onclick="edit_form_submit('#edit_form')"  class="btn btn-primary">儲存</button>
								<a class="btn btn-default" href="{{session('BACKPAGE')}}">回上一頁</a>
								<input type="hidden" name="_token" value="{{csrf_token()}}">
								<input type="hidden" name="id" value="{{request('id')}}">
								<input type="hidden" name="lang" value="{{session('lang')}}">
								<input type="hidden" name="position" value="products">
								<input type="hidden" name="type" value="gunpla">
								<input type="hidden" name="psort" value="{{$rd->psort}}">
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
		load_page('?id='+res.id);
	});
});

</script>
@endsection