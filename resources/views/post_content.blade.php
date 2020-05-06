<?php
if(is_numeric($id)){
	$post = \App\Cm::where('id',$id)->first();
	if(!$post){
		session()->flash('sysmsg', '找不到文章資料');
		echo '<script>location.href="/post"</script>';
		exit;
	}
	\App\Cm::where('id',$id)->increment('hits');
	$account = \App\Members::where('id',$post->up_sn)->first() ;
}else{
	session()->flash('sysmsg', '找不到文章資料');
	echo '<script>location.href="/post"</script>';
	exit;
}
$collect_status = \App\MembersCollects::get_collect_status('post', 'collects', $id);
$tags = explode(',', $post->tags);
?>
@extends('main')
@section('header')
<meta property="og:url"           content="{{request()->url()}}" />
<meta property="og:type"          content="website" />
<meta property="og:title"         content="{{$post->name}}" />
<meta property="og:description"   content="{{mb_substr(strip_tags($post->cont),0,100)}}" />
@endsection
@section('content')
<style type="text/css">
.message{
	display: none;
}
.already{
	color: #ccc !important;
	cursor: default !important;	
}
.reply-btns{
	position: absolute;
	top: 0;
	right: -5px;
	display: flex;
}
.comments_btn{
	position: absolute;
	top: 0;
	right: 0;
	display: flex;
}
.comments_btn a{
	font-size: 12px;
	margin-left: 10px;
}
#rply .btn-edit-submit{
	display: none;
}
.spost textarea{
	display: none;
}
.postmsg{
	margin-top: 20px;
}
.postmsg~textarea{
	display: none;
	width: 74%!important;
}
.btn-cancel{
	background-color: #ffa3a3!important;
}
#rply .spost .btns{
	float: none;
}
pre { 
	white-space: pre-wrap; 
	white-space: -moz-pre-wrap; 
	white-space: -pre-wrap; 
	white-space: -o-pre-wrap; 
	word-wrap: break-word; 
} 
.margin-style{
	margin-top: 10px;
    margin-bottom: -15px;
}

