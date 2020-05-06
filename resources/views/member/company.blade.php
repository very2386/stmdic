<?php
$member_type = \App\Cm::get_members_type();
$news_type = \App\Cm::get_news_type();
$compinfo = \App\Cm::get_companyinfo();
$comp_second = \App\Cm::get_company_type();
$mrd = \App\Members::where('id', session('mid'))->first();
$n = 0 ;
$t = 0 ;
?>
@extends('main')
@section('content')
<style type="text/css">
.btn-del-sp{
	width: 40px;
	height: 40px;
	background-color: #ffa3a3;
	border: none;
	border-radius: 5px;
	color: #ffffff;
	font-size: 12px;
	position: absolute;
	top: 3px;
	left: 260px;
}
.type-select2{
	margin-bottom: 1em;
}
</style>
<section class="register">
	@include('member.menu')
	<div class="breadcrumb">
		<a href="/member/index">會員專區</a> &gt; <a class="name" href="">廠商資料</a>
	</div>
	<div class="content grid-intro form">
		<form id="passwd_form" action="/do/change_password" method="post" enctype="multipart/form-data">
			<div class="block">
				<h3 class="ttl">帳號資料</h3>
				<ul class="custom-input">
					<li>
						<h4 class="ttl">*註冊身份</h4>
						<div class="custom-select small bordered w-srt">
							<h5 class="ttl">{{$mrd->type}}</h5>
						</div>
					</li>
					<li>
						<h4 class="ttl">*帳號</h4>
						<input type="text" name="loginid" readonly="readonly" value="{{$mrd->loginid}}" >
					</li>
					<li>
						<h4 class="ttl">*請輸入舊密碼</h4>
						<input type="password" name="passwd_old">
						<p>＊請以半形輸入，6個字以上英文或數字組合</p>
					</li>
					<li>
						<h4 class="ttl">*修改密碼</h4>
						<input type="password" name="passwd">
						<p>＊請以半形輸入，6個字以上英文或數字組合</p>
					</li>
					<li>
						<h4 class="ttl">*再次輸入密碼</h4>
						<input type="password" name="passwd_chk">
					</li>
					<li>
						<h4 class="spacer"></h4>
						<button class="btn-confirm">修改密碼</button>
					</li>
				</ul>
			</div>
			<input type="hidden" name="_token" value="{{csrf_token()}}">
		</form>
		<form id="edit_form" action="/do/company_edit" method="post" enctype="multipart/form-data">
			<?php
			$comprd = \App\Cm::where('position', 'company')->where('up_sn', session('mid'))->first();
			if(!$comprd) $comprd = \App\Cm::create(['up_sn'=>session('mid'), 'position'=>'company']);
			$comp_type = explode(',', $comprd->type) ;
			?>
			<div class="block company">
				<h3 class="ttl">廠商資料</h3>
				<ul class="custom-input">
					<li>
						<div class="title">
							<h4 class="ttl">廠商名稱</h4>
						</div>
						<div class="prop">
							<input type="text" name="compname" id="compname" value="{{$comprd->name}}">
						</div>
					</li>
					<li class="comptype">
						<h4 class="ttl">廠商分類</h4>
						<ul class="custom-radio sub flex wrap">
							@foreach($comp_second as $k => $type)
								<li>
									<input {{in_array($type,$comp_type)?'checked':''}} name="comptype[]" id="comptype-cat{{$k}}" type="checkbox" value="{{$type}}">
									<label for="comptype-cat{{$k}}" id="comptype-cat{{$k}}">{{$type}}</label>
								</li>
							@endforeach
						</ul>
					</li>
					<li>
						<div class="title">
							<h4 class="ttl">廠商地址</h4>
						</div>
						<div class="prop">
							<input type="text" name="compaddr" id="compaddr" value="{{$comprd->addr}}">
						</div>
					</li>
					<li>
						<div class="title">
							<h4 class="ttl">廠商電話</h4>
						</div>
						<div class="prop">
							<input type="text" name="comptel" id="comptel" value="{{$comprd->comptel}}">
						</div>
					</li>
					<li>
						<div class="title">
							<h4 class="ttl">Email信箱</h4>
						</div>
						<div class="prop">
							<input type="text" name="compemail" id="compemail" value="{{$comprd->email}}">
						</div>
					</li>
					<li>
						<div class="title">
							<h4 class="ttl">傳真</h4>
						</div>
						<div class="prop">
							<input type="text" name="compfax" id="compfax" value="{{$comprd->compfax}}">
						</div>
					</li>
					<li>
						<div class="title">
							<h4 class="ttl">官網</h4>
						</div>
						<div class="prop">
							<input type="text" name="link" id="link" value="{{$comprd->link}}">
						</div>
					</li>
					<li>
						<div class="title">
							<h4 class="ttl">廠商簡介</h4>
						</div>
						<div class="prop">
							<textarea name="compbrief" id="compbrief" cols="30" rows="10">{{$comprd->brief}}</textarea>
						</div>
					</li>
					<li>
						<div class="title">
							<h4 class="ttl">Logo / 小圖</h4>
						</div>

						<div class="prop">
							<div class="comp-spic"><img src="{{\App\Cm::get_spic($comprd->id)}}" alt="Logo / 小圖"></div>
							<input type="file" name="spicfile">
							<p>* 檔案格式：JPG、PNG</p>
						</div>
					</li>
					<li>
						<div class="title">
							<h4 class="ttl">形象大圖</h4>
						</div>
						<div class="prop">
							<div class="comp-pic"><img src="{{\App\Cm::get_pic($comprd->id)}}" alt="形象大圖"></div>
							<input type="file" name="picfile">
							<p>* 檔案格式：JPG、PNG</p>
						</div>
					</li>
				</ul>
			</div>
			@foreach($compinfo as $pos)
			<div class="block upload company" data-index="{{$n++}}">
				<h3 class="ttl">{{$pos}}</h3>
				<div class="compinfo">
					<?php
					$irs = \App\Cm::where('position','compinfo')->where('type', $pos)->where('up_sn', $comprd->id)->get();
					?>
					@foreach($irs as $ird)
					<div class="cinfo" id="item_row{{$ird->id}}">
						<a onclick="del_item('cms', '{{$ird->id}}')" class="del"><i class="fa fa-times-circle" aria-hidden="true"></i></a>
						<img src="{{\App\Cm::get_pic($ird->id)}}" >
						<h4>{{$ird->name}}</h4>
					</div>
					@endforeach
					<div style="clear:both;"></div>
				</div>
				<ul class="custom-input">
					<li>
						<div class="title">
							<h4 class="ttl">名稱</h4>
						</div>
						<div class="prop">
							<input type="text" name="compinfo_name[{{$pos}}][]">
						</div>
					</li>
					<li>
						<div class="title">
							<h4 class="ttl">說明</h4>
						</div>
						<div class="prop">
							<input type="text" name="compinfo_brief[{{$pos}}][]">
						</div>
					</li>
					<li>
						<div class="title">
							<h4 class="ttl">圖片</h4>
						</div>
						<div class="prop">
							<ul>
								<li>
									<input type="file" name="compinfo_pics[{{$pos}}][]">
								</li>
							</ul>
						</div>
						<p>* 檔案格式：JPG、PNG</p>
					</li>
					<li class="sep"></li>	
				</ul>
				<button type="button" class="btn-add-sp">+</button>
			</div>
			@endforeach
			<div class="g-recaptcha" data-sitekey="6Ld2jCsUAAAAADvo2gGU9wJBgwMSCygH1w6ec_Ky"></div>
			<p class="red fz-s">*資料請務必填寫完整，以保障會員權益</p>
			<div class="btn-confirm">
				<a href="/member/company" class="btn-cancel">取消</a>
				<a onclick="edit_submit()" class="btn-confirm">儲存修改</a>
			</div>
			<input type="hidden" name="_token" value="{{csrf_token()}}">
		</form>
	</div>
