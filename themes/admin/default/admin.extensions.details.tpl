{include $PHP.cfg.themes_dir~"/admin/"~$PHP.cfg.admintheme~"/warnings.tpl"}

<h1>{$PHP.L.Extension} {$ADMIN_EXT_NAME}</h1>
<div class="row">
	<div class="col-xs-1 hidden-xs">
		{if $ADMIN_EXT_ICO }
		<img src="{$ADMIN_EXT_ICO}" />
		{else}
		{$PHP.R.admin_icon_extension}
		{/if}
	</div>
	<div class="col-xs-11">
		<table class="table table-striped info">
			<tr>
				<td class="col-xs-3">{$PHP.L.Code}:</td>
				<td class="col-xs-9">{$ADMIN_EXT_CODE}</td>
			</tr>
			<tr>
				<td>{$PHP.L.Description}:</td>
				<td>{$ADMIN_EXT_DESCRIPTION}</td>
			</tr>
			<tr>
				<td>{$PHP.L.Version}:</td>
				<td>
					{if $ADMIN_EXT_VERSION_INSTALLED AND $ADMIN_EXT_VERSION_COMPARE > 0 }
					<span class="highlight_red">{$ADMIN_EXT_VERSION_INSTALLED}</span> / <span class="highlight_green">{$ADMIN_EXT_VERSION}</span>
					{else}
					{$ADMIN_EXT_VERSION}
					{/if}
				</td>
			</tr>
			<tr>
				<td>{$PHP.L.Date}:</td>
				<td>{$ADMIN_EXT_DATE}</td>
			</tr>
			<tr>
				<td>{$PHP.L.Author}:</td>
				<td>{$ADMIN_EXT_AUTHOR}</td>
			</tr>
			<tr>
				<td>{$PHP.L.Copyright}:</td>
				<td>{$ADMIN_EXT_COPYRIGHT}</td>
			</tr>
			<tr>
				<td>{$PHP.L.Notes}:</td>
				<td>{$ADMIN_EXT_NOTES}</td>
			</tr>
			{if $ADMIN_EXT_REQUIRES}
			<tr>
				<td>{$PHP.L.ext_requires_ext}:</td>
				<td>
					<ul  class="list-inline">
					{foreach $ADMIN_EXT_REQUIRES as $EXT}
						<li>
							<a href="{$EXT.URL}" class="label label-{$EXT.CLASS}">{$EXT.NAME}</a>
						</li>
					{/foreach}
					</ul>
				</td>
			</tr>
			{/if}
			{if $ADMIN_EXT_RECOMMENDS}
			<tr>
				<td>{$PHP.L.ext_recommends_ext}:</td>
				<td>
					<ul  class="list-inline">
					{foreach $ADMIN_EXT_RECOMMENDS as $EXT}
						<li>
							<a href="{$EXT.URL}" class="label label-{$EXT.CLASS}">{$EXT.NAME}</a>
						</li>
					{/foreach}
					</ul>
				</td>
			</tr>
			{/if}
		</table>
		<div class="text-right">
		{if !$ADMIN_EXT_ISINSTALLED AND $PHP.dependencies_satisfied }
			<a title="{$PHP.L.adm_opt_install_explain}" class="btn btn-primary" href="{$ADMIN_EXT_INSTALL_URL}" class="ajax button special large">{$PHP.L.adm_opt_install}</a>
		{/if}
		{if $ADMIN_EXT_ISINSTALLED }
			{if $ADMIN_EXT_EXIST }
			<a title="{$PHP.L.adm_opt_install_explain}" class="btn btn-primary" href="{$ADMIN_EXT_UPDATE_URL}" class="ajax button special large">{$PHP.L.adm_opt_update}</a>
			{/if}
			<a title="{$PHP.L.adm_opt_uninstall_explain}"  class="btn btn-danger" href="{$ADMIN_EXT_UNINSTALL_URL}" class="ajax button large">{$PHP.L.adm_opt_uninstall}</a>
		{/if}
		</div>
	</div>
</div>
<div class="block">

