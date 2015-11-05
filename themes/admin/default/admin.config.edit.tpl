<!-- BEGIN: MAIN -->

		{FILE "{PHP.cfg.themes_dir}/admin/default/warnings.tpl"}
		<div class="block">
			{ADMIN_CONFIG_EDIT_CUSTOM}
			<form name="saveconfig" id="saveconfig" action="{ADMIN_CONFIG_FORM_URL}" method="post" class="ajax">
<!-- BEGIN: ADMIN_CONFIG_ROW -->
<!-- BEGIN: ADMIN_CONFIG_FIELDSET_BEGIN -->
	<h3>{ADMIN_CONFIG_FIELDSET_TITLE}</h3>
<!-- END: ADMIN_CONFIG_FIELDSET_BEGIN -->
<!-- BEGIN: ADMIN_CONFIG_ROW_OPTION -->
	<div class="row">
		<div class="col-sm-4">{ADMIN_CONFIG_ROW_CONFIG_TITLE}:</div>
		<div class="col-sm-7">
			{ADMIN_CONFIG_ROW_CONFIG}
			<div class="adminconfigmore">{ADMIN_CONFIG_ROW_CONFIG_MORE}</div>
		</div>
		<div class="col-sm-1 text-right hidden-xs">
			<a href="{ADMIN_CONFIG_ROW_CONFIG_MORE_URL}" class="ajax1 btn btn-link" title="{PHP.L.Reset}">
				<span class="glyphicon glyphicon-refresh" aria-hidden="true"></span>
			</a>
		</div>
	</div>
	<hr/>
<!-- END: ADMIN_CONFIG_ROW_OPTION -->
<!-- END: ADMIN_CONFIG_ROW -->
				<div class="text-right">
					<button type="submit" class="btn btn-success">{PHP.L.Update}</button>
				</div>
			</form>

		</div>
<!-- END: MAIN -->