<!-- BEGIN: MAIN -->
<div class="container container-fluid">
	<!-- IF {PHP.usr.auth_write} -->
	<div class="text-right">
		{LIST_SUBMITNEWPAGE|cot_rc_modify('$this', 'class="btn btn-success"')}
	</div>	
	<!-- ENDIF -->			
	<div class="page-header">
		{LIST_CATPATH}
		<h1>{LIST_CATTITLE}</h1>
	</div>	
	<!-- IF {LIST_ROWCAT_URL} -->
	<div class="row">

		<!-- BEGIN: LIST_ROWCAT -->
		<div class="col-md-4">
			<h4><a href="{LIST_ROWCAT_URL}" title="{LIST_ROWCAT_TITLE}">{LIST_ROWCAT_TITLE}</a> ({LIST_ROWCAT_COUNT})</h4>
			<!-- IF {LIST_ROWCAT_DESC} -->
			<p class="small">{LIST_ROWCAT_DESC}</p>
			<!-- ENDIF -->
		</div>
		<!-- IF {LIST_ROWCAT_NUM} % 3 == 0 -->
		<div class="clearfix"></div>
		<!-- ENDIF -->		
		<!-- END: LIST_ROWCAT -->
	</div>
	<div class="clearfix"></div>
	<hr />
	<!-- ENDIF -->
	<!-- BEGIN: LIST_ROW -->
	<h3>
		<a href="{LIST_ROW_URL}">{LIST_ROW_SHORTTITLE}</a>
		<!-- IF {PHP.usr.isadmin} -->
		<a class="small pull-right" href="{LIST_ROW_ADMIN_EDIT_URL}" title="{PHP.L.Edit}">
			<span class="glyphicon glyphicon-edit"></span>
		</a>
		<!-- ENDIF -->
	</h3>
	<!-- IF {LIST_ROW_DESC} --><div><small>{LIST_ROW_DESC}</small></div><!-- ENDIF -->
	
	
    <div class="textbox text-justify">
		{LIST_ROW_TEXT_CUT}
		<!-- IF {LIST_ROW_TEXT_IS_CUT} -->{LIST_ROW_MORE}<!-- ENDIF -->
	</div>


	<div class="row">
		<div class="col-md-8">
<!-- IF {LIST_ROW_TAGS_ROW_TAG} -->
			<strong>{PHP.L.Tags}:</strong>
	<!-- BEGIN: LIST_ROW_TAGS_ROW -->
			<a href="{LIST_ROW_TAGS_ROW_URL}" rel="nofollow"  class="label label-default">{LIST_ROW_TAGS_ROW_TAG}</a> 
	<!-- END: LIST_ROW_TAGS_ROW -->
<!-- ENDIF -->			
		</div>
		<div class="col-md-4 text-right">
			<span class="glyphicon glyphicon glyphicon-time" title="{PHP.L.Date}"></span>&nbsp; {LIST_ROW_DATE} 
			<!-- IF PHP.cot_extensions_active.comments -->
			<span class="glyphicon glyphicon-comment" title="{PHP.L.Comments}"></span>&nbsp; {LIST_ROW_COMMENTS_COUNT}
			<!-- ENDIF -->
		</div>
	</div>
	<!-- END: LIST_ROW -->

	<!-- IF {LIST_TOP_PAGINATION} -->
	<div class="text-center">
		<ul class="pagination">{LIST_TOP_PAGEPREV}{LIST_TOP_PAGINATION}{LIST_TOP_PAGENEXT}</ul>
	</div>
	<!-- ENDIF -->	

	<!-- IF {LIST_TAG_CLOUD} -->
	<h3>{PHP.L.Tags}</h3>
	{LIST_TAG_CLOUD}
	<!-- ENDIF -->

</div>

<!-- END: MAIN -->