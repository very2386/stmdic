<?php
$member_type = \App\Cm::get_members_type();
$news_type = \App\Cm::get_news_type();
$compinfo = \App\Cm::get_companyinfo();
$comp_second = \App\Cm::get_company_type();
$email = session('data') ? session('data')['email'] : '';
$name = session('data') ? session('data')['name'] : '';
$social_id = [];
if( isset(session('data')['facebook_id']) && session('data')['facebook_id'] ){
	$social_id['facebook_id'] = session('data')['facebook_id'] ; 
}else{
	$social_id['google_id'] = session('data')['google_id'] ;
}
$n = 0;
?>
@extends('main')
@section('header')
<script src='https://www.google.com/recaptcha/api.js?hl=zh-TW'></script>
@endsection
@section('content')
<style type="text/css">
	.company{
		display: none ;
	}
	.custom-input .comptype{
		display: none ;
	}
	.product{
		display: none ;
	}
	.custom-input .job_title{
		display: none ;
	}
	.custom-input .exp{
		display: none ;
	}
	.custom-input .unit{
		display: none ;
	}
	.custom-input .tel{
		display: none ;
	}
	.custom-input .department{
		display: none ;
	}
	.custom-input .research{
		display: none ;
	}
	.custom-input .test_exp{
		display: none ;
	}
	.custom-input .invest{
		display: none ;
	}
	.custom-input .case{
		display: none ;
	}
	.custom-input .website{
		display: none ;
	}
	.custom-input .patent{
		display: none ;
	}
	.custom-input .brief{
		display: none ;
	}
	.custom-input .address{
		display: none ;
	}
	.custom-input .technology{
		display: none ;
	}
	.custom-input .weblink{
		display: none ;
	}
	.text_center{
		height: 45px;
    	text-align: center;
    	line-height: 45px;
	}
