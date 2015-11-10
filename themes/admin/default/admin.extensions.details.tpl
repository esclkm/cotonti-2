
	{include $PHP.cfg.themes_dir~"/admin/"~$PHP.cfg.admintheme~"/warnings.tpl"}

	<h2>{if $ADMIN_EXTENSIONS_ICO }
					<img src="{$ADMIN_EXTENSIONS_ICO}" />
					{else}
					{$PHP.R.admin_icon_extension}
					{/if}{$PHP.L.Extension} {$ADMIN_EXTENSIONS_NAME}:</h2>
	<div class="block">
		<table class="table table-striped info">
			<tr>
				<td class="width25">{$PHP.L.Code}:</td>
				<td class="width75">{$ADMIN_EXTENSIONS_CODE}</td>
			</tr>
			<tr>
				<td>{$PHP.L.Description}:</td>
				<td>{$ADMIN_EXTENSIONS_DESCRIPTION}</td>
			</tr>
			<tr>
				<td>{$PHP.L.Version}:</td>
				<td>
					{if $PHP.isinstalled AND $ADMIN_EXTENSIONS_VERSION_COMPARE > 0 }
					<span class="highlight_red">{$ADMIN_EXTENSIONS_VERSION_INSTALLED}</span> / <span class="highlight_green">{$ADMIN_EXTENSIONS_VERSION}</span>
					{else}
					{$ADMIN_EXTENSIONS_VERSION}
					{/if}
				</td>
			</tr>
			<tr>
				<td>{$PHP.L.Date}:</td>
				<td>{$ADMIN_EXTENSIONS_DATE}</td>
			</tr>
<!--//<tr>
	<td>{$PHP.L.adm_defauth_guests}:</td>
	<td>{$ADMIN_EXTENSIONS_ADMRIGHTS_AUTH_GUESTS} ({$ADMIN_EXTENSIONS_AUTH_GUESTS})</td>
</tr>
<tr>
	<td>{$PHP.L.adm_deflock_guests}:</td>
	<td>{$ADMIN_EXTENSIONS_ADMRIGHTS_LOCK_GUESTS} ({$ADMIN_EXTENSIONS_LOCK_GUESTS})</td>
</tr>
<tr>
	<td>{$PHP.L.adm_defauth_members}:</td>
	<td>{$ADMIN_EXTENSIONS_ADMRIGHTS_AUTH_MEMBERS} ({$ADMIN_EXTENSIONS_AUTH_MEMBERS})</td>
</tr>
<tr>
	<td>{$PHP.L.adm_deflock_members}:</td>
	<td>{$ADMIN_EXTENSIONS_ADMRIGHTS_LOCK_MEMBERS} ({$ADMIN_EXTENSIONS_LOCK_MEMBERS})</td>
