@extends('main')
@section('content')
<section class="register">
	<div class="ttl-bar">
		<h2>會員註冊</h2>
	</div>
	<div class="content grid-intro form">
		<form id="forget_form" action="/do/forget_password" method="post">
			<div class="query custom-input">
				<ul class="custom sub">
					<li>
						<label for="query-pwd" id="query-pwd">請輸入註冊時所填寫的電子郵件</label>
					</li>
				</ul>
				<input id="loginid" type="text" class="w-full mb20" name="email" placeholder="電子郵件 email">
				<div class="g-recaptcha mb20" data-sitekey="6Ld2jCsUAAAAADvo2gGU9wJBgwMSCygH1w6ec_Ky"></div>
				<button type="submit" class="btn-box">送出</button>
			</div>
			<input type="hidden" name="_token" value="{{csrf_token()}}">
		</form>
	</div>
</section>
@endsection
@section('javascript')
<script type="text/javascript">
$(function(){
	register_form('#forget_form', function(res){		
		load_page('/member/index');
	}, function(){
		if($('#loginid').val() == ''){
			alert('請輸入電子郵件 email，請勿空白');
			return false;
		}
	});
});
</script>
@endsection