</section>
@endsection
@section('javascript')
<script type="text/javascript">
	$(function(){
		register_form('#edit_form', function(){
			reload_page();
		});
		$('.datepicker').pickadate({format: 'yyyy-mm-dd', selectYears:50, max: new Date()});
		{
			let index = '{{$t}}';
			$('.block .btn-primary').click(function(){
				index++;
				let $this = $(this);
				let $p = $this.parents('.prop');
				let $cs = $p.find('.custom-select');
				let len = $cs.length;
				if(len < 6){
					let $last = $($cs[len-1]);
					console.log($cs[len-1])
					let $new = $last.clone();
					$new.addClass("asdasd")
					$new.find('.ttl').html('請選擇');
					let id = $new.find('input').attr('sname');
					$new.find('input').attr('id', id+index);
					$new.attr('target', "#"+id+index);
					let newHTML = $new.prop('outerHTML');
					$(newHTML).insertAfter($last);
				}

			})
		}
	})
	function edit_submit(){
		$('#edit_form').submit();
	}
	function chg_interest(){
		var chk = $('#interest-all').prop('checked');
		$('input[name="interest[]"]').prop('checked', chk);
	}
	function del_info(delsn){
	    if(!confirm("確定要刪除嗎？")){
	        return false;
	    }else{
            $(".item_row" + delsn).remove();
	    }
	}
</script>
@endsection