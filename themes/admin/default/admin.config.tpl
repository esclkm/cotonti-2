<!-- BEGIN: MAIN -->
{FILE "{PHP.cfg.themes_dir}/admin/default/warnings.tpl"}


<!-- BEGIN: ADMIN_CONFIG_COL -->
<h3 class="clear">{ADMIN_CONFIG_COL_CAPTION}:</h3>
<div class="row">
<!-- BEGIN: ADMIN_CONFIG_ROW -->
	<a href="{ADMIN_CONFIG_ROW_URL}" class="ajax1 thumbicons col-lg-2 col-md-3 col-sm-6">
		<!-- IF {ADMIN_CONFIG_ROW_ICO} -->
		<img src="{ADMIN_CONFIG_ROW_ICO}"/>
		<!-- ELSE -->
		{PHP.R.admin_icon_extension}
		<!-- ENDIF -->
		{ADMIN_CONFIG_ROW_NAME}
	</a>
<!-- END: ADMIN_CONFIG_ROW -->
</div>
<!-- END: ADMIN_CONFIG_COL -->

<!-- END: MAIN -->