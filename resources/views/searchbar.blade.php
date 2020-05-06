<form id="searchform" action="/search" method="get">
	<div class="searchbar">
		<input type="text" name="q" value="{{request('q')}}" placeholder="新聞搜尋">
		<div class="custom-select" target="#search-target">
			<h5 class="ttl">{{request('c')?request('c'):'全部'}}</h5>
			<ul class="opt">
				<li>全部</li>
				<li>標題</li>
				<li>內文</li>
			</ul>
		</div>
		<input type="hidden" name="c" id="search-target" value="{{request('c')?request('c'):'全部'}}">
		<button type="submit" class="btn-search">Search</button>
	</div>
</form>