</style>
<section class="register">
	<form id="signup_form" action="/do/signup" method="post" enctype="multipart/form-data">
		<div class="ttl-bar">
			<h2>會員註冊</h2>
		</div>
		<div class="breadcrumb">
			<a href="">會員專區</a> &gt; <a href="">會員註冊</a>
		</div>
		<div class="content grid-intro form">
			<div class="block new">
				<h3 class="ttl">新帳號註冊</h3>
				<ul class="custom-input">
					<li>
						<h4 class="ttl">*註冊身份</h4>
						<div id="type-select" class="custom-select small bordered w-srt" target="#type">
							<h5 class="ttl">一般</h5>
							<ul class="opt">
								@foreach($member_type as $key => $type)
								<li data-type="{{$key}}">{{$type}}</li>
								@endforeach
							</ul>
							<input type="hidden" id="type" name="type" value="一般">
						</div>
					</li>
					<li class="comptype">
						<h4 class="ttl">*廠商分類</h4>
						<ul class="custom-radio sub flex wrap">	
							@foreach($comp_second as $k => $type)
							<li>
								<input name="comptype[]" id="comptype-cat{{$k}}" type="checkbox" value="{{$type}}">
								<label for="comptype-cat{{$k}}" id="comptype-cat{{$k}}">{{$type}}</label>
							</li>				
							@endforeach
						</ul>
					</li>
					<li>
						<h4 class="ttl">*設定帳號</h4>
						<input type="text" name="loginid">
					</li>
					<li>
						<h4 class="ttl">*設定密碼</h4>
						<input type="password" name="passwd">
						<p>＊請以半形輸入，6個字以上英文或數字組合</p>
					</li>
					<li>
						<h4 class="ttl">*再次輸入密碼</h4>
						<input type="password" name="passwd_chk">
					</li>
				</ul>
			</div>
			<div class="block basic">
				<h3 class="ttl">基本資料</h3>
				<ul class="custom-input">
					<!-- 共同欄位 -->
					<li class="member_info pic">
						<h4 class="ttl">大頭照</h4>
						<input type="file" name="pic">
					</li>
					<li class="member_info name">
						<h4 class="ttl">*姓名</h4>
						<input type="text" name="name" value="{{$name}}">
					</li>
					<li class="member_info job_title">
						<h4 class="ttl">職稱</h4>
						<input type="text" name="job_title" value="">
					</li>
					<li class="member_info unit">
						<h4 class="ttl">單位</h4>
						<input type="text" name="unit" value="">
					</li>
					<li class="member_info sname">
						<h4 class="ttl">暱稱</h4>
						<input type="text" name="sname" value="">
					</li>
					<li class="member_info email">
						<h4 class="ttl">*E-mail</h4>
						<input type="text" name="email" value="{{$email}}">
						<p style="margin-right:20px;">是否開放</p>
						<ul class="custom-radio sub flex wrap">
							<li>
								<input name="show_email" id="showY" type="radio" value="Y" >
								<label for="showY">是</label>
							</li>
							<li>
								<input name="show_email" id="showN" type="radio" value="N" >
								<label for="showN" >否</label>
							</li>
						</ul>
					</li>
					<li class="member_info tel">
						<h4 class="ttl">聯絡電話</h4>
						<input type="text" name="tel">
					</li>
					<li class="member_info gender">
						<h4 class="ttl">性別</h4>
						<ul id="gender-switch" class="custom-radio sub">
							<li>
								<input name="gender" id="gender-male" type="radio" value="M">
								<label for="gender-male" gender="male" id="gender-male">男性</label>
							</li>
							<li>
								<input name="gender" id="gender-female" type="radio" value="F">
								<label for="gender-female" gender="female" id="gender-female">女性</label>
							</li>
						</ul>
					</li>
					<li class="member_info technology">
						<h4 class="ttl">技術轉移</h4>
						<input type="text" name="technology">
					</li>
					<li class="member_info weblink">
						<h4 class="ttl">科技部研發服務網址</h4>
						<input type="text" name="weblink">
						<p>請參考：<a href="http://arsp.most.gov.tw/NSCWebFront/modules/talentSearch/talentSearch.do" target="_blank">科技部研發服務</a></p>
					</li>
					<li class="member_info multiadd school" data-index="{{$n++}}">
						<h4 class="ttl">學歷</h4>
						<ul class="custom-input">
							<li class="text_center">
								<input type="text" name="school[]" value="">
							</li>
						</ul>
						<button type="button" class="btn-add-sp">+</button>
					</li>
					<li class="member_info multiadd exp" data-index="{{$n++}}">
						<h4 class="ttl">經歷</h4>
						<ul class="custom-input">
							<li>
								<input type="text" name="exp[]" value="">
							</li>
						</ul>
						<button type="button" class="btn-add-sp">+</button>
					</li>
					<li class="member_info multiadd expertise" data-index="{{$n++}}">
						<h4 class="ttl">專長領域</h4>
						<ul class="custom-input">
							<li>
								<input type="text" name="expertise[]" value="">
							</li>
						</ul>
						<button type="button" class="btn-add-sp">+</button>
					</li>
					<li class="member_info multiadd patent" data-index="{{$n++}}">
						<h4 class="ttl">專利</h4>
						<ul class="custom-input">
							<li>
								<input type="text" name="patent[]" value="">
							</li>
						</ul>
						<button type="button" class="btn-add-sp">+</button>
					</li>
					<li class="member_info department">
						<h4 class="ttl">執業科別</h4>
						<input type="text" name="department" value="">
					</li>
					<li class="member_info multiadd research" data-index="{{$n++}}">
						<h4 class="ttl">相關研究計畫</h4>
						<ul class="custom-input">
							<li>
								<input type="text" name="research[]" value="">
							</li>
						</ul>
						<button type="button" class="btn-add-sp">+</button>
					</li>
					<li class="member_info multiadd test_exp" data-index="{{$n++}}">
						<h4 class="ttl">臨床試驗經歷</h4>
						<ul class="custom-input">
							<li>
								<input type="text" name="test_exp[]" value="">
							</li>
						</ul>
						<button type="button" class="btn-add-sp">+</button>
					</li>
					<li class="member_info multiadd invest" data-index="{{$n++}}">
						<h4 class="ttl">投資偏好產業</h4>
						<ul class="custom-input">
							<li>
								<input type="text" name="invest[]" value="">
							</li>
						</ul>
						<button type="button" class="btn-add-sp">+</button>
					</li>
					<li class="member_info multiadd case" data-index="{{$n++}}">
						<h4 class="ttl">相關服務案例</h4>
						<ul class="custom-input">
							<li>
								<input type="text" name="case[]" value="">
							</li>
						</ul>
						<button type="button" class="btn-add-sp">+</button>
					</li>
					<li class="member_info blog">
						<h4 class="ttl">部落格</h4>
						<input type="text" name="blog" value="">
					</li>
					<li class="member_info website">
						<h4 class="ttl">公司網站</h4>
						<input type="text" name="website" value="">
					</li>
					<li class="member_info address">
						<h4 class="ttl">地址</h4>
						<input type="text" name="address" value="">
					</li>
					<li class="member_info brief ">
						<h4 class="ttl">簡介</h4>
						<textarea id="brief" name="brief" cols="30" rows="10"></textarea>
					</li>
					<!-- <li class="member_info">
						<h4 class="ttl">*生日</h4>
						<input class="datepicker" type="text" name="birth">
						<p>*例如：1986-10-01</p>
					</li> 
					<li class="industry member_info">
						<h4 class="ttl">行業別</h4>
						<input type="text" name="industry" value="">
					</li>
					<li class="apartment member_info">
						<h4 class="ttl">部門</h4>
						<input type="text" name="apartment" value="">
					</li>-->
				</ul>
			</div>
			<div class="block multiadd product" data-index="{{$n++}}">
				<h3 class="ttl">相關產品訊息</h3>
				<ul class="custom-input">
					<li class="wrap">
						<ul>
							<li>
								<div class="title">
									<h4 class="ttl">產品名稱</h4>
								</div>
								<div class="prop">
									<input type="text" name="product[]" value="">
								</div>
							</li>
							<li>
								<div class="title">
									<h4 class="ttl">圖片</h4>
								</div>
								<div class="prop">
									<ul>
										<li>
											<input type="file" name="product_pic[]">
										</li>
									</ul>
								</div>
								<p>* 檔案格式：JPG、PNG</p>
							</li>
						</ul>
					</li>
				</ul>
				<button type="button" class="btn-add-sp">+</button>
			</div>
			<div class="block social">
				<h3 class="ttl">社群聯絡方式：</h3>
				<ul class="custom-input">
					<li class="wrap">
						<ul>
							<li>
								<h4 class="ttl">Facebook</h4>
								<input type="text" name="facebook_id">
								<p>*請貼上ID <a>*說明</a></p>
							</li>
							<li>
								<h4 class="ttl">Google</h4>
								<input type="text" name="google_id">
								<p>*請貼上ID <a>*說明</a></p>
							</li>
						</ul>
					</li>
				</ul>
			</div>
			<div class="block interest">
				<h3 class="sttl">請勾選您有興趣的主題內容：</h3>
				<ul class="custom-input">
					<li class="wrap">
						<ul class="custom-radio sub">
							<li>
								<input name="interest-all" id="interest-all" type="checkbox" onchange="chg_interest()">
								<label for="interest-all" id="interest-all">全部文章</label>
							</li>
							@foreach($news_type as $k => $type)
								@if($type != '')
								<li>
									<input name="interest[]" id="interest-cat{{$k+1}}" type="checkbox" value="{{$type}}">
									<label for="interest-cat{{$k+1}}" id="interest-cat{{$k+1}}">{{$type}}</label>
								</li>
								@endif
							@endforeach
						</ul>
					</li>
				</ul>
			</div>
			<div class="block company">
				<h3 class="ttl">廠商資料</h3>
				<ul class="custom-input">
					<li>
						<div class="title">
							<h4 class="ttl">*廠商名稱</h4>
						</div>
						<div class="prop">
							<input type="text" name="compname" id="compname" value="">
						</div>
					</li>
					<li>
						<div class="title">
							<h4 class="ttl">廠商地址</h4>
						</div>
						<div class="prop">
							<input type="text" name="compaddr" id="compaddr" value="">
						</div>
					</li>
					<li>
						<div class="title">
							<h4 class="ttl">電話</h4>
						</div>
						<div class="prop">
							<input type="text" name="comptel" id="comptel" value="">
						</div>
					</li>
					<li>
						<div class="title">
							<h4 class="ttl">傳真</h4>
						</div>
						<div class="prop">
							<input type="text" name="compfax" id="compfax" value="">
						</div>
					</li>
					<li>
						<div class="title">
							<h4 class="ttl">官網</h4>
						</div>
						<div class="prop">
							<input type="text" name="link" id="link" value="">
						</div>
					</li>
					<li>
						<div class="title">
							<h4 class="ttl">*E-mail</h4>
						</div>
						<div>
							<input type="text" name="compemail" id="compemail" value="">
						</div>
						<p style="margin-right:20px;">是否開放</p>
						<ul class="custom-radio sub flex wrap">
							<li>
								<input name="show_compemail" id="email_showY" type="radio" value="Y" >
								<label for="email_showY">是</label>
							</li>
							<li>
								<input name="show_compemail" id="email_showN" type="radio" value="N" >
								<label for="email_showN" >否</label>
							</li>
						</ul>
					</li>
					<li>
						<div class="title">
							<h4 class="ttl">廠商簡介</h4>
						</div>
						<div class="prop">
							<textarea name="compbrief" id="compbrief" cols="30" rows="10"></textarea>
						</div>
					</li>
					<li>
						<div class="title">
							<h4 class="ttl">Logo / 小圖</h4>
						</div>
						<div class="prop">
							<input type="file" name="spicfile">
							<p>* 檔案格式：JPG、PNG</p>
						</div>
					</li>
					<li>
						<div class="title">
							<h4 class="ttl">形象大圖</h4>
						</div>
						<div class="prop">
							<input type="file" name="picfile">
							<p>* 檔案格式：JPG、PNG</p>
						</div>
					</li>
				</ul>
			</div>
			@foreach($compinfo as $pos)
			<div class="block upload company multiadd" data-index="{{$n++}}">
				<h3 class="ttl">{{$pos}}</h3>
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
					<li class="sep">
					</li>	
				</ul>
				<button type="button" class="btn-add-sp">+</button>
			</div>
			@endforeach
			<div class="g-recaptcha" data-sitekey="6LcACjcUAAAAAMDvCmxXqqkV9ue8e_Y7b4fgYXnP"></div>
			<p class="red fz-s">*資料請務必填寫完整，以保障會員權益</p>
			<div class="btn-confirm">
				<a href="/member/index" class="btn-cancel">取消</a>
				<a onclick="signup_submit()" class="btn-confirm">儲存修改</a>
			</div>
		</div>
		<input type="hidden" name="_token" value="{{csrf_token()}}">
		@if(session('data'))
		<input type="hidden" name="{{isset($social_id['facebook_id'])?'facebook_id':'google_id'}}" value="{{isset($social_id['facebook_id'])?$social_id['facebook_id']:$social_id['google_id']}}">
		@endif
	</form>
