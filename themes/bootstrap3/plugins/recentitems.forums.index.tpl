<!-- BEGIN: MAIN -->
<!-- BEGIN: TOPICS_ROW -->
<div class="row">
	<div class="col-md-5">
		<strong><a href="{FORUM_ROW_URL}">{FORUM_ROW_TITLE}</a></strong>
		<p class="small"><span class="glyphicon glyphicon-folder-open" title="{PHP.L.Filedunder}"></span>&nbsp; {FORUM_ROW_PATH_SHORT}</p>
	</div>
	
	<div class="col-md-2">
		{FORUM_ROW_UPDATED}
	</div>
	<div class="col-md-2">
		<span class="glyphicon glyphicon glyphicon-user" title="{PHP.L.Posts}"></span>&nbsp;  {FORUM_ROW_LASTPOSTER}
	</div>
	<div class="col-md-2">
		<div><span class="glyphicon glyphicon glyphicon-time" title="{PHP.L.Date}"></span>&nbsp; {FORUM_ROW_TIMEAGO} {PHP.L.Ago}</div>
	</div>	
	<div class="col-md-1 text-right">
		<div><span class="glyphicon glyphicon glyphicon-comment" title="{PHP.L.Posts}"></span>&nbsp; {FORUM_ROW_POSTCOUNT}</div>
	</div>
</div>
<div class="clearfix"></div>


<!-- END: TOPICS_ROW -->
<!-- BEGIN: NO_TOPICS_FOUND -->
<div class="alert alert-warning">{PHP.L.recentitems_nonewposts}</div>

<!-- END: NO_TOPICS_FOUND -->

<!-- END: MAIN -->