{include $PHP.cfg.themes_dir~"/admin/"~$PHP.cfg.admintheme~"/warnings.tpl"}

<div class="block button-toolbar">
	<a class="button large {if $ADMIN_EXT_SORT_ALP_SEL }special{/if}" href="{$ADMIN_EXT_SORT_ALP_URL}">{$PHP.L.adm_sort_alphabet}</a>
	<a class="button large {if $ADMIN_EXT_SORT_CAT_SEL }special{/if}" href="{$ADMIN_EXT_SORT_CAT_URL}">{$PHP.L.adm_sort_category}</a>
	<a class="button large" href="{if $ADMIN_EXT_ONLY_INSTALLED_SEL }{$ADMIN_EXT_ONLY_INSTALLED_URL}{else}{$ADMIN_EXT_ONLY_INSTALLED_URL}{/if}">{$PHP.L.adm_only_installed}</a>
	<a href="{$ADMIN_EXT_HOOKS_URL}" class="button large">{$PHP.L.Hooks}</a>
</div>


	<h2>{$PHP.L.Extension} ({$ADMIN_EXT_CNT_EXTP})</h2>
	<div class="block">
		<table class="table table-striped">
			<tr>
				<td class="coltop width5">&nbsp;</td>
				<td class="coltop width25">{$PHP.L.Name} {$PHP.L.adm_clicktoedit}</td>
				<td class="coltop width9">{$PHP.L.Version}</td>
				<td class="coltop width4">{$PHP.L.Parts}</td>
				<td class="coltop width12">{$PHP.L.Status}</td>
				<td class="coltop width30">{$PHP.L.Action}</td>
			</tr>
{foreach $ADMIN_EXT_CATEGORIES as $EXT_CAT_CODE => $EXT_CAT}
{if $EXT_CAT_CODE != 'all'}
			<tr>
				<td colspan="6">
					<h3>{$EXT_CAT}</h3>
				</td>
			</tr>
{/if}
{foreach $ADMIN_EXT_EXTENSIONS.$EXT_CAT_CODE as $EXT }
{if $EXT.ERROR_MSG }
			<tr>
				<td colspan="7">{$EXT.CODE}{$EXT.ERROR_MSG}</td>
			</tr>
{else}
			<tr>
				<td>
					{if $EXT.ICO }
					<img src="{$EXT.ICO}" />
					{else}
					{$PHP.R.admin_icon_extension}
					{/if}
				</td>
				<td>
					<h4><a href="{$EXT.URL_DETAILS}"><strong>{$EXT.NAME}</strong></a> <small>{$EXT.CODE}</small></h4>
					<p class="small">{$EXT.DESCRIPTION}</p>
				</td>
				<td class="centerall">
					{if $EXT.STATUS != 'notinstalled' AND $EXT.STATUS != 'missing' AND $EXT.VERSION_COMPARE > 0 }
					<span class="highlight_red">{$EXT.VERSION_INSTALLED}</span> / <span class="highlight_green">{$EXT.VERSION}</span>
					{else}
					{$EXT.VERSION}
					{/if}
				</td>
				<td class="centerall">{$EXT.PARTSCOUNT}</td>
				<td class="centerall">{$PHP.L['adm_'~$EXT.STATUS]}</td>
				<td class="action">
{if $EXT.URL_CONFIG }
					<a title="{$PHP.L.Configuration}" href="{$EXT.URL_CONFIG}" class="button">{$PHP.L.short_config}</a>
{/if}
{if $EXT.URL_STRUCT }
					<a title="{$PHP.L.Structure}" href="{$EXT.URL_STRUCT}" class="button">{$PHP.L.short_struct}</a>
{/if}
{if $EXT.STATUS != 'notinstalled' AND $EXT.STATUS != 'missing'}
					<a title="{$PHP.L.Rights}" href="{$EXT.URL_RIGHTS}" class="button">{$PHP.L.short_rights}</a>
{/if}
{if $EXT.URL_ADMIN }
					<a title="{$PHP.L.Administration}" href="{$EXT.URL_ADMIN}" class="button special">{$PHP.L.short_admin}</a>
{/if}
{if $EXT.URL_OPEN}
					<a title="{$PHP.L.Open}" href="{$EXT.URL_OPEN}" class="button special">{$PHP.L.Open}</a>
{/if}
				</td>
			</tr>
{/if}
{/foreach}
{/foreach}
		</table>
	</div>