</style>
<section class="hot">
	<div class="ttl-bar">
		<h2>討論版</h2>
		<!-- <div class="searchbar">
			<input type="search" placeholder="文章搜尋">
			<button class="btn-search">Search</button>
		</div> -->
	</div>
	<div class="breadcrumb">
		<a href="/">首頁</a> &gt; <a href="/post">討論版</a> &gt; <a href="/post/{{$post->id}}">{{$post->name}}</a>
	</div>
	<div class="content forum two-side clearfix">
		<div class="side-left active article bg-gray">
			<div class="post flex wrap">
				<div class="img">
					<a href="/member_info/{{$account->id}}"><img src="{{\App\Members::get_pic($account->id)}}" alt=""></a>
					<p>{{$account->name}}</p>
				</div>
				<div class="text">
					<h3 class="ttl"><a href="/post/{{$post->id}}">{{$post->name}}</a></h3>
					<p class="source"><span class="date">{{$post->created_at}}</span> <!-- <span class="time">上午10:00</span> --></p>
					<p>{!!$post->cont!!}</p>
					<?php
					$files = \App\OtherFiles::where('position','posts')->where('cm_id',$post->id)->get();
					?>
					<p class="margin-style">
						@if(count($files)>0)
						附件：
						<ul style="margin-top:15px;">
							
							@foreach($files as $rs)
							<li>
								<a href="/download/{{$rs->id}}">{{$rs->name}}</a> &nbsp;
							</li>
							@endforeach
						</ul>
						@endif
					</p>
					<p>
						@foreach($tags as $tag)
				  			@if($tag)
				  			<?php $tagrd = \App\Cm::where('position','tag')->where('name', $tag)->first();?>
							<span class="tag"><a href="javascript:;">#{{$tag}}</a></span>&nbsp;&nbsp;
							@endif
						@endforeach
					</p>
					<div class="pull-right">
						<div id="fb-root"></div>	
						<div class="fb-share-button" data-href="{{request()->url()}}" data-layout="button" data-size="large" data-mobile-iframe="false">
							<a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fdevelopers.facebook.com%2Fdocs%2Fplugins%2F&amp;src=sdkpreparse">分享</a>
						</div>
					</div>
				</div>
				<div class="btns abs">
					<a class="message-btn">留言</a>
					<a id="btn_add_collect" class="{{$collect_status?'already':''}}" data-targetid="{{$id}}">收藏發文</a>
					<a class="btn-add-msg">私訊</a>
					<!-- <a>追蹤作者</a>
					<a>我要檢舉</a>
					<a>我要下載</a>
					<a>聯絡作者</a>
					<a>聯絡版主</a> -->
				</div>
			</div>
			@if(session('mid'))
			<form id="messsage_form" action="/do/message" method="post">
				<div class="message flex">
					<?php
					$member = \App\Members::where('id',session('mid'))->first();
					?>
					<div class="img">
						<img src="{{\App\Members::get_pic($member->id)}}" alt="">
						<p>{{$member->name}}</p>
					</div>
					<div class="text">
						<p><textarea name="cont" id="" cols="105" rows="5"></textarea></p>
						<p><button type="submit">留言</button></p>
					</div>
				</div>
				<input type="hidden" name="_token" value="{{csrf_token()}}">
				<input type="hidden" name="up_sn" value="{{$id}}">	
			</form>
			@endif
			<!-- 留言 -->
			<ul class="reply" id="rply">
				<?php
				$reply = \App\Cm::where('position','comments')->where('up_sn',$id)->orderby('created_at','ASC')->get(); 
				?>
				@foreach($reply as $rd)
				<li class="flex mb20" id="item_row{{$rd->id}}">
					<?php
					$reply_info = \App\Members::where('id',$rd->objsn)->first();
					if(!$reply_info){
						\App\Cm::where('position','comments')->where('objsn',$rd->objsn)->delete(); 
						continue;
					} 
					?>
					<div class="img">
						<a href="/member_info/{{$reply_info->id}}"><img src="{{\App\Members::get_pic($reply_info->id)}}" alt="{{$rd->name}}"></a>
						<p>{{$reply_info->name}}</p>
						<div class="btns">
							<!-- <a class="btn-box s r">最佳解答</a> -->
							<a class="btn-box btn-reply s r" onclick="show_reply('{{$rd->id}}')">回覆</a>
						</div>
					</div>
					<!-- 回覆 -->
					<div class="text">
						<p class="source">
							<span class="date">{{substr($rd->created_at,0,10)}}</span> <span class="time">{{substr($rd->created_at,-8)}}</span>
						</p>
						<p class="postmsg {{$rd->objsn==session('mid')?'mymsg':''}}"><pre>{{$rd->cont}}</pre></p>
						<textarea class="myreply" id="edit_msg{{$rd->id}}">{!!$rd->cont!!}</textarea>
						<div class="btns btn-edit-submit">
							<a class="btn-submit btn-box s r" onclick="edit_msg('{{$rd->id}}')">送出</a>
							<a class="btn-cancel btn-box s r">取消</a>
						</div>
						@if($rd->objsn==session('mid'))
						<div class="comments_btn" >
							<a class="btn-edit btn-box s r">編輯</a>
							<a class="btn-box btn-reply s r" style="background-color:#ffa3a3" onclick="del_item('cms','{{$rd->id}}')">刪除</a>
						</div>
						@endif
						<?php
						$reply_message = \App\Cm::where('position','reply')->where('up_sn',$rd->id)->orderby('created_at','asc')->get();
						?>
						<div class="res">
							<ul>
								@if(!empty($reply_message))
									@foreach($reply_message as $rm)
									<?php
									$rdata = \App\Members::where('id',$rm->objsn)->first();
									if(!$rdata){
										\App\Cm::where('position','reply')->where('up_sn',$rd->id)->delete();
										continue ;
									}
									?>
									<li class="spost clearfix" id="item_row{{$rm->id}}">
										<p class="source">
											<span class="from"> {{$rdata->name}} 於</span>
											<span class="date"> {{$rm->created_at}} </span>
											<span>回覆</span>
										</p>
										<p class="postmsg {{$rm->objsn == session('mid')?'mymsg':''}}"><pre>{{$rm->cont}}</pre></p>
										<textarea id="edit_msg{{$rm->id}}">{!!$rm->cont!!}</textarea>
										<div class="btns btn-edit-submit">
											<a class="btn-submit btn-box s r" onclick="edit_msg('{{$rm->id}}')">送出</a>
											<a class="btn-cancel btn-box s r">取消</a>
										</div>
										@if($rm->objsn == session('mid'))
										<div class="reply-btns">
											<a class="btn-edit btn-box s r">編輯</a>
											<a class="btn-box btn-reply s r" style="background-color:#ffa3a3" onclick="del_item('cms','{{$rm->id}}')">刪除</a>
										</div>
										@endif
									</li>
									@endforeach
								@endif
							</ul>
							<div id="reply_{{$rd->id}}" style="display: none">
								<textarea name="reply_cont" id="reply_cont{{$rd->id}}"></textarea>
								<div class="btns">
									<!-- <a class="btn-box s r">最佳解答</a> -->
									<a class="btn-box btn-reply s r" onclick="reply('{{$rd->id}}')">送出</a>
								</div>
							</div>
							
						</div>
					</div>
				</li>
				@endforeach
			</ul>
		</div>
		<div class="side-right">
			<ul>
				@include('posts_boards')
				@include('posts_hot')
			</ul>
		</div>
	</div>
