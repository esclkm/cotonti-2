
{$ADMIN_RIGHTS_BREADCRUMBS}
		<h2>{$PHP.L.Rights}</h2>
		{include $PHP.cfg.themes_dir~"/admin/"~$PHP.cfg.admintheme~"/warnings.tpl"}
		<form name="saverights" id="saverights" action="{$ADMIN_RIGHTS_FORM_URL}" method="post" class="ajax">
			{if $PHP.g > 5 }
			<table class="cells">
				<tr>
					<td><input type="checkbox" class="checkbox" name="ncopyrightsconf" />{$PHP.L.adm_copyrightsfrom}: {$ADMIN_RIGHTS_SELECTBOX_GROUPS} &nbsp; <input type="submit" class="submit" value="{$PHP.L.Update}" /></td>
				</tr>
			</table>
			{/if}
{foreach \$1 as $row}
			<h3>{$RIGHTS_SECTION_TITLE}:</h3>
			<table class="table table-striped">
				<tr>
					<td class="coltop width5" rowspan="2"></td>
					<td class="coltop width25" rowspan="2">{$PHP.L.Section}</td>
					<td class="coltop width40" colspan="{$ADMIN_RIGHTS_ADV_COLUMNS}">{$PHP.L.Rights}</td>
					<td class="coltop width15" rowspan="2">{$PHP.L.adm_rightspergroup}</td>
					<td class="coltop width15" rowspan="2">{$PHP.L.adm_setby}</td>
				</tr>
				<tr>
					<td class="coltop"><span class="label label-primary">R</span></td>
					<td class="coltop"><span class="label label-primary">W</span></td>
					<td class="coltop"><span class="label label-primary">1</span></td>
					{if $PHP.advanced }
					<td class="coltop"><span class="label label-primary">2</span></td>
					<td class="coltop"><span class="label label-primary">3</span></td>
					<td class="coltop"><span class="label label-primary">4</span></td>
					<td class="coltop"><span class="label label-primary">5</span></td>
					{/if}
					<td class="coltop"><span class="label label-primary">A</span></td>
				</tr>
{foreach \$1 as $row}
				<tr>
					<td class="centerall">					
					{if $ADMIN_RIGHTS_ROW_ICO } 
					<img src="{$ADMIN_RIGHTS_ROW_ICO}"/>
					{else}
					{$PHP.R.admin_icon_extension}
					{/if}
					</td>
					<td> <a href="{$ADMIN_RIGHTS_ROW_LINK}">{$ADMIN_RIGHTS_ROW_TITLE}</a></td>
{foreach \$1 as $row}
					<td class="centerall">
						{if $PHP.out.tpl_rights_parseline_locked AND $PHP.out.tpl_rights_parseline_state }
						<input type="hidden" name="{$ADMIN_RIGHTS_ROW_ITEMS_NAME}" value="1" />
						{$PHP.R.admin_icon_discheck1}
						{/if}
						{if $PHP.out.tpl_rights_parseline_locked AND !$PHP.out.tpl_rights_parseline_state }
						{$PHP.R.admin_icon_discheck0}
						{/if}
						{if !$PHP.out.tpl_rights_parseline_locked }
						<input type="checkbox" class="checkbox" name="{$ADMIN_RIGHTS_ROW_ITEMS_NAME}"{$ADMIN_RIGHTS_ROW_ITEMS_CHECKED}{$ADMIN_RIGHTS_ROW_ITEMS_DISABLED} />
						{/if}
					</td>
{/foreach}
					<td class="centerall"><a title="{$PHP.L.Rights}" href="{$ADMIN_RIGHTS_ROW_RIGHTSBYITEM}" class="button">{$PHP.L.Rights}</a><a title="{$PHP.L.Rights}" href="{$ADMIN_RIGHTS_ROW_LINK}" class="button special">{$PHP.L.Open}</a></td>
					<td class="textcenter">{$ADMIN_RIGHTS_ROW_USER}{$ADMIN_RIGHTS_ROW_PRESERVE}</td>
				</tr>
{/foreach}
			</table>
{/foreach}
			<div style="text-align:center">
				<a href="{$ADMIN_RIGHTS_ADVANCED_URL}">{$PHP.L.More}</a><br /><br />
				<input type="submit" class="submit" value="{$PHP.L.Update}" />
			</div>
		</form>
			
	<div class="block">
		<div class="help">
			<h4>{$PHP.L.Help}:</h4>
				<p><span class="label label-primary">R</span>&nbsp; {$PHP.L.Read}</p>
				<p><span class="label label-primary">W</span>&nbsp; {$PHP.L.Write}</p>
				<p><span class="label label-primary">1</span>&nbsp; {$PHP.L.Custom} #1</p>
				{if $PHP.advanced }
				<p><span class="label label-primary">2</span>&nbsp; {$PHP.L.Custom} #2</p>
				<p><span class="label label-primary">3</span>&nbsp; {$PHP.L.Custom} #3</p>
				<p><span class="label label-primary">4</span>&nbsp; {$PHP.L.Custom} #4</p>
				<p><span class="label label-primary">5</span>&nbsp; {$PHP.L.Custom} #5</p>
				{/if}
				<p><span class="label label-primary">A</span>&nbsp; {$PHP.L.Administration}</p>
		</div>
	</div>			
