<?php
if(request('id')){
	$rd = \App\Cm::where('id', request('id'))->first();
	$conts = json_decode($rd->cont);
	if(!$rd){
		session()->flash('sysmsg', '找不到您要編輯的資料');
		echo '<script>location.href="/backend/experts/index"</script>';
		exit;
	}
}else{
	$rd = \App\Cm::new_obj();
}
$tags= explode(',', $rd->tags);
$types = \App\Cm::get_expert_type();
$n = 0 ; 
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
				<a href="/backend/experts/index">專家資料</a> - 編輯
			</div>
			<div class="card-body">
	            <form class="form form-horizontal" id="edit_form" name="edit_form" enctype="multipart/form-data" method="post" action="/do/edit/cm">
	            	<div class="section">
	            		<div class="section-body">
	            			<div class="form-group pad-btm-20">
	            				<label class="col-md-2 control-label">專家編號</label>
	            				<div class="col-md-8">
	            			  		{{ $rd->id }}
	            			  		<input type="hidden" name="id" value="{{$rd->id}}">
	            				</div>
	            			</div>
	            			<div class="form-group pad-btm-20">
	            				<label class="col-md-2 control-label">專家類別</label>
	            				<div class="col-md-8">
	            			  		<select name="type" id="type" class="form-control">
	            			  			<option value="">請選擇</option>
	            			  			@foreach($types as $key => $type)
	            			  				<option data-type="{{$key}}" value="{{$type}}" {{$rd->type == $type ? 'selected':''}}>{{$type}}</option>
	            			  			@endforeach
	            			  		</select>
	            				</div>
	            			</div>
	            			<div class="form-group">
								<?php
								if($rd->up_sn!=0){
									$member = \App\Members::where('id',$rd->up_sn)->first();
									if(!$member) $member = (object)['loginid'=>''] ; 
								}else $member = (object)['loginid'=>''] ; 
								?>
								<label class="col-md-2 control-label">會員帳號</label>
								<div class="col-md-8">
							  		<input type="text" name="loginid" class="form-control" placeholder="請輸入會員帳號" value="{{$member->loginid}}">
							  		<input type="hidden" name="oldid" value="{{$member->loginid}}">
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-2 control-label">會員密碼</label>
								<div class="col-md-8">
							  		<input type="password" name="passwd" class="form-control" placeholder="請輸入登入密碼（不修改密碼請留空）" value="">
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-2 control-label">確認密碼</label>
								<div class="col-md-8">
							  		<input type="password" name="passwd_chk" class="form-control" placeholder="請再次輸入密碼" value="">
								</div>
							</div>
	            			<div class="form-group expert name">
	            				<label class="col-md-2 control-label">姓名</label>
	            				<div class="col-md-8">
	            			  		<input type="text" name="name" class="form-control" value="{{$rd->name}}">
	            				</div>
	            			</div>
	            			<div class="form-group expert sname">
	            				<label class="col-md-2 control-label">暱稱</label>
	            				<div class="col-md-8">
	            					@if(isset($conts->sname))
	            					@foreach($conts->sname as $sname)
	            			  		<input type="text" name="sname" class="form-control" value="{{$sname}}">
	            			  		@endforeach
	            			  		@else
	            			  		<input type="text" name="sname" class="form-control">
	            			  		@endif
	            				</div>
	            			</div>
	            			<div class="form-group expert unit">
	            				<label class="col-md-2 control-label">單位</label>
	            				<div class="col-md-8">
	            			  		@if(isset($conts->unit))
	            					@foreach($conts->unit as $unit)
	            			  		<input type="text" name="unit" class="form-control" value="{{$unit}}">
	            			  		@endforeach
	            			  		@else
	            			  		<input type="text" name="unit" class="form-control">
	            			  		@endif
	            				</div>
	            			</div>
	            			<div class="form-group expert job_title">
	            				<label class="col-md-2 control-label">職稱</label>
	            				<div class="col-md-8">
	            			  		@if(isset($conts->job_title))
	            					@foreach($conts->job_title as $job_title)
	            			  		<input type="text" name="job_title" class="form-control" value="{{$job_title}}">
	            			  		@endforeach
	            			  		@else
	            			  		<input type="text" name="job_title" class="form-control">
	            			  		@endif
	            				</div>
	            			</div>
	            			<div class="form-group expert email">
	            				<label class="col-md-2 control-label">E-mail</label>
	            				<div class="col-md-8">
	            			  		@if(isset($conts->email))
	            					@foreach($conts->email as $email)
	            			  		<input type="text" name="email" class="form-control" value="{{$email}}">
	            			  		@endforeach
	            			  		@else
	            			  		<input type="text" name="email" class="form-control">
	            			  		@endif
	            				</div>
	            			</div>
	            			<div class="form-group expert tel">
	            				<label class="col-md-2 control-label">聯絡電話</label>
	            				<div class="col-md-8">
	            			  		@if(isset($conts->tel))
	            					@foreach($conts->tel as $tel)
	            			  		<input type="text" name="tel" class="form-control" value="{{$tel}}">
	            			  		@endforeach
	            			  		@else
	            			  		<input type="text" name="tel" class="form-control">
	            			  		@endif
	            				</div>
	            			</div>
	            			<div class="form-group expert blog">
	            				<label class="col-md-2 control-label">部落格</label>
	            				<div class="col-md-8">
	            			  		@if(isset($conts->blog))
	            					@foreach($conts->blog as $blog)
	            			  		<input type="text" name="blog" class="form-control" value="{{$blog}}">
	            			  		@endforeach
	            			  		@else
	            			  		<input type="text" name="blog" class="form-control">
	            			  		@endif
	            				</div>
	            			</div>
	            			<div class="form-group expert website">
	            				<label class="col-md-2 control-label">公司網站</label>
	            				<div class="col-md-8">
	            			  		@if(isset($conts->website))
	            					@foreach($conts->website as $website)
	            			  		<input type="text" name="website" class="form-control" value="{{$website}}">
	            			  		@endforeach
	            			  		@else
	            			  		<input type="text" name="website" class="form-control">
	            			  		@endif
	            				</div>
	            			</div>
	            			<div class="form-group expert school">
	            				<label class="col-md-2 control-label">學歷</label>
	            				<div class="col-md-8">
	            			  		@if(isset($conts->school))
		            					@foreach($conts->school as $school)
		            						<div id="item_row{{++$n}}" style="position: relative;">
		            							<input type="text" name="school[]" class="form-control" value="{{$school}}">
		            							<a class="btn btn-small btn-danger pull-right" onclick="del_info('{{$n}}');">-</a>
		            						</div>  		
		            			  		@endforeach
	            			  		@endif
            			  			<div class="new-col">
            			  				<input type="text" name="school[]" class="form-control" value="">
            			  			</div>
	            			  		<a class="btn btn-small btn-primary btn-pull-right">+</a>
	            				</div>
	            			</div>
	            			<div class="form-group expert exp">
	            				<label class="col-md-2 control-label">經歷</label>
	            				<div class="col-md-8">
	            			  		@if(isset($conts->exp))
		            					@foreach($conts->exp as $exp)
			            					<div id="item_row{{++$n}}" style="position: relative;">
			            						<input type="text" name="exp[]" class="form-control" value="{{$exp}}">
			            						<a class="btn btn-small btn-danger pull-right" onclick="del_info('{{$n}}');">-</a>
			            					</div>  		
		            			  		@endforeach
	            			  		@endif
	            			  		<div class="new-col">
	            			  			<input type="text" name="exp[]" class="form-control" value="">
	            			  		</div>
	            			  		<a class="btn btn-small btn-primary btn-pull-right">+</a>
	            				</div>
	            			</div>
	            			<div class="form-group expert department">
	            				<label class="col-md-2 control-label">執業科別</label>
	            				<div class="col-md-8">
	            			  		@if(isset($conts->department))
	            					@foreach($conts->department as $department)
	            			  		<input type="text" name="department" class="form-control" value="{{$department}}">
	            			  		@endforeach
	            			  		@else
	            			  		<input type="text" name="department" class="form-control">
	            			  		@endif
	            				</div>
	            			</div>
	            			<div class="form-group expert technology">
	            				<label class="col-md-2 control-label">技術轉移</label>
	            				<div class="col-md-8">
	            			  		@if(isset($conts->technology))
	            					@foreach($conts->technology as $technology)
	            			  		<input type="text" name="technology" class="form-control" value="{{$technology}}">
	            			  		@endforeach
	            			  		@else
	            			  		<input type="text" name="technology" class="form-control">
	            			  		@endif
	            				</div>
	            			</div>
	            			<div class="form-group expert weblink">
	            				<label class="col-md-2 control-label">科技部研發服務網址</label>
	            				<div class="col-md-8">
	            			  		@if(isset($conts->weblink))
	            					@foreach($conts->weblink as $weblink)
	            			  		<input type="text" name="weblink" class="form-control" value="{{$weblink}}">
	            			  		@endforeach
	            			  		@else
	            			  		<input type="text" name="weblink" class="form-control">
	            			  		@endif
	            				</div>
	            			</div>
	            			<div class="form-group expert expertise">
	            				<label class="col-md-2 control-label">專長領域</label>
	            				<div class="col-md-8">
	            					@if(isset($conts->expertise))
		            					@foreach($conts->expertise as $expertise)
			            					<div id="item_row{{++$n}}" style="position: relative;">
			            						<input type="text" name="expertise[]" class="form-control" value="{{$expertise}}">
			            						<a class="btn btn-small btn-danger pull-right" onclick="del_info('{{$n}}');">-</a>
			            					</div>  		
		            			  		@endforeach
	            			  		@endif
	            			  		<div class="new-col">
	            			  			<input type="text" name="expertise[]" class="form-control" value="">
	            			  		</div>
	            			  		<a class="btn btn-small btn-primary btn-pull-right">+</a>
	            				</div>
	            			</div>
	            			<div class="form-group expert patent">
	            				<label class="col-md-2 control-label">專利</label>
	            				<div class="col-md-8">
	            					@if(isset($conts->patent))
		            					@foreach($conts->patent as $patent)
			            					<div id="item_row{{++$n}}" style="position: relative;">
			            						<input type="text" name="patent[]" class="form-control" value="{{$patent}}">
			            						<a class="btn btn-small btn-danger pull-right" onclick="del_info('{{$n}}');">-</a>
			            					</div>  		
		            			  		@endforeach
	            			  		@endif
	            			  		<div class="new-col">
	            			  			<input type="text" name="patent[]" class="form-control" value="">
	            			  		</div>
	            			  		<a class="btn btn-small btn-primary btn-pull-right">+</a>
	            				</div>
	            			</div>
	            			<div class="form-group expert research">
	            				<label class="col-md-2 control-label">相關研究計畫</label>
	            				<div class="col-md-8">
	            					@if(isset($conts->research))
		            					@foreach($conts->research as $research)
			            					<div id="item_row{{++$n}}" style="position: relative;">
			            						<input type="text" name="research[]" class="form-control" value="{{$research}}">
			            						<a class="btn btn-small btn-danger pull-right" onclick="del_info('{{$n}}');">-</a>
			            					</div>
		            			  		@endforeach
	            			  		@endif
	            			  		<div class="new-col">
	            			  			<input type="text" name="research[]" class="form-control" value="">
	            			  		</div>
	            			  		<a class="btn btn-small btn-primary btn-pull-right">+</a>
	            				</div>
	            			</div>
	            			<div class="form-group expert test_exp">
	            				<label class="col-md-2 control-label">臨床試驗經歷</label>
	            				<div class="col-md-8">
	            			  		@if(isset($conts->test_exp))
		            					@foreach($conts->test_exp as $test_exp)
			            					<div id="item_row{{++$n}}" style="position: relative;">
			            						<input type="text" name="test_exp[]" class="form-control" value="{{$test_exp}}">
			            						<a class="btn btn-small btn-danger pull-right" onclick="del_info('{{$n}}');">-</a>
			            					</div>  		
		            			  		@endforeach
	            			  		@endif
	            			  		<div class="new-col">
	            			  			<input type="text" name="test_exp[]" class="form-control" value="">
	            			  		</div>
	            			  		<a class="btn btn-small btn-primary btn-pull-right">+</a>
	            				</div>
	            			</div>
	            			<div class="form-group expert invest">
	            				<label class="col-md-2 control-label">投資偏好產業</label>
	            				<div class="col-md-8">
	            			  		@if(isset($conts->invest))
		            					@foreach($conts->invest as $invest)
			            					<div id="item_row{{++$n}}" style="position: relative;">
			            						<input type="text" name="invest[]" class="form-control" value="{{$invest}}">
			            						<a class="btn btn-small btn-danger pull-right" onclick="del_info('{{$n}}');">-</a>
			            					</div>  		
		            			  		@endforeach
	            			  		@endif
	            			  		<div class="new-col">
	            			  			<input type="text" name="invest[]" class="form-control" value="">
	            			  		</div>
	            			  		<a class="btn btn-small btn-primary btn-pull-right">+</a>
	            				</div>
	            			</div>
	            			<div class="form-group expert product">
	            				<label class="col-md-2 control-label">相關產品訊息</label>
	            				<div class="col-md-8">
	            			  		@if(isset($conts->product))
		            					@foreach($conts->product as $product)
			            					<div id="item_row{{++$n}}" style="position: relative;">
			            						<input type="text" name="product[]" class="form-control" value="{{$product}}">
			            						<a class="btn btn-small btn-danger pull-right" onclick="del_info('{{$n}}');">-</a>
			            					</div>  		
		            			  		@endforeach
	            			  		@endif
	            			  		<div class="new-col">
	            			  			<input type="text" name="product[]" class="form-control" value="">
	            			  		</div>
	            			  		<a class="btn btn-small btn-primary btn-pull-right">+</a>
	            				</div>
	            			</div>
	            			<div class="form-group expert case">
	            				<label class="col-md-2 control-label">相關服務案例</label>
	            				<div class="col-md-8">
	            			  		@if(isset($conts->case))
		            					@foreach($conts->case as $case)
			            					<div id="item_row{{++$n}}" style="position: relative;">
			            						<input type="text" name="case[]" class="form-control" value="{{$case}}">
			            						<a class="btn btn-small btn-danger pull-right" onclick="del_info('{{$n}}');">-</a>
			            					</div>  		
		            			  		@endforeach
	            			  		@endif
	            			  		<div class="new-col">
	            			  			<input type="text" name="case[]" class="form-control" value="">
	            			  		</div>
	            			  		<a class="btn btn-small btn-primary btn-pull-right">+</a>
	            				</div>
	            			</div>
	            			<div class="form-group expert brief">
								<div class="col-md-2">
									<label class="control-label">簡介</label>
									<p class="control-label-help">( 請輸入簡介，最多100字 )</p>
								</div>
								<div class="col-md-8">
									<textarea id="brief" name="brief" class="form-control">{!!$rd->brief!!}</textarea>
								</div>
							</div>
	            			<div class="form-group pad-btm-20">
								<label class="col-md-2 control-label">標籤</label>
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
							<!-- <div class="form-group">
								<label class="col-md-2 control-label">列表圖片(小)</label>
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
							</div> -->
							<div class="form-group expert pic">
								<label class="col-md-2 control-label">圖片</label>
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
								<label class="col-md-2 control-label">狀態</label>
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
								<div class="col-md-2">
									<label class="control-label"> </label>
									<p class="control-label-help"> </p>
									<button type="button" class="btn btn-success" onclick="load_media('{{request('id')}}', '')">媒體庫</button>
								</div>
								<!-- <div class="col-md-8">
									<textarea id="pcontent" name="cont">{!!$rd->cont!!}</textarea>
									<script>CKEDITOR.replace( 'pcontent', { height:500 } );</script>
								</div> -->
							</div>
	            		</div>
	            	</div>
	            	<div class="form-footer">
	            		<div class="form-group">
	            			<div class="col-md-8 col-md-offset-3">
	            				<button type="button" onclick="edit_form_submit('#edit_form')" class="btn btn-primary">儲存</button>
	            				<a class="btn btn-default" href="/backend/experts/index">取消</a>
								<input type="hidden" name="_token" value="{{csrf_token()}}">
								<input type="hidden" name="id" value="{{request('id')}}">
								<input type="hidden" name="position" value="expert">
								<input type="hidden" name="up_sn" value="{{$rd->up_sn}}">
								<input type="hidden" name="lang" value="{{$rd->lang ? $rd->lang : session('lang')}}">
								<input type="hidden" name="site" value="backend">
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

	var expertType = {
		'學界專家' :['sname','department','test_exp','invest','product','case','website','address'],
		'產業專家' :['sname','department','test_exp','invest','product','case','website','address'],
		'臨床醫師' :['sname','invest','product','case','website','patent','address','technology','weblink'],
		'創投業者' :['sname','unit','department','gender','school','research','test_exp','product','patent','technology','weblink','expertise','comptype','company','blog','invest','job_title'],
		'服務業者':['sname','school','unit','gender','department','research','test_exp','invest','patent','blog','technology','weblink','expertise','comptype','company','job_title'],
		'其他' :['job_title','school','exp','unit','tel','department','research','test_exp','invest','product','case','website','patent','brief','address','technology','weblink']
	}
	var expert = '{{$rd->type}}';
	if(expert!=''){
		$('.expert').show();
		var type = $('#type').val();
		//更換文字
		if(type == '創投業者'){
			$('.pic label').html('廠商logo');
			$('.name label').html('公司名稱');
			$('.exp label').html('投資領域');
			$('.case label').html('相關投資案例');
		}else if(type == '服務業者'){
			$('.pic label').html('廠商logo');
			$('.name label').html('公司名稱');
			$('.exp label').html('服務領域');
		}
		expertType[expert].forEach(v => {
			$('.' + v).hide();
		})
	}
	$('#type').on('change',function(){
		$('.expert').show();
		var type = $('#type').val();
		//更換文字
		if(type == '創投業者'){
			$('.pic label').html('廠商logo');
			$('.name label').html('公司名稱');
			$('.exp label').html('投資領域');
			$('.case label').html('相關投資案例');
		}else if(type == '服務業者'){
			$('.pic label').html('廠商logo');
			$('.name label').html('公司名稱');
			$('.exp label').html('服務領域');
		}
		
		expertType[type].forEach(v => {
			$('.' + v).hide();
		})
	});
	$('.btn-primary').click(function(){
		var $this = $(this);
		var $p = $this.parents('.form-group');
		var $div = $p.find('.new-col');
		var $input = $div.find('input');
		var $copy = $input.filter(':last-child').prop('outerHTML');
		console.log($copy)
		$p.find('>div').append($div.prop('outerHTML'))
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