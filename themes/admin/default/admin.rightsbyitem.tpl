
	{$ADMIN_RIGHTSBYITEM_BREADCRUMBS}
	
		<h2>{$PHP.L.Rights}</h2>
		{include $PHP.cfg.themes_dir~"/admin/"~$PHP.cfg.admintheme~"/warnings.tpl"}
		<div class="block">
			<form name="saverightsbyitem" id="saverightsbyitem" action="{$ADMIN_RIGHTSBYITEM_FORM_URL}" method="post" class="ajax">
				<table class="table table-striped">
					<tr>
						<td class="coltop width5" rowspan="2"></td>
						<td class="coltop width25" rowspan="2">{$PHP.L.Groups}</td>
						<td class="coltop width40" colspan="{$ADMIN_RIGHTSBYITEM_ADV_COLUMNS}">{$PHP.L.Rights}</td>
						<td class="coltop width15" rowspan="2">{$PHP.L.Open}</td>
						<td class="coltop width15" rowspan="2">{$PHP.L.adm_setby}</td>
					</tr>

					<tr>
						<td class="coltop"><span class="label label-primary">R</span></td>
						<td class="coltop"><span class="label label-primary">W</span></td>
						{if $PHP.advanced OR $PHP.ic == 'page' }
						<td class="coltop"><span class="label label-primary">1</span></td>
						{/if}
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
						<td class="centerall"><img src="{$PHP.cfg.admin_dir}/img/users.png"/></td>
						<td><a href="{$ADMIN_RIGHTSBYITEM_ROW_LINK}">{$ADMIN_RIGHTSBYITEM_ROW_TITLE}</a></td>
{foreach \$1 as $row}
						<td class="centerall">
							{if $PHP.out.tpl_rights_parseline_locked AND $PHP.out.tpl_rights_parseline_state }<input type="hidden" name="{$ADMIN_RIGHTSBYITEM_ROW_ITEMS_NAME}" value="1" />
							{$PHP.R.admin_icon_discheck1}{/if}
							{if $PHP.out.tpl_rights_parseline_locked AND !$PHP.out.tpl_rights_parseline_state }{$PHP.R.admin_icon_discheck0}{/if}
							{if !$PHP.out.tpl_rights_parseline_locked }<input type="checkbox" class="checkbox" name="{$ADMIN_RIGHTSBYITEM_ROW_ITEMS_NAME}"{$ADMIN_RIGHTSBYITEM_ROW_ITEMS_CHECKED}{$ADMIN_RIGHTSBYITEM_ROW_ITEMS_DISABLED} />{/if}
						</td>
{/foreach}
						<td class="centerall"><a title="{$PHP.L.Open}" href="{$ADMIN_RIGHTSBYITEM_ROW_JUMPTO}" class="button special">{$PHP.L.Open}</a><a title="{$PHP.L.Open}" href="{$ADMIN_RIGHTSBYITEM_ROW_LINK}" class="button">{$PHP.L.Rights}</a> </td>
						<td class="textcenter">{$ADMIN_RIGHTSBYITEM_ROW_USER}{$ADMIN_RIGHTSBYITEM_ROW_PRESERVE}</td>
						
					</tr>
{/foreach}
					<tr>
						<td class="textcenter" colspan="{$ADMIN_RIGHTSBYITEM_4ADV_COLUMNS}">
							<a href="{$ADMIN_RIGHTSBYITEM_ADVANCED_URL}">{$PHP.L.More}</a>
						</td>
					</tr>
					<tr>
						<td class="valid" colspan="{$ADMIN_RIGHTSBYITEM_4ADV_COLUMNS}">
							<input type="submit" class="submit" value="{$PHP.L.Update}" />
						</td>
					</tr>
				</table>
			</form>
		</div>
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


