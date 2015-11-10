{include $PHP.cfg.themes_dir~"/admin/"~$PHP.cfg.admintheme~"/warnings.tpl"}

<div class="block">
	{$ADMIN_CONFIG_EDIT_CUSTOM}
	<form name="saveconfig" id="saveconfig" action="{$ADMIN_CONFIG_FORM_URL}" method="post" class="ajax">
		{foreach $ADMIN_CONFIG_ROWS as $ROW}
		{if $ROW.SEPARATOR}
		<h3>{$ROW.TITLE}</h3>
		{else}
		<div class="row">
			<div class="col-sm-4">{$ROW.TITLE}:</div>
			<div class="col-sm-7">
				{$ROW.CONFIG}
				<div class="adminconfigmore">{$ROW.MORE}</div>
			</div>
			<div class="col-sm-1 text-right hidden-xs">
				<a href="{$ROW.RESET}" class="ajax1 btn btn-link" title="{$PHP.L.Reset}">
					<span class="glyphicon glyphicon-refresh" aria-hidden="true"></span>
				</a>
			</div>
		</div>
		<hr/>
		{/if}
		{/foreach}
		<div class="text-right">
			<button type="submit" class="btn btn-success">{$PHP.L.Update}</button>
		</div>
	</form>

</div>
