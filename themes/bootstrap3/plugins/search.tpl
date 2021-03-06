<!-- BEGIN: MAIN -->

		<div class="block">
			<h2 class="stats">{EXT_TITLE}</h2>
				<div>
					<form id="search" name="search" action="{EXT_SEARCH_ACTION}" method="get">
						<input type="hidden" name="e" value="search" />
						<input type="hidden" name="tab" value="{PHP.tab}" />
						<p class="textcenter">
							<a href="{PHP|cot_url('index','e=search')}">{PHP.L.plu_tabs_all}</a> |
							<a href="{PHP|cot_url('index','e=search&amp;tab=frm')}">{PHP.L.Forums}</a> |
							<a href="{PHP|cot_url('index','e=search&amp;tab=pag')}">{PHP.L.Pages}</a>
						</p>

						<p class="margin10 textcenter">{PHP.L.plu_search_req}: {EXT_SEARCH_TEXT} <input type="submit" value="{PHP.L.plu_search_key}" /></p>
						<p class="margin10 textcenter">{PHP.L.plu_other_date}: {EXT_SEARCH_DATE_SELECT} {EXT_SEARCH_DATE_FROM} - {EXT_SEARCH_DATE_TO}</p>
						<p class="margin10 textcenter">{PHP.L.plu_other_userfilter}: {EXT_SEARCH_USER}</p>
<!-- BEGIN: PAGES_OPTIONS -->
						<h3>{PHP.L.Pages}</h3>
						<table class="main">
							<tr>
								<td class="width50">
									<p class="strong">{PHP.L.plu_pag_set_sec}:</p>
									<p>{EXT_PAGE_SEC_LIST}</p>
									<p>{EXT_PAGE_SEARCH_SUBCAT}</p>
									<p class="small">{PHP.L.plu_ctrl_list}</p>
								</td>
								<td class="width50">
									<p class="strong">{PHP.L.plu_other_opt}:</p>
									<p><label>{EXT_PAGE_SEARCH_NAMES} {PHP.L.plu_pag_search_names}</label></p>
									<p>{EXT_PAGE_SEARCH_DESC}</p>
									<p>{EXT_PAGE_SEARCH_TEXT}</p>
									<p>{EXT_PAGE_SEARCH_FILE}</p>
									<p class="strong">{PHP.L.plu_res_sort}:</p>
									<p>{EXT_PAGE_RES_SORT}</p>
									<p>{EXT_PAGE_RES_SORT_WAY}</p>
								</td>
							</tr>
						</table>
<!-- END: PAGES_OPTIONS -->
<!-- BEGIN: FORUMS_OPTIONS -->
						<h3>{PHP.L.Forums}</h3>
						<table class="main">
							<tr>
								<td class="width50">
									<p class="strong">{PHP.L.plu_frm_set_sec}:</p>
									<p>{EXT_FORUM_SEC_LIST}</p>
									<p>{EXT_FORUM_SEARCH_SUBCAT}</p>
									<div class="small">{PHP.L.plu_ctrl_list}</div>
								</td>
								<td class="width50">
									<p class="strong">{PHP.L.plu_other_opt}:</p>
									<p>{EXT_FORUM_SEARCH_NAMES}</p>
									<p>{EXT_FORUM_SEARCH_POST}</p>
									<p>{EXT_FORUM_SEARCH_ANSW}</p>
									<p class="strong">{PHP.L.plu_res_sort}:</p>
									<p>{EXT_FORUM_RES_SORT}</p>
									<p>{EXT_FORUM_RES_SORT_WAY}</p>

								</td>
							</tr>
						</table>
<!-- END: FORUMS_OPTIONS -->
					</form>
				</div>

				{FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/warnings.tpl"}

<!-- BEGIN: RESULTS -->
<!-- BEGIN: PAGES -->
				<h3>{PHP.L.Pages}</h3>
				<table class="cells">
					<tr>
						<td colspan="2" class="coltop">{PHP.L.plu_result}: {PHP.L.plu_tabs_pag}
						</td>
					</tr>
<!-- BEGIN: ITEM -->
					<tr>
						<td colspan="2" class="{EXT_PR_ODDEVEN}">{EXT_PR_TITLE}</td>
					</tr>
					<tr>
						<td colspan="2" class="{EXT_PR_ODDEVEN}">{EXT_PR_TEXT}</td>
					</tr>
					<tr>
						<td class="{EXT_PR_ODDEVEN} width50"><p class="small">{PHP.L.plu_last_date}: {EXT_PR_TIME}</p></td>
						<td class="{EXT_PR_ODDEVEN} textright width50"><p class="small">{PHP.L.plu_section}: {EXT_PR_CATEGORY}</p></td>
					</tr>
<!-- END: ITEM -->
				</table>
<!-- END: PAGES -->

<!-- BEGIN: FORUMS -->
				<h3>{PHP.L.Forums}</h3>
				<table class="cells">
					<tr>
						<td colspan="2" class="coltop">{PHP.L.plu_result}: {PHP.L.plu_tabs_frm}
						</td>
					</tr>
<!-- BEGIN: ITEM -->
					<tr>
						<td colspan="2" class="{EXT_FR_ODDEVEN}">{EXT_FR_TITLE}</td>
					</tr>
					<!-- IF {EXT_FR_TEXT} --><tr>
						<td colspan="2" class="{EXT_FR_ODDEVEN}">{EXT_FR_TEXT}</td>
					</tr><!-- ENDIF -->
					<tr>
						<td class="{EXT_FR_ODDEVEN} width50"><p class="small">{PHP.L.plu_last_date}: {EXT_FR_TIME}</p></td>
						<td class="{EXT_FR_ODDEVEN} textright width50"><p class="small">{PHP.L.plu_section}: {EXT_FR_CATEGORY}</p></td>
					</tr>
<!-- END: ITEM -->
				</table>

<!-- END: FORUMS -->
<!-- END: RESULTS -->
				<p class="paging">{EXT_PAGEPREV}{EXT_PAGENAV}{EXT_PAGENEXT}</p>
		</div>

<!-- END: MAIN -->