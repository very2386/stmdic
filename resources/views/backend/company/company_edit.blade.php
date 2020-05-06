<?php
if(request('id')){
	$rd = \App\Cm::where('id', request('id'))->first();
	$comptype = explode(',', $rd->type) ;
	if(!$rd){
		session()->flash('sysmsg', '找不到您要編輯的資料');
		echo '<script>location.href="/backend/company/index"</script>';
		exit;
	}
}else{
	$rd =\App\Cm::new_obj();
	$comptype= [] ;
}
$tags = explode(',', $rd->tags);
$conts = request('id') ? ['核心技術','上市產品','醫療專利','法規認證','廠商專家','廠商徵才'] : [];
$comp_type = \App\Cm::get_company_type();
$n = 0;
?>
@extends('backend.main')
@section('content')
@include('backend._top')
<style type="text/css">
.form-group{
	position: relative;
}
.btn-pull-right{
	position: absolute;
	bottom: 10px;
    right: -70px;
}
.pull-right{
	position: absolute;
    right: -85px;
    top: 0;
    width: 70px;
}
</style>
<script src="//cdn.ckeditor.com/4.6.2/full/ckeditor.js"></script>
<div class="row">
    <div class="col-xs-12">
		<div class="card">
			<div class="card-header">
				<a href="/backend/company/index">廠商管理</a> - 編輯
			</div>
			<div class="card-body">
					<div class="section">
						<div class="section-title">{{session('lang')}}</div>
						<div class="section-body">
							<div role="tabpanel" style="position: relative;">
							    <!-- Nav tabs -->
							    <ul class="nav nav-tabs" role="tablist">
							        <li class="{{ $arg ? '':'active' }}">
							        	<a href="/backend/company/company_edit?id={{request('id')}}">基本資料</a>
							        </li>
									@foreach($conts as $c)
										<li class="{{$c == $arg ? 'active':'' }}">
											<a href="/backend/company/company_edit/{{$c}}?id={{request('id')}}">{{$c}}</a>
										</li>
									@endforeach
							    </ul>
								@if($arg)
									@if($arg=='廠商徵才')
										<a class="add-btn btn btn-primary" href="/backend/company/job_edit?up_sn={{request('id')}}">新增</a>
									@else
										<a class="add-btn btn btn-primary" href="/backend/company/compinfo_edit?up_sn={{request('id')}}&type={{$arg}}">新增</a>
									@endif
									
								@endif
							    <!-- Tab panes -->
							    <div class="tab-content">
							        @if(!$arg)
							        <div role="tabpanel" class="tab-pane active" id="home">
										<form class="form form-horizontal" id="edit_form" name="edit_form" enctype="multipart/form-data" method="post" action="/do/edit/cm">
										<div class="form-group pad-btm-20">
											<label class="col-md-3 control-label">廠商分類</label>
											<div class="col-md-8">
												@foreach($comp_type as $k => $type)
													<input class="form-inline" {{in_array($type,$comptype)?'checked':''}} name="comptype[]" id="comptype-cat{{$k}}" type="checkbox" value="{{$type}}">
													<label for="comptype-cat{{$k}}" id="comptype-cat{{$k}}">{{$type}}</label>
													&nbsp;&nbsp;&nbsp;
												@endforeach
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-3 control-label">廠商名稱</label>
											<div class="col-md-8">
										  		<input type="text" name="compname" class="form-control" placeholder="請輸入廠商名稱" value="{{$rd->name}}">
											</div>
										</div>
										<div class="form-group">
											<?php
											if($rd->up_sn!=0){
												$member = \App\Members::where('id',$rd->up_sn)->first();
												if(!$member) $member = (object)['loginid'=>''] ;
											} else $member = (object)['loginid'=>''] ;
											?>
											<label class="col-md-3 control-label">會員帳號</label>
											<div class="col-md-8">
										  		<input type="text" name="loginid" class="form-control" placeholder="請輸入會員帳號" value="{{$member->loginid}}">
										  		<input type="hidden" name="oldid" value="{{$member->loginid}}">
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-3 control-label">會員密碼</label>
											<div class="col-md-8">
										  		<input type="password" name="passwd" class="form-control" placeholder="請輸入登入密碼（不修改密碼請留空）" value="">
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-3 control-label">確認密碼</label>
											<div class="col-md-8">
										  		<input type="password" name="passwd_chk" class="form-control" placeholder="請再次輸入密碼" value="">
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-3 control-label">廠商地址</label>
											<div class="col-md-8">
										  		<input type="text" name="compaddr" class="form-control" placeholder="請輸入廠商地址" value="{{$rd->addr}}">
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-3 control-label">廠商電話</label>
											<div class="col-md-8">
										  		<input type="text" name="comptel" class="form-control" placeholder="請輸入廠商電話" value="{{$rd->comptel}}">
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-3 control-label">E-mail</label>
											<div class="col-md-8">
										  		<input type="text" name="compemail" class="form-control" placeholder="請輸入E-mail" value="{{$rd->email}}">
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-3 control-label">傳真</label>
											<div class="col-md-8">
										  		<input type="text" name="compfax" class="form-control" placeholder="請輸入傳真" value="{{$rd->compfax}}">
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-3 control-label">官網</label>
											<div class="col-md-8">
										  		<input type="text" name="link" class="form-control" placeholder="請輸入官網" value="{{$rd->link}}">
											</div>
										</div>
										<div class="form-group">
											<div class="col-md-3">
												<label class="control-label">廠商簡介</label>
												<p class="control-label-help">( 請輸入說明，最多100字 )</p>
											</div>
											<div class="col-md-8">
												<textarea id="compbrief" name="compbrief" class="form-control">{!!$rd->brief!!}</textarea>
											</div>
										</div>
										<div class="form-group pad-btm-20">
											<label class="col-md-3 control-label">標籤</label>
											<div class="col-md-8 tags">
										  		<div class="old_tags">
										  		@foreach($tags as $tag)
										  			@if($tag)
										  			<?php $tagrd = \App\Cm::where('position','tag')->where('name', $tag)->first();?>
													<span class="tag" style="background:{{$tagrd->brief}}">{{$tag}}</span>&nbsp;&nbsp;
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
										</div>
										<div class="form-group">
											<label class="col-md-3 control-label">排序</label>
											<div class="col-md-8">
										  		<input type="text" name="psort" class="form-control" placeholder="請輸入排序" value="{{$rd->psort}}"><div class="small-notes">數字越大越前面</div>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-3 control-label">Logo / 小圖</label>
											<div class="col-md-8">
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
											<label class="col-md-3 control-label">形象大圖</label>
											<div class="col-md-8">
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
											<label class="col-md-3 control-label">加入通路索引</label>
											<div class="col-md-8">
												<div class="radio radio-inline">
													<input type="radio" name="online_status" id="online_statusY" value="Y" {{$rd->online_status == 'Y' ? 'checked':''}}>
													<label for="online_statusY">是</label>
												</div>
												<div class="radio radio-inline">
													<input type="radio" name="online_status" id="online_statusN" value="N" {{$rd->online_status == 'N' ? 'checked':''}}>
													<label for="online_statusN">否</label>
												</div>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-3 control-label">狀態</label>
											<div class="col-md-8">
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
												<label class="control-label">詳細內容</label>
												<p class="control-label-help">( 請輸入內容，最多2000字 )</p>
												<button type="button" class="btn btn-success" onclick="load_media('{{request('id')}}', 'company')">媒體庫</button>
											</div>
											<div class="col-md-8">
												<textarea id="pcontent" name="cont">{!!$rd->cont!!}</textarea>
												<script>CKEDITOR.replace( 'pcontent', { height:500 } );</script>
											</div>
										</div>
										<div class="form-footer">
											<div class="form-group">
												<div class="col-md-8 col-md-offset-3">
													<button type="button" onclick="edit_form_submit('#edit_form')" class="btn btn-primary">儲存</button>
													<a class="btn btn-default" href="{{session('BACKPAGE')}}">回上一頁</a>
													<input type="hidden" name="_token" value="{{csrf_token()}}">
													<input type="hidden" name="id" value="{{request('id')}}">
													<input type="hidden" name="lang" value="{{$rd->lang ? $rd->lang : session('lang')}}">
													<input type="hidden" name="position" value="company">
													<input type="hidden" name="up_sn" value="{{$rd->up_sn}}">
													<input type="hidden" name="site" value="backend">
												</div>
											</div>
										</div>
										</form>
							        </div>
							        @else
							        <div role="tabpanel" class="tab-pane active">
							        	<table class="table datatable">
							        		<thead>
							        			<tr>
							        				<th>#</th>
							        				<th>排序</th>
							        				<th>名稱</th>
							        				@if($arg!='廠商徵才')
							        				<th>圖片</th>
							        				@endif
							        				@if($arg=='上市產品')
													<th>是否加入產品體驗</th>
							        				@endif
							        				<th>狀態</th>
							        				<th>編輯</th>
							        			</tr>
							        		</thead>
							        		<tbody>
							        			<?php
							        			$position = $arg=='廠商徵才'?'comp_resume':'compinfo' ;
							        			$type = $arg=='廠商徵才'?'text':$arg ; 
							        			$rs = \App\Cm::where('position', $position)->where('up_sn',$rd->id)->where('type', $type)->orderBy('psort', 'desc')->orderBy('id', 'desc')->get();
							        			foreach($rs as $rd):
							        			?>
							        				<tr id="item_row{{$rd->id}}">
							        					<th scope="row">{{++$n}}</th>
							        					<td>{{$rd->psort}}</td>
							        					<td>{{$rd->name}}</td>
							        					@if($arg!='廠商徵才')
							        					<td><img src="{{\App\Cm::get_spic($rd->id)}}" style="height:50px;" /></td>
							        					@endif
							        					@if($arg=='上市產品')
							        					<td>{{$rd->online_status == 'Y' ? '是':'否'}}</td>
							        					@endif
							        					<td>{{$rd->mstatus == 'Y' ? '上線':'下線'}}</td>
							        					<th>
							        						@if($arg=='廠商徵才')
							        						<a class="btn btn-primary" href="/backend/company/job_edit?id={{$rd->id}}">編輯</a>
							        						@else
							        						<a class="btn btn-primary" href="/backend/company/compinfo_edit?id={{$rd->id}}">編輯</a>
							        						@endif
							        						<a class="btn btn-danger" onclick="del_item( 'cms', '{{$rd->id}}');" >刪除</a>
							        					</th>
							        				</tr>
							        			<?php 
							        			endforeach;
							        			if($rs->count() <= 0):
							        			?>
							        				<tr>
							        					<td colspan="7">
							        						<div class="empty_data"></div>
							        					</td>
							        				</tr>
							        			<?php endif;?>
							        		</tbody>
							        	</table>
							        </div>
							        @endif
							    </div>

							</div>
						</div>
					</div>
					
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
	$('.datatable').DataTable();
	$('.btn-primary').click(function(){
		var $this = $(this);
		var $p = $this.parents('.form-group');
		var $div = $p.find('.new-col');
		var $input = $div.find('select');
		var $copy = $input.filter(':last-child').prop('outerHTML');
		$div.append($copy)
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
function del_info(delsn){
    if(!confirm("確定要刪除嗎？")){
        return false;
    }else{
        $("#item_row" + delsn).remove();
    }
}

</script>
@endsection