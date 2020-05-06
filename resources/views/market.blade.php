<?php
\App\Cm::where('position','people')->where('type','marketing')->increment('hits');
$home_pic = \App\Cm::where('position','market')->where('type','slider')->where('mstatus','Y')->orderBy('psort','desc')->get();
$market = \App\Cm::where('position','article')->where('type','market')->first();
$bodyclass = "page-market";
$bodyid = "page-market";
$prospectAry = ['目前展會', '未來展會'];
$video_link = \App\Cm::where('position','market_video')->value('link');
?>
@extends('main')
@section('content')
<style>
.market-home-img{
	max-width:100%;
	margin:auto;
}
</style>
<!-- TOP BANNER -->
<section class="top clearfix">
	<div class="swiper-container" data-mode="fade" data-pause="false" data-speed="3000" data-autoplay="3000">
		<ul class="swiper-wrapper">
			<!-- @foreach($home_pic as $h)
			<li class="swiper-slide img"><a href="{{$h->link}}" target="_blank"><img src="{{\App\Cm::get_pic($h->id)}}" alt="{{$h->brief}}"></a></li>
			@endforeach -->
			<li class="swiper-slide img">
				<!-- <iframe width="1200" height="450" src="https://www.youtube.com/watch?v=_HQHXem-TzY&t=8" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe> -->
				<iframe width="1200" height="450" src="https://www.youtube.com/embed/{{$video_link}}" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>

			</li>
		</ul>
		<!-- <div class="swiper-pagination"></div> -->
	</div>
	
</section>
@if($market)
<section class="market-prod">
	<div class="ttl-bar">
		<h2>聚落產品</h2>
	</div>
	<div class="content">
		<ul class="flex submenu-pic" style="margin-bottom: 20px;">
			<?php
				$prods = \App\Cm::get_prods_type();
			?>
			@foreach($prods as $k => $v)
				@if($k >= 4 && $k <=5)<!--med-->
				<li class="i{{$k+1}} {{$k == 0 ? 'active' : ''}}" data-target="cat{{$k+1}}"><div class="img"><img src="/img/icon/market/i5{{$k == 0 ? '-c' : ''}}.png" alt=""></div><div class="text">{{$v}}</div></li>
				@elseif ($k >= 6 && $k <=7)<!-- biotech -->
				<li class="i{{$k+1}} {{$k == 0 ? 'active' : ''}}" data-target="cat{{$k+1}}"><div class="img"><img src="/img/icon/market/i6{{$k == 0 ? '-c' : ''}}.png" alt=""></div><div class="text">{{$v}}</div></li>
				@elseif($k == 8)
				<li class="i{{$k+1}} {{$k == 0 ? 'active' : ''}}" data-target="cat{{$k+1}}"><div class="img"><img src="/img/icon/market/i7{{$k == 0 ? '-c' : ''}}.png" alt=""></div><div class="text">{{$v}}</div></li>
				@else
				<li class="i{{$k+1}} {{$k == 0 ? 'active' : ''}}" data-target="cat{{$k+1}}"><div class="img"><img src="/img/icon/market/i{{$k+1}}{{$k == 0 ? '-c' : ''}}.png" alt=""></div><div class="text">{{$v}}</div></li>
				@endif
			@endforeach
		</ul>
		<div class="content grid-intro">
			@foreach($prods as $k => $v)
			<?php
				// $company = \App\Cm::where('position', 'company')->where('type', 'like', '%'.$v.'%')->where('mstatus','Y')->get();
				// $compAry = [];
				// foreach ($company as $cmpid) {
				// 	$compAry[] = $cmpid->id;
				// }
				$products = \App\Cm::where('position', 'compinfo')->where('type', '上市產品')->where('tags','like','%'.$v.'%')->where('mstatus','Y')->inRandomOrder()->limit(10)->get();	
			?>
			<div class="cat{{$k+1}} {{$k == 0 ? 'active' : ''}}">
				<div class="slider">
					<div class="swiper-container">
						<ul class="swiper-wrapper grid4 no-shrink">
							@foreach($products as $rd)
							<li class="swiper-slide">
								<div class="img">
									<a href="/marketing/marketing/{{$v}}/{{$rd->id}}"><img src="{{$rd->pic}}" alt=""></a>
								</div>
								<div class="text">
									<h3><a href="/marketing/marketing/{{$v}}/{{$rd->id}}">{{$rd->name}}</a></h3>
									<p class="company">{{\App\Cm::where('id',$rd->up_sn)->value('name')}}</p>
									<p>{{$rd->brief}}</p>
									
								</div>
							</li>
							@endforeach
						</ul>
					</div>
					<div class="swiper-button-next black"></div>
					<div class="swiper-button-prev black"></div>
				</div>
				<a href="/marketing/marketing/{{$v}}" class="btn-more">More....</a>
			</div>
			@endforeach
		</div>
	</div>
