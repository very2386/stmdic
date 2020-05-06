<?php
$wh = ['position'=>'comp_resume','mstatus'=>'Y'] ;
if(isset($comp)){
	$jobs = \App\Cm::where($wh)->where('up_sn',$comp->id)->inRandomOrder()->limit(5)->get();
}elseif(isset($id)){
	$jobs = \App\Cm::where($wh)->where('up_sn',$id)->inRandomOrder()->limit(5)->get();
}else{
	$jobs = \App\Cm::where($wh)->inRandomOrder()->limit(5)->get();
}
?>
<div class="side-right right-st1">
	<ul class="job" style="padding-left: 10px;">
		<li>
			<h3 class="ttl">徵才訊息</h3>
			@foreach($jobs as $job)
				<?php
				$comp_info = \App\Cm::where('id',$job->up_sn)->first();
				$conts = json_decode($job->cont) ;
				?>
				<div class="block">
					<h4>
						{{$conts->job_title}}
					</h4>
					<p>{{isset($comp_info->name)?$comp_info->name:''}}</p>
					@if(isset($conts->job_location))
						<p>工作地點：{{$conts->job_location}}</p>
					@endif
					@if(isset($conts->job_salary))
						<p>工作待遇：{{$conts->job_salary}}</p>
					@endif
					@if(isset($conts->job_exp))
						<p>工作經驗：{{$conts->job_exp}}</p>
					@endif
					<a class="btn-hire" onclick="get_job('{{$job->id}}')">我要應徵</a>
				</div>
			@endforeach
		</li>
	</ul>
</div>