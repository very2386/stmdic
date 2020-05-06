<?php
if(!session('mid')){
	echo '<script>location.href="/"</script>';
	exit;
}
$member_type = \App\Cm::get_members_type();
$news_type = \App\Cm::get_news_type();
$compinfo = \App\Cm::get_companyinfo();
$comp_second = \App\Cm::get_company_type();
$prods_type = \App\Cm::get_prods_type();
$mrd = \App\Members::where('id', session('mid'))->first();
if($mrd->type!='一般'){
	if($mrd->type!='醫材廠商') $content = \App\Cm::where('position','expert')->where('up_sn',$mrd->id)->first();
	else $content = \App\Cm::where('position','company')->where('up_sn',$mrd->id)->first();
	$conts = json_decode($content->cont);
} 
$n = 0;
$item = 0 ;
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
}
.text_center{
	height: 45px;
	text-align: center;
	line-height: 45px;
}
</style>
<section class="register">
	@include('member.menu')
	<div class="breadcrumb">
		<a href="/member/index">會員專區</a> &gt; <a class="name" href="">修改資料</a>
	</div>
	<div class="content grid-intro form">
		<form id="passwd_form" action="/do/change_password" method="post" enctype="multipart/form-data">
			<div class="block new">
				<h3 class="ttl">帳號資料</h3>
				<ul class="custom-input">
					<li>
						<h4 class="ttl">*註冊身份</h4>
						<div class="custom-select small bordered w-srt" target="#member_type">
							<h5 class="ttl">{{$mrd->type}}</h5>
							<ul class="opt">
								@foreach($member_type as $key => $type)
								<li data-type="{{$key}}" onclick="chg_type('{{$type}}')">{{$type}}</li>
								@endforeach
							</ul>

						</div>
					</li>
					<li>
						<h4 class="ttl">*帳號</h4>
						<input type="text" name="loginid" readonly="readonly" value="{{$mrd->loginid}}" >
					</li>
					<li>
						<h4 class="ttl">*請輸入舊密碼</h4>
						<input type="password" name="passwd_old">
						<p>＊請以半形輸入，8個字以上英文或數字組合</p>
					</li>
					<li>
						<h4 class="ttl">*修改密碼</h4>
						<input type="password" name="passwd">
						<p>＊請以半形輸入，8個字以上英文或數字組合</p>
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
		<form id="edit_form" action="/do/member_edit" method="post" enctype="multipart/form-data">
			<div class="block basic">
				<h3 class="ttl">基本資料</h3>
				<ul class="custom-input">
					<li class="member_info pic">
						<h4 class="ttl">大頭照</h4>
						<div class="member-pic"><img src="{{\App\Members::get_pic(session('mid'))}}" alt="{{$mrd->name}}">
							<input type="file" name="pic">
						</div>
					</li>
					<li class="member_info nema">
						<h4 class="ttl">*姓名</h4>
						<input type="text" name="name" value="{{$mrd->name}}">
					</li>
					<li class="member_info job_title">
						<h4 class="ttl">職稱</h4>
						@if(isset($conts->job_title))
							@foreach($conts->job_title as $job_title)
							<input type="text" name="job_title" value="{{$job_title}}">
							@endforeach
						@else
							<input type="text" name="job_title">
						@endif
					</li>
					<li class="member_info unit">
						<h4 class="ttl">單位</h4>
						@if(isset($conts->unit))
							@foreach($conts->unit as $unit)
							<input type="text" name="unit" value="{{$unit}}">
							@endforeach
						@else
							<input type="text" name="unit">
						@endif
					</li>
					<li class="member_info sname">
						<h4 class="ttl">暱稱</h4>
						@if($mrd->type=='一般')
							<input type="text" name="sname" value="{{$mrd->sname}}">
						@elseif(isset($conts->sname))
							@foreach($conts->sname as $sname)
							<input type="text" name="sname" value="{{$sname}}">
							@endforeach
						@else
							<input type="text" name="sname">
						@endif
					</li>
					<li class="member_info multiadd school" sdex="{{$n++}}">
						<h4 class="ttl">學歷</h4>
						<ul>
							@if(isset($conts->school))
							@foreach($conts->school as $school)
							<?php
							$rs = explode('-',$school) ;
							?>
							<li class="text_center" id="item_row{{++$item}}">
								<input type="text" name="school[]" value="{{$rs[0]}}">
								<button type="button" class="btn-del-sp" onclick="del_info('{{$item}}')">x</button>	
							</li>
							@endforeach
							@endif
							<li>
								<ul class="custom-input">
									<li class="text_center">
										<input type="text" name="school[]" value="">
									</li>
								</ul>
								<button type="button" class="btn-add-sp">+</button>	
							</li>
						</ul>
					</li>
					<li class="member_info multiadd exp" sdex="{{$n++}}">
						<h4 class="ttl">經歷</h4>
						<ul>
						@if(isset($conts->exp))
							@foreach($conts->exp as $exp)
							<li id="item_row{{++$item}}">
								<input type="text" name="exp[]" value="{{$exp}}">
								<button type="button" class="btn-del-sp" onclick="del_info('{{$item}}')">x</button>	
							</li>
							@endforeach
						@endif
							<li>
								<ul class="custom-input">
									<li>
										<input type="text" name="exp[]" value="">
									</li>
								</ul>
								<button type="button" class="btn-add-sp">+</button>	
							</li>
						</ul>
					</li>
					<li class="member_info email">
						<h4 class="ttl">*E-mail</h4>
						@if(isset($conts->email))
							@foreach($conts->email as $email)
							<input type="text" name="email" value="{{$email}}">
							@endforeach
						@else
							<input type="text" name="email" value="{{$mrd->email}}">
						@endif
						<p style="margin-right:20px;">是否開放</p>
						<ul class="custom-radio sub flex wrap">
							<li>
								<input name="show_email" id="showY" type="radio" value="Y" {{$mrd->show_email=='Y'?'checked':''}}>
								<label for="showY">是</label>
							</li>
							<li>
								<input name="show_email" id="showN" type="radio" value="N" {{$mrd->show_email=='N'?'checked':''}}>
								<label for="showN" >否</label>
							</li>
						</ul>
					</li>
					<li class="member_info tel">
						<h4 class="ttl">聯絡電話</h4>
						@if(isset($conts->tel))
							@foreach($conts->tel as $tel)
							<input type="text" name="tel" value="{{$tel}}">
							@endforeach
						@else
							<input type="text" name="tel">
						@endif
					</li>
					<li class="member_info gender">
						<h4 class="ttl">性別</h4>
						<ul id="gender-switch" class="custom-radio sub">
							<li>
								<input name="gender" id="gender-male" type="radio" value="M" {{$mrd->gender=='M'?'checked="checked"':''}}>
								<label for="gender-male" gender="male" id="gender-male">男性</label>
							</li>
							<li>
								<input name="gender" id="gender-female" type="radio" value="F" {{$mrd->gender=='F'?'checked="checked"':''}}>
								<label for="gender-female" gender="female" id="gender-female">女性</label>
							</li>
						</ul>
					</li>
					<li class="member_info technology">
						<h4 class="ttl">技術轉移</h4>
						@if(isset($conts->technology))
							@foreach($conts->technology as $technology)
							<input type="text" name="technology" value="{{$technology}}">
							@endforeach
						@else
							<input type="text" name="technology">
						@endif
					</li>
					<li class="member_info weblink">
						<h4 class="ttl">科技部研發服務網址</h4>
						@if(isset($conts->weblink))
							@foreach($conts->weblink as $weblink)
							<input type="text" name="weblink" value="{{$weblink}}">
							@endforeach
						@else
							<input type="text" name="weblink">
						@endif
					</li>
					<li class="member_info multiadd expertise" data-index="{{$n++}}">
						<h4 class="ttl">專長領域</h4>
						<ul>
						@if(isset($conts->expertise))
							@foreach($conts->expertise as $expertise)
							<li id="item_row{{++$item}}">
								<input type="text" name="expertise[]" value="{{$expertise}}">
								<button type="button" class="btn-del-sp" onclick="del_info('{{$item}}')">x</button>	
							</li>
							@endforeach
						@endif
							<li>
								<ul class="custom-input">
									<li>
										<input type="text" name="expertise[]" value="">
									</li>
								</ul>
								<button type="button" class="btn-add-sp">+</button>	
							</li>
						</ul>
					</li>
					<li class="member_info multiadd patent" data-index="{{$n++}}">
						<h4 class="ttl">專利</h4>
						<ul>
						@if(isset($conts->patent))
							@foreach($conts->patent as $patent)
							<li id="item_row{{++$item}}">
								<input type="text" name="patent[]" value="{{$patent}}">
								<button type="button" class="btn-del-sp" onclick="del_info('{{$item}}')">x</button>	
							</li>
							@endforeach
						@endif
							<li>
								<ul class="custom-input">
									<li>
										<input type="text" name="patent[]" value="">
									</li>
								</ul>
								<button type="button" class="btn-add-sp">+</button>	
							</li>
						</ul>
					</li>
					<li class="member_info department">
						<h4 class="ttl">執業科別</h4>
						@if(isset($conts->department))
							@foreach($conts->department as $department)
							<input type="text" name="department" value="{{$department}}">
							@endforeach
						@else
							<input type="text" name="department">
						@endif
					</li>
					<li class="member_info multiadd research" data-index="{{$n++}}">
						<h4 class="ttl">相關研究計畫</h4>
						<ul>
						@if(isset($conts->research))
							@foreach($conts->research as $research)
							<li id="item_row{{++$item}}">
								<input type="text" name="research[]" value="{{$research}}">
								<button type="button" class="btn-del-sp" onclick="del_info('{{$item}}')">x</button>	
							</li>
							@endforeach
						@endif
							<li>
								<ul class="custom-input">
									<li>
										<input type="text" name="research[]" value="">
									</li>
								</ul>
								<button type="button" class="btn-add-sp">+</button>	
							</li>
						</ul>
					</li>
					<li class="member_info multiadd test_exp" data-index="{{$n++}}">
						<h4 class="ttl">臨床試驗經歷</h4>
						<ul>
						@if(isset($conts->test_exp))
							@foreach($conts->test_exp as $test_exp)
							<li id="item_row{{++$item}}">
								<input type="text" name="test_exp[]" value="{{$test_exp}}">
								<button type="button" class="btn-del-sp" onclick="del_info('{{$item}}')">x</button>	
							</li>
							@endforeach
						@endif
							<li>
								<ul class="custom-input">
									<li>
										<input type="text" name="test_exp[]" value="">
									</li>
								</ul>
								<button type="button" class="btn-add-sp">+</button>	
							</li>
						</ul>
					</li>
					<li class="member_info multiadd invest" data-index="{{$n++}}">
						<h4 class="ttl">投資偏好產業</h4>
						<ul>
						@if(isset($conts->invest))
							@foreach($conts->invest as $invest)
							<li id="item_row{{++$item}}">
								<input type="text" name="invest[]" value="{{$invest}}">
								<button type="button" class="btn-del-sp" onclick="del_info('{{$item}}')">x</button>	
							</li>
							@endforeach
						@endif
							<li>
								<ul class="custom-input">
									<li>
										<input type="text" name="invest[]" value="">
									</li>
								</ul>
								<button type="button" class="btn-add-sp">+</button>	
							</li>
						</ul>
					</li>
					<li class="member_info multiadd case" data-index="{{$n++}}">
						<h4 class="ttl">相關服務案例</h4>
						<ul>
						@if(isset($conts->case))
							@foreach($conts->case as $case)
							<li id="item_row{{++$item}}">
								<input type="text" name="case[]" value="{{$case}}">			
								<button type="button" class="btn-del-sp" onclick="del_info('{{$item}}')">x</button>	
							</li>
							@endforeach
						@endif
							<li>
								<ul class="custom-input">
									<li>
										<input type="text" name="case[]" value="">
									</li>
								</ul>
								<button type="button" class="btn-add-sp">+</button>	
							</li>
						</ul>
					</li>
					<li class="member_info blog">
						<h4 class="ttl">部落格</h4>
						@if(isset($conts->blog))
							@foreach($conts->blog as $blog)
							<input type="text" name="blog" value="{{$blog}}">
							@endforeach
						@else
							<input type="text" name="blog">
						@endif
					</li>
					<li class="member_info website">
						<h4 class="ttl">公司網站</h4>
						@if(isset($conts->website))
							@foreach($conts->website as $website)
							<input type="text" name="website" value="{{$website}}">
							@endforeach
						@else
							<input type="text" name="website">
						@endif
					</li>
					<li class="member_info address">
						<h4 class="ttl">地址</h4>
						@if(isset($conts->address))
							@foreach($conts->address as $address)
							<input type="text" name="address" value="{{$address}}">
							@endforeach
						@else
							<input type="text" name="address">
						@endif
					</li>
					<li class="member_info brief">
						<h4 class="ttl">簡介</h4>
						<textarea id="brief" name="brief" cols="30" rows="10">{{$mrd->brief}}</textarea>
					</li>
				</ul>
			</div>
			<div class="block multiadd product" data-index="{{$n++}}">
				<h3 class="ttl">相關產品訊息</h3>
				<div class="compinfo">
					@if(isset($conts->product))
					@foreach($conts->product as $product)
					<div class="cinfo" id="item_row{{++$item}}">
						<a onclick="del_info('{{$item}}')" class="del"><i class="fa fa-times-circle" aria-hidden="true"></i></a>
						<img src="{{$product->pic}}" >
						<h4>{{$product->name}}</h4>
						<input type="hidden" name="oldprod[]" value="{{$product->name}}">
						<input type="hidden" name="oldprod_pic[]" value="{{$product->pic}}">
					</div>
					@endforeach
					@endif
					<div style="clear:both;"></div>
				</div>
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
								<h4 class="ttl">FACEBOOK</h4>
								<input type="text" name="facebook_id" value="{{$mrd->facebook_id}}">
								<p>*請貼上ID <a>*說明</a> </p>
							</li>
							<li>
								<h4 class="ttl">Google</h4>
								<input type="text" name="google_id" value="{{$mrd->google_id}}">
								<p>*請貼上ID <a>*說明</a></p>
							</li>
						</ul>
					</li>
				</ul>
			</div>
			<div class="block interest">
				<ul class="custom-input">
					<li class="wrap">
						<h4 class="sttl">請勾選您有興趣的主題內容：</h4>
						<ul class="custom-radio sub">
							<li>
								<input name="interest-all" id="interest-all" type="checkbox" onchange="chg_interest()">
								<label for="interest-all" id="interest-all">全部文章</label>
							</li>
							@foreach($news_type as $k => $type)
								@if($type!='')
								<?php
								$interest = explode(',',$mrd->tags) ;
								?>
								<li>
									<input name="interest[]" id="interest-cat{{$k+1}}" type="checkbox" value="{{$type}}" {{in_array($type,$interest)?'checked':''}}>
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
					<?php
					$comprd = \App\Cm::where('position', 'company')->where('up_sn', session('mid'))->first();
					if(!$comprd) $comprd = \App\Cm::create(['up_sn'=>session('mid'), 'position'=>'company']);
					$comp_type = explode(',', $comprd->type) ;
					?>
					<li>
						<div class="title">
							<h4 class="ttl">*廠商名稱</h4>
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
							<h4 class="ttl">*Email信箱</h4>
						</div>
						<div>
							<input type="text" name="compemail" id="compemail" value="{{$comprd->email}}">
						</div>
						<p style="margin-right:20px;">是否開放</p>
						<ul class="custom-radio sub flex wrap">
							<li>
								<input name="show_compemail" id="email_showY" type="radio" value="Y" {{$mrd->show_email=='Y'?'checked':''}}>
								<label for="email_showY">是</label>
							</li>
							<li>
								<input name="show_compemail" id="email_showN" type="radio" value="N" {{$mrd->show_email=='N'?'checked':''}}>
								<label for="email_showN" >否</label>
							</li>
						</ul>
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
				@if($pos=='上市產品')
					@continue
				@endif
				<div class="block upload company multiadd" data-index="{{$n++}}">
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
						@if($pos=='上市產品')
						<li>
							<div class="title">
								<h4 class="ttl">產品類別</h4>
							</div>
							<ul class="custom-radio sub flex wrap">

								@foreach($prods_type as $k => $type)
									<li>
										<input name="compinfo_type[{{$pos}}][]" id="compinfo_type{{$k}}" type="checkbox" value="{{$type}}">
										<label for="compinfo_type{{$k}}" >{{$type}}</label>
									</li>
								@endforeach
							</ul>
						</li>
						<li>
							<div class="title">
								<h4 class="ttl">youtube連結</h4>
							</div>
							<div class="prop">
								<input type="text" name="compinfo_youtube[{{$pos}}][]">
							</div>
						</li>
						@endif
						<li class="sep"></li>	
					</ul>
					<button type="button" class="btn-add-sp">+</button>
				</div>
			@endforeach
			<div class="g-recaptcha" data-sitekey="6Ld2jCsUAAAAADvo2gGU9wJBgwMSCygH1w6ec_Ky"></div>
			<p class="red fz-s">*資料請務必填寫完整，以保障會員權益</p>
			<div class="btn-confirm">
				<a href="/member/index" class="btn-cancel">取消</a>
				<a onclick="edit_submit()" class="btn-confirm">儲存修改</a>
			</div>
			<input type="hidden" name="_token" value="{{csrf_token()}}">
			<input type="hidden" name="type" value="{{$mrd->type}}" >
			<input type="hidden" name="oldtype" value="{{$mrd->type}}" >
			<input type="hidden" name="up_sn" value="{{$mrd->id}}" >
			<input id="member_type" type="hidden" name="type" value="{{$mrd->type}}" >
			<input type="hidden" name="old_type" value="{{$mrd->type}}">
		</form>
	</div>
