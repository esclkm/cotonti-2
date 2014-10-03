<!-- BEGIN: MAIN -->
<div class="container container-fluid">
	<div class="row">
		<div class="col-md-8">
			<!-- IF {INDEX_NEWS} -->
			<h2>{PHP.L.News}</h2>
			{INDEX_NEWS}
			<!-- ENDIF -->			
		</div>
		<div class="col-md-4">
			<!-- IF {INDEX_POLLS} -->
			<h3>{PHP.L.Polls}</h3>
			{INDEX_POLLS}
			<!-- ENDIF -->	
			<!-- IF {INDEX_TAG_CLOUD} -->
			<h3>{PHP.L.Tags}</h3>
			{INDEX_TAG_CLOUD}
			<!-- ENDIF -->
			<!-- IF {PHP.out.whosonline} -->
			<h3>{PHP.L.Online}</h3>
			<a href="{PHP|cot_url('plug','e=whosonline')}">{PHP.out.whosonline}</a>
			<!-- IF {PHP.out.whosonline_reg_list} -->:<br />{PHP.out.whosonline_reg_list}<!-- ENDIF -->
			<!-- ENDIF -->
		</div>
	</div>

	<!-- IF {PHP.cot_plugins_active.recentitems} -->

	<h2><a href="{PHP|cot_url('plug','e=recentitems')}">{PHP.L.recentitems_title}</a></h2>
	<!-- IF {RECENT_PAGES} -->
	<h3>{PHP.L.recentitems_pages}</h3>
	{RECENT_PAGES}
	<!-- ELSE -->
	<div class="warning">{PHP.L.recentitems_nonewpages}</div>
	<!-- ENDIF -->
	<!-- IF {RECENT_FORUMS} -->
	<h3>{PHP.L.recentitems_forums}</h3>
	{RECENT_FORUMS}
	<!-- ELSE -->
	<div class="warning">{PHP.L.recentitems_nonewposts}</div>
	<!-- ENDIF -->

	<!-- ENDIF -->
</div>
<!-- END: MAIN -->