</section>
<div class="popup popup-add-msg" style="display: none">
	<div class="masklayer"></div>
	<div class="popup_window">
		<div class="popup_title">
			<h3>私訊給 {{$account->name}}</h3>
		</div>
		<div class="popup_content">
			<form action="/do/write_msg" id="write_msg_form" method="post">
				<div class="block">
					<h3 class="note">請輸入您要聯絡的內容：</h3>
					<ul class="custom-input">
						<li>
							<h4 class="ttl">*內容</h4>
							<textarea name="msg" cols="20" rows="10"></textarea>
						</li>
						<li>
							<div class="popup_pad_left"></div>
							<input type="hidden" name="to_email" value="{{$account->email}}">
							<input type="hidden" name="_token" value="{{csrf_token()}}">
							<input type="submit" name="goAddMsg" class="btn-box" value="送出" />
						</li>
					</ul>
				</div>
			</form>
		</div>
	</div>
</div>
@endsection
@section('javascript')
<script type="text/javascript">
	$(function(){
	//留言部分
	register_form('#messsage_form', function(res){
		load_page('/post/{{$id}}');
	});

	$('.message-btn').click(function(){
		var mid = '{{session('mid')}}';
		if(!mid){
			alert('請先登入會員，才可以使用本功能');
		}else{
			if($('.message').css('display')=='none'){
				$('.message').css({'display': 'flex'});
			}else{
				$('.message').hide();
			}
		}
	});
	$('#btn_add_collect').click(function(){
		if(!$(this).hasClass('already')){
			var targetid = $(this).data('targetid');
			get_data('/do/add_collect', {type:'post', action:'collects', targetid:targetid, move:'add'}, function(){
				$('#btn_add_collect').addClass('already');
			});
		}
	});
	$('.btn-edit').click(function(){
		let $this = $(this);
		let $parentLi = $this.parent().parent();
		
		$parentLi.find('.mymsg').hide();
		if($parentLi.hasClass('text')){
			$parentLi.find('.myreply').show().find('~.btns').css({'display': 'flex'});
		} else {

		$parentLi.find('.mymsg~textarea').show();
		$parentLi.find('.btn-edit-submit').css('display', 'flex');
		}
	})
	$('.btn-cancel').click(function(){
		let $this = $(this);
		let $parentLi = $this.parent().parent();
		$parentLi.find('.mymsg').show();
		$parentLi.find('.btn-edit-submit').hide();
		if($parentLi.hasClass('text')){
			$parentLi.find('.myreply').hide();
		} else {
			$parentLi.find('textarea').hide();
		}
	})

	//私訊部分
	register_form('#write_msg_form', function(){
		$('.popup-add-msg').fadeOut();
		load_page('/post/{{$id}}');
	});
	$('.btn-add-msg').click(function() {
		var mid = "{{session('mid')}}" ;
		if(!mid){
			alert('請先登入會員，才可以使用本功能');
		}else{
			$('.popup-add-msg').fadeIn();
		}
	}) 
	$('.masklayer').click(function(){
		$(this).parent().fadeOut();
	})

	(function(d, s, id) {
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) return;
			js = d.createElement(s); js.id = id;
			js.src = "//connect.facebook.net/zh_TW/sdk.js#xfbml=1&version=v2.10&appId=110989952909732";
			fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));
	})

	//留言回覆部分
	function reply(id){
		var mid = "{{session('mid')}}" ;
		if(!mid){
			alert('請先登入會員，才可以使用本功能');
		}else{
			var cont = $('#reply_cont'+id).val() ;
			if(cont==''){
				alert('回覆內容不可以空白');
				return false ; 
			} 
			get_data('/do/reply',{id:id,cont:cont},function(){
				load_page('/post/{{$id}}') ;
			})
		}
	}

	//編輯留言、回復
	function edit_msg(id){
		var cont = $('#edit_msg'+id).val() ;
		get_data('/do/edit_msg',{id:id,cont:cont},function(){
			load_page('/post/{{$id}}') ;
		})
	}

	//顯示回覆框
	function show_reply(id){
		var mid = "{{session('mid')}}" ;
		if(!mid){
			alert('請先登入會員，才可以使用本功能');
		}else{
			if($('#reply_'+id).hasClass('show')){
				$('#reply_'+id).removeClass('show').css('display','none');
			}else{
				$('#reply_'+id).addClass('show').show() ;
			}	
		}
	}

</script>
@endsection