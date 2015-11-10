<footer class="">
	<div class="container container-fluid">
		<hr/>
		<div class="row">
			<div class="col-md-6">
				{if $PHP.cot_modules.rss} -->
				{$PHP.R.icon_rss} <a href="{$.php.cot_url('rss')}" title="{$PHP.L.RSS_Feeds}">RSS</a>
				{/if}
				{if $PHP.cfg.forums}
				{$PHP.R.icon_rss} <a href="{$.php.cot_url('rss','m=forums')}" title="{$PHP.L.RSS_Feeds} {$PHP.cfg.separator} {$PHP.L.Forums}"> RSS (<span class="lower">{$PHP.L.Forums}</span>)</a>
				{/if}
			</div>
			<div class="col-md-6 text-right">
				<div id="powered">{$FOOTER_COPYRIGHT}</div>
			</div>
		</div>
	</div>
</footer>


{if $PHP.usr.is_admin}
	{$FOOTER_CREATIONTIME}
	{$FOOTER_SQLSTATISTICS}
	{$FOOTER_DEVMODE}	
	
{/if}


{$FOOTER_RC}
</body>
</html>