</div>
{if $ADMIN_EXT_ISINSTALLED AND $ADMIN_EXT_EXIST}
<div class="block">

	<h3>{$PHP.L.Action}:</h3>
	<div class="button-toolbar">
	{if $ADMIN_EXT_JUMPTO_URL }
		<a title="{$PHP.L.Open}" href="{$ADMIN_EXT_JUMPTO_URL}" target="_blank" class="btn btn-lg btn-default"><span class="glyphicon glyphicon-share-alt"></span> {$PHP.L.Open}</a>
	{/if}
	{if $ADMIN_EXT_JUMPTO_URL_TOOLS }
	<a title="{$PHP.L.Administration}" href="{$ADMIN_EXT_JUMPTO_URL_TOOLS}"  class="btn btn-lg btn-default"><span class="glyphicon glyphicon-edit"></span> {$PHP.L.Administration}</a>
	{/if}
	{if $ADMIN_EXT_TOTALCONFIG > 0 }
		<a title="{$PHP.L.Configuration}" href="{$ADMIN_EXT_CONFIG_URL}" class="btn btn-lg btn-default"><span class="glyphicon glyphicon-cog"></span> {$PHP.L.Configuration} ({$ADMIN_EXT_TOTALCONFIG})</a>
	{/if}
	<a title="{$PHP.L.Rights}" href="{$ADMIN_EXT_RIGHTS}"  class="btn btn-lg btn-default"><span class="glyphicon glyphicon-lock"></span> {$PHP.L.short_rights}</a>
	{if $ADMIN_EXT_JUMPTO_URL_STRUCT }
	<a title="{$PHP.L.Structure}" href="{$ADMIN_EXT_JUMPTO_URL_STRUCT}" class="btn btn-lg btn-default"><span class="glyphicon glyphicon-list-alt"></span> {$PHP.L.Structure}</a>
	{/if}
	{if $ADMIN_EXT_JUMPTO_EXFLDS}
		{foreach $ADMIN_EXT_JUMPTO_EXFLDS as $EXFLD}
			<a title="{$PHP.L.Extrafield}" href="{$EXFLD.url}" class="btn btn-lg btn-default"><span class="glyphicon glyphicon-hdd"></span> {$PHP.L.adm_extrafields_table} {$EXFLD.name}</a>
		{/foreach}
	{/if}
		</div>
</div>
{/if}

{if $ADMIN_EXT_PARTS}
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

{foreach $ADMIN_EXT_PARTS as $PART index=$index}
{if $PART.ERROR}
		<tr>
			<td class="text-center">{$index+1}</td>
			<td colspan="2" class="text-center">{$PART.FILE}</td>
			<td colspan="4" class="text-center">{$PART.ERROR}</td>
		</tr>
{else}
		<tr>
			<td class="text-center">{$index+1}</td>
			<td class="text-center">{$PART.PART}</td>
			<td class="text-center">{$PART.FILE}</td>
			<td class="text-center">{$PART.HOOKS}</td>
			<td class="text-center">{$PART.ORDER}</td>
			<td class="text-center">{$PART.STATUS}</td>
			<td class="text-center">
{if $PART.NOTINSTALLED}
				&ndash;
{/if}
{if $PART.PAUSEPART_URL}
				<a href="{$PART.PAUSEPART_URL}" class="ajax button">{$PHP.L.adm_opt_pause}</a>
{/if}
{if $PART.UNPAUSEPART_URL}
				<a href="{$PART.UNPAUSEPART_URL}" class="ajax button">{$PHP.L.adm_opt_unpause}</a>
{/if}
			</td>
		</tr>
{/if}
{/foreach}
	</table>
	{if $ADMIN_EXT_ISINSTALLED AND $ADMIN_EXT_EXIST }
	<div class="text-right">
		<a title="{$PHP.L.adm_opt_pauseall_explain}" class="btn btn-default"  href="{$ADMIN_EXT_PAUSE_URL}" class="ajax button large">{$PHP.L.adm_opt_pauseall}</a>
		<a title="{$PHP.L.adm_opt_unpauseall_explain}"  class="btn btn-default" href="{$ADMIN_EXT_UNPAUSE_URL}" class="ajax button large">{$PHP.L.adm_opt_unpauseall}</a>
	</div>
	{/if}
</div>
{/if}
{if $ADMIN_EXT_TAGS}
<div class="block">
	<h3>{$PHP.L.Tags}:</h3>
	<table class="table table-striped">
		<tr>
			<td class="coltop width5">#</td>
			<td class="coltop width25">{$PHP.L.Part}</td>
			<td class="coltop width70">{$PHP.L.Files} / {$PHP.L.Tags}</td>
		</tr>

{foreach $ADMIN_EXT_TAGS as $TAG index=$index}
		<tr>
			<td class="centerall">{$index+1}</td>
			<td class="centerall">{$TAG.PART}</td>
			<td>
				{foreach $TAG.LISTTAGS as $TPL_FILE => $TPL_TAGS}
					<strong>{$TPL_FILE}</strong>
					<div>
					{foreach $TPL_TAGS as $TPL_TAG first=$first}
						{if !$first}, {/if}{$TPL_TAG}
					{/foreach}
					</div>
				{/foreach}	
				{$ADMIN_EXT_DETAILS_ROW_LISTTAGS}
			</td>
		</tr>
{/foreach}
	</table>
</div>
{/if}
