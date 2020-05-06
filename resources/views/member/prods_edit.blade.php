<?php
if(!session('mid')){
	echo '<script>location.href="/"</script>';
	exit();
} 
if($id){
	$prods = \App\Cm::where('id',$id)->first();
	if($prods->specs){
		$tags = explode(',',$prods->specs) ; 
	}else{
		$tags = [] ;
	}
	if($prods->tags){
		$ptype = explode(',',$prods->tags) ; 
	}else{
		$ptype = [] ; 
	}
}else{
	$prods = \App\Cm::new_obj();
	$ptype = [] ; 
	$tags = [] ;
}
$prods_type = \App\Cm::get_prods_type();
$up_sn = \App\Cm::where('position','company')->where('up_sn',session('mid'))->value('id') ; 
?>
@extends('main')
@section('content')
<section class="member member-edit">
	@include('member.menu')
	<div class="breadcrumb">
		<a href="/member/index">會員專區</a> &gt; <a class="name" href="">上市產品</a>
	</div>
	<div class="content grid-intro form">
		<form id="upload_prods_form" action="/do/upload_prods" method="post" enctype="multipart/form-data">
			<div class="">
				<div class="prods">
					<div class="block upload company multiadd" data-index="0">
						<h3 class="ttl">上市產品</h3>
						<div class="compinfo">
							<div style="clear:both;"></div>
						</div>
						<ul class="custom-input">
							<li>
								<div class="title">
									<h4 class="ttl">名稱</h4>
								</div>
								<div class="prop">
									<input type="text" name="name[]" value="{{$prods->name}}">
								</div>
							</li>
							<li>
								<h4 class="ttl">分類</h4>
								<ul class="custom-radio sub flex wrap">
									@foreach($prods_type as $k => $type)
									<li>
										<input name="prods[0][]" id="prods{{$k}}" type="checkbox" value="{{$type}}" {{in_array($type, $ptype)?'checked':''}}>
										<label for="prods{{$k}}" >{{$type}}</label>
									</li>
									@endforeach	
								</ul>
							</li>
							<li>
								<div class="title">
									<h4 class="ttl">說明</h4>
								</div>
								<div class="prop">
									<input type="text" name="brief[]" value="{{$prods->brief}}">
								</div>
							</li>
							<li>
								<div class="title">
									<h4 class="ttl">圖片</h4>
								</div>
								<div class="prop">
									<ul>
										<li>
											<input type="file" name="pic[]">
										</li>
									</ul>
								</div>
								<p>* 檔案格式：JPG、PNG</p>
							</li>
							<li>
								<div class="title">
									<h4 class="ttl">影片</h4>
								</div>
								<div class="prop">
									<input type="text" name="link[]" placeholder="Youtube連結" value="{{$prods->link}}">
								</div>
							</li>
							<li class="tags">
								<div class="title">
									<h4 class="ttl">標籤</h4>
								</div>
								<div class="prop">
									<ul id="myTags-0">
										@foreach($tags as $tag)
											<li>{{$tag}}</li>
										@endforeach
									</ul>
								</div>
							</li>
							<li class="sep"></li>
						</ul>
						@if($id=='')
						<button type="button" class="btn-add-sp">+</button>
						@endif
					</div>
				</div>
			</div>
			<div class="btn-confirm">
				<a href="/member/prods" class="btn-cancel">取消</a>
				<a onclick="edit_product()" class="btn-confirm">送出</a>
			</div>
			<input type="hidden" name="_token" value="{{csrf_token()}}">
			<input type="hidden" name="position" value="compinfo" >
			<input type="hidden" name="type" value="上市產品" >
			<input type="hidden" name="up_sn" value="{{$up_sn}}" >
			<input type="hidden" name="id" value="{{$id}}" >
		</form>
	</div>
</section>
@endsection
@section('javascript')
<script type="text/javascript">
	$(function(){
		$("#myTags-0").tagit({
			fieldName:"tags[0][]",
		});
	});

	function edit_product(){
		submit_form('#upload_prods_form', function(res){
			load_page('/member/prods');
		});
		
	}
</script>
@endsection
