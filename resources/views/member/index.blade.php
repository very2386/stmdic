@extends('main')
@section('content')
<style type="text/css">
.product{
    margin-right: 20px;
    margin-bottom: 10px;
}
.product li{
	width: 100px;
}
</style>
@if(!session('mid'))
<section class="">
	<div class="ttl-bar">
		<h2>會員登入</h2>
		<!-- <div class="searchbar">
			<input type="search" placeholder="文章搜尋">
			<button class="btn-search">Search</button>
		</div> -->
	</div>
	<div class="content two-side clearfix">
		<div class="side-left active article">
			<?php
			$pic = \App\Cm::where('position','advertismenet')->where('mstatus','Y')->inRandomOrder()->limit(1)->get() ; 
			?>
			<div class="img mb20">
				@if($pic->count()>0)
					@foreach($pic as $rd)
					<img src="{{\App\Cm::get_pic($rd->id)}}" alt="">
					@endforeach
				@else
					<img src="http://fakeimg.pl/1200x700/?text=advertismenet" alt="">
				@endif
			</div>
		</div>
		<div class="side-right right-st1">
			<ul>
				<li>
					<h3 class="ttl">會員登入</h3>
					<form id="loginform" action="/do/member_login" method="post" >
						<div class="normal">
							<ul class="custom-input">
								<li><input class="w-full" type="text" id="loginid" name="loginid" placeholder="帳號ID或email"></li>
								<li><input class="w-full" type="password" id="login_password" name="login_password" placeholder="密碼Password"></li>
								<li><button type="submit" class="btn-box" id="btn-login">登入</button></li>
							</ul>
						</div>
						<div class="social">
							<h4>您也可以由以下帳號登入</h4>
							<ul>
								<li><a href="{{\App\Members::get_fb_login_url()}}" class="btn-box facebook clearfix"><span class="icon"><img src="/img/logo/fb-s.png" alt=""></span><span>Facebook 登入</span></a></li>
								<li><a href="{{\App\Members::get_googleplus_login_url()}}" class="btn-box google"><span class="icon"><img src="/img/logo/gp-s.png" alt=""></span><span>Google+ 登入</span></a></li>
							</ul>
						</div>
						<div class="flex between equal">
							<a class="t-center" href="/member/forget">忘記帳號密碼</a>
							<a class="t-center" href="/member/signup">註冊新帳號</a>
							<input type="hidden" name="_token" value="{{csrf_token()}}">
						</div>
					</form>
				</li>			
			</ul>
		</div>
	</div>
