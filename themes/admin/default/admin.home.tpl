<div class="row">
	<div class="col-md-8">
		{if $ADMIN_HOME_UPDATE_REVISION}
		<h3>{$PHP.L.adminqv_update_notice}:</h3>
		<p>{$ADMIN_HOME_UPDATE_REVISION} {$ADMIN_HOME_UPDATE_MESSAGE}</p>
		{/if}
		{include $PHP.cfg.themes_dir~"/admin/"~$PHP.cfg.admintheme~"/warnings.tpl"}
		{foreach $ADMIN_HOME_MAINPANEL as $PANEL}
		{$PANEL}
		{/foreach}
		<h3>Feliz:</h3>
		<table class="table table-striped">
			<tr>
				<td class="width80">{$PHP.L.Version}</td>
				<td class="textcenter width20">{$ADMIN_HOME_VERSION}</td>
			</tr>
			<tr>
				<td>{$PHP.L.Database}</td>
				<td class="textcenter">{$ADMIN_HOME_DB_VERSION}</td>
			</tr>
			<tr>
				<td>{$PHP.L.home_db_rows}</td>
				<td class="textcenter">{$ADMIN_HOME_DB_TOTAL_ROWS}</td>
			</tr>
			<tr>
				<td>{$PHP.L.home_db_indexsize}</td>
				<td class="textcenter">{$ADMIN_HOME_DB_INDEXSIZE}</td>
			</tr>
			<tr>
				<td>{$PHP.L.home_db_datassize}</td>
				<td class="textcenter">{$ADMIN_HOME_DB_DATASSIZE}</td>
			</tr>
			<tr>
				<td>{$PHP.L.home_db_totalsize}</td>
				<td class="textcenter">{$ADMIN_HOME_DB_TOTALSIZE}</td>
			</tr>
			<tr>
				<td>{$PHP.L.Extensions}</td>
				<td class="textcenter">{$ADMIN_HOME_TOTALEXTENSIONS}</td>
			</tr>
			<tr>
				<td>{$PHP.L.Hooks}</td>
				<td class="textcenter">{$ADMIN_HOME_TOTALHOOKS}</td>
			</tr>
		</table>
	</div>

	<div class="col-md-4">
		<div class="list-group cog">
			<a href="{$.php.cot_url('admin', 't=cache')}" class="list-group-item">
				{$PHP.R.admin_icon_extension}
				<h4 class="list-group-item-heading">{$PHP.L.adm_internalcache}</h4>
				<p class="list-group-item-text">{$PHP.L.adm_internalcache_desc}</p>
			</a>
			<a href="{$.php.cot_url('admin', 't=cache&m=disk')}" class="list-group-item">
				{$PHP.R.admin_icon_extension}
				<h4 class="list-group-item-heading">{$PHP.L.adm_diskcache}</h4>
				<p class="list-group-item-text">{$PHP.L.adm_diskcache_desc}</p>
			</a>
			<a href="{$.php.cot_url('admin', 't=log')}" class="list-group-item">
				{$PHP.R.admin_icon_extension}
				<h4 class="list-group-item-heading">{$PHP.L.adm_log}</h4>
				<p class="list-group-item-text">{$PHP.L.adm_log_desc}</p>
			</a>
			<a href="{$.php.cot_url('admin', 't=infos')}" class="list-group-item">
				{$PHP.R.admin_icon_extension}
				<h4 class="list-group-item-heading">{$PHP.L.adm_infos}</h4>
				<p class="list-group-item-text">{$PHP.L.adm_infos_desc}</p>
			</a>
	
		{foreach $ADMIN_EXT as $EXT}

			<a href="{$EXT.URL}" class="list-group-item">
				{if $EXT.ICO } 
					<img src="{$EXT.ICO}"/>
				{else}
				{$PHP.R.admin_icon_extension}
				{/if}
				<h4 class="list-group-item-heading">{$EXT.NAME}</h4>
				<p class="list-group-item-text">{$EXT.DESC}</p>
			</a>
		{/foreach}
		</div>

		 <h3>{$PHP.L.home_ql_b1_title}</h3>
		<ul class="follow">
			<li><a href="{$.php.cot_url('admin','m=config&n=edit&o=core&p=main')}">{$PHP.L.home_ql_b1_1}</a></li>
			<li><a href="{$.php.cot_url('admin','m=config&n=edit&o=core&p=title')}">{$PHP.L.home_ql_b1_2}</a></li>
			<li><a href="{$.php.cot_url('admin','m=config&n=edit&o=core&p=theme')}">{$PHP.L.home_ql_b1_3}</a></li>
			<li><a href="{$.php.cot_url('admin','m=extrafields')}">{$PHP.L.adm_extrafields}</a></li>
		</ul>

		{foreach $ADMIN_HOME_SIDEPANEL as $PANEL}
		{$PANEL}
		{/foreach}

	</div>
</div>
<div class="clearfix"></div>