</section>
@endsection
@section('javascript')
<script type="text/javascript">
	$(function(){
		var member_type = $('#member_type').val();
		chg_type(member_type);
		register_form('#passwd_form');
		$('.datepicker').pickadate({format: 'yyyy-mm-dd', selectYears:50, max: new Date()});
	})
	function edit_submit(){
		var oldtype = $('.oldtype').val();
		var newtype = $('.member_type').val();
		if(oldtype!=newtype){
			if(!confirm("確定要將會將註冊身分由『"+oldtype+"』換成『"+newtype+"』嗎？\n此動作將會刪除原註冊資料，並重新換上本次填寫之修改資料！")){
	        	return false;
		    }
		}
		submit_form('#edit_form', function(res){
			load_page('/member/edit');
		});
		
	}
	function chg_interest(){
		var chk = $('#interest-all').prop('checked');
		$('input[name="interest[]"]').prop('checked', chk);
	}
	function del_info(delsn){
	    if(!confirm("確定要刪除嗎？")){
	        return false;
	    }else{
            $("#item_row" + delsn).remove();
	    }
	}

	function chg_type(member_type){
		var memberType = {
			'學界專家' :['sname','department','test_exp','invest','product','case','website','address','company','comptype'],
			'產業專家' :['sname','department','test_exp','invest','product','case','website','address','company','comptype'],
			'醫療人員' :['sname','invest','product','case','website','patent','address','technology','weblink','expertise','company','comptype'],
			'創投業者' :['sname','unit','department','gender','school','research','test_exp','product','patent','technology','weblink','expertise','comptype','company','blog','invest','job_title','comptype'],
			'服務業者':['sname','school','unit','gender','department','research','test_exp','invest','patent','blog','technology','weblink','expertise','comptype','company','job_title','comptype'],
			'一般' :['job_title','schoo','exp','unit','tel','department','research','test_exp','invest','product','case','website','patent','expertise','brief','address','technology','weblink','company','comptype']
		}
		$('.member_info').css({'display':'flex'});
		$('.block').show();
		//更換文字
		if(member_type == '創投業者'){
			$('.block .pic .ttl').html('廠商logo');
			$('.block .name .ttl').html('公司名稱');
			$('.block .job_title .ttl').html('投資領域');
			$('.block .case .ttl').html('相關投資案例');
		}else if(member_type == '服務業者'){
			$('.block .pic .ttl').html('廠商logo');
			$('.block .name .ttl').html('公司名稱');
			$('.block .job_title .ttl').html('服務領域');
		}

		if(member_type == '醫材廠商'){
			let hide = ['basic','social','interest','member_info','product'];
			hide.forEach(v =>{
				$('.block.' + v).hide();
			})
			$('.company').css({'display':'block'});
			$('.comptype').css({'display':'flex'});
		} else {
			// memberType[type].forEach(v => {
			// 	$('.' + v).hide();
			// 	if(type=="service"){
			// 		$('.block.product').css({'display':'block'});
			// 	}else{
			// 		$('.block.product').hide();
			// 	}	
			// })
			memberType[member_type].forEach(v => {
				$('.' + v).hide();
			})
		}
		$('.member_type').val(member_type);
	}
</script>
@endsection