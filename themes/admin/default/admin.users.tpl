
		<h2>{$PHP.L.Users}</h2>
		{include $PHP.cfg.themes_dir~"/admin/"~$PHP.cfg.admintheme~"/warnings.tpl"}

		<div class="block button-toolbar">
			<a title="{$PHP.L.Configuration}" href="{$ADMIN_USERS_URL}" class="button">{$PHP.L.Configuration}</a>
			<a href="{$ADMIN_USERS_EXTRAFIELDS_URL}" class="button">{$PHP.L.adm_extrafields}</a>
		</div>

{foreach \$1 as $row}
		<div class="block">
			<table class="table table-striped">
				<tr>
					<td class="coltop width5">&nbsp;</td>
					<td class="coltop width35">{$PHP.L.Groups}</td>
					<td class="coltop width20">{$PHP.L.Members}</td>
					<td class="coltop width20">{$PHP.L.Enabled}</td>
					<td class="coltop width20">{$PHP.L.Action}</td>
				</tr>
{foreach \$1 as $row}
				<tr>
					<td class="centerall">
					{if $PHP.hidden_groups AND $ADMIN_USERS_ROW_GRP_HIDDEN == Yes }{$PHP.R.admin_icon_usergroup0}{else}{$PHP.R.admin_icon_usergroup1}{/if}
					{/if}
					</td>
					<td>
						<p class="strong"><a href="{$ADMIN_USERS_ROW_GRP_TITLE_URL}" class="ajax" title="{$PHP.L.Edit}">{$ADMIN_USERS_ROW_GRP_NAME} (#{$ADMIN_USERS_ROW_GRP_ID})</a></p>
						<p class="small">{$ADMIN_USERS_ROW_GRP_DESC}</p>
					</td>
					<td class="centerall">{$ADMIN_USERS_ROW_GRP_COUNT_MEMBERS}</td>
					<td class="centerall">{$ADMIN_USERS_ROW_GRP_DISABLED}</td>
					<td class="centerall action">
						{if !$ADMIN_USERS_ROW_GRP_SKIPRIGHTS }
						<a title="{$PHP.L.Rights}" href="{$ADMIN_USERS_ROW_GRP_RIGHTS_URL}" class="button">{$PHP.L.short_rights}</a>
						{/if}
						<a title="{$PHP.L.Open}" href="{$ADMIN_USERS_ROW_GRP_JUMPTO_URL}" class="button special">{$PHP.L.short_open}</a>
					</td>
				</tr>
{/foreach}
			</table>
		</div>
		<div class="block">
			<h3>{$PHP.L.Add}:</h3>
			<form name="addlevel" id="addlevel" action="{$ADMIN_USERS_FORM_URL}" method="post" class="ajax">
			<table class="table table-striped">
				<tr>
					<td class="width40">{$PHP.L.Name}:</td>
					<td class="width60">{$ADMIN_USERS_NGRP_NAME}{$PHP.L.adm_required}</td>
				</tr>
				<tr>
					<td>{$PHP.L.Title}:</td>
					<td>{$ADMIN_USERS_NGRP_TITLE}{$PHP.L.adm_required}</td>
				</tr>
				<tr>
					<td>{$PHP.L.Description}:</td>
					<td>{$ADMIN_USERS_NGRP_DESC}</td>
				</tr>
				<tr>
					<td>{$PHP.L.Icon}:</td>
					<td>{$ADMIN_USERS_NGRP_ICON}</td>
				</tr>
				<tr>
					<td>{$PHP.L.Alias}:</td>
					<td>{$ADMIN_USERS_NGRP_ALIAS}</td>
				</tr>
				{if $PHP.pfs_is_active }
				<tr>
					<td>{$PHP.L.adm_maxsizesingle}:</td>
					<td>{$ADMIN_USERS_NGRP_PFS_MAXFILE}</td>
				</tr>
				<tr>
					<td>{$PHP.L.adm_maxsizeallpfs}:</td>
					<td>{$ADMIN_USERS_NGRP_PFS_MAXTOTAL}</td>
				</tr>
				{/if}
				<tr>
					<td>{$PHP.L.adm_copyrightsfrom}:</td>
					<td>{$ADMIN_USERS_FORM_SELECTBOX_GROUPS} {$PHP.L.adm_required}</td>
				</tr>
				<tr>
					<td>{$PHP.L.adm_skiprights}:</td>
					<td>{$ADMIN_USERS_NGRP_SKIPRIGHTS}</td>
				</tr>
				<tr>
					<td>{$PHP.L.Level}:</td>
					<td>{$ADMIN_USERS_NGRP_RLEVEL}</td>
				</tr>
				<tr>
					<td>{$PHP.L.Disabled}:</td>
					<td>{$ADMIN_USERS_NGRP_DISABLED}</td>
				</tr>
				{if $PHP.hidden_groups }
				<tr>
					<td>{$PHP.L.Hidden}:</td>
					<td>{$ADMIN_USERS_NGRP_HIDDEN}</td>
				</tr>
				{/if}
				<tr>
					<td>{$PHP.L.adm_rights_maintenance}:</td>
					<td>{$ADMIN_USERS_NGRP_MAINTENANCE}</td>
				</tr>
				<tr>
					<td class="valid" colspan="2"><input type="submit" class="submit" value="{$PHP.L.Add}" /></td>
				</tr>
			</table>
			</form>
		</div>
{/foreach}
{foreach \$1 as $row}
		<div class="block">
			<form name="editlevel" id="editlevel" action="{$ADMIN_USERS_EDITFORM_URL}" method="post" class="ajax">
				<table class="table table-striped">
					<tr>
						<td class="width40">{$PHP.L.Name}:</td>
						<td class="width60">{$ADMIN_USERS_EDITFORM_GRP_NAME} {$PHP.L.adm_required}</td>
					</tr>
					<tr>
						<td>{$PHP.L.Title}:</td>
						<td>{$ADMIN_USERS_EDITFORM_GRP_TITLE} {$PHP.L.adm_required}</td>
					</tr>
					<tr>
						<td>{$PHP.L.Description}:</td>
						<td>{$ADMIN_USERS_EDITFORM_GRP_DESC}</td>
					</tr>
					<tr>
						<td>{$PHP.L.Icon}:</td>
						<td>{$ADMIN_USERS_EDITFORM_GRP_ICON}</td>
					</tr>
					<tr>
						<td>{$PHP.L.Alias}:</td>
						<td>{$ADMIN_USERS_EDITFORM_GRP_ALIAS}</td>
					</tr>
					{if $PHP.pfs_is_active }
					<tr>
						<td>{$PHP.L.adm_maxsizesingle}:</td>
						<td>{$ADMIN_USERS_EDITFORM_GRP_PFS_MAXFILE}</td>
					</tr>
					<tr>
						<td>{$PHP.L.adm_maxsizeallpfs}:</td>
						<td>{$ADMIN_USERS_EDITFORM_GRP_PFS_MAXTOTAL}</td>
					</tr>
					{/if}
					<tr>
						<td>{$PHP.L.Disabled}:</td>
						<td>{$ADMIN_USERS_EDITFORM_GRP_DISABLED}</td>
					</tr>
					{if $PHP.hidden_groups }
					<tr>
						<td>{$PHP.L.Hidden}:</td>
						<td>{$ADMIN_USERS_EDITFORM_GRP_HIDDEN}</td>
					</tr>
					{/if}
					<tr>
						<td>{$PHP.L.Level}:</td>
						<td>{$ADMIN_USERS_EDITFORM_GRP_RLEVEL}</td>
					</tr>
					<tr>
						<td>{$PHP.L.Members}:</td>
						<td><a href="{$ADMIN_USERS_EDITFORM_GRP_MEMBERSCOUNT_URL}">{$ADMIN_USERS_EDITFORM_GRP_MEMBERSCOUNT}</a></td>
					</tr>
					<tr>
						<td>{$PHP.L.adm_rights_maintenance}:</td>
						<td>{$ADMIN_USERS_EDITFORM_GRP_MAINTENANCE}</td>
					</tr>
					<tr>
						<td>{$PHP.L.adm_skiprights}:</td>
						<td>{$ADMIN_USERS_EDITFORM_GRP_SKIPRIGHTS}</td>
					</tr>
					{if !$ADMIN_USERS_EDITFORM_SKIPRIGHTS }
					<tr>
						<td>{$PHP.L.Rights}:</td>
						<td><a href="{$ADMIN_USERS_EDITFORM_RIGHT_URL}" class="button">{$PHP.L.Rights}</a></td>
					</tr>
					{/if}
{if $PHP.g > 5 }
					<tr>
						<td>{$PHP.L.Delete}:</td>
						<td><a href="{$ADMIN_USERS_EDITFORM_DEL_URL}" class="ajax">{$PHP.R.admin_icon_delete}</a></td>
					</tr>
{/if}
					<tr>
						<td class="valid" colspan="2"><input type="submit" class="submit" value="{$PHP.L.Update}" /></td>
					</tr>
				</table>
			</form>
		</div>
{/foreach}

