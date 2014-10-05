<!-- BEGIN: MAIN -->

<!-- BEGIN: PAGE_ROW -->
<div class="row">
	<div class="col-md-2">
		<div><span class="glyphicon glyphicon glyphicon-time" title="{PHP.L.Date}"></span>&nbsp; {PAGE_ROW_DATE} </div>
		<div><span class="glyphicon glyphicon-folder-open" title="{PHP.L.Filedunder}"></span>&nbsp; {PAGE_ROW_CATPATH_SHORT}</div>	
	</div>
	<div class="col-md-10">
		<strong><a href="{PAGE_ROW_URL}">{PAGE_ROW_SHORTTITLE} ({PAGE_ROW_COUNT})</a></strong>
		<!-- IF {PAGE_ROW_DESC} --><p class="small">{PAGE_ROW_DESC}</p><!-- ENDIF -->			
	</div>
</div>
<div class="clearfix"></div>
<!-- END: PAGE_ROW -->
<!-- BEGIN: NO_PAGES_FOUND -->
<div class="alert alert-warning">{PHP.L.recentitems_nonewpages}</div>
<!-- END: NO_PAGES_FOUND -->
<!-- END: MAIN -->