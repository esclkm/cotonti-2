
{include $PHP.cfg.themes_dir~"/admin/"~$PHP.cfg.admintheme~"/warnings.tpl"}
<div class="row text-center"> 

		<div class="">
		{foreach $ADMIN_CONFIG_MAIN as $CFG}
			<a href="{$CFG.URL}" class="ajax1 icon col-lg-2 col-md-2 col-sm-3 col-xs-4">
				{if $CFG.ICO }
				<img src="{$CFG.ICO}"/>
				{else}
				{$PHP.R.admin_icon_extension}
				{/if}
				<h5>{$CFG.NAME}</h5>
			</a>
		{/foreach}

		{foreach $ADMIN_CONFIG_EXT as $CFG}
			<a href="{$CFG.URL}" class="ajax1 icon col-lg-2 col-md-2 col-sm-3 col-xs-4">
				{if $CFG.ICO }
				<img src="{$CFG.ICO}"/>
				{else}
				{$PHP.R.admin_icon_extension}
				{/if}
				<h5>{$CFG.NAME}</h5>
			</a>
		{/foreach}
		</div>
	</div>	
</div>
