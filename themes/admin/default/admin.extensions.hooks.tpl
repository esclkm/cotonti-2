<!-- BEGIN: MAIN -->
	{FILE "{PHP.cfg.themes_dir}/admin/default/warnings.tpl"}

	<h2>{PHP.L.Hooks} ({ADMIN_EXTENSIONS_CNT_HOOK}):</h2>
	<table class="table table-striped">
		<tr>
			<td class="coltop width40">{PHP.L.Hooks}</td>
			<td class="coltop width20">{PHP.L.Extension}</td>
			<td class="coltop width20">{PHP.L.Order}</td>
			<td class="coltop width20">{PHP.L.Active}</td>
		</tr>
<!-- BEGIN: HOOKS_ROW -->
		<tr>
			<td>{ADMIN_EXTENSIONS_HOOK}</td>
			<td>{ADMIN_EXTENSIONS_CODE}</td>
			<td class="centerall">{ADMIN_EXTENSIONS_ORDER}</td>
			<td class="centerall">{ADMIN_EXTENSIONS_ACTIVE}</td>
		</tr>
<!-- END: HOOKS_ROW -->
	</table>
<!-- END: MAIN -->