</section>
@endsection
@section('javascript')
<script>
	$(function(){
		register_form('#signup_form', function(res){
			var member_type = $('#type').val();
			if(member_type=='醫材廠商') load_page('/member/company');
			else load_page('/member/index');
		});
		var memberType = {
			'expert' :['sname','department','test_exp','invest','product','case','website','address','comptype','company'],
			'p_expert' :['sname','department','test_exp','invest','product','case','website','address','comptype','company'],
			'doctor' :['sname','invest','product','case','website','patent','address','technology','weblink','expertise','comptype','company'],
			'invest' :['sname','unit','department','gender','school','research','test_exp','product','patent','technology','weblink','expertise','comptype','company','blog','invest','job_title'],
			'service':['sname','school','unit','gender','department','research','test_exp','invest','patent','blog','technology','weblink','expertise','comptype','company','job_title'],
			'common' :['job_title','school','exp','unit','tel','department','research','test_exp','invest','product','case','website','patent','expertise','brief','address','technology','weblink','company']
		}
		$('#type-select .opt li').click(function(){
			$('.member_info').css({'display':'flex'});
			$('.block').show();
			var type = $(this).data('type');

			//更換文字
			if(type == 'invest'){
				$('.block .pic .ttl').html('廠商logo');
				$('.block .name .ttl').html('公司名稱');
				$('.block .exp .ttl').html('投資領域');
				$('.block .case .ttl').html('相關投資案例');
			}else if(type == 'service'){
				$('.block .pic .ttl').html('廠商logo');
				$('.block .name .ttl').html('公司名稱');
				$('.block .exp .ttl').html('服務領域');
			}

			if(type == 'company'){
				let hide = ['basic','social','interest','member_info','product'];
				hide.forEach(v =>{
					$('.block.' + v).hide();
				})
				$('.company').css({'display':'block'});
				$('.comptype').css({'display':'flex'});
			} else {
				memberType[type].forEach(v => {
					$('.' + v).hide();
					if(type=="service"){
						$('.block.product').css({'display':'block'});
					}else{
						$('.block.product').hide();
					}	
				})
			}

		});
		$('.datepicker').pickadate({format: 'yyyy-mm-dd', selectYears:50, max: new Date()});


		{
			let index = 0;
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
	function signup_submit(){
		$('#signup_form').submit();
	}
	function chg_interest(){
		var chk = $('#interest-all').prop('checked');
		$('input[name="interest[]"]').prop('checked', chk);
	}
</script>
@endsection