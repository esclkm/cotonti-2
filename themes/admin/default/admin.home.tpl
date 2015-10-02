<!-- BEGIN: MAIN -->
<h2>{PHP.L.Main}</h2>
<div class="row">
	<div class="col-md-8">
		<!-- BEGIN: UPDATE -->
		<h3>{PHP.L.adminqv_update_notice}:</h3>
		<p>{ADMIN_HOME_UPDATE_REVISION} {ADMIN_HOME_UPDATE_MESSAGE}</p>
		<!-- END: UPDATE -->
		{FILE "{PHP.cfg.themes_dir}/admin/default/warnings.tpl"}
		<!-- BEGIN: MAINPANEL -->
		{ADMIN_HOME_MAINPANEL}
		<!-- END: MAINPANEL -->
		<h3>Cotonti:</h3>
		<table class="table table-striped">
			<tr>
				<td class="width80">{PHP.L.Version}</td>
				<td class="textcenter width20">{ADMIN_HOME_VERSION}</td>
			</tr>
			<tr>
				<td>{PHP.L.Database}</td>
				<td class="textcenter">{ADMIN_HOME_DB_VERSION}</td>
			</tr>
			<tr>
				<td>{PHP.L.home_db_rows}</td>
				<td class="textcenter">{ADMIN_HOME_DB_TOTAL_ROWS}</td>
			</tr>
			<tr>
				<td>{PHP.L.home_db_indexsize}</td>
				<td class="textcenter">{ADMIN_HOME_DB_INDEXSIZE}</td>
			</tr>
			<tr>
				<td>{PHP.L.home_db_datassize}</td>
				<td class="textcenter">{ADMIN_HOME_DB_DATASSIZE}</td>
			</tr>
			<tr>
				<td>{PHP.L.home_db_totalsize}</td>
				<td class="textcenter">{ADMIN_HOME_DB_TOTALSIZE}</td>
			</tr>
			<tr>
				<td>{PHP.L.Extensions}</td>
				<td class="textcenter">{ADMIN_HOME_TOTALEXTENSIONS}</td>
			</tr>
			<tr>
				<td>{PHP.L.Hooks}</td>
				<td class="textcenter">{ADMIN_HOME_TOTALHOOKS}</td>
			</tr>
		</table>

		<table class="cells">

			<tr>
				<td>
					<p class="strong"><a href="{PHP|cot_url('admin', 't=cache')}">{PHP.L.adm_internalcache}</a></p>
					<p class="small">{PHP.L.adm_internalcache_desc}</p>
				</td>
			</tr>
			<tr>
				<td>
					<p class="strong"><a href="{PHP|cot_url('admin', 't=cache&s=disk')}">{PHP.L.adm_diskcache}</a></p>
					<p class="small">{PHP.L.adm_diskcache_desc}</p>
				</td>
			</tr>		
			<tr>
				<td>
					<p class="strong"><a href="{PHP|cot_url('admin', 't=log')}">{PHP.L.adm_log}</a></p>
					<p class="small">{PHP.L.adm_log_desc}</p>
				</td>
			</tr>
			<tr>
				<td>
					<p class="strong"><a href="{PHP|cot_url('admin', 't=infos')}">{PHP.L.adm_infos}</a></p>
					<p class="small">{PHP.L.adm_infos_desc}</p>
				</td>
			</tr>
		</table>


		<!-- BEGIN: SECTION -->
		<h2>{ADMIN_OTHER_SECTION}</h2>

		<table class="cells">
			<!-- BEGIN: ROW -->
			<tr>
				<td class="centerall width10">
					<!-- IF {ADMIN_OTHER_EXT_ICO} --> 
					<img src="{ADMIN_OTHER_EXT_ICO}"/>
					<!-- ELSE -->
					{PHP.R.admin_icon_extension}
						<!-- ENDIF -->
				</td>
				<td class="width90">
					<p class="strong"><a href="{ADMIN_OTHER_EXT_URL}">{ADMIN_OTHER_EXT_NAME}</a></p>
					<p class="small">{ADMIN_OTHER_EXT_DESC}</p>
				</td>
			</tr>
				<!-- END: ROW -->
				<!-- BEGIN: EMPTY -->
			<tr>
				<td colspan="2">{PHP.L.adm_listisempty}</td>
			</tr>
			<!-- END: EMPTY -->
		</table>

			<!-- END: SECTION -->
	</div>

	<div class="col-md-4">

		 <h3>{PHP.L.home_ql_b1_title}</h3>
		<ul class="follow">
			<li><a href="{PHP|cot_url('admin','m=config&n=edit&o=core&p=main')}">{PHP.L.home_ql_b1_1}</a></li>
			<li><a href="{PHP|cot_url('admin','m=config&n=edit&o=core&p=title')}">{PHP.L.home_ql_b1_2}</a></li>
			<li><a href="{PHP|cot_url('admin','m=config&n=edit&o=core&p=theme')}">{PHP.L.home_ql_b1_3}</a></li>
			<li><a href="{PHP|cot_url('admin','m=extrafields')}">{PHP.L.adm_extrafields}</a></li>
		</ul>

		<!-- BEGIN: SIDEPANEL -->

		{ADMIN_HOME_SIDEPANEL}

		<!-- END: SIDEPANEL -->

	</div>
</div>
<div class="clearfix"></div>


	<!-- END: MAIN -->