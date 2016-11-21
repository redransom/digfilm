<div class="search-container">
	<form id="searchbox" action="{{route('search-results')}}" method="post">
        <label for="search_text" style="display:none">Search Text</label>
		<input type="hidden" name="_token" value="{{ csrf_token() }}" />
		<input id="search" type="text" placeholder="Search" name="search_text" />
		<input id="submit" type="submit" value="&#xf04b;" />
	</form>
</div>