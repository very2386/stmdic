<form id="searchform" action="/event" method="get">
	<div class="searchbar">
		<input type="text" name="q" value="{{request('q')}}" placeholder="活動搜尋">
		<button type="submit" class="btn-search">Search</button>
	</div>
</form>