</section>
@else
<?php
$mrd = \App\Members::where('id', session('mid'))->first();
if($mrd->type!='一般'){
	$expert = \App\Cm::where('position','expert')->where('up_sn',$mrd->id)->first();
	if($expert){
		$conts = json_decode($expert->cont);
	}else{
		$conts = (object)[];
	}
	
}  
$posts = \App\Cm::where('position','posts')->where('up_sn',session('mid'))->count();
$reply = \App\Cm::where('position','comments')->where('objsn',session('mid'))->groupby('up_sn')->get()->count();
?>
<section class="member">
	@include('member.menu')
	<div class="breadcrumb">
		<a href="">會員專區</a> &gt; <a class="name" href="">基本資料</a>
	</div>
	<div class="content form">
		<div class="cat1 active">
			<div class="overall flex v-center">
				<div class="avatar">
					<div class="img">
						<img src="{{\App\Members::get_pic(session('mid'))}}" alt="">
					</div>
					<!-- <div class="badge flex between">
						<img src="/img/icon/id-normal.png" alt="">
						<img src="/img/icon/badge-bestans.png" alt="">
						<img src="/img/icon/badge-recommend.png" alt="">
						<img src="/img/icon/badge-weeklychampion.png" alt="">
					</div> -->
				</div>
				<div class="status">
					<ul class="flex">
						<li>
							<span class="num">{{$posts}}</span>發表的文章
						</li>
						<li>
							<span class="num">{{$reply}}</span>回覆留言數
						</li>
					</ul>
				</div>
			</div>
			<div class="profile-tbl">
				<a class="right btn" href="/member/edit"><i class="fa fa-pencil" aria-hidden="true"></i> 修改會員資料</a>
				<table>
					<tr>
						<th>註冊身分</th>
						<td>{{$mrd->type}}</td>
					</tr>
					<tr>
						<th>會員ID</th>
						<td>{{$mrd->loginid}}</td>
					</tr>
					<tr>
						<th>姓名</th>
						<td>{{$mrd->name}}</td>
					</tr>
					@if(isset($conts->job_title) )
					<tr>
						<th>職稱</th>
						@foreach($conts->job_title as $job_title)
						<td>{{$job_title}}</td>
						@endforeach
					</tr>
					@endif
					@if(isset($conts->unit) )
					<tr>
						<th>單位</th>
						@foreach($conts->unit as $unit)
						<td>{{$unit}}</td>
						@endforeach
					</tr>
					@endif
					@if($mrd->type!='服務業者')
					<tr>
						<th>性別</th>
						<td>{{$mrd->gender == 'M' ? '男':'女'}}</td>
					</tr>
					@endif
					@if($mrd->type=='一般'&&$mrd->sname!='')
					<tr class="sname member_info">
						<th>暱稱</th>
						<td>{{$mrd->sname}}</td>
					</tr>
					@elseif(isset($conts->sname) )
					<tr>
						<th>暱稱</th>
						@foreach($conts->sname as $sname)
						<td>{{$sname}}</td>
						@endforeach
					</tr>
					@endif
					@if($mrd->email!='')
					<tr>
						<th>E-mail</th>
						<td>{{$mrd->email}}</td>
					</tr>
					@endif
					@if(isset($conts->tel) )
					<tr>
						<th>聯絡電話</th>
						@foreach($conts->tel as $tel)
						<td>{{$tel}}</td>
						@endforeach
					</tr>
					@endif
					@if(isset($conts->address) )
					<tr>
						<th>地址</th>
						@foreach($conts->address as $address)
						<td>{{$address}}</td>
						@endforeach
					</tr>
					@endif
					@if(isset($conts->technology) )
					<tr>
						<th>技術轉移</th>
						@foreach($conts->technology as $technology)
						<td>{{$technology}}</td>
						@endforeach
					</tr>
					@endif
					@if(isset($conts->weblink) )
					<tr>
						<th>科技部研發服務網址</th>
						@foreach($conts->weblink as $weblink)
						<td>{{$weblink}}</td>
						@endforeach
					</tr>
					@endif
					@if(isset($conts->website) )
					<tr>
						<th>公司網站</th>
						@foreach($conts->website as $website)
						<td>{{$website}}</td>
						@endforeach
					</tr>
					@endif
					@if(isset($conts->blog) )
					<tr>
						<th>部落格</th>
						@foreach($conts->blog as $blog)
						<td>{{$blog}}</td>
						@endforeach
					</tr>
					@endif
					@if(isset($conts->department) )
					<tr>
						<th>執業類別</th>
						@foreach($conts->department as $department)
						<td>{{$department}}</td>
						@endforeach
					</tr>
					@endif
					@if(isset($conts->school) )
					<tr>
						<th>學歷</th>
						<td>
							@foreach($conts->school as $school)
								<div>{{$school}}</div>
							@endforeach
						</td>
					</tr>
					@endif
					@if(isset($conts->exp) )
					<tr>
						<th>經歷</th>
						<td>
							@foreach($conts->exp as $exp)
							{{$exp}} <br>
							@endforeach
						</td>
					</tr>
					@endif
					@if(isset($conts->expertise) )
					<tr>
						<th>專長領域</th>
						<td>
							@foreach($conts->expertise as $expertise)
							{{$expertise}} <br>
							@endforeach
						</td>
					</tr>
					@endif
					@if(isset($conts->research) )
					<tr>
						<th>相關研究計畫</th>
						<td>
							@foreach($conts->research as $research)
							{{$research}} <br>
							@endforeach
						</td>
					</tr>
					@endif
					@if(isset($conts->patent) )
					<tr>
						<th>專利</th>
						<td>
							@foreach($conts->patent as $patent)
							{{$patent}} <br>
							@endforeach
						</td>
					</tr>
					@endif
					@if(isset($conts->test_exp) )
					<tr>
						<th>臨床試驗經歷</th>
						<td>
							@foreach($conts->test_exp as $test_exp)
							{{$test_exp}} <br>
							@endforeach
						</td>
					</tr>
					@endif
					@if(isset($conts->invest) )
					<tr>
						<th>投資偏好產業</th>
						<td>
							@foreach($conts->invest as $invest)
							{{$invest}} <br>
							@endforeach
						</td>
					</tr>
					@endif
					@if(isset($conts->case) )
					<tr>
						<th>相關服務案例</th>
						<td>
							@foreach($conts->case as $case)
							{{$case}} <br>
							@endforeach
						</td>
					</tr>
					@endif
					@if(isset($conts->product) )
					<tr>
						<th>相關產品資訊</th>
						<td>
							<div class="flex">
								@foreach($conts->product as $prod)
									<div class="product">
										<ul>
											<li>
												{{$prod->name}}
											</li>
											<li class="img"><img src="{{$prod->pic}}"></li>
										</ul>
									</div>
								@endforeach
							</div>
						</td>
					</tr>
					@endif
					@if($mrd->facebook_id!='')
					<tr>
						<th>Facebook</th>
						<td>{{$mrd->facebook_id}}</td>
					</tr>
					@endif
					@if($mrd->google_id!='')
					<tr>
						<th>Google</th>
						<td>{{$mrd->google_id}}</td>
					</tr>
					@endif
					@if($mrd->brief!='')
					<tr class="brief member_info">
						<th>簡介</th>
						<td>{{$mrd->brief}}</td>
					</tr>
					@endif
				</table>
			</div>
		</div>
	</div>
</section>
@endif
@endsection
@section('javascript')
<script type="text/javascript">
$(function(){
	register_form('#loginform', function(res){		
		// if(res.data.type=='醫材廠商') load_page('/member/edit');
		// else load_page('/member/index');
		if(res.after_login) load_page(res.after_login);
		else load_page('/') ;
	}, function(){
		if($('#loginid').val() == '' || $('#login_password').val() == ''){
			alert('請輸入帳號及密碼，請勿空白');
			return false;
		}
	});
	$('#calendar').fullCalendar({
		schedulerLicenseKey: 'CC-Attribution-NonCommercial-NoDerivatives'
	});

});
</script>
@endsection