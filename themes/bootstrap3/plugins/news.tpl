<!-- BEGIN: NEWS -->

<!-- BEGIN: PAGE_ROW -->

	<h3>
		<a href="{PAGE_ROW_URL}">{PAGE_ROW_SHORTTITLE}</a>
		<!-- IF {PHP.usr.isadmin} -->
		<a class="small pull-right" href="{PAGE_ROW_ADMIN_EDIT_URL}" title="{PHP.L.Edit}">
			<span class="glyphicon glyphicon-edit"></span>
		</a>
		<!-- ENDIF -->
	</h3>
	<!-- IF {PAGE_ROW_DESC} --><div><small>{PAGE_ROW_DESC}</small></div><!-- ENDIF -->
	
	
    <div class="textbox text-justify">
		{PAGE_ROW_TEXT_CUT}
		<!-- IF {PAGE_ROW_TEXT_IS_CUT} -->{PAGE_ROW_MORE}<!-- ENDIF -->
	</div>


	<div class="row">
		<div class="col-md-6">
<!-- BEGIN: PAGE_TAGS -->
			<strong>{PHP.L.Tags}:</strong>
<!-- BEGIN: PAGE_TAGS_ROW -->
			<a href="{PAGE_TAGS_ROW_URL}" rel="nofollow"  class="label label-default">{PAGE_TAGS_ROW_TAG}</a> 
<!-- END: PAGE_TAGS_ROW -->
<!-- END: PAGE_TAGS -->			
		</div>
		<div class="col-md-6 text-right">
			<span class="glyphicon glyphicon-folder-open" title="{PHP.L.Filedunder}"></span>&nbsp; {PAGE_ROW_CATPATH_SHORT}
			<span class="glyphicon glyphicon glyphicon-time" title="{PHP.L.Date}"></span>&nbsp; {PAGE_ROW_DATE} 
			<!-- IF PHP.cot_extensions_active.comments -->
			<span class="glyphicon glyphicon-comment" title="{PHP.L.Comments}"></span>&nbsp; {PAGE_ROW_COMMENTS_COUNT}
			<!-- ENDIF -->
		</div>
	</div>

<!-- END: PAGE_ROW -->

	<p class="paging">{PAGE_PAGEPREV}{PAGE_PAGENAV}{PAGE_PAGENEXT}</p>

<!-- END: NEWS -->