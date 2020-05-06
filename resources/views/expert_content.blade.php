公司網站<?php
$choose_type = \App\Cm::get_expert_type();
if(!isset($id)){
	session()->flash('sysmsg', '找不到專家資料');
	echo '<script>location.href="/"</script>';
	exit;
}else{
	$rd = \App\Cm::where('id',$id)->first();
	$experts_type = $rd->type ;
	$conts = json_decode($rd->cont);
	\App\Cm::where('id',$id)->increment('hits');
	if(!$rd){
		session()->flash('sysmsg', '找不到專家資料');
		echo '<script>location.href="/"</script>';
		exit;
	}else{
		if($rd->up_sn!=0) $member = \App\Members::where('id',$rd->up_sn)->first();
	}
}
$active="display:flex";
?>
@extends('main')
@section('content')	
<section class="professional-inner bg-gray">
	<div class="ttl-bar">
		<h2>聚落專家</h2>
		<ul class="tab"> 	
			@foreach($choose_type as $t) 
			<li class="{{$t==$experts_type?'active':''}}"><a href="/expert/{{$t}}">{{$t}}</a></li>
			@endforeach
		</ul>
	</div>
	<div class="breadcrumb">
		<a href="/">首頁</a> &gt; <a href="/expert">聚落專家</a> &gt; <a href="">{{$experts_type}}</a>
	</div>
	<div class="content clearfix">
		<div class="profile flex">
			<?php
			  $pic_src = \App\Cm::get_pic($rd->id);
			  $src = $pic_src=='/images/no_image.gif'?'/img/member_default.png':$pic_src;
			?>
			<div class="img"><img src="{{$src}}" alt="{{$rd->name}}"></div>
			<div class="text">
				<h3 class="ttl">{{$experts_type}} <span>{{$rd->name}}</span></h3>
				<p>{{$rd->brief}}</p>
			</div>
		</div>
		<dl class="cat1 profile-detail flex wrap show_cont" style="{{$rd->type=='學界專家'||$rd->type=='產業專家'?$active:''}}">
			@if(isset($conts->unit))
			<dt>單位</dt>
			<dd>
				@foreach($conts->unit as $unit)
					{{$unit}}
				@endforeach
			</dd>
			@endif
			@if(isset($conts->job_title))
			<dt>職稱</dt>
			<dd>
				@foreach($conts->job_title as $job_title)
					{{$job_title}}
				@endforeach
			</dd>
			@endif
			@if(isset($member->gender)&&$member->gender!='')
			<dt>性別</dt>
			<dd>{{$member->gender=='M'?'男':'女'}}</dd>
			@endif
			@if(isset($conts->email))
			<dt>E-mail</dt>
			<dd>
				@foreach($conts->email as $email)
					{{$email}}
				@endforeach
			</dd>
			@endif
			@if(isset($conts->tel))
			<dt>聯絡電話</dt>
			<dd>
				@foreach($conts->tel as $tel)
					{{$tel}}
				@endforeach
			</dd>
			@endif
			@if(isset($conts->blog))
			<dt>個人部落格</dt>
			<dd>
				@foreach($conts->blog as $blog)
					{{$blog}}
				@endforeach
			</dd>
			@endif
			@if(isset($conts->expertise))
			<dt>專長領域</dt>
			<dd>
				@foreach($conts->expertise as $expertise)
					{{$expertise}} <br>
				@endforeach
			</dd>
			@endif
			@if(isset($conts->technology))
			<dt>技術轉移</dt>
			<dd>
				@foreach($conts->technology as $technology)
					{{$technology}}
				@endforeach
			</dd>
			@endif
			@if(isset($conts->weblink))
			<dt>科技部研發服務網址</dt>
			<dd>
				@foreach($conts->weblink as $weblink)
					<a href="{{$weblink}}" target="_blank">{{$weblink}}</a>
				@endforeach
			</dd>
			@endif
			@if(isset($conts->patent))
			<dt>專利</dt>
			<dd>
				@foreach($conts->patent as $patent)
					{{$patent}} <br>
				@endforeach
			</dd>
			@endif
			@if(isset($conts->school))
			<dt>學歷</dt>
			<dd>
				@foreach($conts->school as $school)
					{{$school}}<br>
				@endforeach
			</dd>
			@endif
			@if(isset($conts->exp))
			<dt>經歷</dt>
			<dd>
				@foreach($conts->exp as $exp)
					{{$exp}}<br>
				@endforeach
			</dd>
			@endif
			@if(isset($conts->research))
			<dt>相關研究計畫</dt>
			<dd>
				@foreach($conts->research as $research)
					{{$research}} <br>
				@endforeach
			</dd>
			@endif
			@if($rd->facebook_id!='')
			<dt>Facebook</dt>
			<dd>{{$rd->facebook_id}}</dd>
			@endif
		</dl>
		<dl class="cat2 profile-detail flex wrap" style="{{$rd->type=='醫療人員'?$active:''}}">
			@if(isset($conts->department))
			<dt>執業科別</dt>
			<dd>
				@foreach($conts->department as $department)
					{{$department}}<br>
				@endforeach
			</dd>
			@endif
			@if(isset($member->gender)&&$member->gender!='')
			<dt>性別</dt>
			<dd>{{$member->gender=='M'?'男':'女'}}</dd>
			@endif
			@if(isset($conts->unit))
			<dt>單位</dt>
			<dd>
				@foreach($conts->unit as $unit)
					{{$unit}}
				@endforeach
			</dd>
			@endif
			@if(isset($conts->job_title))
			<dt>職稱</dt>
			<dd>
				@foreach($conts->job_title as $job_title)
					{{$job_title}}
				@endforeach
			</dd>
			@endif
			@if(isset($conts->school))
			<dt>學歷</dt>
			<dd>
				@foreach($conts->school as $school)
					{{$school}}<br>
				@endforeach
			</dd>
			@endif
			@if(isset($conts->exp))
			<dt>經歷</dt>
			<dd>
				@foreach($conts->exp as $exp)
					{{$exp}}<br>
				@endforeach
			</dd>
			@endif
			@if(isset($conts->research))
			<dt>相關研究計畫</dt>
			<dd>
				@foreach($conts->research as $research)
					{{$research}} <br>
				@endforeach
			</dd>
			@endif
			@if(isset($conts->test_exp))
			<dt>臨床試驗經歷</dt>
			<dd>
				@foreach($conts->test_exp as $test_exp)
					{{$test_exp}}<br>
				@endforeach
			</dd>
			@endif
			@if(isset($conts->blog))
			<dt>個人部落格</dt>
			<dd>
				@foreach($conts->blog as $blog)
					{{$blog}}
				@endforeach
			</dd>
			@endif
			@if($rd->facebook_id!='')
			<dt>Facebook</dt>
			<dd>{{$rd->facebook_id}}</dd>
			@endif
		</dl>
		<dl class="cat3 profile-detail flex wrap" style="{{$rd->type=='服務業者'?$active:''}}">
			@if(isset($conts->email))
			<dt>E-mail</dt>
			<dd>
				@foreach($conts->email as $email)
					{{$email}}
				@endforeach
			</dd>
			@endif
			@if(isset($conts->tel))
			<dt>聯絡電話</dt>
			<dd>
				@foreach($conts->tel as $tel)
					{{$tel}}
				@endforeach
			</dd>
			@endif
			@if(isset($conts->address))
			<dt>地址</dt>
			<dd>
				@foreach($conts->address as $address)
					{{$address}}
				@endforeach
			</dd>
			@endif
			@if(isset($conts->website))
			<dt>公司網站</dt>
			<dd>
				@foreach($conts->website as $website)
					<a href="{{$website}}" target="_blank">{{$website}}</a>
				@endforeach
			</dd>
			@endif
			@if(isset($conts->case))
			<dt>相關服務案例</dt>
			<dd>
				@foreach($conts->case as $case)
					{{$case}}<br>
				@endforeach
			</dd>
			@endif
			@if(isset($conts->product))
			<dt>相關產品訊息</dt>
			<dd>
				@foreach($conts->product as $product)
					{{$product->name}}
				@endforeach
			</dd>
			@endif
			@if(isset($conts->blog))
			<dt>個人部落格</dt>
			<dd>
				@foreach($conts->blog as $blog)
					{{$blog}}
				@endforeach
			</dd>
			@endif
			@if($rd->facebook_id!='')
			<dt>Facebook</dt>
			<dd>{{$rd->facebook_id}}</dd>
			@endif
		</dl>
		<dl class="cat4 profile-detail flex wrap" style="{{$rd->type=='創投業者'?$active:''}}">
			@if(isset($conts->unit))
			<dt>單位</dt>
			<dd>
				@foreach($conts->unit as $unit)
					{{$unit}}
				@endforeach
			</dd>
			@endif
			@if(isset($conts->job_title))
			<dt>職稱</dt>
			<dd>
				@foreach($conts->job_title as $job_title)
					{{$job_title}}
				@endforeach
			</dd>
			@endif
			@if(isset($member->gender)&&$member->gender!='')
			<dt>性別</dt>
			<dd>{{$member->gender=='M'?'男':'女'}}</dd>
			@endif
			@if(isset($conts->school))
			<dt>學歷</dt>
			<dd>
				@foreach($conts->school as $school)
					{{$school}}<br>
				@endforeach
			</dd>
			@endif
			@if(isset($conts->exp))
			<dt>經歷</dt>
			<dd>
				@foreach($conts->exp as $exp)
					{{$exp}}<br>
				@endforeach
			</dd>
			@endif
			
			@if(isset($conts->invest))
			<dt>投資偏好產業</dt>
			<dd>
				@foreach($conts->invest as $invest)
					{{$invest}}
				@endforeach
			</dd>
			@endif
			@if(isset($conts->blog))
			<dt>個人部落格</dt>
			<dd>
				@foreach($conts->blog as $blog)
					{{$blog}}
				@endforeach
			</dd>
			@endif
			@if($rd->facebook_id!='')
			<dt>Facebook</dt>
			<dd>{{$rd->facebook_id}}</dd>
			@endif
		</dl>
		<dl class="cat5 profile-detail flex wrap" style="{{$rd->type=='其他'?$active:''}}">
			<dt>公司名稱</dt>
			<dd></dd>
			<dt>地址、聯絡方式</dt>
			<dd></dd>
			<dt>專長領域</dt>
			<dd></dd>
			<dt>個人部落格、Facebook</dt>
			<dd>https://www.facebook.com/</dd>
			<dt>相關產品訊息</dt>
			<dd></dd>
			<dt>相關服務案例</dt>
			<dd></dd>
		</dl>
	</div>
</section>
@endsection
@section('javascript')
@endsection