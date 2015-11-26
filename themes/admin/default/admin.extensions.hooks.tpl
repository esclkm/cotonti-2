
{include $PHP.cfg.themes_dir~"/admin/"~$PHP.cfg.admintheme~"/warnings.tpl"}

	<h1>{$PHP.L.Hooks} ({$ADMIN_EXT_CNT_HOOK}):</h1>
	<table class="table table-striped">
		<tr>
			<td class="coltop width40">{$PHP.L.Hooks}</td>
			<td class="coltop width20">{$PHP.L.Extension}</td>
			<td class="coltop width20">{$PHP.L.Order}</td>
			<td class="coltop width20">{$PHP.L.Active}</td>
		</tr>
{foreach $ADMIN_EXT_HOOKS as $HOOK}
		<tr>
			<td>{$HOOK.HOOK}</td>
			<td>{$HOOK.CODE}</td>
			<td class="centerall">{$HOOK.ORDER}</td>
			<td class="centerall">{$HOOK.ACTIVE}</td>
		</tr>
{/foreach}
	</table>
