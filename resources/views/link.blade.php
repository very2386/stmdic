<?php
$link_type = \App\Cm::get_link_type();
$data = [] ; 
foreach($link_type as $type){
	$data[$type] = \App\Cm::where('position','link')->where('type',$type)->where('mstatus','Y')->get();
}
?>
@extends('main')
@section('content')	
<section class="professional-inner bg-gray">
	<div class="ttl-bar">
		<h2>外站連結</h2>
	</div>
</section>
<section class="links" style="padding-top: 20px;">
    <ul class="grid3">
    	@foreach($link_type as $type)
        <li>
            <h3>{{$type}}</h3>
            <ul class="grid2">
                @foreach($data[$type] as $rd)
                <li><a href="{{$rd->link}}" target="_blank">{{$rd->name}}</a></li>
                @endforeach
            </ul>
        </li>
        @endforeach
    </ul>
</section>
@endsection
@section('javascript')
@endsection