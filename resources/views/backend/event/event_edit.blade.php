<?php
if(request('id')){
	$rd = \App\Cm::where('id', request('id'))->first();
	if(!$rd){
		session()->flash('sysmsg', '找不到您要編輯的資料');
		echo '<script>location.href="/backend/event/index"</script>';
		exit;
	}
	$cont = json_decode($rd->cont) ;
	$brief = json_decode($rd->brief) ;
}else{
	$rd =\App\Cm::new_obj();
	$brief=(object)['event_cont' => '',
				    'event_fee' => '',
				    'event_organizer' => '',
				    'event_co_organizer' => '',
				    'event_vip' => '',
				    'event_contact' => '',
				    'event_contact_tel' => ''] ;
}
$event_type = \App\Cm::get_event_type();
$tags = explode(',', $rd->tags);
?>
@extends('backend.main')
@section('content')
@include('backend._top')
<style type="text/css">
.del_file{
	padding: 5px;
    position: absolute;
    top: 0px;
    right: 0px;
}
</style>
<script src="//cdn.ckeditor.com/4.6.2/full/ckeditor.js"></script>
<div class="row">
    <div class="col-xs-12">
		<div class="card">
			<div class="card-header">
				<a href="/backend/event/index">活動資料</a> - 編輯
			</div>
			<div class="card-body">
				<form class="form form-horizontal" id="edit_form" name="edit_form" enctype="multipart/form-data" method="post" action="/do/edit/cm">
					<div class="section">
						<div class="section-title">{{session('lang')}}</div>
						<div class="section-body">
							<div class="form-group pad-btm-20">
								<label class="col-md-2 control-label">分類</label>
								<div class="col-md-10 tags">
									<select name="type" id="type" class="form-control">
										<option value="">請選擇分類</option>
									@foreach($event_type as $type)
										<option value="{{$type}}" {{$type == $rd->type ? 'selected':''}}>{{$type}}</option>
									@endforeach
										<option value="展示室活動" {{$rd->type == '展示室活動' ? 'selected':''}}>展示室活動</option>
									</select>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-md-2 control-label">報名日期</label>
								<div class="col-md-5">
									<div class="input-group">
								        <span class="input-group-addon">開始</span>
								        <input type="text" name="signup_sdate" class="form-control datepicker" placeholder="請選擇報名日期" value="{{substr($rd->signup_sdate,0,10)}}">
								    </div>
								</div>
								<div class="col-md-5">
									<div class="input-group">
								        <span class="input-group-addon">結束</span>
								        <input type="text" name="signup_edate" class="form-control datepicker" placeholder="請選擇報名日期" value="{{substr($rd->signup_edate,0,10)}}">
								    </div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-2 control-label">活動日期</label>
								<div class="col-md-5">
									<div class="input-group">
								        <span class="input-group-addon">開始</span>
								        <input type="text" name="event_sdate" class="form-control datepicker" placeholder="請選擇報名日期" value="{{substr($rd->event_sdate,0,10)}}">
								    </div>
								</div>
								<div class="col-md-5">
									<div class="input-group">
								        <span class="input-group-addon">結束</span>
								        <input type="text" name="event_edate" class="form-control datepicker" placeholder="請選擇報名日期" value="{{substr($rd->event_edate,0,10)}}">
								    </div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-2 control-label">標題</label>
								<div class="col-md-10">
							  		<input type="text" name="name" class="form-control" placeholder="請輸入標題" value="{{$rd->name}}">
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-2">
									<label class="control-label">活動內容</label>
								</div>
								<div class="col-md-10">
									<textarea id="event_cont" name="event_cont" class="form-control">{{isset($brief->event_cont)?$brief->event_cont:''}}</textarea>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-2 control-label">活動收費標準</label>
								<div class="col-md-10">
							  		<input type="text" name="event_fee" class="form-control" placeholder="請輸入活動收費標準" value="{{isset($brief->event_fee)?$brief->event_fee:''}}">
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-2 control-label">主辦單位</label>
								<div class="col-md-10">
							  		<input type="text" name="event_organizer" class="form-control" placeholder="請輸入主辦單位" value="{{isset($brief->event_organizer)?$brief->event_organizer:''}}">
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-2 control-label">協辦單位</label>
								<div class="col-md-10">
							  		<input type="text" name="event_co_organizer" class="form-control" placeholder="請輸入協辦單位" value="{{isset($brief->event_co_organizer)?$brief->event_co_organizer:''}}">
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-2 control-label">贊助單位</label>
								<div class="col-md-10">
							  		<input type="text" name="event_sponsors" class="form-control" placeholder="請輸入贊助單位" value="{{isset($brief->event_sponsors)?$brief->event_sponsors:''}}">
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-2 control-label">主持人</label>
								<div class="col-md-10">
							  		<input type="text" name="event_vip" class="form-control" placeholder="請輸入主持人" value="{{isset($brief->event_vip)?$brief->event_vip:''}}">
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-2 control-label">聯絡人</label>
								<div class="col-md-10">
							  		<input type="text" name="event_contact" class="form-control" placeholder="請輸入聯絡人" value="{{isset($brief->event_contact)?$brief->event_contact:''}}">
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-2 control-label">聯絡人電話</label>
								<div class="col-md-10">
							  		<input type="text" name="event_contact_tel" class="form-control" placeholder="聯絡人電話" value="{{isset($brief->event_contact_tel)?$brief->event_contact_tel:''}}">
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-2 control-label">活動報名連結網址</label>
								<div class="col-md-10">
							  		<input type="text" name="link" class="form-control" placeholder="請輸入活動連結網址" value="{{$rd->link}}">
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-2 control-label">報名人數</label>
								<div class="col-md-10">
									<div class="radio radio-inline">
										<input type="radio" name="online_status" id="online_statusY" value="Y" {{$rd->online_status == 'Y' ? 'checked':''}}>
										<label for="online_statusY">額滿</label>
									</div>
									<div class="radio radio-inline">
										<input type="radio" name="online_status" id="online_statusN" value="N" {{$rd->online_status == 'N' ? 'checked':''}}>
										<label for="online_statusN">未額滿</label>
									</div>
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-2 control-label">交通地圖（圖片）</label>
								<div class="col-md-10">
									@if(request('id'))
										<div class="image-preview">
											<img src="{{\App\Cm::get_spic($rd->id)}}" style="max-width:100%; max-height:300px" />
										</div>
									@endif
									<div class="input-group">
								    	<input type="file" name="spicfile" class="form-control" aria-label="上傳交通地圖（圖片）">
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-2 control-label">封面圖片</label>
								<div class="col-md-10">
									@if(request('id'))
										<div class="image-preview">
											<img src="{{\App\Cm::get_pic($rd->id)}}" style="max-width:100%; max-height:300px" />
										</div>
									@endif
									<div class="input-group">
								    	<input type="file" name="picfile" class="form-control" aria-label="上傳封面圖片">
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-2 control-label">活動圖片</label>
								<div class="col-md-10">
									@if(request('id'))
										<?php
										$files = \App\OtherFiles::where('position','event')->where('cm_id',request('id'))->get();
										?>
										@foreach($files as $rs)
										<div class="image-preview col-md-3" style="padding: 5px;" id="item_row{{$rs->id}}">
											<img src="{{$rs->fname}}" style="max-width:100%; max-height:300px" />
											<a class="btn btn-danger del_file" onclick="del_item('otherfiles','{{$rs->id}}')">X</a>
										</div>
										@endforeach
									@endif
									<div class="input-group">
								    	<input type="file" name="other_files[]" class="form-control" aria-label="上傳活動圖片" multiple>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-2 control-label">活動流程</label>
								<div class="col-md-10">
							  		<table class="table event-table">
							  			<thead>
							  				<tr>
							  					<th>時間</th>
							  					<th>議程</th>
							  					<th>貴賓/主持人</th>
							  					<th style="width:100px"><a class="btn-add" style="cursor: pointer;">+新增</a></th>
							  				</tr>
							  			</thead>
							  			<tbody id="process">
							  				@if($rd->cont)
							  				@foreach($cont as $rs)
							  					<tr>
							  						<td>
							  							<input type="text" name="event_step[time][]" class="form-control" value="{{$rs->time}}">
							  						</td>
							  						<td>
							  							<!-- <input type="text" name="event_step[agenda][]" class="form-control" value="{{$rs->agenda}}"> -->
							  							<textarea name="event_step[agenda][]" class="form-control">{{$rs->agenda}}</textarea>
							  						</td>
							  						<td>
							  							<input type="text" name="event_step[vip][]" class="form-control" value="{{$rs->vip}}">
							  						</td>
							  						<td></td>
							  					</tr>
							  				@endforeach
							  				@endif
							  				<tr class="tr">
							  					<td><input type="text" name="event_step[time][]" class="form-control"></td>
							  					<td><textarea name="event_step[agenda][]" class="form-control"></textarea></td>
							  					<td><input type="text" name="event_step[vip][]" class="form-control"></td>
							  					<td></td>
							  				</tr>
							  			</tbody>
							  		</table>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-2 control-label">狀態</label>
								<div class="col-md-10">
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
								<div class="col-md-2">
									<label class="control-label">排序</label>
									<p class="control-label-help">( 數字越大越前面 )</p>
								</div>
								<div class="col-md-10">
							  		<input type="text" name="psort" class="form-control" placeholder="請輸入排序" value="{{$rd->psort}}">
								</div>
							</div>
							
							<!-- <div class="form-group pad-btm-20">
								<label class="col-md-2 control-label">標籤</label>
								<div class="col-md-10 tags">
							  		<div class="old_tags">
							  		@foreach($tags as $tag)
							  			@if($tag)
							  			<?php $tagrd = \App\Cm::where('position','tag')->where('name', $tag)->first();?>
										<span class="tag" style="background:{{isset($tagrd)?$tagrd->brief:''}}">{{$tag}}</span>&nbsp;&nbsp;
										@endif
									@endforeach
									<a class="btn btn-small btn-primary" onclick="edit_tags();">管理標籤</a>
									</div>
							  		<select class="form-control hideme" name="tags[]" id="tags" multiple="multiple">
							  			@foreach($tags as $tag)
							  				@if( strlen($tag) > 0 )
											<option value="{{$tag}}" l="{{strlen($tag)}}" selected="selected">{{$tag}}</option>
											@endif
							  			@endforeach
							  		</select>
							  		<input type="hidden" name="old_tags" value="{{$rd->tags}}">
								</div>
							</div> -->
							<!-- <div class="form-group">
								<div class="col-md-2">
									<label class="control-label">內容</label>
									<p class="control-label-help">( 請輸入內容，最多2000字 )</p>
									<button type="button" class="btn btn-success" onclick="load_media('{{request('id')}}', '')">媒體庫</button>
								</div>
								<div class="col-md-10">
									<textarea id="pcontent" name="cont">{!!$rd->cont!!}</textarea>
									<script>CKEDITOR.replace( 'pcontent', { height:500 } );</script>
								</div>
							</div> -->
						</div>
					</div>
					<div class="form-footer">
						<div class="form-group">
							<div class="col-md-10 col-md-offset-3">
								<button type="button" onclick="edit_form_submit('#edit_form')" class="btn btn-primary">儲存</button>
								<a class="btn btn-default" href="/backend/event/index">取消</a>
								<input type="hidden" name="_token" value="{{csrf_token()}}">
								<input type="hidden" name="id" value="{{request('id')}}">
								<input type="hidden" name="lang" value="{{$rd->lang ? $rd->lang : session('lang')}}">
								<input type="hidden" name="position" value="event">
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
	$('.datepicker').pickadate({format: 'yyyy-mm-dd'});
	$('.btn-add').click(function(){
		var $this = $(this);
		var $table = $this.parents('.event-table');
		var $tr = $table.find('.tr');
		$table.append($tr.prop('outerHTML'));
	})
});
function edit_tags(){
	$('.old_tags').hide();
	$('#tags').select2({
        placeholder: 'Select an item',
        tags: true,
        ajax: {
          url: '/get/tags',
          dataType: 'json',
          delay: 250,
          processResults: function (data) {
            return {
              results: data
            };
          },
          cache: true
        },
        minimumInputLength: 1
    }).show();
}
</script>
@endsection