</section>
<section>
	<div class="ttl-bar">
		<h2>展示平台</h2>
		<ul class="tab">
			<li class="active" data-target="cat0">
				<a>醫材展示室</a>	
			</li>
			<li data-target="cat1">
				<a>產品體驗</a>
			</li>
			<li data-target="cat2">
				<a>數位影音</a>
			</li>
		</ul>
	</div>
	<div class="content grid-intro pd15">
		<div class="cat0 active">
			<section class="two-side mb10">
				<div class="side-left">
					<div class="swiper-container" data-mode="fade" data-pause="false" data-speed="3000" data-autoplay="3000">
						<ul class="swiper-wrapper">
							<?php
							$space_data = \App\Cm::where('position','space')->first() ; 
							$space_imgs = \App\OtherFiles::where('cm_id',$space_data->id)->where('position','space')->get();
							?>
							@foreach($space_imgs as $img)
							<li class="swiper-slide img">
								<a>
									<img src="{{$img->fname}}" alt="">
								</a>
							</li>
							@endforeach
						</ul>
						<div class="swiper-pagination swiper-pagination-clickable swiper-pagination-bullets"><span class="swiper-pagination-bullet"></span><span class="swiper-pagination-bullet"></span><span class="swiper-pagination-bullet swiper-pagination-bullet-active"></span><span class="swiper-pagination-bullet"></span></div>
					</div>
				</div>
				<div class="side-right">
					<h3 class="fz-m brown bold mb20">{{$space_data->name}}</h3>
					<p class="mb10">{!!$space_data->cont!!}</p>
				</div>
			</section>
		</div>
		<div class="cat1">
			<div class="slider">
                <div class="swiper-container">
                    <?php
                    $rs = \App\Cm::where('position','compinfo')->where('online_status','Y')->orderBY('psort','DESC')->limit(6)->get();
                    ?>
                    <ul class="swiper-wrapper grid4 no-shrink">
                        @foreach($rs as $rv)
                        <li class="swiper-slide">
                            <div class="img">
                                <a href="/marketing/product_experience/{{$rv->id}}"><img src="{{\App\Cm::get_pic($rv->id)}}" alt=""></a>
                            </div>
                            <div class="text">
                                <h3><a href="/marketing/product_experience/{{$rv->id}}">{{$rv->name}}</a></h3>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
                <div class="swiper-button-next black"></div>
                <div class="swiper-button-prev black"></div>
            </div>
            <a class="btn-more" href="/marketing/product_experience" style="bottom: -40px;right: 40px;">More....</a>
		</div>
		<div class="cat2">
			<div class="slider">
                <div class="swiper-container">
                    <?php
                    $video = \App\Cm::where('position','video')->where('type','行銷專區')->orderBY('psort','DESC')->limit(6)->get();
                    ?>
                    <ul class="swiper-wrapper grid4 no-shrink">
                        @foreach($video as $rv)
                        <li class="swiper-slide">
                            <div class="img">
                                <a href="/video/{{$rv->id}}"><img src="{{\App\Cm::get_pic($rv->id)}}" alt=""></a>
                            </div>
                            <div class="text">
                                <h3><a href="/video/{{$rv->id}}">{{$rv->name}}</a></h3>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
                <div class="swiper-button-next black"></div>
                <div class="swiper-button-prev black"></div>
            </div>
            <a class="btn-more" href="/video/數位影音" style="bottom: -40px;right: 40px;">More....</a>
		</div>
	</div>
</section>
<section class="market">
	<div class="ttl-bar">
		<h2>展會相關</h2>
		<ul class="tab">
			@foreach($prospectAry as $k => $pros)
			<li data-target="cat{{$k}}" class="{{$k == 0 ? 'active' : ''}}"><a>{{$pros}}</a></li>
			@endforeach
		</ul>
	</div>
	<div class="content grid-intro bg-gray">
		@foreach($prospectAry as $k => $pros)
		<?php
			$position = $pros == "未來展會" ? 'fprospect' : 'prospect' ; 
			$in = \App\Prospects::where('position',$position)->where('type','國內展會')->get();
			$out = \App\Prospects::where('position',$position)->where('type','國外展會')->get();
		?>
		<div class="cat cat{{$k}} {{$k == 0 ? 'active' : ''}}">
			@if($in->count() > 0)
			<h3>國內展會</h3>
			<div class="slider">
				<div class="swiper-container">
					<ul class="swiper-wrapper grid3 spacing20 no-shrink">
						@foreach($in as $v)
							<?php
								$img = \App\OtherFiles::where('position',$position)->where('cm_id',$v->id)->first();
							?>
							@if($img)
							<li class="swiper-slide swiper-slide-active">
								<div class="img">
									<a href="/marketing/prospect/{{$v->id}}"><img src="{{$img->fname}}" alt=""></a>
								</div>
								<div class="text">
									<h3><a href="/marketing/prospect/{{$v->id}}">{{$v->name}}</a></h3>
								</div>
							</li>
							@endif
						@endforeach
					</ul>
				</div>
				<div class="swiper-button-next black"></div>
				<div class="swiper-button-prev black"></div>
			</div>
			@endif
			@if($out->count() > 0)
			<h3>國外展會</h3>
			<div class="slider">
				<div class="swiper-container">
					<ul class="swiper-wrapper grid3 spacing20 no-shrink">
						@foreach($out as $v)
							<?php
								$img = \App\OtherFiles::where('position',$position)->where('cm_id',$v->id)->first();

							?>
							@if($img)
							<li class="swiper-slide swiper-slide-active">
								<div class="img">
									<a href="/marketing/prospect/{{$v->id}}"><img src="{{$img->fname}}" alt=""></a>
								</div>
								<div class="text">
									<h3><a href="/marketing/prospect/{{$v->id}}">{{$v->name}}</a></h3>
								</div>
							</li>
							@endif
						@endforeach
					</ul>
				</div>
				<div class="swiper-button-next black"></div>
				<div class="swiper-button-prev black"></div>
			</div>
			@endif
			
		</div>
		@endforeach	
	</div>
		<img src="{{\App\Cm::where('position','market_footer')->value('pic')}}" alt="">
</section>
@endif
@endsection
@section('javascript')
@include('popup')
@endsection