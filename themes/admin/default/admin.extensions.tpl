<!-- BEGIN: MAIN -->
	{FILE "{PHP.cfg.themes_dir}/admin/default/warnings.tpl"}

<div class="block button-toolbar">
	<a class="button large <!-- IF {ADMIN_EXTENSIONS_SORT_ALP_SEL} -->special<!-- ENDIF -->" href="{ADMIN_EXTENSIONS_SORT_ALP_URL}">{PHP.L.adm_sort_alphabet}</a>
	<a class="button large <!-- IF {ADMIN_EXTENSIONS_SORT_CAT_SEL} -->special<!-- ENDIF -->" href="{ADMIN_EXTENSIONS_SORT_CAT_URL}">{PHP.L.adm_sort_category}</a>
	<a class="button large <!-- IF {ADMIN_EXTENSIONS_ONLY_INSTALLED_SEL} -->special" href="{ADMIN_EXTENSIONS_ONLY_INSTALLED_URL}"<!-- ELSE-->" href="{ADMIN_EXTENSIONS_ONLY_INSTALLED_URL}"<!-- ENDIF -->>{PHP.L.adm_only_installed}</a>
	<a href="{ADMIN_EXTENSIONS_HOOKS_URL}" class="button large">{PHP.L.Hooks}</a>
</div>

<!-- BEGIN: SECTION-->
	<h2>{PHP.L.Extension} ({ADMIN_EXTENSIONS_CNT_EXTP})</h2>
	<div class="block">
		<table class="table table-striped">
			<tr>
				<td class="coltop width5">&nbsp;</td>
				<td class="coltop width25">{PHP.L.Name} {PHP.L.adm_clicktoedit}</td>
				<td class="coltop width15">{PHP.L.Code}</td>
				<td class="coltop width9">{PHP.L.Version}</td>
				<td class="coltop width4">{PHP.L.Parts}</td>
				<td class="coltop width12">{PHP.L.Status}</td>
				<td class="coltop width30">{PHP.L.Action}</td>
			</tr>
<!-- BEGIN: ROW -->
<!-- BEGIN: ROW_CAT -->
			<tr>
				<td colspan="7">
					<h4>{ADMIN_EXTENSIONS_CAT_TITLE}</h4>
				</td>
			</tr>
<!-- END: ROW_CAT -->
<!-- BEGIN: ROW_ERROR_EXT -->
			<tr>
				<td>{ADMIN_EXTENSIONS_X_ERR}</td>
				<td colspan="5">{ADMIN_EXTENSIONS_ERROR_MSG}</td>
			</tr>
<!-- END: ROW_ERROR_EXT -->
			<tr>
				<td>
					<!-- IF {ADMIN_EXTENSIONS_ICO} -->
					<img src="{ADMIN_EXTENSIONS_ICO}" />
					<!-- ELSE -->
					{PHP.R.admin_icon_extension}
					<!-- ENDIF -->
				</td>
				<td>
					<a href="{ADMIN_EXTENSIONS_DETAILS_URL}"><strong>{ADMIN_EXTENSIONS_NAME}</strong></a>
					<p class="small">{ADMIN_EXTENSIONS_DESCRIPTION|cot_cutstring($this,60)}</p>
				</td>
				<td class="centerall">{ADMIN_EXTENSIONS_CODE_X}</td>
				<td class="centerall">
					<!-- IF {PHP.part_status} != 3 AND {ADMIN_EXTENSIONS_VERSION_COMPARE} > 0 -->
					<span class="highlight_red">{ADMIN_EXTENSIONS_VERSION_INSTALLED}</span> / <span class="highlight_green">{ADMIN_EXTENSIONS_VERSION}</span>
					<!-- ELSE -->
					{ADMIN_EXTENSIONS_VERSION}
					<!-- ENDIF -->
				</td>
				<td class="centerall">{ADMIN_EXTENSIONS_PARTSCOUNT}</td>
				<td class="centerall">{ADMIN_EXTENSIONS_STATUS}</td>
				<td class="action">
<!-- IF {ADMIN_EXTENSIONS_TOTALCONFIG} -->
					<a title="{PHP.L.Configuration}" href="{ADMIN_EXTENSIONS_EDIT_URL}" class="button">{PHP.L.short_config}</a>
<!-- ENDIF -->
<!-- IF {PHP.ifstruct} -->
					<a title="{PHP.L.Structure}" href="{ADMIN_EXTENSIONS_JUMPTO_URL_STRUCT}" class="button">{PHP.L.short_struct}</a>
<!-- ENDIF -->
<!-- IF {PHP.totalinstalled} -->
					<a title="{PHP.L.Rights}" href="{ADMIN_EXTENSIONS_RIGHTS_URL}" class="button">{PHP.L.short_rights}</a>
<!-- ENDIF -->
<!-- IF {PHP.ifthistools} -->
					<a title="{PHP.L.Administration}" href="{ADMIN_EXTENSIONS_JUMPTO_URL_TOOLS}" class="button special">{PHP.L.short_admin}</a>
<!-- ENDIF -->
<!-- IF {PHP.if_plg_standalone} -->
					<a title="{PHP.L.Open}" href="{ADMIN_EXTENSIONS_JUMPTO_URL}" class="button special">{PHP.L.Open}</a>
<!-- ENDIF -->
				</td>
			</tr>
<!-- END: ROW -->
<!-- BEGIN: ROW_ERROR -->
			<tr>
				<td>{ADMIN_EXTENSIONS_X}</td>
				<td colspan="5">{PHP.L.adm_opt_setup_missing}</td>
			</tr>
<!-- END: ROW_ERROR -->
		</table>
	</div>
<!-- END: SECTION -->

<!-- END: MAIN -->