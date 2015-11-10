
	{include $PHP.cfg.themes_dir~"/admin/"~$PHP.cfg.admintheme~"/warnings.tpl"}

<div class="block button-toolbar">
	<a class="button large {if $ADMIN_EXTENSIONS_SORT_ALP_SEL }special{/if}" href="{$ADMIN_EXTENSIONS_SORT_ALP_URL}">{$PHP.L.adm_sort_alphabet}</a>
	<a class="button large {if $ADMIN_EXTENSIONS_SORT_CAT_SEL }special{/if}" href="{$ADMIN_EXTENSIONS_SORT_CAT_URL}">{$PHP.L.adm_sort_category}</a>
	<a class="button large {if $ADMIN_EXTENSIONS_ONLY_INSTALLED_SEL }special" href="$ADMIN_EXTENSIONS_ONLY_INSTALLED_URL"<!-- ELSE-->" href="{$ADMIN_EXTENSIONS_ONLY_INSTALLED_URL}"{/if}>{$PHP.L.adm_only_installed}</a>
	<a href="{$ADMIN_EXTENSIONS_HOOKS_URL}" class="button large">{$PHP.L.Hooks}</a>
</div>

{foreach \$1 as $row}
	<h2>{$PHP.L.Extension} ({$ADMIN_EXTENSIONS_CNT_EXTP})</h2>
	<div class="block">
		<table class="table table-striped">
			<tr>
				<td class="coltop width5">&nbsp;</td>
				<td class="coltop width25">{$PHP.L.Name} {$PHP.L.adm_clicktoedit}</td>
				<td class="coltop width15">{$PHP.L.Code}</td>
				<td class="coltop width9">{$PHP.L.Version}</td>
				<td class="coltop width4">{$PHP.L.Parts}</td>
				<td class="coltop width12">{$PHP.L.Status}</td>
				<td class="coltop width30">{$PHP.L.Action}</td>
			</tr>
{foreach \$1 as $row}
{foreach \$1 as $row}
			<tr>
				<td colspan="7">
					<h4>{$ADMIN_EXTENSIONS_CAT_TITLE}</h4>
				</td>
			</tr>
{/foreach}
{foreach \$1 as $row}
			<tr>
				<td>{$ADMIN_EXTENSIONS_X_ERR}</td>
				<td colspan="5">{$ADMIN_EXTENSIONS_ERROR_MSG}</td>
			</tr>
{/foreach}
			<tr>
				<td>
					{if $ADMIN_EXTENSIONS_ICO }
					<img src="{$ADMIN_EXTENSIONS_ICO}" />
					{else}
					{$PHP.R.admin_icon_extension}
					{/if}
				</td>
				<td>
					<a href="{$ADMIN_EXTENSIONS_DETAILS_URL}"><strong>{$ADMIN_EXTENSIONS_NAME}</strong></a>
					<p class="small">{$.php.cot_cutstring($ADMIN_EXTENSIONS_DESCRIPTION,60)}</p>
				</td>
				<td class="centerall">{$ADMIN_EXTENSIONS_CODE_X}</td>
				<td class="centerall">
					{if $PHP.part_status != 3 AND $ADMIN_EXTENSIONS_VERSION_COMPARE > 0 }
					<span class="highlight_red">{$ADMIN_EXTENSIONS_VERSION_INSTALLED}</span> / <span class="highlight_green">{$ADMIN_EXTENSIONS_VERSION}</span>
					{else}
					{$ADMIN_EXTENSIONS_VERSION}
					{/if}
				</td>
				<td class="centerall">{$ADMIN_EXTENSIONS_PARTSCOUNT}</td>
				<td class="centerall">{$ADMIN_EXTENSIONS_STATUS}</td>
				<td class="action">
{if $ADMIN_EXTENSIONS_TOTALCONFIG }
					<a title="{$PHP.L.Configuration}" href="{$ADMIN_EXTENSIONS_EDIT_URL}" class="button">{$PHP.L.short_config}</a>
{/if}
{if $PHP.ifstruct }
					<a title="{$PHP.L.Structure}" href="{$ADMIN_EXTENSIONS_JUMPTO_URL_STRUCT}" class="button">{$PHP.L.short_struct}</a>
{/if}
{if $PHP.totalinstalled }
					<a title="{$PHP.L.Rights}" href="{$ADMIN_EXTENSIONS_RIGHTS_URL}" class="button">{$PHP.L.short_rights}</a>
{/if}
{if $PHP.ifthistools }
					<a title="{$PHP.L.Administration}" href="{$ADMIN_EXTENSIONS_JUMPTO_URL_TOOLS}" class="button special">{$PHP.L.short_admin}</a>
{/if}
{if $PHP.if_plg_standalone }
					<a title="{$PHP.L.Open}" href="{$ADMIN_EXTENSIONS_JUMPTO_URL}" class="button special">{$PHP.L.Open}</a>
{/if}
				</td>
			</tr>
{/foreach}
{foreach \$1 as $row}
			<tr>
				<td>{$ADMIN_EXTENSIONS_X}</td>
				<td colspan="5">{$PHP.L.adm_opt_setup_missing}</td>
			</tr>
{/foreach}
		</table>
	</div>
{/foreach}