</tr>//-->
			<tr>
				<td>{$PHP.L.Author}:</td>
				<td>{$ADMIN_EXTENSIONS_AUTHOR}</td>
			</tr>
			<tr>
				<td>{$PHP.L.Copyright}:</td>
				<td>{$ADMIN_EXTENSIONS_COPYRIGHT}</td>
			</tr>
			<tr>
				<td>{$PHP.L.Notes}:</td>
				<td>{$ADMIN_EXTENSIONS_NOTES}</td>
			</tr>
			{foreach \$1 as $row}
			<tr>
				<td>{$ADMIN_EXTENSIONS_DEPENDENCIES_TITLE}:</td>
				<td>
					<ul>
					{foreach \$1 as $row}
						<li>
							<a href="{$ADMIN_EXTENSIONS_DEPENDENCIES_ROW_URL}" class="{$ADMIN_EXTENSIONS_DEPENDENCIES_ROW_CLASS}">{$ADMIN_EXTENSIONS_DEPENDENCIES_ROW_NAME}</a>
						</li>
					{/foreach}
					</ul>
				</td>
			</tr>
			{/foreach}
		</table>
	</div>
	{if $PHP.isinstalled AND $PHP.exists }
	<div class="block">

		<h3>{$PHP.L.Action}:</h3>
		<div class="button-toolbar">
		{if $ADMIN_EXTENSIONS_JUMPTO_URL }
		<a title="{$PHP.L.Open}" href="{$ADMIN_EXTENSIONS_JUMPTO_URL}" class="button special large">{$PHP.L.Open}</a>
		{/if}
		{if $ADMIN_EXTENSIONS_JUMPTO_URL_TOOLS }
		<a title="{$PHP.L.Administration}" href="{$ADMIN_EXTENSIONS_JUMPTO_URL_TOOLS}" class="button special large">{$PHP.L.Administration}</a>
		{/if}
		{if $ADMIN_EXTENSIONS_TOTALCONFIG > 0 }
		<a title="{$PHP.L.Configuration}" href="{$ADMIN_EXTENSIONS_CONFIG_URL}" class="button large">{$PHP.L.Configuration} ({$ADMIN_EXTENSIONS_TOTALCONFIG})</a>
		{/if}
		<a title="{$PHP.L.Rights}" href="{$ADMIN_EXTENSIONS_RIGHTS}" class="button large">{$PHP.L.short_rights}</a>
		{if $ADMIN_EXTENSIONS_JUMPTO_URL_STRUCT }
		<a title="{$PHP.L.Structure}" href="{$ADMIN_EXTENSIONS_JUMPTO_URL_STRUCT}" class="button large">{$PHP.L.Structure}</a>
		{/if}

			</div>
	</div>
{/if}

	<div class="block">
		<h3>{$PHP.L.Options}:</h3>
		<div class="button-toolbar">
{if !$PHP.isinstalled AND $PHP.dependencies_satisfied }

					<a title="{$PHP.L.adm_opt_install_explain}" href="{$ADMIN_EXTENSIONS_INSTALL_URL}" class="ajax button special large">{$PHP.L.adm_opt_install}</a>
{/if}
{if $PHP.isinstalled }
			{if $PHP.exists }

					<a title="{$PHP.L.adm_opt_install_explain}" href="{$ADMIN_EXTENSIONS_UPDATE_URL}" class="ajax button special large">{$PHP.L.adm_opt_update}</a>
			{/if}
					<a title="{$PHP.L.adm_opt_uninstall_explain}" href="{$ADMIN_EXTENSIONS_UNINSTALL_URL}" class="ajax button large">{$PHP.L.adm_opt_uninstall}</a>
					<a title="{$PHP.L.adm_opt_pauseall_explain}" href="{$ADMIN_EXTENSIONS_PAUSE_URL}" class="ajax button large">{$PHP.L.adm_opt_pauseall}</a>

			{if $PHP.exists }

					<a title="{$PHP.L.adm_opt_unpauseall_explain}" href="{$ADMIN_EXTENSIONS_UNPAUSE_URL}" class="ajax button large">{$PHP.L.adm_opt_unpauseall}</a>

			{/if}
{/if}
</div>
	</div>
	<div class="block">
		<h3>{$PHP.L.Parts}:</h3>
		<table class="table table-striped">
			<tr>
				<td class="coltop width5">#</td>
				<td class="coltop width15">{$PHP.L.Part}</td>
				<td class="coltop width20">{$PHP.L.File}</td>
				<td class="coltop width20">{$PHP.L.Hooks}</td>
				<td class="coltop width10">{$PHP.L.Order}</td>
				<td class="coltop width15">{$PHP.L.Status}</td>
				<td class="coltop width15">{$PHP.L.Action}</td>
			</tr>
{foreach \$1 as $row}
			<tr>
				<td colspan="3">{$ADMIN_EXTENSIONS_DETAILS_ROW_X}</td>
				<td colspan="4">{$ADMIN_EXTENSIONS_DETAILS_ROW_ERROR}</td>
			</tr>
{/foreach}
{foreach \$1 as $row}
			<tr>
				<td class="centerall">{$ADMIN_EXTENSIONS_DETAILS_ROW_I_1}</td>
				<td class="centerall">{$ADMIN_EXTENSIONS_DETAILS_ROW_PART}</td>
				<td class="centerall">{$ADMIN_EXTENSIONS_DETAILS_ROW_FILE}</td>
				<td class="centerall">{$ADMIN_EXTENSIONS_DETAILS_ROW_HOOKS}</td>
				<td class="centerall">{$ADMIN_EXTENSIONS_DETAILS_ROW_ORDER}</td>
				<td class="centerall">{$ADMIN_EXTENSIONS_DETAILS_ROW_STATUS}</td>
				<td class="centerall">
{foreach \$1 as $row}
					&ndash;
{/foreach}
{foreach \$1 as $row}
					<a href="{$ADMIN_EXTENSIONS_DETAILS_ROW_PAUSEPART_URL}" class="ajax button">{$PHP.L.adm_opt_pause}</a>
{/foreach}
{foreach \$1 as $row}
					<a href="{$ADMIN_EXTENSIONS_DETAILS_ROW_UNPAUSEPART_URL}" class="ajax button">{$PHP.L.adm_opt_unpause}</a>
{/foreach}
				</td>
			</tr>
{/foreach}
		</table>
	</div>
	<div class="block">
		<h3>{$PHP.L.Tags}:</h3>
		<table class="table table-striped">
			<tr>
				<td class="coltop width5">#</td>
				<td class="coltop width25">{$PHP.L.Part}</td>
				<td class="coltop width70">{$PHP.L.Files} / {$PHP.L.Tags}</td>
			</tr>
{foreach \$1 as $row}
			<tr>
				<td class="centerall">{$ADMIN_EXTENSIONS_DETAILS_ROW_I_1}</td>
				<td class="centerall">{$ADMIN_EXTENSIONS_DETAILS_ROW_PART}</td>
				<td class="centerall">{$PHP.L.None}</td>
			</tr>
{/foreach}
{foreach \$1 as $row}
			<tr>
				<td class="centerall">{$ADMIN_EXTENSIONS_DETAILS_ROW_I_1}</td>
				<td class="centerall">{$ADMIN_EXTENSIONS_DETAILS_ROW_PART}</td>
				<td>{$ADMIN_EXTENSIONS_DETAILS_ROW_LISTTAGS}</td>
			</tr>
{/foreach}
		</table>
	</div>

