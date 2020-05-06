<?php
$ers = [];
$takenyears = [];
$takenmonths = [];
if(request('id')){
	$rd = \App\Cm::where('id', request('id'))->first();
	if(!$rd){
		session()->flash('sysmsg', '找不到您要編輯的資料');
		echo '<script>location.href="/backend/about/history"</script>';
		exit;
	}
	$ers = \App\Cm::where('up_sn', $rd->id)->orderBy('name', 'asc')->get();
	if($ers){
		foreach($ers as $h){
			$takenmonths[] = $h->name;
		}
	}
}else{
	$rd = new \stdClass();
	$rd->cont = 250;
	$rd->name= '';
	$rd->pic= '';
	$rd->type= '';
	$rd->lang = session('lang');
}

$rs = \App\Cm::where('position', 'history')->where('up_sn', 0)->get();
if($rs){
	foreach($rs as $h){
		$takenyears[] = $h->name;
	}
}

?>
@extends('backend.main')
@section('content')
@include('backend._top')
<script src="//cdn.ckeditor.com/4.6.2/full/ckeditor.js"></script>
<form class="form form-horizontal" id="edit_form" name="edit_form" enctype="multipart/form-data" method="post" action="/do/edit/history">
<div class="row">
    <div class="col-xs-12">
		<div class="card">
			<div class="card-header">
				<a href="/backend/about/history">公司沿革</a> - 編輯
			</div>
			<div class="card-body">
				<div class="section">
					<div class="section-body">
						<div class="form-group">
							<label class="col-md-3 control-label">年份</label>
							<div class="col-md-9">
						  		<select name="name" class="form-control">
									@for($y= 2003; $y<=date('Y'); $y++){
									<option  value="{{$y}}" @if($rd->name == $y) selected @else {{ in_array($y, $takenyears) ? 'disabled':'' }} @endif >{{$y}}</option>
									@endfor
						  		</select>
							</div>
						</div>
						<div class="form-group form-inline">
							<label class="col-md-3 control-label">文字位置</label>
							<div class="col-md-9">
								<label for="typeRight">
						  		<input type="radio" id="typeRight" name="type" class="form-control" value="right" {{$rd->type =='right'?'checked':''}}> 靠左
						  		</label>
						  		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						  		<label for="typeLeft"><input type="radio" id="typeLeft" name="type" class="form-control" value="left" {{$rd->type =='left'?'checked':''}}> 靠右
						  		</label>
						  		
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label">圖片（網頁版）</label>
							<div class="col-md-9">
								@if(request('id'))
									<div class="image-preview">
										<img src="{{\App\Cm::get_pic($rd->id)}}" />
									</div>
								@endif
								<div class="input-group">
							    	<input type="file" name="picfile" class="form-control" aria-label="上傳圖片">
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label">圖片（手機版）</label>
							<div class="col-md-9">
								@if(request('id'))
									<div class="image-preview">
										<img src="{{\App\Cm::get_pic($rd->id, 's')}}" />
									</div>
								@endif
								<div class="input-group">
							    	<input type="file" name="spicfile" class="form-control" aria-label="上傳圖片">
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label">高度</label>
							<div class="col-md-9">
						  		<input type="text" id="cont" name="cont" class="form-control" value="{{$rd->cont}}" >
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label">事件</label>
							<div class="col-md-9">
						  		<div class="section-body" id="history_events">
									@foreach($ers as $erd)					
									<div class="form-group" id="item_row{{$erd->id}}">
										<div class="col-md-3 emonth">
											{{trans('message.'.$erd->name)}}
										</div>
										<div class="col-md-6 econt">
											{!!$erd->cont!!}
										</div>
										<div class="col-md-3" >
											<a class="btn btn-danger" onclick="del_item('cms', '{{$erd->id}}')" >刪除</a>
										</div>
										<hr class="col-md-12"/>
									</div>
									@endforeach	
									<div class="form-group new_event" id="etmp" style="display:none">
										<div class="col-md-3 emonth"></div>
										<div class="col-md-6 econt"></div>
										<div class="col-md-3" >
											<a class="btn btn-danger" onclick="del_ev(this)" >刪除</a>
											<input type="hidden" name="ename[]" class="input-ename" value="">
											<input type="hidden" name="econt[]" class="input-econt" value="">
										</div>
										<hr class="col-md-12"/>
									</div>
									<div class="form-group">
										<div class="col-md-3">
											<select id="emonth" class="form-control">
												@for($m= 1; $m<=12; $m++)
												<?php $n = "m".str_pad($m, 2, '0', STR_PAD_LEFT); ?>
												<option  value="{{$n}}" {{ in_array($n, $takenmonths) ? 'disabled':'' }} >{{trans('message.'.$n)}}</option>
												@endfor
									  		</select>
								  		</div>
								  		<div class="col-md-6">
								  			<textarea id="econt" class="form-control" placeholder="請輸入沿革內容"></textarea>
								  		</div>
								  		<div class="col-md-3">
											<button type="button" class="btn btn-primary" onclick="add_history_event()">新增沿革</button>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="form-footer">
					<div class="form-group">
						<hr class="col-md-12"/>
						<div class="col-md-9 col-md-offset-3">
							<button type="submit" class="btn btn-primary">儲存</button>
							<button type="button" class="btn btn-default">取消</button>
							<input type="hidden" name="_token" value="{{csrf_token()}}">
							<input type="hidden" name="id" value="{{request('id')}}">
							<input type="hidden" name="lang" value="{{$rd->lang ? $rd->lang : session('lang')}}">
							<input type="hidden" name="position" value="history">
						</div>
					</div>
				</div>
			</div>
		</div>
    </div>
</div>
</form>
@endsection
@section('javascripts')
<script>
$(function(){
	register_form('#edit_form', function(res){
		load_page('?id='+res.id);
	});
});
function add_history_event(){
	var m = $('#emonth').val();
	var c = nl2br($('#econt').val());
	$('#etmp').clone().attr('id', 'ev'+m).prependTo('#history_events').show();
	$('#ev'+m + ' .emonth').html($('#emonth option:selected').text());
	$('#ev'+m + ' .econt').html(c);
	$('#ev'+m + ' .input-ename').val(m);
	$('#ev'+m + ' .input-econt').val(c);
	$('#econt').val('');
}
function del_ev(obj){
	$(obj).parents('.new_event').remove();
}
</script>
@endsection