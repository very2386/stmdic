<?php
if(request('id')){
	$rd = \App\Cm::where('id', request('id'))->first();
	if(!$rd){
		session()->flash('sysmsg', '找不到您要編輯的資料');
		echo '<script>location.href="/backend/member/index"</script>';
		exit;
	}
}else{
	$rd =\App\Cm::new_obj();
}
?>
@extends('backend.main')
@section('content')
@include('backend._top')
<style type="text/css">
.del_file{
	padding: 3px;
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
				<a href="/backend/video/index">影音管理</a> - 編輯
			</div>
			<div class="card-body">
	            <form class="form form-horizontal" id="edit_form" name="edit_form" enctype="multipart/form-data" method="post" action="/do/edit/cm">
	            	<div class="section">
	            		<div class="section-body">
	            			<div class="form-group">
	            				<label class="col-md-3 control-label">影片名稱</label>
	            				<div class="col-md-9">
	            			  		<input type="text" name="name" class="form-control" value="{{$rd->name}}" placeholder="請輸入課程講師">
	            				</div>
	            			</div>
							<div class="form-group">
	            				<label class="col-md-3 control-label">課程講師</label>
	            				<div class="col-md-9">
	            			  		<input type="text" name="obj" class="form-control" value="{{$rd->obj}}" placeholder="請輸入課程講師">
	            				</div>
	            			</div>
	            			<div class="form-group">
	            				<label class="col-md-3 control-label">課程類別</label>
	            				<div class="col-md-9">
	            					<?php
	            					$video_type = \App\Cm::where('position','videotype')->where('mstatus','Y')->get();
	            					$ctype = explode('-',$rd->type) ; 
	            					?>
	            					<select name="ctype" id="ctype" class="form-control">
	            						<option value="">請選擇</option>
	            						@foreach($video_type as $vt)
	            						<option data-type="{{$vt->id}}" value="{{$vt->name}}" {{$ctype[0]==$vt->name?'selected':''}}>{{$vt->name}}</option>
	            						@endforeach
							  		</select>
	            				</div>
	            			</div>
	            			<div class="form-group">
	            				<label class="col-md-3 control-label">所屬分類</label>
								@foreach($video_type as $vt)
								<div class="col-md-9 vtype v{{$vt->id}} {{$ctype[0]==$vt->name?'':'hide'}}">
									<?php
									$second_type = \App\Cm::where('position','videotype_2nd')->where('type',$vt->name)->where('mstatus','Y')->get();
									?>
	            					<select name="vtype[{{$vt->name}}]" class="form-control">
	            						<option value="">請選擇</option>
	            						@foreach($second_type as $st)
	            						<option value="{{$st->name}}" {{isset($ctype[1]) ? ($st->name==$ctype[1]?'selected':'') : '' }}>{{$st->name}}</option>
	            						@endforeach
							  		</select>
	            				</div>
								@endforeach
	            			</div>
	            			<div class="form-group">
	            				<label class="col-md-3 control-label">影片連結類別</label>
	            				<div class="col-md-9">
	            			  		<div class="col-md-9">
									<div class="radio radio-inline">
										<input type="radio" name="link_type" id="link_type1" value="YouTube" {{$rd->link_type == 'YouTube' ? 'checked':''}}>
										<label for="link_type1">YouTube</label>
									</div>
									<div class="radio radio-inline">
										<input type="radio" name="link_type" id="link_type2" value="Google Drive" {{$rd->link_type == 'Google Drive' ? 'checked':''}}>
										<label for="link_type2">Google Drive</label>
									</div>
									<div class="radio radio-inline">
										<input type="radio" name="link_type" id="link_type3" value="其他" {{$rd->link_type == '其他' ? 'checked':''}}>
										<label for="link_type3">其他</label>
									</div>
								</div>
	            				</div>
	            			</div>
	            			<div class="form-group">
	            				<label class="col-md-3 control-label">影片連結網址</label>
	            				<div class="col-md-9">
	            			  		<input type="text" name="link" class="form-control" value="{{$rd->link}}" placeholder="請輸入影片連結">
	            				</div>
	            			</div>
	            			<div class="form-group">
								<label class="col-md-3 control-label">列表顯示圖片</label>
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
	            				<label class="col-md-3 control-label">課程簡介</label>
	            				<div class="col-md-9">
	            			  		<input type="text" name="brief" class="form-control" value="{{$rd->brief}}" placeholder="請輸入課程簡介">
	            				</div>
	            			</div>
	            			<div class="form-group">
	            				<label class="col-md-3 control-label">日期</label>
	            				<div class="col-md-9">
	            			  		<input type="text" name="jdate" class="form-control" value="{{$rd->jdate}}" placeholder="請輸入日期">
	            				</div>
	            			</div>
	            			<div class="form-group">
	            				<label class="col-md-3 control-label">片長</label>
	            				<div class="col-md-9">
	            			  		<input type="text" name="specs" class="form-control" value="{{$rd->specs}}" placeholder="請輸入片長">
	            				</div>
	            			</div>
	            			<div class="form-group">
								<label class="col-md-3 control-label">課程教材(多個)</label>
								<div class="col-md-9">
									@if(request('id'))
										<?php
										$files = \App\OtherFiles::where('position','video')->where('cm_id',request('id'))->get();
										?>
										@foreach($files as $rs)
										<div class="col-md-3" style="padding: 5px;" id="item_row{{$rs->id}}">
											<a href="/download/{{$rs->id}}">{{$rs->name}}</a>
											<a class="btn btn-danger del_file" onclick="del_item('otherfiles','{{$rs->id}}')">X</a>
										</div>
										@endforeach
									@endif
									<div class="input-group">
								    	<input type="file" name="other_files[]" class="form-control" aria-label="上傳附件" multiple>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">上傳影片</label>
								<div class="col-md-9">
									<div class="input-group">
								    	<input type="file" class="form-control" aria-label="上傳影片" multiple>
									</div>
								</div>
							</div>
	            			<div class="form-group">
	            				<label class="col-md-3 control-label">排序</label>
	            				<div class="col-md-9">
	            			  		<input type="text" name="psort" class="form-control" value="{{$rd->psort}}" placeholder="數字越大越前面">
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
								<div class="col-md-3">
									<label class="control-label">課程大綱</label>
									<p class="control-label-help">( 請輸入課程大綱，最多2000字 )</p>
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
	            				<button type="button" onclick="edit_form_submit('#edit_form')" class="btn btn-primary">儲存</button>
	            				<a class="btn btn-default" href="/backend/video/index">取消</a>
	            				<input type="hidden" name="_token" value="{{csrf_token()}}">
								<input type="hidden" name="id" value="{{request('id')}}">
								<input type="hidden" name="lang" value="{{$rd->lang ? $rd->lang : session('lang')}}">
								<input type="hidden" name="position" value="video">
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

	$('#ctype').on('change',function(){
		var ctype = $(this);
		var i = ctype[0].selectedIndex;
		var id = ctype.find('option').eq(i).data('type');
		$('.vtype').addClass('hide');
		$('.v'+id).removeClass('hide') ;
		// if(ctype == '育成實績'){
		// 	$('.vtype2').css( "display", "none" );
		// 	$('.vtype1').css( "display", "block" ) ;
		// }else{
		// 	$('.vtype1').css( "display", "none" );
		// 	$('.vtype2').css( "display", "block" ) ;
		// } 
	})
});
</script>
@endsection