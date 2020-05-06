<div class="flex {{$sort_class}} v-center">
	<h4>排序：</h4>
	<div id="type-select" class="custom-select small bordered" target="#post-sort-type">
		<h5 class="ttl">{{$cur_sort}}</h5>
		<ul class="opt">
			<li data-sort="new">最新</li>
			<li data-sort="hot">熱門</li>
		</ul>
		<input type="hidden" id="post-sort-type" value="">
		<input type="hidden" id="current_url" value="{{request()->url()}}">
	</div>
</div>