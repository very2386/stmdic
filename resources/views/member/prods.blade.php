<?php 
if(!session('mid')){
	echo '<script>location.href="/"</script>';
	exit();
} 
$comp_id = \App\Cm::where('position','company')->where('up_sn',session('mid'))->value('id') ; 
$prods = \App\Cm::where('position','compinfo')->where('type','上市產品')->where('up_sn',$comp_id)->get() ; 
?>
@extends('main')
@section('content')
<section class="member">
	@include('member.menu')
	<div class="breadcrumb">
		<a href="/member/index">會員專區</a> &gt; <a class="name" href="/member/prods">上市產品管理</a>
	</div>
	<div class="content grid-intro form">
		<div class="">
			<div class="prods">
				<table class="table-prods">
					<tr>
						<th class="chkbox custom-radio">
							<input name="clickAll" id="clickAll" type="checkbox"> <label for="clickAll"></label>
						</th>
						<th class="manage">圖片</th>
						<th class="blank">類別</th>
						<th class="blank">名稱</th>
						<th class="blank">標籤</th>
						<th><a class="flex v-center center" href="/member/prods_edit"><span class="icon"><img src="/img/icon/add.png" alt=""></span>新增商品</a></th>
						<th><a class="flex v-center center btn-delete" href="javascript:;"><span class="icon"><img src="/img/icon/delete_green.png" alt=""></span>刪除</a></th>
					</tr>
					@foreach($prods as $rd)
						<?php
						if($rd->specs)	$tags = explode(',', $rd->specs) ; 
						else $tags = [] ;
						?>
						<tr id="item_row{{$rd->id}}">
							<td class="chkbox custom-radio">
								<input name="prods[]" id="prod{{$rd->id}}" type="checkbox" value="{{$rd->id}}">
								<label for="prod{{$rd->id}}"></label>
							</td>
							<td class=""><img src="{{\App\Cm::get_pic($rd->id)}}" alt=""></td>
							<td class="depart">{{$rd->tags}}</td>
							<td class="name">{{$rd->name}}</td>
							<td class="tags">
								@if(count($tags)>0)
									@foreach($tags as $tag)
										#{{$tag}}&nbsp;
									@endforeach
								@endif
							</td>
							<td class="blank">&nbsp;</td>
							<td class="edit"><a class="icon" href="/member/prods_edit/{{$rd->id}}"><img src="/img/icon/edit.png" alt=""></a></td>
						</tr>
					@endforeach
				</table>
			</div>
		</div>
	</div>
</section>
@endsection
@section('javascript')
<script type="text/javascript">
	$(function(){
		//全選功能
		$("#clickAll").click(function() {
		   	if($("#clickAll").prop("checked")) {
		    	$("input[name='prods[]']").each(function() {
		         	$(this).prop("checked", true);
		    	});
		   	} else {
		     	$("input[name='prods[]']").each(function() {
		         	$(this).prop("checked", false);
		     	});           
		   	}
		});
		//刪除功能
		$('.btn-delete').click(function(){
			var car_id = [] ;
			$("input[name='prods[]']").each(function() {
		        if($(this).attr('checked')){
		        	car_id.push($(this).val()) ; 
		        }
		    });
		    if(car_id.length==1) del_item('cms',car_id[0]) ; 
		    else del_item_all('cms',car_id) ; 
		})
	});
</script>
@endsection
