<!-- BEGIN: MAIN -->

<div class="container container-fluid">

	<!-- BEGIN: PAGE_ADMIN -->
	<div class="text-right">
		<a href="{PAGE_CAT|cot_url('page','m=add&c=$this')}" class="btn btn-success">{PHP.L.page_addtitle}</a>
		{PAGE_ADMIN_UNVALIDATE|cot_rc_modify('$this', 'class="btn btn-default"')}
		{PAGE_ADMIN_EDIT|cot_rc_modify('$this', 'class="btn btn-default"')}
		{PAGE_ADMIN_CLONE|cot_rc_modify('$this', 'class="btn btn-default"')}
		{PAGE_ADMIN_DELETE|cot_rc_modify('$this', 'class="btn btn-danger confirmLink"')}
	</div>
	<!-- END: PAGE_ADMIN -->

	<div class="page-header">
		{PAGE_CATPATH}
		<h1>{PAGE_SHORTTITLE}</h1>
	</div>


	<!-- IF {PAGE_DESC} -->
	<p class="small">{PAGE_DESC}</p>
	<!-- ENDIF -->


	<div class="row">
		<div class="col-md-8">
			<!-- IF {PAGE_TAGS_ROW_URL} -->
			<strong>{PHP.L.Tags}:</strong>
			<!-- BEGIN: PAGE_TAGS_ROW -->
			<a href="{PAGE_TAGS_ROW_URL}" title="{PAGE_TAGS_ROW_TAG}" rel="nofollow"  class="label label-default">{PAGE_TAGS_ROW_TAG}</a>
			<!-- END: PAGE_TAGS_ROW -->
			<!-- ENDIF -->			
		</div>
		<div class="col-md-4 text-right">
			<span class="glyphicon glyphicon glyphicon-time" title="{PHP.L.Date}"></span>&nbsp; {PAGE_DATE} 
			<!-- IF PHP.cot_extensions_active.comments -->
			<span class="glyphicon glyphicon-comment" title="{PHP.L.Comments}"></span>&nbsp; {PAGE_COMMENTS_COUNT}
			<!-- ENDIF -->
		</div>
	</div>

	<!-- BEGIN: PAGE_MULTI -->
	<h3 class="info">{PHP.L.Summary}:</h3>
	{PAGE_MULTI_TABTITLES}
	<p class="paging">{PAGE_MULTI_TABNAV}</p>

	<!-- END: PAGE_MULTI -->

	<div class="text-justify textbox">{PAGE_TEXT}</div>


	{PAGE_COMMENTS_DISPLAY}
</div>


<!-- END: MAIN -->