@extends('main')
@section('content')
<?php
$mrd = \App\Members::where('id',$id)->first();
if($mrd->type!='一般'){
	$expert = \App\Cm::where('position','expert')->where('up_sn',$mrd->id)->first();
	$conts = json_decode($expert->cont);
}  
$posts = \App\Cm::where('position','posts')->where('up_sn',$id)->count();
$reply = \App\Cm::where('position','comments')->where('objsn',$id)->groupby('up_sn')->get()->count();
?>
<section class="member">
	<div class="ttl-bar member_menu">
		<h2>會員資料</h2>
	</div>
	<div class="breadcrumb">
		<a href="">會員</a> &gt; <a class="name" href="">基本資料</a>
	</div>
	<div class="content form">
		<div class="cat1 active">
			<div class="overall flex v-center">
				<div class="avatar">
					<div class="img">
						<img src="{{\App\Members::get_pic($mrd->id)}}" alt="">
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
				<!-- <a class="right btn" href="/member/edit"><i class="fa fa-pencil" aria-hidden="true"></i> 修改會員資料</a> -->
				<div style="margin-top:20px ">
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
						@if($mrd->email!=''&&$mrd->show_email=='Y')
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
						@if(isset($conts->exp) )
						<tr>
							<th>學經歷</th>
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
	</div>
</section>
@endsection
@section('javascript')
@endsection